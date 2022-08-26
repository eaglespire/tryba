<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\ComplianceDocument;
use App\Models\BankingDetail;
use App\Models\BankingBeneficiary;
use App\Models\Card;
use App\Models\User;
use App\Models\Transactions;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use App\Events\ComplianceVerification;

class ModulrServiceAuth {

  protected $document;
  protected $banking;
  protected $card;
  protected $user;
  protected $transaction;
  protected $invoice;

  public function __construct() {
    $this->productCode = 'O1200001';
    $this->apiKey = \env('MODULR_API_KEY');
    $this->apiSecret = \env('MODULR_API_SECRET');
    $this->url = \env('MODULR_URL');
    $this->signature = \env('MODULR_HMAC');
    $this->yapilyUrl = config('settings.YAPILY.URL');
    $this->yapilyKey = config('settings.YAPILY.KEY');
    $this->yapilySecret = config('settings.YAPILY.SECRET');
    $this->authToken = base64_encode($this->yapilyKey . ':' . $this->yapilySecret);
    $this->sumsuburl = env('SUMSUB_URL');
    $this->secret = env('SUMSUB_SECRET');
    $this->sumsubToken = env('SUMSUB_TOKEN');
    date_default_timezone_set("Europe/London");

  }

      /**
     * Get applicant data
    */
    public function getHeaders()
    {
        return $headers =  \Http::get('http://auth.tryba.io')->json();
    }

    /**
     * Sandbox header
     */
    public function sandboxHeaders() {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => $this->apiKey,
            'Accept' => 'application/json',
        ];
    }




}
