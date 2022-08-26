<?php

namespace App\Jobs;

use App\Mail\SendCustomDriverMail;
use App\Models\CustomMailDriver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Swift_Mailer;
use Swift_SmtpTransport;

class SendWithCustomDomainDrivers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $config = CustomMailDriver::where('user_id',$this->user->id)->first();
        if ($config->status == 1) {
            $transport = new Swift_SmtpTransport($config->mail_host, $config->mail_port, $config->mail_encryption);
            $transport->setUsername($config->mail_username);
            $transport->setPassword($config->mail_password);
            Mail::setSwiftMailer(new Swift_Mailer($transport));
            Mail::to($this->data['email'])->send(new SendCustomDriverMail($this->user,$this->data));
        }else{
            updateEmailLimit($this->user->id);
            Mail::to($this->data['email'])->send(new SendCustomDriverMail($this->user,$this->data));
        }
    
    }
}
