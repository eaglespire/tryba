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
                    <a href="{{route('website.blog')}}" class="text-muted text-hover-primary">{{__('Blog')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('customer.blog.cat')}}" class="text-muted text-hover-primary">{{__('Category')}}</a>
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
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Category')}}</h3>
                </div>
            </div>
            <form action="{{route('create.blog.cat.store', ['id'=>$user->storefront()->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="row mb-6">
                        <label class="col-lg-12 col-form-label fw-bold fs-6 required">{{__('Title')}}</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" name="title" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Create Category')}}</button>
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