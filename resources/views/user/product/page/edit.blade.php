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
                    <a href="{{route('website.page')}}" class="text-muted text-hover-primary">{{__('Page')}}</a>
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
                    <h3 class="fw-bolder m-0 text-dark">{{__('Edit Page')}}</h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{route('store.page.view', ['id'=>$user->storefront()->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" target="_blank" class="btn btn-info btn-color-light"><i class="fal fa-eye"></i> {{__('Preview')}}</a>
                </div>
            </div>
            <form action="{{route('update.page.store', ['id'=>$val->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
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

</script>
@endsection