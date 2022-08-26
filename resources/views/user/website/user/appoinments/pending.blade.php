@extends('user.website.user.index')
@section('mainpage')
<div class="row g-xl-8">
    <div class="col-xl-12">
        <div class="row g-5 g-xxl-8 mb-6">
            @if(count($user->pendingAppointment())>0)
            @foreach($user->pendingAppointment() as $val)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <h3 class="fw-boldest text-dark fs-6x">{{Carbon\Carbon::create($val->d_date)->toFormattedDateString()}} </h3>
                                <div class="fw-bold mt-1 mb-1">{{__('Time')}}: {{Carbon\Carbon::create($val->d_time)->format('H:i').' - '.Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i')}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Duration')}}: {{$val->duration}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Reference')}}: {{$val->ref_id}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Service')}}: {{$val->service->name}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Amount')}}: {{$currency->symbol.number_format($val->total, 2)}}</div>
                                <div class="fw-bold mt-1 mb-1">{{__('Payment Method')}}: {{ucwords($val->payment_method)}}</div>
                            </div>
                            <div class="col-md-6">
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
                    </div>
                    <div class="card-footer">
                        <a href="{{route('user.appointment.reschedule', ['id' => $val->id])}}" class="btn btn-light-primary me-2 mb-2"><i class="fal fa-sync"></i> {{__('Reschedule')}}</a>
                        <a href="{{route('customer.send.email', ['id' => $val->customer_id])}}" class="btn btn-light-primary me-2 mb-2"><i class="fal fa-envelope"></i> {{__('Email Customer')}}</a>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calendar{{$val->id}}"><i class="fal fa-calendar-alt"></i> {{__('Add to Calendar')}}</a>
                    </div>
                    <div class="modal fade" id="calendar{{$val->id}}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-550px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Select Calendar')}}</h3>
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
                                    <a target="_blank" href="{{calendar_apple(Carbon\Carbon::create($val->d_time)->format('H:i'), Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i'), $val->service->name, $val->service->description)}}">
                                        <div class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 mb-8">
                                            <span class="d-flex">
                                                <span class="ms-4">
                                                    <span class="fs-4 fw-boldest text-gray-900 mb-2 d-block">{{__('Apple Calendar')}}</span>
                                                </span>
                                            </span>
                                        </div>
                                    </a>
                                    <a target="_blank" href="{{calendar_google(Carbon\Carbon::create($val->d_time)->format('H:i'), Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i'), $val->service->name, $val->service->description)}}">
                                        <div class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6">
                                            <span class="d-flex">
                                                <span class="ms-4">
                                                    <span class="fs-4 fw-boldest text-gray-900 mb-2 d-block">{{__('Google Calendar')}}</span>
                                                </span>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="card-px text-center py-20 my-10">
                <div class="text-center px-5 mb-4">
                    <i class="fal fa-folders fa-5x"></i>
                </div>
                <p class="fs-2 fw-bold mb-0">{{__('No Pending Appointment found')}}</p>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $user->pendingAppointment()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection