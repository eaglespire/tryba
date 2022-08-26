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

class StorefrontEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sbj;
    public $msg;
    public $store;
    public function __construct($sbj, $msg, $store)
    {
        $this->subject = $sbj;
        $this->message = $msg;
        $this->store = $store;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->store->mail == 1) {
            $transport = new Swift_SmtpTransport($this->store->mail_host, $this->store->mail_port, $this->store->mail_encryption);
            $transport->setUsername($this->store->mail_username);
            $transport->setPassword($this->store->mail_password);
            Mail::setSwiftMailer(new Swift_Mailer($transport));
            $data=[
                'from_address'=>$this->store->mail_from_address,
                'from_name'=>$this->store->mail_from_name,
                'subject'=>$this->subject
            ];
            return $this->from($data['from_address'], $data['from_name'])
            ->markdown('emails.store.mail')
            ->subject($data['subject'])
            ->with([
                'content' => $this->message, 
                'website' => $this->store->store_name, 
                'details' => $this->store->store_desc, 
                'url' => route('website.link', ['id' => $this->store->store_url]),
            ]);
        }else{
            updateEmailLimit($this->store->user_id);
            $data=[
                'subject'=>$this->subject
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
}
