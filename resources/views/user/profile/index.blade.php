@extends('userlayout')

@section('content')
<div id="make_div_white" style="background-color: #ffffff !important;">
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Settings')}}</h1>
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Settings')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-12 col-md-12">
                    <!-- menu items start -->
{{--                    fas fa-{{$icon}} fa-solid--}}
                    <div class="menu-container">
                        @include('user.profile.partials.link', ['routeName'=>'user.profile','linkName'=>'Profile', 'icon'=>'user-circle'])
                        @include('user.profile.partials.link', ['routeName'=>'user.preferences','linkName'=>'Preferences','icon'=>'user-circle'])
                        @include('user.profile.partials.link', ['routeName'=>'user.security','linkName'=>'Security','icon'=>'user-circle'])
                        @include('user.profile.partials.link', ['routeName'=>'user.social','linkName'=>'Social Accounts','icon'=>'user-circle'])
                        @include('user.profile.partials.link', ['routeName'=>'user.billing','linkName'=>'Billing','icon'=>'user-circle'])
                        @if($set->merchant==1)
                            @if($user->getCountrySupported()->merchant==1)
                                @include('user.profile.partials.link', ['routeName'=>'user.api','linkName'=>'API Keys & Webhooks','icon'=>'user-circle'])
                            @endif
                        @endif
                        @include('user.profile.partials.link', ['routeName'=>'user.bank','linkName'=>'Connections','icon'=>'user-circle'])
                        @include('user.profile.partials.link', ['routeName'=>'openbanking.permissions','linkName'=>'Permissions','icon'=>'user-circle'])
                    </div>
                    <!-- menu items end -->
                </div>
                <div class="col-lg-7 col-sm-12 col-md-12">
                    @yield('mainpage')
                </div>
            </div>
            <!-- menu items start-->
{{--            <div class="d-flex overflow-auto mb-10">--}}
{{--                <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('user.profile')==url()->current()) active @endif" href="{{route('user.profile')}}">{{__('Profile')}}</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('user.preferences')==url()->current()) active @endif" href="{{route('user.preferences')}}">{{__('Preferences')}}</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('user.security')==url()->current()) active @endif" href="{{route('user.security')}}">{{__('Security')}}</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('user.social')==url()->current()) active @endif" href="{{route('user.social')}}">{{__('Social Accounts')}}</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('user.billing')==url()->current()) active @endif ml-0" href="{{route('user.billing')}}">{{__('Billings')}}</a>--}}
{{--                    </li>--}}
{{--                    @if($set->merchant==1)--}}
{{--                        @if($user->getCountrySupported()->merchant==1)--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link text-active-primary px-3 @if(route('user.api')==url()->current()) active @endif" href="{{route('user.api')}}">{{__('API Keys & Webhooks')}}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('user.bank')==url()->current()) active @endif" href="{{route('user.bank')}}">{{__('Connections')}}</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link text-active-primary px-3 @if(route('openbanking.permissions')==url()->current()) active @endif" href="{{route('openbanking.permissions')}}">{{__('Permissions')}}</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
            <!-- menu items end-->
{{--            <div class="">--}}
{{--                <div class="tab-content" id="myTabContent">--}}
{{--                    @yield('mainpage')--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
@endsection


@section('script')
@if($user->getCountrySupported()->paypal==1)
<script id="paypal-js" src="https://www.sandbox.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js"></script>
<script>
  let Paypal = document.querySelector("#payPalBtn");
  const toogleCredentials = () => {
    let credentialsForms = document.querySelector("#payPalCredentials")
    credentialsForms.classList.toggle("d-none")
  }
  Paypal.addEventListener("click", toogleCredentials);
</script>
@endif
@if(!empty($seller))
<script>
  function onboardedCallback(authCode, sharedId) {
    fetch("{{ route('payPalSave') }}", {
      method: 'POST',
      headers: {
        'content-type': 'application/json'
      },
      body: JSON.stringify({
        authCode: authCode,
        sharedId: sharedId,
        _token: "{{ csrf_token() }}",
        seller: "{{ $seller }}"
      })
    }).then(function(res) {
      if (!response.ok) {
        alert("Something went wrong!");
      }
    });
  }
</script>
@endif
@endsection

@section('css')
    .menu_container_span{
        vertical-align: top;
    }
    .menu_container_span_color{
        color: #F2FBFE;
    }
    .menu_icon_color{
    color: #6A6E6F;
    }
    .menu_container_active{
        cursor: default !important;
    }
    .menu_container_active:hover{
    cursor: default !important;
    }
    .menu_container_not_active{
    cursor: pointer !important;
    }
    .menu_container_not_active:hover{
    cursor: pointer !important;
    }
@endsection
