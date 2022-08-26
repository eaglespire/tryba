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

class approvedCompliance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to = User::whereid($this->id)->first();
        $set = Settings::first();
        $mlogo = Logo::first();
        $from = env('MAIL_USERNAME');
        $receiver_email = $to->email;
        $receiver_name = $to->first_name;
        $site = $set->site_name;
        $logo = url('/') . '/asset/' . $mlogo->image_link;
        $data = array(
            'website' => $set->site_name,
            'receiver_email' => $receiver_email,
            'logo' => $logo,
            'receiver_name' => $receiver_name,
        );
        Mail::send(['html' => 'emails/compliance/approved'], $data, function ($s_message) use ($receiver_email, $from, $site) {
            $s_message->to($receiver_email)->subject('Compliance Approved')->from($from, $site);
        });
    }
}
