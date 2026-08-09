<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class ValidarHoraVeterinaria implements ValidationRule
{
    public function __construct(
        protected int $horaApertura = 7,
        protected int $horaCierre = 22
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $hora = (int) Carbon::parse($value)->format('H');

        if ($hora < $this->horaApertura || $hora >= $this->horaCierre) {
            $fail("Las citas solo se pueden agendar entre las {$this->horaApertura}:00 y las {$this->horaCierre}:00 horas.");
        }
    }
}