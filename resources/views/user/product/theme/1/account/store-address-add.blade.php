@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
  <div class="core__inner">
    <!-- PAGE HEADER : begin -->
    <div class="page-header">
      <div class="page-header__inner">
        <div class="lsvr-container">
          <div class="page-header__content">

            <h1 class="page-header__title">{{__('Address')}}</h1>
            <!-- BREADCRUMBS : begin -->
            <div class="breadcrumbs">
              <div class="breadcrumbs__inner">
                <ul class="breadcrumbs__list">
                  <li class="breadcrumbs__item">
                    <a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
                  </li>
                  <li class="breadcrumbs__item">
                    <a href="{{route('customer.address', ['store_url'=>$store->store_url])}}" class="breadcrumbs__link">{{__('Address')}}</a>
                  </li>
                  <li class="breadcrumbs__item">
                    <a href="javascript:void;" class="breadcrumbs__link">{{__('Add address')}}</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- BREADCRUMBS : end -->
          </div>
        </div>
      </div>
    </div>
    <!-- PAGE HEADER : end -->

    <!-- CORE COLUMNS : begin -->
    <div class="core__columns">
      <div class="core__columns-inner">
        <div class="lsvr-container">

          <!-- COLUMNS GRID : begin -->
          <div class="core__columns-grid lsvr-grid">
            <!-- MAIN COLUMN : begin -->
            <div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">

              <!-- MAIN : begin -->
              <main id="main">
                <div class="main__inner">
                  <div class="page contact-page">
                    <div class="page__content">
                      <!-- FORM : begin -->
                      <div class="form-default form-top">
                        <form action="{{route('customer.address.save', ['store_url'=>$store->store_url])}}" method="post">
                          @csrf
                          <div class="form-group">
                            <label>{{__('LINE 1')}}*</label>
                            <input type="text" name="line_1" class="form-control" placeholder="{{__('Enter Address')}}" required>
                          </div>
                          <div class="form-group">
                            <label>{{__('LINE 2')}}</label>
                            <input type="text" name="line_2" class="form-control" placeholder="{{__('Enter Second Address (optional)')}}">
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="loginInputLast">{{__('ZIP/POSTAL CODE')}} *</label>
                                <input type="text" name="postal_code" maxlength="6" class="form-control" id="loginInputLast" placeholder="{{__('Enter Postal code')}}" required>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>{{__('STATE/COUNTY')}} *</label>
                            <select class="form-control" id="state" name="state" required>
                              <option value="">{{__('Select your state/county')}}</option>
                              @foreach($shipping as $val)
                              <option value="{{$val->state}}*{{$val->id}}*{{$val->shippingState->iso2}}">{{$val->shippingState->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group" id="showState" style="display:none;">
                            <label>{{__('CITY')}} *</label>
                            <select class="form-control" id="city" name="city">
                            </select>
                          </div>
                          <input type="hidden" name="store_id" value="{{$store->id}}">
                          <div class="row">
                            <div class="col-auto mr-auto">
                              <div class="form-group">
                                <button class="lsvr-button lsvr-form__submit" type="submit">{{__('ADD')}}</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <!-- FORM : end -->

                  </div>
                </div>
            </div>
            </main>
            <!-- MAIN : end -->

          </div>
          <!-- MAIN COLUMN : end -->
        </div>
        <!-- COLUMNS GRID : end -->
      </div>
    </div>
  </div>
  <!-- CORE COLUMNS : end -->
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
</script>
@endsection