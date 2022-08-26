<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - {{$set->site_name}}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="{{asset('asset/images/favicon-png-64.png')}}" />
    <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
    <meta name="application-name" content="{{$set->site_name}}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="description" content="{{$set->site_desc}}" />
    <title>Compliance | Tryba.io</title>
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-inter" >
    <div class="min-h-screen flex justify-center lg:w-full items-center lg:p-8">
        <div class="lg:w-7/12 lg:p-6 p-4 lg:shadow-lg rounded-md">
            <div class="bg-brand flex justify-between items-center p-4 rounded-xl">
                <div>
                    <img src="{{ asset('asset/new_homepage/logo-white.svg') }}" alt="">
                </div>
                <div>
                    <img src="{{ asset('asset/email-asset/icon-1.png') }}" class="h-36 w-auto" alt="">
                </div>
            </div>
                @yield('content')
        </div>

    </div>
</body>
</html>