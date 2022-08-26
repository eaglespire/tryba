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

class TellConnectOperationsController extends Controller
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

    public function performTransaction(Request $request)
    {
        if($request->has('Info')){
            $user = User::whereid($request->Info['UserId'])->first();
            if(isset($user) && !empty($user)){
                $resp = $this->service->performTransaction($request, $user);
                if(isset($resp)){
                
                    if($resp['status'] == 400 ){
                        return response()->json($resp['body'], 400);

                    }
                    if($resp['status'] == 200 ){
                        return response()->json($resp['body'], 200);

                    }
                    if($resp['status'] == 500 ){
                        return response()->json($resp['body'], 500);

                    }
                } else {
                    return response()->json(['error' => 'We encountered a server/processing error, do try again in a few minutes'], 500);
                }
            } 
            else {
                return response()->json(['error' => 'We could not find the user specified with the request'], 500);
            }
        }
        else {
            return response()->json(['error' => 'The request is not properly formed', 'data'=>$request->Info], 500);
        }
    }

}
