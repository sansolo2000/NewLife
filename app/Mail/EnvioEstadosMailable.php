<?php

namespace App\Mail;

use App\Mensaje;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioEstadosMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $titulo;
    public $subject;
    public $cuerpo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $titulo = $this->titulo;

        $cuerpo = $this->cuerpo;
        
        return $this->view('Mail.mail')
                ->with(compact('titulo'))
                ->with(compact('cuerpo'));
    }
}
