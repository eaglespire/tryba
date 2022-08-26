<?php

namespace App\Http\Controllers;

use App\Models\BugReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BugReportsController extends Controller
{
    public function postProblem(Request $request){
        $validator = Validator::make( $request->all(),[
            'description' =>'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('toast_error', $validator->errors()->first());
        }

        BugReports::create([
            'user_id' => auth()->guard('user')->user()->id,
            'description' => $request->description
        ]);

        return back()->with('toast_success', "We have received your bug report and we'll fix");
    }

    public function getBugs(){

        $bugs = BugReports::all();
        return view('admin.bugs.index',[
            'bugs' => $bugs,
            'title' => "Bug Report"
        ]);
    }
}
