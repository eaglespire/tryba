<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    public function allIncome(){
        $income = Income::where('uuid',Auth::user()->id)->with('category')->with('subcategory')->get();
        return view('user.expense.income.show',[
            'title' => 'Income',
            'expenses' => $income
        ]);
    }

    public function showAddIncome(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        return view('user.expense.income.create',[
            'title' => 'New Income',
            'categories' => $categories
        ]);
    }


    public function postIncome(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'amount' => 'required|integer',
            'singleDate'=>'required|date',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $path = "";
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('expenses/income','upload');
        }
        Income::create([
            'uuid' => auth()->guard('user')->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'date' => Carbon::createFromFormat('m/d/Y', $request->singleDate)->format('Y-m-d'),
            'amount' => $request->amount,
            'subcategoryID' => $request->subcategory,
            'invoiceurl' => $path,
        ]);

        return redirect()->route('allIncome')->with('toast_success', 'Income Created!');

    }
     
    public function putIncome(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'amount' => 'required|integer',
            'singleDate'=>'required|date',
            'file' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'category' => 'required|exists:expense_categories,id',
            'subcategory' => 'required|exists:expense_subcategories,id'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $income = Income::whereid($id)->where('uuid',Auth::user()->id)->first();
        $filename = $income->invoiceurl;
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('expenses/income','upload');
        }

        Income::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'subcategoryID' => $request->subcategory,
            'date' =>  Carbon::createFromFormat('m/d/Y', $request->singleDate)->format('Y-m-d'),
            'amount' => $request->amount,
            'invoiceurl' => $filename,
        ]);

        return redirect()->route('allIncome')->with('toast_success', 'Income Updated!');
    }

    public function showputIncome($id){
        $income = Income::where([
            'id' => $id,
            'uuid' => Auth::user()->id
        ])->firstorFail();

        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        $subcategories = ExpenseSubcategory::whereuuid(Auth::user()->id)->where('categoryID',$income->categoryID)->get();
        $income->date = Carbon::createFromFormat('Y-m-d', $income->date)->format('m/d/Y');
        return view('user.expense.income.update',[
            'income' => $income,
            'title' => 'Update '. $income->name,
            'categories' => $categories,
            'subcategories'=> $subcategories
        ]);

    } 

    public function deleteIncome($id){
        $income = Income::whereid($id)->where('uuid',auth()->guard('user')->user()->id)->firstorFail();
        $income->delete();
        return back()->with('toast_success', 'Deleted!');
    }

    public function showreport(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        return view('user.expense.report.create',[
            'title' => 'Report',
            'categories' => $categories
        ]);
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
            return back()->with('errors', $validator->errors());
        }

        $startDate = Carbon::createFromFormat('m/d/Y', $request->startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('m/d/Y', $request->endDate)->format('Y-m-d');

        $result = [];

        if($request->type == "expense" AND $request->category != 'all'){
            $result = Expense::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                    [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amount = (new ExpenseController)->addExpense($result);
        }
        elseif($request->type == "expense" AND $request->category == 'all'){
            $result = Expense::where('uuid',Auth::user()->id)->whereBetween('date', 
                    [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amount = (new ExpenseController)->addExpense($result);
        }

        elseif($request->type == "income" AND $request->category != 'all'){
             $result = Income::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                    [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amount = (new ExpenseController)->addExpense($result);
        }

        elseif($request->type == "income" AND $request->category == 'all'){
            $result = Income::where('uuid',Auth::user()->id)->whereBetween('date', 
                   [$startDate, $endDate])->with('category')->with('subcategory')->get();
           $amount = (new ExpenseController)->addExpense($result);
       }


        elseif($request->type == "expensevsincome" AND $request->category != 'all'){
            $expense = Expense::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                   [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountExpense = (new ExpenseController)->addExpense($expense);
            $income = Income::where('uuid',Auth::user()->id)->where('categoryID',$request->category)->where('subcategoryID',$request->subcategory)
            ->whereBetween('date', 
                   [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountIncome = (new ExpenseController)->addExpense($income);

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
            $amountExpense = (new ExpenseController)->addExpense($expense);
            $income = Income::where('uuid',Auth::user()->id)->whereBetween('date', 
                [$startDate, $endDate])->with('category')->with('subcategory')->get();
            $amountIncome = (new ExpenseController)->addExpense($income);

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
       
       

        return view('user.expense.report.show',[
            'title' => 'Report',
            'type' => ucwords($request->type), 
            'result' => $result,
            'amount' => $amount,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

    }
}
