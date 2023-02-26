<?php

namespace App\Mail;

use App\Models\Lending;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class RemindReturnBookMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lending;

    public function __construct(Lending $lending)
    {
        $this->lending = $lending;
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.remind_return_book',
        );
    }
}
