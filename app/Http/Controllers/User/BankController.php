<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\User;
use App\Models\Settings;
use App\Models\Bank;
use App\Models\Withdraw;
use App\Models\Gateway;
use App\Models\History;
use App\Models\Subaccounts;
use App\Models\Countrysupported;
use Carbon\Carbon;
use Curl\Curl;


class BankController extends Controller
{ 
        public function index()
        {
            $user=User::find(Auth::guard('user')->user()->id);
            $country_supported=Countrysupported::whereid($user->pay_support)->first();
            if($user->bank_status==1){
                if($user->applicant_id==null){
                    $reg=[
                        "request_type"=>"web-sdk",
                        "kyc_consent"=>true,
                        "partner_product"=>"Railsbank-KYC-1",
                        "referrer"=>route('user.banking.kyc')
                    ];
                    $curl = new Curl();
                    $curl->setHeader('Authorization', 'API-Key ' .$country_supported->rail_apikey);
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->setHeader('Accept', 'application/json');
                    $curl->post($country_supported->rail_baseurl."/customer/endusers/".$user->end_user."/kyc-checks", $reg);
                    $response = $curl->response;
                    $curl->close();
                    if ($curl->error) {
                        $data['title']='Error Message';
                        return view('user.merchant.error', $data)->withErrors($response->error);
                    }else{
                        $user->applicant_id=$response->applicant_id;
                        $user->sdk_token=$response->sdk_token;
                        $user->kyc_id=$response->kyc_id;
                        $user->save();
                    }
                }
            }else{
                $data['title']='Bank Services';
                $data['sdk_token']=$user->sdk_token;
                return view('user.profile.banking', $data);
            }
        }
}