<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    public function billingClient(){

    }

    public function showAdminPlans(){
        $allPlans = SubscriptionPlan::all();

        return view('admin.plans.index',[
            'allSubscriptionPlans' => $allPlans,
            'title'                => 'Subscriptions Plans'
        ]);
    }

    public function updateAdminPlans($id,Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'amount' =>'required|integer',
            'duration' =>'required|integer',
            'durationType' => 'required|in:month',
            'annualstartPrice' => 'required|integer',
            'annualendPrice' => 'required|integer',
            'email_limit' =>  'required|integer',
            'sms_limit' =>  'required|integer'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        SubscriptionPlan::whereid($id)->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'duration' => $request->duration,
            'durationType' => $request->durationType,
            'annualstartPrice' => $request->annualstartPrice,
            'annualendPrice' => $request->annualendPrice,
            'email_limit' => $request->email_limit,
            'sms_limit' => $request->sms_limit
        ]);

        return back()->with('toast_success', 'Subscription plan updated!');
    }
}
