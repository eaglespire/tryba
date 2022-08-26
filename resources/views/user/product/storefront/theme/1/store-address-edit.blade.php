@extends('user.product.storefront.theme.1.menu')

@section('content')
<div class="tt-breadcrumb">
  <div class="container">
    <ul>
      <li><a href="{{route('store.index', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
      <li><a href="{{route('customer.address', ['id'=>$store->store_url])}}">{{__('Address')}}</a></li>
      <li><a href="javascript:void;">{{__('Edit address')}}</a></li>
    </ul>
  </div>
</div>
<div id="tt-pageContent">
  <div class="container-indent">
    <div class="container">
      <div class="tt-login-form">
        <div class="row">
          <div class="col-xs-12 col-md-10 offset-md-1">
            <div class="tt-item">
              <div class="form-default form-top">
                <form action="{{route('customer.address.update', ['store_url'=>$store->store_url])}}" method="post">
                  @csrf
                  <div class="form-group">
                    <label>{{__('LINE 1')}}*</label>
                    <input type="text" name="line_1" class="form-control" placeholder="{{__('Enter Address')}}" required value="{{$address->line_1}}">
                  </div>
                  <div class="form-group">
                    <label>{{__('LINE 2')}}</label>
                    <input type="text" name="line_2" class="form-control" placeholder="{{__('Enter Second Address (optional)')}}" value="{{$address->line_2}}">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="loginInputLast">{{__('ZIP/POSTAL CODE')}} *</label>
                        <input type="text" name="postal_code" maxlength="6" class="form-control" id="loginInputLast" value="{{$address->postal_code}}" placeholder="{{__('Enter Postal code')}}" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>{{__('STATE/COUNTY')}} *</label>
                    <select class="form-control" id="state" name="state" required>
                      <option value="">{{__('Select your state/county')}}</option>
                      @foreach($shipping as $val)
                      <option value="{{$val->state}}*{{$val->id}}*{{$val->shippingState->iso2}}" @if($address->shipping_id==$val->id) selected @endif>{{$val->shippingState->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group" id="showState" style="display:none;">
                    <label>{{__('CITY')}} *</label>
                    <select class="form-control" id="city" name="city">
                    </select>
                  </div>
                  <input type="hidden" name="store_id" value="{{$store->id}}">
                  <input type="hidden" name="id" value="{{$address->id}}">
                  <div class="row">
                    <div class="col-auto mr-auto">
                      <div class="form-group">
                        <button class="btn btn-border" type="submit">{{__('Edit')}}</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @stop
  @section('script')
  <script>
    function addresschange() {
      var selectedState = $("#state").find(":selected").val();
      $.ajax({
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "{{route('customer.address.state')}}",
        data: {
          "_token": "{{ csrf_token() }}",
          state: selectedState
        },
        success: function(response) {
          console.log(response);
          if (response.trim() == '') {
            $('#showState').hide();
            $('#city').removeAttr('required', '');
          } else {
            $('#showState').show();
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
    addresschange();
  </script>
  @endsection