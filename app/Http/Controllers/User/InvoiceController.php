<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Settings;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transactions;
use App\Models\Audit;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Curl\Curl;
use Session;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendEmail;
use App\Jobs\SendSms;
use App\Jobs\SendInvoice;
use App\Jobs\SendInvoiceReceipt;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Mail;



class InvoiceController extends Controller
{
    public function Editcustomer($id)
    {
        $data['customer'] = $customer = Customer::whereref_id($id)->first();
        $data['title'] = $customer->first_name.' '.$customer->last_name;
        return view('user.invoice.edit-customer', $data);
    }
    public function addcustomer()
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $data['title'] = 'Create customer';
            return view('user.invoice.create-customer', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function updatecustomer(Request $request,$id)
    {   
        $validator = Validator::make( $request->all(),[
            'email' => 'required|string|max:50',
            'company_name' =>'nullable|string|max:50',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:14',
            'line_1' => 'required|string|max:200',
            'line_2' => 'nullable|max:200',
            'postal_code' => 'required|max:10',
            'code' => 'required|string',
            'state' =>'required|exists:counties,id',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }
        $set = Settings::first();        
        if ($set->invoice == 1) {
            try {
                $validatorf = new EmailValidator();
                $multipleValidations = new MultipleValidationWithAnd([
                    new RFCValidation(),
                    new DNSCheckValidation()
                ]);
                if ($validatorf->isValid($request->email, $multipleValidations)) {
                } 
                else {
                    return back()->withInput()->with('toast_warning', 'Invalid email address');
                }
                $phone = PhoneNumber::make($request->phone, $request->code)->formatE164();
                $sav = Customer::whereref_id($id)->first();
                $sav->email = $request->email;
                $sav->company_name = $request->company_name;
                $sav->first_name = $request->first_name;
                $sav->last_name = $request->last_name;
                $sav->split_phone = $request->phone;
                $sav->phone = $phone;
                $sav->state = $request->state;
                $sav->country = $request->country;
                $sav->code = $request->code;
                $sav->city = $request->city;
                $sav->line_1 = $request->line_1;
                $sav->line_2 = $request->line_2;
                $sav->postal_code = $request->postal_code;
                $sav->save();
                return redirect()->route('user.customer')->with('toast_success', 'Customer successfully updated');
            } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            }
            
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function submitcustomer(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'email' => 'required|string|max:50',
            'company_name' =>'nullable|string|max:50',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:14',
            'line_1' => 'required|string|max:200',
            'line_2' => 'nullable|max:200',
            'postal_code' => 'required|max:10',
            'code' => 'required|string',
            'state' =>'required|exists:counties,id',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }
        $set = Settings::first();
        if ($set->invoice == 1) {
            $user = User::find(Auth::guard('user')->user()->id);
            try {
                $validatorf = new EmailValidator();
                $multipleValidations = new MultipleValidationWithAnd([
                    new RFCValidation(),
                    new DNSCheckValidation()
                ]);
                if ($validatorf->isValid($request->email, $multipleValidations)) {
                } else {
                    return back()->withInput()->with('toast_warning', 'Invalid email address');
                }
                $phone = PhoneNumber::make($request->phone, $request->code)->formatE164();
                $sav = new Customer();
                $sav->user_id = Auth::guard('user')->user()->id;
                $sav->ref_id = 'CUS-' . str_random(6);
                $sav->email = $request->email;
                $sav->company_name = $request->company_name;
                $sav->first_name = $request->first_name;
                $sav->last_name = $request->last_name;
                $sav->split_phone = $request->phone;
                $sav->phone = $phone;
                $sav->code = $request->code;
                $sav->address = $request->address;
                $sav->mode = $user->live;
                $sav->country = $request->country;
                $sav->state = $request->state;   
                $sav->city = $request->city;
                $sav->line_1 = $request->line_1;
                $sav->line_2 = $request->line_2;
                $sav->postal_code = $request->postal_code;
                $sav->save();
                return redirect()->route('user.customer')->with('toast_success', 'Customer successfully created');
            } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
                return back()->withInput()->with('toast_warning', $e->getMessage());
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function Destroycustomer($id)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $check = Invoice::wherecustomer_id($id)->count();
            if ($check == 0) {
                $link = Customer::whereref_id($id)->first();
                $data = $link->delete();
                if ($data) {
                    return back()->with('toast_success', 'Customer was Successfully deleted!');
                } else {
                    return back()->with('toast_warning', 'Error With Deleting Customer');
                }
            } else {
                return back()->with('toast_warning', 'Error with deleting customer, customer has been registered to an invoice');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    //End
    public function invoice()
    {
        $set = Settings::first();
        $xf = auth()->guard('user')->user()->getCountrySupported();
        if ($set->invoice == 1) {
            if ($xf->invoice == 1) {
                $data['title'] = 'Invoice';
                return view('user.invoice.index', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Invoice is not available for your country');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function Editinvoice($id)
    {
        $invoice = Invoice::whereref_id($id)->firstorFail();
        $data['amount'] = json_decode($invoice->amount, true);
        $data['quantity'] = json_decode($invoice->quantity, true);
        $data['notes'] = json_decode($invoice->notes, true);
        $data['tax'] = json_decode($invoice->tax, true);
        $data['discount'] = json_decode($invoice->discount, true);
        $data['total'] = json_decode($invoice->total, true);
        $invoice->due_date = Carbon::createFromFormat('Y-m-d', $invoice->due_date)->format('m/d/Y');
        $data['title'] = $invoice->ref_id;
        $data['customer'] = Customer::whereuser_id(Auth::guard('user')->user()->id)->get();
        $data['invoice'] = $invoice;
        if ($invoice->status == 0) {
            return view('user.invoice.edit', $data);
        } else {
            return back()->with('toast_warning', 'You can\'t edit a paid invoice');
        }
    }
    public function previewinvoice($id)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $data['title'] = 'Preview';
            $data['invoice'] = $invoice = Invoice::whereref_id($id)->firstorFail();
            $check = Customer::whereid($invoice->customer_id)->count();
            if ($check > 0) {
                $data['amount'] = json_decode($invoice->amount, true);
                $data['quantity'] = json_decode($invoice->quantity, true);
                $data['notes'] = json_decode($invoice->notes, true);
                $data['tax'] = json_decode($invoice->tax, true);
                $data['discount'] = json_decode($invoice->discount, true);
                $data['total'] = json_decode($invoice->total, true);
                $data['link'] = $invoice = Invoice::whereref_id($id)->first();
                $data['merchant'] = User::whereid($invoice->user_id)->first();
                return view('user.invoice.preview', $data);
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('No customer was found for this invoice');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function downloadinvoice($id)
    {
        $set = Settings::first();
        $data['title'] = 'Preview';
        $data['invoice'] = $invoice = Invoice::whereref_id($id)->first();
        $data['amount'] = json_decode($invoice->amount, true);
        $data['quantity'] = json_decode($invoice->quantity, true);
        $data['notes'] = json_decode($invoice->notes, true);
        $data['tax'] = json_decode($invoice->tax, true);
        $data['discount'] = json_decode($invoice->discount, true);
        $data['total'] = json_decode($invoice->total, true);
        $data['link'] = $invoice = Invoice::whereref_id($id)->first();
        $data['merchant'] = $merchant = User::whereid($invoice->user_id)->first();
        //return view('user.invoice.export_pdf', $data);
        $pdf = SnappyPdf::loadView('user.invoice.export_pdf', $data);
        return $pdf->download($id . '.pdf');
    }
    public function addinvoice()
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $data['title'] = 'Create invoice';
            $data['customer'] = Customer::whereuser_id(Auth::guard('user')->user()->id)->get();
            return view('user.invoice.create', $data);
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function updateinvoice(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'customer_id' => 'required|exists:customer,id',
            'due_date' =>'required|date',
            'invoice_type' => 'required|in:single,recurring',
            'item_name' => 'required|array',
            'amount' => 'required|array',
            'quantity' => 'required|array',
            'tax' => 'required|array',
            'discount' => 'required|array',
            'note' => 'required|array',
            'invoice_time' => 'required_if:invoice_type,recurring|in:daily,monthly,yearly,quarterly,semiannually'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $set = Settings::first();
        if ($set->invoice == 1) {
            $user = $data['user'] = User::find(Auth::guard('user')->user()->id);
            $currency= $user->getCountrySupported();
            $set = Settings::first();
            foreach ($request->item_name as $key => $value) {
                $item_name[] = $value;
                $quantity[] = $request->quantity[$key];
                $amount[] = $request->amount[$key];
                $discount[] = $request->discount[$key];
                $tax[] = $request->tax[$key];
                $notes[] = $request->note[$key];
                $total[] = (($request->amount[$key] * $request->quantity[$key] * $request->tax[$key] / 100) + ($request->amount[$key] * $request->quantity[$key]) - ($request->amount[$key] * $request->quantity[$key] * $request->discount[$key] / 100));
            }
            $hour = 0;
            if($request->invoice_time == "daily"){
                $hour = 24;
            }
            elseif($request->invoice_time == "quarterly"){
                $hour = 2190;
            }
            elseif($request->invoice_time == "semiannually"){
                $hour = 4380;
            }
            elseif($request->invoice_time == "monthly"){
                $hour = 730;
            }
            elseif($request->invoice_time == "yearly"){
                $hour = 8760;
            }

            $sav = Invoice::whereid($request->id)->first();
            $sav->item = json_encode($item_name);
            $sav->quantity = json_encode($quantity);
            $sav->amount = json_encode($amount);
            $sav->discount = json_encode($discount);
            $sav->tax = json_encode($tax);
            $sav->total = json_encode($total);
            $sav->real_total = json_encode(array_sum($total));
            $sav->notes = json_encode($notes);
            $sav->customer_id = $request->customer_id;
            $sav->due_date = Carbon::createFromFormat('m/d/Y', $request->due_date)->format('Y-m-d');
            $sav->currency = $currency->coin_id;
            $sav->invoice_type = $request->invoice_type;
            $sav->hourstoNextDue = $hour;
            $sav->noOfPayments = 0;
            $sav->save();
            return back()->with('toast_success', 'Saved');
            
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function submitinvoice(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'customer_id' => 'required|exists:customer,id',
            'due_date' =>'required|date|after_or_equal:' . now()->format ('Y-m-d'),
            'invoice_type' => 'required|in:single,recurring',
            'item_name' => 'required|array',
            'amount' => 'required|array',
            'quantity' => 'required|array',
            'tax' => 'required|array',
            'discount' => 'required|array',
            'note' => 'required|array',
            'invoice_time' => 'required_if:invoice_type,recurring|in:daily,monthly,yearly,quarterly,semiannually'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $set = Settings::first();
        if ($set->invoice == 1) {
            $user = User::find(Auth::guard('user')->user()->id);
            $currency = $user->getCountrySupported();
            $token = 'INV-'.str_random(6);
            
            foreach ($request->item_name as $key => $value) {
                $item_name[] = $value;
                $quantity[] = $request->quantity[$key];
                $amount[] = $request->amount[$key];
                $discount[] = $request->discount[$key];
                $tax[] = $request->tax[$key];
                $notes[] = $request->note[$key];
                $total[] = (($request->amount[$key] * $request->quantity[$key] * $request->tax[$key] / 100) + ($request->amount[$key] * $request->quantity[$key]) - ($request->amount[$key] * $request->quantity[$key] * $request->discount[$key] / 100));
            }

            $hour = 0;
            if($request->invoice_time == "daily"){
                $hour = 24;
            }
            elseif($request->invoice_time == "quarterly"){
                $hour = 2190;
            }
            elseif($request->invoice_time == "semiannually"){
                $hour = 4380;
            }
            elseif($request->invoice_time == "monthly"){
                $hour = 730;
            }
            elseif($request->invoice_time == "yearly"){
                $hour = 8760;
            }
            // Creating Invoice here
            $sav = new Invoice();
            $sav->item = json_encode($item_name);
            $sav->quantity = json_encode($quantity);
            $sav->amount = json_encode($amount);
            $sav->discount = json_encode($discount);
            $sav->tax = json_encode($tax);
            $sav->total = json_encode($total);
            $sav->real_total = json_encode(array_sum($total));
            $sav->notes = json_encode($notes);
            $sav->user_id = Auth::guard('user')->user()->id;
            $sav->customer_id = $request->customer_id;
            $sav->ref_id = $token;
            $sav->due_date = Carbon::createFromFormat('m/d/Y', $request->due_date)->format('Y-m-d');
            $sav->address = $request->address;
            $sav->currency = $currency->coin_id;
            $sav->mode = $user->live;
            $sav->invoice_type = $request->invoice_type;
            $sav->hourstoNextDue = $hour;
            $sav->noOfPayments = 0;
            $sav->save();
            return redirect()->route('preview.invoice', ['id' => $token]);
            //return back()->with('toast_success', 'Invoice created');
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function submitpreview(Request $request)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $data = Invoice::whereId($request->id)->first();
            $customer = Customer::whereId($data->customer_id)->first();
            $set = Settings::first();
            if ($set->email_notify == 1) {
                $gg=[
                    'email'=>$customer->email,
                    'name'=>$customer->username,
                    'subject'=>'Invoice Payment',
                    'message'=>'Hi ' . $customer->first_name . ' ' . $customer->last_name . ', here is your invoice payment link ' . route('view.invoice', ['id' => $data->ref_id]) . '. Your payment will be due by ' . $data->due_date
                ];
                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            }
            dispatch(new SendSms($customer->phone, 'Hi ' . $customer->first_name . ' ' . $customer->last_name . ', here is your invoice payment link ' . route('view.invoice', ['id' => $data->ref_id]) . '. Your payment will be due by ' . $data->due_date));
            return redirect()->route('user.invoice')->with('toast_success', 'Invoice was successfully sent');
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function smsinvoice($id)
    {
        $data = Invoice::whereref_id($id)->first();
        if($data->user->sms_limit>$data->user->used_sms){
            dispatch(new SendSms($data->customer->phone, 'Hi ' . $data->customer->first_name . ' ' . $data->customer->last_name . ', here is your invoice payment link ' . route('view.invoice', ['id' => $data->ref_id]) . '. Your payment will be due by ' . $data->due_date));
            updateSmsLimit($data->user->id);
            return back()->with('toast_success', 'SMS sent');
        }else{
            return back()->with('toast_warning', 'SMS limit exceeded');
        }
    }
    public function Reminderinvoice($id)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $data = Invoice::whereref_id($id)->first();
            $set = Settings::first();
            if ($set->email_notify == 1) {
                if($data->user->email_limit > $data->user->used_email || $data->user->sms_limit>$data->user->used_sms){
                    dispatch_sync(new SendSms($data->customer->phone, 'Hi '.$data->customer->first_name.' '.$data->customer->last_name.', here is your invoice payment link '.route('view.invoice', ['id' => $data->ref_id]).'. Your payment will be due by '.$data->due_date));
                    dispatch_sync(new SendInvoice($data->ref_id));
                    updateEmailLimit($data->user->id);
                    updateSmsLimit($data->user->id);
                    return redirect()->route('user.invoice')->with('toast_success', 'Invoice was successfully sent');
                }else{
                    return back()->with('toast_warning', 'Email limit has been exceeded');
                }
            } else {
                return redirect()->route('user.invoice')->with('toast_warning', 'An error occured, Try again later');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function Viewinvoice($id)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $check = Invoice::whereref_id($id)->get();
            if (count($check) > 0) {
                $key = Invoice::whereref_id($id)->first();
                $user = User::find($key->user_id);
                if ($key->user->status == 0) {
                    if (!empty($user->gBPAccount()->accountNumber) && !empty($user->gBPAccount()->sortCode) || (!empty($user->paypal_client_id) && !empty($user->paypal_secret_key))) {
                        if ($key->status == 0) {
                            $checkx = Customer::whereid($key->customer_id)->count();
                            if ($checkx > 0) {
                                $data['link'] = $link = Invoice::whereref_id($id)->first();
                                $data['amount'] = json_decode($link->amount, true);
                                $data['quantity'] = json_decode($link->quantity, true);
                                $data['notes'] = json_decode($link->notes, true);
                                $data['tax'] = json_decode($link->tax, true);
                                $data['discount'] = json_decode($link->discount, true);
                                $data['total'] = json_decode($link->total, true);
                                $data['merchant'] = $user = User::find($link->user_id);
                                $set = Settings::first();
                                $data['title'] = "Invoice - " . $link->ref_id;
                                $xf = $user->getCountrySupported();
                                if ($xf->invoice == 1) {
                                        if ($key->mode == 1) {
                                            if (!empty($user->gBPAccount()->accountNumber) && !empty($user->gBPAccount()->sortCode) || (!empty($user->paypal_client_id) && !empty($user->paypal_secret_key))) {
                                                return view('user.invoice.view_card', $data);
                                            } else {
                                                $data['title'] = 'Error';
                                                return view('user.merchant.success', $data)->withErrors('Merchant has not selected any payment method');
                                            }
                                        } else {
                                            return view('user.invoice.view_test', $data);
                                        }
                                } else {
                                    $data['title'] = 'Error Message';
                                    return view('user.merchant.error', $data)->withErrors('Invoice Module is not available for this Merchant');
                                }
                            } else {
                                $data['title'] = 'Error Message';
                                return view('user.merchant.error', $data)->withErrors('No customer was found for this invoice');
                            }
                        } elseif ($key->status == 1) {
                            $data['title'] = 'Payment Made';
                            return view('user.merchant.success', $data)->withErrors('Invoice has been paid');
                        }
                    } else {
                        $data['title'] = 'Error Message';
                        return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
                    }
                } else {
                    $data['title'] = 'Error Message';
                    return view('user.merchant.error', $data)->withErrors('Merchant is not allowed to receive payment');
                }
            } else {
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('Invalid Invoice link');
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function Destroyinvoice($id)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $link = Invoice::whereref_id($id)->first();
            $history = Transactions::wherepayment_link($id)->get();
            foreach ($history as $val) {
                $val->delete();
            }
            $data = $link->delete();
            return back()->with('toast_success', 'Invoice deleted');
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
    public function Processinvoice(Request $request)
    {
        $set = Settings::first();
        if ($set->invoice == 1) {
            $ext = Invoice::whereref_id($request->link)->firstorFail();
            $merchant = Invoice::whereref_id($request->link)->firstorFail();
            $up_mer = User::whereId($merchant->user_id)->first();
            $currency = $up_mer->getCountrySupported(); 
            $validator = Validator::make(
                $request->all(),
                [
                    'terms' => 'required'
                ]
            );
            if ($validator->fails()) {
                return back()->with('errors', $validator->errors());
            }
            $xtoken = randomNumber(11);
            $sav = new Transactions();
            $sav->ref_id = $xtoken;
            $sav->type = 3;
            $sav->amount = $ext->real_total;
            $sav->email = $ext->customer->email;
            $sav->first_name = $ext->customer->first_name;
            $sav->last_name = $ext->customer->last_name;
            $sav->ip_address = user_ip();
            $sav->receiver_id = $ext->user_id;
            $sav->payment_link = $ext->id;
            $sav->currency = $currency->coin_id;
            $sav->save();
            if ($request->action == 'bank') {
                $sav->payment_type = 'bank';
                $sav->mode = 1;
                $sav->save();
                //Generate Auth Key
                $authToken = base64_encode($set->auth_key . ':' . $set->auth_secret);
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic ' . $authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->get("https://api.yapily.com/institutions"); 
                $response = $curl->response;
                $curl->close();
                if ($curl->error) {
                    return back()->with('toast_warning', $response->error->status . '-' . $response->error->message);
                } else {
                    Cache::put('trans', $sav->ref_id);
                    $data['authtoken'] = $authToken;
                    $data['institution'] = $response->data;
                    $data['title'] = 'Select Preferred Bank';
                    $data['type'] = 3;
                    $data['reference'] = $sav->ref_id;
                    return view('user.dashboard.institution', $data);
                }
            } elseif ($request->action == 'coinbase') {
                $sav->payment_type = 'coinbase';
                $sav->mode = 1;
                $sav->save();
                $data = [
                    'name' => $set->site_name,
                    'description' => 'Invoice Payment',
                    'pricing_type' => 'fixed_price',
                    'metadata' => array('customer_id' => $sav->ref_id, 'customer_name' => $sav->first_name . ' ' . $sav->last_name),
                    'local_price' => array('amount' => $sav->amount, 'currency' => $currency->coin->name),
                    'redirect_url' => route('coinbasesuccess', ['id' => $sav->ref_id]),
                    'cancel_url' => route('coinbasecancelled', ['id' => $sav->ref_id])
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
                } else {
                    $sav->charge_id = $response->data->code;
                    $sav->save();
                    return Redirect::away($response->data->hosted_url);
                }
            } elseif ($request->action == 'paypal') {
                $sav->payment_type = 'paypal';
                $sav->mode = 1;
                $sav->save();
                $authToken = base64_encode($up_mer->paypal_client_id . ':' . $up_mer->paypal_secret_key);
                $data = [
                    'intent' => "CAPTURE",
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => $currency->coin->name,
                                "value" => number_format($sav->amount, 2, '.', '')
                            ],
                        ]
                    ],
                    "application_context" => [
                        'return_url' => route('paypalsuccess', ['id' => $sav->ref_id]),
                        'cancel_url' => route('paypalcancelled', ['id' => $sav->ref_id])
                    ]
                ];
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic ' . $authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post(env('PAYPAL_URL')."v2/checkout/orders", $data);
                $response = $curl->response;
                $curl->close();
                if ($curl->error) {
                    return back()->with('toast_warning', $response->message);
                } else {
                    $sav->charge_id = $response->id;
                    $sav->save();
                    return Redirect::away($response->links[1]->href);
                }
            } elseif ($request->action == 'stripe') {
                $sav->payment_type = 'stripe';
                $sav->mode = 1;
                $sav->save();
                $stripe = new StripeClient($up_mer->stripe_secret_key);
                try {
                    $charge = $stripe->checkout->sessions->create([
                        'success_url' => route('stripesuccess', ['id' => $sav->ref_id]),
                        'cancel_url' => route('stripecancelled', ['id' => $sav->ref_id]),
                        'payment_method_types' => ['card'],
                        'line_items' => [
                            [
                                'name' => 'Invoice Payment',
                                'amount' => number_format($sav->amount, 2, '.', '') * 100,
                                'currency' => $currency->coin->name,
                                'quantity' => 1,
                            ],
                        ],
                        'mode' => 'payment',
                    ]);
                    $sav->charge_id = $charge['id'];
                    if ($charge['livemode'] == false) {
                        $sav->status = 2;
                        $sav->save();
                        return back()->with('toast_warning', 'You can\'t use test keys');
                    }
                    $sav->save();
                    return Redirect::away($charge['url']);
                } catch (\Stripe\Exception\CardException $e) {
                    return back()->with('toast_warning', $e->getMessage());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return back()->with('toast_warning', $e->getMessage());
                }
            } elseif ($request->action == 'test') {
                $sav->payment_type = 'test';
                $sav->mode = 0;
                $sav->status = $request->status;
                $sav->save();
                if ($request->status == 1) {
                    $ext->status = $request->status;
                    $ext->save();
                }
                //Change status to successful
                //Audit
                $audit = new Audit();
                $audit->user_id = $up_mer->id;
                $audit->trx = $xtoken;
                $audit->log = 'Received test payment ' . $ext->ref_id;
                $audit->save();
                //Send Notification
                if ($set->email_notify == 1) {
                    dispatch(new SendInvoiceReceipt($ext->ref_id, 'card', $xtoken));
                }
                //Webhook
                if ($up_mer->receive_webhook == 1) {
                    if ($up_mer->webhook != null) {
                        send_webhook($sav->id);
                    }
                }
                if ($request->status == 1) {
                    return redirect()->route('generate.receipt', ['id' => $sav->ref_id])->with('toast_success', 'Payment was successful');
                } else {
                    return back()->with('toast_warning', 'Payment Failed');
                }
            }
        } else {
            $data['title'] = 'Error Message';
            return view('user.merchant.error', $data)->withErrors('Invoice is currently unavailable');
        }
    }
}
