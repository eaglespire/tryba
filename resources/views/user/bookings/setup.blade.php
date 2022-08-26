@extends('user.bookings.index')

@section('mainpage')
    <div class="card">
        <form action="{{route('booking.setup')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="card-body px-9 pt-6 pb-4">
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Business Name')}}</label>
                    <div class="col-lg-9">
                        <input type="text" name="business_name" value="{{ ($bookingInfos) ? $bookingInfos->business_name : "" }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{__('Business Name')}}" value="" required>
                        @if($errors->first('business_name'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('business_name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                        <span class="required">{{__('Contact Phone')}}</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="{{__('Phone number must be active')}}" aria-label="{{__('Phone number must be active')}}"></i>
                    </label>
                    <div class="col-lg-9">
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                                <span class="input-group-text">+{{$user->getCountry()->phonecode}}</span>
                            </span>
                            <input type="tel" name="phone" maxlength="14" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - with country code')}}" value="{{ ($bookingInfos) ? $bookingInfos->phone_number : "" }}">
                        </div>
                        @if($errors->first('phone'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                        <span class="required">{{__('Email Address')}}</span>
                    </label>
                    <div class="col-lg-9">
                        <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="{{__('Email address')}}" value="{{ ($bookingInfos) ? $bookingInfos->email : "" }}" required>
                        @if($errors->first('email'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Description')}}</label>
                    <div class="col-lg-9">
                        <textarea name="description" id="" cols="30" rows="5" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{__('Description')}}" required>{{ ($bookingInfos) ? $bookingInfos->description : "" }}</textarea>
                        @if($errors->first('description'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                        <span class="required">{{__('Location')}}</span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="address" class="form-control form-control-lg form-control-solid" placeholder="{{__('Location')}}" value="{{ ($bookingInfos) ? $bookingInfos->email : "" }}" required>
                        @if($errors->first('email'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Booking link')}}</label>
                    <div class="col-lg-9">
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                                <span class="input-group-text">{{url('/')}}/bookings/</span>
                            </span>
                            <input type="tel" name="slug" maxlength="14" class="form-control form-control-lg form-control-solid" placeholder="{{__('Booking link')}}" value="{{ ($bookingInfos) ? $bookingInfos->slug : "" }}">
                        </div>
                        @if($errors->first('slug'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('slug') }}</p>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="symbol" value="{{ $currency->symbol }}">
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="required fs-5 fw-bold mb-2">{{__('Meta keywords')}}</label>
                    <input type="text" id="meta_keywords" class="form-control form-control-solid" required value="{{($bookingInfos) ? $bookingInfos->meta_keywords : "" }}" placeholder="{{__('Meta keywords')}}" name="meta_keywords">
                    @if($errors->first('meta_keywords'))
                        <p class="text-danger text-xs my-2">{{ $errors->first('meta_keywords') }}</p>
                    @endif
                </div>
                <div class="row mb-6">
                    <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Set your store logo')}}</label>
                    <div class="col-lg-4">
                        @if($errors->first('logo'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('logo') }}</p>
                        @endif
                        <div class="image-input image-input-outline mb-5" data-kt-image-input="true" @if($bookingInfos) style="background-image:url({{asset('/')}}) !important" @endif>
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-125px h-125px"></div>
                            <!--end::Image preview wrapper-->
    
                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change Checkout Image">
                            <i class="bi bi-pencil-fill fs-7"></i>
    
                            <!--begin::Inputs-->
                            <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->
    
                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Checkout Image">
                            <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->
    
                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove Checkout Image">
                            <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                      </div>
                    </div>
                </div>
                <div class="form-check form-check-solid mb-6">
                    <input name="status" class="form-check-input" type="checkbox" id="customCheckLogindhh" @if($bookingInfos AND $bookingInfos->status==1)checked value="1" @else value="0" @endif>
                    <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLogindhh">{{__('Active')}}</label>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
            </div>
        </form>
    </div>
   
@endsection

@section('script')
    <script>
        'use strict';
        var input2 = document.querySelector("#meta_keywords");
        new Tagify(input2);

        let statusCheck =  document.querySelector('#customCheckLogindhh');

        statusCheck.addEventListener('change',()=>{
            if(statusCheck.checked){
                statusCheck.value = 1
            }else{
                statusCheck.value = 0
            }
        });
    </script>
    @if (session('success'))
        <script>
        "use strict";
        toastr.success("{{ session('success') }}");
        </script> 
    @endif

    @if (session('error'))
        <script>
        "use strict";
        toastr.error("{{ session('error') }}");
        </script> 
    @endif
@endsection