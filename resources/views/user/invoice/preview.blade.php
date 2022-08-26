@extends('user.invoice.master')

@section('content')
<div class="main-content">
  <div class="header py-5 pt-5">
    <div class="container">
      <div class="header-body text-center mb-7">
      </div>
    </div>
  </div>
  <div class="container mt--8 pb-5 mb-0">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card paper-effect rounded-0 border-top border-info">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-6">
                <h3 class="fw-boldest fs-2">{{__('Invoice')}}</h3>
                <a href="{{route('download.invoice', ['id'=>$link->ref_id])}}"  class="btn btn-primary mb-3" >{{__('Export to PDF')}}</a>
              </div>
              <div class="col-lg-6 text-right">
                <div class="">
                  <img style="max-width:30%;" src="{{asset('asset/'.$logo->image_link)}}" alt="image" />
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
              <?php //dd($link); ?>
                <!--begin::Details-->
                <div class="d-flex flex-column py-1">
                  <h3 class="fw-boldest fs-6 mb-1">Billing For</h3>
                  <div class="text-dark fw-bold fs-6 mb-4">
                    @if($link->customer->company_name!=null)
                      {{$link->customer->company_name}}<br />
                    @endif 
                    {{$link->customer->first_name.' '.$link->customer->last_name}}<br/>{{$link->customer->email}}<br />{{$link->customer->phone}}<br /><br />
                    {{__('Address')}}: {{$link->customer->line_1}}<br />
                    @if($link->customer->line_2!=null)
                    {{__('Address 2')}}: {{$link->customer->line_2}}<br />
                    @endif
                    @if($link->customer->city!=null)
                    {{__('City')}}: {{$link->customer->city }}<br />
                    @endif
                    {{__('Country')}}: {{ $link->customer->shipcountry->name }} <br/>
                    @if($link->customer->state!=null)
                    {{__('County')}}: {{$link->customer->shipstate->name}}<br />
                    @endif
                    {{__('Zip/Postal code')}}: {{$link->customer->postal_code}}<br />
                  </div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Customer-->
              <!--begin::Contacts-->
              <div class="col-lg-6 fs-6 fw-bold text-right text-dark">
                <h3 class="fw-boldest fs-6 mb-1">From</h3>
                {{$link->user->first_name.' '.$link->user->last_name}}<br />
                @if($link->user->support_email!=null)
                {{$link->user->support_email}}<br />
                @endif
                {{$link->user->support_phone}}
              </div>
              <!--end::Contacts-->
            </div>
            <hr class="bg-dark mt-0 mb-3">
            <div class="row">
              <div class="col-lg-6">
                <!--begin::Details-->
                <div class="d-flex flex-column py-1">
                  <div class="text-dark fw-bold fs-6 mb-4">
                    Ordered: {{date("M j, Y", strtotime($link->created_at))}}<br />
                    Paid: @if($link->status==1)Yes @elseif($link->status==0)No @elseif($link->status==3) Partial Payment @endif<br />
                    {{__('Reference')}}: {{$link->ref_id}}<br />
                    {{__('Type')}}: {{ ucwords($link->invoice_type)}} Payment<br />
                    {{__('Due by')}}: {{$link->due_date}}<br />
                  </div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Customer-->
            </div>
            <div class="card bg-white">
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead>
                    <tr class="line">
                      <th class="text-dark fw-boldest">{{__('Description')}}</th>
                      <th class="text-dark fw-boldest">{{__('Qty')}}</th>
                      <th class="text-dark fw-boldest">{{__('Tax')}}</th>
                      <th class="text-dark fw-boldest">{{__('Discount')}}</th>
                      <th class="text-dark fw-boldest">{{__('Unit price')}}</th>
                      <th class="text-dark fw-boldest">{{__('Amount')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(json_decode($link->item) as $key=>$val)
                    <tr>
                      <td class="text-dark fw-boldest"><h6 class="fw-boldest fs-6 mb-1">{{$val}}</h6>
                        <p class="m-0 text-dark">
                          {{$notes[$key]}}
                        </p>
                      </td class="text-dark fw-boldest">
                      <td class="text-dark fw-boldest">x{{$quantity[$key]}} </td>
                      <td class="text-dark fw-boldest">@if($tax[$key]!=0){{number_format($tax[$key], 2)}}% @endif</td>
                      <td class="text-dark fw-boldest">@if($discount[$key]!=0){{number_format($discount[$key], 2)}}% @endif</td>
                      <td class="text-dark fw-boldest">{{$link->bb->symbol.number_format($amount[$key], 2)}}</td>
                      <td class="text-dark fw-boldest">{{$link->bb->symbol.number_format($total[$key], 2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><h3 class="fw-boldest fs-6 mb-1">Total</h3></td>
                      <td><h3 class="fw-boldest fs-6 mb-1">{{$link->bb->symbol.number_format(array_sum(json_decode($link->total)), 2)}}</h3></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <form action="{{route('submit.preview')}}" method="post" id="payment-form">
              @csrf
              <input type="hidden" name="id" value="{{$invoice->id}}">
              @if($invoice->status==0)
              <div class="text-center">
                <button type="submit" id="btnlogin" class="btn btn-primary btn-block mb-3">{{__('Send Invoice')}}</button>
                <span class="text-dark">Edit Invoice, <a href="{{route('edit.invoice', ['id' => $invoice->ref_id])}}">Click here</a></span>
              </div>
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-5">
      <a class="text-white" href="{{ route('user.invoice')}}"><i class="fal fa-arrow-left"></i> Back to Invoice</a>
    </div>
    @stop
