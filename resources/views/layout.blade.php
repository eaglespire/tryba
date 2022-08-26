<!doctype html>
<html class="no-js" lang="en">

<head>
  <base href="{{url('/')}}" />
  <title>{{ $title }} - {{$set->site_name}}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="index, follow">
  <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
  <meta name="application-name" content="{{$set->site_name}}" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="description" content="{{$set->site_desc}}" />

  <!-- Start SmartBanner configuration -->
  <meta name="smartbanner:title" content="Smart Application">
  <meta name="smartbanner:author" content="SmartBanner Contributors">
  <meta name="smartbanner:price" content="FREE">
  <!--meta name="smartbanner:price-suffix-apple" content=" - On the App Store"-->
  <meta name="smartbanner:price-suffix-google" content=" - In Google Play">
  <meta name="smartbanner:icon-apple" content="https://url/to/apple-store-icon.png">
  <meta name="smartbanner:icon-google" content="https://url/to/google-play-icon.png">
  <meta name="smartbanner:button" content="VIEW">
  <!--meta name="smartbanner:button-url-apple" content="https://ios/application-url"-->
  <meta name="smartbanner:button-url-google" content="https://play.google.com/store/apps/details?id=com.tryba.io">
  <meta name="smartbanner:enabled-platforms" content="android">
  <meta name="smartbanner:close-label" content="Close">
  <!-- End SmartBanner configuration -->

  <link rel="stylesheet" href="node_modules/smartbanner.js/dist/smartbanner.min.css">
  <script src="https://consent.cookiefirst.com/sites/tryba.io-90197027-c37b-44c4-9f68-ade8cfb2926c/consent.js"></script>
  <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
  <link rel="stylesheet" href="{{asset('asset/front/css/libs.bundle.css')}}" />
  <link rel="stylesheet" href="{{asset('asset/front/css/theme.bundle.css')}}" />
  <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
  <!-- TrustBox script -->
  <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
  <script src="node_modules/smartbanner.js/dist/smartbanner.min.js"></script>
  @if(route('contact')==url()->current())
  {!! htmlScriptTagJsApi() !!}
  @endif
  <!-- End TrustBox script -->
  @yield('css')
  <link rel="icon" href="{{asset('asset/images/favicon-png-64.png')}}" />
</head>

<body>
  <nav class="navbar navbar-expand-lg @if(route('home')==url()->current() || route('blog')==url()->current() || route('pricing')==url()->current() || route('contact')==url()->current() || route('faq')==url()->current()) navbar-dark @else fixed-top navbar-light bg-white border-bottom @endif">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{url('/')}}">
        <img src="{{asset('asset/'.$logo->image_link)}}" class="navbar-brand-img" alt="Tryba">
      </a>
      {{--
      <div class="btn-group dropdown d-block d-sm-none">
        @php $locale = session()->get('locale'); @endphp
        <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" id="dropdownMenuExtraSmall" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fal fa-globe"></i>
          @switch($locale)
          @case('dk')
          DK
          @break
          @case('de')
          DE
          @break
          @case('es')
          ES
          @break
          @case('fr')
          FR
          @break
          @case('lv')
          LV
          @break
          @case('lt')
          LT
          @break
          @case('ee')
          EE
          @break
          @case('hu')
          HU
          @break
          @case('nl')
          NL
          @break
          @case('pl')
          PL
          @break
          @case('ro')
          RO
          @break
          @case('fi')
          FI
          @break
          @case('se')
          SE
          @break
          @case('sl')
          SL
          @break
          @default
          EN
          @endswitch
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuExtraSmall" style="">
          <a class="dropdown-item" href="{{route('lang',['locale'=>'dk'])}}">Danish</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'de'])}}">German</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'en'])}}">English</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'es'])}}">Spanish</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'fr'])}}">French</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'lv'])}}">Latvia</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'lt'])}}">Lithuania</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'ee'])}}">Estonia</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'hu'])}}">Hungarian</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'nl'])}}">Dutch</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'pl'])}}">Polish</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'ro'])}}">Romanian</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'fi'])}}">Finnish</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'se'])}}">Swedish</a>
          <a class="dropdown-item" href="{{route('lang',['locale'=>'sl'])}}">Slovenia</a>
        </div>
      </div>
      --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fe fe-x"></i>
        </button>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link" id="navbarPages" href="{{route('home')}}" aria-haspopup="true" aria-expanded="false">
              {{__('Home')}}
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" id="navbarPages" href="{{route('pricing')}}" aria-haspopup="true" aria-expanded="false">
              {{__('Pricing')}}
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarPages" data-bs-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
              {{__('Legal')}}
            </a>
            <div class="dropdown-menu " aria-labelledby="navbarPages">
              <div class="row gx-0">
                <div class="col-6">
                  <div class="row gx-0">
                    <div class="col-6">
                      <div class="row gx-0">
                        <div class="col-12 col-lg-6">
                          <h6 class="dropdown-header">{{__('Documents')}}</h6>
                          <a class="dropdown-item  mb-lg-0" href="{{route('terms')}}">{{__('Terms & Conditions')}}</a>
                          <a class="dropdown-item  mb-lg-0" href="{{route('privacy')}}">{{__('Privacy policy')}}</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDocumentation" data-bs-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
              Help Center
            </a>
            <div class="dropdown-menu dropdown-menu-md" aria-labelledby="navbarDocumentation">
              <div class="list-group list-group-flush">
                <a class="list-group-item" href="{{route('faq')}}">
                  <div class="icon icon-sm text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <g fill="none" fill-rule="evenodd">
                        <path d="M0 0h24v24H0z" />
                        <path d="M8 3v.5A1.5 1.5 0 009.5 5h5A1.5 1.5 0 0016 3.5V3h2a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2h2z" fill="#335EEA" opacity=".3" />
                        <path d="M11 2a1 1 0 012 0h1.5a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-5a.5.5 0 01-.5-.5v-1a.5.5 0 01.5-.5H11z" fill="#335EEA" />
                        <rect fill="#335EEA" opacity=".3" x="7" y="10" width="5" height="2" rx="1" />
                        <rect fill="#335EEA" opacity=".3" x="7" y="14" width="9" height="2" rx="1" />
                      </g>
                    </svg>
                  </div>
                  <div class="ms-4">
                    <h6 class="fw-bold text-uppercase text-primary mb-0">
                      {{__('Frequently asked questions')}}
                    </h6>
                    <p class="fs-sm text-gray-700 mb-0">
                      {{__('Learn more about tryba.io')}}
                    </p>
                  </div>
                </a>
                <a class="list-group-item" href="{{route('blog')}}">
                  <div class="icon icon-sm text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <g fill="none" fill-rule="evenodd">
                        <path d="M0 0h24v24H0z" />
                        <rect fill="#335EEA" x="4" y="4" width="7" height="7" rx="1.5" />
                        <path d="M5.5 13h4a1.5 1.5 0 011.5 1.5v4A1.5 1.5 0 019.5 20h-4A1.5 1.5 0 014 18.5v-4A1.5 1.5 0 015.5 13zm9-9h4A1.5 1.5 0 0120 5.5v4a1.5 1.5 0 01-1.5 1.5h-4A1.5 1.5 0 0113 9.5v-4A1.5 1.5 0 0114.5 4zm0 9h4a1.5 1.5 0 011.5 1.5v4a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-4a1.5 1.5 0 011.5-1.5z" fill="#335EEA" opacity=".3" />
                      </g>
                    </svg>
                  </div>
                  <div class="ms-4">
                    <h6 class="fw-bold text-uppercase text-primary mb-0">
                      {{__('News and Articles')}}
                    </h6>
                    <p class="fs-sm text-gray-700 mb-0">
                      {{__('Get the latest news about tryba.io')}}
                    </p>
                  </div>
                  <a class="list-group-item" href="{{route('contact')}}">
                    <div class="icon icon-sm text-primary">
                      <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd">
                          <path d="M0 0h24v24H0z" />
                          <rect fill="#335EEA" x="4" y="4" width="7" height="7" rx="1.5" />
                          <path d="M5.5 13h4a1.5 1.5 0 011.5 1.5v4A1.5 1.5 0 019.5 20h-4A1.5 1.5 0 014 18.5v-4A1.5 1.5 0 015.5 13zm9-9h4A1.5 1.5 0 0120 5.5v4a1.5 1.5 0 01-1.5 1.5h-4A1.5 1.5 0 0113 9.5v-4A1.5 1.5 0 0114.5 4zm0 9h4a1.5 1.5 0 011.5 1.5v4a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-4a1.5 1.5 0 011.5-1.5z" fill="#335EEA" opacity=".3" />
                        </g>
                      </svg>
                    </div>
                    <div class="ms-4">
                      <h6 class="fw-bold text-uppercase text-primary mb-0">{{__('Contact us')}}</h6>
                      <p class="fs-sm text-gray-700 mb-0">{{__('Get in touch')}}</p>
                    </div>
                  </a>
                </a>
                <a class="list-group-item" href="https://tryba.statuspage.io" target="_blank">
                  <div class="icon icon-sm text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <g fill="none" fill-rule="evenodd">
                        <path d="M0 0h24v24H0z" />
                        <path d="M5.857 2h7.88a1.5 1.5 0 01.968.355l4.764 4.029A1.5 1.5 0 0120 7.529v12.554c0 1.79-.02 1.917-1.857 1.917H5.857C4.02 22 4 21.874 4 20.083V3.917C4 2.127 4.02 2 5.857 2z" fill="#335EEA" opacity=".3" />
                        <rect fill="#335EEA" x="6" y="11" width="9" height="2" rx="1" />
                        <rect fill="#335EEA" x="6" y="15" width="5" height="2" rx="1" />
                      </g>
                    </svg>
                  </div>
                  <div class="ms-4">
                    <h6 class="fw-bold text-uppercase text-primary mb-0">
                      {{__('System status')}}
                    </h6>
                    <p class="fs-sm text-gray-700 mb-0">
                      {{__('All systems update')}}
                    </p>
                  </div>
                  <span class="badge rounded-pill bg-primary-soft ms-auto">
                    {{__('LIVE')}}
                  </span>
                </a>

              </div>
            </div>
          </li>
        </ul>
        {{--
        <div class="btn-group dropdown d-none d-sm-block">
          @php $locale = session()->get('locale'); @endphp
          <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" id="dropdownMenuExtraSmall" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fal fa-globe"></i>
            @switch($locale)
            @case('dk')
            DK
            @break
            @case('de')
            DE
            @break
            @case('es')
            ES
            @break
            @case('fr')
            FR
            @break
            @case('lv')
            LV
            @break
            @case('lt')
            LT
            @break
            @case('ee')
            EE
            @break
            @case('hu')
            HU
            @break
            @case('nl')
            NL
            @break
            @case('pl')
            PL
            @break
            @case('ro')
            RO
            @break
            @case('fi')
            FI
            @break
            @case('se')
            SE
            @break
            @case('sl')
            SL
            @break
            @default
            EN
            @endswitch
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuExtraSmall" style="">
            <a class="dropdown-item" href="{{route('lang',['locale'=>'dk'])}}">Danish</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'de'])}}">German</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'en'])}}">English</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'es'])}}">Spanish</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'fr'])}}">French</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'lv'])}}">Latvia</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'lt'])}}">Lithuania</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'ee'])}}">Estonia</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'hu'])}}">Hungarian</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'nl'])}}">Dutch</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'pl'])}}">Polish</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'ro'])}}">Romanian</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'fi'])}}">Finnish</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'se'])}}">Swedish</a>
            <a class="dropdown-item" href="{{route('lang',['locale'=>'sl'])}}">Slovenia</a>
          </div>
        </div>
        --}}
        @if (Auth::guard('user')->check())
        <a class="navbar-btn btn btn-sm btn-primary lift ms-auto" href="{{route('user.dashboard')}}">{{__('Dashboard')}}</a>
        @else
        @if(route('login')!=url()->current())
        <a class="navbar-btn btn btn-sm btn-primary lift ms-auto" href="{{route('login')}}">{{__('Sign In')}}</a>
        @endif
        @endif
      </div>
    </div>
  </nav>
  @yield('content')
  <div class="bg-black">
    <div class="container border-top border-gray-900-50"></div>
  </div>
  <!--
    <section class="pt-6 pt-md-8 bg-black">
      <div class="container pb-6 pb-md-8">
        <div class="row align-items-center">
          <div class="col-12 col-md">


            <h3 class="fw-bold mb-1 text-white">
              Tryba android app is Live
            </h3>


            <p class="text-muted mb-6 mb-md-0 text-white">
              Android version is ready for download, iOS is coming soon.
            </p>

          </div>

          <div class="col-auto">

            <a href="javascript:void;" class="text-reset d-inline-block me-1" title="Coming soon">
              <img src="{{url('/')}}/asset/images/button-app.png" class="img-fluid" alt="..." style="max-width: 155px;">
            </a>

            <a href="https://play.google.com/store/apps/details?id=com.tryba.io" target="_blank" class="text-reset d-inline-block" title="Android">
              <img src="{{url('/')}}/asset/images/button-play.png" class="img-fluid" alt="..." style="max-width: 155px;">
            </a>

          </div>
        </div>
      </div>
    </section>
    .-->
  <footer class="py-8 py-md-11 bg-black">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12 col-md-4 col-lg-3">
          <img src="{{asset('asset/'.$logo->dark)}}" alt="..." class="navbar-brand-img img-fluid mb-2">
          <p class="text-gray-700 mb-2">The smart way to do business</p>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <h6 class="fw-bold text-uppercase text-gray-700">
            {{__('Legal')}}
          </h6>
          <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
            <li class="mb-3">
              <a href="{{route('pricing')}}" class="text-reset">{{__('Pricing')}}</a>
            </li>
            <li class="mb-3">
              <a href="{{route('terms')}}" class="text-reset">{{__('Terms')}}</a>
            </li>
            <li>
              <a href="{{route('privacy')}}" class="text-reset">{{__('Privacy')}}</a>
            </li>
          </ul>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <h6 class="fw-bold text-uppercase text-gray-700">{{__('Resources')}}</h6>
          <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
            <li class="mb-3">
              <a href="{{route('faq')}}" class="text-reset">{{__('FAQs')}}</a>
            </li>
            <li class="mb-3">
              <a target="_blank" href="https://helpdesk.tryba.io" class="text-reset">{{__('Help Center')}}</a>
            </li>
            <li class="mb-3">
              <a href="{{route('contact')}}" class="text-reset">{{__('Contact us')}}</a>
            </li>
          </ul>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <h6 class="fw-bold text-uppercase text-gray-700">{{__('Integrations')}}</h6>
          <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
            <li class="mb-3">
              <a href="{{route('user.merchant-plugin')}}" class="text-reset">{{__('Plugins')}}</a>
            </li>
            <li class="mb-3">
              <a href="{{route('user.merchant-api')}}" class="text-reset">{{__('Developers')}}</a>
            </li>
            <li class="mb-3">
              <a target="_blank" href="https://tryba.statuspage.io" class="text-reset">{{__('System Status')}}</a>
            </li>
          </ul>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
          <h6 class="fw-bold text-uppercase text-gray-700">{{__('Social')}}</h6>
          <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
            @foreach($social as $socials)
            @if(!empty($socials->value))
            <li class="mb-3">
              <a href="{{$socials->value}}" class="text-reset">{{ucwords($socials->type)}}</a>
            </li>
            @endif
            @endforeach
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="text-muted small mb-2">
                 <p class="">
                    Tryba U.K Limited designs and operates Tryba websites and app, which offers business current accounts and Cards with innovative built-in website and business management tools as a service. Tryba U.K Limited is a financial technology company registered in England and Wales with company number 13509269 and business mailing address at 126 Colmore Row, Birmingham, B3 3AP, United Kingdom.
                 </p>
                 <p class="my-3" >
                  Tryba business current accounts and Visa cards are electronic money products issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency. Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573).
                 </p>
                 <p class="my-3" >
                  Tryba U.K Limited also act as agent of SafeConnect Ltd for the provision of Open Banking and PISP technology. SafeConnect Ltd is authorised and regulated by the Financial Conduct Authority under the Payment Service Regulations 2017 (827001) for the provision of Account Information and Payment Initiation services.
                 </p>
                 <p>
                     <a href="#">View Tryba on the FCA register (coming soon)</a>
                 </p>
          <br>
          <p class="text-center">
            Tryba © {{date('Y')}}. {{__('All Rights Reserved.')}}<br>ICO certificate: ZB319956
          </p>
          </div>
        </div>
      </div>
  </footer>

  <script src="{{asset('asset/front/js/vendor.bundle.js')}}"></script>
  <script src="{{asset('asset/front/js/theme.bundle.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/custom.js')}}"></script>
  <script>
    {!! getLiveCode() !!}
</script>
  @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
  @yield('script')
  @if(route('pricing')==url()->current())
  <script>
    "use strict";
    function pricing() {
      const obj = $("#list").val();
      var list = JSON.parse(obj);
      list.forEach(myFunction);

      function myFunction(value, index, array) {
        $('#dcountry' + value).hide();
      }
      var country = $("#xcountry").find(":selected").val();
      var myarr = country.split("*");
      var ans = myarr[0].split("<");
      $('#dcountry' + ans).show();
    }
    const obj = $("#list").val();
    var list = JSON.parse(obj);
    list.forEach(myFunction);
    function myFunction(value, index, array) {
      $('#dcountry' + value).hide();
    }
    var country = $("#xcountry").find(":selected").val();
    var myarr = country.split("*");
    var ans = myarr[0].split("<");
    $('#dcountry' + ans).show();
    $("#xcountry").change(pricing);
  </script>
  @endif
</body>

</html>
