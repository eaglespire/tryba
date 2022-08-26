<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Admin;
use Curl\Curl;


class SettingController extends Controller
{

    public function Settings()
    {
        $data['title']='General settings';
        $data['val']=Admin::first();
        return view('admin.settings.index', $data);
    }           

    public function SettlementUpdate(Request $request)
    {
        $data = Settings::findOrFail(1);
        $data->fill($request->all())->save();
        return back()->with('toast_success', 'Update was Successful!');
    } 

    public function AccountUpdate(Request $request)
    {
        $data = Admin::whereid(1)->first();
        $data->username=$request->username;
        $data->password=Hash::make($request->password);
        $data->save();
        return back()->with('toast_success', 'Update was Successful!');
    }  
        
    public function SettingsUpdate(Request $request)
    {
        $data = Settings::findOrFail(1);
        $data->fill($request->all())->save();
        /*
        $set = Settings::findOrFail(1);
        $curl = new Curl();
        $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
        $curl->setHeader('Authorization', 'Basic '.$authToken);
        $curl->setHeader('Content-Type', 'application/json');
        $datas=[
            'name'=> 'freelancer ',
            'description'=> 'freelancing payment system',
            'type'=> 'SERVICE',
            'category'=> 'SOFTWARE',
        ];
        $curl->post("https://api-m.sandbox.paypal.com/v1/catalogs/products", $datas);
        $response = $curl->response;
        $curl->close();  
        $set->paypal_productid=$response->id;
        $set->save();
        */
        return back()->with('toast_success', 'Update was Successful!');
    }    
    
    public function SavingsUpdate(Request $request)
    {
        $data = Settings::findOrFail(1);
        $data->fill($request->all())->save();
        return back()->with('toast_success', 'Update was Successful!');
    }

    public function Features(Request $request)
    {
        $data = Settings::findOrFail(1);  
        if(empty($request->email_activation)){
            $data->email_verification=0;	
        }else{
            $data->email_verification=$request->email_activation;
        } 
        if(empty($request->sms_activation)){
            $data->sms_verification=0;	
        }else{
            $data->sms_verification=$request->sms_activation;
        }             
        if(empty($request->email_notify)){
            $data->email_notify=0;	
        }else{
            $data->email_notify=$request->email_notify;
        }      
        if(empty($request->registration)){
            $data->registration=0;	
        }else{
            $data->registration=$request->registration;
        }                   
        if(empty($request->merchant)){
            $data->merchant=0;	
        }else{
            $data->merchant=$request->merchant;
        }         
        if(empty($request->recaptcha)){
            $data->recaptcha=0;	
        }else{
            $data->recaptcha=$request->recaptcha;
        }           
        if(empty($request->subscription)){
            $data->subscription=0;	
        }else{
            $data->subscription=$request->subscription;
        }                    
        if(empty($request->invoice)){
            $data->invoice=0;	
        }else{
            $data->invoice=$request->invoice;
        }          
        if(empty($request->store)){
            $data->store=0;	
        }else{
            $data->store=$request->store;
        }           
        if(empty($request->donation)){
            $data->donation=0;	
        }else{
            $data->donation=$request->donation;
        }                      
        if(empty($request->stripe_connect)){
            $data->stripe_connect=0;	
        }else{
            $data->stripe_connect=$request->stripe_connect;
        }        
        if(empty($request->kyc_restriction)){
            $data->kyc_restriction=0;	
        }else{
            $data->kyc_restriction=$request->kyc_restriction;
        }         
        if(empty($request->country_restriction)){
            $data->country_restriction=0;	
        }else{
            $data->country_restriction=$request->country_restriction;
        }    
        $res=$data->save();
        if ($res) {
            return back()->with('toast_success', 'Update was Successful!');
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    }      
    
    public function charges(Request $request)
    {
        $data = Settings::findOrFail(1);
        $data->fill($request->all())->save();
        return back()->with('toast_success', 'Update was Successful!');
    }    
 
}
