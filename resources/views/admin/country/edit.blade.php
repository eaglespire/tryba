@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Edit')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-danger"></p>
                        <form action="{{route('admin.plan.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$plan->id}}">
                            <input type="hidden" name="country_id" value="{{$features->id}}" required>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Monthly No of Transactions')}}</label>
                                <div class="col-lg-10">
                                    <input type="text" name="transactions" class="form-control" value="{{$plan->transactions}}" required>
                                </div>
                            </div>    
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Monthly Payment limit')}}</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="number" step="any" name="payment" value="{{$plan->payment}}" class="form-control">
                                        <span class="input-group-append">
                                            <span class="input-group-text">{{$features->coin->symbol}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Name')}}</label>
                                <div class="col-lg-10">
                                    <input type="text" name="name" class="form-control" value="{{$plan->name}}" required>
                                </div>
                            </div>                    
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Monthly Amount')}}</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="number" step="any" name="amount" value="{{$plan->amount}}" class="form-control" required>
                                        <span class="input-group-append">
                                            <span class="input-group-text">{{$features->coin->symbol}}</span>
                                        </span>
                                    </div>
                                    <span class="text-xs form-text">Leave as 0 for free</span>
                                </div>
                            </div>                             
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Annual amount (Input Monthly)')}}</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="number" step="any" name="annual_amount" value="{{$plan->annual_amount}}" class="form-control" required>
                                        <span class="input-group-append">
                                            <span class="input-group-text">{{$features->coin->symbol}}</span>
                                        </span>
                                    </div>
                                    <span class="text-xs form-text">Leave as 0 for free</span>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Email limit per month')}}</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="number" name="email_limit" value="{{$plan->email_limit}}" class="form-control" required>
                                    </div>
                                </div>
                            </div>    
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('SMS limit per month')}}</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="number" name="sms_limit" value="{{$plan->sms_limit}}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Affect active subscribers')}}</label>
                                <div class="col-lg-10">
                                    <select class="form-control select" name="affect_active_subscribers" required> 
                                        <option value="0" @if($plan->affect_active_subscribers==0) selected @endif>No</option>                
                                        <option value="1" @if($plan->affect_active_subscribers==1) selected @endif>Yes</option>                
                                    </select>
                                    <p>This will be reset to No after this</p>
                                </div>
                            </div>           
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-sm">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

@stop