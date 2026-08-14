<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarContrasenaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enlace;

    public function __construct(string $enlace)
    {
        $this->enlace = $enlace;
    }

    public function build()
    {
        return $this->subject("Recuperacion de contrasena - Veterinaria")
            ->view("emails.recuperar_contrasena");
    }
}
