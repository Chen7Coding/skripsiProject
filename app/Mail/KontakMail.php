<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KontakMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan dari Kontak Kami: ' . $this->data['topic'],
            from: $this->data['email']
        );
    }

    public function content(): Content
    {
        return new Content(
           view: 'emails.kontak',
        with: [
            'nama' => $this->data['name'],
            'email' => $this->data['email'],
            'telepon' => $this->data['phone'],
            'topik' => $this->data['topic'],
            'deskripsi' => $this->data['message'],
        ]
        );
    }
}