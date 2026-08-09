<?php

namespace App\Console\Commands;

use App\Models\Cita;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:vencer-citas-no-confirmadas')]
#[Description('Command description')]
class vencerCitasNoConfirmadas extends Command
{
    public function handle()
    {
        $citas=Cita::where('estado', 'agendada')
        ->whereRaw("CONCAT(fecha, ' ', hora)<?", [now()])
        ->get();

        foreach($citas as $cita){
            $cita->update([
                'estado'=>'cancelada',
                'motivo_cancelacion'=>'No confirmada a tiempo por la recepcion'
            ]);
        }

    }
}
