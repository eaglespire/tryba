@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <!--begin::Title-->
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Developers')}}</h1>
      <!--end::Title-->
      <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{__('Developer')}}</li>
      </ul>
    </div>
    <div class="d-flex py-2">
      <a href="#" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-dark">{{__('New App')}}</a>
    </div>
    <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
          <form class="form fv-plugins-bootstrap5 fv-plugins-framework" id="payment-form" action="{{route('submit.merchant')}}" method="post" id="modal-details">
            @csrf
            <div class="modal-header">
              <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Create App')}}</h3>
              <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                <span class="svg-icon svg-icon-2x">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="modal-body py-10">
              <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px" style="max-height: 521px;">
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                  <input type="text" class="form-control form-control-solid" placeholder="{{__('Name of your App')}}" name="name" required>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                  <textarea class="form-control form-control-solid" name="description" type="text" placeholder="{{__('What does your app do')}}"></textarea>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                  <label class="fs-5 fw-bold mb-2">{{__('Url')}}</label>
                  <input type="text" class="form-control form-control-solid" placeholder="{{__('Website URL')}}" name="url">
                </div>
              </div>
            </div>
            <div class="modal-footer flex-center">
              <button type="submit" id="ggglogin" form="modal-details" class="btn btn-success btn-block">{{__('Create App')}}</button>
            </div>
            <div></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="d-flex overflow-auto mb-10">
      <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 fw-bold text-gray-800 flex-nowrap">
        <li class="nav-item">
          <a href="{{route('user.merchant')}}" class="nav-link text-active-primary px-3 @if(route('user.merchant')==url()->current()) active @endif">{{__('App Keys')}}</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.merchant-api')}}" class="nav-link text-active-primary px-3 @if(route('user.merchant-api')==url()->current()) active @endif">{{__('API Checkout')}}</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.merchant-html')}}" class="nav-link text-active-primary px-3 @if(route('user.merchant-html')==url()->current()) active @endif">{{__('HTML Checkout')}}</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.merchant-plugin')}}" class="nav-link text-active-primary px-3 @if(route('user.merchant-plugin')==url()->current()) active @endif">{{__('Plugins')}}</a>
        </li>
        <li class="nav-item">
          <a href="{{route('user.merchant-button')}}" class="nav-link text-active-primary px-3 @if(route('user.merchant-button')==url()->current()) active @endif">{{__('Payment Button')}}</a>
        </li>
      </ul>
    </div>
    @if(route('user.merchant')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-8">
        <div class="row g-5 g-xxl-8">
          <div class="card">
            <div class="card-body pt-3">
              <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                <thead>
                  <tr class="fw-bolder fs-6 text-gray-800 px-7">
                    <th class="min-w-25px"></th>
                    <th class="min-w-80px">{{__('Label')}}</th>
                    <th class="min-w-70px">{{__('Merchant Key')}}</th>
                    <th class="min-w-70px"></th>
                    <th class="min-w-100px">{{__('Created')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($merchant as $val)
                  <tr>
                    <td>
                      <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                        <span class="svg-icon svg-icon-3 svg-icon-primary">
                          <i class="fal fa-chevron-circle-down"></i>
                        </span>
                      </button>
                      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                        <div class="menu-item px-3">
                          <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                        </div>
                        <div class="menu-item px-3"><a href="{{route('log.merchant', ['id' => $val->merchant_key])}}" class="menu-link px-3">{{__('Transactions')}}</a></div>
                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$val->id}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                        <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                      </div>
                    </td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->merchant_key}}</td>
                    <td>
                      <button data-clipboard-text="{{$val->merchant_key}}" class="castro-copy btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light">
                        <!--begin::Svg Icon | path: icons/duotone/General/Copy.svg-->
                        <span class="svg-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z" fill="#B5B5C3" />
                          </svg>
                        </span>
                        <!--end::Svg Icon-->
                      </button>
                    </td>
                    <td>{{$val->created_at->diffforHumans()}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @foreach($merchant as $k=>$val)
          <div class="modal fade" tabindex="-1" id="delete{{$val->id}}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{__('Delete App')}}</h5>
                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                  </div>
                </div>
                <div class="modal-body">
                  <p>{{__('Are you sure you want to delete this?, all transaction related to this app will be deleted')}}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                  <a href="{{route('delete.merchant', ['id' => $val->id])}}" class="btn btn-primary">{{__('Proceed')}}</a>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="edit{{$val->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
              <div class="modal-content">
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('update.merchant')}}" method="post" id="modal-details">
                  @csrf
                  <div class="modal-header">
                    <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Edit App')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                      <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                        </svg>
                      </span>
                    </div>
                  </div>
                  <div class="modal-body py-10">
                    <input type="hidden" name="id" value="{{$val->id}}">
                    <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px" style="max-height: 521px;">
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Name of your App')}}" name="name" value="{{$val->name}}" required>
                      </div>
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                        <textarea name="description" class="form-control form-control-solid" type="text" placeholder="{{__('What does your app do')}}">{{$val->description}}</textarea>
                      </div>
                      <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Url')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('Website URL')}}" value="{{$val->url}}" name="url">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer flex-center">
                    <button type="submit" form="modal-details" class="btn btn-success btn-block">{{__('Edit App')}}</button>
                  </div>
                  <div></div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-xl-4 gy-0 gy-xxl-8">
        <div class="card card-xxl-stretch mb-5 mb-xl-8">
          <div class="card-body p-0">
            <div class="px-9 pt-6 card-rounded h-250px w-100 bgi-no-repeat bgi-size-cover bgi-position-y-top h-200px bg-info">
              <div class="d-flex flex-stack">
                <h3 class="m-0 text-white fw-bolder fs-3">{{__('Statistics')}}</h3>
              </div>
              <div class="fw-bolder fs-5 text-center text-white pt-5">{{__('Received')}}
                <span class="fw-boldest fs-2hx d-block mt-n1">{{number_format($user->receivedMerchant(), 2).' '.$currency->name}}</span>
              </div>
            </div>
            <div class="shadow-xs card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1 bg-white" style="margin-top: -100px">
              <div class="d-flex align-items-center mb-9">
                <div class="d-flex align-items-center flex-wrap w-100">
                  <div class="mb-1 pe-3 flex-grow-1">
                    <a href="#" class="fs-4 text-dark text-hover-primary">{{__('Pending')}}</a>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="fs-4 text-dark pe-1">{{$currency->name}} {{number_format($user->pendingMerchant(), 2)}}</div>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center mb-9">
                <div class="d-flex align-items-center flex-wrap w-100">
                  <div class="mb-1 pe-3 flex-grow-1">
                    <a href="#" class="fs-4 text-dark text-hover-primary">{{__('Abadoned')}}</a>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="fs-4 text-dark pe-1">{{$currency->name}} {{number_format($user->abandonedMerchant(), 2)}}</div>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center mb-9">
                <div class="d-flex align-items-center flex-wrap w-100">
                  <div class="mb-1 pe-3 flex-grow-1">
                    <a href="#" class="fs-4 text-dark text-hover-primary">Total</a>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="fs-4 text-dark pe-1">{{$currency->name}} {{number_format($user->totalMerchant(), 2)}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    @if(route('user.merchant-api')==url()->current())
    <div class="card">
      <div class="card-body p-10 p-lg-15">
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Overview')}}</h2>
          <div class="py-5">
            <strong>Tryba</strong>&nbsp; {{__('provides you access to your resources through RESTful endpoints. Before you proceed, you need to register your')}} <a href="{{route('user.merchant')}}">{{__('app')}}</a> {{__('so you can test the API. You would also be able to access your test API credential and keys from')}} <a href="{{route('user.api')}}">{{__('here')}}</a>
          </div>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('HTTP Request Sample')}}</h2>
          <div class="py-5">
            {{__('We would provide cURL request sample, just so you can quickly test each endpoint on your terminal or command line. Need a quick how-to for making cURL requests? just use an HTTP client such as Postman, like the rest of us!')}}
          </div>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Requests and Responses')}}</h2>
          <div class="py-5">
            {{__('Both request body data and response data are formatted as JSON. Content type for responses are always of the type application/json. You can use the Tryba API in test mode, which does not affect your live data or interact with the banking networks. The API key you use to authenticate the request determines whether the request is live mode or test mode')}}
          </div>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Errors')}}</h2>
          <div class="py-5">
            {{__('Errors are returned when one or more validation rules fail or unauthorized access to API. Examples include not passing required parameters e.g. not passing the transaction/provider ref during a re-query call will result in a validation error. Here\'s a sample below:')}}
          </div>
          <pre class="rounded">
              <code class="language-html" data-lang="html">
              {
                  "status": "failed",
                  "message": "tx_ref is required",
                  "data": null
              }
              </code>
            </pre>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">Authentication</h2>
          <div class="py-5">
            Test mode secret keys have the prefix <code>sec-test</code> and live mode secret keys have the prefix <code>pub-test</code>. Your API keys carry many privileges, so be sure to keep them secure! Do not share your secret API keys in publicly accessible areas such as GitHub, client-side code, and so forth. Authentication to the API is performed via bearer auth passed to us through an Authorization Header
          </div>
          <pre class="rounded">
              <code class="language-html" data-lang="html">
              curl -X POST '{{url('/')}}/api/generate_token' \
                  -H 'Accept: application/json' \
                  -d '{
                      "secret_key": 'sec-test-1SKAJRkwrg7rxhEEQ8ajTFCFfht2U4H0'
                  }'
              </code>
            </pre>
          <p>Response</p>
          <pre class="rounded">
              <code class="language-html" data-lang="html">
              {
                  "token": '6|82SUtz7Hs8qU0S72Mu6MiUGrKr8FZGZDU2GbnnLa'
              }
              </code>
            </pre>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Initiate Transaction')}}</h2>
          <div class="py-5">
            <div class="rounded border p-10 bg-light">
              <div class="mb-6">
                <label class="form-label">merchant_key <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is your app key, it is important for tracking what website is tied to a partciular transaction')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">callback_url <span class="text-gray-600">url</span> <span class="text-danger">required</span></label>
                <p>{{__('This is your IPN url, it is important for receiving payment notification. Successful transactions redirects to this url after payment')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">return_url <span class="text-gray-600">url</span> <span class="text-danger">required</span></label>
                <p>{{__('Fallback page for cancelled payment')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">tx_ref <span class="text-gray-600">string</span> </label>
                <p>{{__('This is a merchant\'s unique reference for the payment, it can be used to query for the status of the payment')}}.</p>
              </div>
              <div class="mb-6">
                <label class="form-label">first_name <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the first_name of your customer')}}.</p>
              </div>
              <div class="mb-6">
                <label class="form-label">last_name <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the last_name of your customer')}}.</p>
              </div>
              <div class="mb-6">
                <label class="form-label">email <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the email address of your customer. Transaction notification will be sent to this email address')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">title <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('Title of transaction')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">description <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('Description of what transaction is for')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">amount <span class="text-gray-600">int32</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the amount to charge all customers')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">quantity <span class="text-gray-600">int32</span> <span class="text-danger">required</span></label>
                <p>{{__('Quantity of Item being payed for')}}</p>
              </div>
            </div>
          </div>
          <pre class="rounded">
              <code class="language-html" data-lang="html">
              curl -X POST '{{url("/")}}/api/initiate_transaction' \
              -H 'Accept: application/json' \
              -H 'Authorization: Bearer {token}' \
              -d '{
                  "merchant_key": 8So3ziLmw9kxHmjo,
                  "public_key": "pub-test-EmvYn3n1Hg4vVnF46RWrh4RbFqOwqSnL"
                  "amount": 100,
                  "email": "yourmail@example.com",
                  "first_name":"John",
                  "last_name":"Doe",
                  "callback_url": "https://example.com/callbackurl",
                  "return_url": "https://example.com/returnurl",
                  "tx_ref": "2346vrcd",
                  "title": "Test Payment",
                  "description": "Payment Description",
                  "quantity": 1
              }'
              </code>
            </pre>
          <p>{{__('Response')}}</p>
          <pre class="rounded">
                <code class="language-html" data-lang="html">
                {
                    "message": "Transaction Initiated",
                    "status": "success",
                    "data": {
                        "reference": "09229936784",
                        "checkout_url": "{{url("/")}}/nn/xpay/8So3ziLmw9kxHmjo/09229936784"
                    }
                }
                </code>
            </pre>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Validate a Transaction')}}</h2>
          <div class="py-5">
            {{__('This shows you how to validate a transaction')}}
          </div>
          <pre class="rounded">
                <code class="language-html" data-lang="html">
                curl -X GET '{{url("/")}}/api/verify-payment/[tx_ref]' \
                -H 'Accept: application/json' \
                -H 'Authorization: Bearer {token}' \
                </code>
            </pre>
          <p>{{__('Response')}}</p>
          <pre class="rounded">
                <code class="language-html" data-lang="html">
                {
                    "message":"Transaction is Complete",
                    "status":"Paid",
                    "data":{
                        "id":444,
                        "email":"yourmail@example.com",
                        "first_name":"John",
                        "last_name":"Doe",
                        "payment_type":"coinbase",
                        "title":"Test Payment",
                        "description":"Payment Description",
                        "quantity":1,
                        "reference":"09229936784",
                        "amount":100,
                        "merchant_key":"8So3ziLmw9kxHmjo",
                        "callback_url":"https://example.com/callbackurl",
                        "return_url":"https://example.com/returnurl",
                        "tx_ref":"2346vrcd",
                        "created_at":"2021-01-01T22:05:02.000000Z",
                        "updated_at":"2020-05-15T12:05:29.000000Z"
                    }
                }
                </code>
            </pre>
        </div>
      </div>
    </div>
    @endif
    @if(route('user.merchant-button')==url()->current())
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body p-10 p-lg-15">
            <div class="pb-10">
              <h2 class="anchor fw-bolder">{{__('Customize the Button')}}</h2>
              <div class="py-5">
                {{__('Customise a payment button, then copy the code to add to your website or share it with your developer. This experience can be used to sell a product or service at a fixed price.')}}
              </div>
              <form name="waf_button_customizer" id="waf_button_customizer_form">
                <div class="">
                  <div class="form-group">
                    <label for="wafMerchantKey" class="col-form-label">{{__('Website')}}</label>
                    <select class="form-control form-control-solid mb-3" id="wafMerchantKey" aria-describedby="wafMerchantKeyHelp" required>
                      <option value="">{{__('Choose a website')}}</option>
                      @foreach($merchant as $val)
                      <option value="{{$val->merchant_key}}">{{$val->name}}</option>
                      @endforeach
                    </select>
                    <p id="wafMerchantKeyHelp" class="">{{__('You can check and add new websites to your account')}}
                      <a href="https://tryba.io/user/merchant" target="_blank">here</a>
                    </p>
                  </div>
                  <div class="form-group">
                    <label for="wafButtonType" class="col-form-label">{{__('Button Type')}}</label>
                    <select class="form-control form-control-solid mb-3" id="wafButtonType" aria-describedby="wafButtonTypeHelp" required>
                      <option value="fixed_price">{{__('Fixed Price')}}</option>
                    </select>
                    <p id="wafButtonTypeHelp" class="">
                      {{__('Fixed price button lets customers buy one of a single item.')}}
                    </p>
                  </div>
                  <div class="form-group">
                    <label for="wafItemTitle" class="col-form-label">{{__('Item Title')}}</label>
                    <input type="text" class="form-control form-control-solid" name="wafItemTitle" id="wafItemTitle" required>
                  </div>
                  <div class="form-group">
                    <label for="wafItemDescription" class="col-form-label">{{__('Item Description')}}</label>
                    <input type="text" class="form-control form-control-solid" name="wafItemDescription" id="wafItemDescription" required>
                  </div>
                  <div class="form-group">
                    <label for="wafCallbackUrl" class="col-form-label">{{__('Callback UR')}}L</label>
                    <input type="text" class="form-control form-control-solid mb-3" name="wafCallbackUrl" id="wafCallbackUrl" aria-describedby="wafCallbackUrlHelp" required>
                    <p id="wafCallbackUrlHelp" class="">
                      {{__('This is the URL which customers will be redirected to after making payment. For example, a thank you page.')}}
                    </p>
                  </div>
                  <div class="form-group">
                    <label for="wafReturnUrl" class="col-form-label">{{__('Return URL')}}</label>
                    <input type="text" class="form-control form-control-solid mb-3" name="wafReturnUrl" id="wafReturnUrl" aria-describedby="wafReturnUrlHelp" required>
                    <p id="wafReturnUrlHelp" class="">
                      {{__('This is the URL which customers will be redirected when they cancel the payment.')}}
                    </p>
                  </div>
                  <div class="button_type_group fixed_price_group">
                    <div class="form-group">
                      <label for="wafItemPrice" class="col-form-label">{{__('Item Price')}}</label>
                      <input type="number" class="form-control form-control-solid mb-3" name="wafItemPrice" id="wafItemPrice" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="wafItemDescription" class="col-form-label">{{__('Shape')}}</label>
                    <select class="form-control form-control-solid" id="wafButtonShape" required>
                      <option value="Rectangle">{{__('Rectangle')}}</option>
                      <option value="Pill">{{__('Pill')}}</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="wafButtonColour" class="col-form-label">{{__('Colour')}}</label>
                    <select class="form-control form-control-solid" id="wafButtonColour" required>
                      <option value="Gold">{{__('Gold')}}</option>
                      <option value="Blue">{{__('Blue')}}</option>
                      <option value="Silver">{{__('Silver')}}</option>
                      <option value="White">{{__('White')}}</option>
                      <option value="Black">{{__('Black')}}</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="wafButtonText" class="col-form-label">{{__('Button Text')}}</label>
                    <input type="text" class="form-control form-control-solid" id="wafButtonText" name="wafButtonText" value="Checkout" required>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <h3 class="font-weight-bolder">{{__('Preview')}}</h3>
              </div>
            </div>
            <div class="align-item-sm-center flex-sm-nowrap text-left">
              <div class="waf-column-content waf_preview_container" id="wafPreviewContainer">
                <div id="wafButtonPreview">
                  <form class="waf_vgc_js_form" method="POST" action="https://tryba.io/ext_transfer">
                    <input type="hidden" class="waf_vgc_merchant_key" name="merchant_key" value="" />
                    <input type="hidden" class="waf_vgc_public_key" name="public_key" value="{{$user->public_key}}" />
                    <input type="hidden" class="waf_vgc_callback_url" name="callback_url" value="" />
                    <input type="hidden" class="waf_vgc_return_url" name="return_url" value="" />
                    <input type="hidden" class="waf_vgc_tx_ref" name="tx_ref" value="" />
                    <input type="hidden" class="waf_vgc_amount" name="amount" value="" />
                    <input type="hidden" class="waf_vgc_email" name="email" value="user@test.com" />
                    <input type="hidden" class="waf_vgc_first_name" name="first_name" value="Finn" />
                    <input type="hidden" class="waf_vgc_last_name" name="last_name" value="Marshal" />
                    <input type="hidden" class="waf_vgc_title" name="title" value="" />
                    <input type="hidden" class="waf_vgc_description" name="description" value="" />
                    <input type="hidden" class="waf_vgc_quantity" name="quantity" value="1" />
                    <input type="hidden" class="waf_vgc_currency" name="currency" value="42" />
                    <button class="waf_vgc_js_form_btn" disabled type="submit">Checkout</button>
                    <div class="waf_powered_by_vgc">
                      <!--span class="waf_powered_by_text">Powered by </span--><img src="{{asset('asset/'.$logo->image_link)}}">
                  </form>
                </div>
                <div class="wafCopyButtonContainer">
                  <div class="alert alert-success waf_copy_success_message hide" role="alert">
                    <i class="fas fa-check-circle"></i> {{__('Your code was copied to clipboard.')}}
                  </div>
                  <a href="#" class="btn btn-info btn-block" id="wafCopyButton">{{__('Copy Code')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    @if(route('user.merchant-html')==url()->current())
    <div class="card">
      <div class="card-body p-10 p-lg-15">
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Integrating Website Payment')}}</h2>
          <div class="py-5">
            {{__(' Receiving money on your website is now easy')}}. {{__('All you need to do is copy the html form code below to your website page')}}
          </div>
          <pre class="rounded">
                <code class="language-html" data-lang="html">
                &lt;form method="POST" action="{{url('/')}}/ext_transfer" &gt;
                    &lt;input type="hidden" name="merchant_key" value="MERCHANT KEY" /&gt;
                    &lt;input type="hidden" name="public_key" value="PUBLIC KEY" /&gt;
                    &lt;input type="hidden" name="callback_url" value="https://example.com/callbackurl" /&gt;
                    &lt;input type="hidden" name="return_url" value="https://example.com/returnurl" /&gt;
                    &lt;input type="hidden" name="tx_ref" value="2346vrcd" /&gt;
                    &lt;input type="hidden" name="amount" value="100" /&gt;
                    &lt;input type="hidden" name="email" value="yourmail@example.com" /&gt;
                    &lt;input type="hidden" name="first_name" value="John" /&gt;
                    &lt;input type="hidden" name="last_name" value="Doe" /&gt;
                    &lt;input type="hidden" name="title" value="Test Payment" /&gt;
                    &lt;input type="hidden" name="description" value="Payment Description" /&gt;
                    &lt;input type="hidden" name="quantity" value="1" /&gt;
                    &lt;input type="submit" value="submit" /&gt;
                &lt;/form&gt;
                </code>
            </pre>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Validate a Transaction')}}</h2>
          <div class="py-5">
            {{__('This shows you how to validate a transaction')}}
          </div>
          <pre class="rounded">
                <code class="language-html" data-lang="html">
                curl -X GET '{{url("/")}}/api/verify-payment/[tx_ref]' \
                -H 'Accept: application/json' \
                -H 'Authorization: Bearer {token}' \
                </code>
            </pre>
          <p>{{__('Response')}}</p>
          <pre class="rounded">
                <code class="language-html" data-lang="html">
                {
                    "message":"Transaction is Complete",
                    "status":"Paid",
                    "data":{
                        "id":444,
                        "email":"yourmail@example.com",
                        "first_name":"John",
                        "last_name":"Doe",
                        "payment_type":"coinbase",
                        "title":"Test Payment",
                        "description":"Payment Description",
                        "quantity":1,
                        "reference":"09229936784",
                        "amount":100,
                        "merchant_key":"8So3ziLmw9kxHmjo",
                        "callback_url":"https://example.com/callbackurl",
                        "return_url":"https://example.com/returnurl",
                        "tx_ref":"2346vrcd",
                        "created_at":"2021-01-01T22:05:02.000000Z",
                        "updated_at":"2020-05-15T12:05:29.000000Z"
                    }
                }
                </code>
            </pre>
        </div>
        <div class="pb-10">
          <h2 class="anchor fw-bolder">{{__('Parameters requirements')}}</h2>
          <div class="py-5">
            <div class="rounded border p-10 bg-light">
              <div class="mb-6">
                <label class="form-label">merchant_key <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is your app key, it is important for tracking what website is tied to a partciular transaction')}}')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">public_key <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is your public_key, it is important for initiating a transaction. You can get it from ')}}<a href="{{route('user.api')}}">here</a></p>
              </div>
              <div class="mb-6">
                <label class="form-label">callback_url <span class="text-gray-600">url</span> <span class="text-danger">required</span></label>
                <p>{{__('This is your IPN url, it is important for receiving payment notification. Successful transactions redirects to this url after payment')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">return_url <span class="text-gray-600">url</span> <span class="text-danger">required</span></label>
                <p>{{__('Fallback page for cancelled payment')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">tx_ref <span class="text-gray-600">string</span> </label>
                <p>{{__('This is a merchant\'s unique reference for the payment, it can be used to query for the status of the payment.')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">first_name <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the first_name of your customer')}}.</p>
              </div>
              <div class="mb-6">
                <label class="form-label">last_name <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the last_name of your customer')}}.</p>
              </div>
              <div class="mb-6">
                <label class="form-label">email <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the email address of your customer. Transaction notification will be sent to this email address')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">title <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('Title of transaction')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">description <span class="text-gray-600">string</span> <span class="text-danger">required</span></label>
                <p>{{__('Description of what transaction is for')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">amount <span class="text-gray-600">int32</span> <span class="text-danger">required</span></label>
                <p>{{__('This is the amount to charge all customers')}}</p>
              </div>
              <div class="mb-6">
                <label class="form-label">quantity <span class="text-gray-600">int32</span> <span class="text-danger">required</span></label>
                <p>{{__('Quantity of Item being payed for')}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    @if(route('user.merchant-plugin')==url()->current())
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/woocommerce-icon.png')}}" alt="woocommerce">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('Woocommerce')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('WooCommerce is an open-source, completely customizable e-commerce platform for entrepreneurs worldwide. Businesses use WooCommerce to sell anything.')}}</div>
                <a href="https://wordpress.org/plugins/tryba-for-wc" class="btn btn-light-info btn-block my-0"><i class="fal fa-arrow-down"></i> {{__('Download Plugin')}}</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/edd.png')}}" alt="edd">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('Easy Digital Downloads')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('Easy Digital Downloads is a popular eCommerce solution for WordPress that was created to help website owners sell digital products such as eBooks, documents, music, graphic designs and more.')}}</div>
                <a href="{{route('merchant.edd')}}" class="btn btn-light-info btn-block my-0"><i class="fal fa-arrow-down"></i> {{__('Download Plugin')}}</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/gravity-forms-icon.png')}}/" alt="gravifyforms">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('Gravity Forms')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('Gravity Forms is a form-builder plugin that allows you to easily build advanced forms for your WordPress-powered website. Create standard forms, order forms and more with Gravity Forms.')}}</div>
                <a href="{{route('merchant.gf')}}" class="btn btn-light-info btn-block my-0"><i class="fal fa-arrow-down"></i> {{__('Download Plugin')}}</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/givewp.png')}}" alt="givewp">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('GiveWP')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('GiveWP WordPress donation plugin provides a complete suite of fundraising tools for everyone. Use GiveWP to raise money whether it\’s for yourself, your business, or a nonprofit organization.')}}</div>
                <a href="{{route('merchant.gwp')}}" class="btn btn-light-info btn-block my-0"><i class="fal fa-arrow-down"></i> {{__('Download Plugin')}}</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/magento-icon.svg')}}" alt="magneto">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('Magneto')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('Magento is a top commerce solution that can be adapted to any business from small online stores to top Brands. It is use by B2C and B2B industries, with more than $155 billion in gross merchandise volume transacted annually.')}}</div>
                <span class="badge badge-light-info">{{__('Coming Soon')}}</span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/prestashop.png')}}" alt="pretashop">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('PrestaShop')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('PrestaShop is the leading ecommerce platform in Europe and Latin America. It allows entrepreneurs and companies with an ambitious project to create and develop their own ecommerce store.')}}</div>
                <span class="badge badge-light-info">{{__('Coming Soon')}}</span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-center flex-column p-9 text-center">
                <div class="symbol symbol-65px symbol-circle mb-7">
                  <img src="{{asset('asset/images/akaunting-logo.png')}}" alt="akaunting">
                </div>
                <div class="fs-3 text-dark fw-boldest mb-1">{{__('Akaunting')}}</div>
                <div class="fs-6 text-dark mb-6">{{__('Akaunting is a free, open source and online accounting software for small businesses and freelancers. From invoicing to expense tracking to accounting, Akaunting has all the tools you need to manage your money online, for free.')}}</div>
                <span class="badge badge-light-info">{{__('Coming Soon')}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
</div>
@stop