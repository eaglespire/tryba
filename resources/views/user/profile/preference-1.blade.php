@extends('user.profile.index')

@section('mainpage')
    <form action="{{route('user.preferences.update')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="card mb-6">
        <div class="card-body px-9 pt-6 pb-4">
          <div class="row mb-6">
            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Support Email')}}</label>
            <div class="col-lg-9">
              <input type="email" name="support_email" id="support_email" class="form-control form-control-lg form-control-solid" placeholder="{{__('Email address')}}" value="{{$user->support_email}}" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Support Phone')}}</label>
            <div class="col-lg-9">
              <input type="text" name="support_phone" id="support_phone" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number')}}" value="{{$user->support_phone}}" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6 required">{{__('Checkout Theme')}}</label>
            <div class="col-lg-9">
              <select name="checkout_theme" aria-label="Select a theme" data-control="select2" data-placeholder="Select a theme..." class="form-select form-select-solid form-select-lg select2-hidden-accessible" data-select2-id="select2-data-4-swnc" tabindex="-1" aria-hidden="true">
                <option value="">{{__('Select Checkout form theme')}}</option>
                <option value="bg-white" @if($user->checkout_theme==null) selected @endif>{{__('Default')}}</option>
                <option value="bg-newlife" @if($user->checkout_theme=="bg-newlife") selected @endif>{{__('New Life')}}</option>
                <option value="bg-morpheusden" @if($user->checkout_theme=="bg-morpheusden") selected @endif>{{__('Morpheus Den')}}</option>
                <option value="bg-sharpblues" @if($user->checkout_theme=="bg-sharpblues") selected @endif>{{__('Sharp Blue')}}</option>
                <option value="bg-fruitblend" @if($user->checkout_theme=="bg-fruitblend") selected @endif>{{__('Fruit Blend')}}</option>
                <option value="bg-deepblue" @if($user->checkout_theme=="bg-deepblue") selected @endif>{{__('Deep Blue')}}</option>
                <option value="bg-fabledsunset" @if($user->checkout_theme=="bg-fabledsunset") selected @endif>{{__('Fabled Sunset')}}</option>
              </select>
            </div>
          </div>
          <div class="row mb-6">
            <div class="col-lg-12">
              <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                <input name="social_links" class="form-check-input h-20px w-30px" type="checkbox" id="customCheckLoging4" value="1" @if($user->social_links==1)checked @endif>
                <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoging4">{{__('Show Social media account links')}}</label>
              </div>
              <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                <input name="display_support_email" class="form-check-input h-20px w-30px" type="checkbox" id="customCheckLoging66" value="1" @if($user->display_support_email==1)checked @endif>
                <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoging66">{{__('Show Support email')}}</label>
              </div>
              <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                <input name="display_support_phone" class="form-check-input h-20px w-30px" type="checkbox" id="customCheckLoging55" value="1" @if($user->display_support_phone==1)checked @endif>
                <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoging55">{{__('Show Support phone')}}</label>
              </div>
            </div>
          </div>
          @if($user->kyc_verif_status==null || $user->kyc_verif_status=="DECLINED")
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
                <h4 class="text-gray-800 fw-bolder">{{__('To enable live mode, We need more information about you')}}</h4>
                <div class="fs-6 text-gray-600 pe-7">{{__('Compliance is currently due, please update your account information to avoid restrictions such as no access to storefront service.')}}</div>
              </div>
              <a href="{{route('compliance.session')}}" class="btn btn-primary px-6 align-self-center text-nowrap">
                {{__('Click here')}}
              </a>
            </div>
          </div>
          @endif
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
          <a href="#" data-bs-toggle="modal" data-bs-target="#delete_account" class="btn btn-light-danger btn-active-light-danger me-2"><i class="fal fa-trash"></i> {{__('Delete account')}}</a>
          <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
        </div>
      </div>
    </form>


    <div class="modal fade" id="delete_account" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
          <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('delaccount')}}" method="post" id="modal-details">
            @csrf
            <div class="modal-header">
              <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Delete Account')}}</h3>
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
                  <label class="required fs-5 fw-bold mb-2">{{__('Reason')}}</label>
                  <textarea type="text" name="reason" placeholder="{{__('Sorry to see you leave, Please tell us why you are leaving')}}')}}" rows="5" class="form-control form-control-solid" required></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer flex-center">
              <button type="submit" form="modal-details" class="btn btn-success btn-block">{{__('Submit')}}</button>
            </div>
            <div></div>
          </form>
        </div>
      </div>
    </div>
    <form action="{{route('edit.store.mail', ['id'=>$user->id])}}" method="post">
      @csrf
      <div class="card mt-6">
        <div class="card-body">
            <div class="accordion accordion-icon-toggle" id="kt_accordion_1">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="kt_accordion_1_header_2">
                        <button class="accordion-button fs-4 fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_2">
                            {{__('Mail Configuration')}}
                        </button>
                    </h2>
                    <div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body">
                            <div class="card-body">
                                <div class="row mb-6">
                                    <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('What email smtp configuration will you be using?')}}</label>
                                    <div class="col-lg-12">
                                        <select id="mail" name="status" class="form-select form-select-solid" required>
                                            <option value='0' @if($user->mailDriver != NULL && $user->mailDriver->status == 0) selected @endif>Tryba ({{__('You can\'t send custom emails to customers using this!')}})</option>
                                            <option value='1' @if($user->mailDriver != NULL && $user->mailDriver->status == 1) selected @endif>My Email Configuration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-6" id="showMail" style="display:none;">
                                    <div class="col-lg-6">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail Host')}}</label>
                                        <input type="text" placeholder="smtp.com" value="{{($user->mailDriver) ? $user->mailDriver->mail_host : ""}}" class="form-control form-control-solid" name="mail_host" id="mail_host" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail Port')}}</label>
                                        <input type="text" placeholder="465" value="{{ ($user->mailDriver) ?  $user->mailDriver->mail_port :"" }}" class="form-control form-control-solid" name="mail_port" id="mail_port" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail Username')}}</label>
                                        <input type="text" placeholder="username" value="{{ ($user->mailDriver) ? $user->mailDriver->mail_username :""}}" class="form-control form-control-solid" name="mail_username" id="mail_username" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail Password')}}</label>
                                        <input type="password" placeholder="password" value="{{ ($user->mailDriver) ? $user->mailDriver->mail_password :""}}" class="form-control form-control-solid" name="mail_password" id="mail_password" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail Encryption')}}</label>
                                        <input type="text" placeholder="SSL/TLS" value="{{ ($user->mailDriver) ? $user->mailDriver->mail_encryption :""}}" class="form-control form-control-solid" name="mail_encryption" id="mail_encryption" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail From Address')}}</label>
                                        <input type="email" placeholder="email address" value="{{($user->mailDriver) ? $user->mailDriver->mail_from_address : "" }}" class="form-control form-control-solid" name="mail_from_address" id="mail_from_address" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="col-form-label fw-bold fs-6">{{__('Mail From Name')}}</label>
                                        <input type="text" placeholder="sender name" value="{{($user->mailDriver) ? $user->mailDriver->mail_from_name : ""}}" class="form-control form-control-solid" name="mail_from_name" id="mail_from_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                @if($user->mailDriver != NULL && $user->mailDriver->status == 1)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#test_email" class="btn btn-success px-6 me-2">{{__('Test SMTP')}}</a>
                                @endif
                                <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </form>
  <div class="modal fade" id="test_email" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
      <div class="modal-content">
        <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('test.store.mail') }}" method="post">
          @csrf
          <div class="modal-header">
            <h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Send Test Email')}}</h3>
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
                <label class="required fs-5 fw-bold mb-2">{{__('Recipent Email')}}</label>
                <input type="text" placeholder="Receipent Email" class="form-control form-control-solid" name="email" id="email" required>
              </div>
              <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                <label class="required fs-5 fw-bold mb-2">{{__('Message')}}</label>
                <textarea type="text" name="message" placeholder="{{__('Message')}}" rows="5" class="form-control form-control-solid" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer flex-center">
            <button type="submit" class="btn btn-primary btn-block">{{__('Submit')}}</button>
          </div>
          <div></div>
        </form>
      </div>
    </div>
  </div>

  <div class="card mt-6">
    <div class="card-header align-items-center border-0 mt-5">
        <h3 class="fw-boldest text-dark fs-6x">{{__('Connect domain')}}</h3>
        <p>{{__('To connect your domain, you need to log in to your provider account and change your settings. Follow the provider step-by-step instructions to get started')}} 
            {{--<a href="{{route('user.store.custom.domain')}}">click here</a>--}}
        </p>
        <ol>
            <li>On your domain provider’s website, log in to your account.</li>
            <li>Create CNAME record with the target of {{ request()->getHost() }} might take up to 24-48 hours for the DNS to be resolved.</li>
            <li>Navigate to storefront dashboard.</li>
            <li>Add your custom domain to Tryba.</li>
            <li>Save your changes.</li>
        </ol>
    </div>
    <form action="{{ (!empty($user->customDomain->domain)) ? (env('APP_ENV') == 'local') ? route('disconnect.domain', ['id'=>$user->id]) : route('edit.domain', ['id' => $user->id]) : ""}}" method="post" class="px-5" enctype="multipart/form-data">
        <div class="card-body">
            @csrf
            <input type="url" class="form-control form-control-solid mb-3" name="custom_domain" placeholder="{{__('https://mydomain.com')}}" value="{{ (!empty($user->customDomain)) ? $user->customDomain->domain : "" }}" @if(!empty($user->customDomain->domain)) disabled @endif  >
            @if(empty($user->customDomain->domain))
                <button type="submit" class="btn btn-light-info btn-block px-6">{{__('Add custom domain')}}</button>
            @elseif(env('APP_ENV') == 'local')
                <button type="submit" class="btn btn-danger btn-block px-6">{{__('Disconnect custom domain')}}</button>
            @endif
        </div>
    </form>
</div>
@endsection


@section('script')
  <script>
      
    function setupMail() {
        var type = $("#mail").find(":selected").val();
        if (type == 0) {
            $('#showMail').hide();
            $('#mail_host').removeAttr('required', '');
            $('#mail_port').removeAttr('required', '');
            $('#mail_username').removeAttr('required', '');
            $('#mail_password').removeAttr('required', '');
            $('#mail_encryption').removeAttr('required', '');
            $('#mail_from_address').removeAttr('required', '');
            $('#mail_from_name').removeAttr('required', '');
        } else if (type == 1) {
            $('#showMail').show();
            $('#mail_host').attr('required', '');
            $('#mail_port').attr('required', '');
            $('#mail_username').attr('required', '');
            $('#mail_password').attr('required', '');
            $('#mail_encryption').attr('required', '');
            $('#mail_from_address').attr('required', '');
            $('#mail_from_name').attr('required', '');
        }
    }
    $("#mail").change(setupMail);
    setupMail();
</script>
  </script>
@endsection