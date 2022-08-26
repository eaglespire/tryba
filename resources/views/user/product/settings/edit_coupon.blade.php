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
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('website.coupon')}}" class="text-muted text-hover-primary">{{__('Coupon')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Edit Coupon')}}</h3>
                </div>
            </div>
            <form action="{{route('edit.coupon', ['id'=>$val->id])}}" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Name')}}</label>
                        <input type="text" class="form-control form-control-solid" value="{{$val->name}}" placeholder="{{__('Name')}}" name="name" required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Limit')}}</label>
                        <input type="number" class="form-control form-control-solid" value="{{$val->limits}}" placeholder="{{__('Limit')}}" name="limits" required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Discount type')}}</label>
                        <select name="type" id="discount_type" class="form-select form-select-solid" required>
                            <option value="">{{__('How will you reward customers')}}</option>
                            <option value="1" @if($val->type==1) selected @endif>{{__('Fiat')}}</option>
                            <option value="2" @if($val->type==2) selected @endif>{{__('Percent off')}}</option>
                        </select>
                    </div>
                    <div id="fiat_amount_div" style="display:none;">
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">{{$currency->symbol}}</span>
                                </span>
                                <input type="number" value="{{$val->amount}}" step="any" class="form-control form-control-solid" id="fiat_amount" name="fiat_amount" placeholder="{{__('How much?')}}">
                            </div>
                        </div>
                    </div>
                    <div id="percent_amount_div" style="display:none;">
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-bold mb-2">{{__('Amount')}}</label>
                            <div class="input-group input-group-solid">
                                <input type="number" value="{{$val->amount}}" step="any" max="99" class="form-control form-control-solid" id="percent_amount" name="percent_amount" placeholder="{{__('How much?')}}">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Code')}}</label>
                        <div class="input-group input-group-solid">
                            <input type="text" value="{{$val->code}}" id="auto-code" class="form-control form-control-solid" name="code" placeholder="{{__('Code?')}}" required>
                            <span class="input-group-prepend">
                                <span class="input-group-text" id="code-generate">{{__('Generate')}}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>
    'use strict';
    $(function() {
        $("#buttonStatus").click(function() {
            if ($(this).is(":checked")) {
                $("#buttonStatusDisplay").show();
                $('#button_text').attr('required', '');
                $('#button_link').attr('required', '');
            } else {
                $("#buttonStatusDisplay").hide();
                $('#button_text').removeAttr('required', '');
                $('#button_link').removeAttr('required', '');
            }
        });
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
    coupon();
</script>
<script>
  $(document).on('click', '#code-generate', function () {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for (var i = 0; i < 10; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    $('#auto-code').val(result);
  });
</script>
@endsection