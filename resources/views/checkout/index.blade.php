<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{{url('/')}}" />
    <title>{{ $title }} - {{$set->site_name}}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
    <meta name="application-name" content="{{$set->site_name}}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta property="og:title" content="{{ $title }} - {{$set->site_name}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('asset/new_homepage/images/og-image.png') }}"/>
    <meta property="og:image:width" content="382" />
    <meta property="og:image:height" content="385" />
    <meta name="description" content="{{$set->site_desc}}" />
    <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
    <link rel="stylesheet" href="{{ asset('asset/new_homepage/fonts/css/cabinet-grotesk.css') }}">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <script>
        window.token = @json(['token'=>csrf_token() ]);
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="app" class="animate__animated animate__fadeIn slower">
    </div>
    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
