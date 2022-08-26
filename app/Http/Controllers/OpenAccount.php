<?php

namespace App\Http\Controllers;

use App\Http\Requests\business;
use App\Http\Requests\business_two;
use App\Http\Requests\described;
use App\Http\Requests\gender_date;
use App\Http\Requests\personal;
use App\Http\Requests\planning_try;
use App\Http\Requests\turnover;
use App\Http\Requests\website;
use App\Http\Requests\whatTryba;
use App\Models\openAccount as ModelsOpenAccount;
use Illuminate\Database\Events\ModelsPruned;
use Illuminate\Http\Request;
use App\Http\Requests\sociallink;
class OpenAccount extends Controller
{
    //first question
      public function planning_to_tryba(ModelsOpenAccount $openaccount, planning_try $request){
      if($this->getuser()){
         // dd($request->all());
         $openaccount->create([
            'user_id'=>auth()->user()->id,
            'newbusiness'=>$request->newbusiness == 1?true:false,
             'existingbusiness'=>$request->existingbusiness == 1?true:false
            ]);
            return response()->json([
                'code'=>200,
                'success'=>'successful'
            ]);
      }else{
          return response()->json([
              'code'=>404,
              'error'=>'please create an account'
          ]);
      }
      }


    //second question
      public function what_would_tryba(ModelsOpenAccount $openaccount, whatTryba $request ){
        if($this->getuser()){
          $account = $openaccount->where('user_id', auth()->user()->id)->first();
          $account->update([
            "offer_service"=>$request->offer_service,
            "sell_online"=>$request->sell_online,
          ]);
          return response()->json([
            'code'=>200,
            'success'=>'successful'
        ]);
        }else{
            return response()->json([
                'code'=>404,
                'error'=>'please create an account'
            ]);
        }
      }

    //third question
    public function gender_and_date(ModelsOpenAccount $openaccount, gender_date $request){
      if($this->getuser()){
        $account = $openaccount->where('user_id', auth()->user()->id)->first();
          $account->update([
              "gender"=>$request->gender,
              "date_of_birth"=>$request
          ]);
          return response()->json([
            'code'=>200,
            'success'=>'successful'
        ]);
      }else{
        return response()->json([
            'code'=>404,
            'error'=>'please create an account'
        ]);
      }
    }

    //fouth question
    public function describe(ModelsOpenAccount $openaccount, described $request){
     if($this->getuser()){
        $account = $openaccount->where('user_id', auth()->user()->id)->first();
       $account->update([
         "describe"=>$request->describe
       ]);
       return response()->json([
        'code'=>200,
        'success'=>'successful'
    ]);
     }else{
        return response()->json([
            'code'=>404,
            'error'=>'please create an account'
        ]);
     }
    }

    //fivth question
    public function website(ModelsOpenAccount $openaccount, website $request ){
    if($this->getuser()){
    $account = $openaccount->where('user_id', auth()->user()->id)->first();
      $account->update([
          "website"=>$request->website,
          "website_link"=>$request->website_link
      ]);
      return response()->json([
        'code'=>200,
        'success'=>'successful'
    ]);
    }else{
        return response()->json([
            'code'=>404,
            'error'=>'please create an account'
        ]);
     }
    }

//sixth question
    public function turnover(ModelsOpenAccount $openaccount, turnover $request){
        if($this->getuser()){
            $account = $openaccount->where('user_id', auth()->user()->id)->first();
            $account->update([
            "turnover"=>$request->turnover
            ]);
            return response()->json([
                'code'=>200,
                'success'=>'successful'
            ]);
        }else{
            return response()->json([
                'code'=>404,
                'error'=>'please create an account'
            ]);
        }
    }

    //seventh question
    public function business(ModelsOpenAccount $openaccount, business $request){
     if($this->getuser()){
        $account = $openaccount->where('user_id', auth()->user()->id)->first();
        $account->update([
         "business_type"=>$request->business_type,
         "business_name"=>$request->business_name
        ]);
        return response()->json([
            'code'=>200,
            'success'=>'successful'
        ]);
     }else{
        return response()->json([
            'code'=>404,
            'error'=>'please create an account'
        ]);
    }
    }

    //eight question
    public function business_second(ModelsOpenAccount $openaccount, business_two $request){

        if($this->getuser()){
            $account = $openaccount->where('user_id', auth()->user()->id)->first();
            $account->update([
             "company_registration_number"=>$request->company_registration_number,
             "business_category"=>$request->business_category
            ]);
            return response()->json([
                'code'=>200,
                'success'=>'successful'
            ]);
         }else{
            return response()->json([
                'code'=>404,
                'error'=>'please create an account'
            ]);
        }
    }

    public function personaldetails(ModelsOpenAccount $openaccount, personal $request){
        if($this->getuser()){
            $account = $openaccount->where('user_id', auth()->user()->id)->first();
            $account->update([
             "postal_or_zipcode"=>$request->postal_or_zipcode,
             "state"=>$request->state,
             "address_one"=>$request->address_one,
             "address_two"=>$request->address_two
            ]);
            return response()->json([
                'code'=>200,
                'success'=>'successful'
            ]);
         }else{
            return response()->json([
                'code'=>404,
                'error'=>'please create an account'
            ]);
        }

    }

    public function sociallinks(ModelsOpenAccount $openaccount, sociallink $request){
        if($this->getuser()){
            $account = $openaccount->where('user_id', auth()->user()->id)->first();
            $account->update([
             "web"=>$request->web,
             "face"=>$request->facebook,
             "instagram"=>$request->instag,
             "twitter"=>$request->twitter
            ]);
            return response()->json([
                'code'=>200,
                'success'=>'successful'
            ]);
         }else{
            return response()->json([
                'code'=>404,
                'error'=>'please create an account'
            ]);
        }
    }

}
