<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankingDetail;
use App\Http\Requests\ComplianceRequest;
use App\Events\ComplianceVerification;
use App\Models\SubscriptionPlan;
use App\Services\ModulrService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SumsubComplianceController extends Controller
{
    protected $user;
    protected $document;
    protected $details;
    protected $modulr;


    public function __construct(User $user, BankingDetail $document, ModulrService $modulr) {
        $this->user = $user;
        $this->document = $document;
        $this->modulr = $modulr;
        $this->url = env('SUMSUB_URL');
        $this->secret = env('SUMSUB_SECRET');
        $this->sumsubToken = env('SUMSUB_TOKEN');

    }

    /**
     * Store data
     */
    public function store($request, $token) {
        \Log::info($request->all());
        $user = $this->user->find($request->user_id);
        $save = $user->update([
            'business_name' => $request->buiness_type === 'LLC' ? $request->name : $request->soletrader_business_name,
            'business_type' => $request->business_type,
            'dob'           => $request->dob,   //$request->year_account.'-'.$request->month_account.'-'.$request->day_account, //$request->dob,
            'gender'        => $request->gender,
            'postal_code'   => $request->soletrader_postcode,
            'post_town'     => $request->soletrader_city,
            'address_line1' => $request->soletrader_addresss_1,
            'address_line2' => $request->soletrader_addresss_2,
            'company_reg_number' => $request->company_RegNumber,
            "industry_code" => $request->industry_code,
            "country_code" => $request->country_code,
            "turnover" => $request->turnover,
            "service_type" => $request->service_type,
            "verif_details_submitted" => "YES",
            "website_link" => $request->websiteURL,
            "facebook" => $request->has('facebookURL') ? $request->facebookURL : NULL,
            "instagram" => $request->has('instagramURL') ? $request->instagramURL : NULL,
            "twitter" => $request->has('twitterURL') ? $request->twitterURL : NULL,
            "product_description" => $request->business_description,
            "account_data" => $request->all()
        ]);
        if($save) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'token'   => $token
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Could not save data'
        ], 422);
    }

    /**
     * Create applicant
     */
    public function createApplicant(ComplianceRequest $request) {
        $user = $this->user->find($request->user_id);
        $payload = [
            'externalUserId' => $user->id,
            'email' => $request->email,
            'phone' => $request->phone,

            'metadata' => [
                [
                    'userId' => $request->user_id,
                ]
            ],
            'fixedInfo' => [
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'dob' => date('Y-m-d', \strtotime($request->dob)),
                'gender' => $request->gender,
                'countryOfBirth' => $request->country_of_birth,
                'country' => $user->getCountry()->iso,
                'addresses' => [
                    [
                        'country' => $user->getCountry()->iso,
                        'postCode' => $request->postal_code,
                        'town' => $request->post_town
                    ]
                ],
            ],
        ];
        $levelName = 'basic-kyc-level';
        $ts = time();
        $url = "/resources/applicants?levelName=$levelName";
        $signature = hash_hmac('sha256', $ts . 'POST' . $url . $request->getContent(), $this->secret);
        $query = Http::withHeaders([
            'X-App-Token' => $this->sumsubToken,
            'X-App-Access-Sig' => $signature,
            'X-App-Access-Ts' => $ts,
            'Content-Type' => 'application/json'
        ])->post($this->url, $payload);


    }

    /**
     * Create ID document
     */
    public function createIdDcoument(Request $request) {
        $payload = [
            'metadata' => [
                'idDocType' => $request->document_type,
                'idDocSubType' => $request->document_sub_type,
                'country' => $request->country,
                'issuedDate' => date('Y-m-d', strtotime($request->issued_date)),
                'validUntil' => date('Y-m-d', strtotime($request->valid_until)),
                'number' => $request->id_number,
            ],
            'content' => $request->document
        ];
        $query = Http::withHeaders([
            'Content-Type' => 'multipart/form-data',
            'X-Return-Doc-Warnings' => true,
        ])->post($this->url+"/resources/applicants/$request->applicant_id/info/idDoc", $payload);
        Log::info($query);
        if(!isset($query['errors'])) {
            return back()->with('toast_success', 'Document submited');
        }
        return back()->withErrors($query['errors']);
    }

    /**
     * Get ID document data
     */
    public function getIdDcoumentData($uid, $applicantId) {
        $query = Http::get($this->url+"/resources/applicants/$applicantId/one");
        Log::info("Document");
        Log::info($query);
        $response = json_decode($query);
        if($response->status() == 200 && isset($query['id'])) {
            $data = $query;
            $this->modulr->sendComplianceDocument($uid, $query);
            // return back()->withData('toast_success', 'Successful');
        }
        // return back()->with('toast_error', 'Could not fetch data');
    }

    /**
     * Get verification result
     */
    public function getVerificationResult(Request $request) {
        $query = Http::get($this->url+"/resources/applicants/$request->applicant_id/one");
        Log::info($query);
        $response = json_decode($query);
        if($response->status() == 200 && isset($query['id'])) {
            $data = $query;
            return back()->withData('toast_success', 'Successful');
        }
        return back()->with('toast_error', 'Could not fetch data');
    }

    /**
     * Get access token
     */
    public function getSumSubAccessToken(ComplianceRequest $request) {
        // return $request->all();
        $levelName = 'poi_liveness-aml-poa';
        $ts = time();
        $lname = urlencode($levelName);
        $data = json_encode($request->all());
        $url = "/resources/accessTokens?userId=$request->user_id&levelName=$levelName&ttlInSecs=$ts";
        $response = Http::withHeaders([
            'X-App-Token' => $this->sumsubToken,
            'X-App-Access-Sig' => hash_hmac('sha256', $ts.$request->method().$url.$data, $this->secret),
            'X-App-Access-Ts' => $ts,
            'Content-Type' => 'application/json'
        ])->post($this->url . $url, $request->all());
        $resp = json_decode($response);
        \Log::info($response);
        if (isset($resp->token) && !empty($resp->token)) {
            return $this->store($request, $resp->token);
        }
        return response()->json([
            'status' => false,
            'message' => 'Network error, please try again'
        ], 422);
    }

    public function getKycDocuments($uid, $applicantId, $inspectionId, $imageId, $fileName) {
        $user = User::find($uid);
        if($user) {
          $ts = time();
          $url = "/resources/inspections/$inspectionId/resources/$imageId";
          $signature = hash_hmac('sha256', $ts.'GET'.$url, $this->secret);
          $request = \Http::withHeaders([
              'X-App-Token' => $this->sumsubToken,
              'X-App-Access-Sig' => $signature,
              'X-App-Access-Ts' => $ts,
              'Content-Type' => 'application/json'
          ])->get($this->url.$url);
          $account_data = json_decode($user->account_data);
           $data = [
              'content'  => base64_encode($request),
              'fileName' => $fileName,
              'group'    => $user->business_type === 'SOLETRADER' || $user->business_type === 'INDIVIDUAL' ? $user->first_name.' '.$user->last_name : $account_data->name
           ];
           \Log::info("DOCUMENT SENT TO MODULR");
           \Log::info($data);
          return $response = $this->modulr->sendComplianceDocument($user->id, $data);
        }
    }

    /**
     * Get access token
     */
    public function getToken(Request $request) {
        $user = User::find($request->user_id);
        if($user) {
            $levelName = 'poi_liveness-aml-poa';
            $ts = time();
            $lname = urlencode($levelName);
            $data = json_encode($request->all());
            $url = "/resources/accessTokens?userId=$request->user_id&levelName=$levelName&ttlInSecs=$ts";
            $response = Http::withHeaders([
                'X-App-Token' => $this->sumsubToken,
                'X-App-Access-Sig' => hash_hmac('sha256', $ts.$request->method().$url.$data, $this->secret),
                'X-App-Access-Ts' => $ts,
                'Content-Type' => 'application/json'
            ])->post($this->url . $url, $request->all());
            $resp = json_decode($response);
            Log::info($response);
            if (isset($resp->token) && !empty($resp->token)) {
                return response()->json([
                    'status' => true,
                    'message'  => 'success',
                    'token' => $resp->token
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Network error, please try again'
        ], 422);
    }

    /**
     * Get applicant data
    */
    public function getApplicantData($applicantId)
    {
        return $this->modulr->getApplicantData($applicantId);
        $ts = time();
        $url = '/resources/applicants/'.$applicantId.'/one';
        $signature = hash_hmac('sha256', $ts.'GET'.$url, $this->secret);
        $query = \Http::withHeaders([
            'X-App-Token' => $this->sumsubToken,
            'X-App-Access-Sig' => $signature,
            'X-App-Access-Ts' => $ts,
            'Content-Type' => 'application/json'
        ])->get($this->url.$url);
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

    /**
     * Get applicant status
    */
    public function getApplicantStatus($uid, $applicantId, $inspectionId) {
        $ts = time();
        $url = "/resources/applicants/$applicantId/requiredIdDocsStatus";
        $signature = hash_hmac('sha256', $ts.'GET'.$url, $this->secret);
        $query = \Http::withHeaders([
            'X-App-Token' => $this->sumsubToken,
            'X-App-Access-Sig' => $signature,
            'X-App-Access-Ts' => $ts,
            'Content-Type' => 'application/json'
        ])->get($this->url.$url);
        \Log::info($query);
        if(isset($query["IDENTITY"])) {
            return $this->getKycDocuments($uid, $applicantId, $inspectionId, $query['IDENTITY']['imageIds'][0], $query['IDENTITY']['idDocType'].'.jpg');
        }
        if(isset($query["COMPANY"])) {
            $applicantDoc = $query["COMPANY"]["stepStatuses"][0]["images"][0];
            return $this->getKycDocuments($uid, $applicantId, $inspectionId, $applicantDoc["imageId"], $applicantDoc['idDocType'].'.jpg');
        }
    }

    /**
     * Sumsub webhook
     */
    public function sumSubWebhook(Request $request)
    {
        Log::info($request->all());
        if (isset($request->type) && isset($request->externalUserId)) {
            $user =  $this->user->find($request->externalUserId);
            if ($request->type === 'applicantReviewed' && $request->reviewStatus === 'completed' && isset($request->reviewResult) && $request->reviewResult['reviewAnswer'] === 'GREEN') {
                if(!empty($user) && $user->kyc_verif_status !== 'APPROVED') {
                    $user->update(['kyc_verif_status' => 'PENDING']);
                }
                if(empty($user->account)) {
                    $this->getApplicantStatus($request->externalUserId, $request->applicantId, $request->inspectionId);

                    //Plans and Go live
                    $link = SubscriptionPlan::wheretype('basic')->first();
                    $user->plan_id = $link->id;
                    $user->live = 1;
                    $user->plan_type="basic";
                    $user->plan_expiring = Carbon::now()->add($link->duration.$link->durationType);
                    $user->email_limit = $user->email_limit + $link->email_limit;
                    $user->sms_limit = $user->sms_limit + $link->sms_limit;
                    $user->save();
                }
                return \http_response_code(200);
            } elseif (!empty($user) && $request->type === 'applicantReset') {
                $user->update(['kyc_verif_status' => 'RESUBMIT']);
                return \http_response_code(200);
            } elseif (!empty($user) && $request->type === 'applicantCreated') {
                $user->update(['kyc_verif_status' => 'SUBMITTED']);
                return \http_response_code(200);
            } elseif (!empty($user) && $request->reviewStatus === 'queued') {
                $user->update(['kyc_verif_status' => 'PROCESSING']);
                return \http_response_code(200);
            } elseif (!empty($user) && $request->reviewStatus === 'pending') {
                $user->update(['kyc_verif_status' => 'PENDING']);
                return \http_response_code(200);
            } elseif (!empty($user) && $request->reviewStatus === 'onHold') {
                $user->update(['kyc_verif_status' => 'PENDING']);
                return \http_response_code(200);
            } elseif (!empty($user) && $request->type === 'applicantReviewed' && $request->reviewStatus === 'completed' && isset($request->reviewResult) && $request->reviewResult['reviewAnswer'] === 'RED') {
                $user->update(['kyc_verif_status' => 'DECLINED']);
                \event(new ComplianceVerification($user, 'Declined'));
                return \http_response_code(200);
            }
        }
    }

    /**
     * Company house check
    */
    public function companyNameCheck() {
        \Log::info(request()->query());
        $param = request()->query('search');
        $query = \Http::withHeaders([
            'Authorization' => '1397b381-28d1-477d-8135-55341ba8c854'
        ])->get("https://api.company-information.service.gov.uk/search?q=$param");
        if(isset($query['items'])) {
            // return $query['items'];
            $data = [];
            foreach($query['items'] as $key => $company) {
                // \Log::info($company['company_status']);
                if(isset($company['company_status']) && $company['company_status'] === 'active') {
                    $data[$key] = $company;
                }
            }
            return $data;
        }
        return $query;
    }

    /**
     * Fetch Company officers
    */
    public function fetchOfficers($companyReg) {
        $url = "https://api.company-information.service.gov.uk/company/$companyReg/officers";
        $param = request()->query('search');
        $query = \Http::withHeaders([
            'Authorization' => '1397b381-28d1-477d-8135-55341ba8c854'
        ])->get($url);
        \Log::info($query);
        if(isset($query['items'])) {
            return json_decode($query);
        }
        return json_decode($query);
    }

    /**
     * Fetch Company beneficiaries
    */
    public function getBeneficiaries($companyReg, $psc_id) {
        \Log::info(request()->fullUrl());
        $url = "https://api.company-information.service.gov.uk/company/$companyReg/persons-with-significant-control/corporate-entity-beneficial-owner/$psc_id";
        $query = \Http::withHeaders([
            'Authorization' => '1397b381-28d1-477d-8135-55341ba8c854'
        ])->get($url);
        \Log::info($query);
        // if(isset($query['items'])) {
        // }
        return json_decode($query);
        return json_decode($query);
    }
}
