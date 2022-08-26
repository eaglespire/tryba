<?php 

namespace App\Services;

class PlaidService {

  public function __construct() 
  {
    $this->url = "https://api.plaid.com";
    $this->clientID = env("PLAID_CLIENT_ID");
    $this->client_secret = env("PLAID_CLIENT_SECRET");
  }
  // Create payment recepient
  public function createPaymentRecipient($bank, $user) 
  {
    $data = [
      "client_id" => $this->clientID,
      "secret" => $this->client_secret,
      "name" => $user->name,
      "iban" => $bank->acc_no,
      "address" => [
        "street" => $street,
        "city" => $city,
        "post_code" => $postcode,
        "country" => $country
      ],
    ];
    $response = \Http::withHeaders([
      "Content-Type" => "application/json",
    ])->post($this->url."/payment_initiation/recipient/create", $data);
    if(isset($response["recipient_id"]) && !empty($response["recipient_id"])) {
      return $response["recipient_id"];
    }
    return false;
  }
  // Get payment recepient
  public function getPaymentRecipient($bank, $user) 
  {
    $data = [
      "client_id" => $this->clientID,
      "secret" => $this->client_secret,
      "recepient_id" => $this->createPaymentRecipient($bank, $user),
    ];
    $response = \Http::withHeaders([
      "Content-Type" => "application/json",
    ])->post($this->url."/payment_initiation/recipient/get", $data);
    if(isset($response["recipient_id"]) && !empty($response["recipient_id"])) {
      return $response;
    }
    return false;
  }
  // List payment recepients
  public function listPaymentRecipients() 
  {
    $data = [
      "client_id" => $this->clientID,
      "secret" => $this->client_secret,
    ];
    $response = \Http::withHeaders([
      "Content-Type" => "application/json",
    ])->post($this->url."/payment_initiation/recipient/list", $data);
    if(isset($response["recipients"]) && !empty($response["recipients"])) {
      return $response;
    }
    return false;
  }
  // Initiate Payment
  public function initiatePayment($request) 
  {
    $data = [
      "client_id" => $this->clientID,
      "secret" => $this->client_secret,
      "recipient_id" => $request->recipient_id,
      "reference" => \bin2hex(\random_bytes(9)),
      "amount" => [
        "currency"=> $request->rex->name,
        "value"=> number_format($request->amount, 2, ".", ""),
      ],
    ];
    $response = \Http::withHeaders([
      "Content-Type" => "application/json",
    ])->post($this->url."/payment_initiation/payment/create", $data);
    if(isset($response["payment_id"]) && !empty($response["payment_id"])) {
      return $response;
    }
    return false;
  }
  // Get Payment Status (verification to ascertain the current state)
  public function getPaymentDetails($payment_id) 
  {
    $data = [
      "client_id" => $this->clientID,
      "secret" => $this->client_secret,
      "payment_id" => $payment_id,
    ];
    $response = \Http::withHeaders([
      "Content-Type" => "application/json",
    ])->post($this->url."/payment_initiation/payment/get", $data);
    if(isset($response["payment_id"]) && !empty($response["payment_id"])) {
      if($response["status"] === "PAYMENT_STATUS_INPUT_NEEDED") {
        return "Transaction is awating users' input";
      }
      elseif($response["status"] === "PAYMENT_STATUS_PROCESSING") {
        return "Payment is processing";
      }
      elseif($response["status"] === "PAYMENT_STATUS_INITIATED" || $response["status"] === "PAYMENT_STATUS_COMPLETED") {
        return "Payment is completed successfuly";
      }
      elseif($response["status"] === "PAYMENT_STATUS_INSUFFICIENT_FUNDS") {
        return "Insufficient fund";
      }
      elseif($response["status"] === "PAYMENT_STATUS_FAILED") {
        return "Payment failed";
      }
      elseif($response["status"] === "PAYMENT_STATUS_BLOCKED") {
        return "Payment blocked";
      }
      return $response;
    }
    return false;
  }
  // List payments
  public function listAllPayments() 
  {
    $data = [
      "client_id" => $this->clientID,
      "secret" => $this->client_secret,
    ];
    $response = \Http::withHeaders([
      "Content-Type" => "application/json",
    ])->post($this->url."/payment_initiation/recipient/list", $data);
    if(isset($response["payments"]) && !empty($response["payments"])) {
      return $response;
    }
    return false;
  }  
}