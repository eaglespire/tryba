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
                    <a href="{{route('user.services')}}" class="text-muted text-hover-primary">{{__('Service')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Create')}}</li>
            </ul>
        </div>
    </div>
</div>

<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Service')}}</h3>
                </div>
            </div>

            <form action="{{ route('create.service') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                                <input type="text" class="form-control form-control-solid" placeholder="{{__('The name of your service')}}" value="{{ (old('name')) ? old('name') : "" }}" name="name" required>
                            </div>
                            <div class="row mb-8">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Description')}}</label>
                                <div class="col-lg-12">
                                    <textarea type="text" class="form-control form-control-solid" rows="4" name="description" required>{{ (old('description')) ? old('description') : "" }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-bold mb-2 mt-5">{{__('Price')}}</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">{{$currency->symbol}}</span>
                                    </span>
                                    <input type="number" class="form-control form-control-solid" placeholder="{{__('The price  of your service')}}" value="{{ (old('price')) ? old('price') : '' }}" name="price" required>
                                </div>
                            </div>
                            <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-bold mb-2">{{__('Duration')}}</label>
                                <div class="input-group input-group-solid">
                                    <input type="number" class="form-control form-control-solid" placeholder="{{__('The duration of your service')}}" value="{{ (old('duration')) ? old('duration') : '' }}" name="duration" required>
                                    <span class="input-group-append">
                                        <select name="durationType" class="form-select form-select-solid" required>
                                            <option @if (old('durationType')=='minute' ) selected @endif value='minute'>Minute</option>
                                            <option @if (old('durationType')=='hour' ) selected @endif value='hour'>Hour</option>
                                            <option @if (old('durationType')=='day' ) selected @endif value='day'>Day</option>
                                            <option @if (old('durationType')=='week' ) selected @endif value='week'>Week</option>
                                            <option @if (old('durationType')=='month' ) selected @endif value='month'>Month</option>
                                            <option @if (old('durationType')=='year' ) selected @endif value='year'>Year</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Set Service Image')}}</label>
                                <div class="col-lg-4">
                                    @if($errors->first('image'))
                                    <p class="text-danger text-xs my-2">{{ $errors->first('image') }}</p>
                                    @endif
                                    <div class="image-input image-input-empty mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper w-150px h-150px"></div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                            <i class="fal fa-image fs-1 text-dark"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" required />
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
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Create Service')}}</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('script')

<script>
    let statusCheck = document.querySelector('#customCheckLogindhh');

    statusCheck.addEventListener('change', () => {
        if (statusCheck.checked) {
            statusCheck.value = 1
        } else {
            statusCheck.value = 0
        }
    });
</script>

@endsection