@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Custom Domain')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th class="scope"></th>
                                    <th>{{ __('Domain')}}</th>
                                    <th>{{ __('User')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{ __('Created')}}</th>
                                    <th>{{ __('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($domains as $k => $val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        @if($val->status==0)
                                        <a class="btn btn-success btn-sm" href="{{route('domain.active', ['id' => $val->id])}}"><i class="fad fa-check"></i> {{__('Enable')}}</a>
                                        @endif
                                    </td>
                                    <td>{{ $val->domain }}</td>
                                    <td>{{  $val->user->first_name }} {{  $val->user->last_name }}</td>
                                    <td>
                                        @if($val->status== 'active')
                                        <span class="badge badge-pill badge-primary"><i class="fad fa-check"></i> {{__('Active')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger"><i class="fad fa-ban"></i> {{__('Pending')}}</span>
                                        @endif
                                    </td>
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
        @stop