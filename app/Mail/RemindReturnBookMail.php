<?php

namespace App\Mail;

use App\Models\Lending;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
//use App\Http\Controllers\RemindReturnBookController;

class RemindReturnBookMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $lending;
    public function __construct(Lending $lending)
    {
        $this->lending = $lending;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */

    public function envelope()
    {
        return new Envelope(
            subject: '返却期限が近づいています',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content()
    {
        return new Content(
            html: 'emails.remind_return_book',
            text: 'emails.remind_return_book-text',
            with: [
                'name' => $this->lending,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
