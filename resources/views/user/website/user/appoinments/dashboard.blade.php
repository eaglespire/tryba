@extends('user.website.user.index')
@section('mainpage')
<div class="row g-xl-8">
    <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header align-items-center mt-2 border-0">
                        <h3 class="fw-boldest text-dark fs-6x">{{__('Upcoming Appointment')}}</h3>
                        <div class="text-dark-400 fw-bold fs-6">{{$user->pendingAppointmentCount()}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header align-items-center mt-2 border-0">
                        <h3 class="fw-boldest text-dark fs-6x">{{__('Completed Appointment')}}</h3>
                        <div class="text-dark-400 fw-bold fs-6">{{$user->completedAppointmentCount()}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header align-items-center mt-2 border-0">
                        <h3 class="fw-boldest text-dark fs-6x">{{__('Services')}}</h3>
                        <div class="text-dark-400 fw-bold fs-6">{{$user->bookingServices()}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center mt-2 border-0">
                        <h3 class="fw-boldest text-dark fs-6x">{{__('Revenue')}}</h3>
                        <div class="text-dark-400 fw-bold fs-6">{{number_format($user->bookingSum(), 2).$currency->name}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body p-0 d-flex justify-content-between flex-column">
                        <div class="d-flex flex-stack card-p flex-grow-1">
                            <!--begin::Icon-->
                            <div class="symbol symbol-45px">
                                <div class="symbol-label">
                                    <i class="fal fa-sync text-primary"></i>
                                </div>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column text-end">
                                <span class="fw-boldest text-dark fs-2">{{__('Bookings')}}</span>
                                <span class="text-dark-400 fw-bold fs-6">{{date("M, d", strtotime(Carbon\Carbon::now()->startOfMonth()))}} - {{date("M, d Y", strtotime(Carbon\Carbon::now()->endOfMonth()))}}</span>
                                <span class="text-dark-400 fw-bold fs-6">{{number_format($user->bookingForTheMonthSum(),2).$currency->name}}</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--begin::Chart-->
                        <div class="">
                            @if(count($user->bookingForTheMonth())>0)
                            <div id="kt_chart_earning" class="card-rounded-bottom h-125px"></div>
                            @else
                            <div class="card-rounded-bottom h-125px text-center text-primary">{{__('No data')}}</div>
                            @endif
                        </div>
                        <!--end::Chart-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection