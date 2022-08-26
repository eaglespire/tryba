<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCustomDriverMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $data;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->data['address'], $this->data['name'])
        ->markdown('emails.store.mail')
        ->subject($this->data['subject'])
        ->with([
            'content' => $this->data['message'], 
            'website' => $this->user->website->websiteName, 
            'details' => $this->user->website->meta_description, 
            'url' => route('website.link', ['id' => $this->user->website->websiteUrl]),
        ]);
    }
}
