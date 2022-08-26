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

class StoreEmail extends Mailable
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
        $this->message = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'subject' => $this->subject
        ];
        return $this->markdown('emails.store.mail')
            ->subject($data['subject'])
            ->with([
                'content' => $this->message,
                'website' => Settings::first()->site_name,
                'details' => Settings::first()->site_desc,
                'url' => route('website.link', ['id' => $this->store->store_url]),
            ]);
    }
}
