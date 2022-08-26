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
                    <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Website')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('website.widgets')}}" class="text-muted text-hover-primary">{{__('Team')}}</a>
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
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Team')}}</h3>
                </div>
            </div>
            <form action="{{route('create.team.website', ['id'=>$user->website->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="card-body px-9 pt-6 pb-4">
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6 required">{{__('Title')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" name="title" required>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Occupation')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Occupation')}}" name="occupation">
                                </div>
                            </div>
                            <h4>{{__('Social accounts')}}</h4>
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Whatsapp')}}</label>
                                <div class="col-lg-12">
                                    <input type="url" class="form-control form-control-solid" placeholder="{{__('Whatsapp')}}" name="whatsapp">
                                </div>
                            </div>                            
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Facebook')}}</label>
                                <div class="col-lg-12">
                                    <input type="url" class="form-control form-control-solid" placeholder="{{__('Facebook')}}" name="facebook">
                                </div>
                            </div>                            
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Linkedin')}}</label>
                                <div class="col-lg-12">
                                    <input type="url" class="form-control form-control-solid" placeholder="{{__('Linkedin')}}" name="linkedin">
                                </div>
                            </div>                            
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Instagram')}}</label>
                                <div class="col-lg-12">
                                    <input type="url" class="form-control form-control-solid" placeholder="{{__('Instagram')}}" name="instagram">
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Twitter')}}</label>
                                <div class="col-lg-12">
                                    <input type="url" class="form-control form-control-solid" placeholder="{{__('Twitter')}}" name="twitter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Featured Image')}}</label>
                            <div class="col-lg-12">
                                <div class="image-input image-input-empty mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                                    <!--begin::Image preview wrapper-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Image preview wrapper-->

                                    <!--begin::Edit button-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                        <i class="bi bi-pencil-fill fs-7"></i>

                                        <!--begin::Inputs-->
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" required/>
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
                    <button type="submit" class="btn btn-primary px-6">{{__('Add team member')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>

</script>
@endsection