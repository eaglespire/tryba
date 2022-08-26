<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Settings;
use App\Models\Logo;
use App\Models\User;


class StoreEmail implements ShouldQueue
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
    public $store;
    public function __construct($to, $name, $subject, $message, $store)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->to = $to;
        $this->name = $name;
        $this->store = $store;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->store->mail == 1) {
            config()->set(
                [
                    'mail.mailers.transport' => $this->store->mail_driver,
                    'mail.mailers.host' => $this->store->mail_host,
                    'mail.mailers.port' => $this->store->mail_port,
                    'mail.mailers.encryption' => $this->store->mail_encryption,
                    'mail.mailers.username' => $this->store->mail_username,
                    'mail.mailers.password' => $this->store->mail_password,
                ]
            );
            $from = $this->store->mail_from_address;
            $site = $this->store->mail_from_name;
            $details = $this->store->store_desc;
            $website = $this->store->store_name;
            if ($this->store->checkout_logo == null) {
                $logo = url('/') . '/asset/' . Logo::first()->image_link2;
            } else {
                $logo = url('/') . '/asset/profile/' . $this->store->image;
            }
            $name = $this->name;
            $to = $this->to;
            $message = $this->message;
            $subject = $this->subject;
            $data = array('name' => $name, 'subject' => $subject, 'content' => $message, 'website' => $website, 'details' => $details, 'logo' => $logo);
            Mail::send(
                ['html' => 'emails/store/mail'],
                $data,
                function ($message) use ($name, $to, $subject, $from, $site) {
                    $message->to($to, $name);
                    $message->subject($subject);
                    $message->from($from, $site);
                }
            );
        } else {
            $from = $this->store->mail_from_address;
            $site = Settings::first()->site_name;
            $details = Settings::first()->site_desc;
            $website = Settings::first()->site_name;
            $logo = url('/') . '/asset/' . Logo::first()->image_link2;
            $name = $this->name;
            $to = $this->to;
            $message = $this->message;
            $subject = $this->subject;
            $data = array('name' => $name, 'subject' => $subject, 'content' => $message, 'website' => $website, 'details' => $details, 'logo' => $logo);
            Mail::send(
                ['html' => 'emails/store/mail'],
                $data,
                function ($message) use ($name, $to, $subject, $from, $site) {
                    $message->to($to, $name);
                    $message->subject($subject);
                    $message->from($from, $site);
                }
            );
        }
    }
}
