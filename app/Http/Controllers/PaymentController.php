<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Income;
use App\Models\Settings;
use App\Models\Transactions;
use App\Models\Paymentlink;
use App\Models\Donations;
use App\Models\Bookings;
use App\Models\Audit;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Order;
use App\Models\Exttransfer;
use App\Models\Sub;
use App\Models\Coupon;
use App\Models\Countrysupported;
use Illuminate\Support\Facades\Session;
use Curl\Curl;
use Illuminate\Support\Facades\Redirect;
// use Carbon\Carbon;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendEmail;
use App\Jobs\SendPaymentEmail;
use App\Jobs\SendMerchant;
use App\Jobs\SendInvoiceReceipt;
use App\Jobs\SendStoreReceipt;
use App\Jobs\SendBookingReceipt;
use App\Models\BankingDetail;
use App\Models\Card;
use App\Models\ComplianceDocument;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use App\Models\RequestMoney;
use App\Models\SubscriptionPlan;
use App\Services\ModulrService;
use App\Services\ModulrServiceAuth;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Issuing\Transaction;

class PaymentController extends Controller
{
    protected $sms;
    protected $service;
    public function __construct() {
        $this->setting = Settings::first();
        $this->yapilyAuthToken = base64_encode($this->setting->auth_key.':'.$this->setting->auth_secret);
    }

    public function bankcallback(Request $request)
    {
        $id = Session('trans');
        $transaction = Transactions::whereRefId($id)->firstOrFail();
        $receiver = User::whereId($transaction->receiver_id)->first();
        if ($transaction->type != 9) {
            $bank = User::whereid($transaction->receiver_id)->first();
            if ($bank->cc->bank_format == "uk") {
                $bank_array = [
                    [
                        'type' => "ACCOUNT_NUMBER",
                        'identification' => '80544825',//$bank->gBPAccount()->accountNumber,
                    ], [
                        'type' => "SORT_CODE",
                        'identification' => '401193',//$bank->gBPAccount()->sortCode,
                    ]
                ];
            } elseif ($bank->cc->bank_format == "eur") {
                $bank_array = [
                    [
                        'type' => "ACCOUNT_NUMBER",
                        'identification' =>  $bank->euroAccount()->accountNumber,
                    ]
                ];
            }
        } else {
            $bank = Countrysupported::whereid($receiver->pay_support)->first();
            $bank_array = [
                [
                    'type' => "ACCOUNT_NUMBER",
                    'identification' => '80544825',//$bank->gBPAccount()->accountNumber,
                ], [
                    'type' => "SORT_CODE",
                    'identification' => '401193',//$bank->gBPAccount()->sortCode,
                ]
            ];
        }
        if (!empty($request->consent)) {
            $receiver->bank_consent = $request->consent;
            $receiver->save();
            $set = Settings::first();
            // $auth_token = base64_encode($receiver->cc->auth_key . ':' . $receiver->cc->auth_secret);
            if ($transaction->type == 1) {
                $d_reference = "Tryba Single Pot";
            } elseif ($transaction->type == 2) {
                $d_reference = "Tryba Multiple Pot";
            } elseif ($transaction->type == 3) {
                $d_reference = "Invoice";
            } elseif ($transaction->type == 4) {
                $d_reference = "Merchant";
            } elseif ($transaction->type == 6) {
                $d_reference = "Subscription";
            } elseif ($transaction->type == 8) {
                $d_reference = "Storefront";
            } elseif ($transaction->type == 9) {
                $d_reference = "Subscription";
            }elseif ($transaction->type == 10) {
                $d_reference = "Appointment";
            }elseif ($transaction->type == 12) {
                $d_reference = "Tryba Request Link";
            }
            $curl = new Curl();
            $curl->setHeader('Authorization', 'Basic ' . $this->yapilyAuthToken);
            $curl->setHeader('Consent', $request->consent);
            $curl->setHeader('Content-Type', 'application/json');
            $data = [
                'type' => "DOMESTIC_PAYMENT",
                'reference' => $d_reference,
                'paymentIdempotencyId' => $transaction->ref_id,
                'amount' => [
                    'amount' => number_format($transaction->amount, 2, '.', ''),
                    'currency' => $transaction->rex->name,
                ],
                'payee' => [
                    'name' => $transaction->user->first_name . ' ' . $transaction->user->last_name,
                    'accountIdentifications' =>
                    $bank_array,
                ],
            ];
            $curl->post("https://api.yapily.com/payments", $data);
            $response = $curl->response;
            Log::info((array) $response);
            $curl->close();
            if ($curl->error) {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors($response->error->status . '-' . $response->error->message);
            } else {
                $transaction->new = 1;
                $transaction->charge_id = $response->data->id;
                $transaction->consent = $request->consent;
                $transaction->tracing_id = $response->meta->tracingId;
                $transaction->save();
                if ($response->data->status == "PENDING") {
                    $transaction->trans_status = $response->data->status;
                    $transaction->save();
                    return redirect()->route('login')->with('toast_warning', 'Payment might be pending due to bank service. Please allow up to 2 hours for the settling bank to return a successful or failed transaction');
                } elseif ($response->data->status == "FAILED") {
                    $transaction->status = 2;
                    $transaction->trans_status = $response->data->status;
                    $transaction->save();
                    return back()->with('toast_warning', 'Payment Failed');
                } elseif ($response->data->status == "COMPLETED") {
                    $transaction->status = 1;
                    $transaction->trans_status = $response->data->status;
                    $transaction->save();
                    if ($transaction->type != 9) {
                        if ($receiver->plan_expired == 0) {
                            $receiver->used_transactions = $receiver->used_transactions + 1;
                            $receiver->used_payments = $receiver->used_payments + $transaction->amount;
                            $receiver->save();
                            if (($receiver->used_payments == $receiver->plan_payments) || ($receiver->used_transactions == $receiver->plan_transactions)) {
                                $receiver->plan_expired == 1;
                                $receiver->save();
                                if ($set->email_notify == 1) {
                                    $gg=[
                                        'email'=>$receiver->email,
                                        'name'=>$receiver->first_name.' '.$receiver->last_name,
                                        'subject'=>'Subscription Expired',
                                        'message'=>'Hey your subscription just expired, you can no longer receive payments. Thanks for choosing ' . $set->site_name
                                    ];
                                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                                }
                            }
                        }
                    }
                    if ($transaction->type == 1) {
                        $link = Paymentlink::whereid($transaction->payment_link)->first();
                        if ($set->email_notify == 1) {
                            dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Single Pot",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                        //platform fee
                        $this->payPlatformFee($transaction,$receiver);
                    } elseif ($transaction->type == 2) {
                        $link = Paymentlink::whereid($transaction->payment_link)->first();
                        $link->donated = $link->donated + $transaction->amount;
                        $link->save();
                        $don = Donations::whereref_id($id)->first();
                        $don->status = 1;
                        $don->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Charity")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Mutiple Pot",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                        //platform fee
                        $this->payPlatformFee($transaction,$receiver);
                    } elseif ($transaction->type == 9) {
                        $dd = explode('*', $transaction->payment_link);
                        $link = Sub::whereid($dd[0])->first();
                        $receiver->plan_id = $dd[0];
                        $receiver->auto_renewal = 1;
                        if ($dd[1] == "monthly") {
                            $receiver->plan_transactions = $link->transactions;
                            $receiver->plan_payments = $link->payment;
                            $receiver->plan_expired = 0;
                            $receiver->plan_type = "monthly";
                            $receiver->plan_expiring = Carbon::now()->add('1 month');;
                        }
                        if ($dd[1] == "annual") {
                            $receiver->plan_transactions = $link->transactions * 12;
                            $receiver->plan_payments = $link->payment * 12;
                            $receiver->plan_expired = 0;
                            $receiver->plan_type = "annual";
                            $receiver->plan_expiring = Carbon::now()->add('1 year');;
                        }
                        $receiver->used_transactions = null;
                        $receiver->used_payments = null;
                        $receiver->save();
                        if ($set->email_notify == 1) {
                            $gg =[
                                'email'=>$receiver->email,
                                'name'=>$receiver->first_name.' '.$receiver->last_name,
                                'subject'=>'Subscription Payment',
                                'message'=>'Hey you just subscribed to ' . $link->name . '. You can now start receiving payment with no charges via gigpots, invoices, selling products and so much more. Thanks for choosing ' . $set->site_name
                            ];
                            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                        }
                    } elseif ($transaction->type == 3) {
                        $invoice = Invoice::whereid($transaction->payment_link)->first();
                        if($invoice->invoice_type == "single"){
                            $invoice->status = 1;
                            $invoice->save();
                        }else{
                            $invoice->due_date = Carbon::parse($invoice->due_date)->addHours($invoice->hourstoNextDue)->format('Y-m-d');
                            $invoice->status = 3;
                            $invoice->save();
                        }

                        if ($set->email_notify == 1) {
                            dispatch(new SendInvoiceReceipt($invoice->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Invoice",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                        //platform fee
                        $this->payPlatformFee($transaction,$receiver);
                    } elseif ($transaction->type == 4) {
                        $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                        $ext->status = 1;
                        $ext->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendMerchant($ext->merchant_key, $transaction->payment_type, $ext->reference));
                        }
                    } elseif ($transaction->type == 8) {
                        $order = Order::whereid($transaction->payment_link)->get();
                        foreach ($order as $val) {
                            $pro = Product::whereid($val->product_id)->first();
                            if ($pro->quantity_status == 0) {
                                $pro->quantity = $pro->quantity - $val->quantity;
                                $pro->sold = $pro->sold + $val->quantity;
                                $pro->save();
                            }
                            $val->status = 1;
                            $val->save();
                        }
                        $rrr=Order::whereorder_id($transaction->track_no)->first();
                        if($rrr->customer_id==null && $rrr->first_name==null){
                            return redirect()->route('complete.order', ['store_url'=>$rrr->storefront->store_url, 'id'=>$rrr->ref_id]);
                        }
                        if ($set->email_notify == 1) {
                            dispatch(new SendStoreReceipt($rrr->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        // Add to income table
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Order paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);

                        return redirect()->route('website.receipt', ['store_url' => $rrr->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    } elseif ($transaction->type == 10) {
                        $booking = Bookings::whereid($transaction->payment_link)->first();
                        $booking->status = 1;
                        $booking->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendBookingReceipt($booking->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Bookings paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);

                        return redirect()->route('website.receipt', ['store_url' => $booking->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    }elseif ($transaction->type == 12) {
                        $link = RequestMoney::whereid($transaction->payment_link)->first();
                        $link->payment_status = true;
                        $link->save();
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Request Link",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    }
                  
                    if ($receiver->receive_webhook == 1) {
                        if ($receiver->webhook != null) {
                            send_webhook($transaction->id);
                        }
                    }
                    if ($receiver->receive_webhook == 1) {
                        if ($receiver->webhook != null) {
                            send_webhook($transaction->id);
                        }
                    }
                    $audit = new Audit();
                    $audit->user_id = $receiver->id;
                    $audit->trx = $id;
                    $audit->log = 'Received payment ' . $id;
                    $audit->save();
                    if ($transaction->type != 4) {
                        return redirect()->route('generate.receipt', ['id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    } else {
                        $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                        return Redirect::away($ext->callback_url);
                    }
                }
            }
            return Redirect::away($response->data->authorisationUrl);
        } else {
            $transaction->status = 2;
            $transaction->save();
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors("Sorry but your payment was cancelled. <a href=".route('bankrecall', ['id'=>$transaction->ref_id]).">Go back?</a>");
        }
    }
    public function bankrecall($id)
    {
        $set=Settings::first();
        $trans=Transactions::whereref_id($id)->first();
        $currency=Countrysupported::whereid($trans->user->pay_support)->first();
        $authToken = base64_encode($currency->auth_key.':'.$currency->auth_secret);
        $curl = new Curl();
        $curl->setHeader('Authorization', 'Basic ' .$authToken);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->get("https://api.yapily.com/institutions");
        $response = $curl->response;
        $curl->close();
        if ($curl->error) {
            $data['title']='Error Message';
            return view('user.merchant.error', $data)->withErrors($response->error->status.'-'.$response->error->message);
        } else{
            Session::put('trans', $trans->ref_id);
            $data['authtoken']=$authToken;
            $data['institution']=$response->data;
            $data['title']='Select Preferred Bank';
            $data['reference']=$trans->ref_id;
            $data['type']=$trans->type;
            $data['bank']=Countrysupported::whereid($trans->user->pay_support)->first();
            $data['amount']=$trans->amount;
            return view('user.dashboard.institution', $data);
        }
    }
    public function cardcallback(Request $request, $id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        $receiver = User::whereid($transaction->receiver_id)->first();
        $set = Settings::first();
        $authToken = base64_encode($set->paypal_clientid . ':' . $set->paypal_secret);
        $curl = new Curl();
        $curl->setHeader('Authorization', 'Basic ' . $authToken);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->get("https://api-m.paypal.com/v1/billing/subscriptions/" . $request->subscription_id);
        $response = $curl->response;
        if ($curl->error) {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors($response->message);
        } else {
            if ($response->status == "ACTIVE") {
                $transaction->status = 1;
                $transaction->charge_id = $response->id;
                $transaction->save();
                $dd = explode('*', $transaction->payment_link);
                $link = Sub::whereid($dd[0])->first();
                $receiver->plan_id = $dd[0];
                $receiver->bank_consent = null;
                if ($dd[1] == "monthly") {
                    $receiver->plan_transactions = $link->transactions;
                    $receiver->plan_payments = $link->payment;
                    $receiver->plan_expired = 0;
                    $receiver->plan_type = "monthly";
                    $receiver->plan_expiring = Carbon::now()->add('1 month');
                }
                if ($dd[1] == "annual") {
                    $receiver->plan_transactions = $link->transactions * 12;
                    $receiver->plan_payments = $link->payment * 12;
                    $receiver->plan_expired = 0;
                    $receiver->plan_type = "annual";
                    $receiver->plan_expiring = Carbon::now()->add('1 year');
                }
                $receiver->used_transactions = null;
                $receiver->used_payments = null;
                $receiver->save();
                if ($set->email_notify == 1) {
                    $gg=[
                        'email'=>$receiver->email,
                        'name'=>$receiver->first_name.' '.$receiver->last_name,
                        'subject'=>'Subscription Payment',
                        'message'=>'Hey you just subscribed to ' . $link->name . '. You can now start receiving payment with no charges via gigpots, invoices, selling products and so much more. Thanks for choosing ' . $set->site_name
                    ];
                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                }
                return redirect()->route('generate.receipt', ['id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
            }
        }
        return Redirect::away($response->data->authorisationUrl);
    }
    public function coinbasesuccess($id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        if ($transaction->status != 1) {
            $receiver = User::whereid($transaction->receiver_id)->first();
            $set = Settings::first();
            $curl = new Curl();
            $curl->setHeader('X-CC-Api-Key', $receiver->coinbase_api_key);
            $curl->setHeader('X-CC-Version', '2018-03-22');
            $curl->setHeader('Content-Type', 'application/json');
            $curl->get("https://api.commerce.coinbase.com/charges/" . $transaction->charge_id);
            $response = $curl->response;
            $curl->close();
            if ($curl->error) {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors($response->error->message);
            } else {
                if ($response->data->payments[0]->status == "CONFIRMED") {
                    $transaction->status = 1;
                    $transaction->save();
                    if ($transaction->type != 9) {
                        if ($receiver->plan_expired == 0) {
                            $receiver->used_transactions = $receiver->used_transactions + 1;
                            $receiver->used_payments = $receiver->used_payments + $transaction->amount;
                            $receiver->save();
                            if (($receiver->used_payments == $receiver->plan_payments) || ($receiver->used_transactions == $receiver->plan_transactions)) {
                                $receiver->plan_expired == 1;
                                $receiver->save();
                                if ($set->email_notify == 1) {
                                    $gg=[
                                        'email'=>$receiver->email,
                                        'name'=>$receiver->first_name.' '.$receiver->last_name,
                                        'subject'=>'Subscription Expired',
                                        'message'=>'Hey your subscription just expired, you can no longer receive payments. Thanks for choosing ' . $set->site_name
                                    ];
                                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                                }
                            }
                        }
                    }
                    if ($transaction->type == 1) {
                        $link = Paymentlink::whereid($transaction->payment_link)->first();
                        if ($set->email_notify == 1) {
                            dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Single Pot",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    } elseif ($transaction->type == 2) {
                        $link = Paymentlink::whereid($transaction->payment_link)->first();
                        $link->donated = $link->donated + $transaction->amount;
                        $link->save();
                        $don = Donations::whereref_id($id)->first();
                        $don->status = 1;
                        $don->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Charity")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Mutiple Pot",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    } elseif ($transaction->type == 3) {
                        $invoice = Invoice::whereid($transaction->payment_link)->first();
                        if($invoice->invoice_type == "single"){
                            $invoice->status = 1;
                            $invoice->save();
                        }else{
                            $invoice->due_date = Carbon::parse($invoice->due_date)->addHours($invoice->hourstoNextDue)->format('Y-m-d');
                            $invoice->status = 3;
                            $invoice->save();
                        }
                        if ($set->email_notify == 1) {
                            dispatch(new SendInvoiceReceipt($invoice->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Invoice",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    } elseif ($transaction->type == 4) {
                        $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                        $ext->status = 1;
                        $ext->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendMerchant($ext->merchant_key, $transaction->payment_type, $ext->reference));
                        }
                    } elseif ($transaction->type == 8) {
                        $order = Order::whereid($transaction->payment_link)->get();
                        foreach ($order as $val) {
                            $pro = Product::whereid($val->product_id)->first();
                            if ($pro->quantity_status == 0) {
                                $pro->quantity = $pro->quantity - $val->quantity;
                                $pro->sold = $pro->sold + $val->quantity;
                                $pro->save();
                            }
                            $val->status = 1;
                            $val->save();
                        }
                        $rrr=Order::whereorder_id($transaction->track_no)->first();
                        if($rrr->customer_id==null && $rrr->first_name==null){
                            return redirect()->route('complete.order', ['store_url'=>$rrr->storefront->store_url, 'id'=>$rrr->ref_id]);
                        }
                        if ($set->email_notify == 1) {
                            dispatch(new SendStoreReceipt($rrr->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        // Add to income table
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Order paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                        return redirect()->route('website.receipt', ['store_url' => $rrr->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    } elseif ($transaction->type == 10) {
                        $booking = Bookings::whereid($transaction->payment_link)->first();
                        $booking->status = 1;
                        $booking->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendBookingReceipt($booking->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "bookingd paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);

                        return redirect()->route('website.receipt', ['store_url' => $booking->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    }
                    if ($receiver->receive_webhook == 1) {
                        if ($receiver->webhook != null) {
                            send_webhook($transaction->id);
                        }
                    }
                    $audit = new Audit();
                    $audit->user_id = $receiver->id;
                    $audit->trx = $id;
                    $audit->log = 'Received payment ' . $id;
                    $audit->save();
                    if ($transaction->type != 4) {
                        return redirect()->route('generate.receipt', ['id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    } else {
                        $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                        return Redirect::away($ext->callback_url);
                    }
                }
            }
        } else {
            $data['title'] = 'Transaction Update';
            return view('user.merchant.success', $data)->withErrors('Payment has already been confirmed');
        }
    }
    public function paypalsuccess($id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        if ($transaction->status != 1) {
            $receiver = User::whereid($transaction->receiver_id)->first();
            $set = Settings::first();
            $authToken = base64_encode($receiver->paypal_client_id . ':' . $receiver->paypal_secret_key);
            $curl = new Curl();
            $curl->setHeader('Authorization', 'Basic ' . $authToken);
            $curl->setHeader('Content-Type', 'application/json');
            $curl->post(env('PAYPAL_URL')."v2/checkout/orders/" . $transaction->charge_id . "/capture");
            $response = $curl->response;
            $curl->close();
            if ($curl->error) {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors($response->message);
            } else {
                if ($response->status == "COMPLETED") {
                    $transaction->status = 1;
                    $transaction->save();
                    if ($transaction->type != 9) {
                        if ($receiver->plan_expired == 0) {
                            $receiver->used_transactions = $receiver->used_transactions + 1;
                            $receiver->used_payments = $receiver->used_payments + $transaction->amount;
                            $receiver->save();
                            if (($receiver->used_payments == $receiver->plan_payments) || ($receiver->used_transactions == $receiver->plan_transactions)) {
                                $receiver->plan_expired == 1;
                                $receiver->save();
                                if ($set->email_notify == 1) {
                                    $gg=[
                                        'email'=>$receiver->email,
                                        'name'=>$receiver->first_name.' '.$receiver->last_name,
                                        'subject'=>'Subscription Expired',
                                        'message'=>'Hey your subscription just expired, you can no longer receive payments. Thanks for choosing ' . $set->site_name
                                    ];
                                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                                }
                            }
                        }
                    }
                    if ($transaction->type == 1) {
                        $link = Paymentlink::whereid($transaction->payment_link)->first();
                        if ($set->email_notify == 1) {
                            dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Single Pot",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    } elseif ($transaction->type == 2) {
                        $link = Paymentlink::whereid($transaction->payment_link)->first();
                        $link->donated = $link->donated + $transaction->amount;
                        $link->save();
                        $don = Donations::whereref_id($id)->first();
                        $don->status = 1;
                        $don->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Charity")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Mutiple Pot",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    } elseif ($transaction->type == 3) {
                        $invoice = Invoice::whereid($transaction->payment_link)->first();
                        if($invoice->invoice_type == "single"){
                            $invoice->status = 1;
                            $invoice->save();
                        }else{
                            $invoice->due_date = Carbon::parse($invoice->due_date)->addHours($invoice->hourstoNextDue);
                            $invoice->status = 3;
                            $invoice->save();
                        }
                        if ($set->email_notify == 1) {
                            dispatch(new SendInvoiceReceipt($invoice->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Invoice",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    } elseif ($transaction->type == 4) {
                        $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                        $ext->status = 1;
                        $ext->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendMerchant($ext->merchant_key, $transaction->payment_type, $ext->reference));
                        }
                    } elseif ($transaction->type == 8) {
                        $order = Order::whereid($transaction->payment_link)->get();
                        foreach ($order as $val) {
                            $pro = Product::whereid($val->product_id)->first();
                            if ($pro->quantity_status == 0) {
                                $pro->quantity = $pro->quantity - $val->quantity;
                                $pro->sold = $pro->sold + $val->quantity;
                                $pro->save();
                            }
                            $val->status = 1;
                            $val->save();
                        }
                        $rrr=Order::whereorder_id($transaction->track_no)->first();
                        if($rrr->customer_id==null && $rrr->first_name==null){
                            return redirect()->route('complete.order', ['store_url'=>$rrr->storefront->store_url, 'id'=>$rrr->ref_id]);
                        }
                        if ($set->email_notify == 1) {
                            dispatch(new SendStoreReceipt($rrr->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        // Add to income table
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Order paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                        return redirect()->route('website.receipt', ['store_url' => $rrr->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    } elseif ($transaction->type == 10) {
                        $booking = Bookings::whereid($transaction->payment_link)->first();
                        $booking->status = 1;
                        $booking->save();
                        if ($set->email_notify == 1) {
                            dispatch(new SendBookingReceipt($booking->ref_id, $transaction->payment_type, $id));
                        }
                        $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "bookingd paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                        return redirect()->route('website.receipt', ['store_url' => $booking->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    }
                    elseif ($transaction->type == 12) {
                        $link = RequestMoney::whereid($transaction->payment_link)->first();
                        $link->payment_status = true;
                        $link->save();
                        $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "Request Link",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    }
                    if ($receiver->receive_webhook == 1) {
                        if ($receiver->webhook != null) {
                            send_webhook($transaction->id);
                        }
                    }
                    if ($receiver->receive_webhook == 1) {
                        if ($receiver->webhook != null) {
                            send_webhook($transaction->id);
                        }
                    }
                    $audit = new Audit();
                    $audit->user_id = $receiver->id;
                    $audit->trx = $id;
                    $audit->log = 'Received payment ' . $id;
                    $audit->save();
                    if ($transaction->type != 4) {
                        return redirect()->route('generate.receipt', ['id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                    } else {
                        $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                        return Redirect::away($ext->callback_url);
                    }
                }
            }
        } else {
            $data['title'] = 'Transaction Update';
            return view('user.merchant.success', $data)->withErrors('Payment has already been confirmed');
        }
    }
    public function stripesuccess($id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        if ($transaction->status != 1) {
            $receiver = User::whereid($transaction->receiver_id)->first();
            $set = Settings::first();
            $stripe = new StripeClient($receiver->stripe_secret_key);
            $charge = $stripe->checkout->sessions->retrieve($transaction->charge_id);
            if ($charge['payment_status'] == "paid") {
                $transaction->status = 1;
                $transaction->save();
                if ($transaction->type != 9) {
                    if ($receiver->plan_expired == 0) {
                        $receiver->used_transactions = $receiver->used_transactions + 1;
                        $receiver->used_payments = $receiver->used_payments + $transaction->amount;
                        $receiver->save();
                        if (($receiver->used_payments == $receiver->plan_payments) || ($receiver->used_transactions == $receiver->plan_transactions)) {
                            $receiver->plan_expired == 1;
                            $receiver->save();
                            if ($set->email_notify == 1) {
                                $gg=[
                                    'email'=>$receiver->email,
                                    'name'=>$receiver->first_name.' '.$receiver->last_name,
                                    'subject'=>'Subscription Expired',
                                    'message'=>'Hey your subscription just expired, you can no longer receive payments. Thanks for choosing ' . $set->site_name
                                ];
                                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                            }
                        }
                    }
                }
                if ($transaction->type == 1) {
                    $link = Paymentlink::whereid($transaction->payment_link)->first();
                    if ($set->email_notify == 1) {
                        dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                    }
                    $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                    $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                    Income::create([
                        'uuid' => $transaction->receiver_id,
                        'name' => $transaction->ref_id,
                        'description' => "Single Pot",
                        'categoryID' => $category->id,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'amount' => $transaction->amount,
                        'subcategoryID' => $subCategory->id,
                        'invoiceurl' => "",
                    ]);
                } elseif ($transaction->type == 2) {
                    $link = Paymentlink::whereid($transaction->payment_link)->first();
                    $link->donated = $link->donated + $transaction->amount;
                    $link->save();
                    $don = Donations::whereref_id($id)->first();
                    $don->status = 1;
                    $don->save();
                    if ($set->email_notify == 1) {
                        dispatch(new SendPaymentEmail($link->ref_id, $transaction->payment_type, $id));
                    }
                    $category = ExpenseCategory::whereuuid(0)->where("name","Charity")->first();
                    $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                    Income::create([
                        'uuid' => $transaction->receiver_id,
                        'name' => $transaction->ref_id,
                        'description' => "Mutiple Pot",
                        'categoryID' => $category->id,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'amount' => $transaction->amount,
                        'subcategoryID' => $subCategory->id,
                        'invoiceurl' => "",
                    ]);
                } elseif ($transaction->type == 3) {
                    $invoice = Invoice::whereid($transaction->payment_link)->first();
                        if($invoice->invoice_type == "single"){
                            $invoice->status = 1;
                            $invoice->save();
                        }else{
                            $invoice->due_date = Carbon::parse($invoice->due_date)->addHours($invoice->hourstoNextDue)->format('Y-m-d');
                            $invoice->status = 3;
                            $invoice->save();
                        }

                        if ($set->email_notify == 1) {
                            dispatch(new SendInvoiceReceipt($invoice->ref_id, $transaction->payment_type, $id));
                        }
                    $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                    $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                    Income::create([
                        'uuid' => $transaction->receiver_id,
                        'name' => $transaction->ref_id,
                        'description' => "Invoice",
                        'categoryID' => $category->id,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'amount' => $transaction->amount,
                        'subcategoryID' => $subCategory->id,
                        'invoiceurl' => "",
                    ]);
                } elseif ($transaction->type == 4) {
                    $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                    $ext->status = 1;
                    $ext->save();
                    if ($set->email_notify == 1) {
                        dispatch(new SendMerchant($ext->merchant_key, $transaction->payment_type, $ext->reference));
                    }
                } elseif ($transaction->type == 8) {
                    $order = Order::whereid($transaction->payment_link)->get();
                    foreach ($order as $val) {
                        $pro = Product::whereid($val->product_id)->first();
                        if ($pro->quantity_status == 0) {
                            $pro->quantity = $pro->quantity - $val->quantity;
                            $pro->sold = $pro->sold + $val->quantity;
                            $pro->save();
                        }
                        $val->status = 1;
                        $val->save();
                    }
                    $rrr=Order::whereorder_id($transaction->track_no)->first();
                    if($rrr->customer_id==null && $rrr->first_name==null){
                        return redirect()->route('complete.order', ['store_url'=>$rrr->storefront->store_url, 'id'=>$rrr->ref_id]);
                    }
                    if ($set->email_notify == 1) {
                        dispatch(new SendStoreReceipt($rrr->ref_id, $transaction->payment_type, $id));
                    }
                    $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                    $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                    // Add to income table
                    Income::create([
                        'uuid' => $transaction->receiver_id,
                        'name' => $transaction->ref_id,
                        'description' => "Order paid",
                        'categoryID' => $category->id,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'amount' => $transaction->amount,
                        'subcategoryID' => $subCategory->id,
                        'invoiceurl' => "",
                    ]);
                    return redirect()->route('website.receipt', ['store_url' => $rrr->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                } elseif ($transaction->type == 10) {
                    $booking = Bookings::whereid($transaction->payment_link)->first();
                    $booking->status = 1;
                    $booking->save();
                    if ($set->email_notify == 1) {
                        dispatch(new SendBookingReceipt($booking->ref_id, $transaction->payment_type, $id));
                    }
                    $category = ExpenseCategory::whereuuid(0)->where("name","Sales")->first();
                        $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                        Income::create([
                            'uuid' => $transaction->receiver_id,
                            'name' => $transaction->ref_id,
                            'description' => "bookingd paid",
                            'categoryID' => $category->id,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $transaction->amount,
                            'subcategoryID' => $subCategory->id,
                            'invoiceurl' => "",
                        ]);
                    return redirect()->route('website.receipt', ['store_url' => $booking->storefront->store_url, 'id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
        
                }elseif ($transaction->type == 12) {
                    $link = RequestMoney::whereid($transaction->payment_link)->first();
                    $link->payment_status = true;
                    $link->save();
                    $category = ExpenseCategory::whereuuid(0)->where("name","Payment")->first();
                    $subCategory = ExpenseSubcategory::whereuuid(0)->where("categoryID",$category->id)->first();
                    Income::create([
                        'uuid' => $transaction->receiver_id,
                        'name' => $transaction->ref_id,
                        'description' => "Request Link",
                        'categoryID' => $category->id,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'amount' => $transaction->amount,
                        'subcategoryID' => $subCategory->id,
                        'invoiceurl' => "",
                    ]);
                }


                if ($receiver->receive_webhook == 1) {
                    if ($receiver->webhook != null) {
                        send_webhook($transaction->id);
                    }
                }
                if ($receiver->receive_webhook == 1) {
                    if ($receiver->webhook != null) {
                        send_webhook($transaction->id);
                    }
                }
                $audit = new Audit();
                $audit->user_id = $receiver->id;
                $audit->trx = $id;
                $audit->log = 'Received payment ' . $id;
                $audit->save();
                if ($transaction->type != 4) {
                    return redirect()->route('generate.receipt', ['id' => $transaction->ref_id])->with('toast_success', 'Payment was successful');
                } else {
                    $ext = Exttransfer::wherereference($transaction->ref_id)->first();
                    return Redirect::away($ext->callback_url);
                }
            }
        } else {
            $data['title'] = 'Transaction Update';
            return view('user.merchant.success', $data)->withErrors('Payment has already been confirmed');
        }
    }
    public function coinbasecancelled($id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        $receiver = User::whereid($transaction->receiver_id)->first();
        $transaction->status = 2;
        $transaction->save();
        return Redirect::away(Session::get('return_url'));
    }
    public function stripecancelled($id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        $receiver = User::whereid($transaction->receiver_id)->first();
        $transaction->status = 2;
        $transaction->save();
        return Redirect::away(Session::get('return_url'));
    }
    public function paypalcancelled($id)
    {
        $transaction = Transactions::whereref_id($id)->first();
        $receiver = User::whereid($transaction->receiver_id)->first();
        $transaction->status = 2;
        $transaction->save();
        return Redirect::away(Session::get('return_url'));
    }
    public function authorize_payment($ref_id,Request $request)
    {
        $transaction = Transactions::whereref_id($ref_id)->first();
        $receiver = User::whereid($transaction->receiver_id)->first();
        if ($transaction->type != 9) {
            $bank = User::whereid($transaction->receiver_id)->first();
            if ($bank->cc->bank_format == "uk") {
                $bank_array = [
                    [
                        'type' => "ACCOUNT_NUMBER",
                        'identification' => '80544825',//$bank->gBPAccount()->accountNumber,
                    ], [
                        'type' => "SORT_CODE",
                        'identification' => '401193',//$bank->gBPAccount()->sortCode,
                    ]
                ];
            } elseif ($bank->cc->bank_format == "eur") {
                $bank_array = [
                    [
                        'type' => "ACCOUNT_NUMBER",
                        'identification' => $bank->euroAccount()->accountNumber,
                    ]
                ];
            }
        } else {
            $bank = Countrysupported::whereid($receiver->pay_support)->first();
            $bank_array = [
                [
                    'type' => "ACCOUNT_NUMBER",
                    'identification' => '80544825',//$bank->gBPAccount()->accountNumber,
                ], [
                    'type' => "SORT_CODE",
                    'identification' => '401193',//$bank->gBPAccount()->sortCode,
                ]
            ];
        }

        if ($transaction->type  == 1) {
            $d_reference = "Tryba Single Pot";
        } elseif ($transaction->type == 2) {
            $d_reference = "Tryba Multiple Pot";
        } elseif ($transaction->type  == 3) {
            $d_reference = "Invoice";
        } elseif ($transaction->type  == 4) {
            $d_reference = "Merchant";
        } elseif ($transaction->type  == 6) {
            $d_reference = "Subscription";
        } elseif ($transaction->type  == 8) {
            $d_reference = "Storefront";
        } elseif ($transaction->type  == 9) {
            $d_reference = "Subscription";
        }elseif ($transaction->type  == 12) {
            $d_reference = "Tryba Request Link";
        }
        $set = Settings::first();
        //Generate Auth Key
        $authToken = base64_encode($set->auth_key.':'.$set->auth_secret);
        $curl = new Curl();
        $curl->setHeader("Authorization", "Basic " . $authToken);
        $curl->setHeader("Content-Type", "application/json");
        $data = [
            'applicationUserId' => $transaction->user->email,
            'institutionId' => $request->bank_id,
            'callback' => route('bankcallback'),
            'paymentRequest' => [
                'type' => "DOMESTIC_PAYMENT",
                'reference' => $d_reference,
                'paymentIdempotencyId' => $ref_id,
                'amount' => [
                    'amount' => number_format($transaction->amount, 2, '.', ''),
                    'currency' => $transaction->rex->name,
                ],
                'payee' => [
                    'name' => $transaction->user->first_name . ' ' . $transaction->user->last_name,
                    'accountIdentifications' =>
                    $bank_array,
                ],
            ],
        ];
        $curl->post("https://api.yapily.com/payment-auth-requests", $data);
        $response = $curl->response;
        $curl->close();
        if ($curl->error) {
            $data["title"] = "Error Message";
            return view("user.merchant.error", $data)->withErrors($response->error->status . "-" . $response->error->message);
        } else {
            $transaction->tracing_id = $response->meta->tracingId;
            $transaction->save();
            Session::put("trans", $transaction->ref_id);
            return Redirect::away($response->data->authorisationUrl);
        }
    }

    public function createPaymentAuthorization($id, $amount, $bankId, $transactionType) {
        // $transaction = Transaction::whereRefId($reference)->first();
        $user = User::find($id);
        $reference = bin2hex(\random_bytes(6));
        $ref_id = randomNumber(11);
        if ($user->cc->bank_format == "uk") {
            $bank_array = [
                    [
                        'type' => "ACCOUNT_NUMBER",
                        'identification' => '80544825',//$user->gBPAccount()->accountNumber,
                    ], [
                        'type' => "SORT_CODE",
                        'identification' => '401193',//$user->gBPAccount()->sortCode,
                    ]
                ];
        }
        elseif ($user->cc->bank_format == "eur") {
            $bank_array = [
                [
                    'type' => "ACCOUNT_NUMBER",
                    'identification' => $user->euroAccount()->accountNumber,
                ]
            ];
        }
        switch ($transactionType) {
            case 1:
                $d_reference = 'Tryba Single Pot';
                break;
            case 2:
                $d_reference = "Tryba Multiple Pot";
                break;
            case 3:
                $d_reference = "Invoice";
                break;
            case 4:
                $d_reference = "Merchant";
                break;
            case 6:
                $d_reference = "Subscription";
                break;
            case 8:
                $d_reference = "Storefront";
                break;
            case 8:
                $d_reference = "Subscription";
                break;
              case 12:
                $d_reference = "Tryba Request Link";
                break;
            default:
                $d_reference = "Subscription";
                break;
        }


        $payload = [
            'applicationUserId' => $user->email,
            'institutionId' => $bankId,
            'callback' => 'https://dev.tryba.io/bank-callback', //route('bankcallback'),
            'paymentRequest' => [
                'type' => "DOMESTIC_PAYMENT",
                'reference' => $d_reference,
                'paymentIdempotencyId' => $reference,
                'amount' => [
                    'amount' => number_format($amount, 2),
                    'currency' => 'GBP', //$currency,
                ],
                'payee' => [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'accountIdentifications' => $bank_array,
                ],
                'address' => [
                    'country' => 'GB'
                ]
            ],
        ];

        $query = Http::withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8',
            'Accept' => 'application/json;charset=UTF-8',
            'Authorization' => 'Basic '.$this->yapilyAuthToken
        ])->post($this->yapilyUrl.'/payment-auth-requests', $payload);
        Log::info($query);
        if(isset($query['data']) && isset($query['data']["authorisationUrl"])) {
            session()->put('trans', $ref_id);
            Transactions::create([
                'user_id'      => $user->id,
                'reference'    => $query['meta']['tracingId'],
                'currency'     => 19 ,
                'receiver_id'  => $user->id,
                'amount'       => $amount,
                'type'         => 9,
                'ref_id'       => $ref_id,
                'trans_status' => $query['data']['status']
            ]);
            return redirect($query['data']['authorisationUrl']);
        }
        $data['title'] = 'Error Message';
        return view('user.merchant.error', $data)->withErrors($query['error']['message']);
    }

    public function payPlatformFee($transaction,$receiver){
        $fee = $transaction->amount * 1/100;
        $payment = new UserController(new SmsService ,new ModulrService(new ModulrServiceAuth,new NotificationService() ,new Invoice(),new Transactions(), new ComplianceDocument(), new BankingDetail(),new Card(), new User()));
        $bankDetails = BankingDetail::where('user_id',$receiver->id)->first();
        $suceess = $payment->payRequest($bankDetails,$fee);
        if ($suceess) {
            Transactions::create([
                'ref_id' => randomNumber(11),
                'type' => 11,
                'amount' => $fee,
                'email' => 'support@tryba.io',
                'first_name' => 'Tryba',
                'last_name' => 'io',
                'ip_address' => user_ip(),
                'receiver_id' => $receiver->id,
                'currency' =>getUserCurrencyDetails($receiver)->id,
                'payment_type' => 'bank',
                'status' => 1
            ]);
        }

    }

    public function getYapilyInstitution(){
        $set = Settings::first();
         //Generate Auth Key
         $authToken = base64_encode($set->auth_key.':'.$set->auth_secret);
         $curl = new Curl();
         $curl->setHeader('Authorization', 'Basic ' .$authToken);
         $curl->setHeader('Content-Type', 'application/json');
         $curl->get("https://api.yapily.com/institutions");
         $response = $curl->response;
         $curl->close();   
         if ($curl->error) {
            return response()->json(['error' => $response->error->status.'-'.$response->error->message],400);
         }else{
            return response()->json(['institution' => $response->data],200);
         }    
    }
    
    public function getTransactionToPay($ref_id){
        $transaction = Transactions::where('ref_id',$ref_id)->firstorFail();
        if ($transaction->status == 0) {
            $set = Settings::first();
            $data['title'] = "Open banking checkout";
            $data['plans'] = SubscriptionPlan::all();
            return view('checkout.index', [
                'transaction' =>  $transaction,
                'title' => "Open banking checkout"
            ]);
        }
    }

    public function getTransactionTopayData($ref_id){
        $transaction = Transactions::where('ref_id',$ref_id)->with('rex')->firstorFail();
        return response()->json(['transaction' =>$transaction],200);
    }
}
