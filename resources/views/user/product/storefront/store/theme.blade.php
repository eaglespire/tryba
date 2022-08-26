@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Themes')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.ecommerce')}}" class="text-muted text-hover-primary">{{__('Storefront')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Themes')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="row g-xl-8">
            @foreach($store->StoreFrontThemes() as $key => $val)
                <div class="col-xl-4">
                    <div class="card mb-5 mb-xxl-8">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <div class="d-flex flex-column">
                                        @if($key==$user->storefront()->theme_id)
                                        <span class="badge badge-pill badge-light-info">Default Theme</span>
                                        @else
                                        <a href="{{route('default.store', ['id' => $user->storefront()->id, 'key' => $key])}}"><span class="badge badge-pill badge-light-info">Set as Default</span></a>
                                        @endif
                                    </div>
                                </div>
                                @if($key==$user->storefront()->store_theme_id)
                                    <a href="{{route('theme.edit.store')}}" class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow">
                                        <i class="fal fa-pencil fs-1 text-dark"></i>
                                    </a>
                                @else 
                                    <div class=" w-50px h-50px"></div>
                                @endif
                            </div>
                            <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom card-rounded-bottom max-h-300px min-h-200px" style="background-image:url({{$val['img_path']}})"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@stop