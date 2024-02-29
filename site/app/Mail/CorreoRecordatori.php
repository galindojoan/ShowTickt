<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Symfony\Component\Mime\Email;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Mailtrap\EmailHeader\CategoryHeader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class CorreoRecordatori extends Mailable
{
    use Queueable, SerializesModels;

    public $evento, $pdfContent;
    /**
     * Create a new message instance.
     */
    public function __construct($evento,$pdfContent)
    {
        $this->evento =$evento;
        $this->pdfContent =$pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Correo Entrades')
                    ->view('mails.recordatoriMail')
                    ->attachData($this->pdfContent, 'entradas.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
