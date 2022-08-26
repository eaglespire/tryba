@extends('user.profile.index')

@section('mainpage')
    <form action="{{route('savewebhook')}}" method="post">
      @csrf
      <div class="card mb-6">
      <div class="card-body px-9 pt-6 pb-4">
        @if($user->live==1)
        @if($user->kyc_verif_status=="APPROVED")
        <div class="row mb-6">
          <label class="col-lg-2 col-form-label fw-bold fs-6">{{__('Public key')}}</label>
          <div class="col-lg-10">
            <div class="d-flex">
              <input type="text" class="form-control form-control-solid me-3 flex-grow-1" value="{{$user->public_key}}">
              <span class="castro-copy btn btn-light fw-boldest flex-shrink-0" data-clipboard-text="{{$user->public_key}}">Copy</span>
            </div>
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-2 col-form-label fw-bold fs-6">{{__('Secret key')}}</label>
          <div class="col-lg-10">
            <div class="d-flex">
              <input type="text" class="form-control form-control-solid me-3 flex-grow-1" value="{{$user->secret_key}}">
              <span class="castro-copy btn btn-light fw-boldest flex-shrink-0" data-clipboard-text="{{$user->secret_key}}">Copy</span>
            </div>
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-2 col-form-label fw-bold fs-6">{{__('Webhook')}}</label>
          <div class="col-lg-10">
            <input type="url" class="form-control form-control-solid me-3 flex-grow-1" placeholder="https://webhook.site" value="{{$user->webhook}}">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-check form-check-solid mb-6">
              <input name="receive_webhook" class="form-check-input" type="checkbox" id="customCheckLoginr8" value="1" @if($user->receive_webhook==1)checked @endif>
              <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginr8">{{__('Receive Webhook Notifications')}}</label>
            </div>
          </div>
        </div>
        @else
        <div class="notice d-flex bg-light-primary rounded border-primary p-6 mb-8">
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
        @else
        <div class="row mb-6">
          <label class="col-lg-2 col-form-label fw-bold fs-6">{{__('Public key')}}</label>
          <div class="col-lg-10">
            <div class="d-flex">
              <input type="text" class="form-control form-control-solid me-3 flex-grow-1" value="{{$user->test_public_key}}">
              <span class="castro-copy btn btn-light fw-boldest flex-shrink-0" data-clipboard-text="{{$user->test_public_key}}">Copy</span>
            </div>
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-2 col-form-label fw-bold fs-6">{{__('Secret key')}}</label>
          <div class="col-lg-10">
            <div class="d-flex">
              <input type="text" class="form-control form-control-solid me-3 flex-grow-1" value="{{$user->test_secret_key}}">
              <span class="castro-copy btn btn-light fw-boldest flex-shrink-0" data-clipboard-text="{{$user->test_secret_key}}">Copy</span>
            </div>
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-2 col-form-label fw-bold fs-6">{{__('Webhook')}}</label>
          <div class="col-lg-10">
            <input type="url" class="form-control form-control-solid me-3 flex-grow-1" placeholder="https://webhook.site" value="{{$user->webhook}}">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-check form-check-solid mb-6">
              <input name="receive_webhook" class="form-check-input" type="checkbox" id="customCheckLoginr8" value="1" @if($user->receive_webhook==1)checked @endif>
              <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginr8">{{__('Receive Webhook Notifications')}}</label>
            </div>
          </div>
        </div>
        @endif
      </div>
      @if($user->kyc_verif_status=="APPROVED")
      <div class="card-footer d-flex justify-content-end py-6 px-9">
        <a href="{{route('generateapi')}}" class="btn btn-light-primary btn-active-light-primary me-2"><i class="fal fa-sync"></i> {{__('Generate New Keys')}}</a>
        <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
      </div>
      @endif
      </div>
    </form>
@endsection
