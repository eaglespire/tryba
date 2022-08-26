@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <a data-toggle="modal" data-target="#create" href="" class="btn btn-sm btn-neutral mb-5"><i class="fad fa-plus"></i> {{__('Add Category')}}</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('MCC')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th class="scope"></th>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Type')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{ __('Created')}}</th>
                                    <th>{{ __('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        <div class="">
                                            <div class="dropdown">
                                                <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fad fa-chevron-circle-down"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item"><i class="fad fa-trash"></i> {{ __('Delete')}}</a>
                                                    <a data-toggle="modal" data-target="#update{{$val->id}}" href="" class="dropdown-item"><i class="fad fa-pencil"></i> {{ __('Edit')}}</a>
                                                    @if($val->status==1)
                                                    <a class='dropdown-item' href="{{route('mcc.disable', ['id' => $val->id])}}"><i class="fad fa-ban"></i> {{__('Disable')}}</a>
                                                    @else
                                                    <a class='dropdown-item' href="{{route('mcc.active', ['id' => $val->id])}}"><i class="fad fa-check"></i> {{__('Enable')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$val->name}}</td>
                                    <td>
                                        @if($val->type==1)
                                        <span class="badge badge-pill badge-primary">Ecommerce</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Services</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->status==1)
                                        <span class="badge badge-pill badge-primary"><i class="fad fa-check"></i> {{__('Active')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger"><i class="fad fa-ban"></i> {{__('Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                                </tr>
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
                                                        <a href="{{route('mcc.delete', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach($category as $k=>$val)
        <div class="modal fade" id="update{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Edit MCC')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('mcc.update')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">{{__('Name')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" value="{{$val->name}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{__('Type')}}</label>
                                <select class="form-control select" name="type">
                                    <option value="1" @if($val->type==1)selected @endif</option>{{__('Ecommerce')}}</option>
                                    <option value="2" @if($val->type==2)selected @endif>{{__('Service')}}</option>
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
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Add MCC')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('mcc.create')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">{{__('Name')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{__('Type')}}</label>
                                <select class="form-control select" name="type">
                                    <option value="1">{{__('Ecommerce')}}</option>
                                    <option value="2">{{__('Service')}}</option>
                                </select>
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-success btn-block">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @stop