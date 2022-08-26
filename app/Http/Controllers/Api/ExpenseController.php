<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExpenseController as ControllersExpenseController;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    
    public function addNewCategory(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }
        $category = ExpenseCategory::create([
            'uuid' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['message' => 'success','category' => $category], 201);
    }

    public function getMonthlyTotal(){
        $expenses = Expense::where('uuid',Auth::user()->id)->with('category')->get();
        $currentMonth = Expense::where('uuid',Auth::user()->id)->whereMonth('date', Carbon::now()->month)->get();
        $incomecurrentMonthArr = Income::where('uuid',Auth::user()->id)->whereMonth('date', Carbon::now()->month)->get();
        $overall =  $this->addExpense($expenses);
        $month = $this->addExpense($currentMonth);
        $incomecurrentMonth = $this->addExpense($incomecurrentMonthArr);
        $monthBudget = Budget::where([
                            'uuid' => Auth::user()->id,
                            'month' => Carbon::now()->format('F'),
                            'year' => Carbon::now()->year
                            ])->with('category')->get();

        $monthBudgetAmount = $this->addExpense($monthBudget);

        $currency = getUserCurrencyName(Auth::user());

        return  response()->json([
            'overallExpense' => $overall,
            'ExpensecurrentMonth' => $month,
            'monthBudgetAmount'  =>  $monthBudgetAmount,
            'incomecurrentMonth' => $incomecurrentMonth,
            'currency' => $currency
        ],200);
    }

    public function addExpense($data){
        $overAmount = 0;
        foreach ($data as $item){
            $overAmount = $overAmount + $item->amount;
        }
        return $overAmount;
    }

 
    public function showAllCategory(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        return response()->json(['message' => 'success','categories' => $categories], 200);
    }

    public function updatePostCategory(Request $request,$id){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $category = ExpenseCategory::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $category = ExpenseCategory::whereid($id)->where('uuid',Auth::user()->id)->first();

        return response()->json(['message' => 'success','category' => $category], 201);
    }

    public function deleteCategory($id){
        $category = ExpenseCategory::whereid($id)->where('uuid',Auth::user()->id)->firstorFail();
        $category->delete();
        return response()->json(['message' => 'success'], 200);
    }


    public function AllSubCategoryExpenseApi($id){
        $subcategory = ExpenseSubcategory::whereuuid(Auth::user()->id)->where('categoryID',$id)->with('category')->get();
        return response()->json(['message' => 'success','subcategory' => $subcategory],200);
    }


    public function postSubCategory(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'category' => 'required|exists:expense_categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $subcategory = ExpenseSubcategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'uuid' => Auth::user()->id
        ]);

        return response()->json(['message' => 'success','subcategory' => $subcategory], 200);
    }

    public function postUpdateSubCategory($id,Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'category' => 'required|exists:expense_categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $subcategory = ExpenseSubcategory::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
        ]);
        $subcategory = ExpenseSubcategory::whereid($id)->where('uuid',Auth::user()->id)->first();

        return response()->json(['message' => 'success','subcategory' => $subcategory], 200);
    }

    public function deleteSubCategory($id){
        $subcategory = ExpenseSubcategory::whereid($id)->where('uuid',Auth::user()->id)->firstorFail();
        $subcategory->delete();
        return response()->json(['message' => 'success'], 201);
    }

    //Expense
    public function allExpense(){
        $expenses = Expense::where('uuid',Auth::user()->id)->with('category')->with('subcategory')->get();
        return response()->json(['message' => 'success','expenses'=>$expenses], 200);
    }

    public function createExpense(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'amount' => 'required|integer',
            'date'=>'required|date',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors', $validator->errors()],422);
        }

        $path = "";
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('expenses/invoice','upload');
        } 

        $expense = Expense::create([
            'uuid' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'amount' => $request->amount,
            'subcategoryID' => $request->subcategory,
            'invoiceurl' => $path,
        ]);

        return response()->json(['message' => 'success','expense' => $expense], 201);
    }


    public function UpdateExpense(Request $request,$id){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'amount' => 'required|integer',
            'date'=>'required|date',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }
        
        $expense = Expense::whereid($id)->where('uuid',Auth::user()->id)->first();
        $filename = $expense->invoiceurl;
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('expenses/invoice','upload');
        }

        $update = Expense::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'subcategoryID' => $request->subcategory,
            'date' =>  Carbon::parse($request->date)->format('Y-m-d'),
            'amount' => $request->amount,
            'invoiceurl' => $filename,
        ]);

        $update = Expense::whereid($id)->where('uuid',Auth::user()->id)->first();

        return response()->json(['message' => 'success','expense' => $update], 201);
    }

  
    public function deleteExpense($id){
        $expense = Expense::whereid($id)->where('uuid',Auth::user()->id)->firstorFail();
        $expense->delete();
        return response()->json(['message' => 'success'], 201);
    }

    public function allBudget(){
        $Budget = Budget::where('uuid',Auth::user()->id)->with('category')->with('subcategory')->get();
        return response()->json(['message' => 'success','budgets'=>$Budget], 200);
    }

    public function postBudget(Request $request){
        $validator = Validator::make( $request->all(),[
            'description' =>'required',
            'amount' => 'required|integer',
            'year' => 'required|digits:4',
            'month'=>'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        if (Budget::where([
            'uuid' =>  Auth::user()->id,
            'categoryID'=> $request->category,
            'subcategoryID'=> $request->subcategory,
            'year'=> $request->year,
            'month'=> $request->month])->exists()) {
            return response()->json(['errors' => 'Budget already exist']);
        }

       $budget = Budget::create([
            'uuid' => Auth::user()->id,
            'description' => $request->description,
            'categoryID' => $request->category,
            'month' => $request->month,
            'amount' => $request->amount,
            'subcategoryID' => $request->subcategory,
            'year' => $request->year,
        ]);

        return response()->json(['message' => 'success','budget' => $budget], 200);
    }


    public function putBudget(Request $request , $id){
        $validator = Validator::make( $request->all(),[
            'description' =>'required',
            'amount' => 'required|integer',
            'year' => 'required|digits:4',
            'month'=>'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $budget = Budget::whereid($id)->where('uuid', Auth::user()->id)
        ->update([
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        $budget = Budget::whereid($id)->where('uuid', Auth::user()->id)->first();
        return response()->json(['message' => 'success','budget' => $budget], 200);

    }

    public function deleteBudget(Request $request, $id){
        $budget = Budget::whereid($id)->where('uuid', Auth::user()->id)->firstorFail();
        $budget->delete();
        return response()->json(['message' => 'success'], 200);
    }

    public function allIncome(){
        $income = Income::where('uuid',Auth::user()->id)->with('category')->with('subcategory')->get();
        return response()->json(['message' => 'success','income' => $income], 200);
    }

    public function postIncome(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'amount' => 'required|integer',
            'date'=>'required|date',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $path = "";
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('expenses/income','upload');
        }
        $income = Income::create([
            'uuid' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'amount' => $request->amount,
            'subcategoryID' => $request->subcategory,
            'invoiceurl' => $path,
        ]);

        return response()->json(['message' => 'success','income' => $income], 200);

    }

      
    public function putIncome(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'amount' => 'required|integer',
            'date'=>'required|date',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $income = Income::whereid($id)->where('uuid',Auth::user()->id)->first();
        $filename = $income->invoiceurl;
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('expenses/income','upload');
        }

        $income = Income::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'subcategoryID' => $request->subcategory,
            'date' =>  Carbon::parse($request->singleDate)->format('Y-m-d'),
            'amount' => $request->amount,
            'invoiceurl' => $filename,
        ]);

        $income = Income::whereid($id)->where('uuid',Auth::user()->id)->first();
        return response()->json(['message' => 'success','income' => $income], 200);
    }

    public function deleteIncome($id){
        $income = Income::whereid($id)->where('uuid',Auth::user()->id)->firstorFail();
        $income->delete();
        return response()->json(['message' => 'success'], 200);
    }

    public function postReport(Request $request){
        $validator = Validator::make( $request->all(),[
            'type' => 'required|in:expense,income,expensevsincome',
            'startDate' =>'required|date|before:endDate',
            'endDate' =>'required|date',
            'category' => 'required',
            'subcategory' => 'required_unless:category,all|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $startDate = Carbon::parse($request->startDate)->format('Y-m-d');
        $endDate = Carbon::parse($request->endDate)->format('Y-m-d');

        $result = [];

        if($request->type == "expense" AND $request->category != 'all'){
            $result = Expense::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                    [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amount = (new ControllersExpenseController)->addExpense($result);
        }
        elseif($request->type == "expense" AND $request->category == 'all'){
            $result = Expense::where('uuid', Auth::user()->id)->whereBetween('date', 
                    [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amount = (new ControllersExpenseController)->addExpense($result);
        }

        elseif($request->type == "income" AND $request->category != 'all'){
             $result = Income::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                    [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amount = (new ControllersExpenseController)->addExpense($result);
        }

        elseif($request->type == "income" AND $request->category == 'all'){
            $result = Income::where('uuid',Auth::user()->id)->whereBetween('date', 
                   [$startDate, $endDate])->with('category')->with('subcategory')->get();
           $amount = (new ControllersExpenseController)->addExpense($result);
       }


        elseif($request->type == "expensevsincome" AND $request->category != 'all'){
            $expense = Expense::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                   [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountExpense = (new ControllersExpenseController)->addExpense($expense);
            $income = Income::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                   [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountIncome = (new ControllersExpenseController)->addExpense($income);

            return view('user.expense.report.mutiple',[
                'title' => 'Report',
                'type' => ucwords($request->type), 
                'expense' => $expense,
                'income' => $income,
                'amountExpense' => $amountExpense,
                'amountIncome' => $amountIncome,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
       }

       elseif($request->type == "expensevsincome" AND $request->category == 'all'){
            $expense = Expense::where('uuid',Auth::user()->id)->whereBetween('date', 
                [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountExpense = (new ControllersExpenseController)->addExpense($expense);
            $income = Income::where('uuid',Auth::user()->id)->whereBetween('date', 
                [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountIncome = (new ControllersExpenseController)->addExpense($income);


            return response()->json(['message' => 'success','report'=>[
                'expense' => $expense,
                'income' => $income,
                'amountExpense' => $amountExpense,
                'amountIncome' => $amountIncome,
                'startDate' => $startDate,
                'endDate' => $endDate,
                ]
            ], 200);
       }
       
       

        return response()->json(['message' => 'success','report'=>[
                'result' => $result,
                'amount' => $amount,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]
        ]);

    }
}
