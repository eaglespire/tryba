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
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Storefront')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Customers')}}</li>
            </ul>
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
                            <table id="kt_datatable_example_7" class="table align-middle table-row-dashed gy-5 gs-7">
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
                                                @if($user->storefront()->mail==1)
                                                <div class="menu-item px-3"><a href="{{route('customer.send.email', ['id' => $val->id])}}" class="menu-link px-3">{{__('Send email')}}</a></div>
                                                @endif
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
    </div>
</div>
</div>
@stop