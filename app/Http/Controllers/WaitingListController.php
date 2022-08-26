<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WaitingListController extends Controller
{
    public function addEmail(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:waiting_lists',
            'phone' => 'required|digits:11',
            'phonecode' => 'required'
        ],[
            'email.unique' => 'This email address has already requested access'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()],422);
        }

        $waitingUser = new WaitingList;
        $waitingUser->name = $request->name;
        $waitingUser->email = $request->email;
        $waitingUser->phone_number = $request->phonecode . $request->phone;
        $waitingUser->save();

        return response()->json(['message' => 'success','data' => $waitingUser], 201);
    }


    public function showWaitingList(){
        $waitingList = WaitingList::all();
        return view('admin.waiting.index',[
           'waitingList' => $waitingList,
           'title' => 'Waiting List'
        ]);
    }
}

