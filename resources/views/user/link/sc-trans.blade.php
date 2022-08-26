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
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.sclinks')}}" class="text-muted text-hover-primary">{{__('Gigpot')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Transactions')}}</li>
            </ul>
        </div>
        <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
            <a href="{{route('user.sclinkstrans.archive', ['id' => $id])}}"class="btn btn-white btn-active-primary me-4 btn-color-dark @if($archivesum==0) disabled @endif ">Archived ({{$archivesum}})</a>
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
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#filter">
                            <!--begin::Svg Icon | path: icons/duotone/Text/Filter.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                            </span>
                            Filter
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
                                        <form action="{{route('user.transactions.sort.sclinks')}}" method="post">
                                            @csrf
                                            <div class="mb-10">
                                                <label class="form-label">{{__('Date Range')}}</label>
                                                <input class="form-control form-control-solid" name="date" placeholder="Pick date rage" value="{{$order}}" />
                                            </div>
                                            <div class="mb-10">
                                                <label class="form-label fs-6 fw-bold">{{__('Status')}}</label>
                                                <select class="form-select form-select-solid" name="status" required>
                                                    <option value="">{{__('Select Status')}}</option>
                                                    <option value="1" @if($status==1) selected @endif>{{__('Successful')}}</option>
                                                    <option value="0" @if($status==0) selected @endif>{{__('Pending')}}</option>
                                                    <option value="2" @if($status==2) selected @endif>{{__('Failed/Cancelled')}}</option>
                                                </select>
                                            </div>
                                            <div class="mb-10">
                                                <label class="form-label fs-6 fw-bold">{{__('Method')}}</label>
                                                <select class="form-select form-select-solid" name="method">
                                                    <option value="0" @if($method==0) selected @endif>{{__('All')}}</option>
                                                    <option value="bank" @if($method=="bank" ) selected @endif>{{__('Bank')}}</option>
                                                    <option value="card" @if($method=="card" ) selected @endif>{{__('Card')}}</option>
                                                    <option value="stripe" @if($method=="stripe" ) selected @endif>{{__('Stripe')}}</option>
                                                    <option value="coinbase" @if($method=="coinbase" ) selected @endif>{{__('Coinbase')}}</option>
                                                    <option value="paypal" @if($method=="paypal" ) selected @endif>{{__('Paypal')}}</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="id" value="{{$id}}">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">{{__('Apply')}}</button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Filter-->
                        <!--begin::Add user-->
                        <form action="{{route('user.archive.transactions')}}" method="post">
                            @csrf
                            @foreach($trans as $val)
                            <input type="hidden" id="pos{{$val->ref_id}}" disabled name="archive[]" value="{{$val->ref_id}}" />
                            @endforeach
                            <input type="hidden" id="add" value="0" />
                            <button type="submit" disabled id="xx" class="btn btn-primary">
                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fal fa-folder"></i>
                                </span>
                                Add to Archive <span id="addx"></span>
                            </button>
                        </form>
                        <!--end::Add user-->
                    </div>
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
                            <th class="w-10px pe-2">

                            </th>
                            <th class="min-w-125px">{{__('Name')}}</th>
                            <th class="min-w-50px">{{__('Status')}}</th>
                            <th class="min-w-100px">{{__('Reference ID')}}</th>
                            <th class="max-w-50px">{{__('Payment')}}</th>
                            <th class="max-w-50px">{{__('Method')}}</th>
                            <th class="min-w-50px">{{__('Amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trans as $val)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="check{{$val->ref_id}}" />
                                </div>
                            </td>
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
                                @endif
                            </td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{ucwords($val->payment_type)}}</td>
                            <td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        @foreach($trans as $val)
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
        @endforeach
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
</div>
<script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
@foreach($trans as $val)
<script>
    $("#check{{$val->ref_id}}").click(function() {
        if ($(this).is(":checked")) {
            var add = parseInt($('#add').val());
            var cc = parseInt(add) + 1;
            $('#add').val(parseInt(add) + 1);
            $('#addx').text('(' + cc + ')');
            $('#pos{{$val->ref_id}}').removeAttr('disabled');
            $('#xx').removeAttr('disabled');
        } else {
            var minus = parseInt($('#add').val());
            var cc = parseInt(minus) - 1;
            $('#add').val(parseInt(minus) - 1);
            $('#addx').text('(' + cc + ')');
            $('#pos{{$val->ref_id}}').attr('disabled');
            if (cc == 0) {
                $('#xx').attr('disabled', 'disabled');
            }
        }
    });
</script>
@endforeach
@stop