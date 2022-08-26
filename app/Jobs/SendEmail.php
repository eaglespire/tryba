<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Settings;
use App\Models\User;
use App\Models\Logo;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $subject;
    public $message;
    public $to;
    public $name;
    public function __construct($to, $name, $subject, $message)
    {
        $this->subject=$subject;
        $this->message=$message;
        $this->to=$to;
        $this->name=$name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $set = Settings::first();
        if($set->email_notify==1){ 
            $mlogo = Logo::first();
            $from = env('MAIL_USERNAME');
            $site = $set->site_name;
            $phone = $set->phone;
            $details = $set->site_desc;
            $email = env('MAIL_USERNAME');
            $logo = url('/') . '/asset/' . $mlogo->image_link;
            $to=$this->to;
            $name=$this->name;
            $subject=$this->subject;
            $message=$this->message;
            $data = array('name' => $name, 'subject' => $subject, 'content' => $message, 'website' => $set->site_name, 'phone' => $phone, 'details' => $details, 'email' => $email, 'logo' => $logo);
            Mail::send(['html' => 'emails/mail'], $data, function ($message) use ($name, $to, $subject, $from, $site) {
                $message->to($to, $name);
                $message->subject($subject);
                $message->from($from, $site);
            });
        }
    }
}
