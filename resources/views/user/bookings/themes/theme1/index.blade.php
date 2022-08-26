<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ $data->description }}">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <meta name="robots" content="index, follow">
    <title>{{ $data->business_name }} | Tryba.io</title>
    <link rel="icon" href="{{ url('/').'/'. $data->logoUrl }}" >
    <meta name="revisit-after" content="4 days">
    <meta name="author" content="{{ $data->business_name }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <link href="{{url('/')}}/asset/fonts/fontawesome/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">   
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <style>
        body{
            font-family: 'Rubik', sans-serif;
        }
        .brand{
            background:{{ $data->appearance->themeColor }} !important;
        }
        .brand-text{
            color:{{ $data->appearance->themeColor }} !important;
        }
        
    </style> 
</head>
<body>
   @include('user.bookings.themes.theme1.components.header',$data)
   @include('user.bookings.themes.theme1.components.booking',$data)
   @include('user.bookings.themes.theme1.components.service',$data)
   @include('user.bookings.themes.theme1.components.contact',$data)
   @include('user.bookings.themes.theme1.components.footer',$data)
    <script>

        let homeBtn = document.querySelector('#homeBtn');
        let contactBtn = document.querySelector('#contactBtn');
        let footerHomeBtn = document.querySelector('#footerHomeBtn ');

        
        const startScrolling = (elem) => {
            let position = document.querySelector('#'+elem).getBoundingClientRect().top;
            scrollTo(document.body, { top:position , easing: 'ease-in-out' ,'duration' :1000 })
        }

        homeBtn.addEventListener("click",()=>{
            startScrolling('home')
        })
        contactBtn.addEventListener("click",()=>{
            startScrolling('contact')
        })
        footerHomeBtn.addEventListener("click",()=>{
            startScrolling('home')
        })

    </script>
</body>
</html>