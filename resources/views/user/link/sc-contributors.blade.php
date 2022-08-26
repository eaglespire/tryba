
@extends('userlayout')

@section('content')
<!-- Page content -->
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
                <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                    <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Contributors')}}</h1>
                    <ul class="breadcrumb fw-bold fs-base my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.sclinks')}}" class="text-muted text-hover-primary">{{__('Gigpot')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Contributors')}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body pt-3">
                        <!--begin::Table-->
                        <table id="kt_datatable_example_5" class="table align-middle table-row-dashed gy-5 gs-7">
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th class="w-10px">S/N</th>
                                    <th class="min-w-125px">{{__('Name')}}</th>
                                    <th class="min-w-50px">{{__('Amount')}}</th>
                                    <th class="min-w-150px">{{__('Date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($donors as $val)
                                <tr>
                                    <td>{{$loop->iteration}}.</td>
                                    <td class="d-flex align-items-center">
                                        <!--begin:: Avatar -->
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label fs-3 bg-light-primary text-primary">
                                            @if($val->anonymous==0)
                                                @if($val->user_id==null)
                                                    @php
                                                        $fff=App\Models\Transactions::whereref_id($val->ref_id)->first();
                                                    @endphp
                                                    {{ucwords(strtolower(substr($fff['first_name'],0,1)))}}
                                                @else
                                                    {{ucwords(strtolower(substr($user['first_name'],0,1)))}}
                                                @endif
                                            @else 
                                                {{ucwords(substr(Anonymous ,0,1))}}
                                            @endif
                                            </div>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::User details-->
                                        <div class="d-flex flex-column">
                                            <div class="text-gray-800 text-hover-primary mb-1">
                                            @if($val->anonymous==0)
                                                @if($val->user_id==null)
                                                    @php
                                                        $fff=App\Models\Transactions::whereref_id($val->ref_id)->first();
                                                    @endphp
                                                    {{ucwords(strtolower($fff['first_name'].' '.$fff['last_name']))}}
                                                @else
                                                    {{ucwords(strtolower($user['first_name'].' '.$xval->user['last_name']))}}
                                                @endif
                                            @else 
                                                {{__('Anonymous')}}
                                            @endif
                                            </div>
                                            <span>{{$val->email}}</span>
                                        </div>
                                        <!--begin::User details-->
                                    </td>
                                    <td>{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </form>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
    </div>
@stop