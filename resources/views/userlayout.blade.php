<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <base href="{{url('/')}}" />
  <title>{{ $title }} | {{$set->site_name}}</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
  <meta name="robots" content="index, follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
  <meta name="application-name" content="{{$set->site_name}}" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="description" content="{{$set->site_desc}}" />
  <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
  <link rel="stylesheet" href="{{config('sweetalert.animatecss')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
  <link href="{{asset('asset/new_dashboard/plugins/custom/leaflet/leaflet.bundle.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/new_dashboard/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/new_dashboard/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/quill/dist/quill.core.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/prism/prism.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/css/docs.css')}}" type="text/css">
  <link rel="stylesheet" href="{{url('/css/cards.css')}}" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{asset('asset/dashboard/date_picker.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/css/index.css')}}" type="text/css">
  {{-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> --}}
  {{-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> --}}

  @if(route('user.merchant-button')==url()->current())
  <link rel="stylesheet" href="{{asset('asset/dashboard/button/assets/css/style.css')}}" type="text/css">
  @endif
    <style>
        @yield('css')
    </style>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row">
      <div id="kt_aside" class="aside aside-default aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
        <div class="aside-logo flex-column-auto pt-9 pb-5" id="kt_aside_logo">
          <!--begin::Logo-->
          <a href="{{url('/')}}">
            <img alt="Logo" src="{{asset('asset/'.$logo->image_link)}}" class="h-auto logo-default" style="height:auto;max-width:100px;" />
            <img alt="Logo" src="{{asset('asset/'.$logo->image_link)}}" class="logo-minimize" style="height:auto;max-width:100px;" />
          </a>
          <!--end::Logo-->
        </div>
        <div class="aside-menu flex-column-fluid">
          <!--begin::Aside Menu-->
          <!--begin::Menu-->
          <div class="menu menu-column menu-fit menu-rounded menu-title-dark menu-icon-dark menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
            <div class="menu-fit hover-scroll-y me-lg-n5 pe-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="20px" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer">
              <div class="menu-item">
                <a class="menu-link @if(route('user.dashboard')==url()->current()) active @endif" href="{{route('user.dashboard')}}">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-house-user"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Dashboard')}}</span>
                </a>
              </div>
              <div class="menu-item">
                <div class="menu-content">
                  <span class="fw-bold text-muted text-uppercase fs-7">{{__('Business')}}</span>
                </div>
              </div>
              @if(!empty($user->website))
                <div class=" menu-item">
                  <a class="menu-link @if(route('website.settings') == url()->current() || route('website.widgets') == url()->current() || route('user.appointment.completed') == url()->current()  || route('user.appointment.pending') == url()->current() ||  route('user.services') == url()->current() ) active @endif" href="{{route('user.appointment')}}">
                    <span class="menu-icon">
                      <div class="symbol symbol-35px me-4">
                        <span class="symbol-label">
                          <i class="fal fa-globe"></i>
                        </span>
                      </div>
                    </span>
                    <span class="menu-title text-dark">{{__('Website')}} <span class="badge bg-danger-secondary ms-3">Coming Soon</span></span>
                  </a>
                </div>
              @else
              <div class=" menu-item">
                <a class="menu-link @if(route('new.website') ==url()->current()) active @endif" href="javascript:void(0)">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-globe"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Website')}} <span class="badge bg-danger-secondary ms-3">Coming Soon</span></span>
                </a>
              </div>
              @endif
              @if(count($user->storefrontCount()) > 0)
                <div class="menu-item">
                  <a class="menu-link @if(route('user.ecommerce') == url()->current() || route('user.storefront.themes') == url()->current() || route('website.customer') == url()->current() || route('user.product')==url()->current() ||  route('user.list')==url()->current() || route('user.shipping')==url()->current()) active @endif" href="{{route('user.ecommerce')}}">
                    <span class="menu-icon">
                      <div class="symbol symbol-35px me-4">
                        <span class="symbol-label">
                          <i class="fal fa-store"></i>
                        </span>
                      </div>
                    </span>
                    <span class="menu-title text-dark">{{__('Storefront')}} <span class="badge bg-danger-secondary ms-3">Coming Soon</span></span>
                  </a>
                </div>
              @else
                <div class=" menu-item">
                  <a class="menu-link @if(route('new.createStore')==url()->current()) active @endif" href="javascript:void(0)">
                    <span class="menu-icon">
                      <div class="symbol symbol-35px me-4">
                        <span class="symbol-label">
                          <i class="fal fa-store"></i>
                        </span>
                      </div>
                    </span>
                    <span class="menu-title text-dark">{{__('Storefront')}} <span class="badge bg-danger-secondary ms-3">Coming Soon</span></span>
                  </a>
                </div>
              @endif
              @if(($set->invoice==1 && $xf->invoice==1) || ($set->donation==1 && $xf->donation==1))
              <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(route('user.invoice')==url()->current() || route('expense.dashboard')==url()->current() || route('user.sclinks')==url()->current() || route('user.customer')==url()->current() || route('user.add-customer')==url()->current()) hover show @endif">
                <span class="menu-link">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-briefcase"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Business tools')}}</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion @if(route('user.invoice')==url()->current() || route('expense.dashboard')==url()->current() || route('user.sclinks')==url()->current() || route('user.customer')==url()->current() || route('user.add-customer')==url()->current()) show @endif" kt-hidden-height="117" style="">
                  @if($set->invoice==1 && $xf->invoice==1)
                  <div class="menu-item">
                    <a class="menu-link" href="{{route('user.invoice')}}">
                      <span class="menu-title @if(route('user.invoice')==url()->current() || route('user.customer')==url()->current() || route('user.add-customer')==url()->current()) text-primary @else text-dark @endif">{{__('Invoice')}}</span>
                    </a>
                  </div>
                  @endif
                  @if($set->donation==1 && $xf->donation==1)
                  <div class="menu-item">
                    <a class="menu-link" href="{{route('user.sclinks')}}">
                      <span class="menu-title @if(route('user.sclinks')==url()->current()) text-primary @else text-dark @endif">{{__('Gigpot')}}</span>
                    </a>
                  </div>
                  <div class="menu-item">
                    <a class="menu-link" href="javascript:void(0)">
                      <span class="menu-title @if(route('expense.dashboard')==url()->current()) text-primary @else text-dark @endif">{{__('Expense tools')}} <span class="badge bg-danger-secondary ms-3">Coming Soon</span></span>
                    </a>
                  </div>
                  @endif
                </div>
              </div>
              @endif
              <div class="menu-item">
                <a class="menu-link @if(route('user.transactions')==url()->current()) active @endif" href="{{route('user.transactions')}}">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-exchange"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Transactions')}}</span>
                </a>
              </div>
              <div class="menu-item">
                <div class="menu-content">
                  <span class="fw-bold text-muted text-uppercase fs-7">{{__('Accounts')}}</span>
                </div>
              </div>
              <div class="menu-item">
                <a class="menu-link @if(route('user.ticket')==url()->current()) active @endif" href="https://helpdesk.tryba.io">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-user-headset"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Support')}}</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link @if(route('user.merchant')==url()->current()||route('user.merchant-api')==url()->current()||route('user.merchant-html')==url()->current()||route('user.merchant-plugin')==url()->current()||route('user.merchant-button')==url()->current()) active @endif" href="javascript:void(0)">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-laptop-code"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Developers')}} <span class="badge bg-danger-secondary ms-3">Coming Soon</span></span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link @if(route('user.profile')==url()->current()) active @endif" href="{{route('user.profile')}}">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-cog"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Global Settings')}}</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="{{route('user.logout')}}">
                  <span class="menu-icon">
                    <div class="symbol symbol-35px me-4">
                      <span class="symbol-label">
                        <i class="fal fa-sign-out"></i>
                      </span>
                    </div>
                  </span>
                  <span class="menu-title text-dark">{{__('Log out')}}</span>
                </a>
              </div>
            </div>
          </div>
          <!--end::Menu-->
        </div>
        <div class="aside-footer flex-column-auto" id="kt_aside_footer"></div>
      </div>
    </div>
  </div>
  <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!---media query head-->
      <!---media query  head-->
    <!--begin::Header-->
    <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
      <!--begin::Container-->

      <div class="container-fluid d-flex align-items-stretch justify-content-between kook">
        <!--begin::Logo bar-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
          <!--begin::Logo-->
          <a href="{{url('/')}}" class="d-lg-none">
            <img alt="Logo" src="{{asset('asset/'.$logo->image_link2)}}" class="mh-40px" />
          </a>
          <!--end::Logo-->
          <!--end::Aside toggler-->
        </div>
        <!--end::Logo bar-->
        <!--begin::Topbar-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
          <!--begin::Search-->
          <div class="d-flex align-items-stretch">
            <!--begin::Search-->
            <div id="kt_header_search" class="d-flex align-items-center w-lg-400px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start" data-kt-menu-flip="bottom">

              <!--begin::Form-->
              <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off" action="{{route('search')}}" method="post">
                @csrf
                <!--begin::Hidden input(Added to disable form autocomplete)-->
                <input type="hidden" />
                <!--end::Hidden input-->
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-dark position-absolute top-50 translate-middle-y ms-0">
                  <i class="fal fa-search text-dark"></i>
                </span>
                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Input-->
                <input type="text" class="form-control form-control-flush ps-10" name="search" required value="" placeholder="{{__('Search for Transactions')}}" data-kt-search-element="input" />
                <!--end::Input-->
                <!--begin::Spinner-->
                <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
                  <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                </span>
                <!--end::Spinner-->
                <!--begin::Reset-->
                <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
                  <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                  <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                        <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                      </g>
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </span>
                <!--end::Reset-->
              </form>
              <!--end::Form-->
            </div>
            <!--end::Search-->
          </div>
          <!--end::Search-->
          <!--begin::Toolbar wrapper-->
          <div class="d-flex align-items-stretch flex-shrink-0">
            <!--begin::User-->
            <div class="d-flex align-items-center ms-1 ms-lg-3">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bugPopup"  class="btn bg-danger-secondary text-light me-4"><i class="fal fa-bug text-light"></i> {{__('Report a problem')}}</a>
            </div>
            <div class="d-flex align-items-center ms-1 ms-lg-3">
              <label class="me-2 switch">
                <input type="checkbox" onclick="changeMode()" @if($user->live==1) checked @endif>
                <span class="slider round"></span>
              </label>
              <span class="me-2 text-md @if($user->live==1) text-dark @else text-dark @endif">{{__('Live')}}</span>
            </div>
            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
              <!--begin::Menu wrapper-->
              <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                <i class="fal fa-user-circle fa-2x text-info"></i>
              </div>
              <!--begin::Menu-->
              <div class="menu menu-sub menu-sub-dropdown menu-column w-300px" data-kt-menu="true">
                <!--begin::Row-->
                <div class="row row-cols-2 g-0">
                  <!--begin::Col-->
                  <a href="https://helpdesk.tryba.io/" class="col text-center border-bottom border-end py-10 rounded-0">
                    <i class="fal fa-user-headset fa-2x text-indigo"></i>
                    <span class="fw-bolder fs-6 d-block pt-3 text-dark">{{__('Support')}}</span>
                  </a>
                  <!--end::Col-->
                  <!--begin::Col-->
                  <a href="{{route('user.profile')}}" class="col text-center border-bottom py-10 rounded-0">
                    <i class="fal fa-cog fa-2x text-indigo"></i>
                    <span class="fw-bolder fs-6 d-block pt-3 text-dark">{{__('Settings')}}</span>
                  </a>
                  <!--end::Col-->
                  <!--begin::Col-->
                  <a href="{{route('user.billing')}}" class="col text-center border-end py-10 rounded-0">
                    <i class="fal fa-file-invoice fa-2x text-indigo"></i>
                    <span class="fw-bolder fs-6 d-block pt-3 text-dark">{{__('Billing')}}</span>
                  </a>
                  <!--end::Col-->
                  <!--begin::Col-->
                  <a href="{{route('user.logout')}}" class="col text-center py-10 rounded-0">
                    <i class="fal fa-sign-out fa-2x text-indigo"></i>
                    <span class="fw-bolder fs-6 d-block pt-3 text-dark">{{__('Sign Out')}}</span>
                  </a>
                  <!--end::Col-->
                </div>
                <!--end::Row-->
              </div>
              <!--end::Menu-->
              <!--end::Menu wrapper-->
            </div>
            <!--end::User -->
            <!--begin::Aside Toggle-->
            <div class="d-flex align-items-center d-lg-none ms-1 ms-lg-3">
              <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px fs-6" id="kt_aside_toggle">
                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                <span class="svg-icon svg-icon-2x">
                  <i class="fal fa-bars text-dark fs-3"></i>
                </span>
                <!--end::Svg Icon-->
              </div>
            </div>
            <!--end::Aside Toggle-->
          </div>
          <!--end::Toolbar wrapper-->
        </div>
        <!--end::Topbar-->
      </div>


      <!--end::Container-->
    </div>
      <!-- Added bg-white to change to white background -->
    <div class="content fs-6 d-flex flex-column flex-column-fluid bg-white" id="kt_content">
      @yield('content')
      <!--begin::Footer-->
      <div class="footer py-4 d-flex flex-lg-column " id="kt_footer">
        <!--begin::Container-->

        <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
          <!--begin::Copyright-->
          <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-bold me-2 text-dark">{{date('Y')}}©</span>
            <a href="{{url('/')}}" class="text-dark text-hover-primary">{{$set->site_name}}</a>
          </div>
          <!--end::Copyright-->
          <!--begin::Menu-->
          <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
            <li class="menu-item">
              <a href="{{route('privacy')}}" target="_blank" class="menu-link px-2 text-dark">Privacy policy</a>
            </li>
            <li class="menu-item">
              <a href="{{route('terms')}}" target="_blank" class="menu-link px-2 text-dark">Terms & Conditions</a>
            </li>
            <li class="menu-item">
              <a href="https://helpdesk.tryba.io" target="_blank" class="menu-link px-2 text-dark">Support</a>
            </li>
          </ul>
          <!--end::Menu-->
        </div>

        <!--end::Container-->
      </div>
      <!--end::Footer-->
      {{-- Report Bug --}}
      <div class="modal fade" id="bugPopup" tabindex="-1" role="dialog" aria-labelledby="sendMoneyGBPTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
            <h5 class="modal-title fs-2" id="sendMoneyGBPTitle">Report a problem</h5>
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
              <span class="svg-icon svg-icon-2x">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                </svg>
              </span>
            </div>
          </div>
          <div class="modal-body">
                  <div id="sender_error" class="text-danger mb-4"></div>
                  <div id="sender_success" class="text-success mb-4"></div>
                  <form action="{{ route("send.bug") }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="">
                          <textarea name="description" class="form-control form-control-solid" placeholder="We are tagging this page and your profile so feel free to simply type away with your comments" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-primary mt-2">
                            Send
                        </button>
                    </div>
                  </form>
              </div>
            </div>
        </div>
    </div>

      <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
      <script src="{{asset('asset/new_dashboard/plugins/global/plugins.bundle.js')}}"></script>
      {{-- <script src="https://static.sumsub.com/idensic/static/sns-websdk-builder.js"></script> --}}
      <script src="{{ asset('asset/new_dashboard/js/scripts.bundle.js') }}"></script>
      <script src="https://static.sumsub.com/idensic/static/sns-websdk-builder.js"></script>
      <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="{{asset('js/main.js')}}"></script>
      {{-- <script src="{{asset('js/newscript.js')}}"></script> --}}
      {{-- <script src="{{asset('js/noScriptNewsss.js')}}"></script> --}}
      <script src="{{asset('asset/new_dashboard/plugins/custom/leaflet/leaflet.bundle.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/account/api-keys/api-keys.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/modals/create-app.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/modals/select-location.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/widgets.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/modals/create-project.bundle.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/modals/upgrade-plan.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/plugins/custom/datatables/datatables.bundle.js')}}"></script>
      <script src="{{asset('asset/new_dashboard/js/custom/documentation/documentation.js')}}"></script>
      <script src="{{asset('asset/tinymce/tinymce.min.js')}}"></script>
      <script src="{{asset('asset/tinymce/init-tinymce.js')}}"></script>
      <script src="{{asset('asset/dashboard/custom.js')}}"></script>
      <script src="{{asset('asset/dashboard/vendor/prism/prism.js')}}"></script>
      <script src="{{asset('asset/dashboard/bootstrap-datepicker.js')}}"></script>
      @if(route('user.merchant-button')==url()->current())
        <script src="{{asset('asset/dashboard/button/assets/js/repeater.js')}}" type="text/javascript"></script>
        <script src="{{asset('asset/dashboard/button/assets/js/jquery.validate-1.19.3.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('asset/dashboard/button/assets/js/custom.js')}}" type="text/javascript"></script>
      @endif
      <script>
         {!! getLiveCode() !!}
      </script>
      <script>
        var APP_ID = "ibbwx4xs";
        var current_user_email = "{{$user->email}}";
        var current_user_name = "{{$user->first_name.' '.$user->last_name}}";
        var current_user_id = "{{$user->id}}";
        /**window.intercomSettings = {
          app_id: APP_ID,
          name: current_user_name, // Full name
          email: current_user_email, // Email address
          user_id: current_user_id // current_user_id
        };
        (function() {
          var w = window;
          var ic = w.Intercom;
          if (typeof ic === "function") {
            ic('reattach_activator');
            ic('update', w.intercomSettings);
          } else {
            var d = document;
            var i = function() {
              i.c(arguments);
            };
            i.q = [];
            i.c = function(args) {
              i.q.push(args);
            };
            w.Intercom = i;
            var l = function() {
              var s = d.createElement('script');
              s.type = 'text/javascript';
              s.async = true;
              s.src = 'https://widget.intercom.io/widget/' + APP_ID;
              var x = d.getElementsByTagName('script')[0];
              x.parentNode.insertBefore(s, x);
            };
            if (document.readyState === 'complete') {
              l();
            } else if (w.attachEvent) {
              w.attachEvent('onload', l);
            } else {
              w.addEventListener('load', l, false);
            }
          }
        })();**/
      </script>
      @if($user->live==0)
        <script>
            "use strict";

            function changeMode() {
                window.location.href = "{{route('user.account.mode', ['id'=>1])}}"
            }
        </script>
      @else
        <script>
            "use strict";

            function changeMode() {
            window.location.href = "{{route('user.account.mode', ['id'=>0])}}"
            }
        </script>
      @endif
      @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@11"])
      @yield('script')
</body>

</html>
