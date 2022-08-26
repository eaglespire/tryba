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
                <li class="breadcrumb-item text-dark">{{__('Storefront')}}</li>
            </ul>
        </div>
        <div class="d-flex py-2">
            <a href="{{ route('store.index',['id' => $user->storefront()->store_url])}}" target="_blank" class="btn btn-dark me-4"><i class="fal fa-store"></i> {{__('My store')}}</a>
            <a href="{{route('new.product')}}" class="btn btn-dark me-4"><i class="fal fa-cart-plus"></i> {{__('Add a new product')}}</a>
            <div class="modal fade" id="ship_create" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">
                        <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('submit.shipping')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="modal-header">
                                <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Create Shipping fee')}}</h3>
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <span class="svg-icon svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body py-10">
                                <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px" style="max-height: 521px;">
                                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-bold mb-2">{{__('State/county')}}</label>
                                        <select name="state" class="form-control form-control-lg form-control-solid" data-control="select2" required>
                                            @foreach($user->getState() as $con)
                                            <option value="{{$con->id}}">{{$con->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                        <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">{{$currency->symbol}}</span>
                                            </span>
                                            <input type="number" step="any" class="form-control form-control-solid" name="amount" placeholder="{{__('How much?')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer flex-center">
                                <button type="submit" class="btn btn-success btn-block">{{__('Create Shipping fee')}}</button>
                            </div>
                            <div></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        @if($user->storefront()->user->display_support_email!=1 || $user->storefront()->user->display_support_phone!=1)
        <div class="notice d-flex bg-light-info rounded border border-info  p-6 mb-8">
            <span class="svg-icon svg-icon-2tx svg-icon-info me-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                    <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                </svg>
            </span>
            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                <div class="mb-3 mb-md-0 fw-bold">
                    <h4 class="text-gray-800 fw-bolder">{{__('Update support information')}}</h4>
                    <div class="fs-6 text-dark pe-7">{{__('For the security of everyone on tryba, please update your support information')}}</div>
                </div>
                <a href="{{route('user.preferences')}}" class="btn btn-info px-6 align-self-center text-nowrap">{{__('Setup')}}</a>
            </div>
        </div>
        @endif
        @if($user->productCount()>0)
        <div class="notice d-flex bg-light-info rounded border border-info  p-6 mb-8">
            <span class="svg-icon svg-icon-2tx svg-icon-info me-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                    <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                </svg>
            </span>
            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                <div class="mb-3 mb-md-0 fw-bold">
                    <h4 class="text-gray-800 fw-bolder">{{__('Update some product category')}}</h4>
                    <div class="fs-6 text-dark pe-7">{{__('Products that don\'t have a category won\'t be displayed on storefront nor marketplace')}}</div>
                </div>
            </div>
        </div>
        @endif
        <div class="d-flex overflow-auto mb-10">
            <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                <li class="nav-item">
                    <a href="{{route('user.ecommerce')}}" class="nav-link text-active-primary px-3 @if(route('user.ecommerce')==url()->current()) active @endif">{{_('Dashboard')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.product')}}" class="nav-link text-active-primary px-3 @if(route('user.product')==url()->current()) active @endif">{{__('Products')}} ({{count($user->product())}})</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.list')}}" class="nav-link text-active-primary px-3 @if(route('user.list')==url()->current()) active @endif">{{__('Orders')}} ({{count($user->orders())}})</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.shipping')}}" class="nav-link text-active-primary px-3 @if(route('user.shipping')==url()->current()) active @endif">{{__('Shipping')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.storefront.themes') }}" class="nav-link text-active-primary px-3 @if(route('user.storefront.themes') == url()->current()) active @endif">{{__('Themes')}}</a>
                </li>
            </ul>
        </div>
        @if(route('user.ecommerce')==url()->current())
            @if(count($user->shipping())==0)
                <div class="notice d-flex bg-light-warning  border border-warning rounded p-6 mb-8">
                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                            <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                            <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                        </svg>
                    </span>
                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                        <div class="mb-3 mb-md-0 fw-bold">
                            <h4 class="text-gray-800 fw-bolder">{{__('Setup shipping rates & regions')}}</h4>
                            <div class="fs-6 text-dark pe-7">{{__('You\'re yet to add a region and shipping rate')}}</div>
                        </div>
                        <a href="{{route('user.shipping')}}" class="btn btn-warning px-6 align-self-center text-nowrap">{{__('Setup')}}</a>
                    </div>
                </div>
            @endif
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="col-md-12">
                        <div class="card mb-6">
                            <div class="card-header align-items-center mt-2 border-0">
                                <h3 class="fw-boldest text-dark fs-6x">{{__('Revenue')}}</h3>
                                <div class="text-dark-400 fw-bold fs-6">{{number_format($user->orderSum(), 2).$currency->name}}</div>
                            </div>
                        </div>
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0 d-flex justify-content-between flex-column">
                                <div class="d-flex flex-stack card-p flex-grow-1">
                                    <!--begin::Icon-->
                                    <div class="symbol symbol-45px">
                                        <div class="symbol-label">
                                            <i class="fal fa-sync text-primary"></i>
                                        </div>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column text-end">
                                        <span class="fw-boldest text-dark fs-2">{{__('Orders')}}</span>
                                        <span class="text-dark-400 fw-bold fs-6">{{date("M, d", strtotime(Carbon\Carbon::now()->startOfMonth()))}} - {{date("M, d Y", strtotime(Carbon\Carbon::now()->endOfMonth()))}}</span>
                                        <span class="text-dark-400 fw-bold fs-6">{{number_format($user->orderForTheMonthSum(),2).$currency->name}}</span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--begin::Chart-->
                                <div class="">
                                    @if(count($user->orderForTheMonth())>0)
                                    <div id="kt_chart_earning" class="card-rounded-bottom h-125px"></div>
                                    @else
                                    <div class="card-rounded-bottom h-125px text-center text-primary">{{__('No data')}}</div>
                                    @endif
                                </div>
                                <!--end::Chart-->
                            </div>
                        </div>
                        <div class="card mb-6">
                            <div class="card-header align-items-center mt-2 border-0">
                                <h3 class="fw-boldest text-dark fs-6x">{{__('Top 5 sold products')}}</h3>
                            </div>
                            <div class="card-body pt-3">
                                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                            <th class="min-w-25px"></th>
                                            <th class="min-w-80px">{{__('Name')}}</th>
                                            <th class="min-w-70px">{{__('Sold')}}</th>
                                            <th class="min-w-50px">{{__('Stock')}}</th>
                                            <th class="min-w-50px">{{__('Amount')}}</th>
                                            <th class="min-w-70px">{{__('Visible')}}</th>
                                            <th class="min-w-70px">{{__('Views')}}</th>
                                            <th class="min-w-100px">{{__('Date')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->topProduct() as $k=>$val)
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click">
                                                    <span class="svg-icon svg-icon-3 svg-icon-primary">
                                                    <i class="fal fa-chevron-circle-down"></i>
                                                    </span>
                                                </button>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                                    </div>
                                                    <div class="menu-item px-3"><a data-bs-toggle="modal" data-bs-target="#product_share{{$val->id}}" href="#" class="menu-link px-3">{{__('Share')}}</a></div>
                                                    <div class="menu-item px-3"><a target="_blank" href="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}" class="menu-link px-3">{{__('Preview')}}</a></div>
                                                    <div class="menu-item px-3"><a href="{{route('orders', ['id' => $val->id])}}" class="menu-link px-3">{{__('Orders')}}</a></div>
                                                    <div class="menu-item px-3"><a href="{{route('edit.product', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                    <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#product_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                                </div>
                                            </td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">
                                                <div class="d-flex">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <div class="mb-1 text-gray-800">
                                                            @if(strlen($val->name)>20)
                                                            {{substr($val->name, 0, 20)}} ...
                                                            @else
                                                            {{$val->name}}
                                                            @endif
                                                        </div>
                                                        @if(checkCategory($val->cat_id)==0)
                                                        <span class="badge badge-warning">{{__('Add category')}}</span>
                                                        @else
                                                        <div class="fw-bold text-gray-400">{{$val->cat->name}}</div>
                                                        @endif
                                                        <div class="tt-rating">
                                                            <i class="fal fa-star @if($val->rating()>0) checked @endif"></i>
                                                            <i class="fal fa-star @if($val->rating()>1) checked @endif"></i>
                                                            <i class="fal fa-star @if($val->rating()>2) checked @endif"></i>
                                                            <i class="fal fa-star @if($val->rating()>3) checked @endif"></i>
                                                            <i class="fal fa-star @if($val->rating()>4) checked @endif"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->sold}}</td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->quantity}}</td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$currency->symbol.$val->amount}}</td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">
                                                @if($val->status==1)
                                                {{__('Yes')}}
                                                @elseif($val->status==0)
                                                {{__('No')}}
                                                @endif
                                            </td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->views}}</td>
                                            <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->created_at->diffforHumans()}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @foreach($user->topProduct() as $k=>$val)
                        <div class="modal fade" id="product_share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-dialog-centered mw-800px">
                                <div class="modal-content">
                                    <div class="modal-header pb-0 border-0 justify-content-end">
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                            <span class="svg-icon svg-icon-2x">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="modal-body scroll-y pt-0 pb-15">
                                        <!--begin::Wrapper-->
                                        <div class="mw-lg-600px mx-auto">
                                            <!--begin::Heading-->
                                            <div class="mb-15 text-center">
                                                <h3 class="fw-boldest text-dark fs-2x">{{__('Share')}}</h3>
                                                <!--begin::Description-->
                                                <div class="text-dark-400 fw-bold fs-4">{{__('Share product with friends, family & customers')}}</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Title-->
                                                <div class="d-flex">
                                                    <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}">
                                                    <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}">Copy Link</button>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex">
                                                <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}" class="btn btn-light-primary w-100">
                                                    <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>
                                                <a target="_blank" href="https://wa.me/{{$val->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}" class="btn btn-icon btn-success mx-6 w-100">
                                                    <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}</a>
                                            </div>
                                            <!--end::Actions-->
                                            <!--begin::Input group-->
                                            <div class="text-center px-5 mt-8">
                                                <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                                                {!! QrCode::eye('circle')->style('round')->size(250)->generate(route('sproduct.link', ['id'=>$user->storefront()->id,'product'=>$val->ref_id])); !!}
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" tabindex="-1" id="product_delete{{$val->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{__('Delete Product')}}</h5>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <span class="svg-icon svg-icon-2x"></span>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{__('Are you sure you want to delete this?, all transaction related to this product will be deleted')}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <a href="{{route('delete.product', ['id' => $val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(route('user.product') == url()->current())
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_7" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-25px"></th>
                                        <th class="min-w-80px">{{__('Name')}}</th>
                                        <th class="min-w-70px">{{__('Sold')}}</th>
                                        <th class="min-w-50px">{{__('Stock')}}</th>
                                        <th class="min-w-50px">{{__('Amount')}}</th>
                                        <th class="min-w-70px">{{__('Visible')}}</th>
                                        <th class="min-w-70px">{{__('Views')}}</th>
                                        <th class="min-w-100px">{{__('Date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->product() as $k=>$val)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click">
                                                <span class="svg-icon svg-icon-3 svg-icon-primary">
                                                <i class="fal fa-chevron-circle-down"></i>
                                                </span>
                                            </button>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                                </div>
                                                <div class="menu-item px-3"><a data-bs-toggle="modal" data-bs-target="#product_share{{$val->id}}" href="#" class="menu-link px-3">{{__('Share')}}</a></div>
                                                <div class="menu-item px-3"><a target="_blank" href="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}" class="menu-link px-3">{{__('Preview')}}</a></div>
                                                <div class="menu-item px-3"><a href="{{route('orders', ['id' => $val->id])}}" class="menu-link px-3">{{__('Orders')}}</a></div>
                                                <div class="menu-item px-3"><a href="{{route('edit.product', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#product_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                            </div>
                                        </td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">
                                            <div class="d-flex">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <div class="mb-1 text-gray-800">
                                                        @if(strlen($val->name)>20)
                                                        {{substr($val->name, 0, 20)}} ...
                                                        @else
                                                        {{$val->name}}
                                                        @endif
                                                    </div>
                                                    @if(checkCategory($val->cat_id)==0)
                                                    <span class="badge badge-warning">{{__('Add category')}}</span>
                                                    @else
                                                    <div class="fw-bold text-gray-400">{{$val->cat->name}}</div>
                                                    @endif
                                                    <div class="tt-rating">
                                                        <i class="fal fa-star @if($val->rating()>0) checked @endif"></i>
                                                        <i class="fal fa-star @if($val->rating()>1) checked @endif"></i>
                                                        <i class="fal fa-star @if($val->rating()>2) checked @endif"></i>
                                                        <i class="fal fa-star @if($val->rating()>3) checked @endif"></i>
                                                        <i class="fal fa-star @if($val->rating()>4) checked @endif"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->sold}}</td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->quantity}}</td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$currency->symbol.$val->amount}}</td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">
                                            @if($val->status==1)
                                            {{__('Yes')}}
                                            @elseif($val->status==0)
                                            {{__('No')}}
                                            @endif
                                        </td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->views}}</td>
                                        <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">{{$val->created_at->diffforHumans()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach($user->product() as $k=>$val)
                    <div class="modal fade" id="product_share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered mw-800px">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                        <span class="svg-icon svg-icon-2x">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y pt-0 pb-15">
                                    <!--begin::Wrapper-->
                                    <div class="mw-lg-600px mx-auto">
                                        <!--begin::Heading-->
                                        <div class="mb-15 text-center">
                                            <h3 class="fw-boldest text-dark fs-2x">{{__('Share')}}</h3>
                                            <!--begin::Description-->
                                            <div class="text-dark-400 fw-bold fs-4">{{__('Share product with friends, family & customers')}}</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Title-->
                                            <div class="d-flex">
                                                <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}">
                                                <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}">Copy Link</button>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex">
                                            <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}" class="btn btn-light-primary w-100">
                                                <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>
                                            <a target="_blank" href="https://wa.me/{{$val->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$val->ref_id])}}" class="btn btn-icon btn-success mx-6 w-100">
                                                <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}</a>
                                        </div>
                                        <!--end::Actions-->
                                        <!--begin::Input group-->
                                        <div class="text-center px-5 mt-8">
                                            <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                                            {!! QrCode::eye('circle')->style('round')->size(250)->generate(route('sproduct.link', ['id'=>$user->storefront()->id,'product'=>$val->ref_id])); !!}
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="product_delete{{$val->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('Delete Product')}}</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="svg-icon svg-icon-2x"></span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('Are you sure you want to delete this?, all transaction related to this product will be deleted')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('delete.product', ['id' => $val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @if(route('user.list')==url()->current())
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_7" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-20px">{{__('S/N')}}</th>
                                        <th class="min-w-80px">{{__('Name')}}</th>
                                        <th class="min-w-50px">{{__('Amount')}}</th>
                                        <th class="min-w-50px">{{__('Quantity')}}</th>
                                        <th class="min-w-50px">{{__('Subtotal')}}</th>
                                        <th class="min-w-70px">{{__('Ship fee')}}</th>
                                        <th class="min-w-70px">{{__('Tax')}}</th>
                                        <th class="min-w-70px">{{__('Total')}}</th>
                                        <th class="min-w-100px">{{__('Date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders() as $k=>$val)
                                    <tr>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$loop->iteration}}.</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">
                                            <div class="d-flex">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a href="{{route('edit.product', ['id' => $val->product->ref_id])}}" class="mb-1 text-gray-800 text-hover-primary">
                                                        @if(strlen($val->product->name)>25)
                                                        {{substr($val->product->name, 0, 25)}} ...
                                                        @else
                                                        {{$val->product->name}}
                                                        @endif
                                                        <span class="badge badge-light-primary">@if($val->order_status==null)Payment Received @else {{$val->order_status}} @endif</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->amount, 2)}}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$val->quantity}}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->amount*$val->quantity, 2)}}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->shipping_fee, 2)}}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->tax, 2)}}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->total, 2)}}</td>
                                        <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$val->created_at->diffforHumans()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach($user->orders() as $k=>$val)
                    <div class="modal fade" id="order_share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered mw-800px">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                        <span class="svg-icon svg-icon-2x">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y pt-0 pb-15">
                                    <!--begin::Wrapper-->
                                    <div class="mw-lg-600px mx-auto">
                                        <!--begin::Heading-->
                                        <div class="mb-15 text-center">
                                            <h3 class="fw-boldest text-dark fs-2x">{{__('Order Details')}}</h3>
                                            <!--begin::Description-->
                                            <div class="text-dark-400 fw-bold fs-4">{{__('Information concerning this order')}}</div>
                                            <div class="fw-bold text-dark">Order ID: {{$val->ref_id}}</div>
                                            <div class="fw-bold text-dark">Tracking Code: {{$val->order_id}}</div>
                                            <div class="fw-bold text-dark">{{$val->product->name}}</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        @if($val->note!=null)
                                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                                                    <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                                                </svg>
                                            </span>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <!--begin::Content-->
                                                <div class="fw-bold">
                                                    <h4 class="text-gray-800 fw-bolder">Additional Note</h4>
                                                    <div class="fs-6 text-gray-600">{{$val->note}}</div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        @endif
                                        <div class="row mt-8">
                                            <div class="col-xl-4 mb-10 mb-xl-0">
                                                <h3 class="fw-boldest mb-3">Delivery Address</h3>
                                                <div class="fs-5 fw-bold text-dark">
                                                    {{__('State')}}: {{$val->shipstate->name}}
                                                    @if($val->city!=null)
                                                    <br>{{__('City')}}: {{$val->city}}
                                                    @endif
                                                    <br>{{__('Postal code')}}: {{$val->postal_code}}
                                                    <br>{{__('line 1')}}: {{$val->line_1}}
                                                    @if($val->line_2!=null)
                                                    <br>{{__('line 2')}}: {{$val->line_2}}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xl-4 mb-10 mb-xl-0">
                                                <h3 class="fw-boldest mb-3">Customer</h3>
                                                <div class="fs-5 fw-bold text-dark">
                                                    @if($val->customer_id==null)
                                                    {{__('Name')}}: {{$val->first_name}} {{$val->last_name}}<br>
                                                    {{__('Email')}}: {{$val->email}}<br>
                                                    {{__('Phone')}}: {{$val->phone}}
                                                    @else
                                                    {{__('Name')}}: {{$val->buyer->first_name}} {{$val->buyer->last_name}}<br>
                                                    {{__('Email')}}: {{$val->buyer->email}}<br>
                                                    {{__('Phone')}}: {{$val->buyer->phone}}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xl-4 mb-10 mb-xl-0">
                                                <h3 class="fw-boldest mb-3">Order Summary</h3>
                                                @if($val->size!=null)
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">{{__('Size')}}:</span>
                                                    <span>{{$val->size}}</span>
                                                </div>
                                                @endif
                                                @if($val->color!=null)
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">{{__('Color')}}:</span>
                                                    <span>{{$val->color}}</span>
                                                </div>
                                                @endif
                                                @if($val->length!=null)
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">{{__('Length')}}:</span>
                                                    <span>{{$val->length}}</span>
                                                </div>
                                                @endif
                                                @if($val->weight!=null)
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">{{__('Weight')}}:</span>
                                                    <span>{{$val->weight}}</span>
                                                </div>
                                                @endif
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">Quantity:</span>
                                                    <span>{{$val->quantity}}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">Item Total:</span>
                                                    <span>{{$currency->symbol}}{{number_format($val->amount*$val->quantity, 2)}}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                                                    <span class="me-2">Delivery:</span>
                                                    <span>{{$currency->symbol}}{{number_format($val->shipping_fee, 2)}}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fw-boldest mt-2">
                                                    <h4 class="fw-boldest me-2">Tax:</h4>
                                                    <span>{{$currency->symbol}}{{number_format($val->tax, 2)}}</span>
                                                </div>
                                                <div class="d-flex justify-content-between fw-boldest mt-2">
                                                    <h4 class="fw-boldest me-2">Grand Total:</h4>
                                                    <span>{{$currency->symbol}}{{number_format($val->total, 2)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 mb-10 mb-xl-0 mt-3">
                                                <div class="tt-rating">
                                                    <i class="fal fa-star @if($val->rating>0) checked @endif"></i>
                                                    <i class="fal fa-star @if($val->rating>1) checked @endif"></i>
                                                    <i class="fal fa-star @if($val->rating>2) checked @endif"></i>
                                                    <i class="fal fa-star @if($val->rating>3) checked @endif"></i>
                                                    <i class="fal fa-star @if($val->rating>4) checked @endif"></i>
                                                </div>
                                                <div class="fs-5 fw-bold text-gray-600">
                                                    @if($val->review==null)
                                                    {{__('No review')}}
                                                    @else
                                                    {{$val->review}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{route('store.order.status', ['id'=>$val->id])}}" method="post">
                                            @csrf
                                            <div class="row mb-6">
                                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Order Status')}}</label>
                                                <div class="col-lg-12">
                                                    <select name="order_status" class="form-select form-select-solid" required>
                                                        <option value="" data-select2-id="select2-data-6-31tw">Select an order status...</option>
                                                        <option value="Order Processed" @if($val->order_status=="Order Processed") selected @endif>Order Processed</option>
                                                        <option value="In Transit" @if($val->order_status=="In Transit") selected @endif>In Transit</option>
                                                        <option value="With Courier" @if($val->order_status=="With Courier") selected @endif>With Courier</option>
                                                        <option value="Delivered" @if($val->order_status=="Delivered") selected @endif>Delivered</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <div class="modal-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary px-6">{{__('Update Order Status')}}</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @if(route('user.shipping')==url()->current())
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="row g-5 g-xxl-8">
                    <div class="card">
                        <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                            <div class="card-title flex-column">
                                <p class="m-0">Shipping regions</p>
                            </div>
                            <div class="card-toolbar">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#ship_create" class="btn btn-info btn-color-light btn-sm">{{__('Add Shipping Fee')}}</a>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th class="min-w-25px"></th>
                                        <th class="min-w-80px">{{__('State/county')}}</th>
                                        <th class="min-w-50px">{{__('Amount')}}</th>
                                        <th class="min-w-50px">{{__('Status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($user->shipping())
                                        @foreach($user->shipping() as $k=>$val)
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
                                                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#ship_edit{{$val->id}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#ship_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                                    </div>
                                                </td>
                                                <td>{{$val->shippingState->name ?? NULL }}</td>
                                                <td>{{$currency->symbol.($val->amount ?? NULL)}}</td>
                                                <td>@if($val->status && $val->status==1)Active @else Disabled @endif</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach($user->shipping() as $k=>$val)
                    <div class="modal fade" tabindex="-1" id="ship_delete{{$val->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('Delete Region')}}</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="svg-icon svg-icon-2x"></span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('Are you sure you want to delete this?')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('delete.shipping', ['id' => $val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="ship_edit{{$val->id}}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('edit.shipping')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Edit Shipping fee')}}</h3>
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                            <span class="svg-icon svg-icon-2x">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="modal-body py-10">
                                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px" style="max-height: 521px;">
                                            <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                                <label class="required fs-5 fw-bold mb-2">{{__('State/county')}}</label>
                                                <select id="state" name="state" class="form-control form-control-lg form-control-solid" data-control="select2" required>
                                                    @foreach($user->getState() as $con)
                                                    <option value="{{$con->id}}" @if($val->state==$con->id) selected @endif>{{$con->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" value="{{$val->id}}" name="id">
                                            <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                                                <div class="input-group input-group-solid">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text">{{$currency->symbol}}</span>
                                                    </span>
                                                    <input type="number" step="any" class="form-control form-control-solid" value="{{$val->amount}}" name="amount" placeholder="{{__('How much?')}}">
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Do you still ship here?')}}</label>
                                                <div class="col-lg-12">
                                                    <select name="status" class="form-select form-select-solid" required>
                                                        <option value='0' @if($val->status==0) selected @endif>No</option>
                                                        <option value='1' @if($val->status==1) selected @endif>Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex-center">
                                        <button type="submit" class="btn btn-success btn-block">{{__('Edit Shipping fee')}}</button>
                                    </div>
                                    <div></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
@stop
@section('script')
<script>
    jQuery(document).ready(function($) {
        $('.clickable-row').on("click", function() {
            window.location.href = $(this).data('href');
        });
    });
    $("select").select2({
        tags: true
    });
</script>
<script>
    'use strict';
    var input2 = document.querySelector("#meta_keywords");
    new Tagify(input2);
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var element = document.getElementById('kt_chart_earning');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-info');
        var lightColor = KTUtil.getCssVariableValue('--bs-light-info');

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'Net Profit',
                data: [<?php foreach ($user->orderForTheMonth() as $val) {
                            echo $val->total . ',';
                        } ?>]
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'area',
                height: height,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                sparkline: {
                    enabled: !0
                }
            },
            plotOptions: {

            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 0.5,
                colors: [baseColor]
            },
            xaxis: {
                categories: [<?php foreach ($user->orderForTheMonth() as $val) {
                                    echo "'" . date("M j", strtotime($val->updated_at)) . "'" . ',';
                                } ?>],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: baseColor,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function(val) {
                        return '@php echo $currency->symbol; @endphp' + val
                    }
                }
            },
            colors: [lightColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    });
</script>
@endsection
