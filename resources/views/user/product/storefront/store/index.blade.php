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
        <li class="breadcrumb-item text-dark">{{__('Storefront')}}</li>
      </ul>
    </div>
    <div class="d-flex py-2">
      @if(count($user->storefrontCount())>0)
      <a href="{{route('website.link', ['id' => $user->storefront()->store_url])}}" target="_blank" class="btn btn-dark me-4"><i class="fal fa-store"></i> {{__('My Store')}}</a>
      @endif
      @if(1>count($user->storefrontCount()))
      <a href="{{route('new.store')}}" class="btn btn-dark">{{__('Create storefront')}}</a>
      @endif
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
                    <select name="state" class="form-select form-select-solid" required>
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
      <div class="modal fade" id="coupon_create" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
          <div class="modal-content">
            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('submit.coupon')}}" enctype="multipart/form-data" method="post">
              @csrf
              <div class="modal-header">
                <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Create Coupon')}}</h3>
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
                    <label class="required fs-5 fw-bold mb-2">{{__('Name')}}</label>
                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Name')}}" name="name" required>
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="required fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                    <input type="number" class="form-control form-control-solid" placeholder="{{__('Limit')}}" name="limits" required>
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="required fs-5 fw-bold mb-2">{{__('Discount type')}}</label>
                    <select name="type" id="discount_type" class="form-select form-select-solid" required>
                      <option value="">{{__('How will you reward customers')}}</option>
                      <option value="1">{{__('Fiat')}}</option>
                      <option value="2">{{__('Percent off')}}</option>
                    </select>
                  </div>
                  <div id="fiat_amount_div" style="display:none;">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                      <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                      <div class="input-group input-group-solid">
                        <span class="input-group-prepend">
                          <span class="input-group-text">{{$currency->symbol}}</span>
                        </span>
                        <input type="number" step="any" class="form-control form-control-solid" id="fiat_amount" name="fiat_amount" placeholder="{{__('How much?')}}">
                      </div>
                    </div>
                  </div>
                  <div id="percent_amount_div" style="display:none;">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                      <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                      <div class="input-group input-group-solid">
                        <input type="number" step="any" max="99" class="form-control form-control-solid" id="percent_amount" name="percent_amount" placeholder="{{__('How much?')}}">
                        <span class="input-group-prepend">
                          <span class="input-group-text">%</span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="fs-5 fw-bold mb-2">{{__('Code')}}</label>
                    <div class="input-group input-group-solid">
                      <input type="text" id="auto-code" class="form-control form-control-solid" name="code" placeholder="{{__('Code?')}}" required>
                      <span class="input-group-prepend">
                        <span class="input-group-text" id="code-generate">{{__('Generate')}}</span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer flex-center">
                <button type="submit" class="btn btn-success btn-block">{{__('Create Coupon')}}</button>
              </div>
              <div></div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="test_email" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
          <div class="modal-content">
            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('test.store.mail', ['id'=>$user->storefront()->id])}}" enctype="multipart/form-data" method="post">
              @csrf
              <div class="modal-header">
                <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Test Email Configuration')}}</h3>
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
                    <label class="required fs-5 fw-bold mb-2">{{__('Email')}}</label>
                    <input type="email" class="form-control form-control-solid" placeholder="{{__('Email')}}" name="email" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer flex-center">
                <button type="submit" class="btn btn-success btn-block">{{__('Send Email')}}</button>
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
    @if(count($user->storefrontCount())>0)
    @if($user->storefront()->user->display_support_email!=1 || $user->storefront()->user->display_support_phone!=1)
    <div class="notice d-flex bg-light-info rounded border border-info rounded p-6 mb-8">
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
          <div class="fs-6 text-dark pe-7">{{__('For the security of everyone on tryba, please update your support information and enable show email and phone to access storefront')}}</div>
        </div>
        <a href="{{route('user.preferences')}}" class="btn btn-info px-6 align-self-center text-nowrap">{{__('Setup')}}</a>
      </div>
    </div>
    @endif
    @endif
    @if($user->productCount()>0)
    <div class="notice d-flex bg-light-info rounded border border-info rounded p-6 mb-8">
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
          <a href="{{route('user.storefront')}}" class="nav-link text-active-primary px-3 @if(route('user.storefront')==url()->current()) active @endif">@if(count($user->storefrontCount())>0){{_('Store Dashboard')}}@else Storefront @endif</a>
        </li>
        @if(count($user->storefrontCount())>0)
        <li class="nav-item">
          <a href="{{route('user.storefront.customize')}}" class="nav-link text-active-primary px-3 @if(route('user.storefront.customize')==url()->current()) active @endif">{{__('Settings')}}</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.storefront.theme')}}" class="nav-link text-active-primary px-3 @if(route('user.storefront.theme')==url()->current()) active @endif">{{__('Templates')}}</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.storefront.customer')}}" class="nav-link text-active-primary px-3 @if(route('user.storefront.customer')==url()->current()) active @endif">{{__('Customers')}} ({{count($user->storefrontCustomer($user->storefront()->id))}})</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.product')}}" class="nav-link text-active-primary px-3 @if(route('user.product')==url()->current()) active @endif">{{__('Products')}} ({{count($user->product())}})</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.list')}}" class="nav-link text-active-primary px-3 @if(route('user.list')==url()->current()) active @endif">{{__('Orders')}} ({{count($user->orders())}})</a>
        </li>
        @endif
      </ul>
    </div>
    @if(route('user.storefront')==url()->current())
    @if(count($user->shipping())==0)
    <div class="notice d-flex bg-light-primary rounded border border-primary rounded p-6 mb-8">
      <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
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
        <a href="{{route('user.shipping')}}" class="btn btn-primary px-6 align-self-center text-nowrap">{{__('Setup')}}</a>
      </div>
    </div>
    @endif
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="col-md-8">
            @if(count($user->storefrontCount())>0)
            <div class="card mb-6">
              <div class="card-header align-items-center border-0 mt-2 border-0">
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
              <div class="card-header align-items-center border-0 mt-2 border-0">
                <h3 class="fw-boldest text-dark fs-6x">{{__('Top 5 sold products')}}</h3>
              </div>
              <div class="card-body pt-3">
                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                  <thead>
                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                      <th class="min-w-25px"></th>
                      <th class="min-w-25px">{{__('Name')}}</th>
                      <th class="min-w-70px">{{__('Sold')}}</th>
                      <th class="min-w-50px">{{__('Current Stock')}}</th>
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
                          <div class="menu-item px-3"><a target="_blank" href="{{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}" class="menu-link px-3">{{__('Preview')}}</a></div>
                          <div class="menu-item px-3"><a href="{{route('orders', ['id' => $val->id])}}" class="menu-link px-3">{{__('Orders')}}</a></div>
                          <div class="menu-item px-3"><a href="{{route('edit.product', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                          <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#product_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                        </div>
                      </td>
                      <td data-href="{{route('edit.product', ['id' => $val->ref_id])}}">
                        <div class="d-flex">
                          <div class="symbol symbol-70px me-6 bg-light">
                            @if($val->new == 0)
                            <img src="{{asset('asset/images/product-placeholder.jpg')}}" alt="image">
                            @else
                            @php
                            $image=App\Models\Productimage::whereproductId($val->id)->first();
                            @endphp
                            <img alt="image" src="{{asset('asset/profile/'.$image->image)}}">
                            @endif
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <div class="mb-1 text-gray-800">{{$val->name}}</div>
                            @if(checkCategory($val->cat_id)==0)
                            <span class="badge badge-warning">{{__('Add category')}}</span>
                            @else
                            <div class="fw-bold text-gray-400">{{$val->cat->name}}</div>
                            @endif
                          </div>
                        </div>
                      </td>
                      <td data-href="{{route('edit.product', ['id' => $val->ref_id])}}">{{$val->sold}}</td>
                      <td data-href="{{route('edit.product', ['id' => $val->ref_id])}}">{{$val->quantity}}</td>
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
                          <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}">
                          <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}">Copy Link</button>
                        </div>
                        <!--end::Title-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Actions-->
                      <div class="d-flex">
                        <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}" class="btn btn-light-primary w-100">
                          <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>
                        <a target="_blank" href="https://wa.me/{{$val->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}" class="btn btn-icon btn-success mx-6 w-100">
                          <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}</a>
                      </div>
                      <!--end::Actions-->
                      <!--begin::Input group-->
                      <div class="text-center px-5 mt-8">
                        <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                        {!! QrCode::eye('circle')->style('round')->size(250)->generate(route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])); !!}
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
            @endif
          </div>
          <div class="col-md-4">
            <div class="card mb-6">
              <div class="card-header align-items-center border-0 mt-5 border-0">
                <h3 class="fw-boldest text-dark fs-6x">{{__('Custom domain')}}</h3>
                <p class="text-dark-400 fw-bold fs-5">{{__('To connect your domain, you need to log in to your provider account and change your settings. Follow the provider step-by-step instructions to get started')}}, <a href="{{route('user.store.custom.domain')}}">click here</a></p>
              </div>
              <form action="{{route('edit.domain', ['id'=>$user->storefront()->id])}}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  @csrf
                  <input type="url" class="form-control form-control-solid mb-3" name="custom_domain" placeholder="{{__('https://mydomain.com')}}" value="{{$user->storefront()->custom_domain}}">
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9 border-0">
                  <button type="submit" class="btn btn-primary btn-block px-6">
                    @if($user->storefront()->custom_domain==null)
                    {{__('Add csutom domain')}}
                    @else
                    {{__('Update custom domain')}}
                    @endif
                  </button>
                </div>
              </form>
            </div>
            <div class="card">
              <div class="card-body">
                <h3 class="fw-boldest text-dark fs-6x">{{__('Share')}}</h3>
                <p class="text-dark-400 fw-bold fs-5">{{__('Share store with friends, family & customers')}}</p>
                @if(count($user->storefrontCount())>0)
                <div class="mw-lg-600px mx-auto">
                  <!--begin::Heading-->

                  <!--end::Heading-->
                  <!--begin::Input group-->
                  <div class="mb-10">
                    <!--begin::Title-->
                    <div class="d-flex mb-2">
                      <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('website.link', ['id' => $user->storefront()->store_url])}}">
                      <button data-clipboard-text="{{route('website.link', ['id' => $user->storefront()->store_url])}}" class="castro-copy btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light">
                        <!--begin::Svg Icon | path: icons/duotone/General/Copy.svg-->
                        <span class="svg-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z" fill="#B5B5C3" />
                          </svg>
                        </span>
                        <!--end::Svg Icon-->
                      </button>
                    </div>
                    <!--end::Title-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Actions-->
                  <div class="d-flex">
                    <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-light-primary w-100">
                      {{__('Send Email')}}</a>
                    <a target="_blank" href="https://wa.me/{{$user->storefront()->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-success mx-6 w-100">
                      {{__('Whatsapp')}}</a>
                  </div>
                  <!--end::Actions-->
                  <!--begin::Input group-->
                  <div class="text-center px-5 mt-8">
                    <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                    {!! QrCode::eye('circle')->style('round')->size(150)->generate(route('website.link', ['id' => $user->storefront()->store_url])); !!}
                  </div>
                  <!--end::Input group-->
                </div>
                @endif
              </div>
            </div>
          </div>
          @if(count($user->storefrontCount())>0)
          <div class="modal fade" id="store_share{{$user->storefront()->id}}" tabindex="-1" aria-modal="true" role="dialog">
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

                  <!--end::Wrapper-->
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endif
    @if(route('user.storefront.customer')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-25px"></th>
                    <th class="min-w-80px">{{__('Name')}}</th>
                    <th class="min-w-70px">{{__('Email')}}</th>
                    <th class="min-w-50px">{{__('Phone')}}</th>
                    <th class="min-w-100px">{{__('Created')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($user->storefrontCount())>0)
                  @foreach($user->storefrontCustomer($user->storefront()->id) as $val)
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
                        <div class="menu-item px-3"><a href="{{route('customer.orders', ['id' => $val->id])}}" class="menu-link px-3">{{__('Orders')}}</a></div>
                      </div>
                    </td>
                    <td>{{$val->first_name.' '.$val->last_name}}</td>
                    <td>{{$val->email}}</td>
                    <td>{{$val->phone}}</td>
                    <td>{{$user->storefront()->created_at->diffforHumans()}}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          @if(count($user->storefrontCount())>0)
          <div class="modal fade" id="store_share{{$user->storefront()->id}}" tabindex="-1" aria-modal="true" role="dialog">
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
                      <div class="text-dark-400 fw-bold fs-4">{{__('Share store with friends, family & customers')}}</div>
                      <!--end::Description-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Input group-->
                    <div class="mb-10">
                      <!--begin::Title-->
                      <div class="d-flex">
                        <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('website.link', ['id' => $user->storefront()->store_url])}}">
                        <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('website.link', ['id' => $user->storefront()->store_url])}}">Copy Link</button>
                      </div>
                      <!--end::Title-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="d-flex">
                      <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-light-primary w-100">
                        <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>
                      <a target="_blank" href="https://wa.me/{{$user->storefront()->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-icon btn-success mx-6 w-100">
                        <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}</a>
                    </div>
                    <!--end::Actions-->
                    <!--begin::Input group-->
                    <div class="text-center px-5 mt-8">
                      <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                      {!! QrCode::eye('circle')->style('round')->size(250)->generate(route('website.link', ['id' => $user->storefront()->store_url])); !!}
                    </div>
                    <!--end::Input group-->
                  </div>
                  <!--end::Wrapper-->
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endif
    @if(route('user.storefront.customize')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <form action="{{route('edit.store', ['id'=>$user->storefront()->id])}}" method="post" enctype="multipart/form-data">
              <div class="card-body px-9 pt-6 pb-4">
                @csrf
                <input type="hidden" value="{{$user->storefront()->id}}" name="id">
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="required fs-5 fw-bold mb-2">{{__('Store title')}}</label>
                  <input type="text" class="form-control form-control-solid" value="{{$user->storefront()->store_name}}" placeholder="{{__('The name of your store')}}" name="store_name" required>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="required fs-5 fw-bold mb-2">{{__('Store description')}}</label>
                  <textarea class="form-control form-control-solid" rows="5" name="store_desc" type="text" placeholder="{{__('Store Description')}}" required>{{$user->storefront()->store_desc}}</textarea>
                </div>
                <div class="row mb-5">
                  <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Products per page')}}</label>
                  <div class="col-lg-12">
                    <select name="product_per_page" class="form-select form-select-solid" required>
                      <option value="" data-select2-id="select2-data-6-31tw">Select number of products per page...</option>
                      <option value="8" @if($user->storefront()->product_per_page=="8") selected @endif>8</option>
                      <option value="16" @if($user->storefront()->product_per_page=="16") selected @endif>16</option>
                      <option value="32" @if($user->storefront()->product_per_page=="32") selected @endif>32</option>
                      <option value="64" @if($user->storefront()->product_per_page=="64") selected @endif>64</option>
                      <option value="128" @if($user->storefront()->product_per_page=="128") selected @endif>128</option>
                      <option value="256" @if($user->storefront()->product_per_page=="256") selected @endif>256</option>
                    </select>
                  </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="fs-5 fw-bold mb-2">{{__('Value added tax')}}</label>
                  <div class="input-group input-group-solid">
                    <input type="number" steps="any" class="form-control form-control-solid" value="{{$user->storefront()->tax}}" placeholder="VAT" name="tax">
                    <span class="input-group-append">
                      <span class="input-group-text">%</span>
                    </span>
                  </div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="fs-5 fw-bold mb-2">{{__('Google analytic')}}</label>
                  <input type="text" maxlength="14" class="form-control form-control-solid" value="{{$user->storefront()->analytics}}" placeholder="UA-XXXXXXXXX-X" name="analytics">
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="fs-5 fw-bold mb-2">{{__('Facebook pixel')}}</label>
                  <input type="text" maxlength="12" class="form-control form-control-solid" value="{{$user->storefront()->facebook_pixel}}" placeholder="UA-0000000-0" name="facebook_pixel">
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="required fs-5 fw-bold mb-2">{{__('Meta keywords')}}</label>
                  <input type="text" id="meta_keywords" class="form-control form-control-solid" required value="{{$user->storefront()->meta_keywords}}" placeholder="{{__('Meta keywords')}}" name="meta_keywords">
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="required fs-5 fw-bold mb-2">{{__('Meta description')}}</label>
                  <textarea type="text" class="form-control form-control-solid" required placeholder="{{__('Meta description')}}" name="meta_description">{{$user->storefront()->meta_description}}</textarea>
                </div>
                <div class="row mb-6">
                  <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Store status')}}</label>
                  <div class="col-lg-12">
                    <select name="status" class="form-select form-select-solid" required>
                      <option value='0' @if($user->storefront()->status==0) selected @endif>Store is disabled</option>
                      <option value='1' @if($user->storefront()->status==1) selected @endif>Store is active</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-6">
                  <div class="col-lg-12">
                    <div class="form-check form-check-solid mb-6">
                      <input name="checkout_logo" class="form-check-input" type="checkbox" id="customCheckLoging7" value="1" @if($user->checkout_logo==1)checked @endif>
                      <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoging7">{{__('Show logo')}}</label>
                    </div>
                    <div class="form-check form-check-solid mb-6">
                      <input name="display_category" class="form-check-input" type="checkbox" id="customCheckLogindhh" value="1" @if($user->storefront()->display_category==1)checked @endif>
                      <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLogindhh">{{__('Display product category')}}</label>
                    </div>
                    <div class="form-check form-check-solid mb-6">
                      <input name="display_related_products" class="form-check-input" type="checkbox" id="customCheckLoginxdhh" value="1" @if($user->storefront()->display_related_products==1)checked @endif>
                      <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginxdhh">{{__('Display related product')}}</label>
                    </div>
                    <div class="form-check form-check-solid mb-6">
                      <input name="display_blog" class="form-check-input" type="checkbox" id="customBlog" value="1" @if($user->storefront()->display_blog==1)checked @endif>
                      <label class="form-check-label fw-bold ps-2 fs-6" for="customBlog">{{__('Display blog')}}</label>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <p class="fw-bold fs-6">{{__('Store logo - Default Tryba logo will be used if not provided')}}</p>
                    <div class="image-input image-input-outline mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                      <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{asset('asset/profile/'.$cast)}})"></div>
                      <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change Checkout Image">
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="avatar_remove" />
                      </label>
                      <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Checkout Image">
                        <i class="bi bi-x fs-2"></i>
                      </span>
                      <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove Checkout Image">
                        <i class="bi bi-x fs-2"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
              </div>
            </form>
            <form action="{{route('edit.store.mail', ['id'=>$user->storefront()->id])}}" method="post">
              @csrf
              <div class="card-body">
                <div class="accordion accordion-icon-toggle mb-8" id="kt_accordion_1">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_2">
                      <button class="accordion-button fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_2">
                        {{__('Mail Configuration')}}
                      </button>
                    </h2>
                    <div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                      <div class="accordion-body">
                        <div class="card-body">
                          <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('What email smtp configuration will you be using?')}}</label>
                            <div class="col-lg-12">
                              <select name="mail" class="form-select form-select-solid" required>
                                <option value='0' @if($user->storefront()->mail==0) selected @endif>Tryba</option>
                                <option value='1' @if($user->storefront()->mail==1) selected @endif>My Email Configuration</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mb-6">
                            <div class="col-lg-6">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail Host')}}</label>
                              <input type="text" placeholder="smtp.com" value="{{$user->storefront()->mail_host}}" class="form-control form-control-solid" name="mail_host" required>
                            </div>
                            <div class="col-lg-6">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail Port')}}</label>
                              <input type="text" placeholder="465" value="{{$user->storefront()->mail_port}}" class="form-control form-control-solid" name="mail_port" required>
                            </div>
                            <div class="col-lg-6">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail Username')}}</label>
                              <input type="email" placeholder="username" value="{{$user->storefront()->mail_username}}" class="form-control form-control-solid" name="mail_username" required>
                            </div>
                            <div class="col-lg-6">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail Password')}}</label>
                              <input type="password" placeholder="password" value="{{$user->storefront()->mail_password}}" class="form-control form-control-solid" name="mail_password" required>
                            </div>
                            <div class="col-lg-6">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail Encryption')}}</label>
                              <input type="text" placeholder="SSL/TLS" value="{{$user->storefront()->mail_encryption}}" class="form-control form-control-solid" name="mail_encryption" required>
                            </div>
                            <div class="col-lg-6">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail From Address')}}</label>
                              <input type="email" placeholder="email address" value="{{$user->storefront()->mail_from_address}}" class="form-control form-control-solid" name="mail_from_address" required>
                            </div>
                            <div class="col-lg-12">
                              <label class="col-form-label fw-bold fs-6">{{__('Mail From Name')}}</label>
                              <input type="text" placeholder="sender name" value="{{$user->storefront()->mail_from_name}}" class="form-control form-control-solid" name="mail_from_name" required>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                          @if($user->storefront()->mail==1)
                          <a href="#" data-bs-toggle="modal" data-bs-target="#test_email" class="btn btn-success px-6 me-2">{{__('Test SMTP')}}</a>
                          @endif
                          <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endif
    @if(route('user.storefront.theme')==url()->current())
    <div class="row g-xl-8">
      @foreach(App\Models\Storefront::themes() as $key => $val)
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
              @if($key==$user->storefront()->theme_id)
              <a href="{{route('theme.edit.store')}}" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow">
                <i class="bi bi-pencil-fill fs-7"></i>
              </a>
              @endif
            </div>
            <div class="pt-5 pb-5">
              <div class="bgi-no-repeat bgi-size-cover rounded min-h-250px" style="background-image:url({{$val['img_path']}});"></div>
            </div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#theme{{$key}}" class="btn btn-block btn-light-info mt-3">
              <i class="fal fa-eye fs-7"></i> Preview
            </a>
            <div class="modal fade" tabindex="-1" id="theme{{$key}}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">{{__('Preview')}}</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                      <span class="svg-icon svg-icon-2x"></span>
                    </div>
                  </div>
                  <div class="modal-body">
                    <img src="{{$val['img_path']}}" style="height:auto; max-width:100%">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
    @if(route('user.store.custom.domain')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="card mb-5 mb-xxl-8">
          <div class="card-body">
            <ol>
              <li>Changing your nameserver is needed to point your custom domain to tryba.io.</li>
              <li>If you can't find the place to change your nameserver in your domain registrar account, then please contact your domain registrar support, they will show you the place to change nameservers for your custom domain</li>
              <li>On your domain provider’s website, log in to your account.</li>
              <li>Find the Name server settings.</li>
              <li>Change the following records:
                <ol>
                  <li>Point your nameservers to the Tryba Nameserver.
                    <ul>
                      @foreach(getNameServers() as $ns)
                      @if($ns['type']=="NS")
                      <li>{{$ns['target']}}</li>
                      @endif
                      @endforeach
                    </ul>
                  </li>
                  {{--<li>If necessary, change the Host name to the @ symbol.</li>
                  <li>Delete any other A records on the domain if there are any present.</li>
                  <li>Point the CNAME record with the name www to tryba.io</li>--}}
                  <li>Wait for 24-48hrs for domain to propagate</li>
                </ol>
              </li>
              <li>Navigate to storefront dashboard</li>
              <li>Add your custom domain</li>
              <li>Save your changes</li>
              <li>Click the button below to verify your nameservers point to ours</li>
            </ol>
            <div class="col-md-12"><a href="{{route('user.store.custom.domain.verify')}}" class="btn btn-light-info btn-block me-2">{{__('Verify Nameserver Connection')}}</a></div>
          </div>
        </div>
      </div>
    </div>
    @endif
    @if(route('user.product')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
              <div class="card-toolbar">
                <a href="{{route('new.product')}}" class="btn btn-info btn-color-light">{{__('Add a new product')}}</a>
              </div>
            </div>
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-25px"></th>
                    <th class="min-w-25px">{{__('Name')}}</th>
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
                      <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-bs-toggle="dropdown">
                        <span class="svg-icon svg-icon-3 svg-icon-primary">
                          <i class="fal fa-chevron-circle-down"></i>
                        </span>
                      </button>
                      <div class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                        <div class="menu-item px-3">
                          <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                        </div>
                        <div class="menu-item px-3"><a data-bs-toggle="modal" data-bs-target="#product_share{{$val->id}}" href="#" class="menu-link px-3">{{__('Share')}}</a></div>
                        <div class="menu-item px-3"><a target="_blank" href="{{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}" class="menu-link px-3">{{__('Preview')}}</a></div>
                        <div class="menu-item px-3"><a href="{{route('orders', ['id' => $val->id])}}" class="menu-link px-3">{{__('Orders')}}</a></div>
                        <div class="menu-item px-3"><a href="{{route('edit.product', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#product_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                      </div>
                    </td>
                    <td onclick="window.location='{{route('edit.product', ['id' => $val->ref_id])}}';">
                      <div class="d-flex">
                        <div class="symbol symbol-70px me-6 bg-light">
                          @if($val->new == 0)
                          <img src="{{asset('asset/images/product-placeholder.jpg')}}" alt="image">
                          @else
                          @php
                          $image=App\Models\Productimage::whereproductId($val->id)->first();
                          @endphp
                          <img alt="image" src="{{asset('asset/profile/'.$image->image)}}">
                          @endif
                        </div>
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
                        <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}">
                        <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}">Copy Link</button>
                      </div>
                      <!--end::Title-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="d-flex">
                      <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}" class="btn btn-light-primary w-100">
                        <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>
                      <a target="_blank" href="https://wa.me/{{$val->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])}}" class="btn btn-icon btn-success mx-6 w-100">
                        <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}</a>
                    </div>
                    <!--end::Actions-->
                    <!--begin::Input group-->
                    <div class="text-center px-5 mt-8">
                      <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                      {!! QrCode::eye('circle')->style('round')->size(250)->generate(route('sproduct.link', ['store'=>$user->storefront()->id,'product'=>$val->ref_id])); !!}
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
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
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
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">
                      <div class="d-flex">
                        <div class="symbol symbol-70px me-6 bg-light">
                          @if($val->product->new == 0)
                          <img src="{{asset('asset/images/product-placeholder.jpg')}}" alt="image">
                          @else
                          @php
                          $image=App\Models\Productimage::whereproduct_id($val->product->id)->first();
                          @endphp
                          <img alt="image" src="{{asset('asset/profile/'.$image->image)}}">
                          @endif
                        </div>
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
                          <i class="fal fa-star @if($val->product->rating()>0) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>1) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>2) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>3) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>4) checked @endif"></i>
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
                    <td>{{$val->shippingState->name}}</td>
                    <td>{{$currency->symbol.$val->amount}}</td>
                    <td>@if($val->status==1)Active @else Disabled @endif</td>
                  </tr>
                  @endforeach
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
                        <select name="state" class="form-select form-select-solid" required>
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
    @if(route('user.store.coupon')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
              <div class="card-title flex-column">
                <p class="m-0">Coupon</p>
              </div>
              <div class="card-toolbar">
                <a href="#" data-bs-toggle="modal" data-bs-target="#coupon_create" class="btn btn-info btn-color-light btn-sm">{{__('Add Coupon')}}</a>
              </div>
            </div>
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-25px"></th>
                    <th class="min-w-80px">{{__('Name')}}</th>
                    <th class="min-w-50px">{{__('Code')}}</th>
                    <th class="min-w-50px">{{__('Discount')}}</th>
                    <th class="min-w-50px">{{__('Limit')}}</th>
                    <th class="min-w-50px">{{__('Used')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user->coupon() as $k=>$val)
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
                        <div class="menu-item px-3"><a href="{{route('update.coupon', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#coupon_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                      </div>
                    </td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->code}}
                      <button data-clipboard-text="{{$val->code}}" class="castro-copy btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light">
                        <!--begin::Svg Icon | path: icons/duotone/General/Copy.svg-->
                        <span class="svg-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z" fill="#B5B5C3" />
                          </svg>
                        </span>
                        <!--end::Svg Icon-->
                      </button>
                    </td>
                    <td>@if($val->type==2){{$val->amount}}% @else {{$currency->symbol.$val->amount}} @endif</td>
                    <td>{{$val->limits}}</td>
                    <td>{{$val->used}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @foreach($user->coupon() as $k=>$val)
          <div class="modal fade" tabindex="-1" id="coupon_delete{{$val->id}}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Delete Coupon')}}</h5>
                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                  </div>
                </div>
                <div class="modal-body">
                  <p>{{__('Are you sure you want to delete this?')}}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                  <a href="{{route('delete.coupon', ['id' => $val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    @if(route('user.store.page')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
              <div class="card-title flex-column">
                <p class="m-0">{{__('Custom pages')}}</p>
              </div>
              <div class="card-toolbar">
                <a href="{{route('add.page.store')}}" class="btn btn-info btn-color-light btn-sm">{{__('Create Page')}}</a>
              </div>
            </div>
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-25px"></th>
                    <th class="min-w-80px">{{__('Title')}}</th>
                    <th class="min-w-50px">{{__('Status')}}</th>
                    <th class="min-w-50px">{{__('Date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(getStorePage($user->storefront()->id) as $k=>$val)
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
                        <div class="menu-item px-3"><a href="{{route('edit.page.store', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                      </div>
                    </td>
                    <td>{{$val->title}}</td>
                    <td>@if($val->status==1)Active @else Disabled @endif</td>
                    <td>{{$val->created_at->diffforHumans()}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @foreach(getStorePage($user->storefront()->id) as $k=>$val)
          <div class="modal fade" tabindex="-1" id="slide_delete{{$val->id}}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Delete Page')}}</h5>
                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                  </div>
                </div>
                <div class="modal-body">
                  <p>{{__('Are you sure you want to delete this?')}}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                  <a href="{{route('delete.page.store', ['id'=>$val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    @if(route('user.store.blog')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
              <div class="card-title flex-column">
                <p class="m-0">{{__('News & Articles')}}</p>
              </div>
              <div class="card-toolbar">
                <a href="{{route('add.blog.store')}}" class="btn btn-info btn-color-light btn-sm">{{__('Create Article')}}</a>
              </div>
            </div>
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-25px"></th>
                    <th class="min-w-80px">{{__('Title')}}</th>
                    <th class="min-w-50px">{{__('Status')}}</th>
                    <th class="min-w-50px">{{__('Views')}}</th>
                    <th class="min-w-50px">{{__('Date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(getStoreBlog($user->storefront()->id) as $k=>$val)
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
                        <div class="menu-item px-3"><a href="{{route('edit.blog.store', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                      </div>
                    </td>
                    <td>{{$val->title}}</td>
                    <td>@if($val->status==1)Active @else Disabled @endif</td>
                    <td>{{$val->views}}</td>
                    <td>{{$val->created_at->diffforHumans()}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @foreach(getStoreBlog($user->storefront()->id) as $k=>$val)
          <div class="modal fade" tabindex="-1" id="slide_delete{{$val->id}}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Delete Article')}}</h5>
                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                  </div>
                </div>
                <div class="modal-body">
                  <p>{{__('Are you sure you want to delete this?')}}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                  <a href="{{route('delete.blog.store', ['id'=>$val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                </div>
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
<script>
  $(document).on('click', '#code-generate', function() {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for (var i = 0; i < 10; i++) {
      result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    $('#auto-code').val(result);
  });
</script>
<script>
  function coupon() {
    var type = $("#discount_type").find(":selected").val();
    if (type == 1) {
      $('#percent_amount_div').hide();
      $('#fiat_amount_div').show();
      $('#fiat_amount').attr('required', '');
      $('#percent_amount').removeAttr('required', '');
    } else if (type == 2) {
      $('#percent_amount_div').show();
      $('#fiat_amount_div').hide();
      $('#fiat_amount').removeAttr('required', '');
      $('#percent_amount').attr('required', '');
    }
  }
  $("#discount_type").change(coupon);
</script>
@endsection