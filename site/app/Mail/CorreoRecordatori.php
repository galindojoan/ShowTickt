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

    public $user, $evento, $link;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $evento,$link)
    {
        $this->user = $user;
        $this->evento =$evento;
        $this->link =$link;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio evento',
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
            view: 'mail.recordatoriMail',
            with: ([
                'user' => $this->user,
                'evento' => $this->evento,
                'link' => $this->link,
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
