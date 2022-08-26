
@extends('userlayout')

@section('content')
  <div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
      <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Invoice')}}</h1>
        <!--end::Title-->
        <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
              <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
          </li>
          <li class="breadcrumb-item text-dark">{{__('Invoice')}}</li>
        </ul>
      </div>
      <div class="d-flex py-2">
        <a href="{{route('user.add-customer')}}" class="btn btn-info me-4"><i class="fal fa-user"></i> {{__('New Customer')}}</a>
        <a href="{{route('user.add-invoice')}}" class="btn btn-dark"><i class="fal fa-file-alt"></i> {{__('New Invoice')}}</a>
      </div>
    </div>
  </div>
  <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
      <div class="d-flex overflow-auto mb-10">
        <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 fw-bold flex-nowrap">
          <li class="nav-item">
            <a href="{{route('user.invoice')}}" class="nav-link text-active-primary px-3 @if(route('user.invoice')==url()->current()) active @endif">{{__('Invoice')}}</a>
          </li>
          <li class="nav-item">
            <a href="{{route('user.customer')}}" class="nav-link text-active-primary px-3 @if(route('user.customer')==url()->current()) active @endif">{{__('Customers')}}</a>
          </li>
        </ul>
      </div>
      @if(route('user.invoice')==url()->current())
      @if($user->kyc_verif_status!="APPROVED")
      <div class="notice d-flex bg-light-primary border-primary  rounded p-6 mb-8">
        <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="0" y="0" width="24" height="24"></rect>
              <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
              <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"></path>
            </g>
          </svg>
        </span>
        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
          <div class="mb-3 mb-md-0 fw-bold">
            <h4 class="text-gray-800 fw-bolder">{{__('We need more information about you')}}</h4>
            <div class="fs-6 text-gray-600 pe-7">{{__('Compliance is currently due, please update your account information to avoid restrictions such as no access to storefront service.')}}</div>
          </div>
          <a href="{{route('compliance.session')}}" class="btn btn-primary px-6 align-self-center text-nowrap">
            {{__('Click here')}}
          </a>
        </div>
      </div>
      @endif
      <div class="row g-xl-8">
        <div class="col-xl-8 mb-6">
          <div class="row g-5 g-xxl-8">
            <div class="card">
              <div class="card-body pt-3">
                <table id="kt_datatable_example_10" class="table align-middle table-row-dashed gy-5 over">
                      <thead>
                          <tr class="fw-bolder fs-6 text-gray-800 px-7">
                              <th class="min-w-50px"></th>
                              <th class="min-w-80px">{{__('Reference ID')}}</th>
                              <th class="min-w-70px">{{__('Amount')}}</th>
                              <th class="min-w-50px">{{__('Status')}}</th>
                              <th class="min-w-70px">{{__('Type')}}</th>
                              <th class="min-w-70px">{{__('Due')}}</th>
                              <th class="min-w-100px">{{__('Created')}}</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach($user->getInvoice() as $val)
                        <tr>
                          <td>
                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click">
                              <span class="svg-icon svg-icon-3 svg-icon-primary">
                                <i class="fal fa-chevron-circle-down"></i>
                              </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-4" data-kt-menu="true">
                              <div class="menu-item px-3">
                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                              </div>
                              @if($val->customer_id!=null)
                              @if($user->kyc_verif_status=="APPROVED" || $user->live==0)
                              <div class="menu-item px-3"><a data-bs-toggle="modal" data-bs-target="#share{{$val->id}}" href="#" class="menu-link px-3">{{__('Share')}}</a></div>
                              <div class="menu-item px-3"><a href="{{route('preview.invoice', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Preview')}}</a></div>
                              @endif
                              @endif
                              @if($val->status==0)
                              <div class="menu-item px-3"><a href="{{route('edit.invoice', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                              @if($val->customer_id!=null)
                              <div class="menu-item px-3"><a href="{{route('reminder.invoice', ['id' => $val->ref_id])}}" class="menu-link px-3">{{ __('Send a reminder')}}</a></div>
                              @endif
                              @endif
                              <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                            </div>
                          </td>
                          
                          <td data-href="{{route('edit.invoice', ['id' => $val->ref_id])}}">{{$val->ref_id}}</td>
                          <td data-href="{{route('edit.invoice', ['id' => $val->ref_id])}}">{{$currency->symbol.number_format(array_sum(json_decode($val->total)), 2)}}</td>
                          <td data-href="{{route('edit.invoice', ['id' => $val->ref_id])}}">
                            @if($val->status == 0)
                              <span class="badge badge-pill badge-light-danger">{{__('Not Paid')}}</span>
                            @elseif($val->status == 1)
                              <span class="badge badge-pill badge-light-success">{{__('Paid')}}</span>
                            @elseif($val->status == 2)
                              <span class="badge badge-pill badge-light-primary">{{__('Refunded')}}</span>
                            @elseif($val->status == 3)
                              <span class="badge badge-pill badge-light-primary">{{__('Partial Payment')}}</span>
                            @endif
                          </td>
                          <td data-href="{{route('edit.invoice', ['id' => $val->ref_id])}}">{{ ucwords($val->invoice_type) }}</td>
                          <td data-href="{{route('edit.invoice', ['id' => $val->ref_id])}}">{{date("j, M Y", strtotime($val->due_date))}}</td>
                          <td data-href="{{route('edit.invoice', ['id' => $val->ref_id])}}">{{$val->created_at->diffforHumans()}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
              </div>
            </div>
            @foreach($user->getInvoice() as $k=>$val)
            <div class="modal fade" id="share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
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
                        <h3 class="fw-boldest text-dark fs-2x">{{__('Share')}}</h3>
                        <!--begin::Description-->
                        <div class="text-dark-400 fw-bold fs-4">{{__('Share invoice with friends, family & customers')}}</div>
                        <!--end::Description-->
                      </div>
                      <!--end::Heading-->
                      <!--begin::Input group-->
                      <div class="mb-10">
                        <!--begin::Title-->
                        <div class="d-flex">
                          <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('view.invoice', ['id' => $val->ref_id])}}">
                          <button class="castro-copy btn btn-light flex-shrink-0 text-dark" data-clipboard-text="{{route('view.invoice', ['id' => $val->ref_id])}}">Copy Link</button>
                        </div>
                        <!--end::Title-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Actions-->
                      <div class="d-flex mb-6">
                        <a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('view.invoice', ['id' => $val->ref_id])}}" class="btn btn-light-primary w-100">
                        <i class="fal fa-envelope fs-5 me-3"></i>{{__('Send Email')}}</a>                                  
                        <a target="_blank" href="{{route('sms.invoice', ['id' => $val->ref_id])}}" class="btn btn-light-primary w-100 mx-6">
                        <i class="fal fa-comments-alt fs-5 me-3"></i>{{__('Send SMS')}}</a>
                      </div>                      
                      <div class="d-flex">
                        <a target="_blank" href="https://wa.me/{{$val->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('view.invoice', ['id' => $val->ref_id])}}" class="btn btn-icon btn-success w-100">
                        <i class="fab fa-whatsapp fs-5 me-3"></i>{{__('Whatsapp')}}</a>
                      </div>
                      <!--end::Actions-->
                      <!--begin::Input group-->
                      <div class="text-center px-5 mt-8">
                        <span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
                        {!! QrCode::eye('circle')->style('round')->size(250)->generate(route('view.invoice', ['id' => $val->ref_id])); !!} 
                      </div>
                      <!--end::Input group-->
                    </div>
                    <!--end::Wrapper-->
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" tabindex="-1" id="delete{{$val->id}}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete Invoice')}}</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                  </div>
                  <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this?, all transaction related to this invoice will be deleted')}}</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <a  href="{{route('delete.invoice', ['id' => $val->ref_id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <div class="col-xl-4 gy-0 gy-xxl-8">
          <div class="card card-xxl-stretch mb-5 mb-xl-8">
            <div class="card-body p-0">
              <div class="px-9 pt-6 card-rounded h-250px w-100 bgi-no-repeat bgi-size-cover bgi-position-y-top h-200px bg-info castro-secret">
                <div class="d-flex flex-stack">
                  <h3 class="m-0 text-white fw-bolder fs-3">{{__('Statistics')}}</h3>
                </div>
                <div class="fw-bolder fs-5 text-center text-white pt-5">{{__('Received')}}
                <span class="fw-boldest fs-2hx d-block mt-n1">{{number_format($user->receivedInvoice(), 2).' '.$currency->name}}</span></div>
              </div>
              <div class="shadow-xs card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1 bg-white" style="margin-top: -100px">
                <div class="d-flex align-items-center mb-9">
                  <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                      <div class="fs-4 text-dark text-hover-primary">{{__('Pending')}}</div>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="fs-4 text-dark pe-1">{{$currency->name}} {{number_format($user->pendingInvoice(), 2)}}</div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center mb-9">
                  <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                      <div class="fs-4 text-dark text-hover-primary">{{__('Total')}}</div>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="fs-4 text-dark pe-1">{{$currency->name}} {{number_format($user->totalInvoice(), 2)}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif      
      @if(route('user.customer')==url()->current())
      <div class="row g-xl-8">
        <div class="col-xl-12">
          <div class="row g-5 g-xxl-8">
            <div class="card">
              <div class="card-body pt-3">
                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="min-w-25px"></th>
                            <th class="min-w-80px">{{__('Name')}}</th>
                            <th class="min-w-70px">{{__('Email')}}</th>
                            <th class="min-w-50px">{{__('Phone')}}</th>
                            <th class="min-w-100px">{{__('Created')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($user->getInvoiceCustomer() as $val)
                      <tr>
                        <td>
                          <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click">
                            <span class="svg-icon svg-icon-3 svg-icon-primary">
                              <i class="fal fa-chevron-circle-down"></i>
                            </span>
                          </button>
                          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                              <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                            </div>
                            <div class="menu-item px-3"><a href="{{route('edit.customer', ['id' => $val->ref_id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                            <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                          </div>
                        </td>
                        <td data-href="{{route('edit.customer', ['id' => $val->ref_id])}}">{{$val->first_name.' '.$val->last_name}}</td>
                        <td data-href="{{route('edit.customer', ['id' => $val->ref_id])}}">{{$val->email}}</td>
                        <td data-href="{{route('edit.customer', ['id' => $val->ref_id])}}">{{$val->phone}}</td>
                        <td data-href="{{route('edit.customer', ['id' => $val->ref_id])}}">{{$val->created_at->diffforHumans()}}</td>
                      </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
            </div>
            @foreach($user->getInvoiceCustomer() as $k=>$val)
            <div class="modal fade" tabindex="-1" id="delete{{$val->id}}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete Customer')}}</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                  </div>
                  <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this?, all transaction related to this customer will be deleted')}}</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <a  href="{{route('delete.customer', ['id' => $val->ref_id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@stop
@section('script')
<script>
  $('td[data-href]').on("click", function() {
    window.location.href = $(this).data('href');
  });
</script>
<script>
  $(document).ready(function() {
      $('#kt_datatable_example_10').DataTable({
        "dom":
        "<'row'" +
        "<'col-lg-6 d-flex align-items-center justify-conten-start'f>" +
        "<'col-lg-6 d-flex align-items-center justify-content-end'l>" +
        ">" +
        
        "<'table-responsive'tr>" +
        
        "<'row'" +
        "<'col-lg-12 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-lg-12 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
          "scrollX": true
      } );
  });
</script>
@endsection