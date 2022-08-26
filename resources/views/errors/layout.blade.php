<!doctype html>
<html class="no-js" lang="en">

<head>
    <base href="{{url('/')}}" />
    <title>{{$title}} - {{$set->site_name}}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
    <meta name="application-name" content="{{$set->site_name}}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="description" content="{{$set->site_desc}}" />
    <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
    <link rel="stylesheet" href="{{asset('asset/front/css/libs.bundle.css')}}" />
    <link rel="stylesheet" href="{{asset('asset/front/css/theme.bundle.css')}}" />
    <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
</head>

<body>
    @yield('content')

    <script src="{{asset('asset/front/js/vendor.bundle.js')}}"></script>
    <script src="{{asset('asset/front/js/theme.bundle.js')}}"></script>
    <script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
</body>

</html>
