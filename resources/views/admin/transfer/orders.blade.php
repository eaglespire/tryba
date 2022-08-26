@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Orders')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons">
                            <thead>
                                <tr>
                                    <th>{{__('S/N')}}</th>
                                    <th>{{__('Ref')}}</th>
                                    <th>{{__('Vendor')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Phone')}}</th>
                                    <th>{{__('Product Name')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Total')}}</th>
                                    <th>{{__('Quantity')}}</th>
                                    <th>{{__('Shipping fee')}}</th>
                                    <th>{{__('Country')}}</th>
                                    <th>{{__('State')}}</th>
                                    <th>{{__('City')}}</th>
                                    <th>{{__('Postal code')}}</th>
                                    <th>{{__('line 1')}}</th>
                                    <th>{{__('line 2')}}</th>
                                    <th>{{__('Created')}}</th>
                                    <th>{{__('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td>#{{$val->ref_id}}</td>
                                    <td>{{$val->seller->first_name.' '.$val->seller->last_name}}</td>
                                    @if($val->customer_id!=null)
                                    <td>{{$val->buyer->first_name}} {{$val->buyer->last_name}}</td>
                                    <td>{{$val->buyer->email}}</td>
                                    <td>{{$val->buyer->phone}}</td>
                                    @else
                                    <td>{{$val->first_name}} {{$val->last_name}}</td>
                                    <td>{{$val->email}}</td>
                                    <td>{{$val->phone}}</td>
                                    @endif
                                    <td>{{$val->lala->name}}</td>
                                    <td>{{view_currency2($val->currency).number_format($val->amount, 2)}}</td>
                                    <td>{{view_currency2($val->currency).number_format($val->total, 2)}}</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>{{view_currency2($val->currency).$val->shipping_fee}}</td>
                                    <td>{{$val->shipcountry->name}}</td>
                                    <td>{{$val->shipstate->name}}</td>
                                    <td>{{$val->city}}</td>
                                    <td>{{$val->postal_code}}</td>
                                    <td>{{$val->line_1}}</td>
                                    <td>{{$val->line_2}}</td>
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
                                <p>Showing 1 to {{$orders->count()}} of {{ $orders->total() }} entries</p>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $orders->onEachSide(2)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop