@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">{{$title}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.country.crypto.update')}}" method="post">
                    @csrf   
                    <input type="hidden" name="id" value="{{$crypto->id}}">
                    <div class="form-group row">
                        <div class="col-lg-12"> 
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($crypto->crypto_buy==1)
                                    <input type="checkbox" name="crypto_buy" id="customCheckLogin" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="crypto_buy" id="customCheckLogin"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin">
                                <span class="text-muted">{{__('Crypto Buy Status')}}</span>     
                                </label>
                            </div> 
                        </div> 
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12"> 
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                @if($crypto->crypto_sell==1)
                                    <input type="checkbox" name="crypto_sell" id="customCheckLogin1" class="custom-control-input" value="1" checked>
                                @else
                                    <input type="checkbox" name="crypto_sell" id="customCheckLogin1"  class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="customCheckLogin1">
                                <span class="text-muted">{{__('Crypto Sell Status')}}</span>     
                                </label>
                            </div> 
                        </div> 
                    </div>          
                    <div class="text-right">
                        <button type="submit" class="btn btn-neutral btn-block">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
@stop