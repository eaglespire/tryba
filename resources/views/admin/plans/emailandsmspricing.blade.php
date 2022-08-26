@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <form action="{{ route('admin.save.pricing') }}" method="post">
                            @csrf        
                            <h3 class="card-title">{{ __('Email Pricing')}}</h3>                               
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Quantity')}}:</label>
                                <div class="col-lg-10">
                                    <input type="number" name="quantityEmail" min="1" value="{{  (!empty($pricing)) ? $pricing->quantity_email : "" }}"  class="form-control" required>
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Amount')}}:</label>
                                <div class="col-lg-10">
                                    <input type="number" name="amountEmail" value="{{ (!empty($pricing)) ?  $pricing->amount_email : "" }}" min="0"  class="form-control" required>
                                </div>
                            </div>           

                            <h3 class="card-title mt-4">{{ __('SMS Pricing')}}</h3>                               
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Quantity')}}:</label>
                                <div class="col-lg-10">
                                    <input type="number" name="quantitySMS" min="1" value="{{ (!empty($pricing)) ?  $pricing->quantity_sms : "" }}"  class="form-control" required>
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Amount')}}:</label>
                                <div class="col-lg-10">
                                    <input type="number" value="{{ (!empty($pricing)) ?  $pricing->amount_sms : "" }}" name="amountSMS" min="0"  class="form-control" required>
                                </div>
                            </div>           
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection