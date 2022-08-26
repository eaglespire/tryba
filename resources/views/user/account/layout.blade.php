<!doctype html>
<html class="no-js" lang="en">

<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
  <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/quill/dist/quill.core.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/css/argon.css?v=1.1.0')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  @yield('css')
<style>
    span {
        font-size: 18px !important;
    }
</style>
<body style="background-color: #fff !important">
  @yield('content')
  <hr class="bg-secondary mt-5">
  <footer class="text-center">
    <p>
        Tryba accounts are provided by Modulr FS Limited, authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN
        900573). Modulr Finance Limited is a registered agent of Modulr FS Limited. Registered address: Scale Space, 58 Wood Lane, London W12 7RZ with
        company number: 09897919. © 2022 Modulr FS Limited.

    </p>
  </footer>
</body>

</html>
