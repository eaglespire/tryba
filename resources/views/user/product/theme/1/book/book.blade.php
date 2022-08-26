@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{$service->name}}</h1>
                        <div class="breadcrumbs">
                            <div class="breadcrumbs__inner">
                                <ul class="breadcrumbs__list">
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
                                    </li>
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('store.services.index', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Services')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="core__columns">
            <div class="core__columns-inner">
                <div class="lsvr-container">

                    <!-- COLUMNS GRID : begin -->
                    <div class="core__columns-grid lsvr-grid">

                        <!-- MAIN COLUMN : begin -->
                        <div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-9 lsvr-grid__col--md-span-12">

                            <!-- MAIN : begin -->
                            <main id="main">
                                <div class="main__inner">

                                    <!-- PAGE : begin -->
                                    <div class="page service-post-page service-post-single">
                                        <div class="page__content">

                                            <!-- POST : begin -->
                                            <article class="post service-post">
                                                <div class="post__inner">

                                                    <!-- POST CONTENT : begin -->
                                                    <div class="post__content">

                                                        <p>{{$service->description}}</p>
                                                        <p class="post__price-current mb-1">Amount: {{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol.number_format($service->price)}}</p>
                                                        <p class="post__price-current mb-1">Duration: {{$service->duration}} @if($service->duration > 1) {{ str_plural($service->durationType) }} @else {{ $service->durationType }} @endif</p>
                                                        @if($store->service_review==1)
                                                        <p class="mb-3">
                                                            <i class="fal fa-star @if($service->rating()>0) checked @endif"></i>
                                                            <i class="fal fa-star @if($service->rating()>1) checked @endif"></i>
                                                            <i class="fal fa-star @if($service->rating()>2) checked @endif"></i>
                                                            <i class="fal fa-star @if($service->rating()>3) checked @endif"></i>
                                                            <i class="fal fa-star @if($service->rating()>4) checked @endif"></i>
                                                        </p>
                                                        @endif
                                                        @if($store->service_review==1)
                                                        <div class="lsvr-accordion lsvr-accordion--toggle post-archive__list">

                                                            <!-- POST : begin -->

                                                            <article class="post faq-post lsvr-accordion__item">
                                                                <div class="lsvr-accordion__item-inner">
                                                                    <header class="lsvr-accordion__item-header">
                                                                        <h3 class="lsvr-accordion__item-title">{{__('REVIEWS')}} ({{count(getBookingReviews($service->id))}})</h3>
                                                                    </header>
                                                                    <div class="lsvr-accordion__item-content-wrapper">
                                                                        <div class="lsvr-accordion__item-content">
                                                                            @foreach(getBookingReviews($service->id) as $val)
                                                                            <article class="post testimonial-post abbr">
                                                                                <div class="post__inner">
                                                                                    <p>{{$val->review}}</p>
                                                                                    <footer class="post__footer post__footer--has-thumbnail">
                                                                                        <cite class="post__title">
                                                                                            <a href="javascript:void;" class="post__title-link"> @if($val->customer_id!=null)
                                                                                                {{$val->buyer->first_name.' '.$val->buyer->last_name}}
                                                                                                @else
                                                                                                {{$val->first_name.' '.$val->last_name}}
                                                                                                @endif</a>
                                                                                            <span class="post__title-description">
                                                                                                <i class="fal fa-star @if($val->service->rating()>0) checked @endif"></i>
                                                                                                <i class="fal fa-star @if($val->service->rating()>1) checked @endif"></i>
                                                                                                <i class="fal fa-star @if($val->service->rating()>2) checked @endif"></i>
                                                                                                <i class="fal fa-star @if($val->service->rating()>3) checked @endif"></i>
                                                                                                <i class="fal fa-star @if($val->service->rating()>4) checked @endif"></i>
                                                                                            </span>
                                                                                        </cite>

                                                                                    </footer>
                                                                                </div>
                                                                            </article>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        </div>
                                                        @endif
                                        
                                                        <div class="form-group add_bottom_45">
                                                            <div class="calendar-part">
                                                                <div id="calendar"></div>
                                                            </div>
                                                        </div>
                                        
                                                        <form action="{{route('check.booking')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="service_id" value="{{$service->id}}">
                                                            <section class="pt-30 pb-30">
                                                                <div class="row justify-content-center add_bottom_45 pb-30">
                                                                    <div class="col-md-12 col-12">
                                                                        <p class="lsvr-form__field">
                                                                            <label class="lsvr-form__field-label">Select your time of choice</label>
                                                                            <select class="lsvr-form__field-input lsvr-form__field-input--text" name="time" id="time-list" required>

                                                                            </select>
                                                                        <div id="time-list2"></div>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                    
                                                                @if(Auth::guard('customer')->check())
                                                                    @if($store->service_type==1)
                                                                        @if(count(getCustomerAddress(auth()->guard('customer')->user()->id))==0)
                                                                        <div class="lsvr-alert-message mb-3">
                                                                            <span class="lsvr-alert-message__icon" aria-hidden="true"></span>
                                                                            <h3 class="lsvr-alert-message__title">Info Message</h3>
                                                                            <p>Please address is need, <a href="{{route('customer.address', ['store_url'=>$store->store_url])}}">click here</a>, to add an address.</p>
                                                                        </div>
                                                                        @else
                                                                        <p class="lsvr-form__field mb-4">
                                                                            <label class="lsvr-form__field-label">Address</label>
                                                                            <select class="lsvr-form__field-input lsvr-form__field-input--text" name="address" required>
                                                                                @foreach(getCustomerAddress(auth()->guard('customer')->user()->id) as $aval)
                                                                                <option value="{{$aval->id}}">{{$aval->line_1}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </p>
                                                                        @endif
                                                                    @endif
                                                                    <div class="tt-shopcart-col mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-lg-12">
                                                                                <div class="tt-shopcart-box">
                                                                                    <h4 class="tt-title">
                                                                                        {{__('Coupon')}}
                                                                                    </h4>
                                                                                    <form action="{{route('book.coupon', ['id'=> $service->id])}}" method="post" class="form-default">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <input class="form-control" type="text" @if($coupon_status==1) value="{{$coupon->code}}" @endif name="code" placeholder="Enter Coupon Code">
                                                                                        </div>
                                                                                        <div class="text-left mt-6">
                                                                                            <button type="submit" class="lsvr-button lsvr-form__submit">{{__('Apply')}}</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tt-shopcart-col">
                                                                        <div class="tt-shopcart-box">
                                                                            <table class="tt-shopcart-table01 text-left">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th>{{__('SUBTOTAL')}}</th>
                                                                                        <td>{{$store->user->cc->coin->symbol}}<span id="subtotal3">{{number_format($service->price)}}</td>
                                                                                    </tr>
                                                                                    @if($coupon_status==1)
                                                                                    <tr>
                                                                                        <th>{{__('COUPON')}}</th>
                                                                                        <td>-{{$store->user->cc->coin->symbol}}<span id="coupon3">{{number_format($coupon_amount, 2)}}</span></td>
                                                                                    </tr>
                                                                                    @endif
                                                                                    @if($store->vat!=null)
                                                                                    <tr>
                                                                                        <th>{{__('VAT')}} ({{$store->tax}}%)</th>
                                                                                        <td>+{{$store->user->cc->coin->symbol}}<span id="tax3">{{number_format($service->price*$store->tax/100, 2)}}</span></td>
                                                                                    </tr>
                                                                                    @endif
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <tr>
                                                                                        <th>{{__('GRAND TOTAL')}}</th>
                                                                                        <td>{{$store->user->cc->coin->symbol}}<span id="total3">{{number_format($total)}}</span></td>
                                                                                    </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                            <div class="text-left">
                                                                                <h3 class="form-text text-xl font-weight-bolder">{{__('Payment Method')}} </h3>
                                                                                @if(getStorefrontOwner($store->user_id)->cc->bank_pay==1 AND $store->user_id)->bank_pay==1)
                                                                                    <div class="bg-gray rounded mb-3">
                                                                                        <div class="custom-control custom-control-alternative custom-radio form-inline">
                                                                                            <input class="custom-control-input" id="customCheckgLogin" type="radio" name="action" value="bank" required>
                                                                                            <label class="custom-control-label ml-2" for="customCheckgLogin">
                                                                                                {{__('Pay with Open Banking')}}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if(getStorefrontOwner($store->user_id)->cc->paypal == 1 AND getStorefrontOwner($store->user_id)->paypal==1)        
                                                                                    <div class="bg-gray rounded mb-3">
                                                                                        <div class="custom-control custom-control-alternative custom-radio form-inline">
                                                                                            <input class="custom-control-input" id="customCheckxLogin" type="radio" name="action" value="paypal" required>
                                                                                            <label class="custom-control-label ml-2" for="customCheckxLogin">
                                                                                                {{__('Pay with Paypal')}}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if(getStorefrontOwner($store->user_id)->cc->coinbase==1 AND getStorefrontOwner($store->user_id)->coinbase==1)
                                                                                    <div class="bg-gray rounded mb-3">
                                                                                        <div class="custom-control custom-control-alternative custom-radio form-inline">
                                                                                            <input class="custom-control-input" id="customCheckdLogin" type="radio" name="action" value="coinbase" required>
                                                                                            <label class="custom-control-label ml-2" for="customCheckdLogin">
                                                                                                {{__('Pay with Coinbase')}}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if(getStorefrontOwner($store->user_id)->cc->coinbase == 1 AND getStorefrontOwner($store->user_id)->coinbase == 1 AND $set->buy_crypto!=null)
                                                                                    <p class="mb-2">{{__('If you don\'t have crypto or you want to buy crypto')}},<a target="_blank" href="{{$set->buy_crypto}}"> {{__('click here')}}</a></p>
                                                                                @endif
                                                                                </div>
                                                                                <p class="text-center not-show book-now-btn">
                                                                                    <input class="lsvr-button lsvr-form__submit" type="submit" value="Book Now" id="appointment-frm-submit">
                                                                                </p>
                                                                            @else
                                                                                <p class="text-center not-show book-now-btn">
                                                                                    <a class="lsvr-button lsvr-form__submit" href="{{route('customer.login', ['store_url'=>$store->store_url])}}">Book</a>
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                            </section>
                                                        </form>
                                                    </div>
                                                    <!-- POST CONTENT : end -->
                                                </div>
                                            </article>
                                            <!-- POST : end -->

                                        </div>
                                    </div>
                                    <!-- PAGE : end -->
                                </div>
                            </main>
                            <!-- MAIN : end -->
                        </div>
                        <div class="core__columns-col core__columns-col--sidebar core__columns-col--right lsvr-grid__col lsvr-grid__col--span-3 lsvr-grid__col--md-span-12">

                            <!-- SIDEBAR : begin -->
                            <aside id="sidebar">
                                <div class="sidebar__inner">

                                    <!-- LSVR SERVICE LIST WIDGET : begin -->
                                    <div class="widget lsvr-service-list-widget">
                                        <div class="widget__inner">
                                            <h3 class="widget__title">Other Services</h3>
                                            <div class="widget__content">
                                                <ul class="lsvr-service-list-widget__list">
                                                    <!-- SERVICE LIST ITEM : begin -->
                                                    @foreach(getStorefrontOwner($store->user_id)->services() as $val)
                                                    <li class="lsvr-service-list-widget__item lsvr-service-list-widget__item--has-icon @if($service->id==$val->id) lsvr-service-list-widget__item--current @endif">
                                                        <a href="{{route('store.services.book', ['id' => $store->store_url, 'service'=>$val->id])}}" class="lsvr-service-list-widget__item-link">{{$val->name}}</a>
                                                    </li>
                                                    @endforeach
                                                    <!-- SERVICE LIST ITEM : end -->
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- LSVR SERVICE LIST WIDGET : end -->

                                </div>
                            </aside>
                            <!-- SIDEBAR : end -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CORE COLUMNS : end -->


@endsection
    @php
        Session::put('return_url', url()->current());
    @endphp
@section('script')
<script>
    $(document).ready(function() {
        var count = 1;
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('store.calender', ['id'=>$store->store_url])}}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            beforeSend: function() {

                $('#calendar').remove();
                $("#time-list").html("");
                var calender = '<div id="calendar" class="calendar' + count + '"></div>';
                $('.calendar-part').append(calender);
            },
            success: function(data_arr) {
                var nowDate = new Date();
                var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                $('.calendar' + count).datepicker({
                    todayHighlight: true,
                    daysOfWeekDisabled: data_arr.days_of_week_disable,
                    weekStart: 1,
                    format: "yyyy-mm-dd",
                    startDate: today,
                    beforeShowDay: function(date) {
                        disable_mm = date.getMonth(),
                            disable_m = disable_mm + 1;
                        disable_d = date.getDate(),
                            disable_y = date.getFullYear();
                        var disabled_date = disable_y + '-' +
                            (disable_m < 10 ? '0' : '') + disable_m + '-' +
                            (disable_d < 10 ? '0' : '') + disable_d;
                        var disable_startDate = data_arr.vacation_time_arr.startdate,
                            disable_endDate = data_arr.vacation_time_arr.enddate;
                        // populate the array
                        for (var disable_day = new Date(disable_startDate); disable_day <= new Date(disable_endDate); disable_day.setDate(disable_day.getDate() + 1)) {
                            dis_mm = disable_day.getMonth(),
                                dis_m = dis_mm + 1;
                            dis_d = disable_day.getDate(),
                                dis_y = disable_day.getFullYear();
                            var dis_date = dis_y + '-' +
                                (dis_m < 10 ? '0' : '') + dis_m + '-' +
                                (dis_d < 10 ? '0' : '') + dis_d;
                            if (disabled_date == dis_date) {
                                return false;
                            }
                        }

                    },
                }).on('changeDate', function(e) {
                    var date_weekday = new Date(e.date).getDay();
                    $.ajax({
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{route('store.availabletime', ['id'=>$store->store_url])}}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'date_weekday': date_weekday,
                            'date': e.date
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $("#time-list").html("");
                        },
                        success: function(data) {
                            console.log(data);
                            var html = '';
                            var html2 = '';
                            if (data.available_time_arr.length > 0) {
                                html2 += '<input type="hidden" name="appointment_date" value="' + data.appointment_date + '">';
                                var data_arr = data.available_time_arr;
                                for (var i = 0; i < data_arr.length; i++) {
                                    html += '<option value="' + data_arr[i] + '">' + data_arr[i] + '</option>';
                                }
                                $('.book-now-btn').show();
                            } else {
                                html += '<option value="">No appointment available on this date</option>';
                                html += '<li style="width:100%">';
                                html += '<h4>No appointment available on this date.</h4>';
                                html += '</li>';
                                $('.book-now-btn').hide();
                            }
                            $("#time-list").html(html);
                            $("#time-list2").html(html2);
                        },
                    });
                });
                count++;
                $('.calendar-part .today').trigger('click');
            }
        });
    });
</script>
@endsection