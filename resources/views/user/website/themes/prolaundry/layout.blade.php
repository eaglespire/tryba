<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $title }} - {{ $website->websiteName }}</title>
<meta name="keywords" content="{{ $website->meta_keywords }}">
<meta name="description" content="{{ $website->meta_description }}">
<meta name="author" content="{{ $website->websiteName }}">
<link rel="shortcut icon" href="images/favicon.ico">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
@if(empty($website->logo_url))
  <link rel="icon" href="{{asset('asset/'.$logo->image_link2)}}" />
@else
  <link rel="icon" href="{{ $website->logo_url }}" />
@endif
<link rel="stylesheet" href="{{  asset('asset/themes/website/prolaundry/css/style.css') }}">
<link rel="stylesheet" href="{{  asset('asset/themes/website/prolaundry/css/custom.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
    :root {
      --primary-color: rgb(0, 43, 136);
      --secondary-color: ;
      --header-color: ;
      /* etc. */
    }
</style>
<body>
    @include('user.website.themes.prolaundry.components.header')

      @yield('content')

    @include('user.website.themes.prolaundry.components.footer')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{  asset('asset/themes/website/prolaundry/js/bundle.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
@yield('script')
</body>
</html>