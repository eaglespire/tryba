@extends('userlayout')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Expenses Manager')}}</h1>
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                    </li>
                    @if(route('expense.dashboard')==url()->current())
                        <li class="breadcrumb-item text-dark">{{__('Expenses Manager')}}</li> 
                    @elseif(route('allExpense')==url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Expense')}}</li>
                    @elseif(route('allBudget')==url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Budget')}}</li>
                    @elseif(route('allBudget')==url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Income')}}</li>
                    @elseif(route('allIncome')==url()->current() OR route('allIncome')==url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Income')}}</li>
                    @elseif(route('showreport') == url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Report')}}</li>
                    @endif
               
                </ul> 
            </div>
            <div class="d-flex py-2">
                @if(route('allExpense')==url()->current())
                    <a href="{{ route('show.expense') }}" class="btn btn-dark btn-active-light me-4">{{__('Add Expense')}}</a>
                @elseif(route('allBudget')==url()->current())
                    <a href="{{ route('newBudget') }}" class="btn btn-dark btn-active-light me-4">{{__('Add Budget')}}</a>
                @elseif(route('allIncome')==url()->current())
                    <a href="{{ route('showAddIncome') }}" class="btn btn-dark btn-active-light me-4">{{__('Add Income')}}</a>
                @elseif(route('AllCategoryExpense')==url()->current() )
                    <a href="{{ route('show.CategoryExpense') }}" class="btn btn-dark btn-active-light me-4">{{__('Add Category')}}</a>
                    <a href="{{ route('showCreateSubCategory') }}" class="btn btn-dark btn-active-light me-4">{{__('Add Sub category')}}</a>
                @elseif(route('showreport')==url()->current())
                    <a href="{{ route('showreport') }}" class="btn btn-dark btn-active-light me-4">{{__('Generate Report')}}</a>
                @endif

            </div>
         
        </div>
    </div>

    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container">
            <div class="d-flex overflow-auto mb-10">
                <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('expense.dashboard')==url()->current()) active @endif" href="{{route('expense.dashboard')}}">{{__('Dashboard')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('allIncome')==url()->current()) active @endif" href="{{route('allIncome')}}">{{__('Income')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('allExpense')==url()->current()) active @endif" href="{{route('allExpense')}}">{{__('Expenses')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('allBudget')==url()->current()) active @endif" href="{{ route('allBudget') }}">{{__('Budget')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('showreport')==url()->current()) active @endif" href="{{ route('showreport') }}">{{__('Report')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('AllCategoryExpense')==url()->current()) active @endif" href="{{ route('AllCategoryExpense') }}">{{__('Category')}}</a>
                    </li>
                </ul>
            </div>
            @yield('mainpage')
        </div>
   
    </div>


    
@endsection