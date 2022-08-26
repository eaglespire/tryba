@extends('paymentlayout')

@section('content')
<div class="main-content">
    <div class="header py-5 pt-7">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-md-7 px-5">
                        <div class="card-profile-image mb-5">
                            <img src="{{asset('asset/'.$logo->image_link)}}">
                        </div>
                        <h5 class="h2 font-weight-bolder mb-3">{{__('Select your plan')}}</h5>
                        <p class="fs-7 text-dark">{{$set->site_name}} {{__('will continue to operate a free service, however, if your business require higher processing limits and/or more advanced features, you can choose one of our paid plans.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container mt--8 pb-5">
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active ml-2" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Annual')}}</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 ml-2" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="true">{{__('Monthly')}}</a>
                    </li>
                </ul>
            </div>
        </div>
      </div>          
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
          <div class="row">
            @if(count($plan)>0)
              @foreach($plan as $val)
                <div class="col-lg-4">
                  <div class="pricing card-group flex-column flex-md-row mb-3">
                    <div class="card card-pricing border-0 text-left mb-2">
                      <div class="card-header text-center">
                        <h1 class="card-title mb-1 text-hero">{{$val->name}}</h1>
                        <h3 class="card-title mb-2 text-hero">{{$currency->symbol.$val->annual_amount}}/{{__('mo')}}</h3>
                      </div>
                      <div class="card-body">              
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{$currency->symbol.number_format($val->payment)}} {{__('Monthly payment limit')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{$val->transactions}} {{__('Monthly transactions')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Unlimited Monthly payment requests')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Instant payments')}}</p>             
                        @if($val->amount!=0)
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('UK/Europe bank account (coming soon) *eligibility applies.')}} </p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Cards (coming soon) *eligibility applies.')}} </p>    
                        @endif                                   
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Direct settlement')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Instant notifications')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('24/7 customer support')}}</p>                                                
                        <br>
                        <div class="row align-items-center">
                          <div class="modal fade" id="buy{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                              <div class="modal-content">
                                <div class="modal-body p-0">
                                  <div class="card border-0 mb-0">
                                    <div class="card-header">
                                      <h1 class="h2 text-uppercase py-1 mb-0 text-hero text-center" id="profit{{$val->id}}">{{$val->name}}</h1>
                                    </div>
                                    <div class="card-body">
                                    <form role="form" action="{{route('user.check_plan')}}" method="post">
                                      @csrf 
                                        <input type="hidden" name="plan" value="{{$val->id}}*annual">
                                        <input name="amount" value="{{number_format($val->amount*12)}}" type="hidden"> 
                                        <div class="form-group row">
                                          <div class="col-lg-12">
                                            <select class="form-control select" name="type" required>
                                                <option value="">{{__('Select Payment Method')}}</option>
                                                @if($user->cc->sub_bank!=null  || $user->cc->sub_bank==1)<option value="1">{{__('Open banking')}}</option>@endif
                                                <option value="2">{{__('Credit/Debit Card')}}</option>
                                            </select>
                                          </div>
                                        </div>    
                                        <div class="custom-control custom-control-alternative custom-checkbox mb-5">
                                          <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="terms" checked required>
                                          <label class="custom-control-label" for=" customCheckLogin">
                                            <p class="text-muted">{{__('This transaction requires your consent before continuing. Read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                                          </label>
                                        </div>                                   
                                        <div class="text-center">
                                          <button type="submit" class="btn btn-primary btn-block my-4">{{__('Pay')}} {{$currency->symbol.number_format($val->amount*12{{--+($val->amount*12*20/100)--}}, '2')}}</button>
                                        </div>
                                        {{--<span class="form-text text-xs text-center">VAT: {{$currency->symbol.number_format($val->amount*12*20/100, '2')}} (+20%)</span>--}}
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                      <a href="#" data-toggle="modal" data-target="#buy{{$val->id}}" class="btn btn-block btn-neutral @if(($user->plan_id==$val->id && $user->plan_type=='annually') || ($user->plan->amount==0 && $user->plan_id==$val->id))disabled @endif">{{__('Get Started')}}</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="col-md-12 mb-5">
                <div class="text-center mt-8">
                  <div class="btn-wrapper text-center">
                      <a href="javascript:void;" class="btn btn-soft-warning btn-icon mb-3">
                          <span class="btn-inner--icon"><i class="fal fa-sad-tear fa-4x"></i></span>
                      </a>
                  </div>
                  <h3 class="text-dark">{{__('No Plans')}}</h3>
                  <p class="text-dark text-sm card-text">{{__('We couldn\'t find any Plans')}}</p>
                </div>
              </div>
            @endif
          </div>
        </div>        
        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
          <div class="row">
            @if(count($plan)>0)
              @foreach($plan as $val)
                <div class="col-lg-4">
                  <div class="pricing card-group flex-column flex-md-row mb-3">
                    <div class="card card-pricing border-0 text-left mb-2">
                      <div class="card-header text-center">
                        <h1 class="card-title mb-1 text-hero">{{$val->name}}</h1>
                        <h1 class="card-title mb-2 text-hero">{{$currency->symbol.$val->amount}}/{{__('mo')}}</h1>
                        <a href="#" data-toggle="modal" data-target="#xbuy{{$val->id}}" class="btn btn-block btn-primary @if(($user->plan_id==$val->id && $user->plan_type=='monthly') || ($user->plan->amount==0 && $user->plan_id==$val->id))disabled @endif">{{__('Get Started')}}</a>
                      </div>
                      <div class="card-body">              
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{$currency->symbol.number_format($val->payment)}} {{__('Monthly payment limit')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{$val->transactions}} {{__('Monthly transactions')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Unlimited Monthly payment requests')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Instant payments')}}</p>     
                        @if($val->amount!=0)
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('UK/Europe bank account (coming soon) *eligibility applies.')}} </p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Cards (coming soon) *eligibility applies.')}} </p>    
                        @endif                                               
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Direct settlement')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('Instant notifications')}}</p>                                                
                        <p class="text-sm text-dark mb-0"><i class="fal fa-check-circle text-success mt-1 mr-2"></i>{{__('24/7 customer support')}}</p>                                                
                        <br>
                        <div class="row align-items-center">
                          <div class="modal fade" id="xbuy{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                              <div class="modal-content">
                                <div class="modal-body p-0">
                                  <div class="card border-0 mb-0">
                                    <div class="card-header">
                                      <h1 class="h2 text-uppercase py-1 mb-0 text-hero text-center" id="profit{{$val->id}}">{{$val->name}}</h1>
                                    </div>
                                    <div class="card-body">
                                      <form role="form" action="{{route('user.check_plan')}}" method="post">
                                      @csrf 
                                        <input type="hidden" name="plan" value="{{$val->id}}*monthly">
                                        <input name="amount" value="{{number_format($val->amount,'2')}}" type="hidden"> 
                                        <div class="form-group row">
                                          <div class="col-lg-12">
                                            <select class="form-control select" name="type" required>
                                                <option value="">{{__('Select Payment Method')}}</option>
                                                @if($user->cc->sub_bank!=null  || $user->cc->sub_bank==1)<option value="1">{{__('Open banking')}}</option>@endif
                                                <option value="2">{{__('Credit/Debit Card')}}</option>
                                            </select>
                                          </div>
                                        </div>    
                                        <div class="custom-control custom-control-alternative custom-checkbox mb-5">
                                          <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="terms" checked required>
                                          <label class="custom-control-label" for=" customCheckLogin">
                                            <p class="text-muted">{{__('This transaction requires your consent before continuing. Read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                                          </label>
                                        </div>                                   
                                        <div class="text-center">
                                          <button type="submit" class="btn btn-primary btn-block my-4">{{__('Pay')}} {{$currency->symbol.number_format($val->amount{{--+($val->amount*20/100)--}}, '2')}}</button>
                                        </div>
                                        {{--<span class="form-text text-xs text-center">VAT: {{$currency->symbol.number_format($val->amount*20/100, '2')}} (+20%)</span>--}}
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="col-md-12 mb-5">
                <div class="text-center mt-8">
                  <div class="btn-wrapper text-center">
                      <a href="javascript:void;" class="btn btn-soft-warning btn-icon mb-3">
                          <span class="btn-inner--icon"><i class="fal fa-sad-tear fa-4x"></i></span>
                      </a>
                  </div>
                  <h3 class="text-dark">{{__('No Plans')}}</h3>
                  <p class="text-dark text-sm card-text">{{__('We couldn\'t find any Plans')}}</p>
                </div>
              </div>
            @endif
          </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <a href="{{route('user.dashboard')}}" class="text-dark"><i class="fal fa-arrow-left"></i> Back to Dashboard</a>
    </div>
  </div>
@stop