
@extends('master')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h3 class="mb-0 font-weight-bolder">{{__('Transactions')}}</h3>
            </div>
            <div class="table-responsive py-4">
                <table class="table table-flush" id="datatable-buttons">
                    <thead>
                        <tr>
                        <th>SN</th>
                        <th>{{__('To')}}</th>
                        <th>{{__('From')}}</th>
                        <th>Status</th>
                        <th class="text-center">{{__('Reference ID')}}</th>
                        <th class="text-center">{{__('Track no')}}</th>
                        <th class="text-center">{{__('Type')}}</th>
                        <th class="text-center">{{__('Channel')}}</th>
                        <th class="text-center">{{__('Amount')}}</th>
                        <th class="text-center">{{__('Date')}}</th>
                        </tr>
                    </thead>
                    <tbody>  
                        @foreach($trans as $k=>$val)
                        @php
                        $check=App\Models\User::whereid($val->receiver_id)->count();
                        @endphp
                            <tr>
                            <td>{{++$k}}.</td>
                                <td>{{$val->first_name.' '.$val->last_name}} [{{$val->email}}]</td>
                                
                                <td>@if($check==1){{$val->receiver->first_name.' '.$val->receiver->last_name}}@else User Deleted @endif</td>
                                <td class="text-center">@if($val->status==0) Pending @elseif($val->status==1) Success @elseif($val->status==2) Failed @endif</td>

                                <td class="text-center">{{$val->ref_id}}</td>
                                <td class="text-center">{{$val->tracing_id}}</td>
                                <td class="text-center">
                                    @if($val->type==1) 
                                        Single Pot 
                                    @elseif($val->type==2) 
                                        Gig Pot
                                    @elseif($val->type==3) 
                                        Invoice                                     
                                    @elseif($val->type==4) 
                                        Merchant                                    
                                    @elseif($val->type==5) 
                                        Account Funding                                    
                                    @elseif($val->type==6) 
                                        Recurring                                    
                                    @elseif($val->type==7) 
                                        Product Order                                    
                                    @elseif($val->type==8) 
                                        Store Order
                                    @elseif($val->type==9) 
                                        Subscription Payment
                                    @endif
                                </td>
        
                                <td class="text-center">{{ucfirst($val->payment_type)}}</td>
                                <td class="text-center">
                                    {{view_currency2($val->currency).number_format($val->amount, 2, '.', '')}} 
                                </td>
                                <td class="text-center">{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p>Showing 1 to {{$trans->count()}} of {{ $trans->total() }} entries</p>
                    </div>
                    <div class="col-md-6 text-right">
                    {{ $trans->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
@stop