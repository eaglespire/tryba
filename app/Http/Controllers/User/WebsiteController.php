<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Stripe\StripeClient;
use App\Models\User;
use App\Models\Settings;
use App\Models\Exttransfer;
use App\Models\Merchant;
use App\Models\Audit;
use App\Models\Transactions;
use App\Models\Charges;
use App\Models\History;
use Illuminate\Support\Facades\Redirect;
use App\Models\Countrysupported;
use Curl\Curl;
use Session;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendMerchant;

class WebsiteController extends Controller
{
    public function merchant()
    {
        $set=Settings::first();
        $user=Auth::guard('user')->user();
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
        if($set->merchant==1){
            if($xf->merchant==1){
                $data['title']='Merchant';
                $data['merchant']=auth()->guard('user')->user()->getWebsites();
                return view('user.merchant.index', $data)->withUser($user);
            }else{
                $data['title']='Error Message';
                return view('user.merchant.error', $data)->withErrors('Merchant is not available for your country');
            }
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Merchant is currently unavailable');
        }
    }

    public function addmerchant()
    {
        $data['title']='Add merchant';
        return view('user.merchant.create', $data);
    }   

    public function merchant_documentation()
    {
        $data['title']='Documentation';
        $data['country']=Countrysupported::wherestatus(1)->get();
        return view('user.merchant.documentation', $data);
    } 

    public function merchant_button()
    {
        $data['title']='Payment Button';
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $data['merchant']=Merchant::whereUser_id(Auth::guard('user')->user()->id)->wheremode($mode)->latest()->get();
        $data['country']=Countrysupported::wherestatus(1)->get();
        return view('user.merchant.button', $data);
    }

    public function merchant_plugin()
    {
        $data['title']='Integrations';
        return view('user.merchant.integrations', $data);
    } 

    public function merchant_html()
    {
        $data['title']='HTML Integration';
        $check=Countrysupported::wherestatus(1)->get();
        $ccx=array();
        foreach($check as $vals){
            $ccx[]=$vals['coin_id'];
        }
        $ccx = array_unique($ccx); 
        $data['dd']=$ccx;
        return view('user.merchant.html', $data);
    }    
    
    public function merchant_api()
    {
        $data['title']='API Checkout';
        $check=Countrysupported::wherestatus(1)->get();
        $ccx=array();
        foreach($check as $vals){
            $ccx[]=$vals['coin_id'];
        }
        $ccx = array_unique($ccx); 
        $data['dd']=$ccx;
        return view('user.merchant.api', $data);
    }

    public function merchant_woo()
    {
        $headers = ['Content-Type' => 'application/zip'];
        return response()->download(public_path("asset/plugins/tryba-payment-gateway-for-woo.zip"), 'tryba-payment-gateway-for-woo.zip', $headers);
    }    
    public function merchant_gf()
    {
        $headers = ['Content-Type' => 'application/zip'];
        return response()->download(public_path("asset/plugins/tryba-for-gravity-forms.zip"), 'tryba-for-gravity-forms.zip', $headers);
    }    
    public function merchant_edd()
    {
        $headers = ['Content-Type' => 'application/zip'];
        return response()->download(public_path("asset/plugins/tryba-for-edd.zip"), 'tryba-for-edd.zip', $headers);
    }    
    public function merchant_gwp()
    {
        $headers = ['Content-Type' => 'application/zip'];
        return response()->download(public_path("asset/plugins/tryba-for-givewp.zip"), 'tryba-for-givewp.zip', $headers);
    } 

    public function Editmerchant($id)
    {
        $data['merchant']=$merchant=Merchant::find($id);
        $data['title']=$merchant->name;
        return view('user.merchant.edit', $data);
    } 

    public function Logmerchant($id)
    {
        $data['log']=Exttransfer::whereMerchant_key($id)->orderby('id', 'desc')->get();
        $data['title']='Merchant log';
        return view('user.merchant.log', $data);
    } 

    public function updatemerchant(Request $request)
    {
        $data = Merchant::find($request->id);
        $res = $data->fill($request->all())->save();
        if ($res) {
            return back()->with('toast_success', 'Saved Successfully!');
        } else {
            return back()->with('toast_warning', 'Problem With updating merchant');
        }
    } 

    public function Destroymerchant($id)
    {
        $data = Merchant::findOrFail($id);
        $ext = Exttransfer::wheremerchant_key($data->merchant_key)->get();
        if(count($ext)>0){
            foreach($ext as $val){
                $val->delete();
            }
        }   
        $data->delete();
        return back();
    }

    public function transferprocess($id, $xx)
    {
        $data['link']=$link=Exttransfer::whereReference($xx)->first();
        $data['boom']=$boom=Merchant::whereMerchant_key($id)->first();
        $data['merchant']=$user=User::whereid($boom->user_id)->first();
        if($user->status==0){
            if($user->payment==1){
                if($link->status==0){
                    $data['title'] = "Make payment - ".$link->title;
                    $data['id']= $id;
                    $data['token']= $xx;
                    if($link->mode==0){
                        return view('user.merchant.transfer_process_test', $data);
                    }else{
                        if($user->bank_pay==1 || $user->paypal==1 || $user->coinbase==1){
                            return view('user.merchant.transfer_process', $data);
                        }else{
                            $data['title']='Error';
                            return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                        }
                    }
                }elseif($link->status==3){
                    $data['title']='Error Message';
                    return view('user.merchant.error', $data)->withErrors('Payment Duration has expired');
                }elseif($link->status==2){
                    $data['title']='Error Message';
                    return view('user.merchant.error', $data)->withErrors('You cancelled this payment');
                }elseif($link->status==1){
                    $data['title']='Error Message';
                    return view('user.merchant.error', $data)->withErrors('Transaction has already been paid');
                }
            }else{
                $data['title']='Error Message';
                return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
            }        
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('An Error Occured');
        }
    }   

    public function Cancelpayment($id)
    {
        $ext=Exttransfer::wheretx_ref($id)->first();
        $ext->status=2;
        $ext->save();
        return Redirect::away($ext->return_url);
    } 

    public function Paymerchant(Request $request)
    {
        $set=Settings::first();
        $ext=Exttransfer::whereReference($request->link)->first();
        $merchant=Merchant::whereMerchant_key($ext->merchant_key)->first();
        $up_mer=User::whereId($merchant->user_id)->first();
        $currency=Countrysupported::whereid($up_mer->pay_support)->first();
        $scurrency=Countrysupported::whereid($up_mer->pay_support)->first();
        $author=Countrysupported::whereid($up_mer->pay_support)->first();
        if($ext->status==0){
            if($request->action=='bank'){
                $ext->payment_type='bank';
                $ext->save();
                //Transaction History
                $sav=new Transactions();              
                $sav->ref_id=$ext->reference;
                $sav->type=4;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$ext->first_name;
                $sav->last_name=$ext->last_name;
                $sav->ip_address=user_ip();
                $sav->receiver_id=$ext->receiver_id;
                $sav->payment_link=$ext->id;
                $sav->payment_type='bank';
                $sav->currency=$currency->coin_id; 
                $sav->mode=1;
                $sav->save();
                //Generate Auth Key
                $authToken = base64_encode($currency->auth_key.':'.$currency->auth_secret);
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
                    $data['type']=4;
                    $data['reference']=$sav->ref_id;
                    return view('user.dashboard.institution', $data);
                }  
            }elseif($request->action=='coinbase'){
                $ext->payment_type='coinbase';
                $ext->save();
                //Transaction History
                $sav=new Transactions();              
                $sav->ref_id=$ext->reference;
                $sav->type=4;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$ext->first_name;
                $sav->last_name=$ext->last_name;
                $sav->ip_address=user_ip();
                $sav->receiver_id=$ext->receiver_id;
                $sav->payment_link=$ext->id;
                $sav->payment_type='coinbase';
                $sav->currency=$currency->coin_id; 
                $sav->mode=1;
                $sav->save();
                $data=[
                    'name'=> $set->site_name,
                    'description'=> $ext->title,
                    'pricing_type'=>'fixed_price',
                    'metadata'=>array('customer_id'=>$sav->ref_id, 'customer_name'=> $sav->first_name.' '.$sav->last_name),
                    'local_price'=>array('amount'=>$sav->amount, 'currency'=>$currency->coin->name),
                    'redirect_url'=> route('coinbasesuccess',['id'=>$sav->ref_id]),
                    'cancel_url'=> route('coinbasecancelled',['id'=>$sav->ref_id])
                ];
                $curl = new Curl();
                $curl->setHeader('X-CC-Api-Key', $up_mer->coinbase_api_key);
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
                $ext->payment_type='paypal';
                $ext->save();
                //Transaction History
                $sav=new Transactions();              
                $sav->ref_id=$ext->reference;
                $sav->type=4;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$ext->first_name;
                $sav->last_name=$ext->last_name;
                $sav->ip_address=user_ip();
                $sav->receiver_id=$ext->receiver_id;
                $sav->payment_link=$ext->id;
                $sav->payment_type='paypal';
                $sav->currency=$currency->coin_id; 
                $sav->mode=1;
                $sav->save();
                $authToken = base64_encode($up_mer->paypal_client_id.':'.$up_mer->paypal_secret_key);
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
            }elseif($request->action=='stripe'){
                $ext->payment_type='stripe';
                $ext->save();
                //Transaction History
                $sav=new Transactions();              
                $sav->ref_id=$ext->reference;
                $sav->type=4;
                $sav->amount=$request->amount;
                $sav->email=$request->email;
                $sav->first_name=$ext->first_name;
                $sav->last_name=$ext->last_name;
                $sav->ip_address=user_ip();
                $sav->receiver_id=$ext->receiver_id;
                $sav->payment_link=$ext->id;
                $sav->payment_type='stripe';
                $sav->currency=$currency->coin_id; 
                $sav->mode=1;
                $sav->save();
                $stripe = new StripeClient($up_mer->stripe_secret_key);
                try{
                    $charge=$stripe->checkout->sessions->create([
                        'success_url' => route('stripesuccess',['id'=>$sav->ref_id]),
                        'cancel_url' => route('stripecancelled',['id'=>$sav->ref_id]),
                        'payment_method_types' => ['card'],
                        'line_items' => [
                          [
                            'name' => $ext->title,
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
                    $ext->payment_type='test';
                    $ext->save();
                    //Transaction History
                    $sav=new Transactions();              
                    $sav->ref_id=$ext->reference;
                    $sav->type=4;
                    $sav->amount=$request->amount;
                    $sav->email=$request->email;
                    $sav->first_name=$ext->first_name;
                    $sav->last_name=$ext->last_name;
                    $sav->ip_address=user_ip();
                    $sav->receiver_id=$ext->receiver_id;
                    $sav->payment_link=$ext->id;
                    $sav->payment_type='test';
                    $sav->currency=$currency->coin_id; 
                    $sav->mode=0;
                    $sav->status=$request->status;
                    $sav->paid=1;
                    $sav->save();
                    $ext->status=$request->status;
                    $ext->mode=0;
                    $ext->save();
                    //Audit log
                    $audit=new Audit();
                    $audit->user_id=$merchant->user_id;
                    $audit->trx=$ext->reference;
                    $audit->log='Received test Payment for '.$ext->reference.' was successful';
                    $audit->save();
                    //Send Notification
                    if($set->email_notify==1){
                        dispatch(new SendMerchant($merchant->merchant_key, 'test', $ext->reference));
                    }
                    //Webhook
                    if($up_mer->receive_webhook==1){
                        if($up_mer->webhook!=null){
                            send_webhook($sav->id);
                        }
                    }
                    if($request->status==1){
                        return Redirect::away($ext->callback_url);
                    }else{
                        return Redirect::away($ext->return_url);
                    }

            } 
        }else{
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors('Transaction already paid');
        }  
    }

    public function transfererror()
    {    
        $data['title']='Error Message';
        return view('user.merchant.error', $data);
    }

    public function submitpay(Request $request)
    {
        $check=Merchant::whereMerchant_key($request->merchant_key)->whereStatus(1)->count();
        if($check>0){
            $token = randomNumber(11);
            $data['merchant']=$merchant=Merchant::whereMerchant_key($request->merchant_key)->first();
            $user=User::whereid($merchant->user_id)->first();
            $diff=$user->plan_payments-$user->used_payments;
            if(($request->quantity*$request->amount)<$diff || ($request->quantity*$request->amount)==$diff){
                if($user->plan_transactions>$user->used_transactions){
                    $validator=Validator::make($request->all(), [
                        'merchant_key' => ['required', 'max:16', 'string'],
                        'public_key' => ['required', 'max:50', 'string'],
                        'amount' => ['required', 'numeric','between:0,99999999999.99'],
                        'email' => ['required', 'max:255'],
                        'first_name' => ['required', 'max:100'],
                        'last_name' => ['required', 'max:100'],
                        'callback_url' => ['required','url'],
                        'return_url' => ['required','url'],
                        'tx_ref' => ['required','string','string'],
                        'title' => ['required','string'],
                        'description' => ['required','string'],
                        'quantity' => ['required','int','min:1'],
                    ]);
                    if ($validator->fails()) {
                        return redirect()->route('transfererror')->withErrors($validator)->withInput();
                    }                    
                    $validatorf = new EmailValidator();
                    $multipleValidations = new MultipleValidationWithAnd([
                        new RFCValidation(),
                        new DNSCheckValidation()
                    ]);
                    if($validatorf->isValid($request->email, $multipleValidations)){}else{
                        return back()->with('toast_warning', 'Invalid email address');
                    }
                    if($merchant->mode==0){$mode=0;$pb=$user->test_public_key;}else{$mode=1;$pb=$user->public_key;}
                    $xf=Countrysupported::whereid($user->pay_support)->first();
                    if($xf->merchant==1){
                        if($user->status==0){
                            if($pb==$request->public_key){
                                $dfd=Exttransfer::wheretx_ref($request->tx_ref)->count();
                                if($dfd==0){
                                    $mer['reference']=$token;
                                    $mer['receiver_id']=$merchant->user_id;
                                    $mer['amount']=$request->amount;
                                    $mer['quantity']=$request->quantity;
                                    $mer['total']=$request->quantity*$request->amount;
                                    $mer['title']=$request->title;
                                    $mer['description']=$request->description;
                                    $mer['merchant_key']=$request->merchant_key;
                                    $mer['callback_url']=$request->callback_url;
                                    $mer['return_url']=$request->return_url;
                                    $mer['tx_ref']=$request->tx_ref;
                                    $mer['email']=$request->email;
                                    $mer['first_name']=$request->first_name;
                                    $mer['last_name']=$request->last_name;
                                    $mer['ip_address']=user_ip();
                                    $mer['status']=0;
                                    $mer['currency']=$xf->coin_id; 
                                    $mer['mode']=$mode;  
                                    Exttransfer::create($mer);
                                    return redirect()->route('transfer.process', ['id'=>$request->merchant_key, 'xx'=>$token]);
                                }else{
                                    $data['title']='Error Message';
                                    return view('user.merchant.error', $data)->withErrors('Transaction reference has been created before');
                                }
                            }else{
                                $data['title']='Error Message';
                                return view('user.merchant.error', $data)->withErrors('Invalid public key');
                            }
                        }else{
                            $data['title']='Error Message';
                            return view('user.merchant.error', $data)->withErrors('An Error Occured');
                        }
                    }else{
                        $data['title']='Error Message';
                        return view('user.merchant.error', $data)->withErrors('Merchant is not available for this Merchant');
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
            return back()->with('toast_warning', 'Invalid merchant key');
        }

    }

    public function submitmerchant(Request $request)
    {
        $validator = Validator::make( $request->all(),
        [
            'name'=>'required',
            'description'=>'required'
        ]
        );
        if ($validator->fails()) {
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors($validator->errors());
        }
        $user=$data['user']=User::find(Auth::guard('user')->user()->id);
        if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
        $trx='MER-'.str_random(6);
        $sav['user_id']=Auth::guard('user')->user()->id;
        $sav['merchant_key']=str_random(16);
        $sav['name']=$request->name;
        $sav['description']=$request->description;
        $sav['url']=$request->url;
        $sav['email']=$request->email;
        $sav['ref_id']=$trx;
        $sav['status'] = 1;
        $sav['live'] = $request->mode;
        $sav['mode'] = $mode;
        $sav['message'] = $request->message;
        Merchant::create($sav);
        $his['user_id']=$user->id;
        $his['ref']=$trx;
        $his['main']=1;
        History::create($his);
        return redirect()->route('user.merchant')->with('toast_success', 'Successfully created');
    }
}