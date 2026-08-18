<?php

namespace App\Console\Commands;

use App\Http\Repositories\CitaRepository;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:vencer-citas-no-confirmadas')]
#[Description('Marca como vencida cualquier cita agendada cuya fecha y hora ya paso sin confirmarse')]
class vencerCitasNoConfirmadas extends Command
{
    public function handle(CitaRepository $citaRepository)
    {
        $total = $citaRepository->expirarAgendadasVencidas();

        $this->info("Citas marcadas como vencidas: {$total}");
    }
}