@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <!--begin::Title-->
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Orders')}}</h1>
      <!--end::Title-->
      <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
          <a href="{{url('/')}}" class="text-muted text-hover-primary">{{__('Home')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.storefront')}}" class="text-muted text-hover-primary">{{__('Storefront')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.storefront.customer')}}" class="text-muted text-hover-primary">{{__('Customer')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{__('Orders')}}</li>
      </ul>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-80px">{{__('Name')}}</th>
                    <th class="min-w-50px">{{__('Amount')}}</th>
                    <th class="min-w-50px">{{__('Quantity')}}</th>
                    <th class="min-w-50px">{{__('Subtotal')}}</th>
                    <th class="min-w-70px">{{__('Ship fee')}}</th>
                    <th class="min-w-70px">{{__('Tax')}}</th>
                    <th class="min-w-70px">{{__('Total')}}</th>
                    <th class="min-w-100px">{{__('Date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user->orders() as $k=>$val)
                  <tr>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">
                      <div class="d-flex">
                        <div class="symbol symbol-70px me-6 bg-light">
                          @if($val->product->new == 0)
                          <img src="{{asset('asset/images/product-placeholder.jpg')}}" alt="image">
                          @else
                          @php
                          $image=App\Models\Productimage::whereproduct_id($val->product->id)->first();
                          @endphp
                          <img alt="image" src="{{asset('asset/profile/'.$image->image)}}">
                          @endif
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <a href="{{route('edit.product', ['id' => $val->product->ref_id])}}" class="mb-1 text-gray-800 text-hover-primary">
                            @if(strlen($val->product->name)>25)
                            {{substr($val->product->name, 0, 25)}} ...
                            @else
                            {{$val->product->name}}
                            @endif
                            <span class="badge badge-light-primary">@if($val->order_status==null)Payment Received @else {{$val->order_status}} @endif</span>
                          </a>
                        </div>
                      </div>
                    </td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->amount, 2)}}</td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$val->quantity}}</td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->amount*$val->quantity, 2)}}</td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->shipping_fee, 2)}}</td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->tax, 2)}}</td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$currency->symbol}}{{number_format($val->total, 2)}}</td>
                    <td data-bs-toggle="modal" data-bs-target="#order_share{{$val->id}}">{{$val->created_at->diffforHumans()}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @foreach($user->orders() as $k=>$val)
          <div class="modal fade" id="order_share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered mw-800px">
              <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                  <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-2x">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                      </svg>
                    </span>
                  </div>
                </div>
                <div class="modal-body scroll-y pt-0 pb-15">
                  <!--begin::Wrapper-->
                  <div class="mw-lg-600px mx-auto">
                    <!--begin::Heading-->
                    <div class="mb-15 text-center">
                      <h3 class="fw-boldest text-dark fs-2x">{{__('Order Details')}}</h3>
                      <!--begin::Description-->
                      <div class="text-dark-400 fw-bold fs-4">{{__('Information concerning this order')}}</div>
                      <div class="fw-bold text-dark">Order ID: {{$val->ref_id}}</div>
                      <div class="fw-bold text-dark">Tracking Code: {{$val->order_id}}</div>
                      <div class="fw-bold text-dark">{{$val->product->name}}</div>
                      <!--end::Description-->
                    </div>
                    <!--end::Heading-->
                    @if($val->note!=null)
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                      <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                          <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                          <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                        </svg>
                      </span>
                      <!--begin::Wrapper-->
                      <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-bold">
                          <h4 class="text-gray-800 fw-bolder">Additional Note</h4>
                          <div class="fs-6 text-gray-600">{{$val->note}}</div>
                        </div>
                        <!--end::Content-->
                      </div>
                      <!--end::Wrapper-->
                    </div>
                    @endif
                    <div class="row mt-8">
                      <div class="col-xl-4 mb-10 mb-xl-0">
                        <h3 class="fw-boldest mb-3">Delivery Address</h3>
                        <div class="fs-5 fw-bold text-dark">
                          {{__('State')}}: {{$val->shipstate->name}}
                          @if($val->city!=null)
                          <br>{{__('City')}}: {{$val->city}}
                          @endif
                          <br>{{__('Postal code')}}: {{$val->postal_code}}
                          <br>{{__('line 1')}}: {{$val->line_1}}
                          @if($val->line_2!=null)
                          <br>{{__('line 2')}}: {{$val->line_2}}
                          @endif
                        </div>
                      </div>
                      <div class="col-xl-4 mb-10 mb-xl-0">
                        <h3 class="fw-boldest mb-3">Customer</h3>
                        <div class="fs-5 fw-bold text-dark">
                          @if($val->customer_id==null)
                          {{__('Name')}}: {{$val->first_name}} {{$val->last_name}}<br>
                          {{__('Email')}}: {{$val->email}}<br>
                          {{__('Phone')}}: {{$val->phone}}
                          @else
                          {{__('Name')}}: {{$val->buyer->first_name}} {{$val->buyer->last_name}}<br>
                          {{__('Email')}}: {{$val->buyer->email}}<br>
                          {{__('Phone')}}: {{$val->buyer->phone}}
                          @endif
                        </div>
                      </div>
                      <div class="col-xl-4 mb-10 mb-xl-0">
                        <h3 class="fw-boldest mb-3">Order Summary</h3>
                        @if($val->size!=null)
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">{{__('Size')}}:</span>
                          <span>{{$val->size}}</span>
                        </div>
                        @endif
                        @if($val->color!=null)
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">{{__('Color')}}:</span>
                          <span>{{$val->color}}</span>
                        </div>
                        @endif
                        @if($val->length!=null)
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">{{__('Length')}}:</span>
                          <span>{{$val->length}}</span>
                        </div>
                        @endif
                        @if($val->weight!=null)
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">{{__('Weight')}}:</span>
                          <span>{{$val->weight}}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">Quantity:</span>
                          <span>{{$val->quantity}}</span>
                        </div>
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">Item Total:</span>
                          <span>{{$currency->symbol}}{{number_format($val->amount*$val->quantity, 2)}}</span>
                        </div>
                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                          <span class="me-2">Delivery:</span>
                          <span>{{$currency->symbol}}{{number_format($val->shipping_fee, 2)}}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-boldest mt-2">
                          <h4 class="fw-boldest me-2">Tax:</h4>
                          <span>{{$currency->symbol}}{{number_format($val->tax, 2)}}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-boldest mt-2">
                          <h4 class="fw-boldest me-2">Grand Total:</h4>
                          <span>{{$currency->symbol}}{{number_format($val->total, 2)}}</span>
                        </div>
                      </div>
                      <div class="col-xl-12 mb-10 mb-xl-0 mt-3">
                        <div class="tt-rating">
                          <i class="fal fa-star @if($val->product->rating()>0) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>1) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>2) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>3) checked @endif"></i>
                          <i class="fal fa-star @if($val->product->rating()>4) checked @endif"></i>
                        </div>
                        <div class="fs-5 fw-bold text-gray-600">
                          @if($val->review==null)
                          {{__('No review')}}
                          @else
                          {{$val->review}}
                          @endif
                        </div>
                      </div>
                    </div>
                    <form action="{{route('store.order.status', ['id'=>$val->id])}}" method="post">
                      @csrf
                      <div class="row mb-6">
                        <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Order Status')}}</label>
                        <div class="col-lg-12">
                          <select name="order_status" class="form-select form-select-solid" required>
                            <option value="" data-select2-id="select2-data-6-31tw">Select an order status...</option>
                            <option value="Order Processed" @if($val->order_status=="Order Processed") selected @endif>Order Processed</option>
                            <option value="In Transit" @if($val->order_status=="In Transit") selected @endif>In Transit</option>
                            <option value="With Courier" @if($val->order_status=="With Courier") selected @endif>With Courier</option>
                            <option value="Delivered" @if($val->order_status=="Delivered") selected @endif>Delivered</option>
                          </select>
                        </div>
                      </div>
                  </div>
                  <!--end::Wrapper-->
                </div>
                <div class="modal-footer d-flex justify-content-end py-6 px-9">
                  <button type="submit" class="btn btn-primary px-6">{{__('Update Order Status')}}</button>
                </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@stop