<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Settings;
use Carbon\Carbon;
use App;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */



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

    public function login()
    {
		$data['title']='Login';
        return view('/auth/login', $data);
    }

    public function submitlogin(Request $request)
    {
        $set = Settings::first();
        if($set->recaptcha==1){
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required',
                'g-recaptcha-response' => 'required|captcha'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required'
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(),'status' => 'failed','data' => null], 400);
        }
        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
        	$user = User::whereid(Auth::guard('user')->user()->id)->first();
	        $user->last_login=Carbon::now();
	        $user->ip_address=user_ip();
            $user->save();
            FacadesApp::setLocale($user->language);
            session()->put('locale', $user->language);
            session()->forget('uniqueid');
            if($user->fa_status==1){
                return response()->json(['message' => 'redirect','status' => 'success','data' => $user,'doubleAuth'=> true], 200);
            }else{
                return response()->json(['message' => 'redirect','status' => 'success','data' => $user,'doubleAuth'=> false], 200);
            }
        } else {
            return response()->json(['message' => 'Oops! You have entered invalid credentials','status' => 'failed','data' => null], 422);
        }

    }

    public function redirectHome(){
        if(Auth::user()){
            return redirect()->route('user.dashboard');
        }
        $set = Settings::first();
        $data['title'] = $set->title;
        $data['plans'] = SubscriptionPlan::all();
        return view('front.index2', $data);
    }

}
