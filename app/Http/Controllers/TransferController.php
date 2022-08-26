<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Settings;
use App\Models\Transfer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transactions;
use App\Models\Productimage;
use App\Models\Requests;
use App\Models\Charges;
use App\Models\Donations;
use App\Models\Paymentlink;
use App\Models\Plans;
use App\Models\Subscribers;
use App\Models\Savings;
use App\Models\Banktransfer;
use App\Models\Deposits;
use App\Models\Exttransfer;
use App\Models\Countrysupported;
use App\Models\History;
use App\Models\Gateway;
use Stripe\StripeClient;


class TransferController extends Controller
{

    public function sclinks()
    {
        $data['title'] = "Single Charge";
        $data['links'] = Paymentlink::wheretype(1)->wheremode(1)->with('user')->latest()->paginate(10);
        return view('admin.transfer.sc', $data);
    }    
    public function transactions()
    {
        $data['title']='Transactions';
        $data['trans']=Transactions::wheremode(1)->latest()->paginate(10);
        return view('admin.transfer.index', $data);
    } 
    // public function saving()
    // {
    //     $data['title'] = "Savings";
    //     $data['savings'] = Savings::wheremode(1)->latest()->paginate(6);
    //     return view('admin.transfer.saving', $data);
    // } 
    public function dplinks()
    {
        $data['title'] = "Donation Page";
        $data['links']=Paymentlink::wheremode(1)->wheretype(2)->latest()->paginate(10);
        return view('admin.transfer.dp', $data);
    }
    // public function Ownbank()
    // {
    //     $data['title']='Transfer';
    //     $data['transfer'] = Transfer::wheremode(1)->latest()->get();
    //     return view('admin.transfer.own-bank', $data);
    // }     
    // public function Requestmoney()
    // {
    //     $data['title']='Request Money';
    //     $data['request']=Requests::wheremode(1)->latest()->get();
    //     return view('admin.transfer.request', $data);
    // }      
    public function Invoice()
    {
        $data['title']='Invoice';
        $data['invoice']=Invoice::wheremode(1)->latest()->paginate(10);
        return view('admin.transfer.invoice', $data);
    }      
    public function Product()
    {
        $data['title'] = 'Product';
        $data['product'] = Product::wheremode(1)->latest()->paginate(10);
        return view('admin.transfer.product', $data);
    }    
    public function charges()
    {
        $data['title']='Charges';
        $data['charges']=Charges::wheremode(1)->latest()->get();
        return view('admin.transfer.charges', $data);
    }
    // public function plans()
    // {
    //     $data['title']='Plans';
    //     $data['plans']=Plans::wheremode(1)->latest()->get();
    //     return view('admin.transfer.plans', $data);
    // }
    // public function unplan($id)
    // {
    //     $page=Plans::find($id);
    //     $page->status=0;
    //     $page->save();
    //     return back()->with('toast_success', 'Plan has been disabled.');
    // } 
    // public function plansub($id)
    // {
    //     $data['plan']=$plan=Plans::wheremode(1)->whereref_id($id)->first();
    //     $data['sub']=Subscribers::wheremode(1)->whereplan_id($plan->id)->latest()->get();
    //     $data['title']=$plan->ref_id;
    //     return view('admin.transfer.subscribers', $data);
    // }
    // public function pplan($id)
    // {
    //     $page=Plans::find($id);
    //     $page->status=1;
    //     $page->save();
    //     return back()->with('toast_success', 'Plan link has been activated.');
    // }
    public function Orders($id)
    {
        $data['title']='Orders';
        $data['orders']=Order::wheremode(1)->whereproduct_id($id)->latest()->get();
        return view('admin.transfer.orders', $data);
    }  
    public function linkstrans($id)
    {
        $data['title'] = "Transactions";
        $data['links'] = Transactions::wheremode(1)->wherepayment_link($id)->latest()->paginate(10);
        return view('admin.transfer.trans', $data);
    }
    public function unlinks($id)
    {
        $page=Paymentlink::find($id);
        $page->status=0;
        $page->save();
        return back()->with('toast_success', 'Payment link has been unsuspended.');
    } 
    public function plinks($id)
    {
        $page=Paymentlink::find($id);
        $page->status=1;
        $page->save();
        return back()->with('toast_success', 'Payment link has been suspended.');
    }    
    public function unproduct($id)
    {
        $page=Product::find($id);
        $page->active=1;
        $page->save();
        return back()->with('toast_success', 'Product has been unsuspended.');
    } 
    public function pproduct($id)
    {
        $page=Product::find($id);
        $page->active=0;
        $page->save();
        return back()->with('toast_success', 'Product has been suspended.');
    }
    public function Destroylink($id)
    {
        $link=Paymentlink::whereid($id)->first();
        $history=Transactions::wherepayment_link($id)->delete();
        if($link->type==2){
            $donation=Donations::wheredonation_id($id)->delete();
        }
        $data=$link->delete();
        if ($data) {
            return back()->with('toast_success', 'Payment link was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Payment link');
        }
    }   
    // public function Destroyownbank($id)
    // {
    //     $data = Transfer::findOrFail($id);
    //     $res =  $data->delete();
    //     if ($res) {
    //         return back()->with('toast_success', 'Request was Successfully deleted!');
    //     } else {
    //         return back()->with('toast_warning', 'Problem With Deleting Request');
    //     }
    // }    
    // public function Destroyrequest($id)
    // {
    //     $data = Requests::findOrFail($id);
    //     $res =  $data->delete();
    //     if ($res) {
    //         return back()->with('toast_success', 'Request was Successfully deleted!');
    //     } else {
    //         return back()->with('toast_warning', 'Problem With Deleting Request');
    //     }
    // }      
    public function Destroyinvoice($id)
    {
        $link=Invoice::whereid($id)->first();
        $history=Transactions::wherepayment_link($id)->delete();
        $res=$link->delete();
        if ($res) {
            return back()->with('toast_success', 'Request was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Request');
        }
    }     
    public function Destroyproduct($id)
    {
        $data = Product::findOrFail($id);
        $res =  $data->delete();
        if ($res) {
            return back()->with('toast_success', 'Request was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Request');
        }
    }     
    public function Destroyorders($id)
    {
        $data = Order::findOrFail($id);
        $res =  $data->delete();
        if ($res) {
            return back()->with('toast_success', 'Request was Successfully deleted!');
        } else {
            return back()->with('toast_warning', 'Problem With Deleting Request');
        }
    }       
    
}
