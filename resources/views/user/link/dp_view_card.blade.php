@extends('checkoutlayout')
@section('content')
<div class="main-content">
    <div class="header py-5 pt-5">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt--8 pb-5 mb-0">
        @if($errors->has('amount'))
        <div class="alert alert-warning alert-dismissible fale show" role="alert">
            {{$errors->first('amount')}}
        </div>
        @endif
        @if($errors->has('status'))
        <div class="alert alert-warning alert-dismissible fale show" role="alert">
            {{$errors->first('status')}}
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card @if($merchant->checkout_theme==null) bg-transparent @endif border-0">
                    <div class="card-header mb-0">
                        <h1 class="text-dark">{{$link->name}}</h1>
                    </div>
                    <div class="card-body">
                        @if($link->image!=null)
                        <img src="{{ $link->image }}" style="max-width:100%;height:auto;" class="mb-3 rounded" alt="{{$link->name}}">
                        @endif
                        <p class="text-primary mb-1 font-weight-bold"><i class="fal fa-user"></i> {{$merchant->first_name.' '.$merchant->last_name}} {{__('is organising this Gig')}}</p>
                        @if(strlen($link->description)>1000)
                        <span>{!!substr($link->description,0,1000)!!}<span id="dots">...</span></span><span id="more" style="display:none;">{!!substr($link->description,1000,strlen($link->description))!!}</span>
                        <a onclick="readmore()" id="read" href="javascript:void;">{{__('Read more')}}</a>
                        @else
                        <p>{!!$link->description!!}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center mb-0">
                            <div class="col-12">
                                <h3 class="form-text text-xl text-dark font-weight-bolder">{{$link->bb->symbol.$link->amount}} {{__('GOAL')}} </h3>
                            </div>
                        </div>
                        <div class="row justify-content-between align-items-center mb-3">
                            <div class="col">
                                <div class="progress progress-xs mb-0">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($donated > 1) ? $donated/$link->amount *100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between align-items-center mb-3">
                            <div class="col-12">
                                <p class="text-sm text-dark">{{$link->bb->symbol.$donated}} {{__('Received')}}</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <a data-toggle="modal" data-target="#donors" href="#" name="action" value="test" class="btn btn-primary btn-block my-4">{{__('Contributors')}}</a>
                            <div class="modal fade" id="donors" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="mb-0 font-weight-bolder">{{__('Gigpot Contributors')}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group list-group-flush list my--3">
                                                @if(count($paid)>0)
                                                @foreach($paid as $k=>$val)
                                                <li class="list-group-item px-0">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape text-white rounded-circle bg-primary">
                                                                <i class="fal fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col text-left">
                                                            <h3 class="mb-0">
                                                                @if($val->anonymous==0)
                                                                @if($val->user_id==null)
                                                                @php
                                                                $fff=App\Models\Transactions::whereref_id($val->ref_id)->first();
                                                                @endphp
                                                                {{$fff['first_name'].' '.$fff['last_name']}}
                                                                @else
                                                                {{$val->user['first_name'].' '.$val->user['last_name']}}
                                                                @endif
                                                                @else
                                                                Anonymous
                                                                @endif
                                                                </h4>
                                                                <p>$link->bb->symbol.number_format($val->amount, 2)}} @ {{$val->created_at->diffForHumans()}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @else
                                                <div class="col-md-12 mb-5">
                                                    <div class="text-center mt-8">
                                                        <div class="mb-3">
                                                            <i class="fal fa-user text-gray fa-3x"></i>
                                                        </div>
                                                        <h3 class="text-dark">{{__('No Contributors Found')}}</h3>
                                                        <p class="text-dark text-sm card-text">{{__('There is no Contributor to this pot')}}</p>
                                                    </div>
                                                </div>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($donated<$link->amount)
                            <form action="{{route('send.donation')}}" method="post" id="payment-form">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">{{$link->bb->symbol}}</span>
                                            </span>
                                            <input type="number" min="1" class="form-control" name="amount" placeholder="0.00" id="transaction_charge" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <select class="form-control select" name="status">
                                            <option value="">{{__('Contribute as')}}</option>
                                            <option value="1">{{__('Anonymous')}}</option>
                                            <option value="0">{{__('Display Information')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" value="{{$link->ref_id}}" name="link">
                                <div class="form-group row">
                                    <div class="col-xs-12 col-md-12 form-group required">
                                        <input type="email" class="form-control" name="email" placeholder="{{__('Email Address')}}" autocomplete="off" required />
                                    </div>
                                    <div class="col-xs-12 col-md-6 form-group required">
                                        <input type="text" class="form-control" name="first_name" placeholder="{{__('First Name')}}" required />
                                    </div>
                                    <div class="col-xs-12 col-md-6 form-group required">
                                        <input type="text" class="form-control" name="last_name" placeholder="{{__('Last Name')}}" required />
                                    </div>
                                </div>
                                <input type="hidden" value="bank" name="type">
                                <div class="custom-control custom-control-alternative custom-checkbox mb-6 text-left">
                                    <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="terms" required>
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <p class="text-muted">{{__('This transaction requires your consent. Please read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                                    </label>
                                </div>
                                @if($errors->has('terms'))
                                <span class="text-xs text-uppercase mt-3">{{$errors->first('terms')}}</span>
                                @endif
                                <div class="text-left">
                                    <h3 class="form-text text-xl text-dark font-weight-bolder">{{__('Payment method')}} </h3>
                                    @if(!empty($merchant->gBPAccount()->accountNumber) AND !empty($merchant->gBPAccount()->sortCode))
                                        <div class="bg-gray rounded mb-3">
                                            <div class="custom-control custom-control-alternative custom-radio">
                                                <input class="custom-control-input" id="customCheckgLogin" type="radio" name="action" value="bank" required>
                                                <label class="custom-control-label" for="customCheckgLogin">
                                                    {{__('Pay with Open Banking')}}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($merchant->paypal) && !empty($merchant->paypal_client_id) && !empty($merchant->paypal_secret_key))
                                        <div class="bg-gray rounded mb-3">
                                            <div class="custom-control custom-control-alternative custom-radio">
                                                <input class="custom-control-input" id="customCheckxLogin" type="radio" name="action" value="paypal" required>
                                                <label class="custom-control-label" for="customCheckxLogin">
                                                    {{__('Pay with Paypal')}}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    @if($merchant->cc->coinbase == 1 && $merchant->coinbase == 1 && false)
                                        <div class="bg-gray rounded mb-3">
                                            <div class="custom-control custom-control-alternative custom-radio">
                                                <input class="custom-control-input" id="customCheckdLogin" type="radio" name="action" value="coinbase" required>
                                                <label class="custom-control-label" for="customCheckdLogin">
                                                    {{__('Pay with Coinbase')}}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center mt-6">
                                    <button type="submit" class="btn btn-primary btn-block">{{__('Pay')}}</button>
                                </div>
                            </form>
                            @endif
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
                <div class="row justify-content-center mt-5">
                    <a href="{{route('login')}}" class="@if($merchant->checkout_theme!=null)text-white @else text-danger @endif"><i class="fal fa-times"></i> Cancel Payment</a>
                </div>
            </div>
        </div>
    </div>
    @php
    Session::put('return_url', url()->current());
    @endphp
    @stop
    @section('script')
    <script>
        $(document).ready(function() {
            $("img").css('height', 'auto').css('max-width', '100%').css('border-radius', '0.375rem');
        });

        function readmore() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("read");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "Read more";
                moreText.style.display = "none";
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "Read less";
                moreText.style.display = "inline";
            }
        }
    </script>
    @endsection