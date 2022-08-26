<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Countrysupported;
use App\Models\Sub;
use App\Models\Exttransfer;
use App\Models\Paymentlink;
use App\Models\Donations;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Audit;
use Carbon\Carbon;
use Curl\Curl;
use App\Mail\SendEmail;
use App\Jobs\SendPaymentEmail;
use App\Jobs\SendMerchant;
use App\Jobs\SendInvoiceReceipt;
use App\Jobs\SendStoreReceipt;
use Illuminate\Support\Facades\Mail;

class UpdateTrans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:trans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Transactions every 10 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
        \Log::info("Transaction update job");
        $set=getSetting();
        $old_transactions=Transactions::wherestatus(0)->wheremode(1)->get();
        foreach($old_transactions as $val){
            $date = Carbon::parse($val->created_at);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            if($diff>1 || $diff==1){
                $val->status=2;
                $val->save();
            }
        }
        $ext=Exttransfer::wherestatus(0)->get();
        foreach($ext as $val){
            $abandoned=Carbon::create($val->created_at->toDateTimeString())->add('10 minutes');
            if(carbon::now()>$abandoned){
                $val->status=3;
                $val->save();
            }
        }
        $sub=User::whereauto_renewal(1)->where('bank_consent', '!=', null)->whereplan_expired(0)->where('plan_expiring', '<', Carbon::now())->wherestatus(0)->get();
        foreach($sub as $val){
            $currency=Countrysupported::whereid($val->pay_support)->first();
            $plan=Sub::whereid($val->plan_id)->first();
            $bank=Countrysupported::whereid($val->pay_support)->first();
            $token=randomNumber(11);
            if($plan->amount==0){
                $val->plan_transactions=null;
                $val->plan_payments=null;
                $val->used_transactions=null;
                $val->plan_payments=null;
                $val->plan_expired=1;
                $val->bank_consent=null;
                $val->auto_renewal=0;
                $val->save();
                if($set->email_notify==1){
                    $gg=[
                        'email'=>$val->email,
                        'name'=>$val->first_name.' '.$val->last_name,
                        'subject'=>'Subscription Expired',
                        'message'=>'Hi '.$val->first_name.', Hey your subscription to '.$plan->name.' has expired. You can no longer receive payment with no charges via gigpots, invoices, selling products and so much more. We hope to see you again. Thanks for choosing '.$set->site_name.'</br>The tryba team.'
                    ];
                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                }
            }else{
                $sav=new Transactions();
                $sav->ref_id=$token;
                $sav->type=9;
                if($val->plan_type="monthly"){
                    $sav->amount=$plan->amount;
                    $sav->base_amount=$plan->amount;
                }elseif($val->plan_type="annual"){
                    $sav->amount=($plan->annual_amount*12);
                    $sav->base_amount=$plan->annual_amount*12;
                }
                $sav->email=$val->email;
                $sav->first_name=$val->first_name;
                $sav->last_name=$val->last_name;
                $sav->receiver_id=$val->id;
                $sav->payment_link=$plan->id;
                $sav->payment_type='bank';
                $sav->ip_address=user_ip();
                $sav->currency=$currency->coin_id;
                $sav->rate=$currency->rate;
                $sav->mode=1;
                $sav->save();
                $auth_token = base64_encode($currency->auth_key.':'.$currency->auth_secret);
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic ' .$auth_token);
                $curl->setHeader('Consent', $val->bank_consent);
                $curl->setHeader('Content-Type', 'application/json');
                $data=[
                    'type'=> "DOMESTIC_PAYMENT",
                    'reference'=> 'Subscription Payment',
                    'paymentIdempotencyId'=> $sav->ref_id,
                    'amount' => [
                        'amount'=> number_format($sav->amount, 2),
                        'currency'=> $sav->rex->name,
                    ],
                    'payee' => [
                        'name'=> $sav->user->first_name.' '.$sav->user->last_name,
                        'accountIdentifications' => [
                            [
                                'type'=> "ACCOUNT_NUMBER",
                                'identification'=> $bank->acct_no,
                            ],[
                                'type'=> "SORT_CODE",
                                'identification'=> $bank->routing_number,
                            ]

                        ],
                    ],
                ];
                $curl->post("https:api.yapily.com/payments", $data);
                $response = $curl->response;
                $curl->close();
                if ($curl->error) {
                    $val->auto_renewal=1;
                    $val->save();
                } else{
                    if($response->data->status=="PENDING"){
                        $sav->charge_id=$response->data->id;
                        $sav->save();
                    }elseif($response->data->status=="FAILED"){
                        $sav->status=2;
                        $sav->save();
                        $val->plan_transactions=null;
                        $val->plan_payments=null;
                        $val->used_transactions=null;
                        $val->plan_payments=null;
                        $val->plan_expired=1;
                        $val->save();
                        if($set->email_notify==1){
                            $gg=[
                                'email'=>$val->email,
                                'name'=>$val->first_name.' '.$val->last_name,
                                'subject'=>'Subscription Renewal Failed',
                                'message'=>'Hi '.$val->first_name.', Hey your subscription to '.$plan->name.' has expired. You can no longer receive payment with no charges via gigpots, invoices, selling products and so much more. We hope to see you again. Thanks for choosing '.$set->site_name.'</br>The tryba team.'
                            ];
                            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                        }
                    }elseif($response->data->status=="COMPLETED"){
                        $val->plan_id=$plan->id;
                        if($val->plan_type=="monthly"){
                            $val->plan_transactions=$plan->transactions;
                            $val->plan_payments=$plan->payment;
                            $val->plan_expired=0;
                            $val->plan_type="monthly";
                            $val->plan_expiring=Carbon::now()->add('1 month');
                        }
                        if($val->plan_type=="annual"){
                            $val->plan_transactions=$plan->transactions*12;
                            $val->plan_payments=$plan->payment*12;
                            $val->plan_expired=0;
                            $val->plan_type="annual";
                            $val->plan_expiring=Carbon::now()->add('1 year');
                        }
                        $val->used_transactions=null;
                        $val->used_payments=null;
                        $val->save();
                        if($set->email_notify==1){
                            $gg=[
                                'email'=>$val->email,
                                'name'=>$val->first_name.' '.$val->last_name,
                                'subject'=>'Subscription Payment',
                                'message'=>'Hey you just subscribed to '.$plan->name.'. You can now start receiving payment with no charges via gigpots, invoices, selling products and so much more. Thanks for choosing '.$set->site_name
                            ];
                            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                        }
                    }
                }
            }
        }
        $norenew=User::whereauto_renewal(0)->whereplan_expired(0)->where('plan_expiring', '<', Carbon::now())->wherestatus(0)->get();
        foreach($norenew as $val){
            $val->plan_transactions=null;
            $val->plan_payments=null;
            $val->used_transactions=null;
            $val->used_payments=null;
            $val->plan_expired=1;
            $val->save();
            if($set->email_notify==1){
                $gg=[
                    'email'=>$val->email,
                    'name'=>$val->first_name.' '.$val->last_name,
                    'subject'=>'Subscription Renewal Failed',
                    'message'=>'Hi '.$val->first_name.', Hey your subscription to '.$val->plan->name.' has expired. You can no longer receive payment with no charges via gigpots, invoices, selling products and so much more. We hope to see you again. Thanks for choosing '.$set->site_name.'</br>The tryba team.'
                ];
                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            }
        }
        $paid=Transactions::wherestatus(0)->wherepayment_type('bank')->where('charge_id', '!=', null)->wherenew(1)->wheremode(1)->get();
        foreach($paid as $val){
           $receiver = User::whereid($val->receiver_id)->first();
           $authToken = base64_encode($receiver->cc->auth_key . ':' . $receiver->cc->auth_secret);
            $curl = new Curl();
            $curl->setHeader('Authorization', 'Basic ' .$authToken);
            $curl->setHeader('Consent', $val->consent);
            $curl->setHeader('Content-Type', 'application/json');
            $curl->get("https:api.yapily.com/payments/".$val->charge_id."/details");
            $response = $curl->response;
            $receiver=User::whereid($val->receiver_id)->first();
            if($response->data->payments[0]->status=="FAILED"){
                $val->status=2;
                $val->save();
            }elseif($response->data->payments[0]->status=="COMPLETED"){
                $val->status=1;
                $val->save();
                $val->charge_id=$response->data->payments[0]->id;
                $val->save();
                if($val->type!=9){
                    if($receiver->plan_expired==0){
                        $receiver->used_transactions=$receiver->used_transactions+1;
                        $receiver->used_payments=$receiver->used_payments+$val->amount;
                        $receiver->save();
                        if(($receiver->used_payments==$receiver->plan_payments) || ($receiver->used_transactions==$receiver->plan_transactions)){
                            $receiver->plan_expired==1;
                            $receiver->save();
                            if($set->email_notify==1){
                                $gg=[
                                    'email'=>$val->email,
                                    'name'=>$val->first_name.' '.$val->last_name,
                                    'subject'=>'Subscription Expired',
                                    'message'=>'Hey your subscription just expired, you can no longer receive payments. Thanks for choosing '.$set->site_name
                                ];
                                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                            }
                        }
                    }
                }
                if($val->type==1){
                    $link=Paymentlink::whereid($val->payment_link)->first();
                    if($set->email_notify==1){
                        dispatch(new SendPaymentEmail($link->ref_id, $val->payment_type, $val->ref_id));
                    }
                }elseif($val->type==2){
                    $link=Paymentlink::whereid($val->payment_link)->first();
                    $don=Donations::whereref_id($val->ref_id)->first();
                    $don->status=1;
                    $don->save();
                    if($set->email_notify==1){
                        dispatch(new SendPaymentEmail($link->ref_id, $val->payment_type, $val->ref_id));
                    }
                }elseif($val->type==9){
                    $dd = explode('*', $val->payment_link);
                    $link=Sub::whereid($dd[0])->first();
                    $receiver->plan_id=$dd[0];
                    if($dd[1]=="monthly"){
                        $receiver->plan_transactions=$link->transactions;
                        $receiver->plan_payments=$link->payment;
                        $receiver->plan_expired=0;
                        $receiver->plan_expiring=Carbon::now()->add('1 month');
                        $receiver->plan_type="monthly";
                    }
                    if($dd[1]=="annual"){
                        $receiver->plan_transactions=$link->transactions*12;
                        $receiver->plan_payments=$link->payment*12;
                        $receiver->plan_expired=0;
                        $receiver->plan_expiring=Carbon::now()->add('1 year');
                        $receiver->plan_type="annual";
                    }
                    $receiver->used_transactions=null;
                    $receiver->used_payments=null;
                    $receiver->save();
                    if($set->email_notify==1){
                        $gg=[
                            'email'=>$val->email,
                            'name'=>$val->first_name.' '.$val->last_name,
                            'subject'=>'Subscription Payment',
                            'message'=>'Hey you just subscribed to '.$link->name.'. You can now start receiving payment with no charges via gigpots, invoices, selling products and so much more. Thanks for choosing '.$set->site_name
                        ];
                        Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                    }
                }elseif($val->type==3){
                    $ext=Invoice::whereid($val->payment_link)->first();
                    $ext->status=1;
                    $ext->save();
                    if($set->email_notify==1){
                        dispatch(new SendInvoiceReceipt($ext->ref_id, $val->payment_type, $val->ref_id));
                    }
                }elseif($val->type==4){
                    $ext=Exttransfer::wherereference($val->ref_id)->first();
                    $ext->status=1;
                    $ext->save();
                    if($set->email_notify==1){
                        dispatch(new SendMerchant($ext->merchant_key, $val->payment_type, $ext->reference));
                    }
                }elseif($val->type==8){
                    $order=Order::whereid($val->payment_link)->get();
                    foreach($order as $val){
                        $pro=Product::whereid($val->product_id)->first();
                        if($pro->quantity_status==0){
                            $pro->quantity=$pro->quantity-$val->quantity;
                            $pro->sold=$pro->sold+$val->quantity;
                            $pro->save();
                        }
                        $val->status=1;
                        $val->save();
                    }
                    $rrr=Order::whereorder_id($val->track_no)->first();
                    if ($set->email_notify == 1) {
                        dispatch(new SendStoreReceipt($rrr->ref_id, $val->payment_type, $val->ref_id));
                    }
                }
                if($receiver->receive_webhook==1){
                    if($receiver->webhook!=null){
                        send_webhook($val->id);
                    }
                }
                $audit=new Audit();
                $audit->user_id=$receiver->id;
                $audit->trx=$val->ref_id;
                $audit->log='Received payment ' .$val->ref_id;
                $audit->save();
            }
        }
        $this->info('Successfully sent daily quote to everyone.');
    }
}
