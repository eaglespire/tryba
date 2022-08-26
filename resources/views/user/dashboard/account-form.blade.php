<form id="accOpeningForm" action="#" method="POST">
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Welcome')}}, <span class="text-brand">{{ ucwords(strtolower($user->business_name ?? $user->first_name)) }} </span> <img src="{{ asset('asset/new_dashboard/media/svg/waving-hand.svg') }}" alt=""></h1>
                <!--end::Title-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    {{-- Notices --}}
    <div class="container ">
        <div class="col-xl-12 px-4" >
            <div class="row my-6 notice rounded p-4 pb-0 position-relative bg-white">
                <div class="col-sm-8 col-12 pb-4">
                    @if($user->kyc_verif_status === 'APPROVED')
                        <h1 class="font-sembold fs-4" >{{__('Welcome to Tryba') }}</h1>
                        <div>{{__("Congratulations! Your account has been successfully opened. Enjoy the benefits of Tryba business banking. ")}}</div>
                    @elseif($user->kyc_verif_status === 'PENDING')
                        <h1 class="font-sembold fs-4" >{{__('Verification is processing') }}</h1>
                        <div>{{__("We are currently verifying your data. This usually take about 5 minutes. In certain cases we might need up to 48hours to run more checks. We will notify you once they are complete. ")}}</div>
                        <div class="my-4">
                            <a href="javascript:;"  class="btn btn-warning">{{__("Processing") }}</a>
                        </div>
                    @else
                        <h1 class="font-sembold fs-4" >{{__('We need more information about you') }}</h1>
                        <div>{{__("Compliance is currently due, please update your account information to avoid restrictions such as no access to storefront service.")}}</div>
                        <div class="my-4">
                                <a href="javascript:;" id="actOpening" class="btn btn-primary">{{__("Click here to update now") }}</a>
                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#accountOpening" class="btn btn-primary">{{__("Click here to update now") }}</a> --}}
                        </div>
                    @endif
                </div>
                <div class="d-none d-sm-flex col-sm-4 justify-content-center">
                    <img src="{{ asset('asset/new_dashboard/media/img/compliance.png') }}" class="compliance-img"  alt="">
                </div>
            </div>
        </div>
    </div>
    {{-- NOtice Modal --}}
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="accountOpening" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div id="modal-size" class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-2" id="mccModalCenterTitle">Account Opening</h5>
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
                    <form id="accountOpeningForm">
                        <div id="errorMsg" class="text-danger mb-2"></div>
                        <div id="first-page" >
                            <h1 class="font-bold fs-3">Government regulations require us to know  more about your business</h1>
                            <div class="fs-6 text-gray my-4">Information Required</div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('asset/new_dashboard/media/svg/user-square.svg') }}" class="icon-height-6" alt="">
                                    <div>Full business Information</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('asset/new_dashboard/media/svg/card.svg') }}" class="icon-height-6" alt="">
                                    <div>Valid ID</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('asset/new_dashboard/media/svg/camera.svg') }}" class="icon-height-6" alt="">
                                    <div>Selfie</div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="getStarted" class="btn btn-block btn-primary">{{__("Continue") }}</button>
                            </div>
                        </div>
                        <div id="second-page" class="d-none">
                            <h1 class="font-bold fs-3">{{ __("How do you plan to use tryba? ") }}</h1>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("Launch my new business")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="new" name="usingTryba">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("Connect to my existing business")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="existing" type="radio" name="usingTryba">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="second-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="second-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="third-page" class="d-none">
                            <h1 class="font-bold fs-3">{{ __("What’s the nature of your business?") }}</h1>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    Offer service
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="service" name="servicesType">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    Sell Online
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="sell" type="radio" name="servicesType">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="third-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="third-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="fouth-page" class="d-none">
                            <h1 class="font-bold fs-3">{{ __("Let’s get to know your business further") }}</h1>
                            <div>
                                <div class="my-4">
                                    <input type="number" name="turnover" id="turnover" class="form-control form-control-solid" placeholder="Your expected monthly spend here">
                                </div>
                            </div>
                            <div class="my-4">
                                <div>
                                    <select name="industry_code" id="business_category" class="form-control form-control-solid" id="">
                                        <option value="">Select Merchant Category</option>
                                        @foreach(getMerchantCodes() as $mcc)
                                            <option value="{{ $mcc->modularLabel }}">{{ $mcc->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="fouth-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="fouth-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="seventh-page-soletrader" class="d-none">
                            <h1 class="font-bold fs-3">Let’s get your personal information</h1>
                            <div class="mb-4">
                                <div class="mt-4">
                                    <input type="text" name="soletrader_addresss_1" id="soletraderAddress1" class="form-control form-control-solid" placeholder="Address 1">
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="soletrader_addresss_2" id="soletraderAddress2" class="form-control form-control-solid" placeholder="Address 2">
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="soletrader_city" id="soletraderCity" class="form-control form-control-solid" placeholder="City">
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="soletrader_postcode" id="soletraderPostCode" class="form-control form-control-solid" placeholder="Postcode">
                                </div>
                            </div>
                            <h1 class="font-bold fs-5">What’s your gender?</h1>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    Male
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="male" name="gender">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    Female
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="female" type="radio" name="gender">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    Rather not say
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="rathernotsay" type="radio" name="gender">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="seventh-btn-soletrader" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="seventh-back-soletrader" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="fifth-page" class="d-none">
                            <h1 class="font-bold fs-3">Business Information</h1>
                            <div class="my-4">
                                <select name="business_type" id="business_type" class="form-select" id="">
                                    <option value="">Select Business Type</option>
                                    <option value="INDIVIDUAL">Personal Account</option>
                                    <option value="SOLETRADER">Self Employed</option>
                                    <option value="LLC">Limited Company</option>
                                </select>
                            </div>
                            <div id="business_name_div" class="d-none">
                                <div class="my-4">
                                    <select  name="business_name" id="business_name" class="form-control form-control-solid select business_name">
                                        <option value="">Enter business name</option>
                                    </select>
                                </div>
                                <div class="my-4">
                                    <input  name="ownership" id="ownership" placeholder="Share size" class="form-control form-control-solid"/>
                                </div>
                            </div>
                            <div id="soletrader_div"  class="d-none">
                                <div class="my-4">
                                    <input name="soletrader_business_name" id="soletrader_business_name" placeholder="Business Name" class="form-control form-control-solid"/>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="fifth-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="fifth-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="sixth-page-limited" class="d-none">
                            <h1 class="font-bold fs-3">Your information so far</h1>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Business Name</div>
                                                <div class="fs-6 c-name" id="c-name"></div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Company reg number</div>
                                                <div class="fs-6 c-reg" id="c-reg"></div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Business type</div>
                                                <div class="fs-6 c-type" id="c-type"></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Registered Addresss</div>
                                                <div class="fs-6 reg-address" id="reg-address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <div class="fw-boldest text-brand fs-2 c-name">Business Name</div>
                                        <div class="fw-boldest fs-6">Beneficial owners</div>
                                        <div class="mt-4 officers" id="officers"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">Have we got all your business informationso far?</div>
                            <div class="mt-4">
                                <button type="button" id="sixth-page-limited-back" class="btn border-brand text-brand btn-outline">{{__("Not my business") }}</button>
                                <button type="button" id="sixth-page-limited-btn" class="btn btn-primary">{{__("Yes, Let’s move") }}</button>
                            </div>
                        </div>
                        <div id="seventh-page" class="d-none">
                            <div class="mb-3">
                                <p>Date of birth</p>
                                <div class="d-flex gap-3">
                                    <div>
                                        <select name="date_account" id="date_account" class="form-select" id="">
                                            <option value="">Day</option>
                                            @for($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <select name="month_account" id="month_account" class="form-select" id="">
                                            <option value="">Month</option>
                                            @for($month = 1; $month <=12; $month++)
                                                <option value="{{ $month }}">{{ date('F', mktime(0,0,0,$month, 1, date('Y')))  }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <select name="year_account" id="year_account" class="form-select" id="">
                                            <option value="">Year</option>
                                            @for($i = 1945; $i < now()->year; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h1 class="font-bold fs-3">In your own word, please describe what you do. </h1>
                            <div class="my-4">
                                <textarea class="form-control form-control-solid" name="business_description" id="business_description" cols="30" rows="6" placeholder="Describe what you want to do in here"></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="seventh-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="seventh-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="eight-page" class="d-none">
                            <h1 class="font-bold fs-3">Do you have a website?</h1>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    Yes
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="haveWebsite" value="yes" name="ownWebsite">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div id="websitediv" class="my-4 d-none">
                                <input type="text" name="websiteURL" id="websiteURL" class="form-control form-control-solid" placeholder="Provide your website url">
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    No
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="no" type="radio" name="ownWebsite">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div id="websiteSocial" class="my-4 d-none">
                                <div class="my-2">
                                    <input type="text" name="facebookURL" id="facebookURL" class="form-control form-control-solid" placeholder="Facebook Profile Url">
                                </div>
                                <div class="my-2">
                                    <input type="text" name="instagramURL" id="instagramURL" class="form-control form-control-solid" placeholder="Instagram handle link">
                                </div>
                                <div class="my-2">
                                    <input type="text" name="twitterURL" id="twitterURL" class="form-control form-control-solid" placeholder="Twitter handle link">
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="eight-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="eight-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="ninth-page" class="d-none">
                            <h1 class="font-bold fs-3">Company Beneficial Owners Details</h1>
                            {{-- <h1 class="font-bold fs-3">We will like to collect personal information of every persons involve in your business</h1>
                            <p class="fs-6">Are there other people involved in your business?</p>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("Yes")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="yes" name="istherestaff">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("No")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="no" name="istherestaff">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div> --}}
                            <div id="staff_Details" class="my-6 d-nones staff_Details">
                                {{-- <div class="row">
                                    <div class="col-6">
                                        <div class="">
                                            <input type="text" name="staffName" class="form-control form-control-solid" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="">
                                            <input type="text" name="staffLastName" class="form-control form-control-solid" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="staffMiddleName" class="form-control form-control-solid" placeholder="Middle Name">
                                </div> --}}
                                {{-- <div class="mt-4">
                                    <input type="email" name="staffemail" class="form-control form-control-solid" placeholder="Email Address">
                                </div> --}}
                                {{-- <div class="sf-details">
                                    <div class="row">
                                        <div class="col-md-6 mt-4">
                                            <input type="text" name="staffphone" class="form-control form-control-solid" placeholder="Phone Number">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <input type="date" name="staffdob" class="form-control form-control-solid" placeholder="Date of birth">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mt-4 col-md-6">
                                            <input type="text" name="staff_addresss_1" class="form-control form-control-solid" placeholder="Address 1">
                                        </div>
                                        <div class="mt-4 col-md-6">
                                            <input type="text" name="staff_addresss_2" class="form-control form-control-solid" placeholder="Address 2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mt-4 col-md-6">
                                            <input type="text" name="staff_city" class="form-control form-control-solid" placeholder="City">
                                        </div>
                                        <div class="mt-4 col-md-6">
                                            <input type="text" name="postcode" class="form-control form-control-solid" placeholder="Postcode">
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="mt-4">
                                <button type="button" id="ninth-btn" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="ninth-back" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="tenth-page-limited" class="d-none">
                            <h1 class="font-bold fs-3">Are you a director in the company?</h1>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("Yes")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="yes" name="is_user_director">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("No")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="no" name="is_user_director">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="tenth-btn-limited" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="tenth-back-limited" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="eleventh-page-limited" class="d-none">
                            <h1 class="font-bold fs-3">To get it clear, is your registered business address the same as your trading address? </h1>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("Yes")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="yes" name="is_address_same">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-4">
                                <div class="">
                                    {{ __("No")}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="no" name="is_address_same">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    </label>
                                </div>
                            </div>
                            <div id="owner_details" class="my-6 d-none">
                                <div class="mt-4">
                                    <input type="text" name="trading_addresss_1" class="form-control form-control-solid" placeholder="Address 1">
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="trading_addresss_2" class="form-control form-control-solid" placeholder="Address 2">
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="trading_city" class="form-control form-control-solid" placeholder="City">
                                </div>
                                <div class="mt-4">
                                    <input type="text" name="tradingr_postcode" class="form-control form-control-solid" placeholder="Postcode">
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="eleventh-btn-limited" class="btn btn-block btn-primary">{{__("Next") }}</button>
                                <button type="button" id="eleventh-back-limited" class="btn btn-block btn-outline">{{__("Go Back") }}</button>
                            </div>
                        </div>
                        <div id="twelfth-page-limited" class="d-none">
                            <h1 class="font-bold fs-3">Account Details Overview</h1>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Business Name</div>
                                                <div class="fs-6 c-name"></div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Company reg number</div>
                                                <div class="fs-6 c-reg"></div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Business type</div>
                                                <div class="fs-6 c-type"></div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5 ">Expected monthly spend</div>
                                                <div class="fs-6 ex-monthly"></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5 ">Registered Addresss</div>
                                                <div class="fs-6 reg-address">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="fw-boldest fs-5">Trading Addresss</div>
                                                <div class="fs-6 trading-address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div>
                                        <div class="fw-boldest text-brand fs-3 c-name">Business Name</div>
                                        <div class="officers"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check my-6">
                                <input class="form-check-input" type="radio" value="no" name="is_user_director">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    I declare that all information provided above is correct
                                </label>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="twelfth-back-limited" class="btn border-brand text-brand btn-outline">{{__("Go Back") }}</button>
                                <button type="button" id="twelfth-btn-limited" class="btn btn-primary">{{__("Yes, Let’s move") }}</button>
                            </div>
                        </div>
                        <div id="final-page" class="d-none">
                            <h1 class="font-bold fs-3">Well done! we’ve got every information. Next step is to verify your ID & selfie </h1>
                            <div class="mt-8 text-gray-500">
                                Our partners at sumsub will aid the next step
                            </div>
                            <div class="mt-4">
                                <input type="hidden" name="email" value="{{$user->email}}"/>
                                <input type="hidden" name="phone" value="{{$user->phone}}"/>
                                <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                <input type="hidden" name="country_code" value="{{$user->getCountry()->iso}}"/>

                                <button type="button" id="final-back" class="btn btn-block text-danger btn-outline">{{__("Oh No!") }}</button>
                                <button type="button" id="final-btn" class="btn btn-block btn-primary">
                                    {{__("I’m happy to continue") }} <img src="{{asset('asset/images/loader.gif')}}" width="20" class="spinnerz hide" />
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="sumsub-containerskkll"></div>
                </div>
            </div>
        </div>
    </div>



