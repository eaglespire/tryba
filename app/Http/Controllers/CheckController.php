<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Jobs\ActivateNotificationJob;
use App\Jobs\SendBlockedJobs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\Bank;
use App\Models\Gateway;
use App\Models\Deposits;
use App\Models\Withdraw;
use App\Models\Merchant;
use App\Models\Contact;
use App\Models\Ticket;
use App\Models\Reply;
use App\Models\Product;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Charges;
use App\Models\Exttransfer;
use App\Models\Transactions;
use App\Models\Donations;
use App\Models\Paymentlink;
use App\Models\Plans;
use App\Models\Subscribers;
use App\Models\Audit;
use App\Models\Virtual;
use App\Models\Billtransactions;
use App\Models\History;
use App\Models\Productcategory;
use App\Models\Storefront;
use App\Models\Shipping;
use App\Models\CustomDomain;
use Carbon\Carbon;
use Curl\Curl;
use App\Jobs\SendPromoJob;
use App\Jobs\UserNotification;
use App\Mail\SendEmail;
use App\Models\BlockedAccounts;
use App\Models\ComplianceAudit;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class CheckController extends Controller
{

        
    public function __construct()
    {		
        $this->middleware('auth');
    }
   
    public function custom_domain(){
        $allDomains = CustomDomain::all();
        $response = Http::withHeaders([
            'X-Auth-Key' => env('TRYBA_CLOUDFLARE_API'),
            'X-Auth-Email' =>  env('TRYBA_CLOUDFLARE_EMAIL')
        ])->get(env('CLOUDFLARE_BASE_URL').'zones/'. env('TRYBA_CLOUDFLARE_ZONE_IDENTIFIER').'/custom_hostnames');

        $updatedArr = $allDomains->map(function ($item, $key) use($response) {
            if ($item->domain) {
                $urlParts = parse_url(trim($item->domain, '/'));
                $key = array_search($urlParts['host'],array_column($response['result'],'hostname'));
                $item->status = $response['result'][$key]['status'];
                return $item;
            }
         
        });
        return view('admin.category.domain', [
            'title'=>'Custom Domain',
            'domains'=> $updatedArr
        ]);
    }   

    public function activate_domain($id){
        $domain=Customdomain::find($id);
        $store=Storefront::whereid($domain->store_id)->first();
        $data = [
            'email' => $domain->storefront->user->email,
            'name' => $domain->storefront->user->first_name.' '.$domain->storefront->user->last_name,
            'subject' => 'Custom Domain Connected',
            'message' => 'Hi your custom domain has been successfully connected, you can now access your website via '.$domain->domain,
        ];
        Mail::to($data['email'], $data['name'])->queue(new SendEmail($data['subject'], $data['message'], $store));
        return back()->with('toast_success', 'Domain is now active');
    }    

    
    public function bpay(){
        $data['title']='Bill payment';
        $data['trans']=Billtransactions::orderBy('created_at', 'DESC')->get();
        return view('admin.bill.index', $data);
    }

    public function transactionsvcard($id){
        $data['title']='Transaction History';
        $val=Virtual::wherecard_hash($id)->first();
        $curl = new Curl();
        $curl->setHeader('Authorization', 'Bearer ' .env('SECRET_KEY'));
        $curl->setHeader('Content-Type', 'application/json');
        $curl->get("https://api.flutterwave.com/v3/virtual-cards/".$val->card_hash."/transactions?from=".date('Y-m-d', strtotime($val['created_at']))."&to=".Carbon::tomorrow()->format('Y-m-d')."&index=1&size=100");
        $response = $curl->response;
        $curl->close();     
        $data['log']=$response;
        return view('admin.virtual.log', $data);
    }

    public function Destroyuser($id)
    {
        $check=User::whereid($id)->first();
        $set=Settings::first();
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
        $trans = Transactions::where('Receiver_id', $id)->orWhere('Sender_id', $id)->delete();
        $store = Storefront::whereUser_id($id)->delete();
        $ship = Shipping::whereUser_id($id)->delete();
        $pro = Productcategory::whereUser_id($id)->delete();
        $user = User::whereId($id)->delete();
        return back()->with('toast_success', 'User was successfully deleted');
    }     
    
    public function Destroystaff($id)
    {
        $staff = Admin::whereId($id)->delete();
        return back()->with('toast_success', 'Staff was successfully deleted');
    }  
        
    public function dashboard()
    {
		$data['title']='Clients';
		$data['users'] = User::latest()->paginate(10);
        return view('admin.user.index', $data);
    }    
    
    public function Users()
    {
		$data['title']='Clients';
		$data['users']=User::latest()->paginate(10);
        return view('admin.user.index', $data);
    }    
    
    public function Staffs()
    {
		$data['title']='Staffs';
		$data['users']=Admin::where('id', '!=', 1)->latest()->get();
        return view('admin.user.staff', $data);
    }       

    public function Messages()
    {
		$data['title']='Messages';
		$data['message']=Contact::latest()->get();
        return view('admin.user.message', $data);
    }     

    public function Newstaff()
    {
		$data['title']='New Staff';
        return view('admin.user.new-staff', $data);
    }    
    
    public function Ticket()
    {
		$data['title']='Ticket system';
		$data['ticket']=Ticket::latest()->get();
        return view('admin.user.ticket', $data);
    }   
    
    public function Email($id,$name)
    {
		$data['title']='Send email';
		$data['email']=$id;
		$data['name']=$name;
        return view('admin.user.email', $data);
    }    
    
    public function Promo()
    {
		$data['title']='Send email';
        $data['client']=$user=User::all();
        return view('admin.user.promo', $data);
    } 
    
    public function Sendemail(Request $request)
    {    
        $gg=[
            'email'=>$request->to,
            'name'=>$request->name,
            'subject'=>$request->subject,
            'message'=>$request->message
        ];
        Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message']));    	  
        return back()->with('toast_success', 'Mail Sent Successfuly!');
    }
    
    public function Sendpromo(Request $request)
    {        	
        dispatch(new SendPromoJob($request->subject, $request->message));     
        return back()->with('toast_success', 'Mail Sent Successfuly!');
    }     
    
    public function Replyticket(Request $request)
    {        
        $data['ticket_id'] = $request->ticket_id;
        $data['reply'] = $request->reply;
        $data['status'] = 0;
        $data['staff_id'] = $request->staff_id;
        $res = Reply::create($data);  
        $set=Settings::first();   
        $ticket=Ticket::whereticket_id($request->ticket_id)->first();
        $user=User::find($ticket->user_id);
        if($set['email_notify']==1){
            $gg=[
                'email'=>$user->email,
                'name'=>$user->first_name.' '.$user->last_name,
                'subject'=>'New Reply - '.$request->ticket_id,
                'message'=>$request->reply
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message'])); 
        } 
        if ($res) {
            return back();
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    }    
    
    public function Createstaff(Request $request)
    {        
        $check=Admin::whereusername($request->username)->get();
        if(count($check)<1){
            $data['username'] = $request->username;
            $data['last_name'] = $request->last_name;
            $data['first_name'] = $request->first_name;
            $data['password'] = Hash::make($request->password);
            $data['profile'] = $request->profile;
            $data['support'] = $request->support;
            $data['promo'] = $request->promo;
            $data['message'] = $request->message;
            $data['deposit'] = $request->deposit;
            $data['settlement'] = $request->settlement;
            $data['transfer'] = $request->transfer;
            $data['request_money'] = $request->request_money;
            $data['donation'] = $request->donation;
            $data['single_charge'] = $request->single_charge;
            $data['subscription'] = $request->subscription;
            $data['merchant'] = $request->merchant;
            $data['invoice'] = $request->invoice;
            $data['charges'] = $request->charges;
            $data['store'] = $request->store;
            $data['blog'] = $request->blog;
            $data['bill'] = $request->bill;
            $data['vcard'] = $request->vcard;
            $res = Admin::create($data);  
            return redirect()->route('admin.staffs')->with('toast_success', 'Staff was successfully created');
        }else{
            return back()->with('toast_warning', 'username already taken');
        }
    }       
     
    
    public function Destroymessage($id)
    {
        $data = Contact::findOrFail($id);
        $res =  $data->delete();
        if ($res) {
            return back()->with('toast_success', 'Request was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Request');
        }
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

    public function Manageuser($id)
    {
        $data['client'] = $user = User::find($id);
        $data['title']=$user->first_name;
        $data['ticket']=Ticket::whereUser_id($user->id)->orderBy('id', 'DESC')->get();
        $data['audit']=Audit::whereUser_id($user->id)->orderBy('created_at', 'DESC')->get();
        $data['charges']=Charges::whereuser_id($user->id)->latest()->get();
        $data['trans']=Transactions::wherereceiver_id($user->id)->wheremode(1)->latest()->get();
        $data['invoice']=Invoice::whereuser_id($user->id)->wheremode(1)->latest()->get();
        $data['dplinks']=Paymentlink::whereuser_id($user->id)->wheremode(1)->wheretype(2)->latest()->get();
        $data['sclinks']=Paymentlink::whereuser_id($user->id)->wheremode(1)->wheretype(1)->latest()->get();
        $data['product']=Product::whereuser_id($user->id)->wheremode(1)->latest()->get();
        $data['merchant'] = Merchant::whereuser_id($user->id)->wheremode(1)->orderBy('id', 'DESC')->get();
        $data['compliance'] = ComplianceAudit::where('user_id',$user->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.user.edit', $data);
    }    
    
    public function Managestaff($id)
    {
        $data['staff']=$user=Admin::find($id);
        $data['title']=$user->username;
        return view('admin.user.edit-staff', $data);
    }    

    public function staffPassword(Request $request)
    {
        $user = Admin::whereid($request->id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('toast_success', 'Password Changed Successfully.');

    }
    
    public function Manageticket($id)
    {
        $data['ticket']=$ticket=Ticket::find($id);
        $data['title']='#'.$ticket->ticket_id;
        $data['client']=User::whereId($ticket->user_id)->first();
        $data['reply']=Reply::whereTicket_id($ticket->ticket_id)->get();
        return view('admin.user.edit-ticket', $data);
    }    
    
    public function Closeticket($id)
    {
        $ticket=Ticket::find($id);
        $ticket->status=1;
        $ticket->save();
        return back()->with('toast_success', 'Ticket has been closed.');
    }     
    
    public function suspendUser($id)
    {
     
        return view('admin.user.suspend-user',[
            'title' => 'Suspend User',
            'id' => $id
        ]);
    } 
    
    public function postSuspend(Request $request, $id){
        $validator = Validator::make( $request->all(),[
            'reason' =>'required',
            'privateNote' => 'required|string',
            'suspend' => 'nullable|boolean'

        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $user = User::where('id',$id)->first();
        $slug = Str::random(10);

        $suspense = false;

        if($request->has('suspend')){
            $suspense = true;      
            $user->status = 1;
            $user->save();
        }

        dispatch_sync(new UserNotification($user,false,$request->all(),$slug,$suspense));
        
        ComplianceAudit::create([
            'user_id' =>$user->id,
            'url' => $slug,
            'subject' => $request->subject,
            'reason' => $request->reason,
            'privateNote' => $request->privateNote,
            'isSuspended' => ($request->has('suspend')) ? $request->suspend : false
        ]);
       
        return redirect(route('admin.users'))->with('toast_success', 'User was successfully suspended.');
    }

    public function blockUser($id){
        $user = User::find($id);
        if($user->isBlocked == false){
            return view('admin.user.block-user',[
                'title' => 'Block User',
                'id' => $id
            ]);
        }else{
            return redirect(route('admin.users'))->with('toast_danger', 'User account is already terminated!.');
        }
    
    }

    public function terminateAccount($id,Request $request){
        $validator = Validator::make($request->all(),[
            'privateNote' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $user = User::find($id);
        $user->isBlocked = true;
        $user->save();

        $slug = Str::random(10);

        BlockedAccounts::updateOrCreate(
            ['user_id' => $user->id],[
            'private_note' => $request->privateNote,
            'isMoneyinAccount' => ($user->gBPAccount() != NULL && $user->gBPAccount()->balance > 0 ) ? true : false,
            'slug' => $slug
        ]);

        dispatch_sync(new SendBlockedJobs($user,$slug));

        return redirect(route('admin.users'))->with('toast_success', 'Account terminated.');
    }

    public function Unblockuser($id)
    {
        $user=User::find($id);
        $user->status = 0;
        $user->save();

        dispatch_sync(new ActivateNotificationJob($user));

        return back()->with('toast_success', 'User was successfully unblocked.');
    }    

    public function compliance(){

        $compliance =  ComplianceAudit::latest()->get();

        return view('admin.compliance.index',[
            'title' => 'Compliance',
            'compliance' => $compliance
        ]);


    }

    public function viewResponse($url){
        $compliance =  ComplianceAudit::where('url',$url)->firstorFail();   
        return view('admin.compliance.show',[
            'title' => 'Compliance',
            'compliance' => $compliance
        ]);
    }

    public function resendCompliance($url){
        $compliance =  ComplianceAudit::where('url',$url)->firstorFail();
        $compliance->response = NULL;
        $compliance->responded = false;
        $compliance->file_url = NULL;
        $compliance->save();

        $data = [
            'subject' => $compliance->subject,
            'reason' => $compliance->reason,
        ];

        $user = User::find($compliance->user_id);
        dispatch_sync(new UserNotification($user,false,$data,$compliance->url,$compliance->isSuspended));


        return back()->with('toast_success', 'Compliance was resent');

    }
    
    public function Readmessage($id)
    {
        $data=Contact::find($id);
        $data->seen=1;
        $data->save();
        return back()->with('toast_success', 'Message has been marked read.');
    } 

    public function Unreadmessage($id)
    {
        $data=Contact::find($id);
        $data->seen=0;
        $data->save();
        return back()->with('toast_success', 'Message has been marked unread.');
    }    
    
    public function Blockstaff($id)
    {
        $user=Admin::find($id);
        $user->status=1;
        $user->save();
        return back()->with('toast_success', 'Staff has been suspended.');
    } 

    public function Unblockstaff($id)
    {
        $user=Admin::find($id);
        $user->status=0;
        $user->save();
        return back()->with('toast_success', 'Staff was successfully unblocked.');
    }

    public function Approvekyc($id)
    {
        $set=Settings::first();
        $user=User::find($id);
        $user->due=2;
        $user->save();
        if($set['email_notify']==1){
            $gg=[
                'email'=>$user->email,
                'name'=>$user->first_name.' '.$user->last_name,
                'subject'=>'Compliance Update',
                'message'=>"Compliance was successfully approved, you can now use your account without restrictions"
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message'])); 
        }
        return back()->with('toast_success', 'Compliance has been approved.');
    }    

    public function Rejectkyc(Request $request)
    {
        $set=Settings::first();
        $user=User::find($request->id);
        $user->due=0;
        $user->save();
        if($set->email_notify==1){
            $gg=[
                'email'=>$user->email,
                'name'=>$user->first_name.' '.$user->last_name,
                'subject'=>'Compliance Update',
                'message'=>"Compliance request was declined, Reason:".$request->reason
            ];
            Mail::to($gg['email'], $gg['name'])->queue(new SendEmail($gg['subject'], $gg['message'])); 
        }
        return back()->with('toast_success', 'Compliance has been declined.');
    }
    public function Profileupdate(Request $request)
    {
        $data = User::findOrFail($request->id);
        $data->business_name=$request->business_name;
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        $data->phone=$request->mobile;
        $data->website_link=$request->website;
        if(empty($request->email_verify)){
            $data->email_verify=0;	
        }else{
            $data->email_verify=$request->email_verify;
        }         
        if(empty($request->phone_verify)){
            $data->phone_verify=0;	
        }else{
            $data->phone_verify=$request->phone_verify;
        }             
        if(empty($request->fa_status)){
            $data->fa_status=0;	
        }else{
            $data->fa_status=$request->fa_status;
        }        
        if(empty($request->payment)){
            $data->payment=0;	
        }else{
            $data->payment=$request->payment;
        }
        if(empty($request->dispute)){
            $data->dispute=0;	
            $withdraw=Withdraw::whereuser_id($data->id)->wherestatus(3)->get();
            foreach($withdraw as $val){
                $val->status=0;
                $val->save();
            }
        }else{
            $data->dispute=$request->dispute;
            $withdraw=Withdraw::whereuser_id($data->id)->wherestatus(0)->get();
            foreach($withdraw as $val){
                $val->status=3;
                $val->save();
            }
        }         
        $res=$data->save();
        if ($res) {
            return back()->with('toast_success', 'Update was Successful!');
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    }    
    public function Staffupdate(Request $request)
    {
        $data = Admin::whereid($request->id)->first();
        $data->username=$request->username;
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        if(empty($request->profile)){
            $data->profile=0;	
        }else{
            $data->profile=$request->profile;
        }  

        if(empty($request->support)){
            $data->support=0;	
        }else{
            $data->support=$request->support;
        }    

        if(empty($request->promo)){
            $data->promo=0;	
        }else{
            $data->promo=$request->promo;
        }     

        if(empty($request->message)){
            $data->message=0;	
        }else{
            $data->message=$request->message;
        }     

        if(empty($request->deposit)){
            $data->deposit=0;	
        }else{
            $data->deposit=$request->deposit;
        }     

        if(empty($request->settlement)){
            $data->settlement=0;	
        }else{
            $data->settlement=$request->settlement;
        }     

        if(empty($request->transfer)){
            $data->transfer=0;	
        }else{
            $data->transfer=$request->transfer;
        }     

        if(empty($request->request_money)){
            $data->request_money=0;	
        }else{
            $data->request_money=$request->request_money;
        }               
        
        if(empty($request->donation)){
            $data->donation=0;	
        }else{
            $data->donation=$request->donation;
        }          
        
        if(empty($request->single_charge)){
            $data->single_charge=0;	
        }else{
            $data->single_charge=$request->single_charge;
        }          
        
        if(empty($request->subscription)){
            $data->subscription=0;	
        }else{
            $data->subscription=$request->subscription;
        }          
        
        if(empty($request->merchant)){
            $data->merchant=0;	
        }else{
            $data->merchant=$request->merchant;
        }          
        
        if(empty($request->invoice)){
            $data->invoice=0;	
        }else{
            $data->invoice=$request->invoice;
        }          
        
        if(empty($request->charges)){
            $data->charges=0;	
        }else{
            $data->charges=$request->charges;
        }     

        if(empty($request->store)){
            $data->store=0;	
        }else{
            $data->store=$request->store;
        }   

        if(empty($request->blog)){
            $data->blog=0;	
        }else{
            $data->blog=$request->blog;
        }         
        
        if(empty($request->bill)){
            $data->bill=0;	
        }else{
            $data->bill=$request->bill;
        }         
        
        if(empty($request->vcard)){
            $data->vcard=0;	
        }else{
            $data->vcard=$request->vcard;
        }                  

        $res=$data->save();
        if ($res) {
            return back()->with('toast_success', 'Update was Successful!');
        } else {
            return back()->with('toast_warning', 'An error occured');
        }
    }

    public function blockedUsers(){
        $blockedAccount = BlockedAccounts::with('user')->get();
        return view('admin.compliance.blocked',[
            'blocked' =>  $blockedAccount,
            'title' => "Blocked Accounts"
        ]);

    }

    public function UnblockedUsers($slug){

        $blockedUser = BlockedAccounts::where('slug',$slug)->with('user')->first();
        $user = User::where('id',$blockedUser->user->id)->first();
        $user->isBlocked = false;
        $user->save();
        $blockedUser->delete();

        return back()->with('toast_success', 'Reinstated Account Successfully!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.loginForm');
    }
        
}
