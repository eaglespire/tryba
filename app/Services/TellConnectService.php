<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Services\ModulrService;

class TellConnectService {

  protected $document;
  protected $banking;
  protected $card;
  protected $user;
  protected $transaction;
  protected $invoice;
  protected $modulrService;

  public function __construct(User $user, ModulrService $modulrService) {
    $this->modulrService = $modulrService;
    $this->clientID = \env('TC_CID');
    $this->clientSecret = \env('TC_CSEC');
    $this->TC_APIKEY = \env('TC_APIKEY');
    $this->TC_PUBKEY = \env('TC_PUBKEY');
    $this->url = \env('TC_URL');
    $this->authToken = base64_encode($this->clientID . ':' . $this->clientSecret);
    $this->mock = '{
        "ConsentId": "4f75c06c-d3bf-4141-930c-e177ec17f812",
        "Environment": "integration",
        "GatewayId": "16776e81-e523-40f7-a32b-2e2c37758ac4",
        "GatewayDomain": "your-gateway-domain",
        "TppName": "Tell Money",
        "TppWebsite": "https://tell.money/",
        "AppName": "Tell Money Demo App",
        "AppDescription": "This is a demonstration app for Open Banking, from TELL MONEY",
        "AppWebsite": "https://open-banking-app.tell.money",
        "ConsentStatus": "Authorised",
        "Scope": "accounts",
        "PaymentType": "",
        "PaymentInformation": "",
        "Permissions": "ReadAccountsBasic, ReadAccountsDetail",
        "ConsentRequestCreated": "2021-08-19 13:48:26",
        "ConsentRequestExpiry": "2021-08-19 13:49:26",
        "ConsentGranted": "null",
        "ConsentExpiry": "null",
        "ConsentRevoked": "null"
      }';

      $this->mock2 = '[
        {
          "ConsentId": "1c7b735f-eb6e-4b23-afb0-3f0a78e79f65",
          "Environment": "integration",
          "GatewayId": "16776e81-e523-40f7-a32b-2e2c37758ac4",
          "GatewayDomain": "your-gateway-domain",
          "TppName": "Tell Money",
          "TppWebsite": "https://tell.money/",
          "AppName": "Tell Money Demo App",
          "AppDescription": "This is a demonstration app for Open Banking, from TELL MONEY",
          "AppWebsite": "https://open-banking-app.tell.money",
          "ConsentStatus": "AwaitingAuthorisation",
          "Scope": "accounts",
          "PaymentType": "",
          "Permissions": [
            "ReadAccountsBasic",
            "ReadAccountsDetail",
            "ReadBalances"
          ],
          "ConsentRequestCreated": "2021-08-19 15:28:33",
          "ConsentRequestExpiry": "2021-08-19 15:29:33",
          "ConsentGranted": "2021-08-19 15:28:35",
          "ConsentExpiry": "2021-11-17 15:28:35",
          "ConsentRevoked": null
        },
        {
          "ConsentId": "8acd50f9-f474-46a0-a7f4-d35e437bd74b",
          "Environment": "production",
          "GatewayId": "16776e81-e523-40f7-a32b-2e2c37758ac4",
          "GatewayDomain": "your-gateway-domain",
          "TppName": "Tell Money",
          "TppWebsite": "https://tell.money/",
          "AppName": "Tell Money Demo App",
          "AppDescription": "This is a demonstration app for Open Banking, from TELL MONEY",
          "AppWebsite": "https://open-banking-app.tell.money",
          "ConsentStatus": "AwaitingAuthorisation",
          "Scope": "accounts",
          "PaymentType": "Domestic Standing Order",
          "Permissions": [],
          "ConsentRequestCreated": "2021-08-19 15:28:33",
          "ConsentRequestExpiry": "2021-08-19 15:29:33",
          "ConsentGranted": "2021-08-19 15:28:35",
          "ConsentExpiry": "2021-11-17 15:28:35",
          "ConsentRevoked": null
        },
        {
          "ConsentId": "4f75c06c-d3bf-4141-930c-e177ec17f812",
          "Environment": "integration",
          "GatewayId": "16776e81-e523-40f7-a32b-2e2c37758ac4",
          "GatewayDomain": "your-gateway-domain",
          "TppName": "Tell Money",
          "TppWebsite": "https://tell.money/",
          "AppName": "Tell Money Demo App",
          "AppDescription": "This is a demonstration app for Open Banking, from TELL MONEY",
          "AppWebsite": "https://open-banking-app.tell.money",
          "ConsentStatus": "AwaitingAuthorisation",
          "Scope": "accounts",
          "PaymentType": "",
          "Permissions": [
            "ReadAccountsBasic",
            "ReadAccountsDetail",
            "ReadBalances"
          ],
          "ConsentRequestCreated": "2021-08-19 13:48:26",
          "ConsentRequestExpiry": "2021-08-19 13:49:26",
          "ConsentGranted": null,
          "ConsentExpiry": null,
          "ConsentRevoked": null
        }
      ]';
  }

  /**
   * create customer
   */
  public function getCustomerConsent($request) {
      $consentId = $request->query('consent');
      
      if(isset($consentId) && !empty($consentId)){
        $query = \Http::withBasicAuth($this->clientID, $this->clientSecret)->withHeaders([
            'Authorization' => 'Basic ' .$this->authToken,
            'Accept' => '*/*',
          ])->get($this->url."consent/".$request->query('consent'));
        $response = \json_decode($query);
        if(isset($response->AppName) && !empty($response->AppName)) {
            return $response;
        }
        // \Log::info(json_encode($response));
        return json_decode($this->mock);

    } else { 
        return json_decode($this->mock);

    // return false;
        }
  }
  
  public function decideCustomerConsent($request, $consentId, $decision) {
    if(isset($decision) && $decision == 'approve'){
      $user=User::whereid(Auth::guard('tellConnect')->user()->id)->first();
    if(!$user) {
      return false;
    }
    $data['account_number'] = $user->acct_no;
    $data['consent'] = json_decode($this->mock);
      
      if(isset($consentId) && !empty($consentId)){
        $postData = [
          "ConsentId" => $consentId,
          "Outcome" => "Pass",
          "UserId" => $user->id,
          "Accounts" => array($data['account_number'])
        ];

        $query = \Http::withBasicAuth($this->clientID, $this->clientSecret)->withHeaders([
            'Authorization' => 'Basic ' .$this->authToken,
            'Accept' => '*/*',
          ])->post($this->url."consent/".$request->query('consent'), $postData);
        $response = \json_decode($query);
        if(isset($response) && !empty($response)) {
          $data['response'] = $response;
          $data['outcome'] = $postData['Outcome'];
        }
        \Log::info(json_encode($response));
        return ($data);

    } else { 
        return $data;

    // return false;
        }
      }
  }

  public function getUserApprovedConsents($uid) {
    \Log::info('A');
    if(isset($uid) && !empty($uid)){
      $query = \Http::withBasicAuth($this->clientID, $this->clientSecret)->withHeaders([
          'Authorization' => 'Basic ' .$this->authToken,
          'Accept' => '*/*',
        ])->get($this->url."users/".$uid."/consents");
      $response = \json_decode($query);
      if(isset($response->AppName) && !empty($response->AppName)) {
          // return $response;
          return json_decode($this->mock2);
        }
      return json_decode($this->mock2);

    } else { 
      return json_decode($this->mock2);

    // return false;
      }

  }

  public function revokeUserApprovedConsents($id) {
    if(isset($id) && !empty($id)){
      $query = \Http::withBasicAuth($this->clientID, $this->clientSecret)->withHeaders([
          'Authorization' => 'Basic ' .$this->authToken,
          'Accept' => '*/*',
        ])->delete($this->url."consent/".$id);
      $response = \json_decode($query);
      if(isset($response->AppName) && !empty($response->AppName)) {
          // return $response;
          return json_decode($this->mock2);
        }
      return json_decode($this->mock2);
    } else { 
        return json_decode($this->mock2);
    // return false;
        }
}

public function performTransaction($request, $user) {
  if($this->verifyTellConnectRSA($request)){
    return $this->determineTransaction($request, $user);
  } else { 
      $data['body']['error']='No request headers are present with the request';
      $data['status']=500;
      return $data;
    }
}

public function getUserAccounts($request, $user){
  $user = $user->gbpAccount();
  $accountRaw = $this->modulrService->getAccountsByCustomer($user->customerId);
  if(isset($accountRaw) && !empty($accountRaw)){
    $data['status'] = 200;
    foreach($accountRaw->content as $account){
      $accType = 'CustomCode';
      
      if($account->identifiers[0]->type == 'SCAN'){
        $accType = 'SortCodeAccountNumber';
      }

      if($accType == 'SortCodeAccountNumber' ){
        $accNo =  $account->identifiers[0]->sortCode."". $account->identifiers[0]->accountNumber;
      }
      if($accType != 'SortCodeAccountNumber' ){
        $accNo =  "IBAN: ".$account->identifiers[0]->iban." BIC :". $account->identifiers[0]->bic;
      }

      $accounts[] = array(
      "AccountId" => $account->id,
      "Currency" =>  $account->currency,
      "AccountType" => "Business",
      "AccountSubType" => "CurrentAccount",
      "Nickname" => "",
      "Identification" => $accNo,
      "SchemeName" => $accType
      );
    }

    
    $data['body']['Accounts'] = $accounts;
    return $data;
  }
}

public function getUserAccountDetails($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId'])){
    $account = $this->modulrService->getUserAccountDetails($request['Data']['AccountId']);
    if(isset($account) && !empty($account)){
      $data['status'] = 200;
        $accType = 'CustomCode';
        
        if($account->identifiers[0]->type == 'SCAN'){
          $accType = 'SortCodeAccountNumber';
        }

        if($accType == 'SortCodeAccountNumber' ){
          $accNo =  $account->identifiers[0]->sortCode."". $account->identifiers[0]->accountNumber;
        }
        if($accType != 'SortCodeAccountNumber' ){
          $accNo =  "IBAN: ".$account->identifiers[0]->iban." BIC :". $account->identifiers[0]->bic;
        }

        $accounts = array(
        "AccountId" => $account->id,
        "Currency" =>  $account->currency,
        "AccountType" => "Business",
        "AccountSubType" => "CurrentAccount",
        "Nickname" => "",
        "Identification" => $accNo,
        "SchemeName" => $accType
        );
      $data['body'] = $accounts;
      return $data;
    } 
  }else {
    $data['status'] = 400;
    $data['body'] = 'No Account ID provided with the request';
    return $data;
  }
}

public function getUserAccountBeneficiaries($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId'])){
    $beneficiaries = $this->modulrService->getUserBeneficiaries($request['Data']['AccountId']);
    if(isset($beneficiaries) && !empty($beneficiaries)){
      $data['status'] = 200;
      foreach($beneficiaries as $beneficiary){
        $trnxAccType = 'CustomCode';

        if($beneficiary['destinationIdentifier']['type'] == 'SCAN'){
          $trnxAccType = 'SortCodeAccountNumber';
        }
        if($trnxAccType == 'SortCodeAccountNumber' ){
          $accNo =  $beneficiary['destinationIdentifier']['sortCode']."". $beneficiary['destinationIdentifier']['accountNumber'];
        }
        if($trnxAccType != 'SortCodeAccountNumber' ){
          $accNo =  "IBAN: ".$beneficiary['destinationIdentifier']['iban']." BIC :". $beneficiary['destinationIdentifier']['bic'];
        }
        
        $allTrnxs[] = array(
        "BeneficiaryId" => $beneficiary['id'],
        "Name" => $beneficiary['name'],
        "Identification" => $accNo,
        "SchemeName" => $trnxAccType,
        "Reference" => $beneficiary['defaultReference'],
        );
      }
      $data['body']['Beneficiaries'] = $allTrnxs;
      return $data;
    } 
  } else {
    $data['status'] = 400;
    $data['body'] = 'No Account ID provided with the request';
    return $data;
  }

}

public function getUserAccountTransactions($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId'])){
    $transactions = $this->modulrService->getAccountTransactions($request['Data']['AccountId']);
    // \Log::info(json_encode($transactions));
    if(isset($transactions) && !empty($transactions)){
    $data['status'] = 200;
    foreach($transactions as $transaction){
      // "CardSchemeName" => "VISA",
      // "CardIdentification" => "#7692",
      // "MerchantCategoryCode" => $transaction->amount,
      // "MerchantName" => $transaction->amount,
      $trnxType = 'Debit';
      $trnxAccType = 'CustomCode';
      $trnxSubCode = 'CreditTransferDomestic';
      if($transaction->credit == true){
        $trnxType = 'Credit';
      }
      if($transaction->account->identifiers[0]->type == 'SCAN'){
        $trnxAccType = 'SortCodeAccountNumber';
      }
      if($trnxAccType == 'SortCodeAccountNumber' ){
        $accNo =  $transaction->account->identifiers[0]->sortCode."". $transaction->account->identifiers[0]->accountNumber;
      }
      if($trnxAccType != 'SortCodeAccountNumber' ){
        $accNo =  "IBAN: ".$transaction->account->identifiers[0]->iban." BIC :". $transaction->account->identifiers[0]->bic;
      }

      if($transaction->credit == true){
        $trnxType = 'Credit';
      }
      if($transaction->type == 'Card'){
        $trnxSubCode = 'Card';
      }
      if($transaction->type == 'StandingOrderCrossBorder'){
        $trnxSubCode = 'StandingOrderCrossBorder';
      }
      if($transaction->type == 'DirectDebit'){
        $trnxSubCode = 'DirectDebit';
      }
      if($transaction->type == 'CreditTransferCrossBorder'){
        $trnxSubCode = 'CreditTransferCrossBorder';
      }

      $allTrnxs[] = array(
      "TransactionId" => $transaction->id,
      "BookingDateTime" => $transaction->postedDate,
      "Amount" => $transaction->amount,
      "Currency" => $transaction->currency,
      "Status" => 'Booked',
      "CreditDebit" => $trnxType,
      "Code" => 'Transfer',
      "SubCode" => $trnxSubCode,
      "CreditorSchemeName" => $trnxAccType,
      "CreditorName" => $transaction->account->name,
      "CreditorIdentification"=> $accNo,
      "TransactionInformation" => $transaction->description
      );
    }
    $data['body']['Transactions'] = $allTrnxs;
    return $data;
  } 
  } else {
    $data['status'] = 400;
    $data['body']['Error'] = "The Account ID is missing from the request";
    return $data;
  }

}

public function getUserDirectDebits($request, $user){
 
    $data['status'] = 400;
    $data['body']['Error'] = "We don't support Direct Debits at the moment";
    return $data;

}

public function getUserStandingOrders($request, $user){
 
  $data['status'] = 400;
  $data['body']['Error'] = "We don't support Standing Orders at the moment";
  return $data;

}

public function getUserAccountBalance($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId'])){
    $account = $this->modulrService->getUserAccountDetails($request['Data']['AccountId']);
    if(isset($account) && !empty($account)){
      $data['status'] = 200;
        $accBalType = 'Credit';
        
        if((int)$account->balance < 0){
          $accBalType = 'Debit';
        }
        $accounts = array(
        "Amount" => $account->balance,
        "Currency" =>  $account->currency,
        "CreditDebit" => $accBalType
        );
      $data['body'] = $accounts;
      return $data;
    } 
  }else {
    $data['status'] = 400;
    $data['body']['Error']  = 'No Account ID provided with the request';
    return $data;
  }
}

public function getUserScheduledPayments($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId'])){
    $transactions = $this->modulrService->getAccountTransactions($request['Data']['AccountId']);
    // \Log::info(json_encode($transactions));
    $data['status'] = 200;
    $allTrnxs = [];
    if(isset($transactions) && !empty($transactions)){
      foreach($transactions as $transaction){
        // "CardSchemeName" => "VISA",
        // "CardIdentification" => "#7692",
        // "MerchantCategoryCode" => $transaction->amount,
        // "MerchantName" => $transaction->amount,
        if(isset($transaction->paymentDate)){
          $trnxType = 'Debit';
          $trnxAccType = 'CustomCode';
          $trnxSubCode = 'CreditTransferDomestic';
          if($transaction->credit == true){
            $trnxType = 'Credit';
          }
          if($transaction->account->identifiers[0]->type == 'SCAN'){
            $trnxAccType = 'SortCodeAccountNumber';
          }
          if($trnxAccType == 'SortCodeAccountNumber' ){
            $accNo =  $transaction->account->identifiers[0]->sortCode."". $transaction->account->identifiers[0]->accountNumber;
          }
          if($trnxAccType != 'SortCodeAccountNumber' ){
            $accNo =  "IBAN: ".$transaction->account->identifiers[0]->iban." BIC :". $transaction->account->identifiers[0]->bic;
          }

          if($transaction->credit == true){
            $trnxType = 'Credit';
          }
          if($transaction->type == 'Card'){
            $trnxSubCode = 'Card';
          }
          if($transaction->type == 'StandingOrderCrossBorder'){
            $trnxSubCode = 'StandingOrderCrossBorder';
          }
          if($transaction->type == 'DirectDebit'){
            $trnxSubCode = 'DirectDebit';
          }
          if($transaction->type == 'CreditTransferCrossBorder'){
            $trnxSubCode = 'CreditTransferCrossBorder';
          }

          $allTrnxs[] = array(
          "ScheduledPaymentId" => $transaction->id,
          "ScheduledPaymentDateTime" => $transaction->postedDate,
          "SchemeName" => $trnxAccType,
          "Identification"=> $accNo,
          "Amount" => $transaction->amount,
          "Currency" => $transaction->currency,
          "Name" => $transaction->account->name,
          );
        } 
      }
    } 
    $data['body']['ScheduledPayments'] = $allTrnxs;
    return $data;
  } else {
    $data['status'] = 400;
    $data['body']['Error'] = "The Account ID is missing from the request";
    return $data;
  }

}

public function getPaymentFundsConfirmation($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId']) && isset($request['Data']['AccountId'])){
    $account = $this->modulrService->getUserAccountDetails($request['Data']['AccountId']);
    if(isset($account) && !empty($account)){
      $data['status'] = 200;
        $accBal = 'FALSE';
        
        if($account->balance >= $request['Data']['Amount']){
          $accBal = 'TRUE';
        }
        $accounts = array(        
          "FundsAvailable" => $accBal
        );
      $data['body'] = $accounts;
      return $data;
    } 
  }else {
    $data['status'] = 400;
    $data['body']['Error']  = 'The request is missing information required to complete this operation';
    return $data;
  }
}


public function makeAPayment($request, $user){
  if($request->has('Data') && isset($request['Data']['AccountId']) && isset($request['Data']['PaymentType']) && isset($request['Data']['BeneficiaryIdentification']) && isset($request['Data']['Amount']) && isset($request['Data']['Currency']) && isset($request['Data']['BeneficiaryName'])){
    if($request['Data']['PaymentType'] != 'Domestic'){
      $data['status'] = 400;
      $data['body']['Error']  = 'We only support Domestic transactions at the moment';     
      return $data;
    }
    $ref = \bin2hex(\random_bytes(6));
    $postPayment = $this->modulrService->tellConnectPostPayment($request, $ref);
      if(isset($postPayment) && !empty($postPayment)){
        if(isset($postPayment['error']) && !empty($postPayment['error'])){
          $data['status'] = 400;
          $data['body']['Error']  = $postPayment['msg'];
          return $data;

        }
        $this->transaction->create([
            'user_id'      => $request['Info']['UserId'],
            'reference'    => $ref,
            'currency'     => 19,
            'receiver_id'  => $request['Info']['UserId'],
            'amount'       => $request['Data']['Amount'],
            'type'         => 9,
            'ref_id'       => $postPayment->externalReference,
            'trans_status' => $postPayment->status,
        ]);
     
        $data['status'] = 200;
        $data['body']['PaymentReference'] = $postPayment->externalReference;
        return $data;
      } 
  } else {
    $data['status'] = 400;
    $data['body']['Error']  = 'The request is missing information required to complete this operation';
    return $data;
  }
}

public function getUserPaymentStatus($request){
  if($request->has('Data') && isset($request['Data']['PaymentReference'])){
    $account = $this->modulrService->getPaymentDetails($request['Data']['PaymentReference']);
    if(isset($account) && !empty($account)){
      $data['status'] = 200;;
      $data['body']['PaymentReference'] = $account;
      return $data;
    } 
  }else {
    $data['status'] = 400;
    $data['body']['Error']  = 'The request is missing information required to complete this operation';
    return $data;
  }
}

public function determineTransaction($request, $user){
  $typeOfTrnx = $request->Info['Operation'];
  if($typeOfTrnx == 'GET /accounts'){
    return $this->getUserAccounts($request, $user);
  }

  if($typeOfTrnx == 'GET /account'){
    return $this->getUserAccountDetails($request, $user);
  }

  if($typeOfTrnx == 'GET /balance'){
    return $this->getUserAccountBalance($request, $user);
  }

  if($typeOfTrnx == 'GET /beneficiaries'){
    return $this->getUserAccountBeneficiaries($request, $user);
  }

  if($typeOfTrnx == 'GET /direct-debits'){
    return $this->getUserDirectDebits($request, $user);
  }

  if($typeOfTrnx == 'GET /scheduled-payments'){
    return $this->getUserScheduledPayments($request, $user);
  }

  if($typeOfTrnx == 'GET /standing-orders'){
    return $this->getUserStandingOrders($request, $user);
  }

  if($typeOfTrnx == 'GET /transactions'){
    return $this->getUserAccountTransactions($request, $user);
  }

  if($typeOfTrnx == 'GET /payment-funds-confirmation'){
    return $this->getPaymentFundsConfirmation($request, $user);
  }

  if($typeOfTrnx == 'POST /payment'){
    return $this->makeAPayment($request, $user);
  }

  if($typeOfTrnx == 'GET /payment'){
    return $this->getUserPaymentStatus($request);
  }

  if($typeOfTrnx == 'GET /funds-confirmation"'){
    return $this->confirmUserHasFunds($request, $user);
  }



}

public function verifyTellConnectRSA($request){
  $reqApiKey = $request->header('x-api-key');
  $reqSignature = $request->header('x-jws-signature');

  if(isset($reqApiKey) == $this->TC_APIKEY){
    // $rsa = new RSA();
    // $rsa->loadKey(base64_decode(env($this->TC_PUBKEY)));
    // $data = $signature;
    // $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);
    // $signature = $rsa->sign($data);
    // $signature = base64_encode($signature);
    // $rsa->loadKey(base64_decode(env('RSA_PUBLIC_KEY'))); // public key
        // return $rsa->verify($data, base64_decode($signature)) ? 'verified' : 'unverified';
    return true;

  }
  return false;

}

}
