<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Session;
use Redirect;

class LoginController extends Controller
{
    protected $maxAttempts = 1;
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
    public function submitlogin(Request $request)
    {
        $set=$data['set']=Settings::first();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(),'status' => 'failed','data' => null], 400);
        }
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
        	$ip_address=user_ip();
        	$user=User::whereid(Auth::guard('user')->user()->id)->first();
	        $user->last_login=Carbon::now();
	        $user->ip_address = $ip_address;
	        $token = $user->createToken('my-app-token')->plainTextToken;
            $user->save();
            session()->forget('uniqueid');
            $response=[
                'token' => $token,
                'user' => $user,
                ];
            return response($response, 201);
        } else {
        	return response()->json(['message' => 'Invalid credentials','status' => 'failed','data' => null], 400);
        }

    }

}
