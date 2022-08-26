<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Countrysupported;
use App\Models\Transferlist;
use App\Models\Banksupported;
use App\Models\Banktransfer;
use App\Models\Sub;
use Curl\Curl;



class CountryController extends Controller
{
    
//Country
    public function CreateCountry(Request $request)
    {
        $data['country_id'] = $request->id;
        $data['coin_id'] = $request->coin_id;
        $res = Countrysupported::create($data);
        if ($res) {
            return redirect()->route('admin.country')->with('toast_success', 'Saved Successfully!');
        } else {
            return back()->with('toast_warning', 'Problem With Creating New Country');
        }
    }
    public function Createclbank(Request $request)
    {
        $data['country_id'] = $request->id;
        $data['name'] = $request->name;
        $data['code'] = $request->code;
        $res = Banksupported::create($data);
        if ($res) {
            return back()->with('toast_success', 'Bank successfully created');
        } else {
            return back()->with('toast_warning', 'Problem With Creating New Bank');
        }
    }
    public function clbank($id)
    {
        $data['title']='Bank Supported';
        $data['bank'] = Banksupported::wherecountry_id($id)->orderby('country_id', 'asc')->get();
        $data['country'] = Countrysupported::wherestatus(1)->get();
        $data['location'] = Countrysupported::wherecountry_id($id)->first();
        $data['country_id']=$id;
        return view('admin.country.bank', $data);
    }    
        
        public function clbankacct($id)
    {
        $data['title']='Bank Account';
        $data['deposit']=Banktransfer::wherecountry_id($id)->orderBy('id', 'DESC')->get();
        $data['country'] = Countrysupported::wherestatus(1)->get();
        $data['bank'] = Countrysupported::wherecountry_id($id)->first();
        $data['country_id']=$id;
        return view('admin.country.bankacct', $data);
    }    
    public function cusers($id)
    {
        $location = Countrysupported::whereid($id)->first();
        $data['title']='Customers from '.$location->real->name;
        $data['users'] = User::wherepay_support($id)->orderby('id', 'desc')->get();
        return view('admin.country.user', $data);
    }    
    public function cfeatures($id)
    {
        $data['features']=$location = Countrysupported::whereid($id)->first();
        $data['title']='Features available for '.$location->real->name;
        return view('admin.country.features', $data);
    }      
    
    public function ccrypto($id)
    {
        $data['crypto']=$location = Countrysupported::whereid($id)->first();
        $data['title']='Crypto currency settings for '.$location->real->name;
        return view('admin.country.crypto', $data);
    }    
    public function ctransfer($id)
    {
        $data['transfer']=$location = Countrysupported::whereid($id)->first();
        $data['all']=Countrysupported::all();
        $data['list']=Transferlist::wherecountry_id($location->country_id)->get();
        $data['title']='Transfer Restrictions on '.$location->real->name;
        return view('admin.country.transfer', $data);
    }
    public function transfer(Request $request)
    {
        $data = Countrysupported::findOrFail($request->id);                                         
        $data->max_transfer=$request->max_transfer;                        
        $data->min_transfer=$request->min_transfer;                        
        $res=$data->save();
        if ($res) {
            return back()->with('toast_success', 'Update was Successful!');
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    }    
    public function crypto(Request $request)
    {
        $data = Countrysupported::findOrFail($request->id);     
        if(empty($request->crypto_buy)){
            $data->crypto_buy=0;	
        }else{
            $data->crypto_buy=$request->crypto_buy;
        }         
        if(empty($request->crypto_sell)){
            $data->crypto_sell=0;	
        }else{
            $data->crypto_sell=$request->crypto_sell;
        }                              
        $res=$data->save();
        if ($res) {
            return back()->with('toast_success', 'Update was Successful!');
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    }    
    public function newtransfer(Request $request)
    {
        $check=Transferlist::wherecountry_id($request->country_id)->whereto_id($request->to_id)->count();
        if($check==0){
            $dd = explode("-", $request->to_id);
            $da = trim($dd[0]);
            $df = trim($dd[1]);
            $data['country_id'] = $request->country_id;
            $data['to_id'] = $da;
            $data['to_x'] = $df;
            $data['rate'] = $request->rate;
            $data['charge'] = $request->charge;
            Transferlist::create($data);
            return redirect()->back()->with('toast_success', 'Saved Successfully!');
        }else{
            return back()->with('toast_warning', 'Already added');
        }
    }     
    public function Features(Request $request)
    {
        $data = Countrysupported::findOrFail($request->id);
        $data->auth_key=$request->auth_key;                
        $data->auth_secret=$request->auth_secret;                
        $data->rail_apikey=$request->rail_apikey;                
        $data->rail_baseurl=$request->rail_baseurl;                
        $data->bank_format=$request->bank_format;                
        if(empty($request->merchant)){
            $data->merchant=0;	
        }else{
            $data->merchant=$request->merchant;
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
        if(empty($request->bank_pay)){
            $data->bank_pay=0;	
        }else{
            $data->bank_pay=$request->bank_pay;
        }        
        if(empty($request->coinbase)){
            $data->coinbase=0;	
        }else{
            $data->coinbase=$request->coinbase;
        }    
        if(empty($request->stripe)){
            $data->stripe=0;	
        }else{
            $data->stripe=$request->stripe;
        }   
        if(empty($request->paypal)){
            $data->paypal=0;	
        }else{
            $data->paypal=$request->paypal;
        }        
        if(empty($request->sub_bank)){
            $data->sub_bank=0;	
        }else{
            $data->sub_bank=$request->sub_bank;
        }               
        $res=$data->save();
        if ($res) {
            return back()->with('toast_success', 'Update was Successful!');
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    } 
    public function Updateclbank(Request $request)
    {
        $mac = Banksupported::whereid($request->id)->first();
        $mac['country_id'] = $request->country;
        $mac['name'] = $request->name;
        $mac['code'] = $request->code;
        $res = $mac->save();
        if ($res) {
            return back()->with('toast_success', 'Bank successfully updated');
        } else {
            return back()->with('toast_warning', 'Problem With Updating Bank');
        }
    }
    public function country()
    {
        $data['title']='Country Supported';
        $data['country'] = Countrysupported::orderby('id', 'desc')->get();
        $data['real'] = Country::all();
        $data['realx']=Currency::get();
        return view('admin.country.index', $data);
    }
    public function UpdateCountry(Request $request)
    {
        $data = Countrysupported::whereid($request->id)->first();
        $data->country_id= $request->country;
        $data->coin_id= $request->coin_id;
        $data->save();
        return back()->with('toast_success', 'Country was Successfully updated!');

    }    
    public function UpdateCountrytransfer(Request $request)
    {
        $data = Transferlist::whereid($request->id)->first();
        $data->rate= $request->rate;
        $data->charge= $request->charge;
        $data->status= $request->status;
        $data->save();
        return back()->with('toast_success', 'Rate was Successfully updated!');

    } 
    public function uncountry($id)
    {
        $data = Countrysupported::find($id);
        $data->status=0;
        $data->save();
        return back()->with('toast_success', 'country has been suspended.');
    } 
    public function pcountry($id)
    {
        $data=Countrysupported::find($id);
        $data->status=1;
        $data->save();
        return back()->with('toast_success', 'country was successfully published.');
    }
    public function DestroyCountry($id)
    {
        $data = Countrysupported::findOrFail($id);
        $check=User::wherepay_support($data->id)->count();
        if($check>0){
            return back()->with('toast_warning', 'You can not delete this country as you have users registered with this as their country');
        }else{
            $again=Countrysupported::count();
            if($again>1){
                $data->delete();
                return back()->with('toast_success', 'Country was Successfully deleted!');
            }else{
                return back()->with('toast_warning', 'There must be at least 1 country!');
            }
        }
    }    
    public function DestroyCountrytransfer($id)
    {
        $data = Transferlist::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Country was Successfully deleted!');
    }
//

//Bank
    public function Createlbank(Request $request)
    {
        $data['country_id'] = $request->id;
        $data['name'] = $request->name;
        $data['code'] = $request->code;
        $res = Banksupported::create($data);
        if ($res) {
            return redirect()->route('admin.lbank')->with('toast_success', 'Saved Successfully!');
        } else {
            return back()->with('toast_warning', 'Problem With Creating New Bank');
        }
    }
    public function lbank()
    {
        $data['title']='Bank Supported';
        $data['bank'] = Banksupported::orderby('country_id', 'asc')->get();
        $data['country'] = Countrysupported::wherestatus(1)->get();
        return view('admin.web-control.bank', $data);
    }
    public function Updatelbank(Request $request)
    {
        $mac = Banksupported::whereid($request->id)->first();
        $mac['country_id'] = $request->country;
        $mac['name'] = $request->name;
        $mac['code'] = $request->code;
        $res = $mac->save();
        if ($res) {
            return redirect()->route('admin.lbank')->with('toast_success', 'Saved Successfully!');
        } else {
            return back()->with('toast_warning', 'Problem With Updating Bank');
        }
    } 
    public function Destroylbank($id)
    {
        $data = Banksupported::findOrFail($id);
        $check=Bank::wherebank_id($data->id)->count();
        if($check>0){
            return back()->with('toast_warning', 'You can not delete this bank as you have users registered with this bank');
        }else{
            $data->delete();
            return back()->with('toast_success', 'Bank was Successfully deleted!');
        }
    }
// 

//Billing
    public function Plans($id)
    {
        $data['title']='Plans';
        $data['features']=Countrysupported::whereid($id)->first();
        $data['plan']=Sub::wherecountry_id($id)->get();
        return view('admin.country.plans', $data);
    } 

    public function Create($id)
    {
        $data['title']='Create plan';
        $data['features']=Countrysupported::whereid($id)->first();
        return view('admin.country.create', $data);
    } 

    public function Store(Request $request)
    {
        $set=Settings::first();
        $features=Countrysupported::whereid($request->country_id)->first();
        if($request->amount==null){
            $data=new Sub();
            $data->fill($request->all())->save();
        }elseif($request->amount!=null){
            $data=new Sub();
            $data->fill($request->all())->save();
            $curl = new Curl();
            $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
            $curl->setHeader('Authorization', 'Basic '.$authToken);
            $curl->setHeader('Content-Type', 'application/json');
            $datas=[
                'product_id'=> $set->paypal_productid,
                'name'=> $request->name,
                'description'=> 'Subscription plan',
                'status'=> 'ACTIVE',
                'billing_cycles'=>[
                    [
                        'frequency'=> [
                            'interval_unit'=> 'MONTH',
                            'interval_count'=> 1
                        ],
                        'tenure_type'=> 'REGULAR',
                        'sequence'=> 1,
                        'total_cycles'=> 999,
                        'pricing_scheme'=> [
                            'fixed_price'=> [
                                'value'=>round($request->amount+($request->amount*20/100)),
                                'currency_code'=> $features->coin->name
                            ]
                        ]
                    ],
                ],
                'payment_preferences'=> [
                    'auto_bill_outstanding'=> true,
                    'setup_fee'=> [
                        'value'=> 0,
                        'currency_code'=> $features->coin->name
                    ],
                    'setup_fee_failure_action'=> 'CONTINUE',
                    'payment_failure_threshold'=> 3
                ],
            ];
            $curl->post("https://api-m.paypal.com/v1/billing/plans", $datas);
            $response_1 = $curl->response;
            $curl->close();   
            $curl = new Curl();
            $curl->setHeader('Authorization', 'Basic '.$authToken);
            $curl->setHeader('Content-Type', 'application/json');
            $datas=[
                'product_id'=> $set->paypal_productid,
                'name'=> $request->name,
                'description'=> 'Subscription plan',
                'billing_cycles'=>[
                    [
                        'frequency'=> [
                            'interval_unit'=> 'YEAR',
                            'interval_count'=> 1
                        ],
                        'tenure_type'=> 'REGULAR',
                        'sequence'=> 1,
                        'total_cycles'=> 999,
                        'pricing_scheme'=> [
                            'fixed_price'=> [
                                'value'=>round($request->annual_amount*12+($request->annual_amount*20*12/100)),
                                'currency_code'=> $features->coin->name
                            ]
                        ]
                    ]
                ],
                'payment_preferences'=> [
                    'auto_bill_outstanding'=> true,
                    'setup_fee'=> [
                        'value'=> 0,
                        'currency_code'=> $features->coin->name
                    ],
                    'setup_fee_failure_action'=> 'CONTINUE',
                    'payment_failure_threshold'=> 3
                ]
            ];
            $curl->post("https://api-m.paypal.com/v1/billing/plans", $datas);
            $response_2 = $curl->response;
            $curl->close(); 
            $data->monthly_id=$response_1->id;
            $data->annual_id=$response_2->id;
            $data->save();
        }
        return redirect()->route('admin.py.plans', ['id'=>$request->country_id])->with('success', 'Saved Successfully!');
    } 

    public function PlanDestroy($id)
    {
        $data = Sub::findOrFail($id);
        $set=Settings::first();
        $check=User::whereplan_id($id)->get();
        if(count($check)>0){
            return back()->with('toast_warning', 'You can not delete this plan, users have subscription on this');
        }else{
            if($data->monthly_id!=null){
                $curl = new Curl();
                $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post("https://api-m.paypal.com/v1/billing/plans/".$data->monthly_id."/deactivate");
                $curl->response;
                $curl->close();      
                $curl = new Curl();     
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post("https://api-m.paypal.com/v1/billing/plans/".$data->annual_id."/deactivate");
                $curl->response;
                $curl->close();  
            }
            $data->delete();
            return back()->with('success', 'Plan was successfully deleted');
        }
    } 

    public function Edit($id)
    {
        $data['title']='Edit Plan';
        $data['plan']=$plan=Sub::whereid($id)->first();
        $data['features']=Countrysupported::whereid($plan->country_id)->first();
        return view('admin.country.edit', $data);
    } 

    public function Update(Request $request)
    {
        $set=Settings::first();
        $features=Countrysupported::whereid($request->country_id)->first();
        $data = Sub::findOrFail($request->id);
        if($request->amount==null){
            $data->fill($request->all())->save();
            if($request->affect_active_subscribers==1){
                foreach(User::whereplan_expired(0)->get() as $val){
                    $val->email_limit=$data->email_limit;
                    $val->sms_limit=$data->sms_limit;
                    $val->plan_transactions=$data->transactions;
                    $val->plan_payments=$data->payment;
                    $val->save();
                }
            }
            $data->affect_active_subscribers=0;
            $data->save();
        }else{
            $data->fill($request->all())->save(); 
            if($request->affect_active_subscribers==1){
                foreach(User::whereplan_expired(0)->get() as $val){
                    $val->email_limit=$data->email_limit;
                    $val->sms_limit=$data->sms_limit;
                    $val->plan_transactions=$data->transactions;
                    $val->plan_payments=$data->payment;
                    $val->save();
                }
            }
            $data->affect_active_subscribers=0;
            $data->save();
            if($data->monthly_id!=null){
                $curl = new Curl();
                $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $datas=[
                    "pricing_schemes"=> [
                        [
                            "billing_cycle_sequence"=> 1,
                            'pricing_scheme'=> [
                                'fixed_price'=> [
                                    'value'=>round($request->amount+($request->amount*20/100)),
                                    'currency_code'=> $features->coin->name
                                ]
                            ]
                        ]
                    ]
                ];
                $curl->post("https://api-m.paypal.com/v1/billing/plans/".$data->monthly_id."/update-pricing-schemes", $datas);
                $response_1 = $curl->response;
                $curl->close();      
                $curl = new Curl();     
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $datas=[
                    "pricing_schemes"=> [
                        [
                            "billing_cycle_sequence"=> 1,
                            'pricing_scheme'=> [
                                'fixed_price'=> [
                                    'value'=>round($request->annual_amount*12+($request->annual_amount*20*12/100)),
                                    'currency_code'=> $features->coin->name
                                ]
                            ]
                        ]
                    ]
                ];
                $curl->post("https://api-m.paypal.com/v1/billing/plans/".$data->annual_id."/update-pricing-schemes", $datas);
                $response_2 = $curl->response;
                $curl->close();  
            }else{
                $curl = new Curl();
                $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $datas=[
                    'product_id'=> $set->paypal_productid,
                    'name'=> $request->name,
                    'description'=> 'Subscription plan',
                    'status'=> 'ACTIVE',
                    'billing_cycles'=>[
                        [
                            'frequency'=> [
                                'interval_unit'=> 'MONTH',
                                'interval_count'=> 1
                            ],
                            'tenure_type'=> 'REGULAR',
                            'sequence'=> 1,
                            'total_cycles'=> 999,
                            'pricing_scheme'=> [
                                'fixed_price'=> [
                                    'value'=>round($request->amount),
                                    'currency_code'=> $features->coin->name
                                ]
                            ]
                        ],
                    ],
                    'payment_preferences'=> [
                        'auto_bill_outstanding'=> true,
                        'setup_fee'=> [
                            'value'=> 0,
                            'currency_code'=> $features->coin->name
                        ],
                        'setup_fee_failure_action'=> 'CONTINUE',
                        'payment_failure_threshold'=> 3
                    ],
                ];
                $curl->post("https://api-m.paypal.com/v1/billing/plans", $datas);
                $response_1 = $curl->response;
                $curl->close();   
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $datas=[
                    'product_id'=> $set->paypal_productid,
                    'name'=> $request->name,
                    'description'=> 'Subscription plan',
                    'billing_cycles'=>[
                        [
                            'frequency'=> [
                                'interval_unit'=> 'YEAR',
                                'interval_count'=> 1
                            ],
                            'tenure_type'=> 'REGULAR',
                            'sequence'=> 1,
                            'total_cycles'=> 999,
                            'pricing_scheme'=> [
                                'fixed_price'=> [
                                    'value'=>round($request->annual_amount*12),
                                    'currency_code'=> $features->coin->name
                                ]
                            ]
                        ]
                    ],
                    'payment_preferences'=> [
                        'auto_bill_outstanding'=> true,
                        'setup_fee'=> [
                            'value'=> 0,
                            'currency_code'=> $features->coin->name
                        ],
                        'setup_fee_failure_action'=> 'CONTINUE',
                        'payment_failure_threshold'=> 3
                    ]
                ];
                $curl->post("https://api-m.paypal.com/v1/billing/plans", $datas);
                $response_2 = $curl->response;
                $curl->close(); 
                $data->monthly_id=$response_1->id;
                $data->annual_id=$response_2->id;
                $data->save();
            }
        }
        return back()->with('success', 'Saved Successfully!');
    }  
//End
}
