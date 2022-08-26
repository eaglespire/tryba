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
                    <a href="{{route('user.appointment.pending')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Reschedule')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Reschedule')}}</h3>
                </div>
            </div>
            <form action="{{route('update.schedule', ['id'=>$booking->id])}}" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="calendar-part">
                        <div id="calendar"></div>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Select your time of choice')}}</label>
                        <select class="form-select form-select-solid" name="time" id="time-list" required>

                        </select>
                    </div>
                    <div id="time-list2"></div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Update')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>
    $(document).ready(function() {
        var count = 1;
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('store.calender', ['id'=>$user->storefront()->store_url])}}",
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
                        url: "{{route('store.availabletime', ['id'=>$user->storefront()->store_url])}}",
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