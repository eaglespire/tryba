<?php

namespace App\Http\Controllers\Auth;

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
use Illuminate\Support\Facades\Session;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Curl\Curl;
use App\Mail\SendEmail;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Mail;
use App\Jobs\EmailVerificationJob;

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
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:user');
    }

    public function register()
    {
        if(Auth::user()){
            return redirect()->route('user.dashboard');
        }
        $set = Settings::first();
        $data['title'] = $set->title;
        $data['plans'] = SubscriptionPlan::all();
        return view('front.index2', $data);
    }

    public function individualregister()
    {
        $data['title']='Register';
        $data['country'] = $country = Country::whereid(Session::get('country'))->first();
        $data['all']=Country::all();
        return view('auth.type.individual', $data);
    }

    public function businessregister()
    {
        $data['title']='Register';
        $data['country']=$country=Country::whereid(Session::get('country'))->first();
        $data['all']=Country::all();
        return view('auth.type.business', $data);
    }

    public function preregister(Request $request)
    {
        Session::put('country', $request->country);
        Session::put('mcc', $request->mcc);
        return redirect()->route('individual.register');
    }

    public function submitregister(Request $request)
    {
        $set = Settings::first();
        $country = Country::whereid($request->country)->first();
        $email_verify = 0;
        $phone_verify = 0;
        $country_supported = Countrysupported::wherecountry_id($request->country)->first();
        $verification_code = strtoupper(Str::random(32));
        $sms_code = strtoupper(Str::random(6));
        $customMessages = [
            'email.unique' => 'This email is already in use',
            'phone.unique'  => 'This phone number is already in use',
            'terms' => "Check the terms and conditions"
         ];
        if($set->recaptcha==1){
            $rules=[
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|same:password',
                'g-recaptcha-response' => 'required|captcha',
                'terms' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json(['message' =>$validator->errors()->first(),'status' => 'failed','data' => null], 400);
            }
        }else{
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'terms' => 'required|boolean',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json(['message' =>$validator->errors()->first(),'status' => 'failed','data' => null], 400);
            }
        }
        try{
           $answer =  $this->email_verification($request->email);

           $phone = PhoneNumber::make($request->phone, $country->iso)->formatE164();
           $user = new User();
           $user->image = 'person.png';
           $user->first_name = ucwords(strtolower($request->first_name));
           $user->last_name = ucwords(strtolower($request->last_name));
           $user->middle_name = ($request->has('middle_name')) ? ucwords(strtolower($request->middle_name)) : NULL;
           $user->business_name = $request->business_name;
           $user->mcc = $request->mcc;
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
           $user->live=0;
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
           $user->used_transactions = 0;
           $user->used_payments = 0;
           $user->save();
            // if($answer->valid == true ){
            // }else{
            //     return response()->json(['message' =>"Please enter a valid email",'status' => 'failed','data' => null], 400);
            // }
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
            dispatch_sync(new EmailVerificationJob($user, $verification_code));
        }
        $user->payment = 0;
        $user->payout = 0;
        $user->due = 0;

        $user->save();
        if (Auth::guard('user')->attempt(['email' => $request->email,'password' => $request->password,])){
            Session::put('waitlist', $user->id);
            return response()->json(['message' => "successfully registered user",'status' => 'sucesss','data' => null], 200);
        }
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
