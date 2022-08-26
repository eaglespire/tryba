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
                    <a href="{{route('website.customer')}}" class="text-muted text-hover-primary">{{__('Customer')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Send email')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Compose Email')}}</h3>
                </div>
            </div>
            <form action="{{route('send.store.mail', ['id'=>$val->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Recipient')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Receiver')}}" name="to" value="{{$val->first_name.' '.$val->last_name}}" readonly required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Email')}}</label>
                        <input type="email" class="form-control form-control-solid" placeholder="{{__('Email')}}" name="email" value="{{$val->email}}" readonly required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Subject')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Subject')}}" name="subject" required>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <input type="hidden" id="quill_html" name="message" required>
                            <div data-toggle="quill" data-quill-placeholder="{{__('Compose message')}}"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Send email')}}</button>
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