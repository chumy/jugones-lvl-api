<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Partida;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PartidaParticipante extends Mailable
{
    use Queueable, SerializesModels;

    public $partida;
    public $organizador;
    public $participant;
    /**
     * Create a new message instance.
     */
    public function __construct($part, $participante)
    {
        $this->partida = Partida::where('partidaId', $part)->with('joc','organitzador', 'participants', 'participants.participant')->get()[0];
        $this->organizador = User::where('uid', $this->partida->organitzador)->get()[0];
        $this->participant = User::where('uid', $participante)->get()[0];
        //Log::info(print_r($this->partida, true));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Molins De Joc: Nou participant a '.$this->partida->joc['name'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.nuevoParticipante',
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
