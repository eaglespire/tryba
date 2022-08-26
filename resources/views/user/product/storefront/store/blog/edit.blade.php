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
                    <a href="{{route('user.store.blog')}}" class="text-muted text-hover-primary">{{__('Blog')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                <div class="card-title flex-column">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Edit Article')}}</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{route('store.blog.view', ['id'=>$user->storefront()->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" target="_blank" class="btn btn-info btn-color-light"><i class="fal fa-eye"></i> {{__('Preview')}}</a>
                </div>
            </div>
            <div class="card-body px-9 pt-6 pb-4">
                <form action="{{route('update.blog.store', ['id'=>$val->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label fw-bold fs-6 required">{{__('Title')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control form-control-solid" value="{{$val->title}}" placeholder="{{__('Title')}}" name="title" required>
                                </div>
                            </div>
                            <div class="row mb-20">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Body')}}</label>
                                <div class="col-lg-12">
                                    <input type="hidden" id="quill_html" name="body" value="{{$val->body}}" required>
                                    <div data-toggle="quill">{!!$val->body!!}</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Visible')}}</label>
                                <div class="col-lg-12">
                                    <select name="status" class="form-select form-select-solid" required>
                                        <option value='0' @if($val->status==0) selected @endif>No</option>
                                        <option value='1' @if($val->status==1) selected @endif>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row mb-6">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Featured Image')}}</label>
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
</div>
@stop
@section('script')
<script>

</script>
@endsection