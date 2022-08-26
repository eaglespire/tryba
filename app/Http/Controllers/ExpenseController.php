<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Budget;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    //
    public function dashboard()
    {
        $expenses = Expense::where('uuid',Auth::user()->id)->with('category')->get();
        $currentMonth = Expense::where('uuid',Auth::user()->id)->whereMonth('date', Carbon::now()->month)->get();
        $incomecurrentMonthArr = Income::where('uuid',Auth::user()->id)->whereMonth('date', Carbon::now()->month)->get();
        $week = Expense::where('uuid',Auth::user()->id)
        ->whereBetween('date', 
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $overall =  $this->addExpense($expenses);
        $month = $this->addExpense($currentMonth);
        $weekAmount = $this->addExpense($week);
        $incomecurrentMonth = $this->addExpense($incomecurrentMonthArr);
        $monthBudget = Budget::where([
                            'uuid' => Auth::user()->id,
                            'month' => Carbon::now()->format('F'),
                            'year' => Carbon::now()->year
                            ])->with('category')->get();

        $monthBudgetAmount = $this->addExpense($monthBudget);

        return view('user.expense.dashboard',[
            'title' => 'Expense & Budgeting',
            'overall' => $overall,
            'month' => $month,
            'currentMonth' => $currentMonth,
            'weekAmount' => $weekAmount,
            'monthBudget'  =>  $monthBudget,
            'monthBudgetAmount'  =>  $monthBudgetAmount,
            'incomecurrentMonth' => $incomecurrentMonth,
            'incomecurrentMonthArr' => $incomecurrentMonthArr
        ]);
    }

    public function addExpense($data){
        $overAmount = 0;

        foreach ($data as $item){
            $overAmount = $overAmount + $item->amount;
        }

        return $overAmount;
    }

    public function allExpense(){
        $expenses = Expense::where('uuid',Auth::user()->id)->with('category')->with('subcategory')->get();
        return view('user.expense.show',[
            'title' => 'Expense',
            'expenses' => $expenses
        ]);
    }
    
    public function show(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        return view('user.expense.create',[
            'title' => 'New Expense',
            'categories' => $categories
        ]);
    }

    public function showCategory(){
        return view('user.expense.category.create',[
            'title' => 'New Expense Category'
        ]);
    }

    public function showAllCategory(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        return view('user.expense.category.show',[
            'title' => 'Category',
            'items' =>$categories 
        ]);
    }

    public function postCategory(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
        ]);
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        ExpenseCategory::create([
            'uuid' => auth()->guard('user')->user()->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return redirect()->route('AllCategoryExpense')->with('toast_success', 'Expense Category Added!');
    }

    public function updateCategory($id){
        $category = ExpenseCategory::where([
            'id' => $id,
            'uuid' => Auth::user()->id
        ])->firstorFail();

        return view('user.expense.category.update',[
            'category' => $category,
            'title' => 'Update '. $category->Name
        ]);
    }

    public function updatePostCategory(Request $request,$id){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        ExpenseCategory::whereid($id)->where('uuid',auth()->guard('user')->user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('AllCategoryExpense')->with('toast_success', 'Expense Category Updated!');
    }

    public function deleteCategory($id){
        $category = ExpenseCategory::whereid($id)->where('uuid',auth()->guard('user')->user()->id)->firstorFail();
        $category->delete();
        return back()->with('toast_success', 'Deleted!');
    }

    public function createExpense(Request $request){
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
            $path = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        } 

        Expense::create([
            'uuid' => auth()->guard('user')->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'date' => Carbon::createFromFormat('m/d/Y', $request->singleDate)->format('Y-m-d'),
            'amount' => $request->amount,
            'subcategoryID' => $request->subcategory,
            'invoiceurl' => $path,
        ]);

        return redirect()->route('allExpense')->with('toast_success', 'Expense Created!');
    }

    public function showUpdateExpense($id){
        $expense = Expense::where([
            'id' => $id,
            'uuid' => Auth::user()->id
        ])->firstorFail();

        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        $subcategories = ExpenseSubcategory::whereuuid(Auth::user()->id)->where('categoryID',$expense->categoryID)->get();
        $expense->date = Carbon::createFromFormat('Y-m-d', $expense->date)->format('m/d/Y');
        return view('user.expense.update',[
            'expense' => $expense,
            'title' => 'Update '. $expense->name,
            'categories' => $categories,
            'subcategories'=> $subcategories
        ]);
    }

    public function UpdateExpense(Request $request,$id){
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
        
        $expense = Expense::whereid($id)->where('uuid',Auth::user()->id)->first();
        $filename = $expense->invoiceurl;
        if ($request->hasFile('file')) {
            $filename =  Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        }

        Expense::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'subcategoryID' => $request->subcategory,
            'date' =>  Carbon::createFromFormat('m/d/Y', $request->singleDate)->format('Y-m-d'),
            'amount' => $request->amount,
            'invoiceurl' => $filename,
        ]);

        return redirect()->route('allExpense')->with('toast_success', 'Expense Updated!');
    }

    public function showDeleteExpense($id){
        $expense = Expense::whereid($id)->where('uuid',auth()->guard('user')->user()->id)->firstorFail();
        $expense->delete();
        return back()->with('toast_success', 'Deleted!');
    }

    public function allBudget(){
        $expenses = Budget::where('uuid',Auth::user()->id)->with('category')->with('subcategory')->get();
        return view('user.expense.budget.show',[
            'title' => 'Budget',
            'expenses' => $expenses
        ]);

    }

    public function newBudget(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $years = range(Carbon::now()->year,Carbon::now()->year + 8);
        return view('user.expense.budget.create',[
            'title' => 'New Budget',
            'categories' => $categories,
            "months"  => $months,
            "years"  => $years,
        ]);
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
            return back()->with('errors', $validator->errors());
        }

        if (Budget::where([
            'uuid' => auth()->guard('user')->user()->id,
            'categoryID'=> $request->category,
            'subcategoryID'=> $request->subcategory,
            'year'=> $request->year,
            'month'=> $request->month])->exists()) {
            return back()->with('errors', 'Budget already exist');
        }

        Budget::create([
            'uuid' => auth()->guard('user')->user()->id,
            'description' => $request->description,
            'categoryID' => $request->category,
            'month' => $request->month,
            'amount' => $request->amount,
            'subcategoryID' => $request->subcategory,
            'year' => $request->year,
        ]);

        return redirect()->route('allBudget')->with('toast_success', 'Budget Created!');
    }

    public function updateBudget($id){

        $budget = Budget::where([
            'id' => $id,
            'uuid' => Auth::user()->id
        ])->firstorFail();

        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        $subcategories = ExpenseSubcategory::whereuuid(Auth::user()->id)->where('categoryID',$budget->categoryID)->get();
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $years = range(Carbon::now()->year,Carbon::now()->year + 8);

        return view('user.expense.budget.update',[
            'budget' => $budget,
            'title' => 'Update '. $budget->name,
            'categories' => $categories,
            "months"  => $months,
            "years"  => $years,
            'subcategories'=> $subcategories
        ]);

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
            return back()->with('errors', $validator->errors());
        }
      
        Budget::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return redirect()->route('allBudget')->with('toast_success', 'Budget Updated!');

    }

    public function deleteBudget(Request $request, $id){
        $budget = Budget::whereid($id)->where('uuid',auth()->guard('user')->user()->id)->firstorFail();
        $budget->delete();
        return back()->with('toast_success', 'Deleted!');
    }

    public function AllSubCategoryExpense($id){
        $subcategory = ExpenseSubcategory::whereuuid(Auth::user()->id)->where('categoryID',$id)->with('category')->get();
        return view('user.expense.category.subcategory.show',[
            'title' => 'Sub Category',
            'items' => $subcategory,
            'id' => $id
        ]);
    }

    public function AllSubCategoryExpenseApi(Request $request){
        $validator = Validator::make( $request->all(),[
            'id' =>'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
            return response()->json($validator->errors(),400);
        }

        $subcategory = ExpenseSubcategory::whereuuid(Auth::user()->id)->where('categoryID',$request->id)->with('category')->get();
        return response()->json($subcategory,200);
    }

    public function showCreateSubCategory(){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        return view('user.expense.category.subcategory.create',[
            'title' => 'Add Sub Category',
            'categories' => $categories
        ]);
    }

    public function postSubCategory(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'category' => 'required|exists:expense_categories,id'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        ExpenseSubcategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
            'uuid' => Auth::user()->id
        ]);

        return redirect()->route('AllCategoryExpense')->with('toast_success', 'Expense Sub Category Added!');
    }

    public function showUpdateSubCategory($id){
        $categories = ExpenseCategory::where('uuid',Auth::user()->id)->get();
        $subcategory = ExpenseSubcategory::where('uuid',Auth::user()->id)->whereid($id)->firstorFail();
        return view('user.expense.category.subcategory.update',[
            'title' => 'Update Sub Category',
            'categories' => $categories,
            'subcategory' => $subcategory,
        ]);
    }

    public function postUpdateSubCategory($id,Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'category' => 'required|exists:expense_categories,id'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        ExpenseSubcategory::whereid($id)->where('uuid',Auth::user()->id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'categoryID' => $request->category,
        ]);

        return redirect()->route('AllCategoryExpense')->with('toast_success', 'Expense Sub Category Updated!');
    }

    public function deleteSubCategory($id){
        $subcategory = ExpenseSubcategory::whereid($id)->where('uuid',auth()->guard('user')->user()->id)->firstorFail();
        $subcategory->delete();
        return back()->with('toast_success', 'Deleted!');
    }
}
