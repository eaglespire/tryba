<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Withdraw;
use App\Models\Charges;
use App\Models\History;


class WithdrawController extends Controller
{
   
    public function log()
    {
        $data['title']='Settlements';
        $data['withdraw']=Withdraw::orderBy('id', 'DESC')->orderby('id', 'desc')->get();
        return view('admin.withdrawal.index', $data);
    }  

    public function delete($id)
    {
        $data = Withdraw::findOrFail($id);
        if($data->status==0){
            return back()->with('toast_warning', 'You cannot delete an unpaid withdraw request');
        }else{
            $res =  $data->delete();
            if ($res) {
                return back()->with('toast_success', 'Request was Successfully deleted!');
            } else {
                return back()->with('toast_warning', 'Problem With Deleting Request');
            }
        }

    } 
    public function approve($id)
    {
        $data = Withdraw::findOrFail($id);
        $user=User::find($data->user_id);
        $user->balance=$user->balance;
        $user->save();
        $set=Settings::first();
        $data->status=1;
        $res=$data->save();
        if($set->email_notify==1){
            send_withdraw($id, 'approved');
        }
        if ($res) {
            return back()->with('toast_success', 'Request was successfully approved!');
        } else {
            return back()->with('toast_warning', 'Problem with approving request');
        }
    }    
    public function decline(Request $request)
    {
        $set=Settings::first();
        $data = Withdraw::findOrFail($request->id);
        $user=User::find($data->user_id);
        $user->balance=$user->balance+$data->amount+$data->charge;
        $user->save();
        $data->status=2;
        $data->comment=$request->reason;
        $res=$data->save();
        $charges = Charges::whereref_id($data->reference)->delete();
        if($set->email_notify==1){
                   send_email($user->email, $user->username, 'Withdraw Request has been declined', 'Withdrawal request of '.$data->reference.' has been declined, '.$data->comment.'<br>Thanks for working with us.'
            );
        }
        if ($res) {
            return back()->with('toast_success', 'Request was successfully declined!');
        } else {
            return back()->with('toast_warning', 'Problem with approving request');
        }
    }  
}
