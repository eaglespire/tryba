<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Settings;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Audit;
use App\Models\Paymentlink;
use App\Models\Transactions;
use App\Models\Charges;
use App\Models\History;
use App\Models\Countrysupported;
use App\Models\Donations;
use Illuminate\Support\Facades\Redirect;
use Stripe\StripeClient;

class SinglechargeController extends Controller
{       
    public function sclinks()
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        if($set->donation==1){
            if($xf->donation==1){
                $title = "Pot";
                $links = Paymentlink::whereuser_id(Auth::user()->id)->wheretype(1)->wheremode($mode)->orderby('id', 'desc')->get();
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

    public function pottransactions($id)
    {
        $set=Settings::first();
        $data['title'] = "Transactions";
        $trans=Transactions::wherepayment_link($id)->wheremode(1)->latest()->get();
        return response()->json(['message' => 'success','data' => $trans], 201);
    }

    public function unsclinks($id)
    {
        $set=Settings::first();
        $mode = (Auth::user()->live==0) ? 0 : 1;
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->donation==1){
            $page=Paymentlink::whereid($id)->wheremode($mode)->first();
            $page->active=0;
            $page->save();
            return response()->json(['message' => 'Pot has been disabled','status' => 'success','data' => null], 201);
        }else{
           return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    } 

    public function psclinks($id)
    {
        $set=Settings::first();
        if(Auth::user()->live==0){$mode=0;}else{$mode=1;}
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->donation==1){
            $page=Paymentlink::whereid($id)->wheremode($mode)->first();
            $page->active=1;
            $page->save();
            return response()->json(['message' => 'Pot has been activated','status' => 'success','data' => null], 201);
        }else{
            $data['title']='Error Message';
           return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }
    } 

    public function updatesclinks(Request $request,$id)
    {
        $set=Settings::first();
        $mode = (Auth::user()->live == 0) ? 0 : 1;
        if($set->donation==1){
            $validator = Validator::make( $request->all(),
            [
                'description'=>'required',
                'name'=>'required',
                'amount' => 'required|numeric'
            ]
            );
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()],422);
            }
            $currency = Countrysupported::whereid(Auth::user()->pay_support)->first();
            $data = Paymentlink::whereId($id)->wheremode($mode)->first();
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

    public function submitsinglecharge(Request $request)
    {
        $set = Settings::first();
        $mode = (Auth::user()->live == 0) ? 0 : 1;
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
            $currency = Countrysupported::whereid(Auth::user()->pay_support)->first();
            $trx = 'POT-'.str_random(6);
            Paymentlink::create([
                'ref_id' =>  $trx,
                'type' => 1,
                'amount' => $request->amount,
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'currency' => $currency->coin_id,
                'mode' => $mode
            ]);   
            $audit['user_id']=Auth::user()->id;
            $audit['trx'] = str_random(16);
            $audit['log'] = 'Created Single Pot - '.$trx;
            Audit::create($audit);
            $his['user_id']= Auth::user()->id;
            $his['ref']= $trx;
            $his['main']=1;
            History::create($his);
            return response()->json(['message' => 'Pot was Successfully created','status' => 'success','data' => null], 201);
        }else{
           return response()->json(['message' => 'Pot is not available for your country','status' => 'failed','data' => null], 400);
        }   
    }

    public function Destroylink($id)
    {
        $mode = (Auth::user()->live == 0) ? 0 : 1;
        $link = Paymentlink::whereid($id)->wheremode($mode)->first();
        Transactions::wherepayment_link($id)->delete();
        $data=$link->delete();
        if ($data) {
            return response()->json(['message' => 'Pot was Successfully deleted','status' => 'success','data' => null], 201);
        } else {
            return response()->json(['message' => 'Problem With Deleting Pot','status' => 'failed','data' => null], 400);
        }
    }


}