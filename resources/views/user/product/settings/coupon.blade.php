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
                <li class="breadcrumb-item text-dark">{{__('Coupons')}}</li>
            </ul>
        </div>
        <div class="d-flex py-2">
            <a href="#" data-bs-toggle="modal" data-bs-target="#coupon_create" class="btn btn-dark me-4"><i class="fal fa-gift"></i> {{__('New Coupon')}}</a>
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
    </div>
</div>
</div>
@stop
@section('script')
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