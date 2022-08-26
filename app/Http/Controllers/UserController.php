<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Settings;
use App\Models\Withdraw;
use App\Models\Exttransfer;
use App\Models\Merchant;
use App\Models\Ticket;
use App\Models\Reply;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Order;
use App\Models\Paymentlink;
use App\Models\Transactions;
use App\Models\Charges;
use App\Models\Donations;
use App\Models\History;
use App\Models\Countrysupported;
use App\Models\Productcategory;
use App\Models\Storefront;
use App\Models\Shipping;
use App\Models\Sub;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Curl\Curl;
use PDF;
use App\Mail\SendEmail;
use App\Services\SmsService;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Models\BankingDetail;
use App\Models\BlockedAccounts;
use App\Models\ComplianceAudit;
use App\Services\ModulrService;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\BankingBeneficiary;
use Stripe\StripeClient;
use App\Models\Country;
use h4cc\WKHTMLToPDF\WKHTMLToPDF;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    protected $sms;

    public function __construct(SmsService $sms, ModulrService $service)
    {
        $this->sms = $sms;
        $this->service = $service;
        $this->accountNumber = env("TRYBA_BANK_ACCOUNT");
        $this->address = env("TRYBA_BANK_ACCOUNT_ADDRESS");
        $this->postCode = env("TRYBA_BANK_ACCOUNT_POSTCODE");
        $this->postTown = env("TRYBA_BANK_ACCOUNT_POSTTOWN");
        $this->sortCode = env("TRYBA_BANK_ACCOUNT_SORTCODE");
    }

    //Dashboard
        public function dashboard()
        {
            $data['title'] = 'Dashboard';
        //    return response()->json(Auth::guard('user')->user()->euroAccount());
            // $user = User::whereid(Auth::user()->id)->first();
            return view('user.dashboard.index', $data)->withUser(Auth::guard('user')->user());
        }

        public function company_reg_no($company){
            $api_key = '1397b381-28d1-477d-8135-55341ba8c854';
        $url = "https://api.companieshouse.gov.uk/company/".$company;
        $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept-Language: en_US',
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded',
                ));
                curl_setopt($ch, CURLOPT_USERPWD, $api_key);
                $res = curl_exec($ch);
                $err = curl_errno($ch);
                curl_close($ch);
                if($err){
                echo "error".$err;
                }

                return $res;
        }

        public function postcode($search_term){
            $api_key = "PCW2P-B32G7-8H9BN-ZY6LH";
            //"PCW2P-B32G7-8H9BN-ZY6LH"
            $url = "https://ws.postcoder.com/pcw/$api_key/pafaddressbase/" . urlencode($search_term);
            $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    $res = curl_exec($ch);
                    $err = curl_errno($ch);
                    curl_close($ch);
                    if($err){
                    echo "error".$err;
                    }
                    return $res;
        }

        public function newdashboard()
        {
            $data['title'] = 'Dashboard';
            $data['user']  = User::whereid(Auth::user()->id)->first();
            $data['stephen'] = 'okpeku ighodaro';
            return view('user.dashboard.dashboard', $data);
        }

        public function package()
        {
            $data['title'] = "Plans";
            $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
            $data['plan']=Sub::wherecountry_id($xf->id)->get();
            return view('user.dashboard.plan', $data);
        }

        public function check_plan(Request $request)
        {
            $set=Settings::first();
            $token=randomNumber(11);
            $currency=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
            $receiver=User::whereid(Auth::guard('user')->user()->id)->first();
            $dd = explode('*', $request->plan);
            $plan=Sub::whereid($dd[0])->first();
            $sav=new Transactions();
            $sav->ref_id=$token;
            $sav->type=9;
            $sav->amount=$request->amount;//($request->amount*20/100);
            $sav->base_amount=$request->amount;
            $sav->email=Auth::guard('user')->user()->email;
            $sav->first_name=Auth::guard('user')->user()->first_name;
            $sav->last_name=Auth::guard('user')->user()->last_name;
            $sav->receiver_id=Auth::guard('user')->user()->id;
            $sav->payment_link=$request->plan;
            $sav->ip_address=user_ip();
            $sav->currency=$currency->coin_id;
            $sav->mode=1;
            $sav->save();
            if($plan->amount==0){
                $receiver->plan_id=$dd[0];
                if($dd[1]=="monthly"){
                    $receiver->plan_transactions=$plan->transactions;
                    $receiver->plan_payments=$plan->payment;
                    $receiver->plan_expired=0;
                    $receiver->plan_type="monthly";
                    $receiver->plan_expiring=Carbon::now()->add('1 month');

                }
                if($dd[1]=="annual"){
                    $receiver->plan_transactions=$plan->transactions*12;
                    $receiver->plan_payments=$plan->payment*12;
                    $receiver->plan_expired=0;
                    $receiver->plan_type="annual";
                    $receiver->plan_expiring=Carbon::now()->add('1 year');
                }
                $receiver->used_transactions=null;
                $receiver->used_payments=null;
                $receiver->save();
                return redirect()->route('user.dashboard')->with('toast_success', 'You can now start receiving payment');
            }else{
                if($request->type==1){
                    $sav->payment_type='bank';
                    $sav->save();
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
                        Session::put('trans', $sav->ref_id);
                        $data['authtoken']=$authToken;
                        $data['institution']=$response->data;
                        $data['title']='Select Preferred Bank';
                        $data['reference']=$sav->ref_id;
                        $data['type']=9;
                        $data['bank']=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
                        $data['amount']=$request->amount;
                        return view('user.dashboard.plan_institution', $data);
                    }
                }else{
                    $sav->payment_type='card';
                    $sav->save();
                    if($dd[1]=="monthly"){
                        $cplan=$plan->monthly_id;
                    }
                    if($dd[1]=="annual"){
                        $cplan=$plan->annual_id;
                    }
                    $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
                    $data=[
                        'plan_id' => $cplan,
                        "subscriber"=> [
                            "name"=>[
                                "given_name"=> $receiver->first_name,
                                "surname"=> $receiver->last_name
                            ],
                            "email_address"=> $receiver->email,
                        ],
                        'custom_id'=>$sav->ref_id,
                        "application_context"=> [
                            "return_url"=> route('cardcallback', ['id'=>$sav->ref_id]),
                            "cancel_url"=> route('user.package')
                        ]
                    ];
                    $curl = new Curl();
                    $curl->setHeader('Authorization', 'Basic '.$authToken);
                    $curl->setHeader('Content-Type', 'application/json');
                    $curl->post("https://api-m.paypal.com/v1/billing/subscriptions", $data);
                    $response = $curl->response;
                    $receiver->card_consent=$response->id;
                    $receiver->save();
                    $curl->close();
                    if ($curl->error) {
                        $data['title']='Error Message';
                        return view('user.merchant.error', $data)->withErrors($response->message);
                    }else{
                        return Redirect::away($response->links[0]->href);
                    }
                }
            }
        }
        public function cancelpackage()
        {
            $set=Settings::first();
            $receiver=User::whereid(Auth::guard('user')->user()->id)->first();
            if($receiver->bank_consent!=null){
                $authToken = base64_encode($receiver->cc->auth_key . ':' . $receiver->cc->auth_secret);
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic ' .$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->delete("https://api.yapily.com/consents/".$receiver->bank_consent);
                $response = $curl->response;
                $receiver->bank_consent=null;
                $receiver->save();
                $curl->close();
                if ($curl->error) {
                    $data['title']='Error Message';
                    return view('user.merchant.error', $data)->withErrors($response->error->status.'-'.$response->error->message);
                } else{
                    return back()->with('toast_success', 'Auto renewal has been disabled');
                }
            }elseif($receiver->card_consent!=null){
                $authToken = base64_encode($set->paypal_clientid.':'.$set->paypal_secret);
                $data=[
                    'reason'=>"Not satisfied with the service"
                    ];
                $curl = new Curl();
                $curl->setHeader('Authorization', 'Basic '.$authToken);
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post("https://api-m.paypal.com/v1/billing/subscriptions/".$receiver->card_consent."/cancel", $data);
                $response = $curl->response;
                $receiver->card_consent=null;
                $receiver->save();
                $curl->close();
                if ($curl->error) {
                    $data['title']='Error Message';
                    return view('user.merchant.error', $data)->withErrors($response->message);
                }else{
                    return back()->with('toast_success', 'Auto renewal has been disabled');
                }
            }
        }
        public function search(Request $request)
        {
            $data['title'] = "Search Result";
            $request->search;
            $data['val']=Transactions::whereref_id($request->search)->firstOrFail();
            return view('user.transactions.search', $data);
        }
    //End of Dashboard

    //Delete account
        public function delaccount(Request $request)
        {
            $id = Auth::guard('user')->user()->id;
            $user = User::whereId($id)->delete();
            $ticket = Ticket::whereUser_id($id)->delete();
            $exttransfer = Exttransfer::whereUser_id($id)->delete();
            $merchant = Merchant::whereUser_id($id)->delete();
            $product = Product::whereUser_id($id)->delete();
            $orders = Order::whereUser_id($id)->delete();
            $invoices = Invoice::whereUser_id($id)->delete();
            $charges = Charges::whereUser_id($id)->delete();
            $donations = Donations::whereUser_id($id)->delete();
            $paymentlink = Paymentlink::whereUser_id($id)->delete();
            $his = History::whereUser_id($id)->delete();
            $store = Storefront::whereUser_id($id)->delete();
            $ship = Shipping::whereUser_id($id)->delete();
            $pro = Productcategory::whereUser_id($id)->delete();
            $trans = Transactions::where('Receiver_id', $id)->orWhere('Sender_id', $id)->delete();
            Auth::guard('user')->logout();
            session()->flash('message', 'Just Logged Out!');
            return redirect()->route('login')->with('toast_success', 'Account was successfully deleted');
        }
    //End of Delete account

    //Support ticket
        public function ticket()
        {
            $data['title']='Support ticket';
            $data['ticket']=auth()->guard('user')->user()->getTickets();
            return view('user.support.index', $data);
        }
        public function openticket()
        {
            $data['title']='New Ticket';
            return view('user.support.new', $data);
        }
        public function Replyticket($id)
        {
            $data['ticket']=$ticket=Ticket::whereid($id)->first();
            $data['title']='#'.$ticket->ticket_id;
            $data['reply']=Reply::whereTicket_id($ticket->ticket_id)->get();
            return view('user.support.reply', $data);
        }
        public function Destroyticket($id)
        {
            $data = Ticket::findOrFail($id);
            $res =  $data->delete();
            if ($res) {
                return back()->with('toast_success', 'Request was Successfully deleted!');
            } else {
                return back()->with('toast_warning', 'Problem With Deleting Request');
            }
        }
        public function Resolveticket($id)
        {
            $ticket=Ticket::find($id);
            $ticket->status=1;
            $ticket->save();
            return back()->with('toast_success', 'Ticket has been closed.');
        }
        public function submitticket(Request $request)
        {
            $set=Settings::first();
            if($request->has('ref_no')){
                $check=Ticket::whereref_no($request->ref_no)->count();
                if($check>0){
                    return back()->with('toast_warning', 'You have already raised a dispute on this.');
                }else{
                    $vex=Transactions::whereref_id($request->ref_no)->count();
                    if($vex>0){
                        $xx=Transactions::whereref_id($request->ref_no)->first();
                        if($xx->mode==1){
                            if($request->hasfile('image')){
                                $validator=Validator::make($request->all(), [
                                    'image.*' => 'mimes:doc,pdf,docx,zip,png,jpeg'
                                ]);
                                if ($validator->fails()) {
                                    return redirect()->route('transfererror')->withErrors($validator)->withInput();
                                }else{
                                    foreach($request->file('image') as $file){
                                        $token=str_random(10);
                                        $name = 'support_'.$token.'.'.$file->extension();
                                        $file->move(public_path('asset/profile/', $name));
                                        $data[] = $name;
                                        $sav['files'] = json_encode($data);
                                    }
                                }
                            }
                            $check=User::whereid($xx->receiver_id)->first();
                            $check->payment=0;
                            $check->save();
                            $withdraw=Withdraw::whereuser_id($xx->receiver_id)->wherestatus(0)->get();
                            foreach($withdraw as $val){
                                $val->status=3;
                                $val->save();
                            }
                            $user=$data['user']=User::find(Auth::guard('user')->user()->id);
                            $sav['user_id']=Auth::guard('user')->user()->id;
                            $sav['subject']=$request->subject;
                            $sav['priority']=$request->priority;
                            $sav['type']=$request->type;
                            $sav['message']=$request->details;
                            $sav['ref_no']=$request->ref_no;
                            $sav['ticket_id']=$token='DIS-'.str_random(6);
                            $sav['status']=0;
                            $xx->disputes=1;
                            $xx->save();
                            Ticket::create($sav);
                            if($set['email_notify']==1){
                                $gg=[
                                    'email'=>$user->email,
                                    'name'=>$user->first_name.' '.$user->last_name,
                                    'subject'=>'New Ticket - '.$request->subject,
                                    'message'=>"Thank you for contacting us, we will get back to you shortly, your Ticket ID is ".$token
                                ];
                                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                                $gg=[
                                    'email'=>$user->email,
                                    'name'=>$user->first_name.' '.$user->last_name,
                                    'subject'=>'New Ticket:'. $token,
                                    'message'=>"New ticket request"
                                ];
                                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                            }
                            return redirect()->route('user.ticket')->with('toast_success', 'Ticket Submitted Successfully.');
                        }else{
                            return back()->with('toast_warning', 'You can\'t raise a dispute for a test transaction.');
                        }
                    }else{
                        return back()->with('toast_warning', 'Invalid reference no.');
                    }
                }
            }else{
                if($request->hasfile('image')){
                    $validator=Validator::make($request->all(), [
                        'image.*' => 'mimes:doc,pdf,docx,zip,png,jpeg'
                    ]);
                    if ($validator->fails()) {
                        return redirect()->route('transfererror')->withErrors($validator)->withInput();
                    }else{
                        foreach($request->file('image') as $file){
                            $token=str_random(10);
                            $name = 'support_'.$token.'.'.$file->extension();
                            $file->move(public_path('asset/profile/', $name));
                            $data[] = $name;
                            $sav['files'] = json_encode($data);
                        }
                    }
                }
                $user=$data['user']=User::find(Auth::guard('user')->user()->id);
                $sav['user_id']=Auth::guard('user')->user()->id;
                $sav['subject']=$request->subject;
                $sav['priority']=$request->priority;
                $sav['type']=$request->type;
                $sav['message']=$request->details;
                $sav['ref_no']=$request->ref_no;
                $sav['ticket_id']=$token='DIS-'.str_random(6);
                $sav['status']=0;
                Ticket::create($sav);
                if($set['email_notify']==1){
                    $gg=[
                        'email'=>$user->email,
                        'name'=>$user->first_name.' '.$user->last_name,
                        'subject'=>'New Ticket - '.$request->subject,
                        'message'=>"Thank you for contacting us, we will get back to you shortly, your Ticket ID is ".$token
                    ];
                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                    $gg=[
                        'email'=>$user->email,
                        'name'=>$user->first_name.' '.$user->last_name,
                        'subject'=>'New Ticket:'. $token,
                        'message'=>"New ticket request"
                    ];
                    Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
                }
                return redirect()->route('user.ticket')->with('toast_success', 'Ticket Submitted Successfully.');
            }
        }
        public function submitreply(Request $request)
        {
            $set=Settings::first();
            $sav['reply']=$request->details;
            $sav['ticket_id']=$request->id;
            $sav['status']=1;
            Reply::create($sav);
            if($set['email_notify']==1){
                $gg=[
                    'email'=>$set->email,
                    'name'=>$set->site_name,
                    'subject'=>'Ticket Reply:'. $request->id,
                    'message'=>"New ticket reply request"
                ];
                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            }
            $data=Ticket::whereTicket_id($request->id)->first();
            $data->status=0;
            $data->save();
            return back()->with('toast_success', 'Message sent!.');
        }
    //End Support ticket

    //Verification
        public function blocked()
        {
            if (Auth::guard('user')->user()->status ==0) {
                return redirect()->route('user.dashboard');
            } else {
                $data['title'] = "Account suspended";
                $data['reason'] = "Account has been suspended";
                $compliance = ComplianceAudit::where('user_id',Auth::guard('user')->user()->id)->latest()->first();
                $data['url'] = "https://compliance.tryba.io/". $compliance->slug;
                return view('user.profile.blocked', $data);
            }
        }
        public function terminated()
        {
            if (Auth::guard('user')->user()->isBlocked == false) {
                return redirect()->route('user.dashboard');
            } else {
                $data['title'] = "Account Terminated";
                $data['reason'] = "Account has been terminated";
                $blocked = BlockedAccounts::where('user_id',Auth::guard('user')->user()->id)->first();
                $data['url'] = "https://compliance.tryba.io/blocked/". $blocked->slug;
                return view('user.profile.blocked', $data);
            }
        }
        public function verifyEmail()
        {
            if (Auth::guard('user')->user()->email_verify==0) {
                $data['title'] = "Verify email address";
                return view('auth.verify-email', $data);
            }elseif (Auth::guard('user')->user()->email_verify ==1) {
                return redirect()->route('user.dashboard')->with('toast_success', Auth::guard('user')->user()->email.' has already been verified');
            }
        }
        public function sendEmail(EmailVerificationRequest $request)
        {
            $user = User::find(Auth::guard('user')->user()->id);
            $code = strtoupper(Str::random(32));
            if($request->has('email') && !empty($request->email)) {
                $user->update(['email' => $request->email, 'verification_code' => $code]);
                // \Mail::to($user->email)->send(new EmailVerification($user, $code));
                // \dispatch(new EmailVerification($user, $code));
                \Mail::to($user->email)->send(new EmailVerification($user, $code));
                return back()->with('toast_success', 'Verification code sent');
            }
            $user->update(['verification_code' => $code]);
            // \dispatch(new EmailVerification($user, $code));
            \Mail::to($user->email)->send(new EmailVerification($user, $code));
            return back()->with('toast_success', 'Verification Code Sent');

            // $set = Settings::find(1);
            // $user = User::find(Auth::guard('user')->user()->id);
            // if (Carbon::parse($user->email_time)->addMinutes(1) > Carbon::now()) {
            //     $time = Carbon::parse($user->email_time)->addMinutes(1);
            //     $delay = $time->diffInSeconds(Carbon::now());
            //     $delay = gmdate('i:s', $delay);
            //     return back()->with('toast_warning', 'You can resend link after ' . $delay . ' minutes');
            // } else {
            //     $code = strtoupper(Str::random(32));
            //     $user->email_time = Carbon::now();
            //     $user->verification_code = $code;
            //     $user->save();
            //     $gg = [
            //         'email'=>$user->email,
            //         'name'=>$user->first_name.' '.$user->last_name,
            //         'subject'=>'We need to verify your email address',
            //         'message'=>'Thanks you for signing up to ' . $set->site_name . '.<br> As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.<br><a href=' . route('user.confirm-email', ['id' => $code]) . '>' . route('user.confirm-email', ['id' => $code]) . '</a>'
            //     ];
            //     Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            //     return back()->with('toast_success', 'Verification Code Sent');
            // }
        }
        public function confirmEmail($id)
        {
            $key = User::whereverification_code($id)->count();
            if ($key == 0) {
                $data['title'] = 'Error Message';
                return view('errors.email', $data)->withErrors('Invalid Token');
            } else {
                $user = User::whereverification_code($id)->first();
                if ($user->email_verify == 1) {
                    $data['title'] = 'Email Verification';
                    return view('errors.email', $data)->withErrors('Email has already been verified');
                } else {
                    $user->email_verify = 1;
                    $user->save();
                    $data['title'] = 'Email Verification';
                    return redirect()->route('user.dashboard')->with('success', 'Email verified');
                }
            }
        }
        public function phoneCheck()
        {
            if (Auth::guard('user')->user()->phone_verify==0) {
                $data['title'] = "Verify Mobile Number";
                $user = User::find(Auth::guard('user')->user()->id);
                $code = randomNumber(6);
                $user->phone_time = Carbon::now();
                $user->sms_code = $code;
                $user->save();
                // dispatch(new SendSms($user->phone, $code));
                $this->sms->fire($user->phone, $code);
                return view('user.verify.phone', $data);
            }elseif (Auth::guard('user')->user()->phone_verify ==1) {
                return redirect()->route('user.dashboard')->with('toast_success', Auth::guard('user')->user()->phone.' has already been verified');
            }
        }
        public function editphone()
        {
            $data['title'] = "Edit Mobile Number";
            return view('user.verify.edit-phone', $data);
        }
        public function sendVcode(Request $request)
        {
            $user = User::find(Auth::guard('user')->user()->id);
            $code = randomNumber(6);
            $user->phone_time = Carbon::now();
            $user->sms_code = $code;
            $user->save();
            // dispatch_sync(new SendSms($user->phone, 'Your Verification Code is ' . $code));
            $this->sms->fire($user->phone, $code);
            session()->flash('toast_success', 'Verification Code Send successfully');
            return back();
        }
        public function smsVerify(Request $request)
        {
            $user = User::find(Auth::guard('user')->user()->id);
            if ($user->sms_code == $request->sms_code) {
                $user->phone_verify = 1;
                $user->save();
                return redirect()->route('user.dashboard')->with('toast_success', 'Your mobile no has been verified successfully');
            } else {
                session()->flash('toast_warning', 'Verification Code didn\'t match');
            }
            return back();
        }
        public function updatephone(Request $request)
        {
            $user = User::find(Auth::guard('user')->user()->id);
            $set=Settings::first();
            if($user->phone!=$request->phone){
                $check=User::wherePhone($request->phone)->count();
                if($check<1){
                    if($set->sms_verification==1){
                        try{
                            $user->phone=PhoneNumber::make($request->phone, $user->xd->iso)->formatE164();
                            $user->save();
                            return redirect()->route('user.phone.authorization')->with('toast_success', 'Mobile Number changed');
                        }catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                            return back()->with('toast_warning', $e->getMessage());
                        }
                    }
                }else{
                    return back()->with('toast_warning', 'Mobile Number already in use.');
                }
            }
            return back()->with('toast_success', 'Mobile Number updated.');
        }
    //End of verification

    //Transaction Logs
        public function archivetransactions(Request $request)
        {
            if($request->has('archive')){
                $data=$request->except('_token');
                //dd($data);
                foreach($data as $val){
                foreach($val as $valx){
                    $trans=Transactions::whereref_id($valx)->first();
                    $trans->archive=1;
                    $trans->save();
                }
                }
                return back()->with('toast_success', 'Added to Archive');
            }else{
                return back()->with('toast_warning', 'Nothing Selected');
            }
        }
        public function rarchivetransactions(Request $request)
        {
            if($request->has('archive')){
                $data=$request->except('_token');
                //dd($data);
                foreach($data as $val){
                foreach($val as $valx){
                    $trans=Transactions::whereref_id($valx)->first();
                    $trans->archive=0;
                    $trans->save();
                }
                }
                return back()->with('toast_success', 'Removed from Archive');
            }else{
                return back()->with('toast_warning', 'Nothing Selected');
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
            $data['payment'] = $request->payment;
            $data['method'] = $request->method;
            $data['order'] = $request->date;
            $date=explode('-', $request->date);
            $from=Carbon::create($date[0])->toDateString();
            $to=Carbon::create($date[1])->toDateString();
            if($request->payment=="0" && $request->method=="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }elseif($request->payment=="0" && $request->method!="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }elseif($request->payment!="0" && $request->method!="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wheretype($request->payment)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wheretype($request->payment)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }elseif($request->payment!="0" && $request->method=="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wheretype($request->payment)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wheretype($request->payment)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }
            return view('user.transactions.index', $data);
        }
        public function sortarchivetransactions(Request $request)
        {
            $set=Settings::first();
            $user=Auth::guard('user')->user()->id;
            $xf=Countrysupported::whereid(Auth::guard('user')->user()->pay_support)->first();
            if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
            $data['title'] = "Transactions";
            $data['status'] = $request->status;
            $data['payment'] = $request->payment;
            $data['method'] = $request->method;
            $data['order'] = $request->date;
            $date=explode('-', $request->date);
            $from=Carbon::create($date[0])->toDateString();
            $to=Carbon::create($date[1])->toDateString();
            if($request->payment=="0" && $request->method=="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }elseif($request->payment=="0" && $request->method!="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }elseif($request->payment!="0" && $request->method!="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wheretype($request->payment)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wherepayment_type($request->method)->wheretype($request->payment)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }elseif($request->payment!="0" && $request->method=="0"){
                $data['trans']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wheretype($request->payment)->wherearchive(0)->wherestatus($request->status)->wheremode($mode)->latest()->get();
                $data['archivesum']=Transactions::whereBetween('created_at', [$from, $to])->where('receiver_id', $user)->wheretype($request->payment)->wherestatus($request->status)->wherearchive(1)->wheremode($mode)->count();
            }
            return view('user.transactions.archive', $data);
        }
        public function transactions()
        {
            $data['title']='Transactions';
            $user=Auth::guard('user')->user();
            $data['status']="3";
            $data['payment']="0";
            $data['method']="0";
            $data['trans'] = $user->getTransactions();
            if(count($data['trans'])>0){
                $first = $user->firstTransactions();
                $last = $user->lastTransactions();
                $data['order'] = date("m/d/Y", strtotime($last->created_at)).' - '.date("m/d/Y", strtotime($first->created_at));
            }else{
                $data['order']=null;
            }
            return view('user.transactions.index', $data);
        }
        public function transactionsarchive()
        {
            $data['title']='Archived Transactions';
            $user=Auth::guard('user')->user()->id;
            $data['status']="3";
            $data['payment']="0";
            $data['method']="0";
            if(Auth::guard('user')->user()->live==0){$mode=0;}else{$mode=1;}
            $data['trans']=Transactions::where('receiver_id', $user)->wherearchive(1)->wheremode($mode)->latest()->get();
            if(count($data['trans'])>0){
                $first=Transactions::where('receiver_id', $user)->wherearchive(1)->wheremode($mode)->limit(1)->orderby('created_at', 'desc')->first();
                $last=Transactions::where('receiver_id', $user)->wherearchive(1)->wheremode($mode)->limit(1)->orderby('created_at', 'asc')->first();
                $data['order'] = date("m/d/Y", strtotime($last->created_at)).' - '.date("m/d/Y", strtotime($first->created_at));
            }else{
                $data['order']=null;
            }
            return view('user.transactions.archive', $data);
        }
    //End of Logs

    //Generate Receipt
        public function generatereceipt($id){
            $data['link']=$trans=Transactions::whereref_id($id)->first();
            if($trans->status==1){
                $data['title']="Receipt from ".$trans->receiver->first_name.' '.$trans->receiver->last_name;
                $data['trans']=$trans;
                $data['merchant']=User::find($trans->receiver_id);
                return view('user.transactions.receipt', $data);
            }else{
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('An Error Occured');
            }
        }
        public function downloadreceipt($id){
            $data['link'] = $trans = Transactions::whereref_id($id)->first();
            if($trans->status==1){
                $data['title']="Receipt from ".$trans->receiver->first_name.' '.$trans->receiver->last_name;
                $data['trans']=$trans;
                $data['merchant']=User::find($trans->receiver_id);
                //return view('user.transactions.receipt', $data);
                $pdf = PDF::loadView('user.transactions.download', $data);
                return $pdf->download($id . '.pdf');
            }else{
                $data['title'] = 'Error Message';
                return view('user.merchant.error', $data)->withErrors('An Error Occured');
            }
        }
    //End of generate Receipot

    /**
     * Update MCC
     */
    public function updateProfile(Request $request, $id) {
        $user = User::find($request->user_id);
        if($user) {
            $user->update(["mcc" => $request->mcc]);
            return back()->withMessage("Profile updated");
        }
        return back()->withErrors("Could not update profile");
    }

    public function buyEmail(Request $request, $id){
        $validator = Validator::make( $request->all(),[
            'limit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()],422);
        }

        $user = User::find($id);
        $bankDetails = BankingDetail::where('user_id',$user->id)->where('currency','GBP')->first();
        $total = $request->limit * getEmailPricePerUnit();
        if(empty($bankDetails)){
            return response()->json(['error' => 'User bank account not found'],404);
        }elseif(!empty($bankDetails) && $bankDetails->balance < $total ){
            return response()->json(['error' => 'Insufficient funds'],422);
        }else{
            $payment = $this->payRequest($bankDetails,$total);
            if(!$payment) {
                return response()->json(['error' => 'Cannot make payment'],400);
            }else{
                $user->email_limit = $user->email_limit + $request->limit;
                $user->save();
                $user->sms_limit = $user->sms_limit + $request->limit;
                $user->save();
                $ref_id = randomNumber(11);
                $transaction = new Transactions();
                $transaction->payment_type = 'bank';
                $transaction->first_name = "Tryba";
                $transaction->last_name = "UK";
                $transaction->receiver_id = $user->id;
                $transaction->amount = $total;
                $transaction->currency = 19;
                $transaction->ref_id = $ref_id;
                $transaction->type = 14;
                $transaction->status = 1;
                $transaction->ip_address = user_ip();
                $transaction->save();
                return response()->json(['success' => 'Payment Successfull'],201);
            }
        }
    }

    public function buySMS(Request $request, $id){
        $validator = Validator::make( $request->all(),[
            'limit' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()],422);
        }

        $user = User::find($id);
        $bankDetails = BankingDetail::where('user_id',$user->id)->where('currency','GBP')->first();
        $total = $request->limit * getSMSPricePerUnit();
        if(empty($bankDetails)){
            return response()->json(['error' => 'User bank account not found'],404);
        }elseif(!empty($bankDetails) && $bankDetails->balance < $total ){
            return response()->json(['error' => 'Insufficient funds'],422);
        }else{
            $payment = $this->payRequest($bankDetails,$total);
            if(!$payment) {
                return response()->json(['error' => 'Cannot make payment'],400);
            }else{
                $user->sms_limit = $user->sms_limit + $request->limit;
                $user->save();
                $ref_id = randomNumber(11);
                $transaction = new Transactions();
                $transaction->payment_type = 'bank';
                $transaction->first_name = "Tryba";
                $transaction->last_name = "UK";
                $transaction->receiver_id = $user->id;
                $transaction->amount = $total;
                $transaction->currency = 19;
                $transaction->ref_id = $ref_id;
                $transaction->type = 13;
                $transaction->status = 1;
                $transaction->ip_address = user_ip();
                $transaction->save();
                return response()->json(['success' => 'Payment Successfull'],201);
            }
        }
    }

    public function payRequest($bankDetails,$total){
        $data = [
            'amount' => $total,
            'sourceAccountId' => $bankDetails->accountId,
            'payeeAccountNumber' => $this->accountNumber,
            'payeeSortCode' => $this->sortCode,
            'beneficiaryId' => '',
            'payeeName' => 'Tryba.io',
            'address' => $this->address,
            'country' => 'GB',
            'postCode' => $this->postCode,
            'postTown' => $this->sortCode,
        ];
        return $this->service->createPayment(new Request($data));
    }

    public function stripe_connect(Country $country, User $user, Merchant $mcc){
        //first step
          // $stripe =  new StripeClient('sk_test_51L2XgNANbaRqueyVOtuRtJAHUVfczqDuVLs3H83aUnbMTSpNzbmJfPm55qbygK2ZwsCIzMJXDvmQEYVE36L3dXOS00rnKNNHVm');
          // $standand  =  $stripe->accounts->create(['type' => 'standard']);
          // return $standand;
        // $person =  $user->find(auth()->user()->id);
        // if($person->stripe_id){
        //         $stripe =  new StripeClient(env('Stripe_Keys'));
        //         $stand  = $stripe->accountLinks->create([
        //             'account' => $person->stripe_id,
        //             'refresh_url' => 'https://example.com/reauth',
        //             'return_url' => 'http://127.0.0.1:8000/user/connections',
        //             'type' => 'account_onboarding',

        //           ]);

        //           return redirect($stand['url']);

        // }else{
            //$mccs = $mcc->where('status', auth()->user()->mcc)->first()->name;
        //    $ans = substr($mccs, 0, 3);
           $url = URL::to('/');

            $country_iso3 = $country->where('id',  auth()->user()->country)->first()->iso;
            $stripe = new StripeClient(
            env('Stripe_Keys')
        );
        //auth()->user()->email
       $standard = $stripe->accounts->create([

          'type' => 'standard',
          'country' => $country_iso3,
          'email' =>auth()->user()->email,
          'business_type'=>auth()->user()->business_type,
          'capabilities' => [
            // 'card_payments' => ['requested' => true],
            // 'transfers' => ['requested' => true],
          ],
        "business_profile" => [
           "mcc"=>7623,
            "name"=>auth()->user()->first_name,
            "product_description"=>auth()->user()->product_description,
           //  "support_address"=> auth()->user()->address_line1,
            "support_email"=>auth()->user()->support_email,
            "support_phone"=>auth()->user()->support_phone,
            "support_url"=>auth()->user()->website_link,
            "url"=> null
        ],
            "company"=>[
             "address"=>[
                   "city"=> auth()->user()->city,
                "line1"=> auth()->user()->line_1,
                 "line2"=>auth()->user()->line_1,
                "postal_code"=>auth()->user()->postal_code,
                "state"=> auth()->user()->state
             ]
             ],


        ]);


       if($standard['id']){
        $stripe =  new StripeClient(env('Stripe_Keys'));
        $stand  = $stripe->accountLinks->create([
            'account' => $standard['id'],
            'refresh_url' => 'https://example.com/reauth',
            'return_url' =>  $url.'/user/connections',
            'type' => 'account_onboarding',

          ]);
        //   $person->update([
        //     "stripe_id"=>$standard['id'],
        //     "stripe"=>1
        //   ]);

          return redirect($stand['url']);
       }
        //}

  }

  public function getbeneficary($id){
    $beneficary = BankingBeneficiary::find($id);
    return response()->json([
        'accountName' => $beneficary->name,
        'accountNumber' => $beneficary->accountNumber,
        'sortCode' => $beneficary->sortCode,
        'currency' => $beneficary->currency,
    ],200);
  }

}
