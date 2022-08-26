@extends('checkoutlayout')

@section('content')

<div class="main-content">
<div class="header py-5 pt-7">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                <div class="card-profile-image mb-5">
                  <img src="{{asset('asset/'.$logo->image_link)}}">
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
    <div class="container mt--8 pb-5 mb-0">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header text-center">
                <h3 class="mb-1 mt-5 font-weight-bold">{{__('Receipt from')}} {{$set->site_name}} </h3>
                <span class="text-dark">{{__('Receipt')}} #{{$trans->ref_id}} [{{__('PAID')}}]</span>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <div class="row justify-content-between align-items-center">
                <div class="col">
                  <div class="my-4">
                    <h3 class="mb-1 h5 text-dark">{{__('AMOUNT PAID')}}</h3>
                    @if($trans->client==0)
                    <span class="text-dark">{{$trans->receiver->coin->bb->symbol.number_format($trans->amount+$trans->charge, 2)}}</span><br>
                    @else
                    <span class="text-dark">{{$trans->receiver->coin->bb->symbol.number_format($trans->amount, 2)}}</span><br>
                    @endif
                  </div>
                </div>
                <div class="col">
                  <div class="my-4">
                    <h3 class="mb-1 h5 text-dark">{{__('DATE PAID')}}</h3>
                    <span class="text-dark">{{date("M j, Y", strtotime($trans->created_at))}}</span><br>
                  </div>
                </div>                
                <div class="col">
                  <div class="my-4">
                    <h3 class="mb-1 h5 text-dark">{{__('PAYMENT METHOD')}}</h3>
                    <span class="text-dark text-uppercase"> {{$trans->payment_type}}</span><br>
                  </div>
                </div>
              </div>    
              <div class="row justify-content-between align-items-center">
                <div class="col">  
                  <div class="my-4">
                    <h3 class="mb-1 h5 text-dark">{{__('FOR')}}</h3>
                    <span class="text-dark">Name:{{$trans->first_name.' '.$trans->last_name}}</span><br>
                    @if($trans->email)<span class="text-dark">Email:{{$trans->email}}</span><br>@endif
                  </div>
                </div>          
              </div>          
              <div class="row justify-content-between align-items-center">
                <div class="col">
                  <div class="my-4">
                    <h3 class="mb-1 h5 text-dark">{{__('SUMMARY')}}</h3>
                    <table style="padding-left: 5px; padding-right:5px;" width="100%">
                        <tbody>
                        <tr>
                            <td class="Table-description Font Font--body" style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;mso-line-height-rule: exactly;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px; width: 100%; ">
                                @if($trans->type==1)
                                {{__('Single Pot Payment')}}
                                @elseif($trans->type==2)
                                {{__('Multiple Pot Payment')}}                                
                                @elseif($trans->type==3)
                                {{__('Invoice Payment')}}                         
                                @elseif($trans->type==4)
                                {{__('Merchant Payment')}}                              
                                @elseif($trans->type==5)
                                {{__('Account Funding')}}                                
                                @elseif($trans->type==6)
                                {{__('Subscription Payment')}}                                
                                @elseif($trans->type==7)
                                {{__('Product Order')}}                               
                                @elseif($trans->type==8)
                                {{__('Storefront Order')}}                             
                                @elseif($trans->type==9)
                                {{__('Subscription Payment')}}                                
                                @elseif($trans->type==10)
                                {{__('Appointment')}}
                                @elseif($trans->type==11)
                                {{__('Platform Fee')}}
                                @elseif($trans->type == 12)
                                {{__('Request Link')}}
                                @elseif($val->type == 13)
                                {{__('SMS')}}
                                @elseif($val->type == 14)
                                {{__('Email')}}
                                @endif
                            </td>
                            <td class="Spacer Table-gap" width="8" style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">&nbsp;</td>
                            <td class="Table-amount Font Font--body" align="right" valign="top" style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;mso-line-height-rule: exactly;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px;">
                            @if($trans->type==9)  
                              <span class="text-dark">{{$trans->receiver->coin->bb->symbol.number_format($trans->amount, 2)}}</span><br>
                            @else
                              <span class="text-dark">{{$trans->receiver->coin->bb->symbol.number_format($trans->amount, 2)}}</span><br>
                            @endif
                            </td>
                        </tr>
                        @if($trans->type!=9)
                        <tr>
                            <td class="Table-description Font Font--body" style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;mso-line-height-rule: exactly;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px; width: 100%; ">
                              <strong>{{__('Amount charged')}}</strong>
                            </td>
                            <td class="Spacer Table-gap" width="8" style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;font-size: 1px;line-height: 1px;mso-line-height-rule: exactly;">&nbsp;</td>
                            <td class="Table-amount Font Font--body" align="right" valign="top" style="border: 0;border-collapse: collapse;margin: 0;padding: 0;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;mso-line-height-rule: exactly;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px;">
                                <strong>{{$trans->receiver->coin->bb->symbol.number_format($trans->charge, 2)}}</strong>
                            </td>
                        </tr>   
                        @endif
                        </tbody>
                    </table>
                    <hr>
                  </div>
                </div>                
              </div>               
              <div class="row justify-content-between align-items-center">
                <div class="col">
                  <div class="my-4">
                    <p class="text-dark">{{__('If you have any questions contact us at')}} <a href="mailto:{{$trans->receiver->support_email}}">{{$trans->receiver->support_email}}</a> {{__('or call at')}} <a href="tel:{{$trans->receiver->phone}}">{{$trans->receiver->phone}}</a>. <a href="{{route('download.receipt', ['id' => $trans->ref_id])}}" >{{__('Click here')}}</a> {{__('to download receipt')}}</p>
                  </div>
                </div>                
              </div>  
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center mt-5">
          <a href="{{route('login')}}" class="@if($merchant->checkout_theme!=null)text-white @else text-primary @endif"><i class="fal fa-times"></i> {{__('Close Browser')}}</a>
      </div>
    </div>
@stop