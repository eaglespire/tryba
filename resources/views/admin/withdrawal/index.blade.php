@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Settlements')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons">
                            <thead>
                                <tr>
                                    <th>{{__('S/N')}}</th>
                                    <th>{{__('Ref')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Amount')}}</th>                                                                     
                                    <th class="text-center">{{__('Charge')}}</th>                                                                     
                                    <th class="text-center">{{__('Status')}}</th>
                                    <th>{{__('Acct No')}}</th>
                                    <th>{{__('Sort code')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Last Update')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraw as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td> 
                                    <td>{{$val->reference}}</td>
                                    <td><a href="{{url('admin/manage-user')}}/{{$val->user['id']}}">{{$val->user['first_name'].' '.$val->user['last_name']}}</a></td>                              
                                    <td>{{view_currency2($val->currency).number_format($val->amount, 2, '.', '')}}</td>
                                    <td class="text-center">
                                        {{view_currency2($val->currency).number_format($val->charge, 2, '.', '')}}
                                    </td>
                                    <td>
                                        @if($val->status==0)
                                            <span class="badge badge-pill badge-danger">{{__('Unpaid')}}</span>
                                        @elseif($val->status==1)
                                            <span class="badge badge-pill badge-success">{{__('Paid')}}</span> 
                                        @elseif($val->status==2)
                                            <span class="badge badge-pill badge-info">{{__('Declined')}}</span>                                        
                                        @elseif($val->status==3)
                                            <span class="badge badge-pill badge-danger">{{__('Suspended for dispute')}}</span>
                                        @endif
                                    </td> 
                                    <td>{{$val->dbank['acct_no']}}</td>
                                    <td>{{$val->dbank['routing_number']}}</td>                                                                     
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>                  
                                </tr>                                 
                                @endforeach               
                            </tbody>                    
                        </table>
                    </div>
                </div>
                @foreach($withdraw as $k=>$val)
                <div class="modal fade" id="declinex{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card border-0 mb-0">
                                    <div class="card-header">
                                        <p class="text-sm">Issue - {{$val->comment}}.</p>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{__('Close')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-header">
                                        <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{__('Close')}}</button>
                                        <a  href="{{route('withdraw.delete', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{__('Proceed')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal fade" id="decline{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="{{route('withdraw.decline')}}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <input name="id" value="{{$val->id}}" type="hidden">
                                            <textarea type="text" name="reason" class="form-control" rows="5" placeholder="{{__('Provide reason for decline')}}" required></textarea>
                                        </div>
                                    </div>             
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success btn-block">{{__('Decline')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop