
@extends('master')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-header header-elements-inline">
        <h3 class="mb-0">{{__('Charges')}}</h3>
      </div>
      <div class="table-responsive py-4">
        <table class="table table-flush" id="datatable-buttons">
          <thead>
            <tr>
              <th>{{__('S / N')}}</th>
              <th>{{__('Amount')}}</th>
              <th>{{__('Real Amount')}}</th>
              <th>{{__('Reference ID')}}</th>
              <th>{{__('Log')}}</th>
              <th>{{__('Created')}}</th>
            </tr>
          </thead>
          <tbody>  
            @foreach($charges as $k=>$val)
              <tr>
                <td>{{++$k}}.</td>
                <td>{{$val->user->coin->bb->symbol.number_format((float)$val->amount,2, '.', '')}}</td>
                <td>${{number_format((float)$val->real_amount,2, '.', '')}}</td>
                <td>#{{$val->ref_id}}</td>
                <td>{{$val->log}}</td>
                <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

@stop