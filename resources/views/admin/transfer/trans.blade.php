@extends('master')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h3 class="mb-0">{{__('Transactions')}}</h3>
            </div>
            <div class="table-responsive py-4">
                <table class="table table-flush" id="datatable-buttons">
                    <thead>
                        <tr>
                            <th>{{__('S / N')}}</th>
                            <th>{{__('From')}}</th>
                            <th>{{__('IP Address')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Reference ID')}}</th>
                            <th>{{__('Payment Type')}}</th>
                            <th>{{__('Created')}}</th>
                            <th>{{__('updated')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($links as $k=>$val)
                        <tr>
                            <td>{{++$k}}.</td>
                            <td>{{$val->first_name.' '.$val->last_name}} [{{$val->email}}]</td>
                            <td>{{$val->ip_address}}</td>
                            <td>
                                @if($val->status==0)
                                <span class="badge badge-pill badge-light-primary">{{__('Pending')}}</span>
                                @elseif($val->status==1)
                                <span class="badge badge-pill badge-light-success">{{__('Success')}}</span>
                                @elseif($val->status==2)
                                <span class="badge badge-pill badge-light-danger">{{__('Failed/Cancelled')}}</span>
                                @endif
                            </td>
                            <td>{{view_currency2($val->currency).number_format($val->amount, 2)}}</td>
                            <td>{{$val->ref_id}}</td>
                            <td>{{$val->payment_type}}</td>
                            <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                            <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p>Showing 1 to {{$links->count()}} of {{ $links->total() }} entries</p>
                    </div>
                    <div class="col-md-6 text-right">
                        {{ $links->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>

        @stop