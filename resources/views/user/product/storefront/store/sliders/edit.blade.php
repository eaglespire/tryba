@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Storefront')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.storefront')}}" class="text-muted text-hover-primary">{{__('Storefront')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.storefront.theme')}}" class="text-muted text-hover-primary">{{__('Themes')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('theme.slider.store')}}" class="text-muted text-hover-primary">{{__('Slides')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Edit Slide')}}</h3>
                </div>
            </div>
            <form action="{{route('update.slider.store', ['id'=>$val->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Text 1')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-solid" value="{{$val->title1}}" placeholder="{{__('Text 1')}}" name="title1">
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Text 2')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-solid" value="{{$val->title2}}" placeholder="{{__('Text 2')}}" name="title2">
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Text 3')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-solid" value="{{$val->title2}}" placeholder="{{__('Text 3')}}" name="title3">
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Visible')}}</label>
                                <div class="col-lg-9">
                                    <select name="status" class="form-select form-select-solid" required>
                                        <option value='0' @if($val->status==0) selected @endif>No</option>
                                        <option value='1' @if($val->status==1) selected @endif>Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-check form-check-solid mb-6">
                                <input name="button_status" class="form-check-input" type="checkbox" id="buttonStatus" value="1" @if($val->button_status==1) checked @endif>
                                <label class="form-check-label fw-bold ps-2 fs-6" for="buttonStatus">{{__('Button Status')}}</label>
                            </div>
                            <div @if($val->button_status==0) style="display:none;" @endif id="buttonStatusDisplay">
                                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-bold mb-2">{{__('Text')}}</label>
                                    <input type="text" class="form-control form-control-solid" id="button_text" value="{{$val->button_text}}" maxlength="40" placeholder="{{__('Text')}}" name="button_text">
                                </div>
                                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-bold mb-2">{{__('Link')}}</label>
                                    <input type="url" class="form-control form-control-solid" id="button_link" value="{{$val->button_link}}" placeholder="{{__('Link')}}" name="button_link">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Image')}}</label>
                                <div class="col-lg-12">
                                    <div class="image-input image-input-outline mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{asset('asset/profile/'.$val->image)}})"></div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                            <i class="bi bi-pencil-fill fs-7"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit button-->

                                        <!--begin::Cancel button-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel image">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel button-->

                                        <!--begin::Remove button-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove image">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove button-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>
    'use strict';
    $(function() {
        $("#buttonStatus").click(function() {
            if ($(this).is(":checked")) {
                $("#buttonStatusDisplay").show();
                $('#button_text').attr('required', '');
                $('#button_link').attr('required', '');
            } else {
                $("#buttonStatusDisplay").hide();
                $('#button_text').removeAttr('required', '');
                $('#button_link').removeAttr('required', '');
            }
        });
    });
</script>
@endsection