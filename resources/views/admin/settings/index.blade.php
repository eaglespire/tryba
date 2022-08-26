@extends('master')
    @section('content')
    <div class="container-fluid mt--6">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h3 class="mb-0">{{__('Congifure website')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.settings.update')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Website name')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="site_name" maxlength="200" value="{{$set->site_name}}" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Yapily Auth Key')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="auth_key" value="{{$set->auth_key}}" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Yapily AuthSecret')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="auth_secret" value="{{$set->auth_secret}}" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Paypal Client ID')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="paypal_clientid" value="{{$set->paypal_clientid}}" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Paypal Secret Key')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="paypal_secret" value="{{$set->paypal_secret}}" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Paypal Product ID')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="paypal_productid" value="{{$set->paypal_productid}}" class="form-control">
                                    </div>
                                </div>                              
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Paypal Webhook ID')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="webhook_id" value="{{$set->webhook_id}}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Company email')}}</label>
                                    <div class="col-lg-10">
                                        <input type="email" name="email" value="{{$set->email}}" class="form-control" required>
                                    </div>
                                </div>                                  
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Buy Crypto Link')}}</label>
                                    <div class="col-lg-10">
                                        <input type="url" name="buy_crypto" value="{{$set->buy_crypto}}" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Support email')}}</label>
                                    <div class="col-lg-10">
                                        <input type="email" name="support_email" value="{{$set->support_email}}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Mobile')}}</label>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                            <input type="text" name="mobile" max-length="14" value="{{$set->mobile}}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Website title')}}</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="title" max-length="200" value="{{$set->title}}" class="form-control" required>
                                    </div>
                                </div>                                  
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Short description')}}</label>
                                    <div class="col-lg-10">
                                        <textarea type="text" name="site_desc" rows="4" class="form-control" required>{{$set->site_desc}}</textarea>
                                    </div>
                                </div>                               
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Storefront message')}}</label>
                                    <div class="col-lg-10">
                                        <textarea type="text" name="storefront_message" rows="4" class="form-control" required>{{$set->storefront_message}}</textarea>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Welcome Message')}}</label>
                                    <div class="col-lg-10">
                                        <textarea type="text" name="welcome_message" rows="7" class="form-control" required>{{$set->welcome_message}}</textarea>
                                    </div>
                                </div>                           
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">{{__('Livechat code')}}</label>
                                    <div class="col-lg-10">
                                        <textarea type="text" name="livechat" class="form-control">{{$set->livechat}}</textarea>
                                    </div>
                                </div>           
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success btn-sm">{{__('Save Changes')}}</button>
                                    </div>
                            </form>
                        </div>
                    </div>                                           
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">{{__('Features')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.features.update')}}" method="post">
                                @csrf   
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->email_verification==1)
                                                <input type="checkbox" name="email_activation" id="customCheckLogin2" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="email_activation"id="customCheckLogin2"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin2">
                                            <span class="text-muted">{{__('Email verification')}}</span>     
                                            </label>
                                        </div>                                         
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->sms_verification==1)
                                                <input type="checkbox" name="sms_activation" id="customCheckLoginx2" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="sms_activation"id="customCheckLoginx2"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLoginx2">
                                            <span class="text-muted">{{__('SMS verification')}}</span>     
                                            </label>
                                        </div>                       
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->email_notify==1)
                                                <input type="checkbox" name="email_notify" id="customCheckLogin3" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="email_notify"id="customCheckLogin3"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin3">
                                            <span class="text-muted">{{__('Email notify')}}</span>     
                                            </label>
                                        </div>  
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->registration==1)
                                                <input type="checkbox" name="registration" id="customCheckLogin4" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="registration"id="customCheckLogin4"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin4">
                                            <span class="text-muted">{{__('Registration')}}</span>     
                                            </label>
                                        </div>                                    
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->subscription==1)
                                                <input type="checkbox" name="subscription" id="customCheckLogin13" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="subscription"id="customCheckLogin13"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin13">
                                            <span class="text-muted">{{__('Subscription')}}</span>     
                                            </label>
                                        </div>                                        
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->stripe_connect==1)
                                                <input type="checkbox" name="stripe_connect" id="customCheckLogin130" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="stripe_connect" id="customCheckLogin130"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin130">
                                            <span class="text-muted">{{__('Stripe Connect')}}</span>     
                                            </label>
                                        </div>   
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->kyc_restriction==1)
                                                <input type="checkbox" name="kyc_restriction" id="customCheckLogin117" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="kyc_restriction" id="customCheckLogin117"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin117">
                                            <span class="text-muted">{{__('Compliance Restriction')}}</span>     
                                            </label>
                                        </div>                                                                                                                                                                                        
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->recaptcha==1)
                                                <input type="checkbox" name="recaptcha" id="customCheckLogin6" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="recaptcha"id="customCheckLogin6"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin6">
                                            <span class="text-muted">{{__('Recaptcha')}}</span>     
                                            </label>
                                        </div>
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->merchant==1)
                                                <input type="checkbox" name="merchant" id="customCheckLogin7" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="merchant" id="customCheckLogin7"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin7">
                                            <span class="text-muted">{{__('Merchant')}}</span>     
                                            </label>
                                        </div>                                                                                
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->country_restriction==1)
                                                <input type="checkbox" name="country_restriction" id="customCheckLogin459" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="country_restriction" id="customCheckLogin459"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin459">
                                            <span class="text-muted">{{__('Country Login Restriction')}}</span>     
                                            </label>
                                        </div>                                       
                                    </div>                                    
                                    <div class="col-lg-4">
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->invoice==1)
                                                <input type="checkbox" name="invoice" id="customCheckLogin10" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="invoice" id="customCheckLogin10"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin10">
                                            <span class="text-muted">{{__('Invoice')}}</span>     
                                            </label>
                                        </div>
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->store==1)
                                                <input type="checkbox" name="store" id="customCheckLogin10z" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="store" id="customCheckLogin10z"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin10z">
                                            <span class="text-muted">{{__('Store')}}</span>     
                                            </label>
                                        </div>                                        
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            @if($set->donation==1)
                                                <input type="checkbox" name="donation" id="customCheckLogin11" class="custom-control-input" value="1" checked>
                                            @else
                                                <input type="checkbox" name="donation" id="customCheckLogin11"  class="custom-control-input" value="1">
                                            @endif
                                            <label class="custom-control-label" for="customCheckLogin11">
                                            <span class="text-muted">{{__('Gig pot')}}</span>     
                                            </label>
                                        </div>                                                                                                                     
                                    </div>
                                </div>         
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success btn-sm">{{__('Save Changes')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>                
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">{{__('Security')}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.account.update')}}" method="post">
                                @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">{{__('Username')}}</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="username" value="{{$val->username}}" class="form-control">
                                        </div>
                                    </div>                         
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">{{__('Password')}}</label>
                                        <div class="col-lg-10">
                                            <input type="password" name="password"  class="form-control" required>
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
@stop