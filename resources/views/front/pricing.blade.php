@extends('layout')
@section('css')

@stop
@section('content')
<section class="mt-n11 pt-12 pb-8 pt-md-14 pb-md-11 bg-black bg-pattern-2">
    <div class="shape shape-blur-3 text-white">
        <svg viewBox="0 0 1738 487" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h1420.92s713.43 457.505 0 485.868C707.502 514.231 0 0 0 0z" fill="url(#paint0_linear)"></path><defs><linearGradient id="paint0_linear" x1="0" y1="0" x2="1049.98" y2="912.68" gradientUnits="userSpaceOnUse"><stop stop-color="currentColor" stop-opacity=".075"></stop><stop offset="1" stop-color="currentColor" stop-opacity="0"></stop></linearGradient></defs></svg>      
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
            <h1 class="display-2 text-white">{{__('Find your plan')}}</h1>
            <p class="lead text-white-80 mb-6 mb-md-8">{{$set->site_name}} {{__('is a free service and we intend to keep it that way, however to access more advanced features, you can choose from one of the paid plans.')}}</p>
            <form class="d-flex align-items-center justify-content-center mb-7 mb-md-9">
                <span class="text-white-80">
                {{__('Annual')}}
                </span>
                <!-- Switch -->
                <div class="form-check form-check-dark form-switch mx-3">
                <input class="form-check-input" type="checkbox" id="billingSwitch" data-toggle="price" data-target=".price">
                </div>
                <!-- Label -->
                <span class="text-white-80">
                {{__('Monthly')}}
                </span>
            </form>
            <div class="form-group">
                <label class="form-label">{{__('Country')}}</label>
                    <select class="form-select" id="xcountry" required>
                        @foreach($sxf as $val)
                        <option value="{{$val->id}}">{{$val->real['nicename']}}</option>
                        @endforeach
                    </select>
                </div>
                @php 
                $ccx=array();
                foreach($sxf as $vals){
                    $ccx[]=$vals->id;
                }
                @endphp
                <input type="hidden" name="list" id="list" value="{{json_encode($ccx, true)}}">
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
@foreach($sxf as $xal)
    @php
    $price=App\Models\Sub::wherecountry_id($xal->id)->get();
    $xcurrency=App\Models\Currency::whereid($xal->coin_id)->first();
    @endphp
    <div id="divCountry">
        <section class="mt-n8 mb-8" id="dcountry{{$xal->id}}">
            <div class="container">
                <div class="row gx-4">
                    @foreach($price as $val)
                    <div class="col-12 col-md-6 mb-5">
                        <div class="card shadow-lg mb-6 mb-md-0">
                            <div class="card-body">
                            <div class="text-center mb-3">
                                <span class="badge rounded-pill bg-primary-soft">
                                <span class="h6 text-uppercase">{{$val->name}}</span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center">
                                <span class="h2 mb-0 mt-2">{{$xcurrency->symbol}}</span>
                                <span class="price display-2 mb-0" data-annual="{{$val->annual_amount}}" data-monthly="{{$val->amount}}">{{$val->annual_amount}}</span>
                                <span class="h2 align-self-end mb-1">/{{__('mo')}}</span>
                            </div>
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{$xcurrency->symbol.number_format($val->payment)}} {{__('Monthly payment limit')}}</p>
                            </div>                        
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{$val->transactions}} {{__('Monthly transactions')}}</p>
                            </div>                        
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Unlimited monthly payment requests')}}</p>
                            </div>
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Unlimited product links')}}</p>
                            </div>
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Storefront & Marketplace')}}</p>
                            </div>
                            @if($val->amount!=0)
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('UK/Europe bank account')}} (coming soon) <small>*{{__('eligibility applies.')}}</small> </p>
                            </div>
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Cards')}} (coming soon) <small>*{{__('eligibility applies.')}}</small> </p>
                            </div>
                            @endif
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Instant settlement')}}</p>
                            </div>  
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Direct payment')}}</p>
                            </div>                        
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('Instant notifications')}}</p>
                            </div>                  
                            <div class="d-flex">
                                <div class="badge badge-rounded-circle bg-success-soft mt-1 me-4"><i class="fe fe-check"></i></div>
                                <p>{{__('24/7 customer support')}}</p>
                            </div>
                            <a href="{{route('register')}}" class="btn w-100 btn-primary">
                                {{__('Get Started')}} <i class="fe fe-arrow-right ms-3"></i>
                            </a>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> <!-- / .row -->
            </div> <!-- / .container -->
        </section>
    </div>
@endforeach
@stop