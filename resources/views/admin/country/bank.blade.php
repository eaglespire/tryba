@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
    <a data-toggle="modal" data-target="#create" href="" class="btn btn-sm btn-neutral mb-5"><i class="fa fa-plus"></i> {{__('Add Bank')}}</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h3 class="card-title">{{ __('Banks for ')}}{{$location->real->name}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th class="scope"></th>   
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Identification Code')}}</th>
                                    <th>{{ __('Created')}}</th>
                                    <th>{{ __('Updated')}}</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($bank as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fad fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{ __('Delete')}}</a>
                                                <a data-toggle="modal" data-target="#update{{$val->id}}" href="" class="dropdown-item">{{ __('Edit')}}</a>
                                            </div>
                                        </div>
                                    </td>  
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->code}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>                   
                                </tr>
                                @endforeach               
                            </tbody>                    
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach($bank as $k=>$val)
        <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card bg-white border-0 mb-0">
                            <div class="card-header">
                                <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                            </div>
                            <div class="card-body px-lg-5 py-lg-5 text-right">
                                <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
                                <a  href="{{route('lbank.delete', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
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
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Edit Bank')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('clbank.update')}}" method="post">
                            @csrf
                            <input name="country" type="hidden" value="{{$country_id}}">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{$val->name}}" required>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" name="code" class="form-control" maxlength="5" value="{{$val->code}}" placeholder="Code" required>
                                </div>
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
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">   
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Add Bank')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.createclbank')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" name="code" class="form-control" maxlength="5" placeholder="Code" required>
                                </div>
                            </div>
                            <input name="id" type="hidden" value="{{$country_id}}">
                            <div class="text-left">
                                <button type="submit" class="btn btn-success btn-block">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@stop