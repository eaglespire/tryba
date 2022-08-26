<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ComplianceVerificationMail;
use Illuminate\Support\Facades\Mail;
class ComplianceVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $decision;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $decision)
    {
        $this->user = $user;
        $this->decision = $decision;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new ComplianceVerificationMail($this->user, $this->decision));
    }
}
