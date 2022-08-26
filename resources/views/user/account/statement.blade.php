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
        <div class="card paper-effect rounded-0 border-top border-info">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-lg-6s ">
                  <img style="max-width:30%;" src="{{asset('asset/'.$logo->image_link)}}" alt="image" />
                <div class="">
                </div>
              </div>
              <div class="col-lg-6s text-right">
                <h3 class="fw-boldest fs-2">{{__('Statement')}}</h3>
              </div>
            </div>
            <hr class="bg-secondary mt-2">
          </div>
          <div class="card-body py-0">
            <div class="row align-items-center">
              <div class="col-lg-12">
                <table style="width: 100%">
                    <tr style="height: 45px">
                        <td colspan="2">
                            <h3 class="fw-boldest fs-6 mb-1">Peter Andrew Onuh</h3>
                            Peter Andrew <br/>
                        </td>
                        <td class="text-right">
                            <h3 class="fw-boldest fs-6 mb-1">GBP</h3>
                        </td>
                    </tr>
                    <tr style="height: 55px">
                        <td>
                            <h3 class="fw-boldest fs-6 mb-1">Sort code</h3> 00-00-00
                        </td>
                        <td>
                            <h3 class="fw-boldest fs-6 mb-1">Account number</h3> 12345678
                        </td>
                    </tr>
                </table>
              </div>

            </div>
            <hr class="bg-secondary mt-3 mb-3">
            <div class="row">
                <table style="width: 100%">
                    <tr style="height: 45px">
                        <td class="text-dark fw-bold fs-6">
                            <table>
                                <tr style="height: 45px">
                                    <td>
                                        <h3>Our Details</h3>
                                        Tryba
                                        Scale Space <br/>
                                        58 Wood Lane <br/>
                                        London <br/>
                                        W12 7RZ
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="text-dark fw-bold fs-6">
                            <table>
                                <tr style="height: 45px">
                                    <td>
                                        <h3>Your Details</h3>
                                        Peter Andrew <br/>
                                        Gbagada, <br/>
                                        Lagos Nigeria
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="width: 100%">
                                <tr style="border-bottom: solid 1px #ccc; height: 45px " >
                                    <td>Period</td>
                                    <td class="text-right"><strong>1 Jan - 31 Jan 2022</strong></td>
                                </tr>
                                <tr style="border-bottom: solid 1px #ccc; height: 45px " >
                                    <td>Previous balance</td>
                                    <td class="text-right"><strong>GBP 0</strong></td>
                                </tr>
                                <tr style="border-bottom: solid 1px #ccc; height: 45px " >
                                    <td>Paid out</td>
                                    <td class="text-right"><strong>GBP 0</strong></td>
                                </tr>
                                <tr style="border-bottom: solid 1px #ccc; height: 45px " >
                                    <td>Paid in</td>
                                    <td class="text-right"><strong>GBP 0</strong></td>
                                </tr>
                                <tr style="height: 45px ">
                                    <td><h3 class="fw-boldest fs-6 mb-1">Balance</h3></td>
                                    <td class="text-right"><strong>GBP 0.00</strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card bg-white mt-4">
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr class="line">
                      <th class="text-dark fw-boldest">{{__('Date')}}</th>
                      <th class="text-dark fw-boldest">{{__('Reference')}}</th>
                      <th class="text-dark fw-boldest">{{__('Details')}}</th>
                      <th class="text-dark fw-boldest">{{__('Paid in')}}</th>
                      <th class="text-dark fw-boldest">{{__('Paid out')}}</th>
                      <th class="text-dark fw-boldest">{{__('Balance')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- @foreach(json_decode($link->item) as $key=>$val)--}}
                    <tr>
                      <td class="text-dark fw-boldest">
                        1 Jan 2021
                      </td >
                      <td class="text-dark fw-boldest">Invoice settlement</td>
                      <td class="text-dark fw-boldest">Paid out invoice to vendor</td>
                      <td class="text-dark fw-boldest">0</td>
                      <td class="text-dark fw-boldest">30</td>
                      <td class="text-dark fw-boldest">200</td>
                    </tr>
                      <td class="text-dark fw-boldest">
                        3 Jan 2021
                      </td >
                      <td class="text-dark fw-boldest">Invoice settlement</td>
                      <td class="text-dark fw-boldest">Paid out invoice to vendor</td>
                      <td class="text-dark fw-boldest">0</td>
                      <td class="text-dark fw-boldest">30</td>
                      <td class="text-dark fw-boldest">200</td>
                    </tr>
                      <td class="text-dark fw-boldest">
                        5 Jan 2021
                      </td >
                      <td class="text-dark fw-boldest">Invoice settlement</td>
                      <td class="text-dark fw-boldest">Paid out invoice to vendor</td>
                      <td class="text-dark fw-boldest">0</td>
                      <td class="text-dark fw-boldest">30</td>
                      <td class="text-dark fw-boldest">200</td>
                    </tr>
                      <td class="text-dark fw-boldest">
                        13 Jan 2021
                      </td >
                      <td class="text-dark fw-boldest">Acount transfer</td>
                      <td class="text-dark fw-boldest">Transfer</td>
                      <td class="text-dark fw-boldest">0</td>
                      <td class="text-dark fw-boldest">10</td>
                      <td class="text-dark fw-boldest">100</td>
                    </tr>
                      <td class="text-dark fw-boldest">
                        21 Jan 2021
                      </td >
                      <td class="text-dark fw-boldest">Payment</td>
                      <td class="text-dark fw-boldest">Payment</td>
                      <td class="text-dark fw-boldest">0</td>
                      <td class="text-dark fw-boldest">30</td>
                      <td class="text-dark fw-boldest">70</td>
                    </tr>
                   {{-- @endforeach --}}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @stop
