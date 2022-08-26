@extends('checkoutlayout')

@section('content')
<div class="main-content">
    <div class="header py-5 pt-7">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <div class="card-profile-image mb-5">
                        <img src="{{asset('asset/'.$logo->image_link)}}">
                        </div>
                    <span class="badge badge-pill badge-danger"><i class="fad fa-ban"></i> {{__('Test Mode')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5 mb-0">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-profile border-0 text-center">
                    <div class="card-header font-weight-bolder mt-3">
                        <h3>{{$link->title}}</h3>
                        <p>{{$link->description}}</p>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">                  
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text text-future">{{$merchant->cc->coin->symbol}}</span>
                                </div>
                                <input class="form-control" readonly type="number"  name="amount" value="{{number_format(($link->amount*$link->quantity), 2)}}">
                            </div>
                        </div>
                        <form action="{{route('pay.merchant', ['type'=>'test'])}}" method="post" id="payment-form"> 
                            @csrf      
                            <input type="hidden" name="amount" value="{{round(($link->amount*$link->quantity))}}">  
                            <input type="hidden" value="{{$link->reference}}" name="link">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <select class="form-control select" name="status" required>
                                    <option value="">{{__('Select Transaction Response')}}</option> 
                                    <option value="1">{{__('Successful')}}</option> 
                                    <option value="2">{{__('Failed')}}</option>      
                                    </select>
                                </div>
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox mt-3">
                                <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="terms" checked required>
                                <label class="custom-control-label" for=" customCheckLogin">
                                    <p class="text-muted">{{__('This transaction requires your consent before continuing. Read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                                </label>
                            </div> 
                            @if($errors->has('terms'))
                                <span class="text-xs text-uppercase mt-3">{{$errors->first('terms')}}</span>
                            @endif 
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block rounded-pill my-4" name="action" value="test"><i class="fal fa-external-link"></i> {{__('Pay')}}</button>
                            </div> 
                        </form>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <p class="text-default">{{__('Contact Merchant for any information on this payment')}}</p>
                    @if($merchant->support_email!=null)
                    <a class="text-primary" href="mailto:{{$merchant->support_email}}">{{$merchant->support_email}}</a>
                    @endif 
                    @if($merchant->support_phone!=null && $merchant->support_email!=null)<span class="text-primary">|</span>@endif
                    @if($merchant->support_phone!=null)
                    <a class="text-primary" href="tel:{{$merchant->support_phone}}">{{$merchant->support_phone}}</a>
                    @endif
                </div>
                @if($merchant->social_links==1)
                <div class="text-center">
                    @if($merchant->facebook!=null)
                    <a href="{{$merchant->facebook}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/facebook-3.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->twitter!=null)
                    <a href="{{$merchant->twitter}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/twitter.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->linkedin!=null)
                    <a href="{{$merchant->linkedin}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/linkedin.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->instagram!=null)
                    <a href="{{$merchant->instagram}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/instagram-2-1.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->youtube!=null)
                    <a href="{{$merchant->youtube}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/youtube-3.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->whatsapp!=null)
                    <a href="{{$merchant->whatsapp}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/whatsapp.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                </div>
                @endif 
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <a href="{{route('cancel.payment', ['id'=>$link->tx_ref])}}" class="@if($merchant->checkout_theme!=null)text-white @else text-danger @endif"><i class="fal fa-times"></i> {{__('Cancel Payment')}}</a>
        </div>
    </div>
@stop