@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Website')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Website Settings')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card mb-6">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Settings')}}</h3>
                </div>
            </div>
            <form action="{{route('edit.website')}}" method="post" enctype="multipart/form-data">
                <div class="card-body px-9 pt-6 pb-4">
                    @csrf
                    <input type="hidden" value="{{$user->storefront()->id}}" name="id">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Website Title')}}</label>
                        <input type="text" class="form-control form-control-solid" value="{{$user->storefront()->store_name}}" placeholder="{{__('The name of your store')}}" name="store_name" required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Website Description')}}</label>
                        <textarea class="form-control form-control-solid" rows="5" name="store_desc" type="text" placeholder="{{__('Store Description')}}" required>{{$user->storefront()->store_desc}}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Value added tax')}}</label>
                        <div class="input-group input-group-solid">
                            <input type="number" steps="any" class="form-control form-control-solid" value="{{$user->storefront()->tax}}" placeholder="VAT" name="tax">
                            <span class="input-group-append">
                                <span class="input-group-text">%</span>
                            </span>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Maintenance Mode')}}</label>
                        <div class="col-lg-12">
                            <select name="status" class="form-select form-select-solid" required>
                                <option value='0' @if($user->storefront()->status==0) selected @endif>{{__('Under maintenance')}}</option>
                                <option value='1' @if($user->storefront()->status==1) selected @endif>{{__('Website is active')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-lg-12">
                            <div class="form-check form-check-solid mb-6">
                                <input name="checkout_logo" class="form-check-input" type="checkbox" id="customCheckLoging7" value="1" @if($user->checkout_logo==1)checked @endif>
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoging7">{{__('Show Logo')}}</label>
                            </div>
                            <div class="form-check form-check-solid mb-6">
                                <input name="display_blog" class="form-check-input" type="checkbox" id="customBlog" value="1" @if($user->storefront()->display_blog==1)checked @endif>
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customBlog">{{__('Display blog')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="fw-bold fs-6">{{__('Website logo - Default Tryba logo will be used if not provided')}}</p>
                            <div class="image-input image-input-outline mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                                <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{asset('asset/profile/'.$cast)}})"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                            <i class="fal fa-image fs-1 text-dark"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Website Image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove Website Image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fw-bolder mb-6 text-dark">{{__('SEO (Search engine optimization)')}}</h4>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2">{{__('Meta Keywords')}}</label>
                            <input type="text" id="meta_keywords" class="form-control form-control-solid" value="{{$user->storefront()->meta_keywords}}" placeholder="{{__('Meta keywords')}}" name="meta_keywords">
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2">{{__('Meta Description')}}</label>
                            <textarea type="text" class="form-control form-control-solid" placeholder="{{__('Meta description')}}" name="meta_description">{{$user->storefront()->meta_description}}</textarea>
                        </div>
                        <h4 class="fw-bolder mb-6 text-dark">{{__('Analytics')}}</h4>
                        <p>Get statistics of what is happening on your website</p>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-bold mb-2">{{__('Google Analytic')}}</label>
                            <input type="text" maxlength="14" class="form-control form-control-solid" value="{{$user->storefront()->analytics}}" placeholder="UA-XXXXXXXXX-X" name="analytics">
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-bold mb-2">{{__('Facebook Pixel')}}</label>
                            <input type="text" maxlength="12" class="form-control form-control-solid" value="{{$user->storefront()->facebook_pixel}}" placeholder="UA-0000000-0" name="facebook_pixel">
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                </div>
            </form>
            <form action="{{route('edit.store.mail', ['id'=>$user->storefront()->id])}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="accordion accordion-icon-toggle" id="kt_accordion_1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_1_header_2">
                                <button class="accordion-button fs-4 fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_2">
                                    {{__('Mail Configuration')}}
                                </button>
                            </h2>
                            <div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="row mb-6">
                                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('What email smtp configuration will you be using?')}}</label>
                                            <div class="col-lg-12">
                                                <select id="mail" name="mail" class="form-select form-select-solid" required>
                                                    <option value='0' @if($user->storefront()->mail==0) selected @endif>Tryba ({{__('You can\'t send custom emails to customers using this!')}})</option>
                                                    <option value='1' @if($user->storefront()->mail==1) selected @endif>My Email Configuration</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-6" id="showMail" style="display:none;">
                                            <div class="col-lg-6">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail Host')}}</label>
                                                <input type="text" placeholder="smtp.com" value="{{$user->storefront()->mail_host}}" class="form-control form-control-solid" name="mail_host" id="mail_host" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail Port')}}</label>
                                                <input type="text" placeholder="465" value="{{$user->storefront()->mail_port}}" class="form-control form-control-solid" name="mail_port" id="mail_port" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail Username')}}</label>
                                                <input type="email" placeholder="username" value="{{$user->storefront()->mail_username}}" class="form-control form-control-solid" name="mail_username" id="mail_username" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail Password')}}</label>
                                                <input type="password" placeholder="password" value="{{$user->storefront()->mail_password}}" class="form-control form-control-solid" name="mail_password" id="mail_password" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail Encryption')}}</label>
                                                <input type="text" placeholder="SSL/TLS" value="{{$user->storefront()->mail_encryption}}" class="form-control form-control-solid" name="mail_encryption" id="mail_encryption" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail From Address')}}</label>
                                                <input type="email" placeholder="email address" value="{{$user->storefront()->mail_from_address}}" class="form-control form-control-solid" name="mail_from_address" id="mail_from_address" required>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="col-form-label fw-bold fs-6">{{__('Mail From Name')}}</label>
                                                <input type="text" placeholder="sender name" value="{{$user->storefront()->mail_from_name}}" class="form-control form-control-solid" name="mail_from_name" id="mail_from_name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        @if($user->storefront()->mail==1)
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#test_email" class="btn btn-success px-6 me-2">{{__('Test SMTP')}}</a>
                                        @endif
                                        <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if($user->storefront()->working_time!=null)
            <form action="{{route('edit.booking')}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="accordion accordion-icon-toggle mb-8" id="kt_accordion_2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_2_header_1">
                                <button class="accordion-button fs-4 p-4 fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_1" aria-expanded="true" aria-controls="kt_accordion_2_body_1">
                                    {{__('Booking Configuration')}}
                                </button>
                            </h2>
                            <div id="kt_accordion_2_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                            <label class="fs-5 fw-bold mb-2">{{__('How do you render service?')}}</label>
                                            <select name="session_time" class="form-select form-select-solid" required>
                                                <option value="1" @if($user->storefront()->session_time==1) selected @endif>{{__('One customer per booking')}}</option>
                                                <option value="2" @if($user->storefront()->session_time==1) selected @endif>{{__('More than one customer per booking')}}</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                            <label class="fs-5 fw-bold mb-2">{{__('Where do you render service?')}}</label>
                                            <select id="service_type" name="service_type" class="form-select form-select-solid" required>
                                                <option value="1" @if($user->storefront()->service_type==1) selected @endif>{{__('Customer home address')}}</option>
                                                <option value="2" @if($user->storefront()->service_type==2) selected @endif>{{__('I have a physical location where I receive customers')}}</option>
                                            </select>
                                        </div>
                                        <div id="store" class="mb-6" @if($user->storefront()->service_type==1) style="display:none;" @endif>
                                            @if($user->storefront()->service_type==1)
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">
                                                    <span class="required">{{__('State/County')}}</span>
                                                </label>
                                                <div class="col-lg-9">
                                                    <select class="form-control form-control-lg form-control-solid" data-control="select2" id="state" name="state" required>
                                                        @foreach($user->getState() as $val)
                                                        <option value="{{$val->id.'*'.$val->iso2}}">{{$val->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row mb-6">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">
                                                    <span class="required">{{__('State/County')}}</span>
                                                </label>
                                                <div class="col-lg-9">
                                                    <select class="form-control form-control-lg form-control-solid" data-control="select2" id="state" name="state" required>
                                                        @foreach($user->getState() as $val)
                                                        <option value="{{$val->id.'*'.$val->iso2}}" @if($user->storefront()->state==$val->id)selected @endif>{{$val->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row mb-6" id="showCity" style="display:none;">
                                                <label class="col-lg-3 col-form-label fw-bold fs-6">
                                                    <span class="required">{{__('City')}}</span>
                                                </label>
                                                <div class="col-lg-9">
                                                    <select class="form-control form-control-lg form-control-solid" data-control="select2" id="city" name="city">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Line 1')}}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="line_1" name="line_1" value="{{$user->storefront()->line_1}}" class="form-control form-control-lg form-control-solid" placeholder="Line 1">
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Zip/Postal Code')}}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" id="postal_code" name="postal_code" value="{{$user->storefront()->postal_code}}" class="form-control form-control-lg form-control-solid" placeholder="Zip/Postal code">
                                                </div>
                                            </div>
                                            <div class="form-text">{{__('Store location will be displayed on your website')}}</div>
                                        </div>
                                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                            <label class="fs-5 fw-bold mb-2">{{__('Daily limit')}}</label>
                                            <input type="number" class="form-control form-control-solid" value="{{$user->storefront()->booking_per_day}}" placeholder="{{__('The maximum amount of bookings per day, leave this empty if you need no limit')}}" name="booking_per_day">
                                        </div>
                                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                            <label class="fs-5 fw-bold mb-2">{{__('Service review')}}</label>
                                            <select id="service_review" name="service_review" class="form-select form-select-solid" required>
                                                <option value="1" @if($user->storefront()->service_review==1) selected @endif>{{__('Allow service review after completion')}}</option>
                                                <option value="0" @if($user->storefront()->service_review==0) selected @endif>{{__('I don\'t need service review')}}</option>
                                            </select>
                                        </div>
                                        <h4 class="fw-bolder mb-6 text-dark">{{__('Business Hours')}}</h4>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[mon][status]" class="form-check-input" type="checkbox" id="custommon" @if($user->storefront()->working_time['mon']['status'] == 1) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="custommon">{{__('Monday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="monstart" @if($user->storefront()->working_time['mon']['status']) @else disabled @endif name="workingtime[mon][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['mon']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="monend" @if($user->storefront()->working_time['mon']['status']) @else disabled @endif name="workingtime[mon][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['mon']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[tue][status]" class="form-check-input" type="checkbox" id="customtue" @if($user->storefront()->working_time['tue']['status']) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customtue">{{__('Tuesday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="tuestart" @if($user->storefront()->working_time['tue']['status']) @else disabled @endif name="workingtime[tue][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['tue']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="tueend" @if($user->storefront()->working_time['tue']['status']) @else disabled @endif name="workingtime[tue][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['tue']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[wed][status]" class="form-check-input" type="checkbox" id="customwed" @if($user->storefront()->working_time['wed']['status']) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customwed">{{__('Wednesday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="wedstart" @if($user->storefront()->working_time['wed']['status']) @else disabled @endif name="workingtime[wed][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['wed']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="wedend" @if($user->storefront()->working_time['wed']['status']) @else disabled @endif name="workingtime[wed][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['wed']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[thu][status]" class="form-check-input" type="checkbox" id="customthu" @if($user->storefront()->working_time['thu']['status']) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customthu">{{__('Thursday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <select class="form-select form-select-solid" id="thustart" @if($user->storefront()->working_time['thu']['status']) @else disabled @endif name="workingtime[thu][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['thu']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <select class="form-select form-select-solid" id="thuend" @if($user->storefront()->working_time['thu']['status']) @else disabled @endif name="workingtime[thu][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['thu']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[fri][status]" class="form-check-input" type="checkbox" id="customfri" @if($user->storefront()->working_time['fri']['status']) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customfri">{{__('Friday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="fristart" @if($user->storefront()->working_time['fri']['status']) @else disabled @endif name="workingtime[fri][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['fri']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="friend" @if($user->storefront()->working_time['fri']['status']) @else disabled @endif name="workingtime[fri][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['fri']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[sat][status]" class="form-check-input" type="checkbox" id="customsat" @if($user->storefront()->working_time['sat']['status']) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customsat">{{__('Saturday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="satstart" @if($user->storefront()->working_time['sat']['status']) @else disabled @endif name="workingtime[sat][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['sat']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="satend" @if($user->storefront()->working_time['sat']['status']) @else disabled @endif name="workingtime[sat][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['sat']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <div class="col-lg-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="workingtime[sun][status]" class="form-check-input" type="checkbox" id="customsun" @if($user->storefront()->working_time['sun']['status']) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customsun">{{__('Sunday')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="sunstart" @if($user->storefront()->working_time['sun']['status']) @else disabled @endif name="workingtime[sun][start]" required>
                                                        @foreach(getTimeInterval(1) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['sun']['start'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-select form-select-solid" id="sunend" @if($user->storefront()->working_time['sun']['status']) @else disabled @endif name="workingtime[sun][end]" required>
                                                        @foreach(getTimeInterval(2) as $key => $val)
                                                        <option value="{{$val}}" @if($user->storefront()->working_time['sun']['end'] == $val) selected @endif>{{strtoupper($val)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder mb-3 text-dark">{{__('Vacation Date')}}</h4>
                                        <p>You won't receive any bookings during this period</p>
                                        @if(!empty($user->storefront()->vacation_time))
                                        <div class="row mb-6">
                                            <div class="col-md-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="customva" class="form-check-input" type="checkbox" id="customva" @if($user->storefront()->vacation_status==1) checked @endif>
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customva">{{__('Status')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input class="form-control form-control-solid" id="vacation" name="date" placeholder="Pick date rage" value="{{$user->storefront()->vacation_time['startdate'].'-'.$user->storefront()->vacation_time['enddate']}}" />
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row mb-6">
                                            <div class="col-md-4">
                                                <div class="form-check form-check-solid mb-6">
                                                    <input name="customva" class="form-check-input" type="checkbox" id="customva">
                                                    <label class="form-check-label fw-bold ps-2 fs-6" for="customva">{{__('Status')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input class="form-control form-control-solid" disabled id="vacation" name="date" placeholder="Pick date rage" />
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            <form action="{{route('edit.store')}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="accordion accordion-icon-toggle mb-8" id="kt_accordion_3">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_3_header_1">
                                <button class="accordion-button p-4 fs-4 fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_body_1" aria-expanded="true" aria-controls="kt_accordion_3_body_1">
                                    {{__('Storefront Configuration')}}
                                </button>
                            </h2>
                            <div id="kt_accordion_3_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_3_header_1" data-bs-parent="#kt_accordion_3">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="row mb-5">
                                            <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Products per page')}}</label>
                                            <div class="col-lg-12">
                                                <select name="product_per_page" class="form-select form-select-solid" required>
                                                    <option value="" data-select2-id="select2-data-6-31tw">Select number of products per page...</option>
                                                    <option value="8" @if($user->storefront()->product_per_page=="8") selected @endif>8</option>
                                                    <option value="16" @if($user->storefront()->product_per_page=="16") selected @endif>16</option>
                                                    <option value="32" @if($user->storefront()->product_per_page=="32") selected @endif>32</option>
                                                    <option value="64" @if($user->storefront()->product_per_page=="64") selected @endif>64</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                            <label class="fs-5 fw-bold mb-2">{{__('Product review')}}</label>
                                            <select id="product_review" name="product_review" class="form-select form-select-solid" required>
                                                <option value="1" @if($user->storefront()->product_review==1) selected @endif>{{__('Allow product review after purchase')}}</option>
                                                <option value="0" @if($user->storefront()->product_review==0) selected @endif>{{__('I don\'t need product review')}}</option>
                                            </select>
                                        </div>
                                        <div class="form-check form-check-solid mb-6">
                                            <input name="display_related_products" class="form-check-input" type="checkbox" id="customCheckLoginxdhh" value="1" @if($user->storefront()->display_related_products==1)checked @endif>
                                            <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginxdhh">{{__('Display related product')}}</label>
                                        </div>
                                        <div class="form-check form-check-solid mb-6">
                                            <input name="storeActive" class="form-check-input" type="checkbox" id="customCheckLoginxdhh" value="1" @if($user->storefront()->storeActive == true)checked @endif>
                                            <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginxdhh">{{ ($user->storefront()->storeActive == false) ? __('Activate your store') : __('Deactivate your store')}}</label>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>
</div>
@stop
@section('script')
<script>
    jQuery(document).ready(function($) {
        $('.clickable-row').on("click", function() {
            window.location.href = $(this).data('href');
        });
    });
</script>
<script>
    'use strict';
    var input2 = document.querySelector("#meta_keywords");
    new Tagify(input2);
</script>
<script>
    'use strict';
    $(function() {
        $("#customva").click(function() {
            if ($(this).is(":checked")) {
                $('#vacation').prop('disabled', false);
            } else {
                $('#vacation').prop('disabled', true);
            }
        });
        $("#custommon").click(function() {
            if ($(this).is(":checked")) {
                $('#monstart').prop('disabled', false);
                $('#monend').prop('disabled', false);
            } else {
                $('#monstart').prop('disabled', true);
                $('#monend').prop('disabled', true);
            }
        });
        $("#customtue").click(function() {
            if ($(this).is(":checked")) {
                $('#tuestart').prop('disabled', false);
                $('#tueend').prop('disabled', false);
            } else {
                $('#tuestart').prop('disabled', true);
                $('#tueend').prop('disabled', true);
            }
        });
        $("#customwed").click(function() {
            if ($(this).is(":checked")) {
                $('#wedstart').prop('disabled', false);
                $('#wedend').prop('disabled', false);
            } else {
                $('#wedstart').prop('disabled', true);
                $('#wedend').prop('disabled', true);
            }
        });
        $("#customthu").click(function() {
            if ($(this).is(":checked")) {
                $('#thustart').prop('disabled', false);
                $('#thuend').prop('disabled', false);
            } else {
                $('#thustart').prop('disabled', true);
                $('#thuend').prop('disabled', true);
            }
        });
        $("#customfri").click(function() {
            if ($(this).is(":checked")) {
                $('#fristart').prop('disabled', false);
                $('#friend').prop('disabled', false);
            } else {
                $('#fristart').prop('disabled', true);
                $('#friend').prop('disabled', true);
            }
        });
        $("#customsat").click(function() {
            if ($(this).is(":checked")) {
                $('#satstart').prop('disabled', false);
                $('#satend').prop('disabled', false);
            } else {
                $('#satstart').prop('disabled', true);
                $('#satend').prop('disabled', true);
            }
        });
        $("#customsun").click(function() {
            if ($(this).is(":checked")) {
                $('#sunstart').prop('disabled', false);
                $('#sunend').prop('disabled', false);
            } else {
                $('#sunstart').prop('disabled', true);
                $('#sunend').prop('disabled', true);
            }
        });
    });

    function service() {
        var type = $("#service_type").find(":selected").val();
        if (type == 1) {
            $('#store').hide();
            $('#state').removeAttr('required', '');
            $('#city').removeAttr('required', '');
            $('#line_1').removeAttr('required', '');
            $('#postal_code').removeAttr('required', '');
        } else if (type == 2) {
            $('#store').show();
            $('#state').attr('required', '');
            $('#line_1').attr('required', '');
            $('#postal_code').attr('required', '');
        }
    }
    $("#service_type").change(service);
    service();

    function setupMail() {
        var type = $("#mail").find(":selected").val();
        if (type == 0) {
            $('#showMail').hide();
            $('#mail_host').removeAttr('required', '');
            $('#mail_port').removeAttr('required', '');
            $('#mail_username').removeAttr('required', '');
            $('#mail_password').removeAttr('required', '');
            $('#mail_encryption').removeAttr('required', '');
            $('#mail_from_address').removeAttr('required', '');
            $('#mail_from_name').removeAttr('required', '');
        } else if (type == 1) {
            $('#showMail').show();
            $('#mail_host').attr('required', '');
            $('#mail_port').attr('required', '');
            $('#mail_username').attr('required', '');
            $('#mail_password').attr('required', '');
            $('#mail_encryption').attr('required', '');
            $('#mail_from_address').attr('required', '');
            $('#mail_from_name').attr('required', '');
        }
    }
    $("#mail").change(setupMail);
    setupMail();
</script>
@if($user->storefront()->working_time!=null)
<script>
    function addresschange() {
        var selectedState = $("#state").find(":selected").val();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{route('user.address.state')}}",
            data: {
                state: selectedState
            },
            success: function(response) {
                console.log(response);
                if (response.trim() == '') {
                    $('#showCity').hide();
                    $('#city').removeAttr('required', '');
                } else {
                    $('#showCity').show();
                    $('#city').html(response);
                    $('#city').attr('required', '');
                }
            },
            error: function(err) {
                console.log(err)
            }
        });
    }
    $("#state").change(addresschange);
</script>
<script>
    function xxxx() {
        var selectedState = $("#state").find(":selected").val();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{route('user.address.statef')}}",
            data: {
                state: '{{$user->storefront()->state}}',
                city: '{{$user->storefront()->city}}'
            },
            success: function(response) {
                console.log(response);
                if (response.trim() == '') {
                    $('#showCity').hide();
                    $('#city').removeAttr('required', '');
                } else {
                    $('#showCity').show();
                    $('#city').html(response);
                    $('#city').attr('required', '');
                }
            },
            error: function(err) {
                console.log(err)
            }
        });
    }
    xxxx();
</script>
@endif
@endsection