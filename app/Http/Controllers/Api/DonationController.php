<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\User;
use App\Models\Settings;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Audit;
use App\Models\Paymentlink;
use App\Models\Transactions;
use App\Models\Charges;
use App\Models\Donations;
use App\Models\History;
use Carbon\Carbon;
use App\Models\Countrysupported;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{  
    
   public function donors($id)
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->donation==1){
            $data['title'] = "Donors";
            $data['donors']=Donations::wheredonation_id($id)->wherestatus(1)->get();
            return response()->json(['message' => 'success','data' => $data], 201);
        }else{
            return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    }   
    
    public function dplinks()
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        if($set->donation==1){
            if($xf->donation==1){
                $title = "Mutiple Pot";
                $links = Paymentlink::whereuser_id(Auth::user()->id)->wheretype(2)->wheremode($mode)->orderby('created_at', 'desc')->get();
                $AllLinks = $links->map(function ($item, $key) {
                    $item->url = route('pot.link', ['id' => $item->ref_id]);
                    return $item;
                });
                $data = [
                    'title' => $title,
                    'links' => $AllLinks
                ];
                return response()->json(['message' => 'success','data' => $data], 201);
            }else{
                return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
            }
        }else{
            return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    }
    
    public function dplinkstrans($id){

        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        if($set->donation==1){
            if($xf->donation==1){
                $link = Paymentlink::whereid($id)->whereuser_id(Auth::user()->id)->wheretype(2)->wheremode($mode)->orderby('created_at', 'desc')->firstorFail();
                $link->url = route('pot.link', ['id' => $link->ref_id]);
                return response()->json(['message' => 'success','data' => $link], 201);
            }else{
                return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
            }
        }else{
            return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }

    }

    public function Destroylink($id)
    {
        $link=Paymentlink::whereid($id)->first();
        $history=Transactions::wherepayment_link($id)->delete();
        $check=Donations::wheredonation_id($id)->get();
        foreach($check as $val){
            Donations::whereid($val->id)->delete();
        }
        $data=$link->delete();
        if ($data) {
            return response()->json(['message' => 'Pot was Successfully deleted','status' => 'success','data' => null], 201);
        } else {
            return response()->json(['message' => 'Problem With Deleting Pot','status' => 'failed','data' => null], 400);
        }
    }
       
    public function updatedplinks(Request $request,$id)
    {
        $set=Settings::first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        if($set->donation==1){
            $validator = Validator::make( $request->all(),
            [
                'amount'=>'required',
                'description'=>'required',
                'name'=>'required',
            ]
            );
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()],422);
            }
            $currency=Countrysupported::whereid(Auth::user()->pay_support)->first();
            $data=Paymentlink::whereid($id)->wheremode($mode)->firstorFail();
            $data->amount = $request->amount;
            $data->description = $request->description;
            $data->name = $request->name;
            $data->currency=$currency->coin_id; 
            $data->save();

            return response()->json(['message' => 'Pot was successfully updated','status' => 'success','data' => null], 201);
        }else{
           return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    }  
    public function submitdonationpage(Request $request)
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        if($set->donation == 1){
            $validator = Validator::make($request->all(),
            [
                'description'=>'required',
                'name'=>'required',
                'amount' => 'required|numeric'
            ]
            );
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()],422);
            }
            $currency=Countrysupported::whereid(Auth::user()->pay_support)->first();
            $trx='POT-'.str_random(6);
            $sav['ref_id']=$trx;
            $sav['type']=2;
            $sav['amount']=$request->amount;
            $sav['name']=$request->name;
            $sav['description']=$request->description;
            $sav['user_id']=Auth::user()->id; 
            $sav['currency']=$currency->coin_id; 
            $sav['mode']=$mode;  
            Paymentlink::create($sav);   
            $audit['user_id']=Auth::user()->id;
            $audit['trx']=$trx;
            $audit['log']='Created Multiple pot - '.$trx;
            Audit::create($audit);
            $his['user_id']=Auth::user()->id;
            $his['ref']=$trx;
            $his['main']=1;
            History::create($his);
            return response()->json(['message' => 'Mutiple Pot was Successfully created','status' => 'success','data' => $sav], 201);
        }else{
            $data['title']='Error Message';
            return response()->json(['message' => 'Pot is currently unavailable','status' => 'failed','data' => null], 201);
        }
    }

    public function deactivate($id){
        $set=Settings::first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        $xf = Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->donation==1){
            $page=Paymentlink::whereid($id)->wheremode($mode)->firstorFail();
            $page->active=0;
            $page->save();
            return response()->json(['message' => 'Pot has been disabled','status' => 'success','data' => null], 201);
        }else{
           return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    }

    public function activate($id){
        $set=Settings::first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        $xf = Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->donation==1){
            $page=Paymentlink::whereid($id)->wheremode($mode)->firstorFail();
            $page->active=1;
            $page->save();
            return response()->json(['message' => 'Pot has been activated','status' => 'success','data' => null], 201);
        }else{
           return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    }
}