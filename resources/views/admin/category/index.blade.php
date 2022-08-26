@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <a data-toggle="modal" data-target="#create" href="" class="btn btn-sm btn-neutral mb-5"><i class="fad fa-plus"></i> {{__('Add Category')}}</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Product Categories')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th class="scope"></th>
                                    <th>{{ __('Name')}}</th>
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
                                                    <a class='dropdown-item' href="{{route('country.unpublish', ['id' => $val->id])}}"><i class="fad fa-ban"></i> {{__('Disable')}}</a>
                                                    @else
                                                    <a class='dropdown-item' href="{{route('country.publish', ['id' => $val->id])}}"><i class="fad fa-check"></i> {{__('Enable')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$val->name}}</td>
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
                                                        <a href="{{route('fc.delete', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
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
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Edit Category')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('fc.update')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">{{__('Name')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" value="{{$val->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">{{__('Details')}}</label>
                                <div class="col-lg-12">
                                    <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileLang" name="image" lang="en">
                                    <label class="custom-file-label" for="customFileLang">{{$val->image}}</label>
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
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Add Category')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('fc.create')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">{{__('Name')}}</label>
                                <div class="col-lg-12">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-12">{{__('Details')}}</label>
                                <div class="col-lg-12">
                                    <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileLangx" name="image" lang="en" required>
                                    <label class="custom-file-label" for="customFileLangx">{{__('Choose Media')}}</label>
                                </div>
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