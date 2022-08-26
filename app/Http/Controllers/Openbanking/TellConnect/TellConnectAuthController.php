<?php

namespace App\Http\Controllers\Openbanking\TellConnect;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Settings;
use Carbon\Carbon;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Services\TellConnectService;

class TellConnectAuthController extends Controller
{
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;
    protected $service;

    public function __construct(TellConnectService $service)
    {
        $this->middleware('guest');
        $this->middleware('guest:user');
        $this->service = $service;

    }

    public function login(Request $request)
    {
		$data['title']='Login';
        $data['consent'] = $this->service->getCustomerConsent($request);
        return view('/open-banking/login', $data);
    }

    public function attemptLogin(Request $request)
    {
        $set=Settings::first();
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
            // adding an extra field 'error'...
            $data['title']='Login';
            $data['errors']=$validator->errors();
            return view('auth.login', $data);
        }
        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::guard('tellConnect')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
        	$user=User::whereid(Auth::guard('tellConnect')->user()->id)->first();
	        $user->last_login=Carbon::now();
	        $user->ip_address=user_ip();
            $user->save();
            session()->put('locale', $user->language);
            session()->forget('uniqueid');
            return redirect()->route('approve.consent', ['consentId', $request->input('consentId')]);
        } else {
        	return back()->with('toast_warning', 'Oops! You have entered invalid credentials');
        }

    }

    public function approveConsent(Request $request)
    {
        $data['title']='Approve Consent';
        $data['consent'] = $this->service->getCustomerConsent($request);
        return view('/open-banking/approve-consent', $data);

    }

    public function consentDecision(Request $request, $consentId, $decision)
    {
        $resp = $this->service->decideCustomerConsent($request, $consentId, $decision);
        $data['consent'] = $resp['consent'];
        $data['account_number'] = $resp['account_number'];
        $data['title']='Consent ' . $data['consent']->ConsentStatus;
        if(isset($data['response']->location) && $data['response']->location !==null ){
            if ($data['response']->location !== 'na'){
                return redirect::to($data['response']->location);
            }
        }
        return view('/open-banking/approved-consent', $data);

    }

    public function getUserPermissions(Request $request)
    {
        $data['title']='Approve Consent';
        $data['consents'] = $this->service->getCustomerConsent($request);
        return view('user.profile.openbanking-permissions', $data);

    }

}
