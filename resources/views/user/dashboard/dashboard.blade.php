@extends('userlayout')

@section('css')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" href="{{asset('asset/dashboard/css/index.css')}}" type="text/css">
@endsection
@section('content')
@include('user.dashboard.account-form')
<div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap" id="userTarget" data-uid="{{$user->id}}">
    <!--begin::Info-->
    <div class="d-flex px-2 flex-column align-items-start justify-content-center flex-wrap me-2">
        <!--begin::Title-->
        <h4 class="text-dark fw-bolder my-1">{{ __('Overview') }}</h4>
    </div>
    <!--end::Info-->
</div>
<div class="container-fluid my-4">
    <div class="col-xxl-12">
        <div class="row gap-6 gap-sm-0">
            <div class="col-xl-4">
                <div class="bg-brand-opacity-4 p-4 rounded position-relative">
                    <div class="d-flex align-items-center justify-content-between mb-12">
                        <div id="switchAccount" class="d-flex cursor-pointer">
                            <div class="text-brand font-semibold">Switch Account</div>
                            <div class="mx-3">
                                <div class="d-flex align-items-center justify-content-center small-circle rounded-circle">
                                    <a href="javascript:void(0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-4  text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" id="viewBalance">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="d-none" id="hideBalance">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div id="account-gpb" class="d-flex align-items-center justify-content-between my-8">
                        <div class="">
                            <div class="font-semibold">Account Balance</div>
                            <div class="font-bold fs-1">{{ getUserCurrency($user) }} <span id="account_balance" data-balance="balance" class="">{{ number_format($user->gBPAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance" data-hidden="balance" class="d-none">*****</span></div>
                            <div class="font-semibold">{{ (getUserCurrencyName($user) == 'GBP') ? "British Pound" : getUserCurrencyName($user) }} ({{ getUserCurrencyName($user) }})</div>
                        </div>
                        <div>
                            <div class="flag-circle flag-uk"></div>
                        </div>
                    </div>
                    <div id="account-euro" class="d-flex align-items-center justify-content-between my-8 d-none">
                        <div class="">
                            <div class="font-semibold">Account Balance</div>
                            <div class="font-bold fs-1">€ <span id="account_balance" data-balance="balance" class="">{{ number_format($user->euroAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance"  data-hidden="balance" class="d-none">*****</span></div>
                            <div class="font-semibold">{{ __('Euro') }} ({{ __("EUR") }})</div>
                        </div>
                        <div>
                            <div class="flag-circle flag-europe"></div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <a href="javascript:void(0)" id="account-btn" data-bs-toggle="modal" data-bs-target="#accountInformation" class="btn btn-block btn-primary">{{__("Account Information") }}</a>
                    </div>
                    <div id="switchContent" class="position-absolute account-dropdown d-none animate__animated animate__fadeIn animate__faster p-4">
                        <div class="rounded bg-white p-2 ">
                            <div onclick="changeAccount('gbp')"  class="d-flex align-items-center cursor-pointer justify-content-between bg-light px-2 py-4 rounded mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flag-circle-sm flag-uk"></div>
                                    <div>
                                        <div class="font-bold text-sm">{{ (getUserCurrencyName($user) == 'GBP') ? "British Pound" : getUserCurrencyName($user) }}</div>
                                        <div class="font-semibold text-gray-500 text-sm">{{ getUserCurrencyName($user) }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-sm">{{ getUserCurrency($user) }} {{ number_format($user->gBPAccount()->balance ?? 0, 2) }}</div>
                                </div>
                            </div>
                            @if(!empty($user->euroAccount()))
                                <div onclick="changeAccount('euro')" class="d-flex align-items-center cursor-pointer justify-content-between bg-light px-2 py-4 rounded">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flag-circle-sm flag-europe"></div>
                                        <div>
                                            <div class="font-bold text-sm">EURO</div>
                                            <div class="font-semibold text-gray-500 text-sm">EUR</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm">€ {{ number_format($user->euroAccount()->balance ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div id="cards" class="bg-brand-yellow yellow-height overflow-hidden  p-4 rounded position-relative">
                    @if($user->virtualCard() != null || $user->physicalCard() != null  )
                    <div class="text-center fs-4 font-bold">
                        Cards
                    </div>
                    <div id="card-overlay" class="card-overlay position-absolute d-none d-flex justify-content-center align-items-end animate__animated animate__fadeIn animate__faster">
                        <div class="text-center mb-4 ">
                            <a href="javascript:void(0)" class="btn text-light btn-sm outline-white">Manage Card</a>
                        </div>
                    </div>
                    <div class="px-3 px-lg-3">
                        <div class="bg-black-card rounded-1rem p-0.5 shadow mt-10">
                            <div class="card-background">
                                <div class="p-1">
                                    <img src="{{ asset('asset/new_homepage/logo-white.svg') }}" height="20px" width="80px"alt="">
                                </div>
                                <div class="px-2 mt-3 mx-6 gap-2 d-flex align-items-center">
                                    <div class="">
                                        <img src="{{ asset('asset/new_dashboard/media/svg/gold.svg') }}" height="25" width="25" alt="">
                                    </div>
                                    <div class="">
                                        <img src="{{ asset('asset/new_dashboard/media/svg/wave2.svg') }}" height="14" width="14" alt="">
                                    </div>
                                </div>
                                <div class="p-2 mx-6 my-2 text-light card-numbers font-bold fs-6">
                                    <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[0] : '****' }}</div>
                                    <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[1] : '****' }}</div>
                                    <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[2] : '****' }}</div>
                                    <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[3] : '****' }}</div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    <div class="card-vaild-thru text-light">VAILD<br>THRU</div>
                                    <div class="text-center card-expire-date text-light font-bold fs-5">
                                        01/23
                                    </div>
                                </div>
                                <div class="p-2 mx-6 my-2 d-flex align-items-center justify-content-between mb-0">
                                    <div class="card-name text-light text-uppercase">{{ $user->first_name.' '.$user->last_name }}</div>
                                    <div class="text-center text-light font-bold fs-5">
                                        <img src="{{ asset('asset/new_dashboard/media/svg/visa.svg') }}" height="30" width="30" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-postion position-absolute px-3">
                            <div class="bg-brand rounded-1rem p-0.5 shadow mt-4 ">
                                <div class="card-background">
                                    <div class="p-1">
                                        <img src="{{ asset('asset/new_homepage/logo-white.svg') }}" height="20px" width="80px" alt="">
                                    </div>
                                    <div class="px-2 mt-3 mx-4 gap-2 d-flex align-items-center">
                                        <div class="">
                                            <img src="{{ asset('asset/new_dashboard/media/svg/gold.svg') }}" height="30" width="30" alt="">
                                        </div>
                                        <div class="">
                                            <img src="{{ asset('asset/new_dashboard/media/svg/wave2.svg') }}" height="14" width="14" alt="">
                                        </div>
                                    </div>
                                    <div class="p-2 mx-4 my-2 d-flex justify-content-between text-light card-numbers font-bold fs-6">
                                        <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[0] : '****' }}</div>
                                        <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[1] : '****' }}</div>
                                        <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[2] : '****' }}</div>
                                        <div>{{ ($user->virtualCard()->pan) ? str_split($user->virtualCard()->pan,4)[3] : '****' }}</div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center align-items-center">
                                        <div class="card-vaild-thru text-light">VAILD<br>THRU</div>
                                        <div class="text-center card-expire-date text-light font-bold fs-5">
                                            01/23
                                        </div>
                                    </div>
                                    <div class="p-2 mx-6 my-2 d-flex align-items-center justify-content-between mb-0">
                                        <div class="card-name text-light text-uppercase">{{ $user->first_name.' '.$user->last_name }}</div>
                                        <div class="text-center text-light font-bold fs-5">
                                            <img src="{{ asset('asset/new_dashboard/media/svg/visa.svg') }}" height="30" width="30" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="d-flex justify-content-between">
                        <div class="fw-boldest fs-4">Cards</div>
                        <div>You have no card yet</div>
                    </div>
                    <div class="my-4 text-center">
                        <a href="javascript:void(0)" class="btn outline-primary btn-sm">{{__("Request for Card") }}</a>
                    </div>
                    <div class="bg-brand rounded-1rem p-0.5 shadow mt-4 position-absolute custom-postion-no-card">
                        <div class="card-background">
                            <div class="p-1">
                                <img src="{{ asset('asset/new_homepage/logo-white.svg') }}" height="18px" width="70" alt="">
                            </div>
                            <div class="px-2 mt-3 mx-6 gap-2 d-flex align-items-center">
                                <div class="">
                                    <img src="{{ asset('asset/new_dashboard/media/svg/gold.svg') }}" height="25" width="25" alt="">
                                </div>
                                <div class="">
                                    <img src="{{ asset('asset/new_dashboard/media/svg/wave2.svg') }}" height="14" width="14" alt="">
                                </div>
                            </div>
                            <div class="p-2 mx-6 my-2 d-flex justify-content-between text-light card-numbers font-bold fs-6">
                                <div>****</div>
                                <div>****</div>
                                <div>****</div>
                                <div>****</div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <div class="card-vaild-thru text-light">VAILD<br>THRU</div>
                                <div class="text-center card-expire-date text-light font-bold fs-5">
                                    **/**
                                </div>
                            </div>
                            <div class="p-2 mx-6 my-2 d-flex align-items-center justify-content-between mb-0">
                                <div class="card-name text-light text-uppercase">{{ $user->first_name.' '.$user->last_name }}</div>
                                <div class="text-center text-light font-bold fs-5">
                                    <img src="{{ asset('asset/new_dashboard/media/svg/visa.svg') }}" height="30" width="30" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-4">
                <div class="bg-white py-lg-4 px-lg-6 p-6 rounded">
                    <div class="text-center fs-5 fw-boldest">
                        Quick Links
                    </div>
                    <div class="row my-2">
                            <div class="col-4">
                                <div>
                                    <a href="javascript:void(0)" id="addMoneyBtn">
                                        <div class="d-flex  justify-content-center">
                                            <div class="circle bg-brand-opacity-4 d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('asset/new_dashboard/media/svg/wallet-add.svg') }}"  alt="">
                                            </div>
                                        </div>
                                        <div class="font-bold text-dark text-sm text-center my-2">Add Money</div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <a href="javascript:void(0)" id="sendMoneyBtn">
                                        <div class="d-flex  justify-content-center">
                                            <div class="circle bg-brand-red d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('asset/new_dashboard/media/svg/import.svg') }}"  alt="">
                                            </div>
                                        </div>
                                        <div class="font-bold text-sm text-dark text-center my-2">Transfer</div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <a href="{{ route('user.invoice') }}">
                                        <div class="d-flex  justify-content-center">
                                            <div class="circle bg-purplue d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('asset/new_dashboard/media/svg/receipt-edit.svg') }}"  alt="">
                                            </div>
                                        </div>
                                        <div class="font-bold text-dark text-sm text-center my-2">Invoice</div>
                                    </a>
                                </div>
                            </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4">
                            <a href="javascript:void(0)" class="opacity-50">
                                <div class="d-flex  justify-content-center">
                                    <div class="circle bg-yellow d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('asset/new_dashboard/media/svg/frame.svg') }}"  alt="">
                                    </div>
                                </div>
                                <div class="font-bold text-center text-dark text-sm my-2">Exchange</div>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0)" id="request-money-btn">
                                <div class="d-flex  justify-content-center">
                                    <div class="circle bg-green d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('asset/new_dashboard/media/svg/import-icon.svg') }}"  alt="">
                                    </div>
                                </div>
                                <div class="font-bold text-center text-dark text-sm my-2">Request</div>
                            </a>
                        </div>
                        <div class="col-4 opacity-50">
                            <a href="javascript:void(0)">
                                <div class="d-flex  justify-content-center">
                                    <div class="circle bg-orange d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('asset/new_dashboard/media/svg/money-time.svg') }}"  alt="">
                                    </div>
                                </div>
                                <div class="font-bold text-center text-dark text-sm my-2">Bookings</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid my-6">
    <div class="col-xxl-12">
        <div class="row gap-6 gap-sm-0">
            <div class="col-xl-4">
                <div class=" position-relative overflow-hidden">
                    <div id="service_1" class="bg-brand-opacity-4 px-4 pt-4 rounded position-relative transform service-transition animate__animated animate__fadeIn animate__faster">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="javascript:void(0)" onclick="changeSlide(1,3)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="font-sembold fs-4">
                                Gigpot
                            </div>
                            <div>
                                <a href="javascript:void(0)" onclick="changeSlide(1,2)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="my-2 text-base">
                            Send payment links to friends, co-workers, family for a specific event of gig
                        </div>
                        <div class="d-flex align-items-end justify-content-between pb-4 mt-16">
                            <div class="d-flex flex-shrink-0">
                                <a href="{{ route("user.sclinks") }}" class="btn btn-primary btn-sm">Create Gigpot</a>
                            </div>
                            <div class="">
                                <img src="{{ asset('asset/new_dashboard/media/img/gigpot.png') }}" class="position-absolute  service-image" alt="">
                            </div>
                        </div>
                    </div>
                    <div id="service_2" class="bg-image-purple-4 px-4 pt-4 rounded position-relative d-none transform service-transition animate__animated animate__fadeIn animate__faster">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="javascript:void(0)" onclick="changeSlide(2,1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="font-sembold fs-4">
                                Invoice
                            </div>
                            <div>
                                <a href="javascript:void(0)" onclick="changeSlide(2,3)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="my-2 text-base">
                            Create & issue customers invoice with reminders, social sharing, QR code.
                        </div>
                        <div class="d-flex align-items-end justify-content-between pb-4 mt-16">
                            <div class="d-flex flex-shrink-0">
                                <a href="{{ route("user.invoice") }}" class="btn btn-primary btn-sm">Create Invoice</a>
                            </div>
                            <div class="">
                                <img src="{{ asset('asset/new_dashboard/media/img/invoice.png') }}" class="position-absolute  service-image-2" alt="">
                            </div>
                        </div>
                    </div>
                    <div id="service_3" class="bg-image-green-4 px-4 pt-4 rounded position-relative d-none transform service-transition animate__animated animate__fadeIn animate__faster">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="javascript:void(0)" onclick="changeSlide(3,2)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="font-sembold fs-4">
                                Website
                            </div>
                            <div>
                                <a href="javascript:void(0)" onclick="changeSlide(3,1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="my-2 text-base">
                            Sell products & services on a single multipurpose and functional website.
                        </div>
                        <div class="d-flex align-items-end justify-content-between pb-4 mt-16">
                            <div class="d-flex flex-shrink-0">
                                <button class="btn btn-primary btn-sm opacity-50">Create Website</button>
                            </div>
                            <div class="">
                                <img src="{{ asset('asset/new_dashboard/media/img/website.png') }}" class="position-absolute  service-image-2" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class=" position-relative overflow-hidden">
                    <div id="trnx_1" class="bg-brand-yellow px-4 pt-4 rounded position-relative transform service-transition animate__animated animate__fadeIn animate__faster">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="font-sembold fs-4">
                                Statistics
                            </div>
                            <div class="d-flex gap-2">
                                <div>
                                    <a href="javascript:void(0)" onclick="changeTransactionSlide(1,3)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                        </svg>
                                    </a>
                                </div>

                                <div>
                                    <a href="javascript:void(0)" onclick="changeTransactionSlide(1,2)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="my-8 text-base">
                            <div class="font-semibold mb-2">Pending Transactions</div>
                            <div class="font-bold fs-1">{{ getUserCurrency($user) }}{{ number_format($user->pendingTransactions() ?? 0, 2) }}</div>
                        </div>
                        <div class="mt-10 mb-4 pb-4">
                            <a href="{{ route('user.transactions') }}" class="btn btn-block btn-primary btn-sm">View transaction</a>
                        </div>
                    </div>
                    <div id="trnx_2" class="bg-image-green-4 px-4 pt-4 rounded position-relative d-none transform service-transition animate__animated animate__fadeIn animate__faster">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="font-sembold fs-4">
                                Statistics
                            </div>
                            <div class="d-flex gap-2">
                                <div>
                                    <a href="javascript:void(0)" onclick="changeTransactionSlide(2,1)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                        </svg>
                                    </a>
                                </div>

                                <div>
                                    <a href="javascript:void(0)" onclick="changeTransactionSlide(2,3)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="my-8 text-base">
                            <div class="font-semibold mb-2">Successfully Transactions</div>
                            <div class="font-bold fs-1">{{ getUserCurrency($user) }}{{ number_format($user->successTransactions() ?? 0, 2) }}</div>
                        </div>
                        <div class="mt-10 mb-4 pb-4">
                            <a href="{{ route('user.transactions') }}" class="btn btn-block btn-primary btn-sm">View transaction</a>
                        </div>
                    </div>
                    <div id="trnx_3" class="bg-red-4 px-4 pt-4 rounded position-relative d-none transform service-transition animate__animated animate__fadeIn animate__faster">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="font-sembold fs-4">
                                Statistics
                            </div>
                            <div class="d-flex gap-2">
                                <div>
                                    <a href="javascript:void(0)" onclick="changeTransactionSlide(3,2)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                        </svg>
                                    </a>
                                </div>
                                <div>
                                    <a href="javascript:void(0)" onclick="changeTransactionSlide(3,1)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-height-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="my-8 text-base">
                            <div class="font-semibold mb-2">Failed Transactions</div>
                            <div class="font-bold fs-1">{{ getUserCurrency($user) }}{{ number_format($user->failedTransactions() ?? 0, 2) }}</div>
                        </div>
                        <div class="mt-10 mb-4 pb-4">
                            <a href="{{ route('user.transactions') }}" class="btn btn-block btn-primary btn-sm">View transaction</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card p-4-important">
                    <!--begin::Card body-->
                    <div class="card-body p-0-important">
                        <!--begin::Col-->
                        <div class="">
                            @if($user->plan)
                                <div class="p-4">
                                    <p class="text-center fw-boldest">Plan active until {{date("M d, Y", strtotime($user->plan_expiring))}}</p>
                                    <div class="d-flex justify-content-center align-items-center gap-6 mt-8">
                                        <div class="position-relative">
                                            <img src="{{ asset("asset/new_dashboard/media/svg/calendar.png") }}" height="90px" width="" alt="">
                                            <div class="custom-postion-date">
                                                <p class="text-center fs-2 fw-boldest">{{date("d", strtotime($user->plan_expiring))}}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fs-2 mb-0 fw-boldest text-brand">{{ $currency->symbol }}{{ number_format($user->plan->amount ?? 0, 2) }}</div>
                                            <div class="fs-4 fw-boldest text-gray-500">Per {{ $user->plan->durationType }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-4">
                                    <p class="text-center fw-boldest">You do not have a subscription yet</p>
                                    <div class="d-flex justify-content-center mt-9">
                                        <img src="{{ asset("asset/new_dashboard/media/svg/no-subscription.svg") }}" alt="">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!--begin::Chart Widget 1-->
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0 d-flex justify-content-between flex-column">
            <div class="d-flex flex-stack card-p flex-grow-1">
                <!--begin::Icon-->
                <div class="symbol symbol-45px">

                </div>
                <!--end::Icon-->
                <!--begin::Text-->
                <div class="d-flex flex-column text-end">
                    <span class="fw-boldest text-dark fs-2">{{__('Net Income')}}</span>
                    <span class="text-dark-400 fw-bold fs-6">{{__('All-time earnings')}}</span>
                </div>
                <!--end::Text-->
            </div>
            <!--begin::Chart-->
            <div class="">
                @if(count($profit)>0)
                <div id="kt_chart_earning" class="card-rounded-bottom h-125px"></div>
                @else
                <div class="card-rounded-bottom h-125px text-center text-primary">{{__('No data')}}</div>
                @endif
            </div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Chart Widget 1-->
</div>
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-brand-opacity-4 mb-6">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-xl-6 order-md-1 order-2">
                            <h3 class="fw-boldest text-dark fs-6x">{{__('Connect to a marketplace')}}</h3>
                            <div class="mt-4 font-semibold fw-boldest fs-5">{{__("A complete solution for marketplaces")}}</div>
                            <p class="text-dark-400 mb-4 fs-5">{{__('Connect a marketplace or payment gateway to your account to start recieving and holding funds locally.')}}</p>
                            <div>
                                <div class="my-4">
                                    <a href="{{ route('user.bank') }}" class="btn outline-primary">{{__("Connect Marketplaces") }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 order-md-2 order-1 mb-8 mb-lg-0">
                            <div class="d-flex h-100 align-items-center justify-content-sm-start justify-content-lg-center">
                                <img src="{{ asset("asset/new_dashboard/media/img/connection.png") }}" class="connection-img" alt="connection">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="row">
                        @if(count($user->storefrontCount()))
                        <div class="col-md-9">
                            <h3 class="fw-boldest text-dark fs-6x">{{__('Share')}}</h3>
                            <p class="text-dark-400 fw-bold fs-5">{{__('Share website with friends, family & customers')}}</p>
                            <div class="mx-auto">
                                <div class="mb-10">
                                    <div class="d-flex mb-2">
                                        @if($user->website != null)
                                            <input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('website.link', ['id' => $user->website->websiteUrl])}}">
                                            <button data-clipboard-text="{{route('website.link', ['id' => $user->website->websiteUrl])}}" class="castro-copy btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <path d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z" fill="#B5B5C3" />
                                                    </svg>
                                                </span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex mb-4">
                                    <a target="_blank" href="{{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-primary w-100">
                                        {{__('Vist your website')}}</a>
                                    <a target="_blank" href="https://wa.me/{{ $user->storefront()->phone }}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-primary btn-outline mx-6 w-100">
                                        {{__('Share your link')}}</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="text-center px-5 mt-8">
                                <span class="fs-6 fw-bold text-gray-800 d-block mb-2 text-left">{{__('Share using')}}</span>
                                {!! QrCode::eye('circle')->style('round')->size(100)->generate(route('website.link', ['id' => $user->storefront()->store_url])); !!}
                            </div>
                        </div>
                        @else
                            <h3 class="fw-boldest text-dark fs-6x">{{__('Create your website')}}</h3>
                            <p class="text-dark-400 fw-bold my-4 fs-5">{{__('You can offer services on a single multipurpose and functional website. We offer the best theme that fit perfectly with your business niche.')}}</p>
                            <div>
                                <div class="my-4">
                                    <button class="btn opacity-5 btn-primary">{{__("Create Website") }}</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row px-4">
		<div class="card mb-6">
			<div class="card-body">
				<h3 class="fw-boldest text-dark fs-6x">{{__('Recent Transaction')}}</h3>
				<!--begin::Table-->
				<table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
					<thead>
						<tr class="fw-bolder fs-6 text-gray-800 px-7">
							<th class="min-w-125px">{{__('Name')}}</th>
							<th class="min-w-50px">{{__('Status')}}</th>
							<th class="min-w-100px">{{__('Reference ID')}}</th>
							<th class="max-w-50px">{{__('Payment')}}</th>
							<th class="max-w-50px">{{__('Method')}}</th>
							<th class="min-w-50px">{{__('Amount')}}</th>
							{{-- <th></th> --}}
						</tr>
					</thead>
					<tbody>
						@foreach(getFiveTrx($user->id,$user->live) as $val)
						<tr>
							<td class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">
								<!--begin::User details-->
								<div class="d-flex flex-column">
									<span>{{ ucfirst($val->first_name).' '.ucfirst($val->last_name) }}</span>
								</div>
								<!--begin::User details-->
							</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">@if($val->status==0)
								<span class="badge badge-pill badge-light-primary">{{__('Pending')}}</span>
								@elseif($val->status==1)
								<span class="badge badge-pill badge-light-success">{{__('Success')}}</span>
								@elseif($val->status==2)
								<span class="badge badge-pill badge-light-danger">{{__('Failed/Cancelled')}}</span>
								@endif
							</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{$val->ref_id}}</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">
								@if($val->type==1)
								{{__('Single Pot')}}
								@elseif($val->type==2)
								{{__('Gig Pot')}}
								@elseif($val->type==3)
								{{__('Invoice')}}
								@elseif($val->type==4)
								{{__('Merchant')}}
								@elseif($val->type==5)
								{{__('Account Funding')}}
								@elseif($val->type==6)
								{{__('Recurring')}}
								@elseif($val->type==7)
								{{__('Product Order')}}
								@elseif($val->type==8)
								{{__('Store Order')}}
								@elseif($val->type==9)
								{{__('Subscription')}}
								@elseif($val->type==10)
								{{__('Appointment')}}
                                @elseif($val->type==11)
                                {{__('Platform Fee')}}
                                @elseif($val->type==12)
                                {{__('Request Money')}}
                                @endif
							</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{ucwords($val->payment_type)}}</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}"><span class="text-brand">{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</span></td>
							{{-- <td data-bs-toggle="modal" >
								<a href="{{ route('transaction.invoice.download', $val->id) }}">Download</a>
							</td> --}}
						</tr>
						@endforeach
					</tbody>
				</table>
				<!--end::Table-->
			</div>
		</div>
		@foreach(getFiveTrx($user->id,$user->live) as $val)
        <div class="modal fade" id="trans_share{{$val->id}}" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y pt-0 pb-15">
                        <!--begin::Wrapper-->
                        <div class="mw-lg-600px mx-auto">
                            <!--begin::Heading-->
                            <div class="mb-15 text-center">
                                <h3 class="fw-boldest text-dark fs-2x">{{__('Transaction Details')}}</h3>
                                <!--begin::Description-->
                                <div class="text-dark-400 fw-bold fs-4">{{__('Information concerning this transaction')}}</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Heading-->
                            <div class="row mt-8 align-items-center">
                                <div class="col-xl-12 mb-10 mb-xl-0">
                                    <div class="fs-5 fw-bold text-dark">
                                        <div class="card card-dashed flex-row flex-stack flex-wrap px-6 py-5 h-100 mb-6">
                                            <div class="d-flex flex-column py-2">
                                                <div class="d-flex align-items-center fs-4 fw-boldest mb-3">{{__('Payment Details')}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Amount')}}</div>
                                                <div class="fs-4 fw-bold text-dark">{{number_format($val->amount, 2, '.', '')}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Reference ID')}}</div>
                                                <div class="fs-4 fw-bold text-dark">{{$val->ref_id}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Status')}}</div>
                                                @if($val->status==0)
                                                <span class="fs-4 text-primary"><i class="fal fa-sync text-primary"></i> {{__('Pending')}}</span>
                                                @elseif($val->status==1)
                                                <span class="fs-4 text-success"><i class="fal fa-check text-success"></i>{{__('Success')}}</span>
                                                @elseif($val->status==2)
                                                <span class="fs-4 text-danger"><i class="fal fa-ban text-danger"></i> {{__('Failed/Cancelled')}}</span>
                                                @endif
                                                <div class="fs-4 text-gray-600 ">{{__('Date')}}</div>
                                                <div class="fs-4 fw-bold text-dark">{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</div>
                                            </div>
                                            <div class="d-flex flex-column py-2">
                                                <br>
                                                <div class="fs-4 text-gray-600 ">{{__('Currency')}}</div>
                                                <div class="fs-4 text-dark fw-bold">{{$currency->name}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Payment Method')}}</div>
                                                <div class="fs-4 fw-bold text-dark">{{ucwords($val->payment_type)}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Type')}}</div>
                                                <div class="fs-4 fw-bold text-dark">
                                                    @if($val->type==1)
                                                    {{__('Single Pot')}}
                                                    @elseif($val->type==2)
                                                    {{__('Gig Pot')}}
                                                    @elseif($val->type==3)
                                                    {{__('Invoice')}}
                                                    @elseif($val->type==4)
                                                    {{__('Merchant')}}
                                                    @elseif($val->type==5)
                                                    {{__('Account Funding')}}
                                                    @elseif($val->type==6)
                                                    {{__('Recurring')}}
                                                    @elseif($val->type==7)
                                                    {{__('Product Order')}}
                                                    @elseif($val->type==8)
                                                    {{__('Store Order')}}
                                                    @elseif($val->type==9)
                                                    {{__('Subscription')}}
                                                    @elseif($val->type==10)
                                                    {{__('Appointment')}}
                                                    @endif
                                                </div><br><br>
                                            </div>
                                        </div>
                                        <div class="card card-dashed flex-row flex-stack flex-wrap px-6 py-5 h-100 mb-6">
                                            <div class="d-flex flex-column py-2">
                                                <div class="d-flex align-items-center fs-4 fw-boldest mb-3">{{__('Recipient details')}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Name')}}</div>
                                                <div class="fs-4 fw-bold text-dark">{{ucwords(strtolower($val->receiver->first_name)).' '.ucwords(strtolower($val->receiver->last_name))}}</div>
                                            </div>
                                            <div class="d-flex flex-column py-2">
                                                <br>
                                                <div class="fs-4 text-gray-600 ">{{__('Email')}}</div>
                                                <div class="fs-4 text-dark fw-bold">{{$val->receiver->email}}</div>
                                            </div>
                                        </div>
                                        <div class="card card-dashed flex-row flex-stack flex-wrap px-6 py-5 h-100">
                                            <div class="d-flex flex-column py-2">
                                                <div class="d-flex align-items-center fs-4 fw-boldest mb-3">{{__('Sender details')}}</div>
                                                <div class="fs-4 text-gray-600 ">{{__('Name')}}</div>
                                                <div class="fs-4 fw-bold text-dark">{{ucwords(strtolower($val->first_name)).' '.ucwords(strtolower($val->last_name))}}</div>
                                            </div>
                                            <div class="d-flex flex-column py-2">
                                                <br>
                                                <div class="fs-4 text-gray-600 ">{{__('Email')}}</div>
                                                <div class="fs-4 text-dark fw-bold">{{$val->email}}</div>
                                            </div>
                                        </div>
                                        @if($val->status==1)
                                        <p class="mt-3"><a href="{{route('download.receipt', ['id' => $val->ref_id])}}" class="btn btn-light-info btn-block">{{__('Click here to download receipt')}}</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
	</div>
</div>
{{-- Account Information --}}
<div class="modal fade" id="accountInformation" tabindex="-1" role="dialog" aria-labelledby="accountInformationTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<h5 class="modal-title fs-2" id="mccModalCenterTitle">Account Information</h5>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between mb-8">
                    <div class="">
                        <div class="font-semibold">Account Balance</div>
                        <div class="font-bold fs-1">{{ getUserCurrency($user) }} <span id="account_balance" class="">{{ number_format($user->gBPAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance" class="d-none">*****</span></div>
                        <div class="font-semibold">{{ (getUserCurrencyName($user) == 'GBP') ? "British Pound" : getUserCurrencyName($user) }} ({{ getUserCurrencyName($user) }})</div>
                    </div>
                    <div>
                        <div style="" class="flag-circle flag-uk"></div>
                    </div>
                </div>
                <div class="bg-light p-4 rounded mb-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="">
                            <div class="font-bold">Account Name</div>
                            <div>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" onclick="copyClipboard('{{ $user->first_name }} {{ $user->last_name }}')">
                                <img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="">
                            <div class="font-bold">Account number</div>
                            <div>
                                {{ $user->gBPAccount()->accountNumber ?? '000000' }}
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" onclick="copyClipboard('{{ $user->gBPAccount()->accountNumber ?? '000000' }}')">
                                <img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <div class="font-bold">Sort Code</div>
                            <div>
                                {{$user->gBPAccount()->sortCode ?? '00-00-00'}}
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" onclick="copyClipboard('{{ $user->gBPAccount()->sortCode ?? '00-00-00'}}')">
                                <img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="my-4">
                        <a href="javascript:void(0)" onclick="addMoney('GBP')" class="btn btn-primary d-flex align-items-center gap-3 py-4 px-6">
                            <div><img src="{{ asset("asset/new_dashboard/media/svg/wallet-add-white.svg") }}" class="icon-height-6" alt=""></div>
                            <div>{{__("Add Money") }}</div>
                        </a>
                    </div>
                    <div class="my-4">
                        <a href="javascript:void(0)" onclick="openTransferPopup('GBP')"  class="btn outline-primary d-flex align-items-center gap-3">
                            <div><img src="{{ asset("asset/new_dashboard/media/svg/import-blue.svg") }}" class="icon-height-6" alt=""></div>
                            <div>{{__("Transfer Money") }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="accountInformation-euro" tabindex="-1" role="dialog" aria-labelledby="accountInformationTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<h5 class="modal-title fs-2" id="mccModalCenterTitle">Account Information</h5>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between mb-8">
                    <div class="">
                        <div class="font-semibold">Account Balance</div>
                        <div class="font-bold fs-1">€ <span id="account_balance" class="">{{ number_format($user->euroAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance" class="d-none">*****</span></div>
                        <div class="font-semibold">{{ __('Euro') }} ({{ __("EUR") }})</div>
                    </div>
                    <div>
                        <div style="" class="flag-circle flag-europe"></div>
                    </div>
                </div>
                <div class="bg-light p-4 rounded mb-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="">
                            <div class="font-bold">Account Name</div>
                            <div>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" onclick="copyClipboard('{{ $user->first_name }} {{ $user->last_name }}')">
                                <img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="">
                            <div class="font-bold">IBAN</div>
                            <div>
                                {{ $user->euroAccount()->iban ?? 'Not Available' }}
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" onclick="copyClipboard('{{ $user->euroAccount()->iban ?? '000000' }}')">
                                <img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="">
                            <div class="font-bold">BIC</div>
                            <div>
                                {{ $user->euroAccount()->bic ?? 'Not Available' }}
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" onclick="copyClipboard('{{ $user->euroAccount()->bic ?? '000000' }}')">
                                <img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="my-4">
                        <a href="javascript:void(0)" onclick="addMoney('EURO')" class="btn btn-primary d-flex align-items-center gap-3 py-4 px-6">
                            <div><img src="{{ asset("asset/new_dashboard/media/svg/wallet-add-white.svg") }}" class="icon-height-6" alt=""></div>
                            <div>{{__("Add Money") }}</div>
                        </a>
                    </div>
                    <div class="my-4">
                        <a href="javascript:void(0)"  onclick="openTransferPopup('EURO')"  class="btn outline-primary d-flex align-items-center gap-3">
                            <div><img src="{{ asset("asset/new_dashboard/media/svg/import-blue.svg") }}" class="icon-height-6" alt=""></div>
                            <div>{{__("Transfer Money") }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($user->kyc_verif_status === 'APPROVED')
{{-- Add Money --}}
<div class="modal fade" id="addMoney-GBP" tabindex="-1" role="dialog" aria-labelledby="addMoneyTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<h5 class="modal-title fs-2" id="addMoneyTitle">Add Money</h5>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between mb-8">
                    <div class="">
                        <div class="font-semibold">Account Balance</div>
                        <div class="font-bold fs-1">{{ getUserCurrency($user) }} <span id="account_balance" class="">{{ number_format($user->gBPAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance" class="d-none">*****</span></div>
                        <div class="font-semibold">{{ (getUserCurrencyName($user) == 'GBP') ? "British Pound" : getUserCurrencyName($user) }} ({{ getUserCurrencyName($user) }})</div>
                    </div>
                    <div>
                        <div style="" class="flag-circle flag-uk"></div>
                    </div>
                </div>
                <div class="bg-brand-opacity-4 p-4 rounded mb-8">
                    <div class="fw-boldest fs-5">Smart Account Topup</div>
                    <div class="text-sm">Use Open Banking to topup account</div>
                    <form action="{{route('payment.open-banking')}}" method="POST" id="openBankingForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        <div class="row mt-4">
                            <div class="col-8">
                                <input type="number" name="amount" id="amount" class="form-control bg-white form-control-solid" placeholder="Amount">
                            </div>
                            <div class="col-4">
                                <button data-href="{{url('/dashboard/open-banking?_id='.$user->id.'&&amount=100')}}" class="btn btn-block btn-primary">Proceed</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-image-green-4 p-4 rounded mb-8">
                    <div class="fw-boldest fs-5">Share Account Details</div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="fs-6">Account Number: {{ $user->gBPAccount()->accountNumber ?? '000000' }}</div>
                            <div class="fs-6">Sort Number: {{$user->gBPAccount()->sortCode ?? '00-00-00'}}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <button id="btn_copy_accno_sort_code" data-account="{{ $user->gBPAccount()->accountNumber ?? '000000' }}" data-sort="{{$user->gBPAccount()->sortCode ?? '00-00-00'}}" class="btn btn-sm bg-white text-brand btn-primary d-flex align-items-center gap-3">
                                    <div><img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" class="icon-height-6" alt=""></div>
                                    <div>{{ __("Copy and paste") }}</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if($user->kyc_verif_status === 'APPROVED')
<div class="modal fade" id="addMoney-EURO" tabindex="-1" role="dialog" aria-labelledby="addMoneyTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<h5 class="modal-title fs-2" id="addMoneyTitle">Add Money</h5>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between mb-8">
                    <div class="">
                        <div class="font-semibold">Account Balance</div>
                        <div class="font-bold fs-1">€ <span id="account_balance" class="">{{ number_format($user->euroAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance" class="d-none">*****</span></div>
                        <div class="font-semibold">{{ __('Euro') }} ({{ __("EUR") }})</div>
                    </div>
                    <div>
                        <div style="" class="flag-circle flag-europe"></div>
                    </div>
                </div>
                <div class="bg-brand-opacity-4 p-4 rounded mb-8">
                    <div class="fw-boldest fs-5">Smart Account Topup</div>
                    <div class="text-sm">Use Open Banking to topup account</div>
                    <div class="row mt-4">
                        <div class="col-8">
                            <input type="number" name="amount" id="amount" class="form-control bg-white form-control-solid" placeholder="Amount">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-block btn-primary">Proceed</button>
                        </div>
                    </div>
                </div>
                <div class="bg-image-green-4 p-4 rounded mb-8">
                    <div class="fw-boldest fs-5">Share Account Details</div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="fs-6">IBAN:{{ $user->euroAccount()->iban ?? 'Not Available' }}</div>
                            <div class="fs-6">BIC:{{ $user->euroAccount()->bic ?? '000000' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <button class="btn btn-sm bg-white text-brand btn-primary d-flex align-items-center gap-3">
                                    <div><img src="{{ asset("asset/new_dashboard/media/svg/copy.svg") }}" class="icon-height-6" alt=""></div>
                                    <div>{{ __("Copy and paste") }}</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if($user->kyc_verif_status === 'APPROVED')
{{-- Send MOney --}}
<div class="modal fade" id="sendMoney-GBP" tabindex="-1" role="dialog" aria-labelledby="sendMoneyGBPTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<h5 class="modal-title fs-4" id="sendMoneyGBPTitle">Send Money</h5>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body">
                <div id="errorSendMoney" class="text-danger mb-2"></div>
                <div class="d-flex align-items-center justify-content-between mb-4 d-none">
                    <div class="">
                        <div class="font-semibold">Account Balance</div>
                        <div class="font-bold fs-5">{{ getUserCurrency($user) }} <span id="account_balance" class="">{{ number_format($user->gBPAccount()->balance ?? 0, 2) }}</span><span id="hidden_balance" class="d-none">*****</span></div>
                        <div class="font-semibold">{{ (getUserCurrencyName($user) == 'GBP') ? "British Pound" : getUserCurrencyName($user) }} ({{ getUserCurrencyName($user) }})</div>
                    </div>
                    <div>
                        <div style="" class="flag-circle flag-uk"></div>
                    </div>
                </div>
                <div id="send-option" class="rounded">
                    <div onclick="switchSendMoney('existing')" class="bg-brand-opacity-4 p-4 rounded cursor-pointer">
                        <div class="d-flex gap-4">
                            <div class="bg-brand icon-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('asset/new_dashboard/media/svg/send.svg') }}" class="icon-height-6" alt="">
                            </div>
                            <div>
                                <div class="fw-boldest fs-5">Transfer to existing beneficiary</div>
                                <div class="text-sm">Bank Transfers to an existing beneficiary</div>
                            </div>
                        </div>
                    </div>
                    <div  onclick="switchSendMoney('new')" class="bg-green p-4 rounded mt-4 cursor-pointer">
                        <div class="d-flex gap-4">
                            <div class="bg-green-deep icon-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('asset/new_dashboard/media/svg/add.svg') }}" class="icon-height-6" alt="">
                            </div>
                            <div>
                                <div class="fw-boldest fs-5">Transfer to someone new</div>
                                <div class="text-sm">Pay someone new</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow p-4 rounded mt-4 cursor-pointer d-none">
                        <div class="d-flex gap-4">
                            <div class="bg-yellow-deep icon-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('asset/new_dashboard/media/svg/empty-wallet-add.svg') }}" class="icon-height-6" alt="">
                            </div>
                            <div>
                                <div class="fw-boldest fs-5">Transfer to your other accounts</div>
                                <div class="text-sm">Bank Transfers to your other accounts</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow p-4 mt-4">
                        <div class="fw-boldest mb-4"><span><img src="{{ asset('asset/new_dashboard/media/svg/flag.svg') }}"></span> New Payee account name check</div>
                        <div class="text-sm">For additional security and to help protect against fraud, we'Il check the details you provide against the payee's account details, including the name on their account. Although this does not prevent all types of fraud, this will  help give you reassurancethat you are paying the correct person.</div>
                    </div>
                </div>
                <div id="beneficiary" class="rounded d-none">
                    <div class="row">
                        <div class="col-8">
                            <div class="fs-6">Please ensure you provide correct transfer details</div>
                        </div>
                        <div class="col-4 text-right">
                            <button id="switch-beneficiary" class="btn btn-primary btn-sm">Pay Someone New</button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div id="accounttypeDiv" class="col-6">
                            <select id="accountype" name="accountype" class="form-control form-control-solid">
                                <option value="">Select account type*</option>
                                <option value="personal">Personal Account</option>
                                <option value="business">Business Account</option>
                            </select>
                        </div>
                        <div id="beneficariesDiv" class="col-6">
                            <select name="beneficiary" id="beneficiaryInput"  class="form-control form-control-solid" placeholder="Select Beneficiary">
                                <option value="">Select Beneficiary*</option>
                                @foreach($user->bankingbeneficiaries as $beneficiary)
                                    <option value="{{ $beneficiary->id }}">{{ $beneficiary->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="inputReceiverDiv" class="row mt-4 d-none">
                        <div class="col-6">
                            <input type="text" name="firstName" id="firstName" class="form-control form-control-solid" placeholder="First name*">
                        </div>
                        <div class="col-6">
                            <input type="text" name="lastName" id="lastName" class="form-control form-control-solid" placeholder="Last name*">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <input type="text" name="accountNumber" readonly id="beneficiaryaccountNumber" class="form-control form-control-solid" placeholder="Account number*">
                        </div>
                        <div class="col-6">
                            <input type="text" name="accountSortCode" readonly id="beneficiaryaccountSortCode" class="form-control form-control-solid" placeholder="Sortcode*">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="input-group input-group-solid">
                                <span class="input-group-prepend">
                                  <span class="input-group-text">{{ getUserCurrencyName($user) }}</span>
                                </span>
                                <input type="number" id="amountSend" name="amount" class="form-control form-control-lg form-control-solid" placeholder="{{__('Amount*')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div id="paymentTypeDiv" class="col-6">
                            <select name="paymentType" id="paymentType" class="form-control form-control-solid" placeholder="Select Beneficiary">
                                <option value="">Select payment type*</option>
                                <option value="instant">Instant Payment</option>
                                <option value="scheduled">Scheduled Payment</option>
                            </select>
                        </div>
                        <div class="col-6" id="paymentDateDIv">
                            <input type="date" name="date" id="date" class="form-control form-control-solid" placeholder="mm/dd/yyy">
                        </div>
                    </div>
                    <div id="saveBeneficiary" class="col-6 mt-4 d-none">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Save Beneficiary</label>
                        </div>
                    </div>

                    <input type="text" name="switchBeneficiaryType" value="" id="switchBeneficiaryType" class="d-none">

                    <div class="col-md-12 submit-button mt-4 ">
                        <button  class="btn btn-primary form-control" type="button" id="confirmPayee">
                            Continue
                        </button>
                    </div>
                </div>

                <div id="review" class="rounded d-none">
                    <div class="mb-4">
                        <div class="text-sm">From</div>
                        <div class="mt-2 bg-brand-opacity-4 p-4 rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="fs-6">Selected Account</div>
                                    <div class="fs-6">{{ $user->gBPAccount()->accountNumber ?? '000000' }} | {{$user->gBPAccount()->sortCode ?? '00-00-00'}} </div>
                                </div>
                                <div>
                                    <p class="fw-boldest text-brand">{{ getUserCurrency($user) }} <span id="amountNumberBlue"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-sm">To</div>
                        <div class="text-success text-sm">Account name is match</div>
                        <div class="mt-2 bg-green p-4 rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5" id="reciverName"></div>
                                    <div class="fs-6">Selected Account</div>
                                    <div class="fs-6"><span id="amountAccountNumber"></span> | <span id="amountAccountSortCode"></span></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <div><img src="{{ asset('asset/new_dashboard/media/svg/tick-circle.svg') }}" alt=""></div>
                                <div class="text-success text-sm">Confirmed</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="text-brand text-sm">Amount<span>*</span></label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                              <span class="input-group-text">{{ getUserCurrencyName($user) }}</span>
                            </span>
                            <input type="number" id="amountConfirm" name="amount" class="form-control form-control-lg form-control-solid" placeholder="{{__('Amount')}}">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <button onclick="goToTab('beneficiary','review')" class="btn btn-block text-danger">Cancel</button>
                        </div>
                        <div class="col-6">
                            <button onclick="goToTab('review','passwordConfimation')"  class="btn btn-block btn-primary">Proceed</button>
                        </div>
                    </div>
                </div>

                <div id="passwordConfimation" class="rounded d-none">
                    <div class="col-12">
                        <label for="beneficaries" class="text-brand text-sm">Enter your Tryba account password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-solid" placeholder="Password">
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <button onclick="goToTab('passwordConfimation','reviewAndConfirm')" class="btn btn-block btn-primary">Proceed</button>
                        </div>
                        <div class="col-6">
                            <button onclick="goToTab('reviewAndConfirm','passwordConfimation')" class="btn btn-block text-danger">Cancel</button>
                        </div>
                    </div>
                </div>

                <div id="reviewAndConfirm" class="rounded d-none">
                    <div class="mb-4">
                        <div class="text-sm">From</div>
                        <div class="mt-2 bg-brand-opacity-4 p-4 rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="fs-6">Selected Account</div>
                                    <div class="fs-6">{{ $user->gBPAccount()->accountNumber ?? '000000' }} | {{$user->gBPAccount()->sortCode ?? '00-00-00'}} </div>
                                </div>
                                <div>
                                    <p class="fw-boldest text-brand">{{ getUserCurrency($user) }} <span id="amountNumberBlue"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-sm">To</div>
                        <div class="d-flex align-items-center gap-1">
                            <div><img src="{{ asset('asset/new_dashboard/media/svg/tick-circle.svg') }}" alt=""></div>
                            <div class="text-warning text-sm">Account is a close match</div>
                        </div>

                        <div class="text-sm">
                            the account name you gave us isn't the same as the name held on the account please double check the details. Making this payment may lead to money being sent to the wrong account which may not be recoverable.
                        </div>
                        <div class="text-sm fw-bold mt-3">You enter</div>
                        <div class="mt-2 bg-warning p-4 rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5" id="reciverName">Nelson Mojolaoluwa</div>
                                    <div class="fs-6">HSBC UK BANK PLC | Personal Account</div>
                                    <div class="fs-6"><span id="amountAccountNumber">442013063</span> | <span id="amountAccountSortCode">56-00-55</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 p-4">
                            <div class="text-sm fw-bold">Their bank told us</div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5" id="reciverName">Nelson Mojolaoluwa</div>
                                    <div class="fs-6">HSBC UK BANK PLC | Personal Account</div>
                                    <div class="fs-6"><span id="amountAccountNumber">442013063</span> | <span id="amountAccountSortCode">56-00-55</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="text-brand text-sm">Amount<span>*</span></label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                              <span class="input-group-text">{{ getUserCurrencyName($user) }}</span>
                            </span>
                            <input type="number" id="amountConfirm" name="amount" class="form-control form-control-lg form-control-solid" placeholder="{{__('Amount')}}">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <button onclick="goToTab('confirmationError','reviewAndConfirm')" class="btn btn-outline-primary">Use Nelson Jolaoluwa</button>
                        </div>
                        <div class="col-6">
                            <button onclick="goToTab('confirmationError','reviewAndConfirm')" class="btn btn-block btn-primary">Use What I entered</button>
                        </div>
                    </div>
                </div>

                <div id="confirmationError" class="rounded d-none">
                    <div class="mb-4">
                        <div class="text-sm">From</div>
                        <div class="mt-2 bg-brand-opacity-4 p-4 rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="fs-6">Selected Account</div>
                                    <div class="fs-6">{{ $user->gBPAccount()->accountNumber ?? '000000' }} | {{$user->gBPAccount()->sortCode ?? '00-00-00'}} </div>
                                </div>
                                <div>
                                    <p class="fw-boldest text-brand">{{ getUserCurrency($user) }} <span id="amountNumberBlue"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-sm">To</div>
                        <div class="d-flex align-items-center gap-1">
                            <div><img src="{{ asset('asset/new_dashboard/media/svg/tick-circle.svg') }}" alt=""></div>
                            <div class="text-danger text-sm">Account name does not match</div>
                        </div>

                        <div class="text-sm">
                            the account name you gave us isn't the same as the name held on the account please double check the details. Making this payment may lead to money being sent to the wrong account which may not be recoverable.
                        </div>
                        <div class="text-sm fw-bold mt-3">You enter</div>
                        <div class="mt-2 bg-warning p-4 rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5" id="reciverName">Nelson Mojolaoluwa</div>
                                    <div class="fs-6">HSBC UK BANK PLC | Personal Account</div>
                                    <div class="fs-6"><span id="amountAccountNumber">442013063</span> | <span id="amountAccountSortCode">56-00-55</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 p-4">
                            <div class="text-sm fw-bold">Their bank told us</div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-boldest fs-5" id="reciverName">Nelson Mojolaoluwa</div>
                                    <div class="fs-6">HSBC UK BANK PLC | Personal Account</div>
                                    <div class="fs-6"><span id="amountAccountNumber">442013063</span> | <span id="amountAccountSortCode">56-00-55</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="text-brand text-sm">Amount<span>*</span></label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                              <span class="input-group-text">{{ getUserCurrencyName($user) }}</span>
                            </span>
                            <input type="number" id="amountConfirm" name="amount" class="form-control form-control-lg form-control-solid" placeholder="{{__('Amount')}}">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <button onclick="goToTab('confirmationError','beneficiary')" class="btn btn-block text-danger">Go Back to Edit</button>
                        </div>
                        <div class="col-6">
                            <button onclick="goToTab('confirmationError','cautionError')" class="btn btn-block btn-primary">Use What I entered</button>
                        </div>
                    </div>
                </div>

                <div id="cautionError" class="rounded d-none">
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-1">
                            <div><img src="{{ asset('asset/new_dashboard/media/svg/tick-circle.svg') }}" alt=""></div>
                            <div class="text-danger text-sm">Account name does not match</div>
                        </div>

                        <div class="text-sm mt-4">
                            The account name you gave us isn't the same as the name held on the account. Please double check the details. Making this payment may lead to money being sent to the wrong account which may not be recoverable.
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <button onclick="goToTab('cautionError','beneficiary')" class="btn btn-block text-danger">Go Back to Edit</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-block btn-primary">Yes, Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if($user->kyc_verif_status === 'APPROVED')
<div class="modal fade" id="requestMoney" tabindex="-1" role="dialog" aria-labelledby="sendMoneyGBPTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<h5 class="modal-title fs-2" id="sendMoneyGBPTitle">Request money</h5>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
					<span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
						</svg>
					</span>
				</div>
			</div>
            <div class="modal-body">
                <div id="sender_error" class="text-danger mb-4"></div>
                <div id="sender_success" class="text-success mb-4"></div>
                <form id="create_request_link" class="">
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="">
                                <input type="text" required name="sender_first_name" class="form-control form-control-solid" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="">
                                <input type="text" required name="sender_last_name" class="form-control form-control-solid" placeholder="Last Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="">
                            <input type="number" required name="sender_amount" class="form-control form-control-solid" min="10" placeholder="Enter an amount">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-primary">
                            Generate Link
                        </button>
                    </div>
                </form>
                <div id="share_link_sender" class="d-none">
                    <div class="d-flex align-items-center mb-2">
                        <input type="text" id="sender_generated_link" class="form-control form-control-solid me-3" name="search" value="">
                        <button  id="sender_generated_btn" data-clipboard-text="" class="castro-copy w-25 btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light">
                            Copy link
                        </button>
                    </div>
                    <div class="d-flex justify-content-center my-4">
                        <div>
                            <div class="fw-5">Scan QR code or Share Using</div> 
                            <div class="d-flex justify-content-center">
                                <div id="qrcode" class="my-4"></div>
                            </div>
                        </div>
                    </div>
                    <form id="send_request_link">
                    <div class="col-12 mb-4">
                        <div class="mb-4">How would you want the receiver to receive the link</div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="email" name="sender_via">
                            <label class="form-check-label">
                              By Email
                            </label>
                        </div>
                        <div id="email_div" class="col-12 mb-4 d-none">
                            <div class="">
                                <input type="email" name="sender_email" class="form-control form-control-solid" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="sms" name="sender_via">
                            <label class="form-check-label">
                              By SMS
                            </label>
                        </div>
                        <div id="sms_div" class="col-12 mb-4 d-none">
                            <div class="input-group input-group-solid">
                                <span class="input-group-prepend">
                                  <select name="sender_phone_code" id="sender_phone_code" data-control="select2" class="form-control form-control-lg form-control-solid" required>
                                    @foreach(getPhone() as $val)
                                        <option value="{{ ' +'.str_replace('+', '', $val->phonecode) }}">{{ ' +'.str_replace('+', '', $val->phonecode) }}</option>
                                    @endforeach
                                  </select>
                                </span>
                                <input type="tel" name="sender_phonenumber"  id="sender_phonenumber" maxlength="11" value="" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - without country code')}}">
                            </div>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="whatsapp" name="sender_via">
                            <label class="form-check-label">
                              By Whatsapp
                            </label>
                        </div>
                        <div id="whatsapp_div" class="d-none">
                            <div class="col-12 mb-4">
                                <div class="input-group input-group-solid">
                                    <span class="input-group-prepend">
                                      <select name="whatsapp_phone_code" id="whatsapp_phone_code" data-control="select2" class="form-control form-control-lg form-control-solid" required>
                                        @foreach(getPhone() as $val)
                                            <option value="{{ ' +'.str_replace('+', '', $val->phonecode) }}">{{ ' +'.str_replace('+', '', $val->phonecode) }}</option>
                                        @endforeach
                                      </select>
                                    </span>
                                    <input type="tel" id="sender_whatsapp_number" name="sender_whatsapp_number" maxlength="11" value="" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - without country code')}}">
                                </div>
                            </div>
                            <a target="_blank" id="whatsapp_btn_link" href="" class="btn btn-success d-none">
                                <i class="fab fa-whatsapp fs-5 me-1"></i>{{__('Whatsapp')}}
                            </a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <input type="hidden" name="slug" id="slug">
                        <button id="generate_another_link" class="btn outline-primary mt-4 me-3">
                            Generate Another Request Link
                        </button>
                        <button id="send_link_btn" class="btn btn-primary mt-4">
                            Send
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="overlay d-none" id="switch-overlay"></div>
    <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Compliance Verification</h5>
                    <a href="javascript:;" class="close text-danger" id="closeModal" data-dismiss="modal" aria-label="Close" style="font-size: 32px !important;">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div id="sumsub-container"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var element = document.getElementById('kt_chart_earning');

		var height = parseInt(KTUtil.css(element, 'height'));
		var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
		var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
		var baseColor = KTUtil.getCssVariableValue('--bs-primary');
		var lightColor = KTUtil.getCssVariableValue('--bs-light-primary');

		if (!element) {
			return;
		}

		var options = {
			series: [{
				name: 'Net Profit',
				data: [<?php foreach ($profit as $val) {
							echo $val->amount . ',';
						} ?>]
			}],
			chart: {
				fontFamily: 'inherit',
				type: 'area',
				height: '150px',
				toolbar: {
					show: !1
				},
				zoom: {
					enabled: !1
				},
				sparkline: {
					enabled: !0
				}
			},
			plotOptions: {

			},
			legend: {
				show: false
			},
			dataLabels: {
				enabled: false
			},
			fill: {
				type: 'solid',
				opacity: 1
			},
			stroke: {
				curve: 'smooth',
				show: true,
				width: 0.5,
				colors: [baseColor]
			},
			xaxis: {
				categories: [<?php foreach ($profit as $val) {
									echo "'" . date("M j", strtotime($val->updated_at)) . "'" . ',';
								} ?>],
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false
				},
				labels: {
					style: {
						colors: labelColor,
						fontSize: '12px'
					}
				},
				crosshairs: {
					position: 'front',
					stroke: {
						color: baseColor,
						width: 1,
						dashArray: 3
					}
				},
				tooltip: {
					enabled: true,
					formatter: undefined,
					offsetY: 0,
					style: {
						fontSize: '12px'
					}
				}
			},
			yaxis: {
				labels: {
					style: {
						colors: labelColor,
						fontSize: '12px'
					}
				}
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0
					}
				},
				active: {
					allowMultipleDataPointsSelection: false,
					filter: {
						type: 'none',
						value: 0
					}
				}
			},
			tooltip: {
				style: {
					fontSize: '12px'
				},
				y: {
					formatter: function(val) {
						return '@php echo $currency->symbol; @endphp' + val
					}
				}
			},
			colors: [lightColor],
			grid: {
				borderColor: borderColor,
				strokeDashArray: 4,
				yaxis: {
					lines: {
						show: true
					}
				}
			},
			markers: {
				strokeColor: baseColor,
				strokeWidth: 3
			}
		};

		var chart = new ApexCharts(element, options);
		chart.render();
	});


   /* let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let business = document.getElementById('business_reg');
    let display = document.getElementById('display')
    business.addEventListener("keyup", function(e){
      let word  = e.target.value;
      if(word.length > 0){
          //{{ route('user.smsEmail',$user->id) }}
         let url = window.location.origin+"/user/business/"+word;

        fetch(url, {
            method: "GET",
           headers: {"Content-type": "application/json;charset=UTF-8",
                     "X-CSRF-TOKEN": token}
        }).then(Response => {
            return Response.json()
        }).then(res => {
           if(res.errors){
           // console.log(res.errors[0].error)
            display.innerText = res.errors[0].error
            display.setAttribute("class", "w-auto text-center d-block");
           }else if(res.company_status == 'active'){
             // console.log(res.company_name)
              display.innerText = res.company_name
              display.setAttribute("class", "w-auto text-center d-block");

           }
        })
      }else if(word.length == 0){
        display.innerText = ""
        display.setAttribute("class", "w-auto text-center d-none");
      }else if(word == ''){
        display.innerText = ""
        display.setAttribute("class", "w-auto text-center d-none");
      }
      else{
        display.innerText = ""
        display.setAttribute("class", "w-auto text-center d-none");
      }
    })

     let tokens = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let personel = document.getElementById("personel");
    let postal_code = document.getElementById("postal_code");
    postal_code.addEventListener("keyup", function(e){
       let word = e.target.value
       if(word.length > 0){
        url = window.location.origin+'/user/postal/'+word;
        fetch(url, {
            method: "GET",
           headers: {"Content-type": "application/json;charset=UTF-8",
                     "X-CSRF-TOKEN": tokens}
        }).then(Response => {
            return Response.json()
        }).then(res => {
            console.log(res)
           if(res.errors){
           // console.log(res.errors[0].error)
           // display.innerText = res.errors[0].error
            //display.setAttribute("class", "w-auto text-center d-block");
           }
        })

       }else if(word.length == 0){
        personel.innerText = ""
        personel.setAttribute("class", "w-auto text-center d-none");
      }else if(word == ''){
        personel.innerText = ""
        personel.setAttribute("class", "w-auto text-center d-none");
      }
      else{
        personel.innerText = ""
        personel.setAttribute("class", "w-auto text-center d-none");
      }
    })*/
</script>

@endsection

