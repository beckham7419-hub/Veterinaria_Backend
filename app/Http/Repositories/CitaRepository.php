<?php

namespace App\Http\Repositories;

use App\Models\Cita;
use App\Models\Mascota;
use Carbon\Carbon;

class CitaRepository
{
    /**
     * Marca como 'vencida' cualquier cita 'agendada' cuya fecha y hora ya pasaron
     * sin haber sido confirmada. Se ejecuta antes de listar o de operar sobre una cita.
     */
    public function expirarAgendadasVencidas(): int
    {
        return Cita::where('estado', 'agendada')
            ->where(function ($query) {
                $query->whereDate('fecha', '<', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('fecha', now()->toDateString())
                            ->where('hora', '<', now()->format('H:i:s'));
                    });
            })
            ->update(['estado' => 'vencida']);
    }

    /**
     * Si la cita individual sigue 'agendada' pero ya paso su fecha y hora, la marca
     * como 'vencida' y detiene la accion en curso con un mensaje explicativo.
     */
    private function expirarSiVencida(Cita $cita): void
    {
        if ($cita->estado !== 'agendada') {
            return;
        }

        $fechaHoraCita = Carbon::parse($cita->fecha->format('Y-m-d').' '.$cita->hora);

        if ($fechaHoraCita->isFuture()) {
            return;
        }

        $cita->estado = 'vencida';
        $cita->save();

        throw new \Exception('Esta cita ya caduco: paso su fecha y hora programada sin haber sido confirmada.');
    }

    public function obtenerCitas(?string $estado = null, $mascotaId = null, $veterinarioId = null, ?string $fechaInicio = null, ?string $fechaFin = null)
    {
        try {
            $this->expirarAgendadasVencidas();

            $query = Cita::with(['mascota', 'veterinario']);

            if ($estado) {
                $query->where('estado', $estado);
            }

            if ($mascotaId) {
                $query->where('mascota_id', $mascotaId);
            }

            if ($veterinarioId) {
                $query->where('veterinario_id', $veterinarioId);
            }

            if ($fechaInicio) {
                $query->whereDate('fecha', '>=', $fechaInicio);
            }

            if ($fechaFin) {
                $query->whereDate('fecha', '<=', $fechaFin);
            }

            $citas = $query->orderBy('fecha')->orderBy('hora')->get();

            return [
                'mensaje' => 'Citas obtenidas',
                'data' => $citas,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener las citas: '.$e->getMessage(), 0, $e);
        }
    }

    public function agendarCita(array $data)
    {
        $existeVeterinario = Cita::where('veterinario_id', $data['veterinario_id'])
            ->where('fecha', $data['fecha'])
            ->where('hora', $data['hora'])
            ->where('estado', '!=', 'cancelada')
            ->exists();

        if ($existeVeterinario) {
            throw new \Exception('El veterinario ya tiene una cita agendada en ese horario.');
        }

        $existeMascota = Cita::where('mascota_id', $data['mascota_id'])
            ->where('fecha', $data['fecha'])
            ->where('estado', '!=', 'cancelada')
            ->exists();

        if ($existeMascota) {
            throw new \Exception('Esta mascota ya tiene una cita activa programada para este dia.');
        }

        try {
            $mascota = Mascota::findOrFail($data['mascota_id']);

            $cita = new Cita($data);
            $cita->dueno_id = $mascota->dueno_id;
            $cita->numero_folio = 'TEMP-'.uniqid();
            $cita->save();

            $cita->numero_folio = 'FOLIO-'.str_pad($cita->id, 5, '0', STR_PAD_LEFT);
            $cita->save();

            return [
                'mensaje' => 'Cita agendada',
                'cita' => $cita,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo agendar la cita: '.$e->getMessage(), 0, $e);
        }
    }

    public function actualizarCita(Cita $cita, array $data)
    {
        $this->expirarSiVencida($cita);

        if (isset($data['fecha']) || isset($data['hora']) || isset($data['veterinario_id'])) {
            $veterinarioId = $data['veterinario_id'] ?? $cita->veterinario_id;
            $fecha = $data['fecha'] ?? $cita->fecha->format('Y-m-d');
            $hora = $data['hora'] ?? $cita->hora;

            $existeVeterinario = Cita::where('veterinario_id', $veterinarioId)
                ->where('fecha', $fecha)
                ->where('hora', $hora)
                ->where('estado', '!=', 'cancelada')
                ->where('id', '!=', $cita->id)
                ->exists();

            if ($existeVeterinario) {
                throw new \Exception('El veterinario ya tiene una cita agendada en ese horario.');
            }
        }

        try {
            $cita->update($data);

            return [
                'mensaje' => 'Cita actualizada',
                'cita' => $cita,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo actualizar la cita: '.$e->getMessage(), 0, $e);
        }
    }

    public function cancelarCita(Cita $cita, string $motivo, int $usuarioId)
    {
        $this->expirarSiVencida($cita);

        if ($cita->estado === 'cancelada') {
            throw new \Exception('Esta cita ya esta cancelada.');
        }

        if ($cita->estado === 'completada') {
            throw new \Exception('No se puede cancelar una cita ya completada.');
        }

        try {
            $cita->estado = 'cancelada';
            $cita->motivo_cancelacion = $motivo;
            $cita->cancelado_por_usuario_id = $usuarioId;
            $cita->fecha_cancelacion = now();
            $cita->save();

            return ['mensaje' => 'Cita cancelada', 'cita' => $cita];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo cancelar la cita: '.$e->getMessage(), 0, $e);
        }
    }

    public function confirmarCita(Cita $cita)
    {
        $this->expirarSiVencida($cita);

        if ($cita->estado !== 'agendada') {
            throw new \Exception('Solo se pueden confirmar citas en estado agendada.');
        }

        try {
            $cita->estado = 'confirmada';
            $cita->save();

            return ['mensaje' => 'Cita confirmada', 'cita' => $cita];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo confirmar la cita: '.$e->getMessage(), 0, $e);
        }
    }

    public function iniciarConsulta(Cita $cita)
    {
        $this->expirarSiVencida($cita);

        if (! \in_array($cita->estado, ['agendada', 'confirmada'])) {
            throw new \Exception('Solo se puede iniciar la consulta de una cita agendada o confirmada.');
        }

        if (! $cita->hora_llegada) {
            throw new \Exception('No se puede iniciar la consulta sin haber registrado el check-in de la mascota.');
        }

        try {
            $cita->estado = 'en_consulta';
            $cita->save();

            return ['mensaje' => 'Consulta iniciada', 'cita' => $cita];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo iniciar la consulta: '.$e->getMessage(), 0, $e);
        }
    }

    public function completarCita(Cita $cita)
    {
        if ($cita->estado !== 'en_consulta') {
            throw new \Exception('Solo se puede completar una cita que esta en consulta.');
        }

        try {
            $cita->estado = 'completada';
            $cita->save();

            return ['mensaje' => 'Cita completada', 'cita' => $cita];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo completar la cita: '.$e->getMessage(), 0, $e);
        }
    }

    public function registrarLlegada(Cita $cita)
    {
        $this->expirarSiVencida($cita);

        if ($cita->estado === 'cancelada') {
            throw new \Exception('No se puede registrar la llegada de una cita cancelada.');
        }

        if ($cita->estado === 'completada') {
            throw new \Exception('No se puede registrar la llegada de una cita ya completada.');
        }

        if ($cita->hora_llegada) {
            throw new \Exception('Ya se registro la llegada de esta cita.');
        }

        if (! $cita->fecha->isToday()) {
            throw new \Exception('Solo se puede registrar la llegada el dia de la consulta.');
        }

        try {
            $cita->hora_llegada = now();
            $cita->save();

            return ['mensaje' => 'Llegada registrada', 'cita' => $cita];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo registrar la llegada: '.$e->getMessage(), 0, $e);
        }
    }

    public function obtenerCitasDeDueno(int $duenoId)
    {
        try {
            $this->expirarAgendadasVencidas();

            $citas = Cita::where('dueno_id', $duenoId)
                ->whereIn('estado', ['agendada', 'confirmada', 'cancelada'])
                ->orderBy('fecha')->orderBy('hora')
                ->get();

            return ['mensaje' => 'Citas obtenidas', 'data' => $citas];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener las citas: '.$e->getMessage(), 0, $e);
        }
    }

    public function cancelarCitaDueno(Cita $cita, int $duenoId)
    {
        if ((int) $cita->dueno_id !== (int) $duenoId) {
            throw new \Exception('No tienes permiso para cancelar esta cita.');
        }

        $this->expirarSiVencida($cita);

        if ($cita->estado === 'cancelada') {
            throw new \Exception('Esta cita ya esta cancelada.');
        }

        if ($cita->estado === 'completada') {
            throw new \Exception('No se puede cancelar una cita ya completada.');
        }

        $fechaHoraCita = Carbon::parse($cita->fecha->format('Y-m-d').' '.$cita->hora);
        $horasRestantes = ($fechaHoraCita->timestamp - now()->timestamp) / 3600;

        if ($horasRestantes < 2) {
            throw new \Exception('Solo puedes cancelar con al menos 2 horas de anticipacion.');
        }

        try {
            $cita->estado = 'cancelada';
            $cita->cancelado_por_dueno_id = $duenoId;
            $cita->fecha_cancelacion = now();
            $cita->save();

            return ['mensaje' => 'Cita cancelada', 'cita' => $cita];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo cancelar la cita: '.$e->getMessage(), 0, $e);
        }
    }

    public function obtenerHorariosOcupados(int $veterinarioId, string $fecha)
    {
        try {
            $ocupados = Cita::where('veterinario_id', $veterinarioId)
                ->where('fecha', $fecha)
                ->where('estado', '!=', 'cancelada')
                ->pluck('hora');

            return ['mensaje' => 'Horarios ocupados obtenidos', 'data' => $ocupados];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener los horarios: '.$e->getMessage(), 0, $e);
        }
    }
}
