@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">{{$title}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.country.transfer.update')}}" method="post">
                    @csrf   
                    <input type="hidden" name="id" value="{{$transfer->id}}">
                    <p>Transfer Charge</p>                     
                    <div class="form-group row">                                     
                        <label class="col-form-label col-lg-3">{{__('Maximum Transfer daily')}}<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">{{$transfer->coin->symbol}}</span>
                                </span>
                                <input type="number" step="any" name="max_transfer" value="{{$transfer->max_transfer}}" class="form-control" required>
                            </div>
                        </div>      
                    </div>                     
                    <div class="form-group row">                                     
                        <label class="col-form-label col-lg-3">{{__('Minimum Transfer')}}<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">{{$transfer->coin->symbol}}</span>
                                </span>
                                <input type="number" step="any" name="min_transfer" value="{{$transfer->min_transfer}}" class="form-control" required>
                            </div>
                        </div>      
                    </div>           
                    <div class="text-right">
                        <button type="submit" class="btn btn-neutral btn-block">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 font-weight-bolder">{{__('Supported Countries')}} {{$transfer->real->name}} {{__('can transfer to')}}</h3>
            </div>             
            <div class="card-body">
                <form action="{{route('admin.country.transfer.list.new')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <select class="form-control custom-select" name="to_id" required>
                                <option value="">Select Country</option>
                                @foreach($all as $val)
                                    <option value="{{$val->real->id}}-{{$val->id}}">{{$val->real->name}} - {{$val->bb->name}}</option>
                                @endforeach
                            </select>
                        </div>       
                    </div> 
                    <div class="form-group row">
                        <div class="col-lg-12">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">{{$transfer->bb->symbol}}</span>
                            </span>
                            <input type="number" step="any" name="rate" class="form-control" placeholder="{{__('Rate to selected country')}}" required>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">                                    
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">{{$transfer->bb->symbol}}</span>
                                </span>
                                <input type="number" step="any" name="charge" class="form-control" placeholder="{{__('Charge')}}" required>
                            </div>
                        </div>      
                    </div> 
                    <input type="hidden" value="{{$transfer->real->id}}" name="country_id"> 
                    <div class="text-right">
                        <button type="submit" class="btn btn-neutral btn-block"><i class="fad fa-external-link"></i> {{__('Add Country')}}</button>
                    </div>
                </form>
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group list-group-flush list">
                            @if(count($list)>0)
                                @foreach($list as $k=>$val)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <span class="text-xs">{{$val->to->name}} [1 {{$val->to->iso3}} => {{$transfer->bb->symbol}}{{$val->rate}}] Charge - {{$transfer->bb->symbol}}{{$val->charge}} @if($val->status==1)[Active] @else [Disabled] @endif</span>
                                            </div>                                      
                                            <div class="col-auto">
                                            <a data-toggle="modal" data-target="#update{{$val->id}}" href="" class="btn btn-sm btn-success"><i class="fad fa-check"></i> {{__('Update Rate')}}</a>
                                            <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="btn btn-sm btn-danger"><i class="fad fa-trash"></i> {{__('Delete')}}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card bg-white border-0 mb-0">
                                                        <div class="card-header">
                                                            <h3 class="mb-0 font-weight-bolder">{{__('Delete')}} {{$val->to->name}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <span class="mb-0 text-xs">{{__('Are you sure you want to delete this?, If you delete this, clients in ')}}{{$transfer->real->name}} won't be able to transfer to {{$val->to->name}}</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <a  href="{{route('country.transfer.delete', ['id' => $val->id])}}" class="btn btn-danger btn-block">{{__('Proceed')}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="update{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">   
                                                    <h3 class="mb-0 h3 font-weight-bolder">{{__('Update Country Rate')}}</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('country.transfer.update')}}" method="post">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-prepend">
                                                                        <span class="input-group-text">{{$transfer->bb->symbol}}</span>
                                                                    </span>
                                                                    <input type="number" step="any" name="rate" class="form-control" value="{{$val->rate}}" required>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group row">                                    
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-prepend">
                                                                        <span class="input-group-text">{{$transfer->bb->symbol}}</span>
                                                                    </span>
                                                                    <input type="number" step="any" name="charge" placeholder="{{__('Charge')}}" class="form-control"value="{{$val->charge}}" required>
                                                                </div>
                                                            </div>      
                                                        </div> 
                                                        <div class="form-group">
                                                            <label>{{__('Status')}}</label>
                                                            <select class="form-control select" name="status">
                                                                <option value="1" @if($val->status==1)selected @endif>{{__('Active')}}</option>
                                                                <option value="0" @if($val->status==0) selected @endif>{{__('Deactive')}}</option>
                                                            </select>
                                                        </div> 
                                                        <input type="hidden" name="id" value="{{$val->id}}">
                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-success btn-block">{{__('Save')}}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="row text-center">
                                <div class="col-md-12 mb-5">
                                <div class="text-center mt-8">
                                    <div class="mb-3">
                                    <img src="{{url('/')}}/asset/images/empty.svg">
                                    </div>
                                    <h3 class="text-dark">No Country Found</h3>
                                    <p class="text-dark text-sm card-text">We couldn't find any country {{$transfer->real->name}} can transfer to</p>
                                </div>
                                </div>
                            </div>
                            @endif
                        </ul>                   
                    </div>                   
                </div>                   
            </div>   
        </div> 
@stop