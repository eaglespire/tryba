@extends('userlayout')

@section('content')
<!-- Page content -->
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Transactions')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Transactions')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--begin::Card body-->
            <div class="card-body pt-3">
                <!--begin::Table-->
                <table id="kt_datatable_example_5" class="table align-middle table-row-dashed gy-5 gs-7">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="min-w-125px">{{__('Name')}}</th>
                            <th class="min-w-50px">{{__('Status')}}</th>
                            <th class="min-w-100px">{{__('Reference ID')}}</th>
                            <th class="max-w-50px">{{__('Payment')}}</th>
                            <th class="max-w-50px">{{__('Method')}}</th>
                            <th class="min-w-50px">{{__('Amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <div class="symbol-label fs-3 bg-light-primary text-primary">{{ucwords(substr($val->first_name,0,1))}}</div>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <span>{{$val->email}}</span>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">@if($val->status==0)
                                <span class="badge badge-pill badge-light-primary">{{__('Pending')}}</span>
                                @elseif($val->status==1)
                                <span class="badge badge-pill badge-light-success">{{__('Success')}}</span>
                                @elseif($val->status==2)
                                <span class="badge badge-pill badge-light-danger">{{__('Failed/Cancelled')}}</span>
                                @endif
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{$val->ref_id}}</td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">
                                @if($val->type==1)
                                {{__('Single Pot')}}
                                @elseif($val->type==2)
                                {{__('Gig Pot')}}
                                @elseif($val->type==3)
                                {{__('Invoice')}}
                                @elseif($val->type==4)
                                {{__('Merchant')}}
                                @elseif($val->type==5)
                                {{__('Account Funding')}}
                                @elseif($val->type==6)
                                {{__('Recurring')}}
                                @elseif($val->type==7)
                                {{__('Product Order')}}
                                @elseif($val->type==8)
                                {{__('Store Order')}}
                                @elseif($val->type==9)
                                {{__('Subscription')}}
                                @elseif($val->type==10)
                                {{__('Appointment')}}
                                @elseif($val->type==11)
                                {{__('Platform Fee')}}
                                @elseif($val->type==12)
                                {{__('Request Link')}}
                                @elseif($val->type == 13)
                                {{__('SMS')}}
                                @elseif($val->type == 14)
                                {{__('Email')}}
                                @endif
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{ucwords($val->payment_type)}}</td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</td>
                        </tr>
                    </tbody>
                </table>
                </form>
                <div class="modal fade" id="trans_share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
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
                                        <h3 class="fw-boldest text-dark fs-2x">{{__('Transaction Details')}}</h3>
                                        <!--begin::Description-->
                                        <div class="text-dark-400 fw-bold fs-4">{{__('Information concerning this transaction')}}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Heading-->
                                    <div class="row mt-8 align-items-center">
                                        <div class="col-xl-12 mb-10 mb-xl-0">
                                            <div class="fs-5 fw-bold text-dark">
                                                <div class="card card-dashed flex-row flex-stack flex-wrap px-6 py-5 h-100 mb-6">
                                                    <div class="d-flex flex-column py-2">
                                                        <div class="d-flex align-items-center fs-4 fw-boldest mb-3">{{__('Payment Details')}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Amount')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">{{number_format($val->amount, 2, '.', '')}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Reference ID')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">{{$val->ref_id}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Status')}}</div>
                                                        @if($val->status==0)
                                                        <span class="fs-4 text-primary"><i class="fal fa-sync text-primary"></i> {{__('Pending')}}</span>
                                                        @elseif($val->status==1)
                                                        <span class="fs-4 text-success"><i class="fal fa-check text-success"></i>{{__('Success')}}</span>
                                                        @elseif($val->status==2)
                                                        <span class="fs-4 text-danger"><i class="fal fa-ban text-danger"></i> {{__('Failed/Cancelled')}}</span>
                                                        @endif
                                                        <div class="fs-4 text-gray-600 ">{{__('Date')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</div>
                                                    </div>
                                                    <div class="d-flex flex-column py-2">
                                                        <br>
                                                        <div class="fs-4 text-gray-600 ">{{__('Currency')}}</div>
                                                        <div class="fs-4 text-dark fw-bold">{{$currency->name}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Payment Method')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">{{ucwords($val->payment_type)}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Type')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">
                                                            @if($val->type==1)
                                                            {{__('Single Pot')}}
                                                            @elseif($val->type==2)
                                                            {{__('Gig Pot')}}
                                                            @elseif($val->type==3)
                                                            {{__('Invoice')}}
                                                            @elseif($val->type==4)
                                                            {{__('Merchant')}}
                                                            @elseif($val->type==5)
                                                            {{__('Account Funding')}}
                                                            @elseif($val->type==6)
                                                            {{__('Recurring')}}
                                                            @elseif($val->type==7)
                                                            {{__('Product Order')}}
                                                            @elseif($val->type==8)
                                                            {{__('Store Order')}}
                                                            @elseif($val->type==9)
                                                            {{__('Subscription')}}
                                                            @elseif($val->type==10)
                                                            {{__('Appointment')}}
                                                            @elseif($val->type==11)
                                                            {{__('Platform Fee')}}
                                                            @elseif($val->type==11)
                                                            {{__('Request Link')}}
                                                            @elseif($val->type == 13)
                                                            {{__('SMS')}}
                                                            @elseif($val->type == 14)
                                                            {{__('Email')}}
                                                            @endif
                                                        </div><br><br>
                                                    </div>
                                                </div>
                                                <div class="card card-dashed flex-row flex-stack flex-wrap px-6 py-5 h-100 mb-6">
                                                    <div class="d-flex flex-column py-2">
                                                        <div class="d-flex align-items-center fs-4 fw-boldest mb-3">{{__('Recipient details')}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Name')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">{{ucwords(strtolower($val->receiver->first_name)).' '.ucwords(strtolower($val->receiver->last_name))}}</div>
                                                    </div>
                                                    <div class="d-flex flex-column py-2">
                                                        <br>
                                                        <div class="fs-4 text-gray-600 ">{{__('Email')}}</div>
                                                        <div class="fs-4 text-dark fw-bold">{{$val->receiver->email}}</div>
                                                    </div>
                                                </div>
                                                <div class="card card-dashed flex-row flex-stack flex-wrap px-6 py-5 h-100">
                                                    <div class="d-flex flex-column py-2">
                                                        <div class="d-flex align-items-center fs-4 fw-boldest mb-3">{{__('Sender details')}}</div>
                                                        <div class="fs-4 text-gray-600 ">{{__('Name')}}</div>
                                                        <div class="fs-4 fw-bold text-dark">{{ucwords(strtolower($val->first_name)).' '.ucwords(strtolower($val->last_name))}}</div>
                                                    </div>
                                                    <div class="d-flex flex-column py-2">
                                                        <br>
                                                        <div class="fs-4 text-gray-600 ">{{__('Email')}}</div>
                                                        <div class="fs-4 text-dark fw-bold">{{$val->email}}</div>
                                                    </div>
                                                </div>
                                                @if($val->status==1)
                                                <p class="mt-3"><a href="{{route('download.receipt', ['id' => $val->ref_id])}}" class="btn btn-light-info btn-block">{{__('Click here to download receipt')}}</a></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div class="modal-footer">
                                <p>Electronic money account is provided by Modulr FS Limited, authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573). </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
</div>
@endsection