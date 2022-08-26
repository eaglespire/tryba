@extends('master')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-header">
        <h3 class="mb-0 font-weight-bolder">{{__('Transactions')}}</h3>
      </div>
      <div class="table-responsive py-4">
        <table class="table table-flush" id="datatable-buttons">
          <thead>
            <tr>
              <th>{{__('S / N')}}</th>
              <th>{{__('Reference ID')}}</th>
              <th>{{__('Status')}}</th>
              <th>{{__('Amount')}}</th>
              <th>{{__('Created')}}</th>
              <th>{{__('updated')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transfer as $k=>$val)
            @php
            $fff=App\Models\Merchant::wheremerchant_key($val->merchant_key)->first();
            @endphp
            <tr>
              <td>{{++$k}}.</td>
              <td>{{$val->reference}}</td>
              <td>
                @if($val->status==0) <span class="badge badge-pill badge-info"><i class="fad fa-spinner"></i> Pending - @if($val->payment_type!=null){{$val->payment_type}} @else No payment type @endif | @if($val->user_id==$user->id) Debit @else Credit @endif</span>
                @elseif($val->status==1) <span class="badge badge-pill badge-success"><i class="fad fa-check"></i> Paid - @if($val->payment_type!=null){{$val->payment_type}} @else No payment type @endif | @if($val->user_id==$user->id) Debit @else Credit @endif</span>
                @elseif($val->status==2) <span class="badge badge-pill badge-danger"><i class="fad fa-window-close"></i> Cancelled - @if($val->payment_type!=null){{$val->payment_type}} @else No payment type @endif | @if($val->user_id==$user->id) Debit @else Credit @endif</span>
                @elseif($val->status==3) <span class="badge badge-pill badge-danger"><i class="fad fa-ban"></i> Abandoned - @if($val->payment_type!=null){{$val->payment_type}} @else No payment type @endif | @if($val->user_id==$user->id) Debit @else Credit @endif</span>
                @elseif($val->status==4) <span class="badge badge-pill badge-primary"><i class="fad fa-house-return"></i> Refunded - @if($val->payment_type!=null){{$val->payment_type}} @else No payment type @endif | @if($val->user_id==$user->id) Debit @else Credit @endif</span>
                @endif
              </td>
              <td>
                {{view_currency2($val->currency).number_format($val->amount-$val->charge, 2, '.', '')}}
              </td>
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
                        <p>Showing 1 to {{$transfer->count()}} of {{ $transfer->total() }} entries</p>
                    </div>
                    <div class="col-md-6 text-right">
                        {{ $transfer->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
    </div>

    @stop