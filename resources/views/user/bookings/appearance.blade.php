@extends('user.bookings.index')

@section('mainpage')
    <div class="card">
        <form action="{{route('post.appearance')}}" method="post">
            @csrf
            <div class="card-body px-9 pt-6 pb-4">
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Theme Color')}}</label>
                    <div class="col-lg-1">
                        <input type="color" name="themeColor" class="border rounded" value="{{ ($appearance) ? $appearance->themeColor : '#01afef'}}" required>
                  </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                        <span class="required">{{__('Action Text')}}</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="{{__('Action text for buttons')}}"></i>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="actionText" class="form-control form-control-lg form-control-solid" placeholder="{{__('Action text')}}" value="{{ ($appearance) ? $appearance->actionText : "Book now" }}" required>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                        <span class="required">{{__('Working hours')}}</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="{{__('Action text for buttons')}}"></i>
                    </label>
                    <div class="col-lg-4 mb-6">
                        <div class="input-group input-group-solid">
                            <select name="" id="" class="form-control form-control-lg form-control-solid">
                                <option value="">{{ _('Opening hours') }}</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span class="input-group-prepend">
                                <span class="input-group-text">AM</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-group-solid">
                            <select name="" id="" class="form-control form-control-lg form-control-solid">
                                <option value="">{{ _('Closing hours') }}</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span class="input-group-prepend">
                                <span class="input-group-text">PM</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Set your header image')}}</label>
                    <div class="col-lg-4">
                        @if($errors->first('logo'))
                            <p class="text-danger text-xs my-2">{{ $errors->first('logo') }}</p>
                        @endif
                        <div class="image-input image-input-outline mb-5" data-kt-image-input="true">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-256px h-125px"></div>
                            <!--end::Image preview wrapper-->
    
                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-52 h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change header image">
                            <i class="bi bi-pencil-fill fs-7"></i>
    
                            <!--begin::Inputs-->
                            <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->
    
                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel header image">
                            <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->
    
                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove header image">
                            <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                      </div>
                    </div>
                </div>
            </div>       
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
            </div>
        </form>
    </div>
   
@endsection