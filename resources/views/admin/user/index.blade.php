@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h3 class="mb-0">{{__('Users')}}</h3>
            </div>
            <div class="table-responsive py-4">
                <table class="table table-flush" id="datatable-buttons">
                    <thead>
                        <tr>
                            <th>{{__('S/N')}}</th>
                            <th class="scope"></th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Plan')}}</th>
                            <th>{{__('Monthly Income')}}</th>
                            <th>{{__('Monthly Amount')}}</th>
                            <th>{{__('Expiring Date')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Balance')}}</th>
                            <th>{{__('Registered')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $k=>$val)
                        <tr>
                            <td>{{++$k}}.</td>
                            <td class="">
                            <div class="dropdown">
                                    <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fad fa-chevron-circle-down"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="{{route('user.manage', ['id' => $val->id])}}" class="dropdown-item">{{__('Manage customer')}}</a>
                                        <a href="{{route('admin.email', ['email' => $val->email, 'name' => $val->first_name.' '.$val->last_name])}}" class="dropdown-item">{{__('Send email')}}</a>
                                        @if($val->status==0)
                                            <a class='dropdown-item' href="{{route('admin.suspend', ['id' => $val->id])}}">{{__('Suspend')}}</a>
                                        @else
                                            <a class='dropdown-item' href="{{route('user.unblock', ['id' => $val->id])}}">{{__('Activate')}}</a>
                                        @endif
                                        @if($val->isBlocked == false)
                                            <a class='dropdown-item' href="{{route('user.block', ['id' => $val->id])}}">{{__('Terminate')}}</a>
                                        @endif
                                        <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{__('Delete')}}</a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $val->first_name.' '.$val->last_name }}</td>
                            <td>
                                @if($val->plan)
                                    {{ucwords($val->plan->name)}}
                                @else
                                    No Active plan
                                @endif
                            </td>
                            <td>{{ view_currency2($val->coin['coin_id']).number_format(GetUserMonthlyTransactions($val->id)) }}</td>
                            <td>
                                @if($val->plan)
                                    {{ view_currency($val->plan->currency_id) }}{{  $val->plan->amount }}/{{  $val->plan->durationType }}
                                @else
                                    No Active plan
                                @endif</td>
                            <td>{{date("d, M Y", strtotime($val->plan_expiring))}}</td>
                            <td>{{$val->email}}</td>
                            <td>
                                @if($val->isBlocked == true)
                                    <span class="badge badge-pill badge-danger">{{__('Terminated')}}</span>
                                @elseif($val->status==0)
                                    <span class="badge badge-pill badge-primary">{{__('Active')}}</span>
                                @elseif($val->status==1)
                                    <span class="badge badge-pill badge-warning">{{__('Suspended')}}</span>
                                @endif
                            </td>

                            <td>{{view_currency2($val->coin['coin_id']).number_format($val->balance,'2','.','')}}</td>
                            <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p>Showing 1 to {{$users->count()}} of {{ $users->total() }} entries</p>
                    </div>
                    <div class="col-md-6 text-right">
                        {{ $users->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
        @foreach($users as $k=>$val)
        <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card bg-white border-0 mb-0">
                            <div class="card-header">
                                <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                            </div>
                            <div class="card-body  d-flex  px-lg-5 py-lg-5 text-right">
                                <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{__('Close')}}</button>
                                <form method="post" action="{{ route('user.delete', ['id' => $val->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" class="btn btn-danger btn-sm" value="{{__('Proceed')}}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
@stop
