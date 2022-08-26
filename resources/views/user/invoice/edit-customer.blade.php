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
        <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
      </ul>
    </div>
    <div class="d-flex py-2">
      <a href="{{route('user.add-customer')}}" class="btn btn-dark">{{__('Add a Customer')}}</a>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="card">
      <div class="card-header card-header-stretch">
        <div class="card-title d-flex align-items-center">
          <h3 class="fw-bolder m-0 text-dark">{{__('Edit Customer')}}</h3>
        </div>
      </div>
      <form action="{{route('update.customer',$customer->ref_id)}}" method="post">
        @csrf
        @method('put')
        <div class="card-body px-9 pt-6 pb-4">
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Company Name')}}</label>
            <div class="col-lg-9">
              <input type="text" name="company_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Company name" value="{{$customer->company_name}}">
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Full Name')}}</label>
            <div class="col-lg-9">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="{{$customer->first_name}}" required>
                </div>
                <div class="col-lg-6">
                  <input type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="{{$customer->last_name}}" required>
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
                      <select name="code" class="form-control form-control-lg form-control-solid" data-control="select2">
                        @foreach(getPhone() as $val)
                        <option value="{{$val->iso2}}" @if($customer->code==$val->iso2)selected @endif>{{ ' +'.str_replace('+', '', $val->phonecode) }}</option>
                        @endforeach
                      </select>
                    </span>
                    <input type="tel" name="phone" maxlength="14" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - without country code')}}" value="{{$customer->split_phone}}" required>
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
              <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email address" value="{{$customer->email}}" required>
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
                 <option value="{{$val->id}}" @if($customer->country==$val->id) selected @endif>{{ $val->emoji.' '.$val->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
            <div class="row mb-6" id="showState">
              <label class="col-lg-3 col-form-label fw-bold fs-6">
                <span class="required">{{__('County')}}</span>
              </label>
              <div class="col-lg-9">
                <select class="form-control form-control-lg form-control-solid" data-control="select2" id="state" name="state" required>
                  <option value="">{{__('Select your county')}}</option>
                  @foreach(getInvoiceState($user->getCountry()->iso) as $val)
                  <option value="{{$val->id}}" @if($customer->state == $val->id) selected @endif>{{$val->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          <div class="row mb-6" id="showCity">
            <label class="col-lg-3 col-form-label fw-bold fs-6">
              <span class="required">{{__('City')}}</span>
            </label>
            <div class="col-lg-9">
              <input type="text" name="city" value="{{ $customer->city }}" class="form-control form-control-lg form-control-solid" placeholder="City" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Line 1')}}</label>
            <div class="col-lg-9">
              <input type="text" name="line_1" class="form-control form-control-lg form-control-solid" placeholder="Line 1" value="{{$customer->line_1}}" required>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Line 2')}}</label>
            <div class="col-lg-9">
              <input type="text" name="line_2" class="form-control form-control-lg form-control-solid" placeholder="Line 2" value="{{$customer->line_2}}">
            </div>
          </div>
          <div class="row mb-6">
            <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Postcode')}}</label>
            <div class="col-lg-9">
              <input type="text" name="postal_code" class="form-control form-control-lg form-control-solid" placeholder="Postcode" value="{{$customer->postal_code}}" required>
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
        if (response.trim() == '') {
          $('#showState').hide();
          $('#showCity').hide();
          $('#state').removeAttr('required', '');
          $('#city').removeAttr('required', '');
        } else {
          $('#showState').show();
          $('#state').html(response);
          $('#state').attr('required', '');
        }
      },
      error: function(err) {
        console.log(err)
      }
    });
  }
  $("#country").change(countrychange);
  function ffff() {
    var selectedCountry = $("#country").find(":selected").val();
    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: "{{route('user.address.countryf')}}",
      data: {
        country: selectedCountry,
        state: '{{$customer->state}}'
      },
      success: function(response) {
        if (response.trim() == '') {
          $('#showState').hide();
          $('#showCity').hide();
          $('#state').removeAttr('required', '');
          $('#city').removeAttr('required', '');
        } else {
          $('#showState').show();
          $('#state').html(response);
          $('#state').attr('required', '');
        }
      },
      error: function(err) {
        console.log(err)
      }
    });
  }
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
  function xxxx() {
    var selectedState = $("#state").find(":selected").val();
    $.ajax({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: "{{route('user.address.statef')}}",
      data: {
        state: '{{$customer->state}}',
        city: '{{$customer->city}}'
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

</script>
@endsection