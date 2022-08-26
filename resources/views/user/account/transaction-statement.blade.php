@extends('user.account.layout')

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
        <div class="card paper-effectss rounded-0 border-tops border-none">
          <div class="card-header">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-12 text-center mb-4 mt-4">
                <img style="max-width:30%;" src="{{asset('asset/'.$logo->image_link)}}" alt="image" />
                <div class="">
                </div>
              </div>
            </div>
            {{-- <hr class="bg-secondary mt-2"> --}}
          </div>
          <div class="card-body py-0">
            <div class="row align-items-center">
              <div class="col-lg-12">
                <table style="width: 100%">
                    <tr style="height: 55px">
                        <td>
                            <h2>Transfer confirmation</h2>
                            <span>Funded</span><h3 class="fw-boldest fs-6 mb-1">{{ $data->created_at->toFormattedDateString() ?? null }}</h3>
                            <span>Paid out</span><h3 class="fw-boldest fs-6 mb-1">{{ $data->updated_at->toFormattedDateString() ?? null }}</h3>
                            <span>Transfer #</span><h3 class="fw-boldest fs-6 mb-1">{{ $data->reference }}</h3>
                            <span>Payment #</span><h3 class="fw-boldest fs-6 mb-1">P1U8747849</h3>
                        </td>
                        <td class="text-right">
                            <h3>Your details</h3>
                            <span>{{ $data->user->first_name ?? null.' '.$data->user->last_name ?? null }}</span><br/>
                            <span>{{ $data->user->gBPAccount()->addressLin1 ?? null }}</span><br/>
                            <span>{{ $data->user->gBPAccount()->addressLin2 ?? null }}</span><br/>
                            {{-- <span>United Kingdom</span><br/> --}}
                        </td>
                    </tr>
                </table>
              </div>
            </div>
            <div class="mt-4 ">
                <h2>Transfer Overview</h2>
                <hr class="bg-secondary mt-3 mb-3">
            </div>
            <table class=" align-items-center " style="width: 60%;">
                <tr>
                    <td class="text-left">
                     <span>Amount</span> <h3>{{ number_format($data->amount,2) }} GBP</h3>
                    </td >
                    <td class="text-left">
                        <span>Fee </span>  <h3>0.5 GBP</h3>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <span>Amount Converted</span> <h3>{{ number_format($data->amount,2) }} GBP</h3>
                    </td >
                    <td class="text-left">
                        <span>Exchange rate </span>    <h3>1 GBP = 1.0 GBP</h3>
                    </td>
                </tr>
            </table>

            <div class="mt-4">
                <h2>Sent to </h2>
                <hr class="bg-secondary mt-3 mb-3">
            </div>
            <table class="align-items-center" style="width: 60%;">
                <tr>
                    <td class="text-left">
                       <span> Name</span> <h3>Madu Ikechukwu</h3>
                    </td >
                    <td class="text-left">
                        <span>Reference</span>     <h3>Peter Andrew</h3>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <span>Amount details</span>
                        <h3>22-10-90</h3>
                        <h3>4560936511</h3>
                    </td >
                    <td class="text-left">
                    </td>
                </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    @stop
