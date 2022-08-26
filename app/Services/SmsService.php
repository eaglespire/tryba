<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SmsService {

  public  function __construct() {
    $this->client = new Client( env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
  }

  public function fire($phoneNumber, $message) {
    try {
        $this->client->messages->create($phoneNumber, ['from' => env('TWILIO_NUMBER'), 'body' => $message]);
    } catch (TwilioException $e) {
        Log::info($e->getMessage());
    } catch (Exception $e) {
        Log::info($e->getMessage());
    }
  }
}
