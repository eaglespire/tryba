<!doctype html>
<html class="no-js" lang="en">

<head>
  <base href="{{url('/')}}" />
  <title>{{ $title }} | {{$set->site_name}}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
  <meta name="robots" content="index, follow">
  <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
  <meta name="application-name" content="{{$set->site_name}}" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="description" content="{{$set->site_desc}}" />
  <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
  <link rel="stylesheet" href="{{asset('asset/front/css/libs.bundle.css')}}" />
  <link rel="stylesheet" href="{{asset('asset/front/css/theme.bundle.css')}}" />
  <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
  @yield('css')

</head>
<!-- header begin-->

<body class="">
  <section>
    <div class="container d-flex flex-column">
      <div class="row align-items-center justify-content-center gx-0 min-vh-100">
        @yield('content')
        <div class="col-lg-5 offset-lg-1 align-self-stretch d-none d-lg-block">
          <div class="h-100 w-cover bg-cover" style="background-image: url({{asset('asset/images/sit.jpg')}})"></div>
          <div class="shape shape-start shape-fluid-y text-white">
            <svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor"></path>
            </svg>
          </div>
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->
  </section>
  <div class="bg-black">
    <div class="container border-top border-gray-900-50"></div>
  </div>
  {{--    --}}
  <script src="{{asset('asset/front/js/vendor.bundle.js')}}"></script>
  <script src="{{asset('asset/front/js/theme.bundle.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/custom.js')}}"></script>
  @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>

</html>
@yield('script')
<script>
  $('.dummy-dd').on('click', function(e) {
    //$(this).off("click").attr('disabled','disabled');
    add.off();
  });
  "use strict";
  $('#btnlogin').on('click', function() {
    $(this).val('Please wait ...').attr('disabled', 'disabled');
    $('#payment-form').submit();
  });
</script>
@if($set->recaptcha==1)
{!! NoCaptcha::renderJs() !!}
@endif
