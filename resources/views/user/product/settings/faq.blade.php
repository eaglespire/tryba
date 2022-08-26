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
                <li class="breadcrumb-item text-dark">{{__('Faq')}}</li>
            </ul>
        </div>
        <div class="d-flex py-2">
            <a href="{{route('add.faq.store')}}" class="btn btn-info me-4"><i class="fal fa-question"></i> {{__('New Question')}}</a>
            <a href="{{route('add.faq.cat.store')}}" class="btn btn-dark me-4"><i class="fal fa-folder"></i> {{__('New Category')}}</a>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="d-flex overflow-auto mb-10">
            <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                <li class="nav-item">
                    <a href="{{route('website.faq')}}" class="nav-link text-active-primary px-3 @if(route('website.faq')==url()->current()) active @endif">{{_('Question')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('customer.faq.cat')}}" class="nav-link text-active-primary px-3 @if(route('customer.faq.cat')==url()->current()) active @endif">{{__('Category')}}</a>
                </li>
            </ul>
        </div>
        <div class="row g-xl-8">
            <div class="col-xl-12">
                @if(route('website.faq')==url()->current())
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-25px"></th>
                                        <th class="min-w-80px">{{__('Question')}}</th>
                                        <th class="min-w-50px">{{__('Date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(getStoreFaq($user->storefront()->id) as $k=>$val)
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
                                                <div class="menu-item px-3"><a href="{{route('edit.faq.store', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                            </div>
                                        </td>
                                        <td>{{$val->question}}</td>
                                        <td>{{$val->created_at->diffforHumans()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach(getStoreFaq($user->storefront()->id) as $k=>$val)
                    <div class="modal fade" tabindex="-1" id="slide_delete{{$val->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('Delete Faq')}}</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="svg-icon svg-icon-2x"></span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('Are you sure you want to delete this?')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('delete.faq.store', ['id'=>$val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                @if(route('customer.faq.cat')==url()->current())
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-25px"></th>
                                        <th class="min-w-80px">{{__('Title')}}</th>
                                        <th class="min-w-50px">{{__('Date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(getStoreFaqCat($user->storefront()->id) as $k=>$val)
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
                                                <div class="menu-item px-3"><a href="{{route('edit.faq.cat.store', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#cat_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                            </div>
                                        </td>
                                        <td>{{$val->title}}</td>
                                        <td>{{$val->created_at->diffforHumans()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach(getStoreFaqCat($user->storefront()->id) as $k=>$val)
                    <div class="modal fade" tabindex="-1" id="cat_delete{{$val->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('Delete Category')}}</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="svg-icon svg-icon-2x"></span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('Are you sure you want to delete this?')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('delete.faq.cat.store', ['id'=>$val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@stop