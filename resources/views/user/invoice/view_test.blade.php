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
                <a href="{{route('download.invoice', ['id'=>$link->ref_id])}}" class="text-primary">{{__('Export to PDF')}}</a>
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
                <!--begin::Details-->
                <div class="d-flex flex-column py-1">
                  <h3 class="fw-boldest fs-6 mb-1">Billing For</h3>
                  <div class="text-dark fw-bold fs-6 mb-4">
                    @if($link->customer->company_name!=null)
                    {{$link->customer->company_name}}<br />
                    @endif 
                    {{$link->customer->first_name.' '.$link->customer->last_name}}<br /><br />{{$link->customer->email}}<br />{{$link->customer->phone}}<br /><br />
                    {{__('Address')}}: {{$link->customer->line_1}}<br />
                    @if($link->customer->line_2!=null)
                    {{__('Address 2')}}: {{$link->customer->line_2}}<br />
                    @endif
                    {{-- @if($link->customer->city!=null)
                    {{__('City')}}: {{$link->customer->shipcity->name}}<br />
                    @endif --}}
                    {{__('Country')}}: {{$link->customer->shipcountry->name}}<br />
                    @if($link->customer->state!=null)
                    {{__('State/County')}}: {{$link->customer->shipstate->name}}<br />
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
                    {{__('Ordered')}}: {{date("M j, Y", strtotime($link->created_at))}}<br />
                    Paid: @if($link->status==1)Yes @elseif($link->status==0)No @endif<br />
                    {{__('Reference')}}: {{$link->ref_id}}<br />
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
                      <td class="text-dark fw-boldest">
                        <h6 class="fw-boldest fs-6 mb-1">{{$val}}</h6>
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
                      <td>
                        <h3 class="fw-boldest fs-6 mb-1">Total</h3>
                      </td>
                      <td>
                        <h3 class="fw-boldest fs-6 mb-1">{{$link->bb->symbol.number_format(array_sum(json_decode($link->total)), 2)}}</h3>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            @if($link->status==0)
            <form role="form" action="{{ route('process.invoice')}}" method="post" id="payment-form">
              @csrf
              <input type="hidden" value="{{$link->ref_id}}" name="link">
              <input type="hidden" value="test" name="type">
              <div class="form-group row">
                <div class="col-lg-12">
                  <select class="form-control select" name="status" required>
                    <option value="">{{__('Select Transaction Response')}}</option>
                    <option value="1">{{__('Successful')}}</option>
                    <option value="2">{{__('Failed')}}</option>
                  </select>
                </div>
              </div>
              <div class="custom-control custom-control-alternative custom-checkbox mt-3">
                <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="terms" checked required>
                <label class="custom-control-label" for=" customCheckLogin">
                  <p class="text-muted">This transaction requires your consent before continuing. Read <a href="{{route('terms')}}">Terms & Conditions</a></p>
                </label>
              </div>
              @if($errors->has('terms'))
              <span class="fal  text-uppercase mt-3">{{$errors->first('terms')}}</span>
              @endif
              <div class="text-center">
                <button type="submit" name="action" value="test" class="btn btn-primary btn-block rounded-pill my-4"><i class="fal fa-external-link"></i> Pay</button>
              </div>
            </form>
            @endif
          </div>
        </div>
        <div class="text-center mb-3">
          <p class="text-default">Contact Merchant for any information on this payment</p>
          @if($merchant->support_email!=null)
          <a class="text-primary" href="mailto:{{$merchant->support_email}}">{{$merchant->support_email}}</a>
          @endif
          @if($merchant->support_phone!=null && $merchant->support_email!=null)<span class="text-primary">|</span>@endif
          @if($merchant->support_phone!=null)
          <a class="text-primary" href="tel:{{$merchant->support_phone}}">{{$merchant->support_phone}}</a>
          @endif
        </div>
        @if($merchant->social_links==1)
        <div class="text-center">
          @if($merchant->facebook!=null)
          <a href="{{$merchant->facebook}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/facebook-3.svg')}}" class="w-30px me-6" alt=""></a>
          @endif
          @if($merchant->twitter!=null)
          <a href="{{$merchant->twitter}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/twitter.svg')}}" class="w-30px me-6" alt=""></a>
          @endif
          @if($merchant->linkedin!=null)
          <a href="{{$merchant->linkedin}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/linkedin.svg')}}" class="w-30px me-6" alt=""></a>
          @endif
          @if($merchant->instagram!=null)
          <a href="{{$merchant->instagram}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/instagram-2-1.svg')}}" class="w-30px me-6" alt=""></a>
          @endif
          @if($merchant->youtube!=null)
          <a href="{{$merchant->youtube}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/youtube-3.svg')}}" class="w-30px me-6" alt=""></a>
          @endif
          @if($merchant->whatsapp!=null)
          <a href="{{$merchant->whatsapp}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/whatsapp.svg')}}" class="w-30px me-6" alt=""></a>
          @endif
        </div>
        @endif
        <div class="row justify-content-center mt-5">
          <a href="{{route('login')}}" class="@if($merchant->checkout_theme!=null)text-white @else text-danger @endif"><i class="fal fa-times"></i> Cancel Payment</a>
        </div>
      </div>
    </div>
  </div>
  @stop