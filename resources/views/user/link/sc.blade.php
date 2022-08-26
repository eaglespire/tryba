@extends('userlayout')

@section('content')
<!--end::Header-->
<!--begin::Content-->
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <!--begin::Title-->
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Gig Pot')}}</h1>
      <!--end::Title-->
      <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{__('Gig Pot')}}</li>
      </ul>
    </div>
    <div class="d-flex py-2">
      <button type="button" class="btn btn-white btn-active-dark me-3" data-bs-toggle="modal" data-bs-target="#filter">
        <span class="svg-icon svg-icon-3">
          <i class="fal fa-filter"></i> {{__('Filter')}}
        </span>
      </button>
      <div class="modal fade" id="filter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-550px">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Filter Options')}}</h3>
              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                <span class="svg-icon svg-icon-2x">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="modal-body scroll-y my-7">
              <form action="{{route('user.sclinks.sort')}}" method="post">
                @csrf
                <div class="mb-10">
                  <label class="form-label">{{__('Date Range')}}</label>
                  <input class="form-control form-control-solid" name="date" placeholder="Pick date rage" value="{{$order}}" />
                </div>
                <!--begin::Input group-->
                <div class="mb-10">
                  <!--begin::Label-->
                  <label class="form-label fs-6 fw-bold">{{__('Status')}}</label>
                  <!--end::Label-->
                  <!--begin::Input-->
                  <select class="form-select form-select-solid" name="status">
                    <option value="0" @if($status==0) selected @endif>{{__('All')}}</option>
                    <option value="1" @if($status==1) selected @endif>{{__('Active')}}</option>
                    <option value="2" @if($status==2) selected @endif>{{__('Disabled')}}</option>
                  </select>
                  <!--end::Input-->
                </div>
                <div class="mb-10">
                  <!--begin::Label-->
                  <label class="form-label fs-6 fw-bold">{{__('Type')}}</label>
                  <!--end::Label-->
                  <!--begin::Input-->
                  <select class="form-select form-select-solid" name="type">
                    <option value="0" @if($type==0) selected @endif>{{__('All')}}</option>
                    <option value="1" @if($type==1) selected @endif>{{__('Single Pot')}}</option>
                    <option value="2" @if($type==2) selected @endif>{{__('Multiple Pot')}}</option>
                  </select>
                  <!--end::Input-->
                </div>

                <div class="mb-10">
                  <!--begin::Label-->
                  <label class="form-label fs-6 fw-bold">{{__('Limit')}}</label>
                  <!--end::Label-->
                  <!--begin::Input-->
                  <select class="form-select form-select-solid" name="limit">
                    <option value="10" @if($limit==10) selected @endif>{{__('10')}}</option>
                    <option value="25" @if($limit==25) selected @endif>{{__('25')}}</option>
                    <option value="50" @if($limit==50) selected @endif>{{__('50')}}</option>
                    <option value="100" @if($limit==100) selected @endif>{{__('100')}}</option>
                  </select>
                  <!--end::Input-->
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">{{__('Apply')}}</button>
                </div>
                <!--end::Actions-->
              </form>
            </div>
          </div>
        </div>
      </div>
      <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#create" >{{__('Add a new Gigpot')}}</a>
      <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-550px">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Select Gig Pot')}}</h3>
              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                <span class="svg-icon svg-icon-2x">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="modal-body scroll-y my-7">
              <a href="#" data-bs-toggle="modal" data-bs-target="#single_charge">
                <div class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 mb-8">
                  <span class="d-flex">
                    <span class="ms-4">
                      <span class="fs-4 fw-boldest text-gray-900 mb-2 d-block">{{__('Single Pot')}}</span>
                      <span class="fw-bold fs-6 text-gray-600">{{__('Collect a single payment from friends, family and customers')}}</span>
                    </span>
                  </span>
                </div>
              </a>
              <a href="#" data-bs-toggle="modal" data-bs-target="#multiple_charge">
                <div class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6">
                  <span class="d-flex">
                    <span class="ms-4">
                      <span class="fs-4 fw-boldest text-gray-900 mb-2 d-block">{{__('Multiple Pot')}}</span>
                      <span class="fw-bold fs-6 text-gray-600">{{__('Set a goal and receive money from friends, family and customers')}}</span>
                    </span>
                  </span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="single_charge" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
          <div class="modal-content">
            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('submit.singlecharge')}}" method="post" id="modal-details">
              @csrf
              <div class="modal-header">
                <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Request Payment')}}</h3>
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
                    <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Name of your Page')}}" name="name" required>
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                    <div class="input-group input-group-solid">
                      <span class="input-group-prepend">
                        <span class="input-group-text">{{$currency->symbol}}</span>
                      </span>
                      <input type="number" step="any" class="form-control form-control-solid" name="amount" min="{{$xf->min_payment}}" placeholder="{{__('How much?')}}">
                    </div>
                    <div class="form-text">{{__('Leave empty to allow customers enter desired amount.')}}</div>
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                    <textarea type="text" rows="5" class="form-control form-control-solid" placeholder="{{__('Tell your customer why you are requesting this payment')}}" name="description"></textarea>
                  </div>
                </div>
              </div>
              @if($user->kyc_verif_status=="APPROVED" || $user->live == 0)
              <div class="modal-footer flex-center">
                <button type="submit" form="modal-details" class="btn btn-success btn-block">{{__('Create Gig Pot')}}</button>
              </div>
              @else
              <div class="modal-body flex-center">
                <div class="notice d-flex bg-light-primary rounded border-primary  rounded p-6 mb-8">
                  <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
                        <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"></path>
                      </g>
                    </svg>
                  </span>
                  <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                    <div class="mb-3 mb-md-0 fw-bold">
                      <h4 class="text-gray-800 fw-bolder">{{__('We need more information about you')}}</h4>
                      <div class="fs-6 text-gray-600 pe-7">{{__('Compliance is currently due, please update your account information to avoid restrictions such as no access to storefront service.')}}</div>
                    </div>
                    <a href="{{route('compliance.session')}}" class="btn btn-primary px-6 align-self-center text-nowrap">
                      {{__('Click here')}}
                    </a>
                  </div>
                </div>
              </div>
              @endif
              <div></div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="multiple_charge" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
          <div class="modal-content">
            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data" action="{{route('submit.donationpage')}}" method="post" id="modal-detailx">
              @csrf
              <div class="modal-header">
                <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Request Payment')}}</h3>
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
                <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-offset="300px" style="max-height: 521px;">
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                    <input type="text" class="form-control form-control-solid" placeholder="{{__('Name of your Page')}}" name="name" required>
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                    <div class="input-group input-group-solid">
                      <span class="input-group-prepend">
                        <span class="input-group-text">{{$currency->symbol}}</span>
                      </span>
                      <input type="number" step="any" class="form-control form-control-solid" name="amount" min="{{$xf->min_payment}}" placeholder="{{__('Your Goal?')}}" required>
                    </div>
                  </div>
                  <div class="image-input image-input-empty mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                    <!--begin::Image preview wrapper-->
                    <div class="image-input-wrapper w-125px h-125px"></div>
                    <!--end::Image preview wrapper-->
  
                    <!--begin::Edit button-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                              <i class="fal fa-image fs-1 text-dark"></i>
  
                      <!--begin::Inputs-->
                      <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                      <input type="hidden" name="avatar_remove" />
                      <!--end::Inputs-->
                    </label>
                    <!--end::Edit button-->
  
                    <!--begin::Cancel button-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                      <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Cancel button-->
  
                    <!--begin::Remove button-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                      <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Remove button-->
                  </div>
                  <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                    <textarea type="text" rows="5" class="form-control form-control-solid" placeholder="{{__('Tell your customer why you are requesting this payment')}}" name="description"></textarea>
                  </div>
                </div>
              </div>
              @if($user->kyc_verif_status=="APPROVED" || $user->live==0)
              <div class="modal-footer flex-center">
                <button type="submit" form="modal-detailx" class="btn btn-success btn-block">{{__('Create Gig Pot')}}</button>
              </div>
              @else
              <div class="modal-body flex-center">
                <div class="notice d-flex bg-light-primary rounded border-primary  rounded p-6 mb-8">
                  <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
                        <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"></path>
                      </g>
                    </svg>
                  </span>
                  <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                    <div class="mb-3 mb-md-0 fw-bold">
                      <h4 class="text-gray-800 fw-bolder">{{__('We need more information about you')}}</h4>
                      <div class="fs-6 text-gray-600 pe-7">{{__('Compliance is currently due, please update your account information to avoid restrictions such as no access to storefront service.')}}</div>
                    </div>
                    <a href="{{route('compliance.session')}}" class="btn btn-primary px-6 align-self-center text-nowrap">
                      {{__('Click here')}}
                    </a>
                  </div>
                </div>
              </div>
              @endif
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
      <div class="row g-xl-8">
        <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-body pt-3">
                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class=""></th>
                            <th class="min-w-80px">{{__('Name')}}</th>
                            <th class="min-w-80px">{{__('Amount')}}</th>
                            <th class="min-w-50px">{{__('Type')}}</th>
                            <th class="min-w-50px">{{__('Status')}}</th>
                            <th class="min-w-50px">{{__('Created')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($links as $item)
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
                                <div class="menu-item px-3"><a data-bs-toggle="modal" data-bs-target="#share{{$item->id}}" href="#" class="menu-link px-3">{{__('Share')}}</a></div>
                                <div class="menu-item px-3"><a target="_blank" href="{{route('pot.link', ['id' => $item->ref_id])}}" class="menu-link px-3">{{__('Preview')}}</a></div>
                                @if($item->type == 2)
                                  <div class="menu-item px-3"><a href="{{route('user.sclinkscontributors', ['id' => $item->id])}}" class="menu-link px-3">{{__('Contributors')}}</a></div>
                                @endif
                                <div class="menu-item px-3"><a href="{{route('user.sclinkstrans', ['id' => $item->id])}}" class="menu-link px-3">{{__('Transactions')}}</a></div>
                                @if($item->active == 1)
                                <div class="menu-item px-3"><a href="{{route('sclinks.unpublish', ['id' => $item->id])}}" class="menu-link px-3">{{ __('Disable')}}</a></div>
                                @else
                                <div class="menu-item px-3"><a href="{{route('sclinks.publish', ['id' => $item->id])}}" class="menu-link px-3">{{ __('Activate')}}</a></div>
                                @endif
                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$item->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                            </div>
                        </td>
                        <td data-href="">{{ $item->name }}</td>
                        <td data-href="">
                          @if($item->type == 1) 
                            @if($item->amount == null) Not fixed @else {{ $currency->symbol }}  {{ number_format($item->amount) }} @endif
                          @else
                            {{$currency->symbol.number_format(getAmountDonated($item->id),2)}} / {{$currency->symbol.number_format($item->amount,2)}}
                          @endif  
                        </td>
                        <td data-href="">@if($item->type == 1){{__('Single Pot')}} @else{{__('Multiple Pot')}} @endif</td>
                        <td data-href="">
                          @if($item->active==1)
                            <span class="badge badge-pill badge-light-success">{{__('Active')}}</span>
                          @else
                            <span class="badge badge-pill badge-light-danger">{{__('Disabled')}}</span>
                          @endif
                        </td>
                        <td data-href="">{{ $item->created_at->diffforHumans() }}</td>                 
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        @foreach($links as $item)
          <div class="modal fade" tabindex="-1" id="delete{{$item->id}}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Delete Pot')}}</h5>
                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                  </div>
                </div>
                <div class="modal-body">
                  <p>{{__('Are you sure you want to delete this?, all transaction related to this pot will also be deleted')}}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                  @if($item->type==1)
                  <a href="{{route('delete.user.sclink', ['id' => $item->id])}}" class="btn btn-danger">{{__('Proceed')}}</a>
                  @else
                  <a href="{{route('delete.user.dplink', ['id' => $item->id])}}" class="btn btn-danger">{{__('Proceed')}}</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        @foreach($links as $item)
          <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Edit Pot')}}</h3>
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
                  <div class="scroll-y me-n7 pe-7">
                    <form class="form" enctype="multipart/form-data" action="{{route('update.sclinks')}}" method="post">
                      @csrf
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" value="{{$item->name}}" placeholder="{{__('Name of your Page')}}" name="name" required>
                      </div>
                      @if($item->type==1)
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                        <div class="input-group input-group-solid">
                          <span class="input-group-prepend">
                            <span class="input-group-text">{{$currency->symbol}}</span>
                          </span>
                          <input type="number" step="any" value="{{$item->amount}}" class="form-control form-control-solid" name="amount" min="{{$xf->min_payment}}" placeholder="{{__('How much?')}}">
                        </div>
                        <div class="form-text">{{__('Leave empty to allow customers enter desired amount.')}}</div>
                      </div>
                      @else
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                        <div class="input-group input-group-solid">
                          <span class="input-group-prepend">
                            <span class="input-group-text">{{$currency->symbol}}</span>
                          </span>
                          <input type="number" step="any" value="{{$item->amount}}" class="form-control form-control-solid" name="amount" min="{{$xf->min_payment}}" placeholder="{{__('Your Goal?')}}">
                        </div>
                      </div>
                      @endif
                      @if($item->type == 2)
                      <div class="image-input image-input-outline mb-5" data-kt-image-input="true" style="background-image: url({{asset('asset/new_dashboard/media/avatars/blank.png')}})">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('asset/profile/'.$item->image)}})"></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
                          <i class="bi bi-pencil-fill fs-7"></i>

                          <!--begin::Inputs-->
                          <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                          <input type="hidden" name="avatar_remove" />
                          <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->

                        <!--begin::Cancel button-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                          <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel button-->

                        <!--begin::Remove button-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                          <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Remove button-->
                      </div>
                      @endif
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                        <textarea type="text" rows="5" class="form-control form-control-solid" placeholder="{{__('Tell your customer why you are requesting this payment')}}" name="description">{!! $item->description !!}</textarea>
                      </div>
                      <input type="hidden" name="id" value="{{$item->ref_id}}">
                  </div>
                </div>
                <div class="modal-footer flex-center">
                  <button type="submit" class="btn btn-success btn-block">{{__('Save')}}</button>
                </div>
                <div></div>
                </form>
              </div>
            </div>
          </div>
        @endforeach
        @foreach($links as $item)
        <div class="modal fade" id="share{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
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
                  <div class="text-dark-400 fw-bold fs-4">{{__('Share gigpot with friends, family & customers')}}</div>
                  <!--end::Description-->
                </div>
                <!--end::Heading-->
                <!--begin::Input group-->
                <div class="mb-10">
                  <!--begin::Title-->
                  <div class="d-flex">
                    <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('pot.link', ['id' => $item->ref_id])}}">
                    <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('pot.link', ['id' => $item->ref_id])}}">Copy Link</button>
                  </div>
                  <!--end::Title-->
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="d-flex">
                  <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('pot.link', ['id' => $item->ref_id])}}" class="btn btn-light-primary w-100">
                    <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>
                  <a target="_blank" href="https://wa.me/{{$item->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('pot.link', ['id' => $item->ref_id])}}" class="btn btn-icon btn-success mx-6 w-100">
                    <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}
                  </a>
                </div>
                <!--end::Actions-->
                <!--begin::Input group-->
                <div class="text-center px-5 mt-8">
                  <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                  {!! QrCode::eye('circle')->style('round')->size(200)->generate(route('pot.link', ['id' => $item->ref_id])); !!}
                </div>
                <!--end::Input group-->
              </div>
              <!--end::Wrapper-->
            </div>
          </div>
        </div>
        @endforeach
      </div>
  </div>
</div>
</div>
@endsection