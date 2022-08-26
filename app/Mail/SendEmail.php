<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Settings;
use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sbj;
    public $msg;
    public function __construct($sbj, $msg)
    {
        $this->subject = $sbj;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $transport = new Swift_SmtpTransport('tryba.io', 465, 'ssl');
        $transport->setUsername('no-reply@tryba.io');
        $transport->setPassword('.&!QVSoQgvy!');
        Mail::setSwiftMailer(new Swift_Mailer($transport));
        $data = [
            'subject' => $this->subject,
            'message' => $this->msg
        ];
        return $this->markdown('emails.markdown.mail')
            ->subject($data['subject'])
            ->with([
                'content' => $data['message'],
                'website' => Settings::first()->site_name,
                'details' => Settings::first()->site_desc,
                'url' => route('home'),
            ]);
    }
}
