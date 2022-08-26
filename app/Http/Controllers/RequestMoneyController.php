<?php

namespace App\Http\Controllers;

use App\Jobs\SendPaymentEmail;
use App\Jobs\SendRequestLinkJob;
use App\Models\Audit;
use App\Models\Countrysupported;
use App\Models\RequestMoney;
use App\Models\Settings;
use App\Models\Transactions;
use App\Models\User;
use App\Services\SmsService;
use Curl\Curl;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class RequestMoneyController extends Controller
{
    public function createRequestLink(Request $request){
        $validator = Validator::make( $request->all(),[
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'amount' => 'required|integer|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(),'status' => 'failed','data' => null], 400);
        }

        $slug = 'RQ-'. Str::random(6);         
        RequestMoney::create([
            'user_id' => Auth::user()->id,
            'slug' => $slug,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'amount' => $request->amount,
            'description' => $request->description,
            'currency_id' => getUserCurrencyDetails(Auth::user())->id,
            'email' => $request->email,
            'phone_number' => $request->phone_number
        ]);
        return response()->json(['message' => "Successfully Generated a link",'status' => 'success','data' => [
            'url' => route('requestMoney',$slug),
            'slug' => $slug
        ]], 200);

    }

    public function requestLink($slug){
        $requestDetails = RequestMoney::where('slug',$slug)->where('payment_status',false)->firstorFail();
        $user = User::find($requestDetails->user_id);
        return view('user.link.request_view_card',[
            'link' =>  $requestDetails,
            'merchant' => $user,
            'slug' => $slug,
            "title" => "Send Money"
        ]);
    }

    public function sendRequestLink(Request $request,$slug){
        $validator = Validator::make($request->all(),[
            'email' => 'nullable|email',
            'phone_number' => 'nullable|digits:11',
            "phonecode" => "nullable"
        ]);

        $user = User::find(Auth::user()->id);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(),'status' => 'failed','data' => null], 400);
        }

        $requestDetails =  RequestMoney::where('slug',$slug)->firstorFail();

        $sms_status = false;
        if($request->phone_number != NULL &&  $user->used_sms < $user->sms_limit ){
            $requestDetails->phone_number = $request->phonecode . $request->phone_number;
            $requestDetails->save();
            $message = "Hi ". $requestDetails->first_name .", ". $requestDetails->user->first_name . " is requesting ". $requestDetails->currency->symbol . $requestDetails->amount ." from you using this link ". route('requestMoney',$requestDetails->slug) ." thank you.";
            $phonenumber = $requestDetails->phonecode.$requestDetails->phone_number;
            $sms = new SmsService;
            $sms->fire($phonenumber, $message);
            updateSmsLimit(Auth::user()->id);
            $sms_status = true;
            $sms_message = "Successfully sent link to " .  $phonenumber;
        }else{
            $sms_message = ($request->email != NULL) ? "You have exceed your SMS limit" : NULL;
        }

        $email_status = false;
        if($request->email != NULL && $user->used_email < $user->email_limit){
            $requestDetails->email = $request->email;
            $requestDetails->save();
            dispatch_sync(new SendRequestLinkJob($requestDetails));
            updateEmailLimit(Auth::user()->id);
            $email_status = true;
            $email_message = "Successfully sent link to " .  $request->email;
        }else{
            $email_message = ($request->email != NULL) ?  "You have exceed your email limit" : NULL;
        }

        return response()->json(['message' => null ,'status' => 'success','data' => [
            'email_status' =>  $email_status,
            'email_message' => $email_message,
            'sms_status' =>  $sms_status,
            'sms_message' =>  $sms_message
        ]], 200);
    }

    public function intiateRequestPayment(Request $request,$slug){
        $set = Settings::first();
        $link = RequestMoney::where('slug',$slug)->firstorFail();
        $xtoken = randomNumber(11);
        $receiver = User::whereid($link->user_id)->first();
        $currency = Countrysupported::whereid($receiver->pay_support)->first();
        $validator = Validator::make( $request->all(),
        [
            'email' => 'nullable|max:255',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'amount'=>'required|integer',
            'terms'=>'required'
        ]
        );
        if ($validator->fails()) {
            $data['errors'] =$validator->errors();
            return back()->withInput()->with('errors', $validator->errors());
        }
        if ($request->has("email")) {
            $validatorf = new EmailValidator();
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);
            if($validatorf->isValid($request->email, $multipleValidations)){}else{
                return back()->with('toast_warning', 'Invalid email address');
            }
        }
        $sav = new Transactions();
        $sav->ref_id = $xtoken;
        $sav->type = 12;
        $sav->amount = $request->amount;
        $sav->email = $request->email;
        $sav->first_name = $request->first_name;
        $sav->last_name = $request->last_name;
        $sav->receiver_id = $link->user_id;
        $sav->payment_link = $link->id;
        $sav->ip_address = user_ip();
        $sav->currency = $currency->coin_id; 
        $sav->save();
        if($request->action =='bank'){
            $sav->payment_type ='bank';
            $sav->mode = 1;
            $sav->save();
            return redirect()->route('get.getTransactionToPay',$sav->ref_id);   
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
        }elseif($request->action == 'test'){
            $sav->payment_type='test';
            $sav->mode=0;
            $sav->status=$request->status;
            $sav->save();
            //Save Audit Log For Receiver 
            $audit=new Audit();
            $audit->user_id=$receiver->id;
            $audit->trx = $xtoken;
            $audit->log ='Received test payment ' .$link->ref_id;
            $audit->save();
            //Notify users
            if($set->email_notify == 1){
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
    }

    public function sendWhatsappLink(Request $request, $slug){
        $validator = Validator::make($request->all(),[
            'phone_number' => 'nullable|digits:11',
            "phonecode" => "nullable"
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(),'status' => 'failed','data' => null], 400);
        }

        $requestDetails =  RequestMoney::where('slug', $slug)->with("user")->firstorFail();
        $requestDetails->phone_number = $request->phonecode . $request->phone_number;
        $requestDetails->save();
        $message = "?text=Hi ". $requestDetails->first_name .", ". $requestDetails->user->first_name . " is requesting ". $requestDetails->currency->symbol . $requestDetails->amount ." from you using this link ". route('requestMoney',$requestDetails->slug) ." thank you.";
        $phonenumber = $request->phonecode.$request->phone_number;
        $whatsappLink = "https://wa.me/".$phonenumber. $message;

        return response()->json(['message' => null,'status' => 'success','data' => [
            "whatsappLink" => $whatsappLink
        ]], 200);

    }
}
