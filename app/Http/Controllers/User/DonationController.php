<?php

namespace App\Http\Controllers\User;

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
use Curl\Curl;
use Session;
use Image;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Jobs\SendPaymentEmail;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Session as FacadesSession;

class DonationController extends Controller
{  
    public function Destroylink($id)
    {
        $link=Paymentlink::whereid($id)->first();
        $history=Transactions::wherepayment_link($id)->delete();
        $check=Donations::wheredonation_id($id)->get();
        foreach($check as $val){
            $donation=Donations::whereid($val->id)->delete();
        }
        $data=$link->delete();
        if ($data) {
            return back()->with('toast_success', 'Pot was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Pot');
        }
    }
    public function dplinkstrans($id)
    {
        $set=Settings::first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            $data['title'] = "Pot";
            $data['trans']=Transactions::wherepayment_link($id)->wherearchive(0)->wheretype(2)->wheremode($mode)->latest()->get();
            $data['archivesum']=Transactions::wherepayment_link($id)->wherearchive(1)->wheretype(2)->wheremode($mode)->latest()->count();
            return view('user.link.dp-trans', $data);
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }
    public function submitdonationpage(Request $request)
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
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        if($set->donation==1){
            $set=Settings::first();
            $currency=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
            $user=User::find(Auth::guard('user')->user()->id);
            $trx='POT-'.str_random(6);
            $sav['ref_id']=$trx;
            $sav['type']=2;
            $sav['amount']=$request->amount;
            $sav['name']=$request->name;
            $sav['description']=$request->description;
            $sav['user_id']=Auth::guard('user')->user()->id; 
            $sav['currency']=$currency->coin_id; 
            $sav['mode']=$mode; 
            $fileUrl = "";
            if($request->has('avatar')){
                $fileUrl = Cloudinary::uploadFile($request->file('avatar')->getRealPath())->getSecurePath();
                $sav['image'] = $fileUrl;
            }
            Paymentlink::create($sav);   
            $audit['user_id']=$user->id;
            $audit['trx']=$trx;
            $audit['log']='Created Multiple pot - '.$trx;
            Audit::create($audit);
            $his['user_id']=$user->id;
            $his['ref']=$trx;
            $his['main']=1;
            History::create($his);
            return back()->with('toast_success', 'Pot was successfully created');
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Pot is currently unavailable');
        }
    }
    public function Senddonation(Request $request)
    {
        $set=Settings::first();
        if($set->donation==1){
            $set=Settings::first();
            $link=Paymentlink::whereref_id($request->link)->first();
            $receiver=User::whereid($link->user_id)->first();
            $xtoken=randomNumber(11);
            $donated=Donations::wheredonation_id($link->id)->wherestatus(1)->sum('amount');
            if (Auth::guard('user')->check()){
                $currency=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
            }else{
                $currency=Countrysupported::whereid($receiver->pay_support)->first();
            }
            $check = ($link->amount) ? $link->amount - $donated : $request->amount;
            $validator = Validator::make( $request->all(),
                [
                'email' => 'required|max:255',
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'amount'=>'required|integer|min:0|max:'.round($check),
                'status'=>'required',
                'terms'=>'required'
                ]
            );
            if ($validator->fails()) {
                return back()->with('errors', $validator->errors());
            }
            $validatorf = new EmailValidator();
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);
            if($validatorf->isValid($request->email, $multipleValidations)){}else{
                return back()->with('toast_warning', 'Invalid email address');
            }
            if($request->action=='bank'){
                $sav=new Transactions();
                $sav->ref_id = $xtoken;
                $sav->type=2;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$request->first_name;
                $sav->last_name=$request->last_name;
                $sav->receiver_id=$link->user_id;
                $sav->payment_link=$link->id;
                $sav->payment_type='bank';
                $sav->ip_address = user_ip();
                $sav->currency=$currency->coin_id;  
                $sav->mode=1;
                $sav->save();
                //Save Donation
                $don= new Donations();
                $don->amount=$request->amount;
                $don->status=0;
                $don->anonymous=$request->status;
                $don->ref_id=$xtoken;
                $don->donation_id = $link->id;
                $don->currency=$currency->coin_id; 
                $don->mode=1;
                $don->save(); 
                if($check>$request->amount || $check==$request->amount){
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
                        FacadesSession::put('trans', $sav->ref_id);
                        $data['authtoken']=$authToken;
                        $data['institution']=$response->data;
                        $data['title']='Select Preferred Bank';
                        $data['type']=2;
                        $data['reference']=$sav->ref_id;
                        return view('user.dashboard.institution', $data);
                    } 
                }else{
                    return back()->with('toast_warning', 'Amount exceeds pot requirement');
                }
            }elseif($request->action=='coinbase'){
                $sav=new Transactions();
                $sav->ref_id=$xtoken;
                $sav->type=2;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$request->first_name;
                $sav->last_name=$request->last_name;
                $sav->receiver_id=$link->user_id;
                $sav->payment_link=$link->id;
                $sav->payment_type='coinbase';
                $sav->ip_address=user_ip();
                $sav->currency=$currency->coin_id; 
                $sav->mode=1;
                $sav->save();
                //Save Donation
                $don=new Donations();
                $don->amount=$request->amount;
                $don->status=0;
                $don->anonymous=$request->status;
                $don->ref_id=$xtoken;
                $don->donation_id=$link->id;
                $don->currency=$currency->coin_id; 
                $don->mode=1;
                $don->save(); 
                if($check>$request->amount || $check==$request->amount){
                    $data=[
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
                }else{
                    return back()->with('toast_warning', 'Amount exceeds pot requirement');
                }
            }elseif($request->action=='paypal'){
                $sav=new Transactions();
                $sav->ref_id=$xtoken;
                $sav->type=2;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$request->first_name;
                $sav->last_name=$request->last_name;
                $sav->receiver_id=$link->user_id;
                $sav->payment_link=$link->id;
                $sav->payment_type='paypal';
                $sav->ip_address=user_ip();
                $sav->currency=$currency->coin_id;  
                $sav->mode=1;
                $sav->save();
                //Save Donation
                $don=new Donations();
                $don->amount=$request->amount;
                $don->status=0;
                $don->anonymous=$request->status;
                $don->ref_id=$xtoken;
                $don->donation_id=$link->id;
                $don->currency=$currency->coin_id; 
                $don->mode=1;
                $don->save(); 
                if($check>$request->amount || $check==$request->amount){
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
                    $curl->post("https://api-m.paypal.com/v2/checkout/orders", $data);
                    $response = $curl->response;
                    $curl->close();  
                    if ($curl->error) {
                        return back()->with('toast_warning', $response->message);
                    }else{
                        $sav->charge_id=$response->id;
                        $sav->save();
                        return Redirect::away($response->links[1]->href);
                    }  
                }else{
                    return back()->with('toast_warning', 'Amount exceeds pot requirement');
                }
            }elseif($request->action=='stripe'){
                $sav=new Transactions();
                $sav->ref_id=$xtoken;
                $sav->type=2;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$request->first_name;
                $sav->last_name=$request->last_name;
                $sav->receiver_id=$link->user_id;
                $sav->payment_link=$link->id;
                $sav->payment_type='stripe';
                $sav->ip_address=user_ip();
                $sav->currency=$currency->coin_id;  
                $sav->mode=1;
                $sav->save();
                //Save Donation
                $don=new Donations();
                $don->amount=$request->amount;
                $don->status=0;
                $don->anonymous=$request->status;
                $don->ref_id=$xtoken;
                $don->donation_id=$link->id;
                $don->currency=$currency->coin_id; 
                $don->mode=1;
                $don->save(); 
                if($check>$request->amount || $check==$request->amount){
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
                }else{
                    return back()->with('toast_warning', 'Amount exceeds pot requirement');
                }
            }elseif($request->action=='test'){
                if($check>$request->amount || $check==$request->amount){
                    $sav=new Transactions();              
                    $sav->ref_id=$xtoken;
                    $sav->type=2;
                    $sav->amount=$request->amount;
                    $sav->email=$request->email;
                    $sav->first_name=$request->first_name;
                    $sav->last_name=$request->last_name;
                    $sav->ip_address=user_ip();
                    $sav->receiver_id=$link->user_id;
                    $sav->payment_link=$link->id;
                    $sav->payment_type='test';
                    $sav->currency=$currency->coin_id; 
                    $sav->mode=0;
                    $sav->status=$request->status;
                    $sav->save();
                    //Save Donation
                    $don=new Donations();
                    $don->amount=$request->amount;
                    $don->amount=$request->amount;
                    $don->status=$request->status;
                    $don->anonymous=$request->presence;
                    $don->ref_id=$xtoken;
                    $don->donation_id=$link->id;
                    $don->currency=$currency->coin_id; 
                    $don->mode=0;
                    $don->save(); 
                    //Audit
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
                    if($receiver->receive_webhook==1){
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
                }else{
                    return back()->with('toast_warning', 'Amount exceeds donation requirement');
                }

            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Multiple pot is currently unavailable');
        }
    }
}