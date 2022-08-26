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
                <li class="breadcrumb-item text-dark">{{__('Appointments')}}</li>
            </ul>
        </div>
        @if($user->storefront()->working_time!=null)
        <div class="d-flex py-2">
            <a href="{{route('create.service')}}" class="btn btn-dark me-4"><i class="fal fa-briefcase"></i> {{__('Add a new service')}}</a>
        </div>
        @endif
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        @if($user->storefront()->working_time!=null)
        <div class="d-flex overflow-auto mb-10">
            <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                <li class="nav-item">
                    <a href="{{route('user.appointment')}}" class="nav-link text-active-primary px-3 @if(route('user.appointment')==url()->current()) active @endif">{{_('Dashboard')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.appointment.pending')}}" class="nav-link text-active-primary px-3 @if(route('user.appointment.pending')==url()->current()) active @endif">{{_('Upcoming')}} ({{$user->pendingAppointmentCount()}})</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.appointment.completed')}}" class="nav-link text-active-primary px-3 @if(route('user.appointment.completed')==url()->current()) active @endif">{{_('Completed')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.services')}}" class="nav-link text-active-primary px-3 @if(route('user.services')==url()->current()) active @endif">{{__('Services')}}</a>
                </li>
            </ul>
        </div>
        @else
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Setup appointment')}}</h3>
                </div>
            </div>
            <form action="{{route('edit.booking')}}" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <input type="hidden" name="booking_setup">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('How do you render service')}}</label>
                        <select name="session_time" class="form-select form-select-solid" required>
                            <option value="1" @if(session('session_time')==1) selected @endif>{{__('One customer per booking')}}</option>
                            <option value="2" @if(session('session_time')==2) selected @endif>{{__('More than one customer per booking, I have multiple staffs')}}</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Where do you render service')}}</label>
                        <select id="service_type" name="service_type" class="form-select form-select-solid" required>
                            <option value="1" @if(session('service_type')==1) selected @endif>{{__('Customer home address')}}</option>
                            <option value="2" @if(session('service_type')==2) selected @endif>{{__('I have a physical location where I receive customers')}}</option>
                        </select>
                    </div>
                    <div id="store" class="mb-6" style="display:none;">
                        <div class="row mb-6">
                            <label class="col-lg-3 col-form-label fw-bold fs-6">
                                <span class="required">{{__('State/County')}}</span>
                            </label>
                            <div class="col-lg-9">
                                <select class="form-select form-select-solid" id="state" name="state" required>
                                    @foreach($user->getState() as $val)
                                    <option value="{{$val->id.'*'.$val->iso2}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6" id="showCity" style="display:none;">
                            <label class="col-lg-3 col-form-label fw-bold fs-6">
                                <span class="required">{{__('City')}}</span>
                            </label>
                            <div class="col-lg-9">
                                <select class="form-select form-select-solid" id="city" name="city">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Line 1')}}</label>
                            <div class="col-lg-9">
                                <input type="text" id="line_1" name="line_1" value="@if(session('line_1')){{session('line_1')}}@endif" class="form-control form-control-lg form-control-solid" placeholder="Line 1">
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Zip/Postal Code')}}</label>
                            <div class="col-lg-9">
                                <input type="text" id="postal_code" name="postal_code" value="@if(session('postal_code')){{session('postal_code')}}@endif" class="form-control form-control-lg form-control-solid" placeholder="Zip/Postal code">
                            </div>
                        </div>
                        <div class="form-text">{{__('Store location will be displayed on your website')}}</div>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Daily limit')}}</label>
                        <input type="number" class="form-control form-control-solid" value="@if(session('booking_per_day')){{session('booking_per_day')}}@endif" placeholder="{{__('The maximum amount of bookings per day, leave this empty if you need no limit')}}" name="booking_per_day">
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Service review')}}</label>
                        <select id="service_review" name="service_review" class="form-select form-select-solid" required>
                            <option value="1">{{__('Allow service review after completion')}}</option>
                            <option value="0">{{__('I don\'t need service review')}}</option>
                        </select>
                    </div>
                    <h4 class="fw-bolder mb-6 text-dark">{{__('Business Hours')}}</h4>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[mon][status]" class="form-check-input" type="checkbox" id="custommon">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="custommon">{{__('Monday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="monstart" disabled name="workingtime[mon][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="monend" disabled name="workingtime[mon][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[tue][status]" class="form-check-input" type="checkbox" id="customtue">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customtue">{{__('Tuesday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="tuestart" disabled name="workingtime[tue][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="tueend" disabled name="workingtime[tue][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[wed][status]" class="form-check-input" type="checkbox" id="customwed">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customwed">{{__('Wednesday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="wedstart" disabled name="workingtime[wed][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="wedend" disabled name="workingtime[wed][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[thu][status]" class="form-check-input" type="checkbox" id="customthu">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customthu">{{__('Thursday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="thustart" disabled name="workingtime[thu][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="thuend" disabled name="workingtime[thu][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[fri][status]" class="form-check-input" type="checkbox" id="customfri">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customfri">{{__('Friday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="fristart" disabled name="workingtime[fri][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="friend" disabled name="workingtime[fri][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[sat][status]" class="form-check-input" type="checkbox" id="customsat">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customsat">{{__('Saturday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="satstart" disabled name="workingtime[sat][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="satend" disabled name="workingtime[sat][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input name="workingtime[sun][status]" class="form-check-input" type="checkbox" id="customsun">
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customsun">{{__('Sunday')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="sunstart" disabled name="workingtime[sun][start]" required>
                                    @foreach(getTimeInterval(1) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="sunend" disabled name="workingtime[sun][end]" required>
                                    @foreach(getTimeInterval(2) as $key => $val)
                                    <option value="{{$val}}">{{strtoupper($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Submit')}}</button>
                </div>
            </form>
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
                data: [<?php foreach ($user->bookingForTheMonth() as $val) {
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
                categories: [<?php foreach ($user->bookingForTheMonth() as $val) {
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
    'use strict';
    $(function() {
        $("#custommon").click(function() {
            if ($(this).is(":checked")) {
                $('#monstart').prop('disabled', false);
                $('#monend').prop('disabled', false);
            } else {
                $('#monstart').prop('disabled', true);
                $('#monend').prop('disabled', true);
            }
        });
        $("#customtue").click(function() {
            if ($(this).is(":checked")) {
                $('#tuestart').prop('disabled', false);
                $('#tueend').prop('disabled', false);
            } else {
                $('#tuestart').prop('disabled', true);
                $('#tueend').prop('disabled', true);
            }
        });
        $("#customwed").click(function() {
            if ($(this).is(":checked")) {
                $('#wedstart').prop('disabled', false);
                $('#wedend').prop('disabled', false);
            } else {
                $('#wedstart').prop('disabled', true);
                $('#wedend').prop('disabled', true);
            }
        });
        $("#customthu").click(function() {
            if ($(this).is(":checked")) {
                $('#thustart').prop('disabled', false);
                $('#thuend').prop('disabled', false);
            } else {
                $('#thustart').prop('disabled', true);
                $('#thuend').prop('disabled', true);
            }
        });
        $("#customfri").click(function() {
            if ($(this).is(":checked")) {
                $('#fristart').prop('disabled', false);
                $('#friend').prop('disabled', false);
            } else {
                $('#fristart').prop('disabled', true);
                $('#friend').prop('disabled', true);
            }
        });
        $("#customsat").click(function() {
            if ($(this).is(":checked")) {
                $('#satstart').prop('disabled', false);
                $('#satend').prop('disabled', false);
            } else {
                $('#satstart').prop('disabled', true);
                $('#satend').prop('disabled', true);
            }
        });
        $("#customsun").click(function() {
            if ($(this).is(":checked")) {
                $('#sunstart').prop('disabled', false);
                $('#sunend').prop('disabled', false);
            } else {
                $('#sunstart').prop('disabled', true);
                $('#sunend').prop('disabled', true);
            }
        });
    });

    function addresschange() {
        var selectedState = $("#state").find(":selected").val();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{route('user.address.state')}}",
            data: {
                state: selectedState
            },
            success: function(response) {
                console.log(response);
                if (response.trim() == '') {
                    $('#showCity').hide();
                    $('#city').removeAttr('required', '');
                } else {
                    $('#showCity').show();
                    $('#city').html(response);
                    $('#city').attr('required', '');
                }
            },
            error: function(err) {
                console.log(err)
            }
        });
    }
    $("#state").change(addresschange);

    function service() {
        var type = $("#service_type").find(":selected").val();
        if (type == 1) {
            $('#store').hide();
            $('#state').removeAttr('required', '');
            $('#city').removeAttr('required', '');
            $('#line_1').removeAttr('required', '');
            $('#postal_code').removeAttr('required', '');
        } else if (type == 2) {
            $('#store').show();
            $('#state').attr('required', '');
            $('#line_1').attr('required', '');
            $('#postal_code').attr('required', '');
        }
    }
    $("#service_type").change(service);
    service();
</script>
@endsection