<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplianceVerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $decision;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$decision)
    {
        $this->user = $user;
        $this->decision = $decision;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Compliance verification '.$this->decision)->markdown('mails.compliance-verification');
    }
}
