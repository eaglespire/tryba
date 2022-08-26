<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $recipients;
    public $message;

    public function __construct($recipients, $message)
    {
        $this->recipients = $recipients;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        try {
            $client->messages->create($this->recipients, ['from' => env('TWILIO_NUMBER'), 'body' => $this->message]);
        } catch (TwilioException $e) {
            return back()->with('alert', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('alert', $e->getMessage());
        }
    }
}
