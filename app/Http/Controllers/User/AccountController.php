<?php

namespace App\Http\Controllers\User;
use App\Models\Country;
use Illuminate\Support\Facades\URL;
use App\Models\Merchant;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Logo;
use App\Models\Audit;
use App\Models\Countrysupported;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App;
use Illuminate\Support\Facades\Http;
use App\Mail\SendEmail;
use App\Jobs\approvedCompliance;
use App\Jobs\declinedCompliance;
use App\Jobs\ComplianceVerificationJob;
use App\Models\BankingDetail;
use App\Models\Mcc;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\XeroConnections;
use CreateXeroTokensTable;
use Dcblogdev\Xero\Facades\Xero;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;
use Illuminate\Support\Facades\Mail;
use App\Services\TellConnectService;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Save verification session ID
     */
    protected $tellConnectService;

    public function __construct(TellConnectService $tellConnectService )
    {
        $this->settings = Settings::find(1);
        $this->logo = Logo::first();
        $this->tellConnectService = $tellConnectService;
        $this->sumsubSecret = 'duY9Mfd2STN2ukki7RgjF0kYClhiAyRa';
        $this->sumsubToken = 'sbx:Gu7sFQk5xiaWyBwDqBdMbGum.zQ3X19VDqW0G9zh1rxm4PclxGY3KcEHm';

    }
    public function saveVerifData(Request $request)
    {
        if (!empty($request->user_id) && !empty($request->data_id)) {
            $user = User::find($request->user_id);
            if ($user && $user->kyc_verif_status !== 'APPROVED') {
                $user->update(["verif_session_id" => $request->data_id]);
            }
            return response()->json([
                "status" => true,
                "message" => "success",
                "data" => []
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "failed",
            "data" => []
        ]);
    }
    /**
     * Submit verif Data
     */
    public function submitVerifData(Request $request)
    {
        \Log::info($request->all());
        if (!empty($request->user_id)) {
            $user = User::find($request->user_id);
            if ($user && empty($user->kyc_verif_status)) {
                $user->update(["kyc_verif_status" => 'SUBMITTED']);
            }
            return response()->json([
                "status" => true,
                "message" => "success",
                "data" => []
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "failed",
            "data" => []
        ]);
    }
    public function compliancesession()
    {
        Session::put('compliance', Auth::guard('user')->user()->id);
        return redirect()->route('user.dashboard');
    }

    //Settings
    public function profile()
    {
        $data['title'] = "Global Settings";
        return view('user.profile.profile', $data);
    }

    public function showpreferences(){
        $data['title'] = "Global Settings";
        return view('user.profile.preference', $data);
    }

    public function showSecurity(){
        $data['title'] = "Global Settings";
        $g = new GoogleAuthenticator();
        $secret = $g->generateSecret();
        $data['secret'] = $secret;
        $data['image'] = GoogleQrUrl::generate(auth()->guard('user')->user()->email, $secret, $this->settings->site_name);
        return view('user.profile.security', $data);
    }

    public function showSocial(){
        $data['title'] = "Global Settings";
        return view('user.profile.social', $data);
    }
    public function showApi(){
        $data['title'] = "Global Settings";
        return view('user.profile.api', $data);
    }

    public function showBilling(){
        $data['title'] = "Global Settings";
        return view('user.profile.billing', $data);
    }

    public function stripe_connect( ){
        //first step
        //   $stripe =  new StripeClient(env('Stripe_Keys'));
        //   $standand  =  $stripe->accounts->create(['type' => 'standard']);
        //   return $standand;
        $url = URL::to('/');
        $person =  User::find(auth()->user()->id);
        if($person->stripe_id){
                $stripe =  new StripeClient(env('Stripe_Keys'));
                $stand  = $stripe->accountLinks->create([
                    'account' => $person->stripe_id,
                    'refresh_url' => $url.'/user/connections',
                    'return_url' => $url.'/user/connections',
                    'type' => 'account_onboarding',

                  ]);

                  return $stand['url'];

        }else{
            $mccs = Mcc::where('status', auth()->user()->mcc)->first()->name;
            $ans = substr($mccs, 0, 3);
            $url = URL::to('/');
            $business_type = auth()->user()->business_type = 'LLC'?'company':'individual';
            $country_iso3 = Country::where('id',  auth()->user()->country)->first()->iso;
            $country_name = Country::where('id',  auth()->user()->country)->first()->name;
            $banking = BankingDetail::where("user_id", auth()->user()->id)->first();
            $bankans =  $banking->accountType == 'LLC'?'company':'individual';
              //BankingDetail
            $stripe = new StripeClient(
            env('Stripe_Keys')
        );
        //auth()->user()->email
            if($business_type == 'company'){
                        $standard = $stripe->accounts->create([

                            'type' => 'standard',
                            'country' => $country_iso3,
                            'email' =>auth()->user()->email,
                            'business_type'=>$business_type,
                            'capabilities' => [
                              // 'card_payments' => ['requested' => true],
                              // 'transfers' => ['requested' => true],
                            ],
                          "business_profile" => [
                             "mcc"=>7623,
                              "name"=>auth()->user()->first_name,
                              "product_description"=>auth()->user()->product_description,
                             //  "support_address"=> auth()->user()->address_line1,
                              "support_email"=>auth()->user()->support_email,
                              "support_phone"=>auth()->user()->support_phone,
                              "support_url"=>auth()->user()->website_link,
                              "url"=> null
                          ],
                              "company"=>[
                               "address"=>[
                                     "city"=> auth()->user()->city,
                                  "line1"=> auth()->user()->line_1,
                                   "line2"=>auth()->user()->line_1,
                                  "postal_code"=>auth()->user()->postal_code,
                                  "state"=> auth()->user()->state
                               ]
                               ],
                               "external_account"=>[
                                "object"=> "bank_account",
                                "country"=>$country_iso3,
                                "currency"=>$banking->currency,
                                "account_holder_name"=>auth()->user()->first_name." ".auth()->user()->last_name,
                                "account_holder_type"=>$banking->accountType == 'LLC'?'company':'individual',
                                "routing_number"=>$banking->accountId,
                                "account_number"=>"GB82WEST12345698765432",
                                "data"=>array(
                                    "country"=>$country_iso3,
                                    "currency"=>$banking->currency,
                                    "account_holder_name"=>auth()->user()->first_name." ".auth()->user()->last_name,
                                    "account_holder_type"=>$banking->accountType == 'LLC'?'company':'individual',
                                    "routing_number"=>$banking->accountId,
                                    "account_number"=>"GB82WEST12345698765432",
                                ),
                                // "has_more"=> false,
                            ]

                          ]);

                    }else{
                        $standard = $stripe->accounts->create([

                            'type' => 'standard',
                            'country' => $country_iso3,
                            'email' =>auth()->user()->email,
                            'business_type'=>$business_type,
                            'capabilities' => [
                              // 'card_payments' => ['requested' => true],
                              // 'transfers' => ['requested' => true],
                            ],
                          "business_profile" => [
                             "mcc"=>7623,
                              "name"=>auth()->user()->first_name,
                              "product_description"=>auth()->user()->product_description,
                              "support_address"=>[
                                "address"=>[
                                    "city"=> auth()->user()->city,
                                 "line1"=> auth()->user()->line_1,
                                  "line2"=>auth()->user()->line_1,
                                 "postal_code"=>auth()->user()->postal_code,
                                 "state"=> auth()->user()->state
                                ],
                              ],
                              "support_email"=>auth()->user()->support_email,
                              "support_phone"=>auth()->user()->support_phone,
                              "support_url"=>auth()->user()->website_link,
                              "url"=> null
                          ],

                               "individual"=>[
                                  "address"=>[
                                      "city"=> auth()->user()->city,
                                   "line1"=> auth()->user()->line_1,
                                    "line2"=>auth()->user()->line_1,
                                   "postal_code"=>auth()->user()->postal_code,
                                   "state"=> auth()->user()->state
                                  ],
                                  "dob"=>auth()->user()->dob,
                                  "email"=>auth()->user()->email,
                                  "first_name"=>auth()->user()->first_name,
                                  "gender"=>auth()->user()->gender,
                                  "maiden_name"=>auth()->user()->middle_name,
                                   "phone"=>auth()->user()->phone
                              ],

                              "external_account"=>[
                                "object"=> "bank_account",
                                "country"=>$country_iso3,
                                "currency"=>$banking->currency,
                                "account_holder_name"=>auth()->user()->first_name." ".auth()->user()->last_name,
                                "account_holder_type"=>$banking->accountType == 'LLC'?'company':'individual',
                                "routing_number"=>$banking->accountId,
                                "account_number"=>"GB82WEST12345698765432",
                                "data"=>array(
                                    "country"=>$country_iso3,
                                    "currency"=>$banking->currency,
                                    "account_holder_name"=>auth()->user()->first_name." ".auth()->user()->last_name,
                                    "account_holder_type"=>$banking->accountType == 'LLC'?'company':'individual',
                                    "routing_number"=>$banking->accountId,
                                    "account_number"=>"GB82WEST12345698765432",
                                ),
                                // "has_more"=> false,
                            ]


                          ]);

                    }




       if($standard['id']){
        $stripe =  new StripeClient(env('Stripe_Keys'));
        $stand  = $stripe->accountLinks->create([
            'account' => $standard['id'],
            'refresh_url' => $url.'/user/connections',
            'return_url' =>  $url.'/user/connections',
            'type' => 'account_onboarding',

          ]);

          $person->stripe_id = $standard['id'];
           $person->stripe = 1;
           $person->save();
          return $stand['url'];
       }
        }

  }

    public function showConnection(){
        //stripe_connect
        $stripe = $this->stripe_connect();
        $data['stripe_url'] = $stripe;
        $data['title'] = "Global Settings";
        $user = User::find(auth()->guard('user')->user()->id);
        $paypalcountry =  $this->AllowedCountries(auth()->guard('user')->user()->country);
        $data['paypalcountry'] =  $paypalcountry;
        $xeroCredentials = XeroConnections::where('uuid',Auth::user()->id)->where('active',1)->exists();
        if($user->getCountrySupported()->paypal == 1 AND auth()->guard('user')->user()->paypal_client_id == NULL && auth()->guard('user')->user()->paypal_secret_key == NULL) {
            $seller = bin2hex(random_bytes(43));
            //$res = $this->GetPayPalLInk($seller);
            if (false) {
                return redirect()->route('user.bank')->with('toast_error', 'Error in connection to Paypal.');
            }else{
                $data['url'] = "";//$res['links'][1]['href'];
                $data['seller'] = $seller;
            }
        }else{
            $data['url'] = $data['seller'] = "";
        }
        $data['xero'] = false;
        if($xeroCredentials){
            $data['xero'] = true;
        }
        return view('user.profile.connections', $data);
    }

    public function logout()
    {
        if (Auth::guard('user')->check()) {
            $user = User::findOrFail(Auth::guard('user')->user()->id);
            $user->fa_expiring = Carbon::now()->subMinutes(30);
            $user->save();
            session()->forget('oldLink');
            Auth::guard('user')->logout();
            session()->flash('message', 'Just Logged Out!');
            return redirect()->route('login');
        } else {
            return redirect()->route('login');
        }
    }
    public function submitPassword(Request $request)
    {
        $user = User::whereid(Auth::guard('user')->user()->id)->first();
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            $audit['user_id'] = Auth::guard('user')->user()->id;
            $audit['trx'] = str_random(16);
            $audit['log'] = 'Changed Password';
            Audit::create($audit);
            return back()->with('toast_success', 'Password Changed successfully.');
        } elseif (!Hash::check($request->password, $user->password)) {
            return back()->with('toast_warning', 'Invalid password');
        }
    }
    public function account(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'phone' => 'required|string|max:14',
            'email' =>'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $set = Settings::first();
        $user = User::findOrFail(Auth::guard('user')->user()->id);

        if(Hash::check($request->password, $user->password)){
            if ($user->phone !== ('+' . $user->getCountry()->phonecode . $request->phone)) {
                if(!User::wherePhone('+' . $user->getCountry()->phonecode . $request->phone)->exists() && $set->sms_verification == 1){
                    try {
                        $user->phone_verify = 0;
                        $user->phone = PhoneNumber::make($request->phone, $user->getCountry()->iso)->formatE164();
                        $user->save();
                    } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                        return back()->with('toast_warning', $e->getMessage());
                    }
                }else {
                    return back()->with('toast_warning', 'Mobile Number already in use.');
                }
            }

            if ($user->email !== $request->email) {
                $check = User::whereemail($request->email)->count();
                if ($check < 1) {
                    if ($set->email_verification == 1) {
                        $user->email_verify = 0;
                        $user->email = $request->email;
                        $user->save();
                    }
                } else {
                    return back()->with('toast_warning', 'Email address already in use.');
                }
            }

            return back()->with('toast_success', 'Profile Updated Successfully.');

        }else{
            return back()->with('toast_danger', 'Incorrect password used !');
        }
    }

    public function preferences(Request $request)
    {
        $user = User::findOrFail(Auth::guard('user')->user()->id);
        $user->support_email = $request->support_email;
        $user->support_phone = $request->support_phone;
        $user->checkout_logo = $request->checkout_logo;
        $user->mcc = $request->mcc;
        if ($request->checkout_theme == "bg-white") {
            $user->checkout_theme = null;
        } else {
            $user->checkout_theme = $request->checkout_theme;
        }
        $user->social_links = $request->social_links;
        $user->display_support_email = $request->display_support_email;
        $user->display_support_phone = $request->display_support_phone;
        $user->save();
        $audit['user_id'] = Auth::guard('user')->user()->id;
        $audit['trx'] = str_random(16);
        $audit['log'] = 'Updated preferences';
        Audit::create($audit);
        return redirect()->route('user.preferences')->with('toast_success', 'Profile Updated Successfully.');
    }
    public function payment(Request $request)
    {
        $user = User::findOrFail(Auth::guard('user')->user()->id);
        $xf = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if (!empty($request->bank_pay)) {
            if ($xf->bank_format == "uk") {
                if ($request->acct_no == null || $request->routing_number == null) {
                    return redirect()->route('user.bank')->with('toast_warning', 'Provide all Bank Credentials.');
                } else {
                    $user->acct_no = $request->acct_no;
                    $user->routing_number = $request->routing_number;
                    $user->payment = 1;
                }
            } elseif ($xf->bank_format == "eur") {
                if ($request->acct_no == null) {
                    return redirect()->route('user.bank')->with('toast_warning', 'Provide all Bank Credentials.');
                } else {
                    $user->acct_no = $request->acct_no;
                    $user->payment = 1;
                }
            }
        }
        if (!empty($request->coinbase)) {
            if ($request->coinbase_api_key == null) {
                return redirect()->route('user.bank')->with('toast_warning', 'Provide all Coinbase Credentials.');
            } else {
                $user->coinbase_api_key = $request->coinbase_api_key;
                $user->payment = 1;
            }
        }
        if(!empty($request->paypal)){
            if($request->paypal_client_id == null || $request->paypal_secret_key == null){
                return redirect()->route('user.bank')->with('toast_warning', 'Provide all Paypal Credentials.');
            }else{
                $user->paypal_client_id=$request->paypal_client_id;
                $user->paypal_secret_key=$request->paypal_secret_key;
                $user->payment = 1;
            }
        }
        $user->coinbase = $request->coinbase;
        $user->bank_pay = $request->bank_pay;
        $user->paypal = $request->paypal;
        $user->save();
        $audit['user_id'] = Auth::guard('user')->user()->id;
        $audit['trx'] = str_random(16);
        $audit['log'] = 'Updated payment method';
        Audit::create($audit);
        return redirect()->route('user.bank')->with('toast_success', 'Payment Method Updated Successfully.');
    }
    public function accountmode($id)
    {
        $user = User::findOrFail(Auth::guard('user')->user()->id);
        if ($id == 0) {
            $user->live = 0;
            $user->save();
            return back()->with('toast_success', 'Test mode activated');
        } elseif ($id == 1) {
            if ($user->kyc_verif_status == "APPROVED") {
                $user->live = 1;
                $user->save();
                return back()->with('toast_success', 'Live mode activated, you can now receive payments');
            } else {
                Session::put('compliance', Auth::guard('user')->user()->id);
                return back()->with('toast_warning', 'To enable live mode, We need more information about you');
            }
        }
    }
    public function social(Request $request)
    {
        $data = User::findOrFail(Auth::guard('user')->user()->id);
        $data->fill($request->all())->save();
        $data->save();
        return back()->with('toast_success', 'Social accounts Updated Successfully.');
    }
    public function generateapi()
    {
        $data = User::findOrFail(Auth::guard('user')->user()->id);
        $data->public_key = 'pub-live-' . Str::random(32);
        $data->secret_key = 'sec-live-' . Str::random(32);
        $data->test_public_key = 'pub-test-' . Str::random(32);
        $data->test_secret_key = 'sec-test-' . Str::random(32);
        $data->save();
        return redirect()->route('user.api')->with('toast_success', 'New Api keys was generated successfully');
    }
    public function savewebhook(Request $request)
    {
        $data = User::findOrFail(Auth::guard('user')->user()->id);
        if ($request->has('receive_webhook')) {
            if ($request->webhook == null) {
                return redirect()->route('user.api')->with('toast_warning', 'Add a url to webhook');
            } else {
                $data->webhook = $request->webhook;
                $data->receive_webhook = $request->receive_webhook;
                $data->save();
                return redirect()->route('user.api')->with('toast_success', 'Webhook enabled');
            }
        } else {
            $data->receive_webhook = 0;
            $data->save();
            return redirect()->route('user.api')->with('toast_success', 'Webhook disabled');
        }
    }
    public function submit2fa(Request $request)
    {
        $user = User::findOrFail(Auth::guard('user')->user()->id);
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        $secret = $request->vv;
        $set = Settings::first();
        if ($request->type == 0) {
            $check = $g->checkcode($user->googlefa_secret, $request->code, 3);
            if ($check) {
                $user->fa_status = 0;
                $user->googlefa_secret = null;
                $user->save();
                $audit['user_id'] = Auth::guard('user')->user()->id;
                $audit['trx'] = str_random(16);
                $audit['log'] = 'Deactivated 2fa';
                Audit::create($audit);
                if ($set->email_notify == 1) {
                    $gg=[
                        'email'=>$user->email,
                        'name'=>$user->first_name.' '.$user->last_name,
                        'subject'=>'Two Factor Security Disabled',
                        'message'=>'2FA security on your account was just disabled, contact us immediately if this was not done by you.'
                    ];
                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                }
                return back()->with('toast_success', '2fa disabled.');
            } else {
                return back()->with('toast_warning', 'Invalid code.');
            }
        } else {
            $check = $g->checkcode($secret, $request->code, 3);
            if ($check) {
                $user->fa_status = 1;
                $user->googlefa_secret = $request->vv;
                $user->save();
                $audit['user_id'] = Auth::guard('user')->user()->id;
                $audit['trx'] = str_random(16);
                $audit['log'] = 'Activated 2fa';
                Audit::create($audit);
                if ($set->email_notify == 1) {
                    $gg=[
                        'email'=>$user->email,
                        'name'=>$user->first_name.' '.$user->last_name,
                        'subject'=>'Two Factor Security Enabled',
                        'message'=>'2FA security on your account was just enabled, contact us immediately if this was not done by you.'
                    ];
                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                }
                return back()->with('toast_success', '2fa enabled.');
            } else {
                return back()->with('toast_warning', 'Invalid code.');
            }
        }
    }
    public function veriffDecisionWebhook(Request $data)
    {
        // $set=Settings::find(1);
        $request = json_decode($data->getContent(), true);
        \Log::info($data);
        // \Log::info($data->status);
        // $apiKey = 'f7a1bfed-262b-4f32-8658-cffa89d6da7a';
        // $sig = $request->header('X-HMAC-SIGNATURE');
        // $signature = hash_hmac('sha256', $sig, 'secret');
        // if($signature === $apiKey) {
        if (isset($request['status']) && $request['status'] === 'success' && isset($request['verification']) && !empty($request['verification'])) {
            $user = User::find($request['verification']["vendorData"]);
            // \Log::info($user);
            if ($user && $request['verification']['status'] === 'approved' && $request['verification']['code'] == 9001 && $user->kyc_verif_status !== 'APPROVED') {
                $user->update(['kyc_verif_status' => 'APPROVED']);
                dispatch(new approvedCompliance($user->id));
                return http_response_code(200);
            } elseif ($user && $request['verification']['status'] === 'expired' || $request['verification']['status'] === 'abandoned') {
                $user->update([
                    'kyc_verif_status' => 'PENDING'
                ]);
                return http_response_code(200);
            } elseif ($user && $request['verification']['status'] === 'declined') {
                $user->update([
                    'kyc_verif_status' => 'DECLINED'
                ]);
                dispatch(new declinedCompliance($user->id));
                return http_response_code(200);
                // if($set->email_notify==1){
                // }
            } elseif ($user && $request['verification']['status'] === 'resubmission_requested') {
                $user->update([
                    'kyc_verif_status' => 'RESUBMIT'
                ]);
                return http_response_code(200);
            }
            // return http_response_code(200);
        }
        // }
    }
    //End of Settings

    public function getSumSubAccessToken(Request $request)
    {
        $userID = User::find($request->user_id);
        if (!$userID) {
            return response()->json([
                'status' => false,
                'message' => 'Inavlid user ID'
            ]);
        }
        $levelName = 'basic-kyc-level';
        $ts = time();
        $url = "/resources/accessTokens?userId=$userID->id&levelName=$levelName&ttlInSecs=$ts";
        $signature = hash_hmac('sha256', $ts . 'POST' . $url . $request->getContent(), $this->sumsubSecret);
        $response = \Http::withHeaders([
            'X-App-Token' => $this->sumsubToken,
            'X-App-Access-Sig' => $signature,
            'X-App-Access-Ts' => $ts,
            'Content-Type' => 'application/json'
        ])->post('https://api.sumsub.com' . $url, $request->all());
        \Log::info($response);
        $resp = json_decode($response);
        if (isset($resp->token) && !empty($resp->token)) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data'  => $resp
            ], 200);
        }
        return $response;
    }

    /**
     * Sumsub webhook
     */
    public function sumSubWebhook(Request $request)
    {
        \Log::info($request->all());
        // \Log::info($request->header());
        //  1n1qspxkiy6nzbyysyj8hawmsqu      API secret
        if (isset($request->type) && isset($request->externalUserId)) {
            $user =  User::find($request->externalUserId);
            if ($request->type === 'applicantReviewed' && $request->reviewStatus === 'completed' && isset($request->reviewResult) && $request->reviewResult['reviewAnswer'] === 'GREEN') {
                $user->update(['kyc_verif_status' => 'APPROVED']);
                // dispatch(new approvedCompliance($user->id));
                \dispatch(new ComplianceVerificationJob($user, 'Approved'));
                return \http_response_code(200);
            } elseif ($request->type === 'applicantReset') {
                $user->update(['kyc_verif_status' => 'RESUBMIT']);
                return \http_response_code(200);
            } elseif ($request->type === 'applicantCreated') {
                $user->update(['kyc_verif_status' => 'SUBMITTED']);
            } elseif ($request->reviewStatus === 'queued') {
                $user->update(['kyc_verif_status' => 'PROCESSING']);
            } elseif ($request->reviewStatus === 'pending') {
                $user->update(['kyc_verif_status' => 'PENDING']);
            } elseif ($request->reviewStatus === 'onHold') {
                $user->update(['kyc_verif_status' => 'PENDING']);
            } elseif ($request->type === 'applicantReviewed' && $request->reviewStatus === 'completed' && isset($request->reviewResult) && $request->reviewResult['reviewAnswer'] === 'RED') {
                $user->update(['kyc_verif_status' => 'DECLINED']);
                // dispatch(new declinedCompliance($user->id));
                \dispatch(new ComplianceVerificationJob($user, 'Declined'));
                return \http_response_code(200);
            }
        }
    }

    public function GetPayAccessToken()
    {
        $url = env("PAYPAL_URL") . 'v1/oauth2/token';
        $res = Http::withBasicAuth(env('PAYPAL_CLIENT_ID'), env("PAYPAL_SECRET_ID"))
            ->withHeaders([
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US'
            ])->asForm()->post($url, [
                'grant_type' => 'client_credentials'
            ]);

        return $res;
    }

    public function GetSellerAccessToken($clientID, $secretID, $authCode, $seller)
    {
        $url = env("PAYPAL_URL") . 'v1/oauth2/token';
        $data = [
            "grant_type" => "authorization_code",
            "code" => $authCode,
            "code_verifier" => $seller
        ];
        $res = Http::withBasicAuth($clientID, $secretID)
            ->withHeaders([
                'Accept' => 'application/json',
                'Accept-Language' => 'en_US'
            ])->asForm()->post($url, $data);

        return $res['access_token'];
    }

    public function GetPayPalLInk($seller)
    {
        $data = [
            "operations" => array([
                "operation" => "API_INTEGRATION",
                "api_integration_preference" => [
                    "rest_api_integration" => [
                        "integration_method" => "PAYPAL",
                        "integration_type" => "FIRST_PARTY",
                        "first_party_details" => [
                            "features" => [
                                "PAYMENT",
                                "REFUND",
                                "FUTURE_PAYMENT",
                                "PARTNER_FEE",
                                "DELAY_FUNDS_DISBURSEMENT",
                                "UPDATE_CUSTOMER_DISPUTES"
                            ],
                            "seller_nonce" => $seller,
                        ]
                    ]
                ]
            ]),
            "partner_config_override" => [
                "partner_logo_url" =>'https://tryba.io/asset/images/logo_1630539941.png',
                "return_url" => route('redirectUrl'),
                "return_url_description" => "Connect your paypal account with Tryba"
            ],
            "products" => [
                "EXPRESS_CHECKOUT"
            ],
            "legal_consents" => array([
                "type"  => "SHARE_DATA_CONSENT",
                "granted" => true
            ])
        ];
        $url = env("PAYPAL_URL") . 'v2/customer/partner-referrals';
        $token = $this->GetPayAccessToken();
        $res = Http::withToken($token['access_token'])
            ->withHeaders([
                "Content-Type" => "application/json"
            ])->post($url, $data);

        return $res;
    }

    public function redirectUrl()
    {
        return redirect()->route('user.bank')->with('toast_success', 'Successfully added your Paypal credentials ');
    }

    public function returnUrlPayPal(Request $request)
    {

        $authCode = $request->authCode;
        $sharedId = $request->sharedId;
        $seller = $request->seller;

        $token = $this->GetSellerAccessToken($sharedId, "", $authCode, $seller);



        $url = env("PAYPAL_URL") . 'v1/customer/partners/' . env('PAYPAL_MERCHANT_ID') . '/merchant-integrations/credentials/';

        $res = Http::withToken($token)
            ->withHeaders([
                "Content-Type" => "application/json"
            ])->get($url);


        $user = User::where('id', Auth::user()->id)->first();
        $user->paypal_client_id = $res['client_id'];
        $user->paypal_secret_key = $res['client_secret'];
        $user->save();

        return response()->json("Successfully connected to paypal", 200);
    }


    public function disconnectPayPal()
    {

        $user = User::where('id', Auth::user()->id)->first();
        $user->paypal_client_id = null;
        $user->paypal_secret_key = null;
        $user->save();

        return redirect()->route('user.bank')->with('toast_success', 'Successfully removed your Paypal account ');
    }


    public function connectXero(){
        if (!request()->has('code')) {

            $url = 'https://login.xero.com/identity/connect/authorize' . '?' . http_build_query([
                'response_type' => 'code',
                'client_id'     => config('xero.clientId'),
                'redirect_uri'  => config('xero.redirectUri'),
                'scope'         => config('xero.scopes')
            ]);

            return redirect()->away($url);
        } elseif (request()->has('code')) {

            // With the authorization code, we can retrieve access tokens and other data.
            try {
                $params = [
                    'grant_type'    => 'authorization_code',
                    'code'          => request('code'),
                    'redirect_uri'  => config('xero.redirectUri')
                ];

                $resultCode = $this->dopost('https://identity.xero.com/connect/token', $params);

                try {
                    $client = new Client;
                    $response = $client->get('https://api.xero.com/connections', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $resultCode['access_token'],
                            'Content-Type' => 'application/json'
                        ]
                    ]);

                    $result = json_decode($response->getBody()->getContents(), true);

                    $tenantData = [
                        'auth_event_id'    => $result[0]['authEventId'],
                        'tenant_id'       => $result[0]['tenantId'],
                        'tenant_type'     => $result[0]['tenantType'],
                        'tenant_name'     => $result[0]['tenantName'],
                        'created_date_utc' => $result[0]['createdDateUtc'],
                        'updated_date_utc' => $result[0]['updatedDateUtc']
                    ];
                    $this->storeToken($resultCode, $tenantData);

                } catch (Exception $e) {
                    throw new Exception('error getting tenant: '.$e->getMessage());
                }
                return redirect()->route('user.bank')->with('toast_success', 'Successfully added your Xero account ');
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    public function dopost($url, $params)
    {
        try {
            $client = new Client;

            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'authorization' => "Basic ".base64_encode(config('xero.clientId').":".config('xero.clientSecret'))
            ];

            $response = $client->post($url, [
                'headers' => $headers,
                'form_params' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function storeToken($token, $tenantData)
    {
        $data = [
            'id_token'      => $token['id_token'],
            'access_token'  => $token['access_token'],
            'expires_in'    => $token['expires_in'],
            'token_type'    => $token['token_type'],
            'refresh_token' => $token['refresh_token'],
            'scopes'        => $token['scope'],
            'uuid'          => Auth::user()->id,
            'active'        => 1
        ];

        if ($tenantData != null) {
            $data = array_merge($data, $tenantData);
        }

        //create a new record or if the user id exists update record
        return XeroConnections::updateOrCreate(['uuid' => Auth::user()->id], $data);
    }
    public function callBackXero(){
        return XeroConnections::where('uuid',Auth::user()->id);
    }

    public function disconnectXero(){
        XeroConnections::where('uuid',Auth::user()->id)->update([
            'active' => 0
        ]);

        return redirect()->route('user.bank')->with('toast_success', 'Successfully removed Xero account ');
    }

    public function getUserPermissions(Request $request)
    {
        $user = User::find(auth()->guard('user')->user()->id);
        $data['title']='List user approved Consent';
        $data['consents'] = $this->tellConnectService->getUserApprovedConsents($user->id);
        // \Log::info(json_encode($data['consents']));
        return view('user.profile.openbanking-permissions', $data);

    }


    public function revokeUserPermissions($id)
    {
        $data['title']='Revoke user approved Consent';
        $data['consents'] = $this->tellConnectService->revokeUserApprovedConsents($id);
        // \Log::info(json_encode($data['consents']));
        return redirect()->route('openbanking.permissions');

    }
}
