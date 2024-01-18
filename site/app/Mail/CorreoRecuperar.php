<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Mime\Email;
use Mailtrap\EmailHeader\CategoryHeader;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorreoRecuperar extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    use Queueable, SerializesModels;

    public $urlRecuperacion, $usuario;

    public function __construct($datos)
    {
        $this->urlRecuperacion = $datos['urlGenerada'];
        $this->usuario = $datos['username'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperar Contraseña ShowTickt',
            using: [
                function (Email $email) {
                    // Headers
                    $email->getHeaders()
                        ->addTextHeader('X-Message-Source', 'example.com')
                        ->add(new UnstructuredHeader('X-Mailer', 'Mailtrap PHP Client'))
                    ;

                    // Custom Variables
                    $email->getHeaders()
                        ->add(new CustomVariableHeader('user_id', '45982'))
                        ->add(new CustomVariableHeader('batch_id', 'PSJ-12'))
                    ;

                    // Category (should be only one)
                    $email->getHeaders()
                        ->add(new CategoryHeader('Integration Test'))
                    ;
                },
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.passwordMail',
            with:([
                'url' => $this->urlRecuperacion,
                'name' => $this->usuario,
            ])
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
