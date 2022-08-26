@extends('user.profile.index')

@section('mainpage')
    @include('user.profile.partials.top', ['title'=>'Connections'])
    <form action="{{route('user.payment.update')}}" method="post">
      @csrf
      <div class="card mb-6">
      <div class="card-body px-9 pt-6 pb-4">
        {{-- @if($user->getCountrySupported()->bank_format=="uk")
          <div class="form-check form-check-solid mb-6">
            <input name="bank_pay" class="form-check-input" type="checkbox" id="customCheckLoginx8" value="1" @if($user->bank_pay==1)checked @endif>
            <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginx8">{{__('Bank transfer')}}</label>
      </div>
      <div id="dvBank" @if($user->bank_pay==null)style="display: none" @endif>
        <div class="form-group row mb-6">
          <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('Account Number')}}</label>
          <div class="col-lg-10">
            <input type="text" name="acct_no" id="acct_no" pattern="\d*" maxlength="8" class="form-control form-control-lg form-control-solid" value="{{$user->acct_no}}">
          </div>
        </div>
        <div class="form-group row mb-6">
          <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('Sort Code')}}</label>
          <div class="col-lg-10">
            <input type="text" name="routing_number" pattern="\d*" maxlength="6" id="routing_number" class="form-control form-control-lg form-control-solid" value="{{$user->routing_number}}">
          </div>
        </div>
      </div>
      @elseif($user->getCountrySupported()->bank_format=="eur")
      <div class="form-check form-check-solid mb-6">
        <input name="bank_pay" class="form-check-input" type="checkbox" id="customCheckLoginxf8" value="1" @if($user->bank_pay==1)checked @endif>
        <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginxf8">{{__('Bank transfer')}}</label>
      </div>
      <div id="dvdBank" @if($user->bank_pay==null)style="display: none" @endif>
        <div class="form-group row mb-6">
          <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('IBAN')}}</label>
          <div class="col-lg-10">
            <input type="text" name="acct_no" pattern="\d*" id="acct_no" maxlength="16" class="form-control form-control-lg form-control-solid" value="{{$user->routing_number}}">
          </div>
        </div>
      </div>
      @endif --}}
      @if(false)
        <div class="mb-4">
          @if ($user->paypal_client_id == NULL AND $user->paypal_secret_key == NULL )
                 @if ($paypalcountry == true)
                 <a target="_blank" class="btn btn-primary px-6" data-paypal-onboard-complete="onboardedCallback" href="{{ $url }}&displayMode=minibrowser" data-paypal-button="true">{{__('Connect to Paypal')}}</a>
                 @endif
          @else
            <a class="btn btn-danger px-6" href="{{ route('disconnectPayPal') }}">{{__('Disconnect Paypal Account')}}</a>
          @endif
        </div>
      @endif

      @if($xf->paypal == 1)
      <div class="form-check form-check-solid mb-6">
        <input name="paypal" class="form-check-input" type="checkbox" id="customCheckLoginfx8" value="1" @if($user->paypal && $user->paypal_client_id != null && $user->paypal_secret_key != null)checked @endif>
        <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginfx8">{{__('Paypal')}}</label>
      </div>
      <div id="dvPaypal" @if($user->paypal == null || ($user->paypal_client_id == null && $user->paypal_secret_key == null))style="display: none" @endif>
        <p class="mb-3 text-dark-400">{{__('Payments made by your customers using Paypal are subjected to Paypal pricing and terms and conditions.')}} <a target="_blank" href="https://developer.paypal.com">{{__('Click here')}} </a> {{__('to get Paypal credentials')}}</p>
        <div class="form-group row mb-6">
          <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('Client ID')}}</label>
          <div class="col-lg-10">
            <input type="text" name="paypal_client_id" placeholder="Client ID" id="paypal_client_id" class="form-control form-control-lg form-control-solid" value="{{$user->paypal_client_id}}">
          </div>
        </div>
        <div class="form-group row mb-6">
          <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('Secret Key')}}</label>
          <div class="col-lg-10">
            <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control form-control-lg form-control-solid" placeholder="Secret Key" value="{{$user->paypal_secret_key}}">
          </div>
        </div>
      </div>

    @endif
      {{--
    @if($user->getCountrySupported()->stripe==1)
      <div class="form-check form-check-solid mb-6">
        <input name="stripe" class="form-check-input" type="checkbox" id="customCheckLogingdx8" value="1" @if($user->stripe==1)checked @endif>
        <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLogingdx8">{{__('Stripe')}}</label>
        </div>
        <div id="dvStripe" @if($user->stripe==null)style="display: none" @endif>
          <p class="mb-3 text-dark-400">{{__('Payments made by your customers using Stripe are subjected to Stripe pricing and terms and conditions. You can only use stripe live keys.')}} <a target="_blank" href="https://stripe.com/docs/keys">{{__('Click here')}} </a> {{__('to get Stripe API key')}}</p>
          <div class="form-group row mb-6">
            <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('Publishable key')}}</label>
            <div class="col-lg-10">
              <input type="text" name="stripe_public_key" id="stripe_public_key" class="form-control form-control-lg form-control-solid" value="{{$user->stripe_public_key}}">
            </div>
          </div>
          <div class="form-group row mb-6">
            <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('Secret Key')}}</label>
            <div class="col-lg-10">
              <input type="text" name="stripe_secret_key" id="stripe_secret_key" class="form-control form-control-lg form-control-solid" value="{{$user->stripe_secret_key}}">
            </div>
          </div>
        </div>
    @endif
    --}}
  <div class="my-6">
    @if ($xero == false)
      <a href="{{ route('user.xero') }}" class="btn btn-primary px-6">{{__('Connect to Xero')}}</a>
    @else
      <a href="{{ route('user.xero.disconnect') }}" class="btn btn-danger px-6">{{__('Disconnect Xero')}}</a>
    @endif
  </div>

  <div class="mb-4">
  {{--  <a href="{{ route('stripe') }}"><button class="btn btn-primary px-6" id="stripe">Connect to Stripe</button></a>  --}}
  <a href="{{ $stripe_url }}" class="btn btn-primary px-6">{{__('Connect to Stripe')}}</a>
 </div>
  {{-- @if($user->getCountrySupported()->coinbase==1)
  <div class="form-check form-check-solid mb-6">
    <input name="coinbase" class="form-check-input" type="checkbox" id="customCheckLoginhx8" value="1" @if($user->coinbase==1)checked @endif>
    <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoginhx8">{{__('Coinbase')}}</label>
  </div>
  <div id="dvCoinbase" @if($user->coinbase==null)style="display: none" @endif>
    <p class="mb-3 text-dark-400">{{__('Payments made by your customers using Coinbase commerce are subjected to Coinbase commerce pricing and terms and conditions.')}} <a target="_blank" href="https://commerce.coinbase.com/docs/">{{__('Click here')}} </a> {{__('to get coinbase commerce API key')}}</p>
    <div class="form-group row mb-6">
      <label class="col-form-label col-lg-2 required fw-bold fs-6">{{__('API Key')}}</label>
      <div class="col-lg-10">
        <input type="text" name="coinbase_api_key" id="coinbase_api_key" class="form-control form-control-lg form-control-solid" value="{{$user->coinbase_api_key}}">
      </div>
    </div>
  </div>
  @endif --}}
    </div>
    <div class="card-footer d-flex justify-content-end py-6 px-9">
      <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
    </div>
</div>
</form>
</div>
@endsection

<script>
  {{--  let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  let stripe = document.getElementById('stripe');
  stripe.addEventListener("click", function(e){
      if(e.target){
          //{{ route('user.smsEmail',$user->id) }}
        let url = "{{ route('stripe') }}"
       // let url = "{{ route('user/stripe') }}"
       // let formData = new FormData();
       // formData.append('status', 'yes');
          fetch(url, {
              method: "GET",
              body: formData,
             headers: {"Content-type": "application/json;charset=UTF-8",
                       "X-CSRF-TOKEN": token}
          }).then(Response => {
              return Response.json()
          }).then(res => {

          })

      }
  })  --}}
</script>
@section('script')
    <script>
      let Paypal = document.querySelector("#payPalBtn");
        const toogleCredentials =() => {
          let credentialsForms =  document.querySelector("#payPalCredentials")
          credentialsForms.classList.toggle("d-none")
        }

        Paypal.addEventListener("click", toogleCredentials);



    </script>
    @if($user->getCountrySupported()->paypal==1)
        <script id="paypal-js" src="https://www.sandbox.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js"></script>
    @endif

    @if(!empty($seller))
        <script>
            function onboardedCallback(authCode, sharedId) {
                fetch("{{ route('payPalSave') }}", {
                method: 'POST',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    authCode: authCode,
                    sharedId: sharedId,
                    _token: "{{ csrf_token() }}",
                    seller: "{{ $seller }}"
                })
                }).then(function(res) {
                if (!response.ok) {
                    alert("Something went wrong!");
                }
                });
            }


        </script>
    @endif
@endsection
