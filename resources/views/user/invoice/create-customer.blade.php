@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Customer')}}</h1>
      <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.customer')}}" class="text-muted text-hover-primary">{{__('Customer')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{__('Create')}}</li>
      </ul>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="card">
      <div class="card-header card-header-stretch">
        <div class="card-title d-flex align-items-center">
          <h3 class="fw-bolder m-0 text-dark">{{__('New Customer')}}</h3>
        </div>
      </div>
      <form action="{{route('submit.customer')}}" id="payment-form" method="post">
        @csrf
        <div class="card-body px-9 pt-6 pb-4">
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Company Name')}}</label>
            <div class="col-lg-9">
              <input type="text" name="company_name" value="{{ (old('company_name')) ? old('company_name') : "" }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Company name">
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Full Name')}}</label>
            <div class="col-lg-9">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" name="first_name" value="{{ (old('first_name')) ? old('first_name') : "" }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" required>
                </div>
                <div class="col-lg-6">
                  <input type="text" name="last_name" value="{{ (old('last_name')) ? old('last_name') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="Last name" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">
              <span class="required">{{__('Contact Phone')}}</span>
            </label>
            <div class="col-lg-9">
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group input-group-solid">
                    <span class="input-group-prepend">
                      <select name="code" data-control="select2" class="form-control form-control-lg form-control-solid" required>
                        @foreach(getPhone() as $val)
                        <option value="{{$val->iso2}}" @if(old('code') == $val->iso2)selected @endif>{{ ' +'.str_replace('+', '', $val->phonecode) }}</option>
                        @endforeach
                      </select>
                    </span>
                    <input type="tel" name="phone" maxlength="14" value="{{ (old('phone')) ? old('phone') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - without country code')}}" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">
              <span class="required">{{__('Email Address')}}</span>
            </label>
            <div class="col-lg-9">
              <input type="email" name="email" value="{{ (old('email')) ? old('email') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="Email address" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">
              <span class="required">{{__('Country')}}</span>
            </label>
            <div class="col-lg-9">
              <select name="country" id="country" data-control="select2" class="form-control form-control-lg form-control-solid" required>
                <option value="">{{__('Select your country')}}</option>
                @foreach(getShipping() as $val)
                <option value="{{$val->id}}">{{ $val->emoji.' '.$val->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-6" id="showState" style="display:none;">
            <label class="col-lg-3 col-form-label fw-bold fs-6">
              <span class="required">{{__('County')}}</span>
            </label>
            <div class="col-lg-9">
              <select class="form-control form-control-lg form-control-solid" data-control="select2" id="state" name="state" required>
                <option value=''>Select your county</option>
              </select>
            </div>
          </div>
          <div class="row mb-6" id="showCity" >
            <label class="col-lg-3 col-form-label fw-bold fs-6">
              <span class="required">{{__('City')}}</span>
            </label>
            <div class="col-lg-9">
              <input type="text" name="city" value="{{ (old('city')) ? old('city') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="City" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Line 1')}}</label>
            <div class="col-lg-9">
              <input type="text" name="line_1" value="{{ (old('line_1')) ? old('line_1') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="Line 1" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Line 2')}}</label>
            <div class="col-lg-9">
              <input type="text" name="line_2" value="{{ (old('line_2')) ? old('line_2') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="Line 2">
            </div>
          </div>
          <div class="row mb-6">
            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Postcode')}}</label>
            <div class="col-lg-9">
              <input type="text" name="postal_code" value="{{ (old('postal_code')) ? old('postal_code') : "" }}" class="form-control form-control-lg form-control-solid" placeholder="Postcode" required>
            </div>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
          <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@stop
@section('script')
<script>
  function countrychange() {
    var selectedCountry = $("#country").find(":selected").val();
    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: "{{route('user.address.country')}}",
      data: {
        country: selectedCountry
      },
      success: function(response) { 
          $('#showState').show();
          response.forEach(element => {
            $('#state').append(new Option(`${element.name}`,`${element.id}`))
          });
          $('#state').attr('required', '');
      },
      error: function(err) {
        console.log(err)
      }
    });
  }
  $("#country").change(countrychange);
</script>
<script>
  function addresschange() {
    var selectedState = $("#state").find(":selected").val();
    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: "{{route('user.address.state')}}",
      data: {
        state: selectedState
      },
      success: function(response) {
        console.log(response);
        if (response.trim() == '') {
          $('#showCity').hide();
          $('#city').removeAttr('required', '');
        } else {
          $('#showCity').show();
          $('#city').html(response);
          $('#city').attr('required', '');
        }
      },
      error: function(err) {
        console.log(err)
      }
    });
  }
  $("#state").change(addresschange);
</script>
@endsection
