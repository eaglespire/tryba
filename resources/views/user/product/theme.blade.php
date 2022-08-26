@extends('userlayout')
@section('styles')
<link rel="stylesheet" href="{{asset('asset/dashboard/bootstrap-iconpicker.min.css')}}">
@endsection
@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Edit Template')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('website.theme')}}" class="text-muted text-hover-primary">{{__('Template')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
            </ul>
        </div>
        <div class="d-flex py-2">
            {{--<a href="{{route('theme.import.demo', ['id'=>$user->storefront()->id])}}" class="btn btn-info me-4">{{__('Import Demo Layout')}}</a>--}}
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="d-flex overflow-auto mb-10">
            <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                <li class="nav-item">
                    <a href="{{route('theme.edit.store')}}" class="nav-link text-active-primary px-3 @if(route('theme.edit.store')==url()->current()) active @endif">{{__('Homepage')}}</a>
                </li>
                @if(themeSetting($user->storefront()->theme_id)['config']['sliders']==1)
                <li class="nav-item">
                    <a href="{{route('theme.slider.store')}}" class="nav-link text-active-primary px-3 @if(route('theme.slider.store')==url()->current()) active @endif">{{__('Slides')}}</a>
                </li>
                @endif
                @if(themeSetting($user->storefront()->theme_id)['config']['features']==1)
                <li class="nav-item">
                    <a href="{{route('theme.features.store')}}" class="nav-link text-active-primary px-3 @if(route('theme.features.store')==url()->current()) active @endif">{{__('Features')}}</a>
                </li>
                @endif
                @if(themeSetting($user->storefront()->theme_id)['config']['menu']==1)
                <li class="nav-item">
                    <a href="{{route('theme.menu.store')}}" class="nav-link text-active-primary px-3 @if(route('theme.menu.store')==url()->current()) active @endif">{{__('Menu')}}</a>
                </li>
                @endif
                {{--
                @if(themeSetting($user->storefront()->theme_id)['config']['menu']==1)
                <li class="nav-item">
                    <a href="{{route('theme.menu.store')}}" class="nav-link text-active-primary px-3 @if(route('theme.menu.store')==url()->current()) active @endif">{{__('Footer')}}</a>
                </li>
                @endif
                @if(themeSetting($user->storefront()->theme_id)['config']['menu']==1)
                <li class="nav-item">
                    <a href="{{route('theme.menu.store')}}" class="nav-link text-active-primary px-3 @if(route('theme.menu.store')==url()->current()) active @endif">{{__('Contact Us')}}</a>
                </li>
                @endif
                --}}
            </ul>
        </div>
        @if(route('theme.edit.store')==url()->current())
        <form action="{{route('update.slider.text', ['id'=>$user->storefront()->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @if(array_key_exists('slider', themeSetting($user->storefront()->theme_id)['home_page']))
            <div class="card mb-8">
                <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                    <div class="card-title flex-column">
                        <p class="m-0">{{__('Slider')}}</p>
                    </div>
                    <div class="card-toolbar">
                        <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                            <input name="slider_status" class="form-check-input h-30px w-50px" type="checkbox" value="1" @if(isset(getLayout($user->storefront()->id)->slider_status) && getLayout($user->storefront()->id)->slider_status==1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Limit')}}" value="{{getLayout($user->storefront()->id)->slider_limit ?? NULL}}" name="slider_limit">
                    </div>
                </div>
            </div>
            @endif
            @if(array_key_exists('blog', themeSetting($user->storefront()->theme_id)['home_page']))
            <div class="card mb-8">
                <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                    <div class="card-title flex-column">
                        <p class="m-0">{{__('Blog')}}</p>
                    </div>
                    <div class="card-toolbar">
                        <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                            <input name="blog_status" class="form-check-input h-30px w-50px" type="checkbox" value="1" @if(isset(getLayout($user->storefront()->id)->blog_status) && getLayout($user->storefront()->id)->blog_status==1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" value="{{ getLayout($user->storefront()->id)->blog_title ?? NULL }}" name="blog_title">
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Subtitle')}}</label>
                        <textarea class="form-control form-control-solid" rows="2" name="blog_body" type="text" placeholder="{{__('Subtitle')}}">{{ getLayout($user->storefront()->id)->blog_body ?? NULL }}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Limit')}}" value="{{ getLayout($user->storefront()->id)->blog_limit ?? NULL }}" name="blog_limit">
                    </div>
                </div>
            </div>
            @endif
            @if(array_key_exists('review', themeSetting($user->storefront()->theme_id)['home_page']))
            <div class="card mb-8">
                <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                    <div class="card-title flex-column">
                        <p class="m-0">{{__('Review')}}</p>
                    </div>
                    <div class="card-toolbar">
                        <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                            <input name="review_status" class="form-check-input h-30px w-50px" type="checkbox" value="1" @if(isset(getLayout($user->storefront()->id)->review_status) && getLayout($user->storefront()->id)->review_status == 1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" value="{{getLayout($user->storefront()->id)->review_title ?? NULL}}" name="review_title">
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Subtitle')}}</label>
                        <textarea class="form-control form-control-solid" rows="2" name="review_body" type="text" placeholder="{{__('Subtitle')}}">{{getLayout($user->storefront()->id)->review_body ?? NULL}}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Limit')}}" value="{{getLayout($user->storefront()->id)->review_limit ?? NULL}}" name="review_limit">
                    </div>
                </div>
            </div>
            @endif
            @if(array_key_exists('services', themeSetting($user->storefront()->theme_id)['home_page']))
            <div class="card mb-8">
                <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                    <div class="card-title flex-column">
                        <p class="m-0">{{__('Services')}}</p>
                    </div>
                    <div class="card-toolbar">
                        <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                            <input name="services_status" class="form-check-input h-30px w-50px" type="checkbox" value="1" @if(isset(getLayout($user->storefront()->id)->services_status) && getLayout($user->storefront()->id)->services_status==1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" value="{{getLayout($user->storefront()->id)->services_title ?? NULL}}" name="services_title">
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Subtitle')}}</label>
                        <textarea class="form-control form-control-solid" rows="2" name="services_body" type="text" placeholder="{{__('Subtitle')}}">{{getLayout($user->storefront()->id)->services_body ?? NULL}}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Limit')}}" value="{{getLayout($user->storefront()->id)->services_limit ?? NULL}}" name="services_limit">
                    </div>
                </div>
            </div>
            @endif
            @if(array_key_exists('team', themeSetting($user->storefront()->theme_id)['home_page']))
            <div class="card mb-8">
                <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                    <div class="card-title flex-column">
                        <p class="m-0">{{__('Team')}}</p>
                    </div>
                    <div class="card-toolbar">
                        <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                            <input name="team_status" class="form-check-input h-30px w-50px" type="checkbox" value="1" @if(isset(getLayout($user->storefront()->id)->team_status) && getLayout($user->storefront()->id)->team_status==1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" value="{{getLayout($user->storefront()->id)->team_title ?? NULL}}" name="team_title">
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Subtitle')}}</label>
                        <textarea class="form-control form-control-solid" rows="2" name="team_body" type="text" placeholder="{{__('Subtitle')}}">{{getLayout($user->storefront()->id)->team_body ?? NULL}}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Limit')}}" value="{{getLayout($user->storefront()->id)->team_limit ?? NULL}}" name="team_limit">
                    </div>
                </div>
            </div>
            @endif
            @if(array_key_exists('statistics', themeSetting($user->storefront()->theme_id)['home_page']))
            <div class="card mb-8">
                <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                    <div class="card-title flex-column">
                        <p class="m-0">{{__('Statistics')}}</p>
                    </div>
                    <div class="card-toolbar">
                        <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                            <input name="statistics_status" class="form-check-input h-30px w-50px" type="checkbox" value="1" @if(isset(getLayout($user->storefront()->id)->statistics_status) && getLayout($user->storefront()->id)->statistics_status==1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Title')}}" value="{{getLayout($user->storefront()->id)->statistics_title ?? NULL}}" name="statistics_title">
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Subtitle')}}</label>
                        <textarea class="form-control form-control-solid" rows="2" name="statistics_body" type="text" placeholder="{{__('Subtitle')}}">{{getLayout($user->storefront()->id)->statistics_body ?? NULL}}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Limit')}}" value="{{getLayout($user->storefront()->id)->statistics_limit ?? NULL}}" name="statistics_limit">
                    </div>
                </div>
            </div>
            @endif
            <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
        </form>
        @endif
        @if(route('theme.slider.store')==url()->current())
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                            <div class="card-toolbar">
                                <a href="{{route('add.slider.store')}}" class="btn btn-info btn-color-light btn-sm">{{__('Create Slide')}}</a>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-25px"></th>
                                        <th class="min-w-80px">{{__('Image')}}</th>
                                        <th class="min-w-50px">{{__('Slug')}}</th>
                                        <th class="min-w-50px">{{__('Status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(getThemeSliders($user->storefront()->id) as $k=>$val)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                                <span class="svg-icon svg-icon-3 svg-icon-primary">
                                                    <i class="fal fa-chevron-circle-down"></i>
                                                </span>
                                            </button>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                                </div>
                                                <div class="menu-item px-3"><a href="{{route('edit.slider.store', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="symbol symbol-30px me-6 bg-light">
                                                    <img alt="image" src="{{asset('asset/profile/'.$val->image)}}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$val->slug}}</td>
                                        <td>@if($val->status==1)Active @else Disabled @endif</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach(getThemeSliders($user->storefront()->id) as $k=>$val)
                    <div class="modal fade" tabindex="-1" id="slide_delete{{$val->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('Delete Slide')}}</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="svg-icon svg-icon-2x"></span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('Are you sure you want to delete this?')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('delete.slider.store', ['id'=>$val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @if(route('theme.features.store')==url()->current())
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                            <div class="card-toolbar">
                                <a href="{{route('add.feature.store')}}" class="btn btn-info btn-color-light btn-sm">{{__('Create Feature')}}</a>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-25px"></th>
                                        <th class="min-w-80px">{{__('Image')}}</th>
                                        <th class="min-w-50px">{{__('Slug')}}</th>
                                        <th class="min-w-50px">{{__('Status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(getThemeFeature($user->storefront()->id) as $k=>$val)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                                <span class="svg-icon svg-icon-3 svg-icon-primary">
                                                    <i class="fal fa-chevron-circle-down"></i>
                                                </span>
                                            </button>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                                </div>
                                                <div class="menu-item px-3"><a href="{{route('edit.feature.store', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="symbol symbol-30px me-6 bg-light">
                                                    <img alt="image" src="{{asset('asset/profile/'.$val->image)}}">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$val->slug}}</td>
                                        <td>@if($val->status==1)Active @else Disabled @endif</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach(getThemeFeature($user->storefront()->id) as $k=>$val)
                    <div class="modal fade" tabindex="-1" id="slide_delete{{$val->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('Delete Feature')}}</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="svg-icon svg-icon-2x"></span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('Are you sure you want to delete this?')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('delete.feature.store', ['id'=>$val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @if(route('theme.menu.store')==url()->current())
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-header align-items-center border-0 mt-2">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="fw-boldest text-dark fs-4">{{__('Pre-built Menus')}}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('Home')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('Home')}}" data-type="home" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('Services')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('Services')}}" data-type="services" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('Blog')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('Blog')}}" data-type="blog" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('Our Team')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('Our Team')}}" data-type="our_team" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('Testimonials')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('Testimonials')}}" data-type="testimonials" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('FAQ')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('FAQ')}}" data-type="faq" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{__('Products')}}</div>
                                        </div>
                                    </div>
                                    <a data-text="{{__('Products')}}" data-type="products" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                @foreach(getStorePageActive($user->storefront()->id) as $val)
                                <div class="d-flex flex-stack mb-7">
                                    <div class="d-flex align-items-center">
                                        <div class="ps-1">
                                            <div class="fs-6 text-dark fw-bold mt-1">{{$val->title}} <span class="badge badge-light-primary">{{__('Custom Page')}}</span></div>
                                        </div>
                                    </div>
                                    <a data-text="{{$val->title}}" data-type="{{$val->id}}" data-custom="yes" class="addToMenus btn btn-light btn-color-muted fw-boldest btn-sm px-5" href="javascript:void;">{{__('Add to Menus')}}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-header align-items-center border-0 mt-2">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="fw-boldest text-dark fs-4">{{__('Add / Edit Menu')}}</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form id="frmEdit" class="form-horizontal">
                                    @csrf
                                    <input class="item-menu" type="hidden" name="type" value="">

                                    <div id="withUrl">
                                        <div class="form-group mb-6">
                                            <label class="col-form-label fw-bold fs-6" for="text">{{__('Text')}}</label>
                                            <input type="text" class="form-control form-control-solid item-menu" name="text" placeholder="{{__('Text')}}">
                                        </div>
                                        <div class="form-group mb-6">
                                            <label class="col-form-label fw-bold fs-6" for="href">{{__('URL')}}</label>
                                            <input type="text" class="form-control form-control-solid item-menu" name="href" placeholder="{{__('URL')}}">
                                        </div>
                                        <div class="form-group mb-6">
                                            <label class="col-form-label fw-bold fs-6" for="target">{{__('Target')}}</label>
                                            <select name="target" id="target" class="form-control form-control-solid item-menu">
                                                <option value="_self">{{__('Self')}}</option>
                                                <option value="_blank">{{__('Blank')}}</option>
                                                <option value="_top">{{__('Top')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="withoutUrl" style="display: none;">
                                        <div class="form-group mb-6">
                                            <label class="col-form-label fw-bold fs-6" for="text">{{__('Text')}}</label>
                                            <input type="text" class="form-control form-control-solid item-menu" name="text" placeholder="{{__('Text')}}">
                                        </div>
                                        <div class="form-group mb-6">
                                            <label class="col-form-label fw-bold fs-6" for="href">{{__('URL')}}</label>
                                            <input type="text" class="form-control form-control-solid item-menu" name="href" placeholder="{{__('URL')}}">
                                        </div>
                                        <div class="form-group mb-6">
                                            <label class="col-form-label fw-bold fs-6" for="target">{{__('Target')}}</label>
                                            <select name="target" class="form-control form-control-solid item-menu">
                                                <option value="_self">{{__('Self')}}</option>
                                                <option value="_blank">{{__('Blank')}}</option>
                                                <option value="_top">{{__('Top')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="button" id="btnUpdate" class="btn btn-info" disabled><i class="fal fa-sync-alt"></i> {{__('Update')}}</button>
                                <button type="button" id="btnAdd" class="btn btn-success"><i class="fal fa-plus"></i> {{__('Add')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-header align-items-center border-0 mt-2">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="fw-boldest text-dark fs-4">{{__('Website Menus')}}</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                <ul id="myEditor" class="sortableLists list-group">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form">
                    <div class="form-group from-show-notify row">
                        <div class="col-12 text-center">
                            <button id="btnOutput" class="btn btn-success">{{__('Update Menu')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
@stop
@section('script')
<script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('asset/dashboard/vue/vue.js')}}"></script>
<script src="{{asset('asset/dashboard/vue/axios.js')}}"></script>
<script src="{{asset('asset/dashboard/fontawesome-iconpicker/fontawesome-iconpicker.min.js')}}"></script>
<script src="{{asset('asset/dashboard/jquery-menu-editor/jquery-menu-editor.js')}}"></script>
<script>
    "use strict";
    var prevMenus = "{{ ($user->storefront()->getMenus()) ? json_encode($user->storefront()->getMenus()->menus) : "" }}";
    var menuUpdate = "{{route('theme.menu.store.update', ['id'=> $user->storefront()->id])}}";
</script>
<script src="{{asset('asset/dashboard/menu-builder.js')}}"></script>
@endsection
