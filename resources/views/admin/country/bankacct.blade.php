@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Update Bank Details')}}</h3>
                        <p class="card-text text-sm">{{__('Last updated')}}: {{date("Y/m/d h:i:A", strtotime($bank->updated_at))}}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{url('admin/bankdetails')}}" method="post">
                        @csrf
                            <input type="hidden" name="id" value="{{$bank->id}}">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Account number')}}</label>
                                <div class="col-lg-10">
                                <input type="number" name="acct_no" class="form-control" value="{{$bank->acct_no}}">
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Sort_code')}}</label>
                                <div class="col-lg-10">
                                <input type="number" name="routing_number" class="form-control" value="{{$bank->routing_number}}">
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