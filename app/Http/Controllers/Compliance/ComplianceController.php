<?php

namespace App\Http\Controllers\Compliance;

use App\Http\Controllers\Controller;
use App\Models\BlockedAccounts;
use App\Models\Bookings;
use App\Models\BookingServices;
use App\Models\Budget;
use App\Models\ComplianceAudit;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Order;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Transactions;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class ComplianceController extends Controller
{
    //

    public function getForm($url){
        $data['compliance'] =  ComplianceAudit::where('url',$url)->firstorFail();
        $data['set'] = Settings::first();
        $data['title'] = 'Compliance';
        return view('compliance.compliance',$data);
    }

    public function RespondForm(Request $request, $url){
        $validator = Validator::make( $request->all(),[
            'response' => 'required|string|max:50',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:20000',
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $compliance = ComplianceAudit::where('url',$url)->first();
        $compliance->response = $request->response;
        $compliance->file_url = ($request->has('file')) ? Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath() : NULL;
        $compliance->responded = true;
        $compliance->save();

        return back()->with('success','We would review the following document within the next 4 hours');
    }

    public function getBlockedForm($url){
        $blockedAccount = BlockedAccounts::where('slug',$url)->with('user')->firstorFail();
        return view('compliance.download',[
            'set' => Settings::first(),
            'title' => "Blocked Account",
            'blocked' => $blockedAccount 
        ]);
    }

    public function downloadData($url,Request $request){
        $validator = Validator::make( $request->all(),[
            'accountNumber' => 'nullable|numeric|digits:8',
            'sortCode' => 'required_with:accountNumber|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }

        $blocked = BlockedAccounts::where('slug',$url)->with('user')->firstorFail();
        if($request->has('accountNumber') && $request->has('sortCode')){
            $blocked->account_number = $request->accountNumber;
            $blocked->sort_code = $request->sortCode;
            $blocked->save();
        }

        //All Data 
        $transaction = Transactions::where('receiver_id',$blocked->user->id)->get();
        $expense = Expense::where('uuid',$blocked->user->id)->get();
        $budget = Budget::where('uuid',$blocked->user->id)->get();
        $income = Income::where('uuid',$blocked->user->id)->get();
        $products = Product::where('user_id',$blocked->user->id)->get();
        $orders = Order::where('seller_id',$blocked->user->id)->get();
        $customer = Customer::where('user_id',$blocked->user->id)->get();
        $services = BookingServices::where('user_id',$blocked->user->id)->get();
        $bookings = Bookings::where('user_id',$blocked->user->id)->get();
        
        $files = [
            $transaction->storeExcel('blocked/transaction.xlsx'),
            $expense->storeExcel('blocked/expense.xlsx'),
            $budget->storeExcel('blocked/budget.xlsx'),
            $budget->storeExcel('blocked/budget.xlsx'),
            $income->storeExcel('blocked/income.xlsx'),
            $products->storeExcel('blocked/products.xlsx'),
            $orders->storeExcel('blocked/orders.xlsx'),
            $customer->storeExcel('blocked/customer.xlsx'),
            $services->storeExcel('blocked/services.xlsx'),
            $bookings->storeExcel('blocked/bookings.xlsx')
        ];

        $zip = new ZipArchive;
        $filename ="tryba_data.zip"; // Zip name
        $zip->open($filename,  ZipArchive::CREATE);
        $files = File::files(public_path('blocked'));
   
        foreach ($files as $key => $value) {
            $relativeNameInZipFile = basename($value);
            $zip->addFile($value, $relativeNameInZipFile);
        }
         
        $zip->close();

        return response()->download(public_path($filename));
    }

}
