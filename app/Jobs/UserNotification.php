<?php

namespace App\Jobs;

use App\Mail\UserNotification as MailUserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $activate;
    protected $request;
    protected $slug;
    protected $suspense;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$activate,$request,$slug,$suspense)
    {
        $this->user = $user;
        $this->activate = $activate;
        $this->request = $request;
        $this->slug = $slug;
        $this->suspense = $suspense;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new MailUserNotification($this->user, $this->activate,$this->request,$this->slug , $this->suspense));
    }
}
