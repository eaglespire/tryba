<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $activate;
    public $request;
    public $slug;
    public $suspense;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$activate,$request,$slug,$suspense)
    {
        $this->user = $user;
        $this->activate = $activate;
        $this->suspense = $suspense;
        $this->subjectText = ($suspense) ? 'Your account has been suspended' : ' We require more information';
        $this->request = $request;
        $this->slug = $slug;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->suspense){
            return $this->subject($this->subjectText)->markdown('mails.account-suspend');
        }else{
            return $this->subject($this->subjectText)->markdown('mails.account-notSuspended');
        }
        
    }
}
