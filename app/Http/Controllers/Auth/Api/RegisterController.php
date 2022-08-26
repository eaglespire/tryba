<?php

namespace App\Http\Controllers\Auth\Api;

use App\Models\User;
use App\Models\Settings;
use App\Models\Country;
use App\Models\Sub;
use App\Models\Countrysupported;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\SendEmail;
use App\Jobs\SendSms;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function list_supported_countries()
    {
        $country = Countrysupported::wherestatus(1)->with('real')->with('coin')->get(); 
        return response($country, 201);
    }        
    public function list_countries()
    {
        $country=Country::all();
        return response($country, 201);
    }     
    
    public function supported_countries($id)
    {
        $country=Country::whereid($id)->first();
        $response=[
            'nicename'=>$country->nicename,
            'phonecode'=>$country->phonecode
            ];
        return response($response, 201);
    }     
    
    public function submitregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required',
            "country" => "required|exists:country,id"
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(),'status' => 'failed','data' => null], 400);
        }
        $set = Settings::first();
        $country = Country::whereid($request->country)->first();
        $email_verify = 0;
        $phone_verify = 0;
        $country_supported = Countrysupported::wherecountry_id($request->country)->first();
        $verification_code = strtoupper(Str::random(6));
        $sms_code = strtoupper(Str::random(6));
             
        try{
            $phone = PhoneNumber::make($request->phone, $country->iso)->formatE164();
            $user = new User();
            $user->image = 'person.png';
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->middle_name = ($request->has('middle_name')) ? $request->middle_name : NULL;
            $user->business_name = $request->business_name;
            $user->phone = $phone;
            $user->country = $request->country;
            $user->pay_support = $country_supported->id;
            $user->email = $request->email;
            $user->email_verify = $email_verify;
            $user->phone_verify = $phone_verify;
            $user->phone_time = Carbon::parse()->addMinutes(5);
            $user->sms_code = $sms_code;
            $user->verification_code = $verification_code;
            $user->email_time = Carbon::parse()->addMinutes(5);
            $user->balance = $country_supported->rate*$set->balance_reg;
            $user->ip_address = user_ip();
            $user->password = Hash::make($request->password);
            $user->public_key='pub-live-'.Str::random(32);        
            $user->secret_key='sec-live-'.Str::random(32);                
            $user->test_public_key='pub-test-'.Str::random(32);        
            $user->test_secret_key='sec-test-'.Str::random(32);  
            $user->last_login=Carbon::now();
            $user->live=1;
            $user->save();
            $user->plan_id = null;
            $user->auto_renewal = 0;
            $user->plan_transactions = 0;
            $user->plan_payments = 0;
            $user->plan_expired = 0;
            $user->plan_type= NULL;
            $user->plan_expiring = NULL;
            $user->email_limit = 0;
            $user->sms_limit = 0;
            $user->used_transactions = null;
            $user->used_payments = null;
            $user->save();
        }catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);
        }catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
            return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);
        }catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
            return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);          
        }catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
            return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);
        }
        if ($set->email_verification == 1) {
            $gg=[
                'email'=>$user->email,
                'name'=>$user->first_name.' '.$user->last_name,
                'subject'=>'We need to verify your email address',
                'message'=>'Thanks you for signing up to Tryba.<br> As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.<br><a href='.route('user.confirm-email', ['id'=>$verification_code]).'>'.route('user.confirm-email', ['id'=>$verification_code]).'</a>'
            ];
            Mail::to($gg['email'], $gg['name'])->send(new SendEmail($gg['subject'], $gg['message']));
        }
        if ($set->sms_verification == 1) {
            $message = "Your phone verification code is: $user->sms_code";
            dispatch_sync(new SendSms($user->phone, strip_tags($message)));
        }
        $user->payment=0;
        $user->payout=0;
        $user->due=0;
        $user->save();

        return response()->json(['message' => 'Successfully registered user','status' => 'success'], 200);
        
    }    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
