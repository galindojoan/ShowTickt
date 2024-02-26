<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Mail\Mailable;
use Symfony\Component\Mime\Email;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Mailtrap\EmailHeader\CategoryHeader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class CorreoEntrades extends Mailable
{
    use Queueable, SerializesModels;

    public $evento, $sessio, $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct($evento, $sessio, $pdfContent)
    {
        $this->evento = $evento;
        $this->sessio = $sessio;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Correo Entrades')
                    ->view('mails.entradesMail')
                    ->attachData($this->pdfContent, 'entradas.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

}
