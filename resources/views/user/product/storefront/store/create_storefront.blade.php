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
                <li class="breadcrumb-item text-dark">{{__('Create')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        @if(count($user->shipping())==0)
        <div class="notice d-flex bg-light-primary rounded border border-primary rounded p-6 mb-8">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotone/General/Shield-check.svg-->
            <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                    <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                </svg>
            </span>
            <!--end::Svg Icon-->
            <!--end::Icon-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                <!--begin::Content-->
                <div class="mb-3 mb-md-0 fw-bold">
                    <h4 class="text-gray-800 fw-bolder">{{__('Setup shipping rates & regions')}}</h4>
                    <div class="fs-6 text-dark pe-7">{{__('You are required to add a region and shipping rate, to create a storefront')}}</div>
                </div>
                <!--end::Content-->
                <!--begin::Action-->
                <a href="{{route('user.shipping')}}" class="btn btn-primary px-6 align-self-center text-nowrap">{{__('Setup')}}</a>
                <!--end::Action-->
            </div>
            <!--end::Wrapper-->
        </div>
        @endif
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Store')}}</h3>
                </div>
            </div>
            <form action="{{route('submit.store')}}" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Store title')}}</label>
                        <input type="text" class="form-control form-control-solid" value="@if(session('store_name')){{session('store_name')}}@endif" placeholder="{{__('The name of your store')}}" name="store_name" required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Store description')}}</label>
                        <textarea class="form-control form-control-solid" rows="5" name="store_desc" type="text" placeholder="{{__('Store Description')}}" required>@if(session('store_desc')){{session('store_desc')}}@endif</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Storefront Link')}}</label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                                <span class="input-group-text">{{url('/')}}/store/</span>
                            </span>
                            <input type="text" step="any" required class="form-control form-control-solid" value="@if(session('store_url')){{session('store_url')}}@endif" name="store_url" placeholder="slug">
                        </div>
                        <div class="form-text">{{__('You can\'t edit this after submission')}}</div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" @if(count($user->shipping())==0) disabled @endif class="btn btn-primary px-6">{{__('Create Storefront')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop