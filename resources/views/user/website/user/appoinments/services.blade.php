@extends('user.website.user.index')
@section('mainpage')
<div class="row g-xl-8">
    <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <table id="kt_datatable_example_7" class="table align-middle table-row-dashed gy-5 gs-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th class=""></th>
                                <th class="min-w-80px">{{__('Image')}}</th>
                                <th class="min-w-80px">{{__('Title')}}</th>
                                <th class="min-w-70px">{{__('Price')}}</th>
                                <th class="min-w-50px">{{__('Duration')}}</th>
                                <th class="min-w-100px">{{__('Created')}}</th>
                                <th class="min-w-100px">{{__('Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->allServices() as $val)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click">
                                        <span class="svg-icon svg-icon-3 svg-icon-primary">
                                            <i class="fal fa-chevron-circle-down"></i>
                                        </span>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                        </div>
                                        <div class="menu-item px-3"><a href="{{ route('getUpdate.service',$val->id) }}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#service_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                    </div>
                                </td>
                                <td><img src="{{ $val->image }}" class="w-40px h-40px" alt=""></td>
                                <td onclick="window.location='{{route('getUpdate.service',$val->id)}}';">{{$val->name}}</td>
                                <td onclick="window.location='{{route('getUpdate.service',$val->id)}}';">{{ $currency->symbol.number_format($val->price,2) }}</td>
                                <td onclick="window.location='{{route('getUpdate.service',$val->id)}}';">{{$val->duration}} @if($val->duration > 1) {{ str_plural($val->durationType) }} @else {{ $val->durationType }} @endif</td>
                                <td onclick="window.location='{{route('getUpdate.service',$val->id)}}';">{{ $val->created_at->diffforHumans() }}</td>
                                <td onclick="window.location='{{route('getUpdate.service',$val->id)}}';">{{ ($val->status) ? "Active" : "Disabled" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @foreach($user->services() as $val)
            <div class="modal fade" tabindex="-1" id="service_delete{{$val->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{__('Delete Service')}}</h5>
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p>{{__('Are you sure you want to delete this?')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <a href="{{route('delete.service', ['id' => $val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection