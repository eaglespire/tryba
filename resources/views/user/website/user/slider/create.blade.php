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
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('website.theme')}}" class="text-muted text-hover-primary">{{__('Website')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('website.widgets')}}" class="text-muted text-hover-primary">{{__('Widget')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Create')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Slide')}}</h3>
                </div>
            </div>
            <form action="{{route('create.slider.website')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Text 1')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Text 1')}}" name="title1">
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Text 2')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Text 2')}}" name="title2">
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Text 3')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Text 3')}}" name="title3">
                                </div>
                            </div>
                            <div class="form-check form-check-solid mb-6">
                                <input name="button_status" class="form-check-input" type="checkbox" id="buttonStatus" value="1">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="buttonStatus">{{__('Button Status')}}</label>
                            </div>
                            <div style="display:none;" id="buttonStatusDisplay">
                                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-bold mb-2">{{__('Text')}}</label>
                                    <input type="text" class="form-control form-control-solid" id="button_text" maxlength="40" placeholder="{{__('Text')}}" name="button_text">
                                </div>
                                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-bold mb-2">{{__('Link')}}</label>
                                    <input type="url" class="form-control form-control-solid" id="button_link" placeholder="{{__('Link')}}" name="button_link">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Image')}}</label>
                                <div class="col-lg-12">
                                    <div class="image-input image-input-empty bg-light mb-5" data-kt-image-input-action="change" data-kt-image-input="true">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper w-250px h-150px"></div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                            <i class="fal fa-image fs-1 text-dark"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="file" accept=".png, .jpg, .jpeg" required />
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
                                    <p  class="fs-6 text-small">Use 1280 by 720 pixels</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Submit')}}</button>
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