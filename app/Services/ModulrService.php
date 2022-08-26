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
use App\Services\NotificationService;
use App\Services\ModulrServiceAuth;

class ModulrService {

  protected $document;
  protected $banking;
  protected $card;
  protected $user;
  protected $transaction;
  protected $invoice;
  protected $notification;

  public function __construct(ModulrServiceAuth $authService, NotificationService $notification, Invoice $invoice, Transactions $transaction, ComplianceDocument $document, BankingDetail $banking, Card $card, User $user) {
    $this->document = $document;
    $this->invoice = $invoice;
    $this->banking = $banking;
    $this->transaction = $transaction;
    $this->user = $user;
    $this->card = $card;
    $this->notification = $notification;
    $this->authService = $authService;
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
    public function getApplicantData($applicantId)
    {
        //return $this->modulr->getApplicantData($applicantId);
        $ts = time();
        $url = '/resources/applicants/'.$applicantId.'/one';
        $signature = hash_hmac('sha256', $ts.'GET'.$url, $this->secret);
        $query = \Http::withHeaders([
            'X-App-Token' => $this->sumsubToken,
            'X-App-Access-Sig' => $signature,
            'X-App-Access-Ts' => $ts,
            'Content-Type' => 'application/json'
        ])->get($this->sumsuburl.$url);
          $data = json_decode($query);
        $complianceData = [];
        if($data->type === 'company') {
            $complianceData["externalReference"] = $data->externalUserId;
            $complianceData['type'] = 'LLC'; //$data->type;
            $complianceData['name'] = $data->info->companyInfo->companyName;
            $complianceData['companyRegNumber'] = $data->info->companyInfo->registrationNumber;
            // $complianceData['country'] = 'GB'; //$data->info->companyInfo->country;
            // $complianceData['phone'] = $data->phone;
            // $complianceData['email'] = $data->email;
            $complianceData['legalEntity'] = 'GB';
            $complianceData['tcsVersion'] = 1;
            $complianceData['tradingAddress'] = [
                "addressLine1" => $data->info->companyInfo->legalAddress,
                "addressLine2" => $data->info->companyInfo->legalAddress,
                "country" => 'GB', //$data->info->companyInfo->country,
                "postCode" => $data->info->companyInfo->postalAddress,
                "postTown" => $data->info->companyInfo->address->town,
            ];
            $complianceData['registeredAddress'] = [
                "addressLine1" => $data->info->companyInfo->legalAddress,
                "addressLine2" => $data->info->companyInfo->legalAddress,
                "country" => 'GB', //$data->info->companyInfo->country,
                "postCode" => $data->info->companyInfo->postalAddress,
                "postTown" => $data->info->companyInfo->address->town,
            ];
            if(count($data->info->companyInfo->beneficiaries) > 0) {
                $benf = [];
                foreach($data->info->companyInfo->beneficiaries as $key => $beneficiary) {
                    $partner = $this->getApplicantData($beneficiary->applicantId);
                    if($beneficiary->type === 'ubo' ) {
                        $partner['ownership'] = $beneficiary->shareSize ?? 30;
                    }
                    $partner['applicant'] = $beneficiary->type === 'representative' ? true : false;
                    $partner['type'] = $beneficiary->type === 'representative' ? 'DIRECTOR' : 'BENE_OWNER';
                    $benf[$key] = $partner;
                }
                $complianceData['associates'] = $benf;
                return $complianceData;
           }
        }
        if(isset($data->memberOf)) {
            $address = json_decode(json_encode($data->fixedInfo->addresses));
            return [
                "applicant" => $data->type === 'representative' ? true : false,
                "type" => $data->type === 'representative' ? 'DIRECTOR' : 'BENE_OWNER',
                "firstName" => $data->fixedInfo->firstName,
                // "middleName" => $data->fixedInfo->middleName ?? NULL,
                "lastName" => $data->fixedInfo->lastName,
                "dateOfBirth" => $data->fixedInfo->dob,
                "email" => $data->fixedInfo->email ?? NULL,
                "phone" => $data->fixedInfo->phone ?? NULL,
                "homeAddress" => [
                  "country"   => "GB",
                  "postCode" => $address[0]->postCode,
                  "postTown" => $address[0]->town,
                  "addressLine1" => $address[0]->street.' '.$address[0]->town.' '.$address[0]->postCode,
                  "addressLine2" => $address[0]->addressLine2 ?? NULL,
                ]
            ];
        }
        $address = json_decode(json_encode($data->info->addresses));
        return [
            "externalReference" => $data->externalUserId,
            "type" => "SOLETRADER",
            "name" => $data->info->firstName." ".$data->info->lastName,
            "associates" => [
                "applicant" => true,
                "type" => "SOLETRADER",
                "firstName" => $data->info->firstName,
                "middleName" => $data->info->middleName ?? NULL,
                "lastName" => $data->info->lastName,
                "dateOfBirth" => $data->info->dob,
                "email" => $data->info->email ?? NULL,
                "phone" => $data->info->phone ?? NULL,
                "homeAddress" => [
                    "country" => "GB",
                    "postCode" => $address[0]->postCode,
                    "postTown" => $address[0]->town,
                    "addressLine1" => $address[0]->formattedAddress,
                    "addressLine2" => $address[0]->addressLine2 ?? NULL,
                ]
            ],
            "tradingAddress" => [
              "country" => "GB",
              "postCode" => $address[0]->postCode,
              "postTown" => $address[0]->town,
              "addressLine1" => $address[0]->formattedAddress,
              "addressLine2" => $address[0]->addressLine2 ?? NULL,
            ],
            "legalEntity" => "GB",
            "tcsVersion" => 1,
        ];
    }

//   /**
//    * create customer
//    */
//   public function createCustomer($applicantId, $user, $documentInfo) {
//     $payload = $this->getApplicantData($applicantId);
//     $payload["industryCode"] = $user->industry_code;
//     $payload["expectedMonthlySpend"] = $user->turnover;
//     $payload['documentInfo'] =  [
//         [
//             "path" => $documentInfo["path"],
//             "fileName" => $documentInfo["fileName"],
//             "uploadedDate" => date('Y-m-d\TH:i:sO', strtotime(Carbon::today())),
//         ]
//     ];
//     \LoG::info("################# PAYLOAD #######################");
//     \Log::info($payload);
//     \LoG::info("################# PAYLOAD #######################");

//     $query = \Http::withHeaders([
//       'Accept' => 'application/json',
//       'Content-Type' => 'application/json',
//       'Authorization' => $this->apiKey,
//     ])->post($this->url."/customers", $payload);
//     $response = \json_decode($query);
//     \LoG::info("################# ACCOUNT #######################");
//         \Log::info($query);
//     \LoG::info("################# ACCOUNT #######################");
//     if(isset($response->id) && !empty($response->id)) {
//       $this->createEuroAccount($response->id, $user->id);
//       return $this->createAccount($response->id, $user->id);
//     }
//     return $query;
//     \Log::info("Customer created");
//   }

  /**
   * Create customer
   */
  public function createCustomer($user, $documentInfo = null) {
    //   $user = $this->user->find($request->user_id);
    $request = json_decode($user->account_data);
    \Log::info("Account data");
    \Log::info((array) $request);
    \Log::info("Account data");
    if($user->business_type === 'INDIVIDUAL') {
        $payload = [
            "type" => "INDIVIDUAL",
            "name" => $user->first_name.' '.$user->last_name,
            "legalEntity" => 'GB',
            "expectedMonthlySpend" => $user->turnover,
            "tcsVersion" => 1,
            "associates" => [
                [
                    "applicant" => true,
                    "type" => 'INDIVIDUAL',
                    "firstName" => $user->first_name,
                    "lastName" => $user->last_name,
                    "dateOfBirth" => $user->dob,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "homeAddress" => [
                      "addressLine1" => $user->address_line1,
                      "addressLine2" => $user->address_line2,
                      "country" => $user->getCountry()->iso,
                      "postCode" => $user->postal_code,
                      "postTown" => $user->post_town,
                    ],
                ]
            ],
            "documentInfo" => [
                [
                    "path" => $documentInfo["path"],
                    "fileName" => $documentInfo["fileName"],
                    "uploadedDate" => date('Y-m-d\TH:i:sO', strtotime(Carbon::today())),
                ]
            ]
        ];
    }
    else if($user->business_type === 'SOLETRADER') {
        $payload = [
            "associates" => [
                [
                    "applicant" => true,
                    "type" => 'SOLETRADER',
                    "firstName" => $user->first_name,
                    "lastName" => $user->last_name,
                    "dateOfBirth" => $user->dob,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "homeAddress" => [
                      "addressLine1" => $user->address_line1,
                      "addressLine2" => $user->address_line2,
                      "country" => $user->getCountry()->iso,
                      "postCode" => $user->postal_code,
                      "postTown" => $user->post_town,
                    ],
                ]
            ],
            "tradingAddress" => [
              "addressLine1" => $user->address_line1,
              "addressLine2" => $user->address_line2,
              "country" => $user->getCountry()->iso,
              "postCode" => $user->postal_code,
              "postTown" => $user->post_town,
            ],
            "type" => $user->business_type,
            "name" => $user->business_name,
            "industryCode" => $user->industry_code,
            "legalEntity" => 'GB',
            "expectedMonthlySpend" => $user->turnover,
            "tcsVersion" => 1,
            "documentInfo" => [
                [
                  "path" => $documentInfo["path"],
                  "fileName" => $documentInfo["fileName"],
                  "uploadedDate" => date('Y-m-d\TH:i:sO', strtotime(Carbon::today())),
                ]
            ]
        ];
    }
    else {
        $associates = [];
        if($user->business_type === "LLC" && count($request->associates) > 1) {
            foreach($request->associates as $key => $associate) {
                $arr = [
                    "applicant" => $key == 0 ? true : false,
                    "type" => $key == 0 ? 'DIRECTOR' : 'BENE_OWNER',
                    "firstName" => $associate->firstName,
                    "lastName" => $associate->lastName,
                    "dateOfBirth" => $request->dob_.$key,
                    "email" => $key == 0 ? $user->email : $request->email_.$key,
                    "phone" => $request->phoneNumber_.$key,
                    "homeAddress" => [
                        "addressLine1" => $request->address_line1_.$key,
                        "addressLine2" => $request->address_line2_.$key,
                        "country"      => $request->country_.$key,
                        "postCode"     => $request->postcode_.$key,
                        "postTown"     => $request->city_.$key,
                    ]
                    // "homeAddress" => [
                    //   "addressLine1" => $user->address_line1,
                    //   "addressLine2" => $user->address_line2,
                    //   "country" => $user->getCountry()->iso,
                    //   "postCode" => $user->postal_code,
                    //   "postTown" => $user->post_town,
                    // ],
                ];
                if($key != 0) {
                    $arr['ownership'] = $request->ownership_.$key;
                    // $arr['homeAddress'] = [
                    //     "addressLine1" => $user->address_line1,
                    //     "addressLine2" => $user->address_line2,
                    //     "country" => $user->getCountry()->iso,
                    //     "postCode" => $user->postal_code,
                    //     "postTown" => $user->post_town,
                    // ];
                }
                // else {
                //     $arr['homeAddress'] = [
                //         "addressLine1" => $request->address_line1_.$key,
                //         "addressLine2" => $request->address_line2_.$key,
                //         "country"      => $request->getCountry()->iso,
                //         "postCode"     => $request->postal_code_.$key,
                //         "postTown"     => $request->post_town_.$key,
                //     ];

                // }
                $associates[$key] = $arr;
            }
        }
        else {
            $associates = [
                [
                    "applicant" => true,
                    "type" => 'DIRECTOR',
                    "firstName" => $request->associates[0]->firstName,
                    "lastName" => $request->associates[0]->lastName,
                    "dateOfBirth" => $request->dob_0,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "homeAddress" => [
                        "addressLine1" => $request->address_line1_0,
                        "addressLine2" => $request->address_line2_0,
                        "country" => $user->getCountry()->iso,
                        "postCode" => $request->postcode_0,
                        "postTown" => $request->city_0,
                    ],
                ],
                [
                    "applicant" => false,
                    "type" => 'BENE_OWNER',
                    "firstName" => $request->associates[0]->firstName,
                    "lastName" => $request->associates[0]->lastName,
                    "dateOfBirth" => $request->dob_0,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "ownership" => $request->ownership,
                    "homeAddress" => [
                        "addressLine1" => $request->address_line1_0,
                        "addressLine2" => $request->address_line2_0,
                        "country" => $user->getCountry()->iso,
                        "postCode" => $request->postcode_0,
                        "postTown" => $request->city_0,
                    ],
                ],
            ];
        }
        $payload = [
          "tradingAddress" => [
            "country"   => "GB",
            "postCode" => $request->tradingAddress->postCode,
            "postTown" => $request->tradingAddress->postTown,
            "addressLine1" => $request->associates[0]->homeAddress->addressLine1,
            "addressLine2" => null,
          ],
          "registeredAddress" => [
            "country"   => "GB",
            "postCode" => $request->registeredAddress->postCode,
            "postTown" => $request->registeredAddress->postTown,
            "addressLine1" => $request->associates[0]->homeAddress->addressLine1,
            "addressLine2" => null,
          ],
          "associates" => $associates,
          "externalReference" => $user->id,
          "type" => $user->business_type,
          "companyRegNumber" => $request->business_name,
          "name" => $user->business_type === 'SOLETRADER' ? $user->first_name.' '.$user->last_name : $request->name,
          "industryCode" => $user->industry_code,
          "legalEntity" => 'GB',
          "expectedMonthlySpend" => $user->turnover,
          "tcsVersion" => 1,
          "documentInfo" => [
            [
            "path" => $documentInfo["path"],
            "fileName" => $documentInfo["fileName"],
            "uploadedDate" => date('Y-m-d\TH:i:sO', strtotime(Carbon::today())),
            ]
          ]
        ];
    }
    \LoG::info("################# PAYLOAD #######################");
    \Log::info($payload);
    \LoG::info("################# PAYLOAD #######################");

    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/customers", $payload);
    $response = \json_decode($query);
    \LoG::info("################# ACCOUNT #######################");
        \Log::info($query);
    \LoG::info("################# ACCOUNT #######################");
    if(isset($response->id) && !empty($response->id)) {
      $this->notification->add($response->id, 'PAYIN');
      $this->createEuroAccount($response->id, $user->id);
      return $this->createAccount($response->id, $user->id);
    }
    return $query;
    \Log::info("Customer created");
  }

  /**
   * Get customer
   */
  public function getCustomer($cid) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/customers/$cid");
    $response = \json_decode($query);
    if(isset($response->associates) && !empty($response->associates)) {
      return $response->associates;
    }
    return false;
  }


    /**
   * Get customers
   */
  public function getCustomers() {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/customers");
    \Log::info("######### ACCOUNTS #######");
    \Log::info($query);
    \Log::info("######### ACCOUNTS #######");
    $response = \json_decode($query);
    if(isset($response->associates) && !empty($response->associates)) {
      return $response->associates;
    }
    return false;
  }

  /**
   * Create Card
   */
  public function createCard($request) {
    if(strtolower($request->card_type) !== 'virtual') {
      return $this->createPhysicalCard($request);
    }

    $date =  Carbon::now()->addYears(3);
    $expiryDate = $date->format('Y').'-'.$date->format('m');
    $user = $this->user->find($request->user_id);
     $payload = [
        "authentication" => [
            "knowledgeBase" => [["type" => $request->kba_question,'answer' => $request->kba_answer]]
        ],
      "expiry" => $expiryDate,
      "externalRef" => \bin2hex(\random_bytes(8)),
      "limit" => 5000,
      "productCode" => "O120001M",
      "holder" => [
        "firstName" => $user->first_name,
        "lastName" => $user->last_name,
        "dateOfBirth" => $user->dob,
        "email" => $user->email,
        "mobileNumber" => $user->phone
      ]
    ];
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/accounts/".$request->accountId."/cards", $payload);
    \Log::info($query);
    $response = \json_decode($query);
    if(isset($query["id"]) && isset($query["pan"])) {
      $fetchCard = $this->getCard($query["id"]);
      $card = $this->card->where('user_id', $request->user_id)->where('c_status', 'BLOCKED')->where('type', 'virtual')->first();
      if($card) {
        $card->delete();
      }
      if($fetchCard) {
          return $this->card->create([
            "user_id"    => $request->user_id,
            "account_id" => $request->accountId,
            "c_id"    => $query["id"],
            "pan"   => $fetchCard->maskedPan,
            "reference"   => $query["externalRef"],
            "c_status"   => $fetchCard->status,
            "type"       => 'virtual'
          ]);
      }
      return $this->card->create([
        "user_id"    => $request->user_id,
        "account_id" => $request->accountId,
        "c_id"    => $query["id"],
        "pan"   => $query["pan"],
        "reference"   => $query["externalRef"],
        "c_status"   => "ACTIVE",
        "type"       => "virtual"
      ]);
    }
    return false;
  }

  /**
   * Create Physical Card
   */
  public function createPhysicalCard($request) {
    $user = $this->user->find($request->user_id);
    if(!$user) {
      return false;
    }
    $date =  Carbon::now()->addYears(3);
    $expiryDate = $date->format('Y').'-'.$date->format('m');
    $data = [
        'authentication' => [
            'knowledgeBase' => [
                [
                    'type' => $request->kba_question,
                    'answer' => $request->kba_answer,
                ]
            ]
        ],
      'expiry' => $expiryDate, //$request->expiry, //e.g 2024-12
      'externalRef' => \bin2hex(\random_bytes(8)),
      'limit' => 5000,
      'productCode' => 'O120001R',
      'printedName' => $user->last_name.' '.$user->first_name,
      'design' => [
        'cardRef' => 'TrybaCARD',
        'packagingRef' => 'TrybaPACKAGING'
      ],
      'holder' => [
        'firstName' => $user->first_name,
        'lastName' => $user->last_name,
        'dateOfBirth' => $user->dob,
        'email' => $user->email,
        'mobileNumber' => $user->phone,
        'billingAddress' => [
          'addressLine1' => $user->address_line1,
          'country' => $user->getCountry()->iso,
          'postCode' => $user->postal_code,
          'postTown' => $user->post_town,
        ]
      ],
      'constraints' => [
        'authorization' => [
          'spend' => [
            [
              'currency' => 'GBP',
              'max' => 3000,
              'min' => 5
            ]
          ]
        ]
      ]
    ];
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/accounts/".$request->accountId."/physical-cards", $data);
    $response = \json_decode($query);
    \Log::info($query);
    if(isset($query["taskId"])) {
        $card = $this->card->where('user_id', $request->user_id)->where('c_status', 'BLOCKED')->where('type', 'physical')->first();
        if($card) {
            $card->delete();
        }
        $save = $this->card->create([
            "user_id"    => $request->user_id,
            "account_id" => $request->accountId,
            "task_id"    => $query["taskId"],
            "task_url"   => $query["taskUrl"],
            "c_status"   => "SUBMITTED",
            "type"       => "physical",
            "mtg_token"  => $query["metaData"]["managementToken"]
        ]);
        $this->getTasks($query["taskId"]);
        return $save;
    }
    return false;
  }

  /**
   * Get task
   */
  private function getTasks($taskId) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/card-tasks/$taskId");
    $response = \json_decode($query);
    \Log::info($query);
    if(isset($query['resourceId']) && $query['status'] === 'COMPLETE' && $query['type'] === 'PHYSICAL_CARD_CREATE') {
        $cardData = $this->getCard($query['resourceId']);
        if(isset($cardData->maskedPan)) {
            $card = $this->card->where('task_id', $taskId)->first();
            $card->update([
                'c_id' => $cardData->id,
                'pan' => $cardData->maskedPan,
                'expiry' => $cardData->expiry,
                'reference' => $cardData->externalRef,
                'c_status' => $cardData->status,
            ]);
        }
    }
    // return false;
  }

  /**
   * Get physical Card create task
   */
  public function getCardTasks($accountId) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/accounts/$accountId/physical-card-request-tasks");
    $response = \json_decode($query);
    \Log::info($query);
    if($query['id']) {
      return $response;
    }
    return false;
  }

  /**
   * Get Card
   */
  public function getCard($card_id) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/cards/$card_id");
    $response = \json_decode($query);
    if($query['id']) {
      return $response;
    }
    return false;
  }

  /**
   * Get Account Cards
   */
  public function getAccountCards($card_id) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/accounts/$card_id/cards");
    $response = \json_decode($query);
    \Log::info((array) $query);
    // if($query['id']) {
    //   return $response;
    // }
    return false;
  }

  /**
   * Block/Unblock card
   */
  public function blockOrUnblockCard($card_id, $action) {
    $type = strtolower($action);
    if($action === 'freeze' || $action === 'unfreeze') {
        $this->suspendCard($card_id, $type);
    }
    elseif($action === 'unblock') {
        $type = 'unblock';
    }
    else {
        $type = 'block';
    }

    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/cards/$card_id/".$type);
    $response = \json_decode($query);
    \Log::info($query);
    if($query->status()) {
        switch ($action) {
            case 'freeze':
                $status =  'SUSPENDED';
                break;
            case 'unfreeze':
                $status =  'ACTIVE';
                break;
            case 'block':
                $status =  'BLOCKED';
                break;
            default:
                $status = 'BLOCKED';
                break;
        }
        $this->card->whereCId($card_id)->first()->update(['c_status' => $status]);
      return true;
    }
    return false;
  }

  /**
   * Suspend card
   */
  public function suspendCard($card_id, $action) {
    $type = strtolower($action);
    if($action === 'freeze') {
        $type = 'suspend';
    }
    elseif($action === 'unfreeze') {
        $type = 'unsuspend';
    }
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/cards/$card_id/".$type);
    $response = \json_decode($query);
    \Log::info($query);
    if($query->status()) {
        switch ($action) {
            case 'freeze':
                $status =  'SUSPENDED';
                break;
            case 'unfreeze':
                $status =  'ACTIVE';
                break;
            case 'block':
                $status =  'BLOCKED';
                break;
            default:
                $status = 'SUSPEND';
                break;
        }
        $this->card->whereCId($card_id)->first()->update(['c_status' => $status]);
      return true;
    }
    return false;
  }

  /**
   * Activate physical Card
  */
  public function activateCard($card_id) {
    $card = $this->card->where('c_id', $card_id)->first();
    if(empty($card->mtg_token)) {
      return false;
    }
    $query = \Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => $this->apiKey,
      'Accept' => 'application/json',
      'X-MOD-CARD-MGMT-TOKEN' => $card->mtg_token,
    ])->get($this->url."/cards/$card_id/activate");
    $response = \json_decode($query);
    \Log::info($query);
    \Log::info($query->status());
    if($query->status() == 204|| $query->status() == 201 || $query->status() == 200) {
      return true;
    }
    return false;
  }

  /**
   * Retrieve Card PIN
  */
  public function retrievePin($card_id) {
    $card = $this->card->where('c_id', $card_id)->first();
    if(empty($card->mtg_token)) {
      return false;
    }
    $query = \Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => $this->apiKey,
      'Accept' => 'application/json',
      'X-MOD-CARD-MGMT-TOKEN' => $card->mtg_token,
    ])->get($this->url."/cards/$card_id/pin");
    $response = \json_decode($query);
    if(isset($query["pin"])) {
      return $response;
    }
    return false;
  }

  /**
   * Create secure card details token
  */
  public function createSecureCardDetailsToken($card_id) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/cards/$card_id/secure-details-token");
    $response = \json_decode($query);
    if($query->status() == 200 || $query->status() == 201) {
      return $response;
    }
    return false;
  }

  /**
   * Get secure card details token
  */
  public function getSecureCardDetailsToken($card_id) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/cards/$card_id/secure-details-token");
    $response = \json_decode($query);
    if($query->status() == 204 || $query->status() == 201) {
      return $response;
    }
    return false;
  }

  /**
   * Get physical card request details
  */
  public function getPhysicalCardRequestDetails($account_id) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/accounts/$account_id/physical-card-request-tasks");
    $response = \json_decode($query);
    if($query->status() == 204 || $query->status() == 201) {
      return $response;
    }
    return false;
  }

  /**
   * Create Account
  */
  public function createAccount($cid, $id) {
    $account = $this->banking->find($id);
    $data = [
      'currency' => 'GBP',
      'productCode' => 'O210000D', //$this->productCode,
      'externalRef' => \bin2hex(\random_bytes(8)),
    ];
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/customers/$cid/accounts", $data);
    $response = \json_decode($query);
    \Log::info($query);
    if(isset($response->id) && isset($response->identifiers)) {
        $acc = $this->banking->create([
          'user_id' => $id,
          'customerId' => $cid,
          'accountId' => $response->id,
          'balance' => $response->balance,
          'currency' => $response->currency,
          'accountNumber' => $query["identifiers"][0]["accountNumber"],
          'sortCode' => $query["identifiers"][0]["sortCode"],
          'status' => true,
        ]);
        $user = $this->user->find($acc->user->id);
        $user->update(['kyc_verif_status' => 'APPROVED']);
        \event(new ComplianceVerification($user, 'Approved'));
        return $response;
    }
    return false;
  }

  /**
   * Create EUR Account
  */
  public function createEuroAccount($cid, $id) {
    $data = [
      'currency' => 'EUR',
      'productCode' => 'O230000H', //$this->productCode,
      'externalRef' => \bin2hex(\random_bytes(8)),
    ];
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/customers/$cid/accounts", $data);
    $response = \json_decode($query);
    \Log::info($query);
    if(isset($response->id) && isset($response->identifiers)) {
        $this->banking->create([
          'user_id' => $id,
          'customerId' => $cid,
          'accountId' => $response->id,
          'balance' => $response->balance,
          'currency' => $response->currency,
          'iban' => $query["identifiers"][0]["iban"],
          'bic' => $query["identifiers"][0]["bic"],
          'status' => true,
        ]);
        return $response;
    }
    return false;
  }

  /**
   * Get local Account
  */
  public function getAccounts($uid) {
    return $this->banking->whereUserId($uid)->get();
  }

  /**
   * Get Account
  */
    public function getAccount($uid) {
        $account = $this->banking->whereUserId($uid)->whereCurrency('GBP')->first();
        if(!$account) {
        return false;
        }
        if(!$account->accountId) {
        return false;
        }
        $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/accounts/$account->accountId");
        $response = \json_decode($query);
            if(isset($response->id) && isset($response->identifiers)) {
                if($account) {
                $account->update([
                    'balance' => $response->availableBalance,
                    // 'accountNumber' => $query["identifiers"][0]["accountNumber"],
                    // 'sortCode' => $query["identifiers"][0]["sortCode"],
                    // 'iban' => $query["identifiers"][0]["iban"] ?? NULL,
                    // 'bic' => $query["identifiers"][0]["bic"] ?? NULL,
                    // 'status' => true,
                ]);
                $this->getAccountsByCustomer($account->customerId);
                return $account;
                }
                return false;
            }
    }


  /**
   * Get Accounts by Customer
  */
  public function getAccountsByCustomer($cid) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/customers/$cid/accounts?statuses=ACTIVE&searchCriteria=BLOCKED&searchCriteria=CLOSED&searchCriteria=CLIENT_BLOCKED&showAvailableBalance=true");
    $response = \json_decode($query);
    if($query->status() == 200) {
        if(isset($query['content'])) {
            $user_id = $this->banking->where('customerId', $cid)->first()->user_id;
            foreach ($query['content'] as $key => $account) {
               $local_account = $this->banking->where('customerId', $cid)->where('accountId', $account['id'])->first();
               if($local_account) {
                   $local_account->update([
                       'balance' => $account['availableBalance']
                   ]);
               }
               else {
                   if($account['currency'] === 'GBP') {
                    $this->banking->create([
                        'user_id' => $user_id,
                        'customerId' => $cid,
                        'accountId' => $account['id'],
                        'balance' => $account['availableBalance'],
                        'currency' => $account['currency'],
                        'accountNumber' => $account["identifiers"][0]["accountNumber"],
                        'sortCode' => $account["identifiers"][0]["sortCode"],
                        'status' => true,
                    ]);
                   }
                   elseif($account['currency'] === 'EUR') {
                    $this->banking->create([
                        'user_id' => $user_id,
                        'customerId' => $cid,
                        'accountId' => $account['id'],
                        'balance' => $account['availableBalance'],
                        'currency' => $account['currency'],
                        'iban' => $account["identifiers"][0]["iban"],
                        'bic' => $account["identifiers"][0]["bic"],
                        'status' => true,
                    ]);
                   }
               }
            }
        }
      return $response;
    }
    return false;
  }

  /**
   * Create Payment
   */
  public function createPayment($request) {
      Log::info($request->all());
    $payload = [
        'amount' => $request->amount,
        'currency' => $request->has('currency') ? $request->currency : 'GBP',
        'sourceAccountId' => $request->sourceAccountId,
        'productCode' => $this->productCode, // $request->productCode,
        'externalReference' => \bin2hex(\random_bytes(8)),
        'reference' => \bin2hex(\random_bytes(6)),
        'destination' => [
          'accountNumber' => $request->payeeAccountNumber,
          'sortCode' => $request->payeeSortCode,
          'id' => $request->beneficiaryId,
          'type' => 'SCAN',
          'name' => $request->payeeName,
        ],
        'address' => [
          'addressLine1' => $request->address,
          'addressLine2' => $request->address,
          'country' => $request->country,
          'postCode' => $request->postCode,
          'postTown' => $request->postTown,
        ],
    ];
    if($request->payment_type === 'standing_order') {
        //   \Log::info("Scheduler");
        //   \Log::info($request->all());
       $payload = [
            'amount' => $request->amount,
            'currency' => $request->has('currency') ? $request->currency : 'GBP',
            'sourceAccountId' => $request->sourceAccountId,
            'productCode' => $this->productCode, // $request->productCode,
            'externalReference' => \bin2hex(\random_bytes(8)),
            'reference' => \bin2hex(\random_bytes(6)),
            'paymentDate' => $request->payment_date,
            'destination' => [
              'accountNumber' => $request->payeeAccountNumber,
            //   'sortCode' => $request->payeeSortCode,
              'id' => $request->beneficiaryId,
              'type' => 'BENEFICIARY',
              'name' => $request->payeeName,
            ],
            'address' => [
              'addressLine1' => $request->address,
              'addressLine2' => $request->address,
              'country' => $request->country,
              'postCode' => $request->postCode,
              'postTown' => $request->postTown,
            ],
        ];
    }

    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/payments", $payload);
    $response = \json_decode($query);
    \Log::info($query);
    if($query->status() == 201) {
      return $response;
    }
    elseif(isset($response->message)) {
        return "error";
    }
    return false;
  }

  /**
   * Submit document
   */
  public function sendComplianceDocument($uid, $payload) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/documents", $payload);
    \Log::info($query);
    $response = \json_decode($query);
    if(isset($response->path) && isset($response->fileName)) {
    //   $this->document->create([
    //     'user_id' => $uid,
    //     'file_name' => $response->fileName,
    //     'file_path' => $response->path,
    //   ]);
      $user = $this->user->find($uid);
      return $this->createCustomer($user, $query);
      return $response;
    }
    return false;
  }

  /**
   * Get KYC documents
   */
  public function getKycDocuments($uid, $imageId, $fileName) {
    $user = User::find($uid);
    if($user) {
      $request = \Http::withHeaders($this->authService->sandboxHeaders())->get('https://api.sumsub.com'.$url);
       $data = [
          'content' => base64_encode($request),
          'fileName' => $fileName,
          'group'    => $user->business_type === 'SOLETRADER' ? $user->first_name.' '.$user->last_name : $user->user->companyName
       ];
       $response = $this->sendComplianceDocument($user->id, $data);
       \Log::info("DOCUMENT SENT TO MODULR");
    }
  }

  /**
   * create customer
   */
  public function createBeneficiary($request) {
    $payload = [
      "destinationIdentifier" => [
        "accountNumber" => $request->accountNumber,
        "currency" => 'GBP',
        "type" => 'SCAN',
        "sortCode" => $request->sortCode,
      ],
      "name" => $request->beneficiaryName,
      "defaultReference" => \bin2hex(\random_bytes(6)),
      'externalReference' => \bin2hex(\random_bytes(8)),
    ];
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/customers/$request->cid/beneficiaries", $payload);
    $response = \json_decode($query);
    \Log::info($query);
    if(isset($query["id"]) && !empty($query["id"])) {
      BankingBeneficiary::create([
        'user_id' => $request->uid,
        'bid' => $query['id'],
        'cid' => $query['customerId'],
        'name' => $query['name'],
        'accountId' => $query['accountId'] ?? NULL,
        'accountNumber' => $query['destinationIdentifier']['accountNumber'],
        'sortCode' => $query['destinationIdentifier']['sortCode'],
        'currency' => $query['destinationIdentifier']['currency'],
        'status' => true,
      ]);
      return  $query;
    }
    return $query[0]["message"];
  }

  /**
   * Get benficiaries
  */
  public function getBeneficiaries($cid, $uid) {
    //   $this->createEuroAccount($cid, $uid);
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/beneficiaries/?customerId=$cid");
      $response = \json_decode($query);
      if(isset($query["content"])) {
        foreach($query["content"] as $key => $content) {
          BankingBeneficiary::create([
            'user_id' => $uid,
            'bid' => $content['id'],
            'cid' => $content['customerId'],
            'name' => $content['name'],
            'accountId' => $content['accountId'] ?? NULL,
            'accountNumber' => $content['destinationIdentifier']['accountNumber'],
            'sortCode' => $content['destinationIdentifier']['sortCode'],
            'currency' => $content['destinationIdentifier']['currency'],
            'status' => true,
          ]);
        }
        return $query["content"];
      }
      return false;
  }

  /**
   * Get list of access groups
  */
  public function payeeVerification($request) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/account-name-check", [
      'name' => $request->name,
      'accountType' => strtoupper($request->accountType),
      'accountNumber' => $request->accountNumber,
      'sortCode' => $request->sortCode,
      'paymentAccountId' => $request->paymentAccountId,
    ]);
    \Log::info($query);
      $response = \json_decode($query);
      if(isset($query["result"])) {
        return $query["result"];
      }
      return false;
  }

  /**
   * Get open banking institutions
   */
  public function getInstitutions($request) {
      $user = auth()->guard('user')->user();
    if(empty($user->account)) {
        return back()->with('toast_error', "You currently don't have a bank account on Tryba. Create on to use this service");
    }
    $query = \Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => 'Basic '.$this->authToken
    ])->get($this->yapilyUrl.'/institutions');
    if(isset($query['data'])) {
      $data['authtoken'] = $this->authToken;
      $data['institution'] = $query['data'];
      $data['title'] = 'Select Preferred Bank';
      $data['type'] = 3;
      $data['reference'] = bin2hex(\random_bytes(6));
      $data['userId'] = $request->user_id;
      $data['amount'] = $request->amount;
      return view('user.dashboard.open-banking', $data);//->withData($data);
    }
    return false;
  }

  /**
   * Get standing order institutions
   */
  public function getAccountServicingPaymentProviders() {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url.'/aspsps');
    $response = json_decode($query, true);
    \Log::info($query);
    if($query->status() == 200) {
      $data = [];
      foreach ($query as $key => $institution) {
        foreach($institution["capabilities"] as $capability) {
            if($capability["type"] === "STANDING_ORDER") {
                $data[] = $institution;
            }
        }
      }
        return $data;
    }
    return false;
  }

  /**
   * Standing Order
  */
  public function initiateStandingoRDER($accountId) {
      $payload = [
        'aspspId'  => '',
        ''
      ];
    $query = \Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => $this->apiKey,
      'Accept' => 'application/json',
    ])->post($this->url."/standing-order-initiations", $payload);
    $response = \json_decode($query);
    if(isset($query["pin"])) {
      return $response;
    }
    return false;
  }

  /**
   * Webhook
   */
  public function webhook($request) {
    if($request->EventName === 'CARDCREATION' && $request->Result === 'CREATED') {
        $card = $this->card->where('task_id', $request->TaskId)->first();
        $card->update([
            'masked_pan' => $request->MaskedPAN,
            'pan' => $request->MaskedPAN,
            'c_id' => $request->CardId,
            'c_status' => 'ACTIVE',
        ]);
    }
    // if($request->Type === 'PI_FAST' || $request->Type === 'INT_INTC') {

    // }
  }


  // FOR TELL CONNECT


  public function getAccountTransactions($accountId) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/accounts/$accountId/transactions");
      $response = \json_decode($query);
      if(isset($response->content) && !empty($response->content)) {
          return $response->content;
        } else {
      return false;
    }
  }


  public function getUserAccountDetails($accId) {
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/accounts/$accId");
    $response = \json_decode($query);

    if($query->status() == 200) {
      return $response;
    }
    return false;
  }

  public function getUserBeneficiaries($cid) {
    //   $this->createEuroAccount($cid, $uid);
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/beneficiaries/?customerId=$cid");
      $response = \json_decode($query);
      if(isset($query["content"])) {
        return $query["content"];
      }
      return false;
  }


  public function getPaymentDetails($payRef) {
    $currentDateTime = Carbon::now();
    $newDateTime = substr($currentDateTime->subMonths(5)->toIso8601String(), 0, 22)."00";
    $query = \Http::withHeaders($this->authService->sandboxHeaders())->get($this->url."/payments/?id=$payRef");
      $response = \json_decode($query);
          \Log::info(json_encode($response));
      if(isset($query["content"])) {
        return $query["content"];
      }
      $data['error'] = 'error';
      $data['msg'] = $response;
      return $data;
  }



  public function tellConnectPostPayment($request, $ref) {
    $account = substr($request['Data']['BeneficiaryIdentification'], 6);
    $scode = substr($request['Data']['BeneficiaryIdentification'], 6,6);
    \Log::info(json_encode($scode));

    $payload = [
      'amount' => $request['Data']['Amount'],
      'currency' => $request['Data']['Currency'],
      'sourceAccountId' => $request['Data']['AccountId'],
      'externalReference' => \bin2hex(\random_bytes(8)),
      'reference' => $ref,
      'destination' => [
        'accountNumber' => $account,
        'sortCode' => $scode,
        'type' => 'SCAN',
        'name' => $request['Data']['BeneficiaryName'],
      ]
  ];

  $query = \Http::withHeaders($this->authService->sandboxHeaders())->post($this->url."/payments", $payload);
  $response = \json_decode($query);
  \Log::info(json_encode($response));

  if($query->status() == 201) {
    return $response;
  }
  $data['error'] = 'error';
  $data['msg'] = $response;
  return $data;
}


}
