@extends('user.profile.index')

@section('mainpage')
    @include('user.profile.partials.top', ['title'=>'Security'])
    <form action="{{route('change.password')}}" method="post">
      @csrf
      <div class="card mb-6">
      <div class="card-body px-9 pt-6 pb-4">
        <div class="notice d-flex rounded p-6 mb-8" style="background-color: #FFF9DE; border: none">
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
              <h4 class="text-gray-800 fw-bolder">{{__('Secure Your Account')}}</h4>
              <div class="fs-6 text-gray-600 pe-7">{{__('Two-factor authentication adds an extra layer of security to your account. To log in, in addition you\'ll need to provide a 6 digit code')}}</div>
            </div>
            <a href="#" class="btn btn-primary px-6 text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication"> @if($user->fa_status==0)
              {{__('Enable 2FA')}}@elseif($user->fa_status==1){{__('Disable 2FA')}}@endif
            </a>
          </div>
        </div>


        <div class="row mb-6">
          <div class="col-lg-12">
            <input placeholder="{{__('Current Password*')}}" type="password" name="password" class="bg-light-primary py-5 form-control form-control-lg form-control-solid me-3 flex-grow-1" required>
          </div>
        </div>
        <div class="row mb-6">
          <div class="col-lg-12">
            <input placeholder="{{__('New Password*')}}" type="password" name="new_password" class="bg-light-primary py-5 form-control-lg form-control form-control-solid me-3 flex-grow-1" required>
          </div>
        </div>
      </div>


      <div class="card card-body py-10 mb-6" style="background-color: #FFF9DE;">
              <h6>Secure Your Card</h6>
              <p>Two factor authentication adds extra layer of security to your account. To log in, in addition, you
                  will need to provide a 6 digit code</p>
              <div>
                  <button class="btn btn-light-primary px-6" type="submit" style="background-color: #00AFEF; color: #ffffff">Enable 2FA</button>
              </div>
          </div>



      <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
      </div>
      </div>
    </form>
    <div class="modal fade" id="kt_modal_two_factor_authentication" tabindex="-1" style="display: none;" aria-hidden="true">
      <!--begin::Modal header-->
      <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
          <!--begin::Modal header-->
          <div class="modal-header flex-stack">
            <!--begin::Title-->
            <div class="fs-3 fw-boldest">{{__('Two-Factor Authenticaton')}}</div>
            <!--end::Title-->
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
              <!--begin::Svg Icon | path: icons/duotone/Interface/Close-Square.svg-->
              <span class="svg-icon svg-icon-2x">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                </svg>
              </span>
              <!--end::Svg Icon-->
            </div>
            <!--end::Close-->
          </div>
          <!--begin::Modal header-->
          <!--begin::Modal body-->
          <div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
            <div>
              <!--begin::Heading-->
              <h3 class="text-dark fw-boldest fs-3 mb-7">{{__('Authenticator Apps')}}</h3>
              <!--end::Heading-->
              <!--begin::Description-->
              <div class="text-gray-500 fw-bold fs-5 mb-10">{{__('Using an authenticator app like')}}
                <a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">{{__('Google Authenticator')}}</a>,
                <a href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">{{__('Microsoft Authenticator')}}</a>,
                <a href="https://authy.com/download/" target="_blank">{{__('Authy')}}</a>, {{__('or')}}
                <a href="https://support.1password.com/one-time-passwords/" target="_blank">{{__('1Password')}}</a>, {{__('scan the QR code. It will generate a 6 digit code for you to enter below')}}.
                <!--begin::QR code image-->
                <div class="pt-5 text-center">
                  @if($user->fa_status==0)
                  <img src="{{$image}}" alt="" class="mw-150px">
                  @endif
                </div>
                <!--end::QR code image-->
              </div>
              <!--end::Description-->
              <!--begin::Notice-->
              <div class="notice d-flex bg-light-warning  border-warning border border-dashed rounded mb-10 p-6">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                    <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                  </svg>
                </span>
                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Wrapper-->
                @if($user->fa_status==0)
                <div class="d-flex flex-stack flex-grow-1">
                  <!--begin::Content-->
                  <div class="fw-bold">
                    <div class="fs-6 text-gray-600">{{__('If you having trouble using the QR code, select manual entry on your app, and enter your username and the code:')}}
                      <div class="fw-boldest text-dark pt-2">{{$secret}}</div>
                    </div>
                  </div>
                  <!--end::Content-->
                </div>
                @endif
                <!--end::Wrapper-->
              </div>
              <!--end::Notice-->
              <!--begin::Form-->
              <form action="{{route('change.2fa')}}" method="post">
                @csrf
                <!--begin::Input group-->
                <div class="mb-10 fv-row fv-plugins-icon-container">
                  <input type="text" pattern="\d*" name="code" class="form-control form-control-lg form-control-solid" minlength="6" maxlength="6" placeholder="Enter authentication code" required>
                  <input type="hidden" name="vv" value="{{$secret}}">
                  @if($user->fa_status==0)
                  <input type="hidden" name="type" value="1">
                  @elseif($user->fa_status==1)
                  <input type="hidden" name="type" value="0">
                  @endif
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="d-flex flex-center">
                  <button type="submit" class="btn btn-primary btn-block">
                    @if($user->fa_status==0)
                    {{__('Enable 2FA')}}
                    @elseif($user->fa_status==1)
                    {{__('Disable 2FA')}}
                    @endif
                  </button>
                </div>
                <!--end::Actions-->
                <div></div>
              </form>
              <!--end::Form-->
            </div>
          </div>
          <!--begin::Modal body-->
        </div>
        <!--end::Modal content-->
      </div>
      <!--end::Modal header-->
    </div>
@endsection
