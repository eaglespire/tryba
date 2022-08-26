<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Transactions;
use App\Models\Shipcountry;
use App\Models\Shipstate;
use App\Models\Countrysupported;
use Propaganistas\LaravelPhone\PhoneNumber;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Mail\SendEmail;
use App\Jobs\SendSms;
use App\Jobs\SendInvoice;
use App\Models\County;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function ship_country()
    {
        $country=Shipcountry::all();
        return response()->json(['message' => 'success','data' => $country], 201);
    }
    public function ship_state($id)
    {
        $state=County::wherecountry_id($id)->get();
        return response()->json(['message' => 'success','data' => $state], 201);
    }
    public function invoice()
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->invoice == 1){
            if($xf->invoice == 1){
                $invoices = Invoice::whereUser_id(Auth::user()->id)->wheremode(1)->latest()->get();
                $allInvoicesUrls = $invoices->map(function ($item, $key) {
                    $item->url = route('view.invoice', ['id' => $item->ref_id]);
                    return $item;
                });
                return response()->json(['message' => 'success','data' => $allInvoicesUrls], 201);
            }else{
               return response()->json(['message' => 'Invoice is not available for your country','status' => 'failed','data' => null], 400);
            }
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    }

    public function getOneinvoice($id) {
        
        $set = Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->invoice == 1){
            if($xf->invoice==1){
                $invoice = Invoice::whereUser_id(Auth::user()->id)->whereid($id)->first();
                $invoice->url = route('view.invoice', ['id' => $invoice ->ref_id]);
                return response()->json(['message' => 'success','data' => $invoice ], 201);
            }else{
               return response()->json(['message' => 'Invoice is not available for your country','status' => 'failed','data' => null], 400);
            }
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    }

    public function customer()
    {
        $set=Settings::first();
        $xf=Countrysupported::whereid(Auth::user()->pay_support)->first();
        if($set->invoice==1){
            if($xf->invoice==1){
                $data['customer']=Customer::whereUser_id(Auth::user()->id)->wheremode(1)->latest()->get();
                return response()->json(['message' => 'success','data' => $data], 201);
            }else{
               return response()->json(['message' => 'Invoice is not available for your country','status' => 'failed','data' => null], 400);
            }
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    }
    public function Editinvoice(Request $request,$id)
    {
        $validator = Validator::make( $request->all(),[
            'customer_id' => 'required|exists:customer,id',
            'due_date' =>'required|date|date_format:Y-m-d|after_or_equal:' . now()->format ('Y-m-d'),
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
            return response()->json(['errors' => $validator->errors()],422);
        }

        $set = Settings::first();
        if ($set->invoice == 1) {
            $user = $data['user'] = User::find(Auth::user()->id);
            $currency = $user->getCountrySupported();
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

            $sav = Invoice::whereid($id)->first();
            $sav->item = json_encode($item_name);
            $sav->quantity = json_encode($quantity);
            $sav->amount = json_encode($amount);
            $sav->discount = json_encode($discount);
            $sav->tax = json_encode($tax);
            $sav->total = json_encode($total);
            $sav->real_total = json_encode(array_sum($total));
            $sav->notes = json_encode($notes);
            $sav->customer_id = $request->customer_id;
            $sav->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
            $sav->currency = $currency->coin_id;
            $sav->invoice_type = $request->invoice_type;
            $sav->hourstoNextDue = $hour;
            $sav->noOfPayments = 0;
            $sav->save();
            return response()->json(['message' => 'Invoice updated','status' => 'success','invoice' => $sav], 201);   
            
        } else {
            $data['title'] = 'Error Message';
            return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);  
        }


    }       
    public function previewinvoice($id)
    {
        $set=Settings::first();
        if($set->invoice==1){
            $data['title']='Preview';
            $data['invoice']=$invoice=Invoice::whereref_id($id)->first();
            $data['amount']=json_decode($invoice->amount, true);
            $data['quantity']=json_decode($invoice->quantity, true);
            $data['notes']=json_decode($invoice->notes, true);
            $data['tax']=json_decode($invoice->tax, true);
            $data['discount']=json_decode($invoice->discount, true);
            $data['total']=json_decode($invoice->total, true);
            $data['link']=$invoice=Invoice::whereref_id($id)->first();
            $data['merchant']=$merchant=User::whereid($invoice->user_id)->first();
            return response()->json(['message' => 'success','data' => $data], 201);
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    }   
    public function addinvoice()
    {
        $set=Settings::first();
        if($set->invoice==1){
            $data['title']='Create invoice';
            return response()->json(['message' => 'success','data' => $data], 201);
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    } 
    public function submitinvoice(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'customer_id' => 'required|exists:customer,id',
            'due_date' =>'required|date|date_format:Y-m-d|after_or_equal:' . now()->format ('Y-m-d'),
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
            return response()->json(['errors' => $validator->errors()],422);
        }

        $set = Settings::first();
        if($set->invoice == 1){
            $user=$data['user'] = User::find(Auth::user()->id);
            $currency = Countrysupported::whereid(Auth::user()->pay_support)->first();
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
            $sav->user_id = Auth::user()->id;
            $sav->customer_id = $request->customer_id;
            $sav->ref_id = $token;
            $sav->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
            $sav->address = $request->address;
            $sav->currency = $currency->coin_id;
            $sav->mode = $user->live;
            $sav->invoice_type = $request->invoice_type;
            $sav->hourstoNextDue = $hour;
            $sav->noOfPayments = 0;
            $sav->save();
            
            return response()->json(['message' => 'Invoice created','status' => 'success','invoice' => $sav], 201);   
            
        }else{
            $data['title']='Error Message';
            return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);  
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
            return response()->json(['errors' => $validator->errors()],422);
        }
        $set=Settings::first();
        if($set->invoice==1){
            $user=$data['user']=User::find(Auth::user()->id);
            try{
                $validatorf = new EmailValidator();
                $multipleValidations = new MultipleValidationWithAnd([
                    new RFCValidation(),
                    new DNSCheckValidation()
                ]);
                if($validatorf->isValid($request->email, $multipleValidations)){}else{
                    return response()->json(['message' => 'Invalid email address','status' => 'failed','data' => null], 400);
                }
                $phone = PhoneNumber::make($request->phone, $request->iso)->formatE164();
                $sav = Customer::whereid($id)->first();
                $sav->email=$request->email;
                $sav->first_name=$request->first_name;
                $sav->last_name=$request->last_name;
                $sav->company_name=$request->company_name;
                $sav->code=$request->phone_code;
                $sav->split_phone=$request->phone;
                $sav->phone=$phone;
                $sav->country=$request->country;
                $sav->state=$request->state;
                $sav->city=$request->city;
                $sav->line_1=$request->line_1;
                $sav->line_2=$request->line_2;
                $sav->postal_code=$request->postal_code;
                $sav->save(); 
                return response()->json(['message' => 'Customer successfully updated','status' => 'success','data' => $sav], 201);                   
            }catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);
            }catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);                   
            }catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);                  
            }catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);           
            }
        }else{
            return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
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
            return response()->json(['errors' => $validator->errors()],422);
        }
        $set=Settings::first();
        if($set->invoice==1){
            try{
                $validatorf = new EmailValidator();
                $multipleValidations = new MultipleValidationWithAnd([
                    new RFCValidation(),
                    new DNSCheckValidation()
                ]);
                if($validatorf->isValid($request->email, $multipleValidations)){

                }else{
                    return response()->json(['message' => 'Invalid email address','status' => 'failed','data' => null], 400);
                }
                $phone = PhoneNumber::make($request->phone, $request->iso)->formatE164();
                $sav = new Customer();
                $sav->user_id=Auth::user()->id;
                $sav->ref_id='CUS-'.str_random(6);
                $sav->email=$request->email;
                $sav->company_name=$request->company_name;
                $sav->first_name=$request->first_name;
                $sav->last_name=$request->last_name;
                $sav->code=$request->phone_code;
                $sav->split_phone=$request->phone;
                $sav->phone=$phone;
                $sav->country=$request->country;
                $sav->state=$request->state;
                $sav->city=$request->city;
                $sav->line_1=$request->line_1;
                $sav->line_2=$request->line_2;
                $sav->postal_code=$request->postal_code;
                $sav->mode = (Auth::user()->live == 0) ? 0 :1; 
                $sav->save();
                return response()->json(['message' => 'Customer successfully created','status' => 'success','data' => $sav], 201);                   
            }catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);
            }catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);                   
            }catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);                  
            }catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
                return response()->json(['message' => $e->getMessage(),'status' => 'failed','data' => null], 400);           
            }
        }else{
            return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    }       
    public function submitpreview(Request $request)
    {
        $set=Settings::first();
        if($set->invoice==1){
            $data=Invoice::whereId($request->id)->first();
            $set=Settings::first();
            if($set->email_notify==1){
                $gg=[
                    'email'=>$data->email,
                    'name'=>$data->first_name.' '.$data->last_name,
                    'subject'=>'Invoice Payment',
                    'message'=>'Hi '.$data->first_name.' '.$data->last_name.', here is your invoice payment link '.route('view.invoice', ['id' => $data->ref_id]).'. Your payment will be due by '.$data->due_date
                ];
                Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));
            }
            dispatch(new SendSms($data->phone, 'Hi '.$data->first_name.' '.$data->last_name.', here is your invoice payment link '.route('view.invoice', ['id' => $data->ref_id]).'. Your payment will be due by '.$data->due_date));
            return response()->json(['message' => 'Invoice was successfully sent','status' => 'success','data' => null], 201);
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    } 

    public function smsinvoice($id)
    {
        $data=Invoice::whereref_id($id)->first();
        dispatch(new SendSms($data->phone, 'Hi '.$data->first_name.' '.$data->last_name.', here is your invoice payment link '.route('view.invoice', ['id' => $data->ref_id]).'. Your payment will be due by '.$data->due_date));
        return response()->json(['message' => 'SMS sent','status' => 'failed','data' => null], 201);
    }    
    public function Reminderinvoice($type,$id)
    {
        if ($type == 'email' OR $type == 'sms') {
            $set=Settings::first();
            if($set->invoice==1){
                $data=Invoice::whereid($id)->first();
                $set=Settings::first();
                if($type == 'email' AND $data->user->email_limit > $data->user->used_email ){
                    dispatch_sync(new SendInvoice($data->ref_id));
                    updateEmailLimit($data->user->id);
                    return response()->json(['message' => 'Invoice was successfully sent','status' => 'success','data' => null], 201);
                }
                elseif($type == 'sms' AND $data->user->sms_limit > $data->user->used_sms){
                    dispatch_sync(new SendSms($data->phone, 'Hi '.$data->first_name.' '.$data->last_name.', here is your invoice payment link '.route('view.invoice', ['id' => $data->ref_id]).'. Your payment will be due by '.$data->due_date));
                    updateSmsLimit($data->user->id);
                    return response()->json(['message' => 'Invoice was successfully sent','status' => 'success','data' => null], 201);
                }else{
                    return response()->json(['message' => 'Email limit has been exceeded','status' => 'failed','data' => null], 400);
                }
            }else{
               return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
            }
        }else{
            return response()->json('Not found', 404);
        }
       
    }         
     
    public function Destroyinvoice($id)
    {
        $set = Settings::first();
        if($set->invoice==1){
            $link = Invoice::whereid($id)->firstorFail();
                $history = Transactions::wherepayment_link($id)->get();
                foreach ($history as $val) {
                    $val->delete();
                }
            $data = $link->delete();
            if ($data) {
                return response()->json(['message' => 'Invoice was successfully deleted','status' => 'success','data' => null], 201);
            } else {
                return response()->json(['message' => 'Problem With Deleting Invoice','status' => 'failed','data' => null], 400);
            }
        }else{
           return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    }    
    public function Destroycustomer($id)
    {
        $set=Settings::first();
        if($set->invoice==1){
            $check = Invoice::wherecustomer_id($id)->count();
            if($check==0){
                $link = Customer::whereid($id)->first();
                $data=$link->delete();
                if ($data) {
                    return response()->json(['message' => 'Customer was Successfully deleted!','status' => 'failed','data' => null], 201);
                } else {
                    return response()->json(['message' => 'Error With Deleting Customer','status' => 'failed','data' => null], 400);
                }
            }else{
                return response()->json(['message' => 'Error with deleting customer','status' => 'failed','data' => null], 400);
            }
        }else{
            return response()->json(['message' => 'Invoice is currently unavailable','status' => 'failed','data' => null], 400);
        }
    } 
}