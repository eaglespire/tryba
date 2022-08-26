<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\IVRService;

class IVRController extends Controller
{
    protected $service;

    public function __construct(IVRService $service)
    {
        $this->middleware('guest');
        $this->middleware('guest:user');
        $this->service = $service;
    }

    public function demo(Request $request){
        return $this->service->demo($request);
    }

    public function welcome(){
        return $this->service->showWelcome();
    }


    public function ivrMenu(Request $request){
        return $this->service->ivrMenu($request);        
    }

    public function cardOperations(Request $request){
        return $this->service->cardOperations($request);        
    }

    public function blockUnblockCard(Request $request){
        return $this->service->cardOperations($request);        
    }

    public function getNumber(Request $request){
        return $this->service->getNumber($request);        
    }

    public function verifyNumber(Request $request){
        return $this->service->verifyNumber($request);        
    }

    public function openAccount(Request $request){
        return $this->service->openAccount($request);        
    }

    public function getPin($phone){
        return $this->service->getPin($phone);        
    }
    
    public function verifyPin(Request $request, $phone){
        return $this->service->verifyPinAndBlockCard($request, $phone);        
    }

    public function otherContact(Request $request){
        return $this->service->otherEnquiriesContactInfo($request);        
    }

}

