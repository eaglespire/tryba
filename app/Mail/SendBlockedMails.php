<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendBlockedMails extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subjectText;
    public $slug;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$slug)
    {
        $this->user = $user;
        $this->slug = $slug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject("We’re closing your account")->markdown('mails.account-blocked');
    }
}
