<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Settings;
use App\Models\Audit;
use App\Models\Paymentlink;
use App\Models\Transactions;
use App\Models\History;
use App\Models\Countrysupported;
use App\Models\Donations;
use Illuminate\Support\Facades\Redirect;
use Curl\Curl;
use Stripe\StripeClient;
use Image;
use Carbon\Carbon;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendPaymentEmail;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SinglechargeController extends Controller
{       
    public function sortsclinks(Request $request)
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            if($xf->donation==1){
                $data['title'] = "Pot";
                $data['status'] = $request->status;
                $data['type'] = $request->type;
                $data['limit'] = $request->limit;
                $data['order'] = $request->date;
                $date=explode('-', $request->date);
                $from=Carbon::create($date[0])->toDateString();
                $to=Carbon::create($date[1])->toDateString();
                if($request->status=="0" && $request->type=="0"){
                    $data['links']=Paymentlink::whereBetween('created_at', [$from, $to])->whereuser_id(Auth::guard('user')->user()->id)->wheremode($mode)->paginate($data['limit']);
                }elseif($request->status=="0" && $request->type!="0"){
                    $data['links']=Paymentlink::whereBetween('created_at', [$from, $to])->wheretype($request->type)->wheremode($mode)->whereuser_id(Auth::guard('user')->user()->id)->paginate($data['limit']);
                }elseif($request->status!="0" && $request->type!="0"){
                    $data['links']=Paymentlink::whereBetween('created_at', [$to, $from])->wheretype($request->type)->wheremode($mode)->whereactive($request->status)->whereuser_id(Auth::guard('user')->user()->id)->paginate($data['limit']);
                }elseif($request->status!="0" && $request->type=="0"){
                    $data['links']=Paymentlink::whereBetween('created_at', [$from, $to])->whereuser_id(Auth::guard('user')->user()->id)->whereactive($request->status)->wheremode($mode)->paginate($data['limit']);
                }

                return view('user.link.sc', $data);
            }else{
                $data['title']='Error Message';
                return view('user.merchant.error', $data)->withErrors('Pot is not available for your country');
            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }   
    public function sclinks()
    {
        $set = Settings::first();
        $xf = Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        $mode = (Auth::guard('user')->user()->live == 0) ? 0 : 1 ;
        if($set->donation == 1){
            if($xf->donation == 1){
                $data['title'] = "Gigpot";
                $data['status'] = 0;
                $data['type'] = 0;
                $data['limit'] = 10;
                $data['links']=Paymentlink::whereuser_id(Auth::guard('user')->user()->id)->wheremode($mode)->latest()->paginate($data['limit']);
                if(count($data['links'])>0){
                $first = Paymentlink::whereuser_id(Auth::guard('user')->user()->id)->wheremode($mode)->orderby('created_at', 'desc')->first();
                $last = Paymentlink::whereuser_id(Auth::guard('user')->user()->id)->wheremode($mode)->orderby('created_at', 'asc')->first();
                $data['order'] = date("m/d/Y", strtotime($last->created_at)).' - '.date("m/d/Y", strtotime($first->created_at));
                }else{
                    $data['order'] = null;
                }
                return view('user.link.sc', $data);
            }else{
                $data['title']='Error Message';
                return view('user.merchant.error', $data)->withErrors('Pot is not available for your country');
            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }
    public function sclinkstrans($id)
    {
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            $data['title'] = "Transactions";
            $data['id']=$id;
            $data['status']="3";
            $data['method']="0";
            $data['trans']=Transactions::wherepayment_link($id)->wherearchive(0)->wheremode($mode)->latest()->get();
            $data['archivesum']=Transactions::wherepayment_link($id)->wherearchive(1)->wheremode($mode)->latest()->count();
            if(count($data['trans'])>0){
            $first=Transactions::wherepayment_link($id)->wherearchive(0)->wheremode($mode)->limit(1)->orderby('created_at', 'desc')->first();
            $last=Transactions::wherepayment_link($id)->wherearchive(0)->wheremode($mode)->limit(1)->orderby('created_at', 'asc')->first();
            $data['order'] = date("m/d/Y", strtotime($last->created_at)).' - '.date("m/d/Y", strtotime($first->created_at));
            }else{
                $data['order']=null;
            }
            return view('user.link.sc-trans', $data);
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }      
    public function sclinkscontributors($id)
    {
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            $data['title'] = "Contributors";
            $data['donors']=Donations::wheredonation_id($id)->wherestatus(1)->latest()->get();
            return view('user.link.sc-contributors', $data);
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }  
    public function archivesclinkstrans($id)
    {
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            $data['title'] = "Transactions";
            $data['id']=$id;
            $data['status']="3";
            $data['method']="0";
            $data['trans']=Transactions::wherepayment_link($id)->wherearchive(1)->wheremode($mode)->latest()->get();
            $first=Transactions::wherepayment_link($id)->wherearchive(0)->wheremode($mode)->limit(1)->orderby('created_at', 'desc')->first();
            $last=Transactions::wherepayment_link($id)->wherearchive(0)->wheremode($mode)->limit(1)->orderby('created_at', 'asc')->first();
            $data['order'] = date("m/d/Y", strtotime($last->created_at)).' - '.date("m/d/Y", strtotime($first->created_at));
            return view('user.link.sc-trans-archive', $data);
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }
    public function sorttransactions(Request $request)
    {
        $set=Settings::first();
        $user=Auth::guard('user')->user()->id;
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $data['title'] = "Transactions";
        $data['status'] = $request->status;
        $data['method'] = $request->method;
        $data['order'] = $request->date;
        $data['id']=$request->id;
        $date=explode('-', $request->date);
        $from=Carbon::create($date[0])->toDateString();
        $to=Carbon::create($date[1])->toDateString();
        if($request->method=="0"){
            $data['trans']=Transactions::wherepayment_link($request->id)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
            $data['archivesum']=Transactions::wherepayment_link($request->id)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
        }elseif($request->method!="0"){
            $data['trans']=Transactions::wherepayment_link($request->id)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
            $data['archivesum']=Transactions::wherepayment_link($request->id)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
        }
        return view('user.link.sc-trans', $data);
    }        
    public function sortarchivetransactions(Request $request)
    {
        $set=Settings::first();
        $user=Auth::guard('user')->user()->id;
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $data['title'] = "Transactions";
        $data['status'] = $request->status;
        $data['method'] = $request->method;
        $data['order'] = $request->date;
        $data['id']=$request->id;
        $date=explode('-', $request->date);
        $from=Carbon::create($date[0])->toDateString();
        $to=Carbon::create($date[1])->toDateString();
        if($request->method=="0"){
            $data['trans']=Transactions::wherepayment_link($request->id)->wherearchive(1)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherestatus($request->status)->wheremode($mode)->latest()->get();
            $data['archivesum']=Transactions::wherepayment_link($request->id)->wherearchive(1)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
        }elseif($request->method!="0"){
            $data['trans']=Transactions::wherepayment_link($request->id)->wherearchive(1)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherestatus($request->status)->wheremode($mode)->latest()->get();
            $data['archivesum']=Transactions::wherepayment_link($request->id)->wherearchive(1)->whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
        }
        return view('user.link.sc-trans-archive', $data);
    }    
    public function unsclinks($id)
    {
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if($set->donation==1){
            $page=Paymentlink::whereid($id)->wheremode($mode)->first();
            $page->active=0;
            $page->save();
            return back()->with('toast_success', 'Pot has been disabled.');
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    } 
    public function psclinks($id)
    {
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if($set->donation==1){
            $page=Paymentlink::whereid($id)->wheremode($mode)->first();
            $page->active=1;
            $page->save();
            return back()->with('toast_success', 'Pot has been activated.');
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    } 
    public function updatesclinks(Request $request)
    {
        $validator = Validator::make( $request->all(),
        [
            'description'=>'required'
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $currency=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if($set->donation==1){
            $data = Paymentlink::whereref_id($request->id)->first();
            $data->amount = ($request->amount > 1) ? $request->amount : NULL;
            $data->description = $request->description;
            $data->name = $request->name;
            $data->currency=$currency->coin_id; 
            if($request->has('avatar')){
                $fileUrl = Cloudinary::uploadFile($request->file('avatar')->getRealPath())->getSecurePath();
                $data->image = $fileUrl;
            }
            $data->save();
            return redirect()->route('user.sclinks')->with('toast_success', 'Pot was successfully updated');
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }  

    public function submitsinglecharge(Request $request)
    {
        $validator = Validator::make( $request->all(),
        [
            'description'=>'required',
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            $currency=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
            $amount=$request->amount;
            $user=User::find(Auth::guard('user')->user()->id);
            $trx='POT-'.str_random(6);
            $sav['ref_id']=$trx;
            $sav['type']=1;
            $sav['amount']=$request->amount;
            $sav['name']=$request->name;
            $sav['description']=$request->description;
            $sav['user_id']=$user->id; 
            $sav['currency']=$currency->coin_id; 
            $sav['mode']=$mode; 
            Paymentlink::create($sav);   
            $audit['user_id']=Auth::guard('user')->user()->id;
            $audit['trx']=str_random(16);
            $audit['log']='Created Pot - '.$trx;
            Audit::create($audit);
            $his['user_id']=$user->id;
            $his['ref']=$trx;
            $his['main']=1;
            History::create($his);
            return redirect()->route('user.sclinks')->with('toast_success', 'Pot was successfully created');
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }   
    }

    public function Destroylink($id)
    {
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $link=Paymentlink::whereid($id)->wheremode($mode)->first();
        $history=Transactions::wherepayment_link($id)->delete();
        $data=$link->delete();
        if ($data) {
            return back()->with('toast_success', 'Pot was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Pot');
        }
    }

    public function gigpotLink($id)
    {
        $set=Settings::first();
        $key = Paymentlink::whereref_id($id)->firstorFail();
        $user = User::find($key->user_id);
        $mode = ($user->live==0) ? 0 : 1;
        $xf = Countrysupported::whereid($user->pay_support)->first();
        if($user->status == 0 && $user->isBlocked == false && $key->status == 0 && $key->active == 1 && $user->kyc_verif_status=="APPROVED" ){
            $data['link']=$key;
            $data['merchant']= $user;
            $data['title']= "Pot";
            $data['donated'] = Donations::wheredonation_id($key->id)->wherestatus(1)->sum('amount');
            $data['paid'] = Donations::wheredonation_id($key->id)->wherestatus(1)->latest()->paginate(5);
            if($key->mode == 1){
                if($key->type == 1){
                    if((!empty($user->gBPAccount()->accountNumber) AND !empty($user->gBPAccount()->sortCode))|| (!empty($user->paypal_client_id) && !empty($user->paypal_secret_key))){
                        return view('user.link.sc_view_card', $data);
                    }else{
                        $data['title']='Error';
                        return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                    }
                }elseif($key->type == 2){  
                    if((!empty($user->gBPAccount()->accountNumber) AND !empty($user->gBPAccount()->sortCode))|| (!empty($user->paypal_client_id) && !empty($user->paypal_secret_key))){
                        return view('user.link.dp_view_card', $data);
                    }else{
                        $data['title']='Error';
                        return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                    }
                }
            }else{
                if($key->type == 1){
                    return view('user.link.sc_test', $data);
                }elseif($key->type == 2){
                    return view('user.link.dp_test', $data);
                }
            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    } 

    public function scviewlink($id)
    {
        $set=Settings::first();
        if($set->donation==1){
            $check=Paymentlink::whereref_id($id)->get();
            if(count($check)>0){
                $key=Paymentlink::whereref_id($id)->first();
                $user=User::find($key->user_id);
                if($user->live==0){$mode=0;}else{$mode=1;}
                if($key->user->status==0){
                    if($key->user->payment==1){
                        if($key->status==0){
                            if($key->active==1){
                                $diff=$user->plan_payments-$user->used_payments;
                                if($key->amount<$diff || $key->amount==$diff){
                                    if($user->plan_transactions>$user->used_transactions){
                                        $data['link']=$key;
                                        $data['merchant']=$user;
                                        $data['title']="Pot";
                                        $data['donated']=Donations::wheredonation_id($key->id)->wherestatus(1)->sum('amount');
                                        $data['paid']=Donations::wheredonation_id($key->id)->wherestatus(1)->latest()->paginate(5);
                                        $xf=Countrysupported::whereid($user->pay_support)->first();
                                        if($xf->donation==1){
                                            if($user->kyc_verif_status=="APPROVED"){
                                                if($key->mode==1){
                                                    if($key->type==1){
                                                        if($user->bank_pay==1 || $user->paypal==1 || $user->coinbase==1){
                                                            return view('user.link.sc_view_card', $data);
                                                        }else{
                                                            $data['title']='Error';
                                                            return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                                                        }
                                                    }elseif($key->type==2){  
                                                        if($user->bank_pay==1 || $user->paypal==1 || $user->coinbase==1){
                                                            return view('user.link.dp_view_card', $data);
                                                        }else{
                                                            $data['title']='Error';
                                                            return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                                                        }
                                                    }
                                                }else{
                                                    if($key->type==1){
                                                        return view('user.link.sc_test', $data);
                                                    }elseif($key->type==2){
                                                        return view('user.link.dp_test', $data);
                                                    }
                                                }
                                            }else{
                                                Session::put('storefront', Auth::guard('user')->user()->id);
                                                $data['title']='Error Message';
                                                return view('user.merchant.error', $data)->withErrors('Compliance is currently due, please update your account information to avoid restrictions.');
                                            }
                                        }else{
                                            $data['title']='Error Message';
                                            return view('user.merchant.error', $data)->withErrors('Pot Module is not available for this Merchant');
                                        }
                                    }else{
                                        $data['title']='Error Message';
                                        return view('user.merchant.error', $data)->withErrors('Merchant have exceeded the number of transactions he/she can perform this month');
                                    }
                                }else{
                                    $data['title']='Error Message';
                                    return view('user.merchant.error', $data)->withErrors('Amount Exceeds Merchant Subscription Payment Limit');
                                }
                            }else{
                                $data['title']='Error Occured';
                                return view('user.merchant.error', $data)->withErrors('Pot has been disabled');
                            }    
                        }else{
                            $data['title']='Error Occured';
                            return view('user.merchant.error', $data)->withErrors('Pot has been suspended');
                        }
                    }else{
                        $data['title']='Error Message';
                        return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
                    }
                }else{
                    $data['title']='Error Message';
                    return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
                }
            }else{
                $data['title']='Error Message';
                return view('user.merchant.error', $data)->withErrors('Invalid Pot');
            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }   

    public function Sendsingle(Request $request)
    {
        $set=Settings::first();
        if($set->donation == 1){
            $link = Paymentlink::whereref_id($request->link)->first();
            $xtoken = randomNumber(11);
            $receiver = User::whereid($link->user_id)->first();
            $currency = Countrysupported::whereid($receiver->pay_support)->first();
            $validator = Validator::make( $request->all(),
            [
                'email' => 'required|max:255',
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'amount'=>'required|integer|min:'.$link->amount,
                'terms'=>'required'
            ]
            );
            if ($validator->fails()) {
                $data['errors']=$validator->errors();
                return back()->withInput()->with('errors', $validator->errors());
            }
            $validatorf = new EmailValidator();
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);
            if($validatorf->isValid($request->email, $multipleValidations)){}else{
                return back()->with('toast_warning', 'Invalid email address');
            }
            $sav=new Transactions();
            $sav->ref_id=$xtoken;
            $sav->type=1;
            $sav->amount=$request->amount;
            $sav->email=$request->email;
            $sav->first_name=$request->first_name;
            $sav->last_name=$request->last_name;
            $sav->receiver_id=$link->user_id;
            $sav->payment_link=$link->id;
            $sav->ip_address = user_ip();
            $sav->currency = $currency->coin_id; 
            $sav->save();
            if($request->action=='bank'){
                $sav->payment_type='bank';
                $sav->mode=1;
                $sav->save();
                //Generate Auth Key
                $authToken = base64_encode($set->auth_key.':'.$set->auth_secret);
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic ' .$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->get("https://api.yapily.com/institutions");
                $response = $curl->response;
                $curl->close();   
                if ($curl->error) {
                    return back()->with('toast_warning', $response->error->status.'-'.$response->error->message);
                }else{
                    Cache::put('trans', $sav->ref_id);
                    $data['authtoken']=$authToken;
                    $data['institution']=$response->data;
                    $data['title']='Select Preferred Bank';
                    $data['type']=1;
                    $data['reference']=$sav->ref_id;
                    return view('user.dashboard.institution', $data);
                }    
            }elseif($request->action=='coinbase'){
                $sav->payment_type='coinbase';
                $sav->mode=1;
                $sav->save();
                $data = [
                    'name'=> $set->site_name,
                    'description'=> $link->name,
                    'pricing_type'=>'fixed_price',
                    'metadata'=>array('customer_id'=>$sav->ref_id, 'customer_name'=> $sav->first_name.' '.$sav->last_name),
                    'local_price'=>array('amount'=>$sav->amount, 'currency'=>$currency->coin->name),
                    'redirect_url'=> route('coinbasesuccess',['id'=>$sav->ref_id]),
                    'cancel_url'=> route('coinbasecancelled',['id'=>$sav->ref_id])
                ];
                $curl = new Curl();
                $curl->setHeader('X-CC-Api-Key', $receiver->coinbase_api_key);
                $curl->setHeader('X-CC-Version', '2018-03-22');
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post("https://api.commerce.coinbase.com/charges", $data);
                $response = $curl->response;
                $curl->close();   
                if ($curl->error) {
                    return back()->with('toast_warning', $response->error->message);
                }else{
                    $sav->charge_id=$response->data->code;
                    $sav->save();
                    return Redirect::away($response->data->hosted_url);
                }    
            }elseif($request->action=='paypal'){
                $sav->payment_type='paypal';
                $sav->mode = 1;
                $sav->save();
                $authToken = base64_encode($receiver->paypal_client_id.':'.$receiver->paypal_secret_key);
                $data=[
                    'intent' => "CAPTURE",
                    "purchase_units"=> [
                        [
                            "amount"=>[
                                "currency_code"=> $currency->coin->name,
                                "value"=> number_format($sav->amount, 2, '.', '')
                            ],
                        ]
                    ],
                    "application_context"=> [
                        'return_url'=> route('paypalsuccess',['id'=>$sav->ref_id]),
                        'cancel_url'=> route('paypalcancelled',['id'=>$sav->ref_id])
                    ]
                ];
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post(env('PAYPAL_URL')."v2/checkout/orders", $data);
                $response = $curl->response;
                $curl->close();  
                if ($curl->error) {
                    return $curl->error;
                    return back()->with('toast_warning', $response->message);
                }else{
                    $sav->charge_id=$response->id;
                    $sav->save();
                    return Redirect::away($response->links[1]->href);
                }    
            }elseif($request->action == 'stripe'){
                $sav->payment_type='stripe';
                $sav->mode=1;
                $sav->save();
                $stripe = new StripeClient($receiver->stripe_secret_key);
                try{
                    $charge=$stripe->checkout->sessions->create([
                        'success_url' => route('stripesuccess',['id'=>$sav->ref_id]),
                        'cancel_url' => route('stripecancelled',['id'=>$sav->ref_id]),
                        'payment_method_types' => ['card'],
                        'line_items' => [
                          [
                            'name' => $link->name,
                            'amount' => number_format($sav->amount, 2, '.', '')*100,
                            'currency' => $currency->coin->name,
                            'quantity' => 1,
                          ],
                        ],
                        'mode' => 'payment',
                    ]);
                    $sav->charge_id=$charge['id'];
                    if($charge['livemode']==false){
                        $sav->status=2;
                        $sav->save();
                        return back()->with('toast_warning', 'You can\'t use test keys');
                    }
                    $sav->save();
                    return Redirect::away($charge['url']);
                } catch (\Stripe\Exception\CardException $e) {
                    return back()->with('toast_warning', $e->getMessage());
                }catch (\Stripe\Exception\InvalidRequestException $e) {
                    return back()->with('toast_warning', $e->getMessage());
                } 
            }elseif($request->action=='test'){
                $sav->payment_type='test';
                $sav->mode=0;
                $sav->status=$request->status;
                $sav->save();
                //Save Audit Log For Receiver 
                $audit=new Audit();
                $audit->user_id=$receiver->id;
                $audit->trx=$xtoken;
                $audit->log='Received test payment ' .$link->ref_id;
                $audit->save();
                //Notify users
                if($set->email_notify==1){
                    dispatch(new SendPaymentEmail($link->ref_id, 'test', $xtoken));
                } 
                //Webhook
                if($receiver->receive_webhook == 1){
                    if($receiver->webhook!=null){
                        send_webhook($sav->id);
                    }
                }
                //Redirect payment
                if($request->status==1){
                    return redirect()->route('generate.receipt', ['id'=>$sav->ref_id])->with('toast_success', 'Payment was successful');
                }else{
                    return back()->with('toast_warning', 'Payment Failed');
                }
            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }  

}