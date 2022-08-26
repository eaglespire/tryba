@extends('user.website.user.index')
@section('mainpage')
<div class="row g-xl-8">
    <div class="col-xl-12">
        <div class="row g-5 g-xxl-8 mb-6">
            @if(count($user->completedAppointment())>0)
            @foreach($user->completedAppointment() as $val)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="d-flex flex-stack mb-2 px-3 py-2 ms-n3">
                            <div class="pe-2">
                                <h3 class="fw-boldest text-dark fs-6x">{{Carbon\Carbon::create($val->d_date)->toFormattedDateString()}} </h3>
                                <div class="fw-bold mt-1 mb-1">{{__('Time')}}: {{Carbon\Carbon::create($val->d_time)->format('H:i').' - '.Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i')}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Duration')}}: {{$val->duration}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Reference')}}: {{$val->ref_id}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Service')}}: {{$val->service->name}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Amount')}}: {{$currency->symbol.number_format($val->total, 2)}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Payment Method')}}: {{ucwords($val->payment_method)}}</div>
                            </div>
                            <div class="pe-2">
                                <h3 class="fw-boldest text-dark fs-6x">{{__('Customer')}} </h3>
                                <div class="fw-bold mt-1 mb-1">{{__('Name')}}: {{$val->buyer->first_name.' '.$val->buyer->last_name}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Email')}}: {{$val->buyer->email}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Phone')}}: {{$val->buyer->phone}}</div>
                                @if($val->line_1!=null)
                                <div class="fw-bold mt-1 mb-1">{{__('State')}}: {{$val->shipstate->name}}</div>
                                @if($val->city!=null)
                                <div class="fw-bold mt-1 mb-1">{{__('City')}}: {{$val->city}}</div>
                                @endif
                                <div class="fw-bold mt-1 mb-1">{{__('Postal code')}}: {{$val->postal_code}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('line 1')}}: {{$val->line_1}}</div>
                                @if($val->line_2!=null)
                                <div class="fw-bold mt-1 mb-1">{{__('line 2')}}: {{$val->line_2}}</div>
                                @endif
                                @endif
                            </div>
                        </div>
                        @if($val->review==null)
                        <div class="col-xl-12 mb-10 mb-xl-0 mt-3">
                            <div class="tt-rating">
                                <i class="fal fa-star @if($val->rating>0) checked @endif"></i>
                                <i class="fal fa-star @if($val->rating>1) checked @endif"></i>
                                <i class="fal fa-star @if($val->rating>2) checked @endif"></i>
                                <i class="fal fa-star @if($val->rating>3) checked @endif"></i>
                                <i class="fal fa-star @if($val->rating>4) checked @endif"></i>
                            </div>
                            <div class="fs-5 fw-bold text-gray-600">
                                @if($val->review==null)
                                {{__('No review')}}
                                @else
                                {{$val->review}}
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            @endforeach
            @else
            <div class="card-px text-center py-20 my-10">
                <div class="text-center px-5 mb-4">
                    <i class="fal fa-folders fa-5x"></i>
                </div>
                <p class="fs-2 fw-bold mb-0">{{__('No Completed Appointment found')}}</p>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $user->completedAppointment()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection