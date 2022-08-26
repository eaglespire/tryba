@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">{{$title}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.country.features.update')}}" method="post">
                    @csrf   
                    <input type="hidden" name="id" value="{{$features->id}}">
                    <div class="form-group row">
                        <div class="col-lg-12">                                     
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->subscription==1)
                                    <input type="checkbox" name="subscription" id="customCheckLogin13" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="subscription"id="customCheckLogin13"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin13">
                                <span class="text-muted">{{__('Subscription')}}</span>     
                                </label>
                            </div> 
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->store==1)
                                    <input type="checkbox" name="store" id="customCheckLogin10z" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="store" id="customCheckLogin10z"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin10z">
                                <span class="text-muted">{{__('Store')}}</span>     
                                </label>
                            </div>                                        
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->donation==1)
                                    <input type="checkbox" name="donation" id="customCheckLogin11" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="donation" id="customCheckLogin11"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin11">
                                <span class="text-muted">{{__('Gig pot')}}</span>     
                                </label>
                            </div>                                        
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->invoice==1)
                                    <input type="checkbox" name="invoice" id="customCheckLogin10" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="invoice" id="customCheckLogin10"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin10">
                                <span class="text-muted">{{__('Invoice')}}</span>     
                                </label>
                            </div>                                                                                                                                                                                                                                   
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->merchant==1)
                                    <input type="checkbox" name="merchant" id="customCheckLogin7" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="merchant" id="customCheckLogin7"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin7">
                                <span class="text-muted">{{__('Merchant')}}</span>     
                                </label>
                            </div>                                                                 
                            <p class="mt-5">Method of Receiving Payment</p>     
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->coinbase==1)
                                    <input type="checkbox" name="coinbase" id="customCheckLoginwx7" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="coinbase" id="customCheckLoginwx7"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLoginwx7">
                                <span class="text-muted">{{__('Coinbase')}}</span>     
                                </label>
                            </div>                                        
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->bank_pay==1)
                                    <input type="checkbox" name="bank_pay" id="customCheckLoginx8" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="bank_pay" id="customCheckLoginx8"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLoginx8">
                                <span class="text-muted">{{__('Bank Transfer')}}</span>     
                                </label>
                            </div>                                        
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->stripe==1)
                                    <input type="checkbox" name="stripe" id="customCheckLoginsx9" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="stripe" id="customCheckLoginsx9"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLoginsx9">
                                <span class="text-muted">{{__('Stripe')}}</span>     
                                </label>
                            </div>                            
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->paypal==1)
                                    <input type="checkbox" name="paypal" id="customCheckLoginvx9" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="paypal" id="customCheckLoginvx9"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLoginvx9">
                                    <span class="text-muted">{{__('Paypal')}}</span>     
                                </label>
                            </div>                            
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($features->sub_bank==1)
                                    <input type="checkbox" name="sub_bank" id="customCheckLoginvcx9" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="sub_bank" id="customCheckLoginvcx9"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLoginvcx9">
                                    <span class="text-muted">{{__('Access to subscription via bank payment')}}</span>     
                                </label>
                            </div>                                                              
                        </div>                                    
                    </div>   
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Yapily Auth Key')}}</label>
                        <div class="col-lg-10">
                            <input type="text" name="auth_key" class="form-control" value="{{$features->auth_key}}" required>
                        </div>
                    </div>                     
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Yapily Auth Secret')}}</label>
                        <div class="col-lg-10">
                            <input type="text" name="auth_secret" class="form-control" value="{{$features->auth_secret}}" required>
                        </div>
                    </div> 
                    {{-- <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Rails Bank API key')}}</label>
                        <div class="col-lg-10">
                            <input type="text" name="rail_apikey" class="form-control" value="{{$features->rail_apikey}}" required>
                        </div>
                    </div>                     
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Rails API Base URL')}}</label>
                        <div class="col-lg-10">
                            <input type="text" name="rail_baseurl" class="form-control" value="{{$features->rail_baseurl}}" required>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Bank format')}}</label>
                        <div class="col-lg-10">
                            <select class="form-control select" name="bank_format" required>
                                <option value='uk'@if($features->bank_format=='uk') selected @endif>UK Format</option>
                                <option value='eur'@if($features->bank_format=='eur') selected @endif>EUR Format</option>
                            </select>
                        </div>
                    </div>           
                    <div class="text-right">
                        <button type="submit" class="btn btn-neutral btn-block">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
@stop