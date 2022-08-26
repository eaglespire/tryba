@extends('userlayout')

@section('content')

<!--end::Header-->
<!--begin::Content-->
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
	<div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
		<!--begin::Info-->
		<div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
			<!--begin::Title-->
			<h1 class="text-dark fw-bolder my-1 fs-1">{{__('Welcome')}}, {{ ucwords(strtolower($user->business_name ?? $user->first_name)) }} 👋🏼</h1>
			<!--end::Title-->
			<!--begin::Breadcrumb-->
			<ul class="breadcrumb fw-bold fs-base my-1">
				<li class="breadcrumb-item text-dark">{{__('Dashboard')}}</li>
			</ul>
			<!--end::Breadcrumb-->
		</div>
		<!--end::Info-->
	</div>
</div>
<!--end::Toolbar-->
<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
	<!--begin::Container-->
	<div class="container" id="userTarget" data-uid="{{$user->id}}">
		@if($user->live==0)
		<div class="notice d-flex bg-white border rounded p-6 mb-8">
			<!--begin::Icon-->
			<!--begin::Svg Icon | path: icons/duotone/General/Shield-check.svg-->
			<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
				<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
					<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
					<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
				</svg>
			</span>
			<!--end::Svg Icon-->
			<!--end::Icon-->
			<!--begin::Wrapper-->
			<div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
				<!--begin::Content-->
				<div class="mb-3 mb-md-0 fw-bold">
					<h4 class="text-dark fw-bolder">{{__('Test Mode')}}</h4>
					<div class="fs-6 text-dark pe-7">{{__('Real time payment can\'t be received while account is in test mode.')}}</div>
				</div>
				<!--end::Content-->
				<!--begin::Action-->
				<a href="{{route('user.account.mode', ['id'=>1])}}" class="btn btn-light-primary px-6 align-self-center text-nowrap">{{__('Activate live mode')}}</a>
				<!--end::Action-->
			</div>
			<!--end::Wrapper-->
		</div>
		@endif
		<!--begin::Accordion-->
		<div class="accordion accordion-icon-toggle mb-8" id="kt_accordion_1">
			@if($user->phone_verify==0)
			<div class="accordion-item">
				<h2 class="accordion-header" id="kt_accordion_1_header_2">
					<button class="accordion-button fs-5 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_2">
						<div class="symbol symbol-35px me-4">
							<span class="symbol-label">
								<i class="fal fa-phone-alt text-indigo"></i>
							</span>
						</div>
						{{__('Mobile number is not yet verified')}}
					</button>
				</h2>
				<div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
					<div class="accordion-body">
						<p class="text-dark fs-6 fw-bold pt-4 mb-4"> {{__('We need to verify your mobile number')}} {{$user->phone}}.</p>
						<a class="btn btn-light btn-sm fs-7 btn-color-dark fw-boldest px-5 dummy-dd" href="{{route('user.phone.authorization')}}">{{__('Click here')}}</a>
					</div>
				</div>
			</div>
			@endif
			@if($user->kyc_verif_status==null || $user->kyc_verif_status=="DECLINED" || $user->kyc_verif_status=="PENDING" || $user->kyc_verif_status=="RESUBMIT")
				<!--begin::Notice-->
				<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">
					<!--begin::Icon-->
					<!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
					<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
							<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
							<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
						</svg>
					</span>
					<!--end::Svg Icon-->
					<!--end::Icon-->
					<!--begin::Wrapper-->
					<div class="d-flex flex-stack flex-grow-1">
						<!--begin::Content-->
						<div class="fw-bold">
							<h4 class="text-dark fw-bolder">{{__('We need more information about you')}}</h4>
							@if($user->kyc_verif_status=="PENDING" || $user->kyc_verif_status=="")
								<div class="fs-6 text-dark">{{__('Compliance is currently due, please update your account information to avoid restrictions such as no access to storefront service.')}}</div>
							@elseif($user->kyc_verif_status=="DECLINED")
							<div class="fs-6 text-dark">{{__('Sorry, Your Compliance verification was declined, please ensure to use valid information.')}}</div>
							@elseif($user->kyc_verif_status=="RESUBMIT")
							<div class="fs-6 text-dark"> {{__('Sorry, Your Compliance verification requires re-submission, please ensure to use valid information.')}}</div>
							@endif
							<a class="btn btn-light btn-sm fs-7 btn-color-dark fw-boldest px-5 mt-3" href="javascript:;" id="verifyKyck" data-toggle="modal" data-target="#verificationModal" data-backdrop="static">
								{{__('Click here')}} {{--<img src="{{asset('asset/images/loader.gif')}}" width="20" class="spinner" />--}}
							</a>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Notice-->
			@endif
			@if($user->kyc_verif_status=="PROCESSING")
				<!--begin::Notice-->
				<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">
					<!--begin::Icon-->
					<!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
					<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
							<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
							<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
						</svg>
					</span>
					<!--end::Svg Icon-->
					<!--end::Icon-->
					<!--begin::Wrapper-->
					<div class="d-flex flex-stack flex-grow-1">
						<!--begin::Content-->
						<div class="fw-bold">
							<h4 class="text-dark fw-bolder">{{__('Compliance is Processing')}}</h4>
							<div class="fs-6 text-dark">{{__('Compliance is currently being processed.')}}</div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Notice-->
			@endif
			@if($user->kyc_verif_status=="SUBMITTED")
				<!--begin::Notice-->
				<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">
					<!--begin::Icon-->
					<!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
					<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
							<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
							<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
						</svg>
					</span>
					<!--end::Svg Icon-->
					<!--end::Icon-->
					<!--begin::Wrapper-->
					<div class="d-flex flex-stack flex-grow-1">
						<!--begin::Content-->
						<div class="fw-bold">
							<h4 class="text-dark fw-bolder">{{__('We are currently reviewing your compliance')}}</h4>
							<div class="fs-6 text-dark">{{__('Compliance has been submitted and is currently being processed.')}}</div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Notice-->
			@endif
		@if($user->dispute==1)
		<div class="accordion-item">
			<h2 class="accordion-header" id="kt_accordion_1_header_4">
				<button class="accordion-button fs-5 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_4" aria-expanded="true" aria-controls="kt_accordion_1_body_4">
					<div class="symbol symbol-35px me-4">
						<span class="symbol-label">
							<i class="fal fa-user-headset text-indigo"></i>
						</span>
					</div>
					{{__('Resolve Disputes on your account')}}
				</button>
			</h2>
			<div id="kt_accordion_1_body_4" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_4" data-bs-parent="#kt_accordion_1">
				<div class="accordion-body">
					<p class="text-dark fs-6 fw-bold pt-4 mb-4"> {{__('A dispute has been raised against your account, you can\'t receive payment until the dispute is resolved')}}</p>
				</div>
			</div>
		</div>
		@endif
	</div>
	<!--end::Accordion-->

	<div class="row g-xl-8">
		<!--begin::Col-->
		<div class="col-xxl-12">
			<!--begin::Row-->
			<div class="row g-xl-8 card-wrapper">
				<!--begin::Col-->
			    <div class="col-xl-4 col-md-5 col-lg-6 col-12">
					<div class="card account-card card-xl-stretch mb-5 mb-xl-8 tryba-card-white">
						<!--begin::Body-->
						<div class="card-body p-0 d-flexs justify-content-betweens">
							<div class="card-pp">
								<div class="text-start">
									<span class="account-figure" id="accountBalance">£{{ number_format($user->gBPAccount()->balance ?? 0, 2) }}</span>
									<span class="balance">Balance</span>
								</div>
							</div>
							<!--begin::Chart-->
							<div class="card-rounded-bottom text-center ">
								<span class="account-text">Account Number / Sort Code</span>
								<span class="account-number" id="bankAccountNumber">{{$user->gBPAccount()->accountNumber ?? '000000'}} / {{$user->gBPAccount()->sortCode ?? '00-00-00'}}</span>
							</div>
							<!--end::Chart-->
						</div>
						<div class="card-footer">
							<a href="javascript:void;" id="addMoney" class="btn btn-light-info btn-sm me-2">Add Money
							</a>
							<a href="javascript:void;" id="sendMoney" class="btn btn-light-info btn-sm">Send Money
							</a>
						</div>
					</div>
				</div>
				<!--end::Col-->

				<!--begin::Col-->
				<div class="col-xl-4 col-md-5 col-lg-6 col-12">
					@if($user->cards && $user->cards->count() > 0 && $user->physicalCard() !== null && ($user->physicalCard()->c_status !== 'BLOCKED' || $user->physicalCard()->c_status !== 'SUBMITTED'))

                        <div class="card card-xl-stretch mb-5 mb-xl-8 tryba-card card-back" id="tryba-card-back">
                            <h4>Manage Card</h4>
                            <div class="card-row-md" style="display: none">
                                @if ($user->physicalCard()->c_status === 'ACTIVE' || $user->physicalCard()->c_status === 'CREATED')
                                    <a href="javascript:;" class="freezeCard" data-action="freeze" data-cid="{{ $user->physicalCard()->c_id ?? null}}">
                                        <i class="fa fa-key"></i>
                                        <span>Freeze card</span>
                                    </a>
                                @elseif ($user->physicalCard()->c_status === 'SUSPENDED')
                                    <a href="javascript:;" class="freezeCard" data-action="unfreeze" data-cid="{{ $user->physicalCard()->c_id ?? null }}">
                                        <i class="fa fa-key"></i>
                                        <span>Activate</span>
                                    </a>
                                @endif
                                <a href="javascript:;" class="cardItem" data-type="details" data-cid="{{$user->physicalCard()->c_id ?? null}}">
                                    <i class="fa fa-credit-card"></i>
                                    <span>Card details</span>
                                </a>
                                <a href="javascript:;" class="freezeCard" data-action="block" data-cid="{{ $user->physicalCard()->c_id ?? null}}">
                                    <i class="fa fa-lock"></i>
                                    <span>Block</span>
                                </a>
                            </div>
                        </div>
                        <div class="card card-xl-stretch mb-5 mb-xl-8 tryba-card card-front" id="tryba-card-primary">
                            <div class="card-row">
                                @if ($user->physicalCard()->c_status === 'CREATED')
                                    <a href="javascript:;" id="activateCard" data-cid="{{ $user->physicalCard()->c_id }}" class="card-status active-card">
                                        Activate <img src="{{asset('asset/images/loader.gif')}}" width="15" class="spinner" style="display: none;" />
                                    </a>
                                @endif
                                <img src="{{asset('/images/card/logo.png')}}" width="70" class="logo" />
                                <h5 class="v-card-text"> Debit</h5>
                            </div>
                            <img src="{{asset('/images/card/hologram.png')}}" class="hologram" width="35" />
                            <img src="{{asset('/images/card/arrow.png')}}" class="arrow" width="20" />
                            <div class="card-row-sm card--number">
                                <div class="card-label ">
                                    <h5 class="accNum" id="accNum">{{ $user->physicalCard()->pan ?? null}}</h5>
                                </div>
                            </div>
                            <div class="valid-thru">
                                <small>valid thru</small><span>12/24</span>
                            </div>
                            <div class="card-holder">
                                <h5>{{$user->last_name.' '.$user->first_name}}</h5>
                            </div>
                            <img src="{{asset('/images/card/visa.png')}}" class="brand-logo" />
                        </div>
                    @else
                        <div class="card card-xl-stretch mb-5 mb-xl-8 tryba-card card-empty" id="tryba-card-back">
                            <h4>Get a Physical Card</h4>
                            @if($user->cards->count() > 0 && $user->physicalCard() != null && $user->physicalCard()->c_status === 'BLOCKED')
                                <div class="text-danger">
                                    Card is <strong>BLOCKED</strong>
                                </div>
                                <div class="card-row-md">
                                    <a href="javascript:;" class="getCard" id="getCards" data-type="Physical">
                                        <i class="fa fa-plus"></i>
                                        <span id="loaderMsg">Request Card</span>
                                    </a>
                                </div>
                            @elseif($user->cards->count() > 0 && $user->physicalCard() != null && $user->physicalCard()->c_status === 'SUBMITTED')
                                <div class="text-info">
                                    Request <strong>SUBMITTED</strong>
                                </div>
                                <div class="card-row-md">
                                    <p>Your card request was submmited and will be made avaible in 10 minutes.</p>
                                </div>
                            @else
                                <div class="card-row-md">
                                    <a href="javascript:;" class="getCard" id="getCards" data-type="Physical">
                                        <i class="fa fa-plus"></i>
                                        <span id="loaderMsg">Request Card</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
				</div>
				<!--end::Col-->

				<!--begin::Col-->
				<div class="col-xl-4 col-md-5 col-lg-6 col-12">
					@if($user->cards && $user->cards->count() > 0 && $user->virtualCard() !== null && $user->virtualCard()->c_status !== 'BLOCKED')
                        <div class="card card-xl-stretch mb-5 mb-xl-8 tryba-card card-back" id="tryba-card-back">
                            <h4>Manage Card</h4>
                            <div class="card-row-md" style="display: none">
                                @if ($user->virtualCard()->c_status === 'ACTIVE')
                                    <a href="javascript:;" class="freezeCard" data-action="freeze" data-cid="{{ $user->virtualCard()->c_id ?? null}}">
                                        <i class="fa fa-key"></i>
                                        <span>Freeze card</span>
                                    </a>
                                @elseif ($user->virtualCard()->c_status === 'SUSPENDED')
                                    <a href="javascript:;" class="freezeCard" data-action="unfreeze" data-cid="{{ $user->virtualCard()->c_id ?? null }}">
                                        <i class="fa fa-key"></i>
                                        <span>Activate</span>
                                    </a>
                                @endif
                                <a href="javascript:;" class="cardItem" data-type="details" data-cid="{{$user->virtualCard()->c_id ?? null}}">
                                    <i class="fa fa-credit-card"></i>
                                    <span>Card details</span>
                                </a>
                                <a href="javascript:;" class="freezeCard" data-action="block" data-cid="{{ $user->virtualCard()->c_id ?? null}}">
                                    <i class="fa fa-lock"></i>
                                    <span>Block</span>
                                </a>
                            </div>
                        </div>
                        <div class="card card-xl-stretch mb-5 mb-xl-8 tryba-card card-front" id="tryba-card-secondary">
                            <div class="card-row">
                                <img src="{{asset('/images/card/logo.png')}}" width="70" class="logo" />
                                <h5 class="v-card-text">Virtual</h5>
                            </div>
                            <img src="{{asset('/images/card/hologram.png')}}" class="hologram" width="35" />
                            <img src="{{asset('/images/card/arrow.png')}}" class="arrow" width="20" />
                            <div class="card-row-sm card--number">
                                <div class="card-label">
                                    <h5 class="accNum" id="accNum">{{$user->virtualCard()->pan}}</h5>
                                </div>
                            </div>
                            <div class="valid-thru">
                                <small>valid thru</small><span>12/24</span>
                            </div>
                            <div class="card-holder">
                                <h5>{{$user->last_name.' '.$user->first_name}}</h5>
                            </div>
                            <h5 class="limited-use">Limited use</h5>
                            <img src="{{asset('/images/card/visa.png')}}" class="brand-logo" />
                        </div>
					@else
                        <div class="card card-xl-stretch mb-5 mb-xl-8 tryba-card card-empty" id="tryba-card-back">
                            <h4>Get a Digital Card</h4>
                            @if($user->cards && $user->cards->count() > 0 && $user->virtualCard()->c_status === 'BLOCKED')
                                <div class="text-danger">
                                    Card is <strong>BLOCKED</strong>
                                </div>
                            @endif
                                <div class="card-row-md">
                                    <a href="javascript:;" class="getCard" id="getCard" data-type="Virtual">
                                        <i class="fa fa-plus"></i>
                                        <span id="loaderMsg">Request Card</span>
                                    </a>
                                </div>
                        </div>
					@endif
				</div>
				<!--end::Col-->

			</div>
			<!--end::Row-->
		</div>
		<!--end::Col-->
	</div>

	<div class="row g-xl-8">
		<!--begin::Col-->
		<div class="col-xxl-12">
			<!--begin::Row-->
			<div class="row g-xl-8">
				<!--begin::Col-->
				<div class="col-xl-4">
					<!--begin::Chart Widget 1-->
					<div class="card card-xl-stretch mb-5 mb-xl-8">
						<!--begin::Body-->
						<div class="card-body p-0 d-flex justify-content-between flex-column">
							<div class="d-flex flex-stack card-p flex-grow-1">
								<!--begin::Icon-->
								<div class="symbol symbol-45px">
									<div class="symbol-label">
										<i class="fal fa-sync text-primary"></i>
									</div>
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
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-xl-4">
					<!--begin::Slider Widget 1-->
					<div class="card card-xl-stretch mb-5 mb-xl-8  bg-info">
						<!--begin::Body-->
						<div class="card-body pt-5">
							<div id="kt_stats_widget_8_carousel" class="carousel carousel-custom carousel-stretch slide" data-bs-ride="carousel" data-bs-interval="8000">
								<!--begin::Heading-->
								<div class="d-flex flex-stack flex-wrap">
									<span class="fs-4 text-white fw-boldest pe-2">{{__('Receive Payment')}}</span>
									<!--begin::Carousel Indicators-->
									<ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
										<li data-bs-target="#kt_stats_widget_8_carousel" data-bs-slide-to="0" class="ms-1 active"></li>
										<li data-bs-target="#kt_stats_widget_8_carousel" data-bs-slide-to="1" class="ms-1"></li>
										<li data-bs-target="#kt_stats_widget_8_carousel" data-bs-slide-to="2" class="ms-1"></li>
									</ol>
									<!--end::Carousel Indicators-->
								</div>
								<!--end::Heading-->
								<!--begin::Carousel-->
								<div class="carousel-inner pt-6">
									<!--begin::Item-->
									<div class="carousel-item active">
										<div class="carousel-wrapper">
											<div class="d-flex flex-column justify-content-between flex-grow-1">
												<div class="fs-2 text-white text-hover-primary fw-boldest">{{__('Gigpot')}}</div>
												<p class="text-white fs-6 fw-bold pt-4 mb-0">{{__('Send payment links to friends, co-workers, family for a specific event of gig.')}}</p>
											</div>
											<!--begin::Info-->
											<div class="d-flex flex-stack pt-8">
												<a href="{{route('user.sclinks')}}" class="btn btn-light btn-sm btn-color-dark fs-7 px-5">{{__('Create Payment Link')}}</a>
											</div>
											<!--end::Info-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="carousel-item">
										<div class="carousel-wrapper">
											<!--begin::Title-->
											<div class="d-flex flex-column justify-content-between flex-grow-1">
												<div class="fs-2 text-white text-hover-primary fw-boldest">{{__('Invoice')}}</div>
												<p class="text-white fs-6 fw-bold pt-4 mb-0">{{__('Create & issue customers invoice with reminders, social sharing, QR code.')}}</p>
											</div>
											<!--end::Title-->
											<!--begin::Info-->
											<div class="d-flex flex-stack pt-8">
												<a href="{{route('user.invoice')}}" class="btn btn-light btn-sm btn-color-dark fs-7 px-5">{{__('Create Invoice')}}</a>
											</div>
											<!--end::Info-->
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="carousel-item">
										<div class="carousel-wrapper">
											<!--begin::Title-->
											<div class="d-flex flex-column justify-content-between flex-grow-1">
												<div class="fs-2 text-white text-hover-primary fw-boldest">{{__('Website')}}</div>
												<p class="text-white fs-6 fw-bold pt-4 mb-0">{{__('Sell products & services on a single multipurpose and functional website.')}}</p>
											</div>
											<!--end::Title-->
											<!--begin::Info-->
											<div class="d-flex flex-stack pt-8">
												<a href="{{ route('user.storefront') }}" class="btn btn-light btn-sm btn-color-dark fs-7 px-5">{{__('Create Website')}}</a>
											</div>
											<!--end::Info-->
										</div>
									</div>
									<!--end::Item-->
								</div>
								<!--end::Carousel-->
							</div>
						</div>
						<!--end::Body-->
					</div>
					<!--end::Slider Widget 1-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-xl-4">
					<!--begin::Slider widget 2-->
					<div class="card card-xl-stretch mb-5 mb-xl-8 bg-primary">
						<!--begin::Body-->
						<div class="card-body pt-5">
							<!--begin::Carousel-->
							<div id="kt_stats_widget_9_carousel" class="carousel carousel-custom carousel-stretch slide" data-bs-ride="carousel" data-bs-interval="8000">
								<!--begin::Nav-->
								<div class="d-flex flex-stack flex-wrap">
									<span class="text-white fw-boldest fs-4 pe-2">{{__('Statistics')}}</span>
									<!--begin::Carousel Indicators-->
									<ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
										<li data-bs-target="#kt_stats_widget_9_carousel" data-bs-slide-to="0" class="ml-1 active"></li>
										<li data-bs-target="#kt_stats_widget_9_carousel" data-bs-slide-to="1" class="ml-1"></li>
										<li data-bs-target="#kt_stats_widget_9_carousel" data-bs-slide-to="2" class="ml-1"></li>
									</ol>
									<!--end::Carousel Indicators-->
								</div>
								<!--end::Nav-->
								<!--begin::Items-->
								<div class="carousel-inner pt-8">
									<!--begin::Item-->
									<div class="carousel-item active">
										<div class="carousel-wrapper">
											<!--begin::Title-->
											<div class="flex-grow-1">
												<div class="fs-2 text-white text-hover-primary fw-boldest">{{__('Successful Transactions')}}</div>
												<p class="text-white fs-1 fw-boldest pt-5 mb-0">{{$currency->symbol}} {{number_format($user->successTransactions(), 2)}}</p>
											</div>
											<!--end::Title-->
											<div class="d-flex flex-stack pt-7">
												<a href="{{route('user.transactions')}}" class="btn btn-light btn-sm fs-7 btn-color-dark px-5">{{__('Transactions')}}</a>
											</div>
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="carousel-item">
										<div class="carousel-wrapper">
											<!--begin::Title-->
											<div class="flex-grow-1">
												<div class="fs-2 text-white text-hover-primary fw-boldest">{{__('Pending Transactions')}}</div>
												<p class="text-white fs-1 fw-boldest pt-5 mb-0">{{$currency->symbol}} {{number_format($user->pendingTransactions(), 2)}}</p>
											</div>
											<!--end::Title-->
											<div class="d-flex flex-stack pt-7">
												<a href="{{route('user.transactions')}}" class="btn btn-light btn-sm fs-7 btn-color-dark px-5">{{__('Transactions')}}</a>
											</div>
										</div>
									</div>
									<!--end::Item-->
									<!--begin::Item-->
									<div class="carousel-item">
										<div class="carousel-wrapper">
											<!--begin::Title-->
											<div class="flex-grow-1">
												<div class="fs-2 text-white text-hover-primary fw-boldest">{{__('Failed Transactions')}}</div>
												<p class="text-white fs-1 fw-boldest pt-5 mb-0">{{$currency->symbol}} {{number_format($user->failedTransactions(), 2)}}</p>
											</div>
											<!--end::Title-->
											<div class="d-flex flex-stack pt-7">
												<a href="{{route('user.transactions')}}" class="btn btn-light btn-sm fs-7 btn-color-dark px-5">{{__('Transactions')}}</a>
											</div>
										</div>
									</div>
									<!--end::Item-->
								</div>
								<!--end::Items-->
							</div>
							<!--end::Carousel-->
						</div>
						<!--end::Body-->
					</div>
					<!--end::Slider widget 2-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
		</div>
		<!--end::Col-->
	</div>
	<!--end::Row-->
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
								<!--begin:: Avatar -->
								<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
									<div class="symbol-label fs-3 bg-light-primary text-primary">{{ucwords(substr($val->user->first_name,0,1))}}</div>
								</div>
								<!--end::Avatar-->
								<!--begin::User details-->
								<div class="d-flex flex-column">
									<span>{{$val->user->first_name.' '.$val->user->last_name}}</span>
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
                                @endif
							</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{ucwords($val->payment_type)}}</td>
							<td data-bs-toggle="modal" data-bs-target="#trans_share{{$val->id}}">{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</td>
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
		@foreach(getFiveTrx($user->id, $user->live) as $val)
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
	@if(count($user->storefrontCount())>0 && $user->website != null)
	<div class="card mb-6">
		<div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<h3 class="fw-boldest text-dark fs-6x">{{__('Share')}}</h3>
					<p class="text-dark-400 fw-bold fs-5">{{__('Share website with friends, family & customers')}}</p>
					<div class="mx-auto">
						<div class="mb-10">
							<div class="d-flex mb-2">
								<input type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{route('website.link', ['id' => $user->website->websiteUrl])}}">
								<button data-clipboard-text="{{route('website.link', ['id' => $user->website->websiteUrl])}}" class="castro-copy btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light">
									<span class="svg-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
											<path d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z" fill="#B5B5C3" />
										</svg>
									</span>
								</button>
							</div>
						</div>
						<div class="d-flex">
							<a target="_blank" href="mailto:?body=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-light-primary w-100">
								{{__('Send Email')}}</a>
							<a target="_blank" href="https://wa.me/{{$user->storefront()->phone}}/?text=Hi there! I am using tryba.io to take payments. All you need to do is click the link, make payment with card or account and voila! Thanks! {{route('website.link', ['id' => $user->storefront()->store_url])}}" class="btn btn-success mx-6 w-100">
								{{__('Whatsapp')}}</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="text-center px-5 mt-8">
						<span class="fs-6 fw-bold text-gray-800 d-block mb-2">{{__('Scan QR code or Share using')}}</span>
						{!! QrCode::eye('circle')->style('round')->size(150)->generate(route('website.link', ['id' => $user->storefront()->store_url])); !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="card mb-6 mb-xl-9">
		<!--begin::Card body-->
		<div class="card-body">
			<!--begin::Row-->
			<div class="row">
				<!--begin::Col-->
				<div class="col-lg-12">
					@if($user->plan_expired == 0)
						<h2 class="fw-boldest mb-1 text-dark">{{__('Active until')}} {{date("M d, Y", strtotime($user->plan_expiring))}}</h2>
						<p class="text-dark fw-bold mb-0">{{__('Tryba’s dynamic pricing system method of subscription is an intelligent AI that automatically upgrade or downgrade your subscription based on transaction volume.Tryba’s dynamic pricing system method of subscription is an intelligent AI that automatically upgrade or downgrade your subscription based on transaction volume.')}}</p>
					@else
						<h2 class="fw-boldest mb-1 text-dark">You have no active subscription.</h2>
						<p class="text-dark fw-bold mb-6 mb-lg-15">{{__('You subscription expired on ')}}{{date("M d, Y", strtotime($user->plan_expiring))}}.</p>
					@endif
                    @if($user->plan != null)
                        <h3 class="fs-3 fw-bold my-4">
                            <span class="text-gray-800 fw-boldest me-1">{{ view_currency($user->plan->currency_id).number_format($user->plan->amount, 2)}}</span>
                            <span class="text-gray-600">{{__('Per Month')}}</span>
                        </h3>
                    {{-- @else
                        <h3 class="fs-3 fw-bold my-4">
                            <span class="text-gray-800 fw-boldest me-1">{{ view_currency($user->plan->currency_id).number_format($user->plan->amount, 2)}}</span>
                            <span class="text-gray-600">{{__('Per Month')}}</span>
                        </h3> --}}
                    @endif

					<!--begin::Text-->
                    @if($user->plan != null)
                        <div class="d-flex text-muted fw-boldest fs-4 mt-5 pb-3">
                            <span class="flex-grow-1 text-dark">{{__('Income')}}</span>
                            <span class="text-gray-800">{{ $currency->symbol . number_format(successMonthlyTransactions()) }} {{__('of')}} {{view_currency($user->plan->currency_id) . number_format($user->plan->annualendPrice)}}</span>
                        </div>
                    @endif
					<!--end::Text-->
					<!--begin::Progress-->
					<div class="progress h-8px bg-light-primary mb-3">
						@if($user->plan != null && $user->plan_transactions != null)
						<div class="progress-bar bg-primary" role="progressbar" style="width: {{ successMonthlyTransactions()/$user->plan->annualendPrice * 100}}%" aria-valuenow="{{ $user->used_transactions/$user->plan->annualendPrice * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
						@else
						<div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
						@endif
					</div>
					<!--end::Progress-->
					<!--begin::Description-->
                    @if($user->plan != null)
                        @if($user->plan->annualendPrice - successMonthlyTransactions() > 0)
                            <p class="text-dark fw-bold mb-6 mb-lg-15">{{ $currency->symbol . number_format($user->plan->annualendPrice - successMonthlyTransactions()) }} {{__('remaining until your plan requires renewal')}}</p>
                        @else
                            <p class="text-dark fw-bold mb-6 mb-lg-15">{{__('Your plan  will automatically be upgraded to')}} {{ ucwords(getNextSubscriptionPlan($user->plan->id +1 )->type) }} plan</p>
                        @endif
                    @endif
						<!--end::Description-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-6">
                            @if ($user->plan != null)
                                <!--begin::Text-->
                                <div class="d-flex text-muted fw-boldest fs-4 pb-3">
                                    <span class="flex-grow-1 text-dark">{{__('Email Limit using Tryba SMTP')}}</span>
                                    <span class="text-gray-800">{{$user->used_email}} {{__('of')}} {{ $user->plan->email_limit }}</span>
                                </div>
                                <!--end::Text-->
                            @endif
							<!--begin::Progress-->
							<div class="progress h-8px bg-light-primary mb-3">
								@if($user->email_limit!=null)
									<div class="progress-bar bg-primary" role="progressbar" style="width:{{ ($user->used_email) ? $user->used_email/$user->plan->email_limit * 100 : 0}}%" aria-valuenow="{{ ($user->used_email) ? $user->used_email/$user->plan->email_limit * 100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
								@else
								<div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								@endif
							</div>
							<!--end::Progress-->
                            @if($user->plan != null)
							    <p class="text-dark fw-bold mb-6 mb-lg-15">{{$user->plan->email_limit - $user->used_email}} {{__('remaining until your plan upgrade.')}} <a href="#" data-bs-toggle="modal" data-bs-target="#buyMore"class="btn-link">Click here</a> to buy more</p>
							@endif
                            <!--begin::Text-->
						</div>
						<div class="col-lg-6">
                            @if($user->plan != null)
                                <div class="d-flex text-muted fw-boldest fs-4 pb-3">
                                    <span class="flex-grow-1 text-dark">{{__('SMS')}}</span>
                                    <span class="text-gray-800">{{ $user->used_sms }} {{__('of')}} {{ $user->plan->sms_limit }}</span>
                                </div>
                                <!--end::Text-->
                            @endif
							<!--begin::Progress-->
							<div class="progress h-8px bg-light-primary mb-3">
								@if($user->sms_limit!=null)
									<div class="progress-bar bg-primary" role="progressbar" style="width:{{ ($user->used_sms > 1) ? $user->used_sms/$user->plan->sms_limit * 100 : 0}}%" aria-valuenow="{{ ($user->used_sms > 1) ? $user->used_sms/$user->plan->sms_limit * 100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
								@else
									<div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								@endif
							</div>
							<!--end::Progress-->
							<!--begin::Description-->
                            @if($user->plan != null)
                                <p class="text-dark fw-bold mb-6 mb-lg-15">{{$user->plan->sms_limit - $user->used_sms}} {{__('remaining until your plan upgrade.')}} <a href="#" data-bs-toggle="modal" data-bs-target="#buyMoreSMS"class="btn-link">Click here</a> to buy more</p>
							@endif
                            <!--end::Description-->
						</div>
					</div>
				</div>
				<!--end::Col-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
		</div>
		<!--end::Card body-->
	</div>
	<!--begin::Row-->
	<!--end::Row-->
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="buyMore" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mccModalCenterTitle">Buy Email</h5>
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
				<form action="#" id="emailBuy" method="POST" >
					@csrf
					@method('post')
					<p id="messageEmail" class="alert mb-3 d-none"></p>
					<div class="form-group mt-2">
						<input type="number" name="quantityEmail" min="1" value="1" id="quantityEmail" required placeholder="How many emails?" class="form-control form-control-solid p-4" />
					</div>
					<div class="input-group input-group-solid mt-4">
						<span class="input-group-prepend">
						  <span class="input-group-text">Amount ({{ getUserCurrencyName($user) }})</span>
						</span>
						<input type="number" id="amountEmail" readonly name="amountEmail" value="{{ getEmailPricePerUnit() }}" class="form-control form-control-lg form-control-solid" placeholder="{{__('Amount')}}">
					</div>
					<div class="form-group mt-4 ">
						<button type="submit" class="btn btn-primary form-control" >
							<div class="spinner-border text-light d-none" id="spinnerEmail" role="status" style="width: 1.5rem; height: 1.5rem;">
								<span class="visually-hidden">Loading...</span>
							</div>
							<span id="buyemail">Buy</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="buyMoreSMS" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mccModalCenterTitle">Buy SMS</h5>
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
				<form action="#" id="smsBuy" method="POST" >
					@csrf
					@method('post')
					<p id="messageSMS" class="alert mb-3 d-none"></p>
					<div class="form-group mt-2">
						<input type="number" name="quantitySMS" min="1" value="1" id="quantitySMS" required placeholder="How many SMS?" class="form-control form-control-solid p-4" />
					</div>
					<div class="input-group input-group-solid mt-4">
						<span class="input-group-prepend">
						  <span class="input-group-text">Amount ({{ getUserCurrencyName($user) }})</span>
						</span>
						<input type="number" id="amountSMS" readonly name="amountSMS" value="{{ getSMSPricePerUnit() }}" class="form-control form-control-lg form-control-solid" placeholder="{{__('Amount')}}">
					</div>
					<div class="form-group mt-4 ">
						<button type="submit" class="btn btn-primary form-control">
							<div class="spinner-border text-light d-none" id="spinnerSMS" role="status" style="width: 1.5rem; height: 1.5rem;">
								<span class="visually-hidden">Loading...</span>
							</div>
							<span id="buysms">Buy</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- MCC Modal -->
	@if($user->mcc == null)
		<div class="modal fade" data-backdrop="static" data-keyboard="false" id="mccModal" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="mccModalCenterTitle">What service do you provide?</h5>
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
						<form action="{{ route('user.mcc.update', $user->id) }}" method="POST" >
							@csrf
							@method('PUT')
							<input type="hidden" name="user_id" value="{{ $user->id }}" />
							<div class="form-group">
								<select class="form-select select  @if ($errors->has('mcc'))is-invalid @endif" id="mcc" name="mcc" required>
									<option value="">{{__('What service do you provide?')}}</option>
									@foreach(getMcc() as $val)
									<option value="{{$val->id}}">{{$val->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group mt-3 ">
								<button type="submit" class="btn btn-primary form-control">
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endif

	<!-- Card Creation modal -->
	<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="cardModalCenterTitle">Debit Card Creation</h5>
					<div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
						<span class="svg-icon svg-icon-2x">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
							</svg>
						</span>
					</div>
				</div>
				<div class="modal-body">
					<div>
						<form action="{{ route('user.card.create') }}" method="POST">
							@csrf
							<div class="row">
								<input type="hidden" name="user_id" value="{{ $user->id }}" />
								<input type="hidden" name="first_name" value="{{ $user->first_name }}" />
								<input type="hidden" name="last_name" value="{{ $user->last_name }}" />
								<input type="hidden" name="email" value="{{ $user->email }}" />
								<input type="hidden" name="phone" value="{{ $user->phone }}" />
								<input type="hidden" name="dob" value="{{ $user->dob ?? null }}" />
								<input type="hidden" name="accountId" value="{{ $user->gBPAccount()->accountId ?? null }}" />
								<div class="form-group">
									<input type="text" name="card_type" id="card_type" placeholder="Card Type" class="form-control @error('card_type') is-invalid @enderror" readonly/>
								</div>
								<div class="form-group mt-2">
									<select id="kba_question" name="kba_question" class="form-control @error('kba_question') is-invalid @enderror" required>
										<option value="">Select KBA Question</option>
										<option value="FIRST_PET_NAME">First Pet Name</option>
										<option value="FIRST_CAR">First Car</option>
										<option value="CITY_PARENTS_MET">City Parents Met</option>
										<option value="CITY_PARENTS_MET">Favourite Childhood Friend</option>
										<option value="MATERNAL_GRANDMOTHER_MAIDEN_NAME">Maternal Grandmother's Maiden Name</option>
									</select>
								</div>
								<div class="form-group mt-2">
									<input type="text" name="kba_answer" id="kba_answer" required placeholder="KBA Answer" value="{{ old('kba_answer') }}" class="form-control @error('kba_answer') is-invalid @enderror"/>
								</div>
								<div class="form-group mt-3">
									<button type="submit" class="btn btn-primary form-control">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	{{-- <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Tryba Compliance Verification</h5>
					<a href="javascript:;" class="close text-danger" id="closeModal" data-dismiss="modal" aria-label="Close" style="font-size: 32px !important;">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div id="sumsub-websdk-container"></div>
				</div>
			</div>
		</div>
	</div> --}}
	<!--end::Content-->
	<div class="modal fade" id="waitlist" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Join the waitlist')}}</h3>
					<div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
						<span class="svg-icon svg-icon-2x">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
							</svg>
						</span>
					</div>
				</div>
				<div class="modal-body py-10">
					<p>Thank you for joining tryba’s waitlist for business account and card.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Verification -->
	{{-- <div class="modal fade" id="verificationModal" tabindex="-1"  role="dialog" aria-labelledby="verificationModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centereds" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-slim">
					<h4 class="modal-title" id="exampleModalCenterTitle">Account Opening</h4>
					<a href="javascript:;" class="close text-danger" id="closeMsodal" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
                    <form enctype="multipart/form-data" id="verifForm">
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        <h4>Government regulations require us to know more about your business</h4>
                        <p>Information required</p>
                        <ul class="form-requirements">
                            <li>
                                <i class="fas fa-user-circle"></i> Full business information
                            </li>
                            <li>
                                <i class="fas fa-credit-card"></i> Valid ID
                            </li>
                            <li>
                                <i class="fas fa-camera"></i> Selfie
                            </li>
                        </ul>
                        <div class="mt-4 mb-4">
                            <button type="button" class="btn form-control btn-lg">Continue</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- Modal Verification -->
	<div class="modal fade" id="verificationModal" tabindex="-1"  role="dialog" aria-labelledby="verificationModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Tryba Compliance Verification</h5>
					<a href="javascript:;" class="close text-danger" id="closeMsodal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 32px !important;">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div id="sumsub-container"></div>
                    {{-- @if ($user->verif_details_submitted !== "YES")
                    @endif --}}
                    <form enctype="multipart/form-data" id="verifForm">
                        {{-- @csrf --}}
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        <div class="row mt-3">
                            <div class="col-lg-6 mt-2">
                                <label>Select Busniess Type</label>
                                <select name="business_type" class="form-control">
                                    <option value="">Select Business</option>
                                    <option value="SOLETRADER">Self Employed</option>
                                    <option value="LLC">LLC - Limited Company</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>Business Name</label>
                                <input type="text" class="form-control" placeholder="Business Name" value="{{ old('business_name') }}" name="business_name" required/>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>Company Registration Number</label>
                                <input type="text" class="form-control" placeholder="Company Registration Number" value="{{ old('company_reg_number') }}" name="company_reg_number" required/>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="company_regNumber">Select Business Category</label>
                                <select name="industry_code" class="form-control form-control-lg" required>
                                    <option value="">Select Category</option>
                                    <option value="I">Accomodation and food services</option>
                                    <option value="N">Administrative and support services</option>
                                    <option value="A">Agriculture, forestry and fishing</option>
                                    <option value="R">Arts, entertainment and recreation</option>
                                    <option value="F">Construction</option>
                                    <option value="P">Education</option>
                                    <option value="D">Electricity, gas, steam and air conditioning</option>
                                    <option value="K">Financial and insurance services</option>
                                    <option value="Q">Human health and social work</option>
                                    <option value="J">Information and communication</option>
                                    <option value="C">Manufacturing</option>
                                    <option value="B">Mining and quarrying</option>
                                    <option value="X">Online gambling or adult entertainment</option>
                                    <option value="S">Retail and other services</option>
                                    <option value="M">Professional, scientific and technical services</option>
                                    <option value="O">Public administration and defence</option>
                                    <option value="L">Real estate</option>
                                    <option value="H">Transport and logistics</option>
                                    <option value="E">Water supply, sewerage and waste management</option>
                                    <option value="G">Wholesale and retail trade; vehicle repair</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" placeholder="Date of Birth" value="{{ old('dob') }}" name="dob" required/>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="type">Country of residence</label>
                                <select name="country_code" class="form-control ">
                                    <option value="GB">
                                        GB
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>Postal/Zip Code</label>
                                <input type="text" class="form-control" placeholder="Postal Code" value="{{ old('postal_code') }}" name="postal_code" required/>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>State/Province</label>
                                <input type="text" class="form-control" placeholder="Post Town" value="{{ old('post_town') }}" name="post_town" required/>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>Address Line 1</label>
                                <input type="text" class="form-control" placeholder="Address line 1" value="{{ old('address_line1') }}" name="address_line1" required/>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label>Address Line 2 (optional)</label>
                                <input type="text" class="form-control" placeholder="Address line 2" value="{{ old('address_line2') }}" name="address_line2"/>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <button type="button" class="btn btn-primary form-control" id="startVerif">
                                    Continue <img src="{{asset('asset/images/loader.gif')}}" width="20" class="spinnerz" />
                                </button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>

	<!-- Details Modal -->
	<div class="modal fade" id="accountModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="accountModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Please complete your KYC, it will only take 5 minutes</h5>
					<a href="javascript:;" class="close text-danger" id="closeAccsountModal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 32px !important;">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div class="alert-danger alert" id="errMsg">
					</div>
					<form action="#">
						<div class="row">
							<div class="col-md-12 mt-3" id="dateOfBirth">
								<label for="date_of_birth">Date Of Birth</label>
								<input type="date" name="dob" max="2004-12-31" class="form-control" id="dob">
							</div>
							<div class="col-md-12 mt-3">
								<label for="account_type">Select Account Type</label>
								<select name="account_type" class="form-control" id="account_type">
									<option value="SOLETRADER">SOLETRADER</option>
									<option value="LLC">LLC - Limited Company </option>
								</select>
							</div>
							<div class="col-md-12 mt-3" id="companyName">
								<label for="company_regNumber">Company Name</label>
								<input type="text" name="company_name" class="form-control" placeholder="Company Name" id="company_name">
							</div>
							<div class="col-md-12 mt-3" id="companyRegNum">
								<label for="company_regNumber">Company Registration Number</label>
								<input type="text" name="company_regNumber" class="form-control form-control-lg" placeholder="Company Registration Number" id="company_regNumber">
							</div>
							<div class="col-md-12 mt-3">
								<label for="company_regNumber">Select Business Category</label>
								<select name="industry_code" class="form-control form-control-lg" id="industry_code">
									<option value="">Select Category</option>
									<option value="I">Accomodation and food services</option>
									<option value="N">Administrative and support services</option>
									<option value="A">Agriculture, forestry and fishing</option>
									<option value="R">Arts, entertainment and recreation</option>
									<option value="F">Construction</option>
									<option value="P">Education</option>
									<option value="D">Electricity, gas, steam and air conditioning</option>
									<option value="K">Financial and insurance services</option>
									<option value="Q">Human health and social work</option>
									<option value="J">Information and communication</option>
									<option value="C">Manufacturing</option>
									<option value="B">Mining and quarrying</option>
									<option value="X">Online gambling or adult entertainment</option>
									<option value="S">Retail and other services</option>
									<option value="M">Professional, scientific and technical services</option>
									<option value="O">Public administration and defence</option>
									<option value="L">Real estate</option>
									<option value="H">Transport and logistics</option>
									<option value="E">Water supply, sewerage and waste management</option>
									<option value="G">Wholesale and retail trade; vehicle repair</option>
								</select>
							</div>
							<div class="col-md-4 mt-3">
								<label for="type">Country of residence</label>
								<select name="country" class="form-control form-control-lg">
									<option value="GB">
										GB
									</option>
								</select>
							</div>
							<div class="col-md-4 mt-3">
								<label for="postcode">Post/Zip Code</label>
								<input type="text" name="post_code" class="form-control form-control-lg" placeholder="Post Code" id="post_code">
							</div>
							<div class="col-md-4 mt-3">
								<label for="post_town">State/Province</label>
								<input type="text" name="post_town" class="form-control form-control-lg" placeholder="State/Province" id="post_town">
							</div>
							<div class="col-md-12 mb-3 mt-3">
								<label for="address">Address line 1</label>
								<input name="address_1" id="address_1" class="form-control form-control-lg" placeholder="Address 1" />
							</div>
							<div class="col-md-12 mb-3 mt-3">
								<label for="address">Address line 2</label>
								<input name="address_2" id="address_2" class="form-control form-control-lg" placeholder="Address 2" />
							</div>
							<div class="col-md-12 submit-button">
								<button class="btn btn-primary" type="button" id="submBtn">
									Proceed
									<img src="{{asset('images/loader.gif')}}" width="20" id="loader" />
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Card modal -->
	<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="cardModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="cardModalCenterTitle">Request Card</h5>
					<a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 32px !important;">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<form action="#">
						<div class="row">
							<div class="col-md-12 mt-3">
								<label for="fname">First Name</label>
								<input type="text" name="first_name" class="form-control form-control-lg" placeholder="First Name" value="{{$user->first_name}}" readonly>
							</div>
							<div class="col-md-12 mt-3">
								<label for="fname">Last Name</label>
								<input type="text" name="last_name" class="form-control form-control-lg" placeholder="Last Name" value="{{$user->last_name}}" readonly>
							</div>
							<div class="col-md-12 mt-3">
								<label for="lname">Card Fee (£)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">£</span>
									</div>
									<input type="number" name="card_fee" class="form-control form-control-lg" readonly value="5">
								</div>
							</div>

							<div class="  mt-3">
								<button class="btn btn-primary form-control" type="button" id="createCard">
									Submit
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- sendMoney modal -->
	<div class="modal fade" id="sendMoneyModal" role="dialog" aria-labelledby="sendMoneyModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="sendMoneyModalCenterTitle">Send Money</h5>
					<a href="javascript:;" class="close text-danger" id="closePaymentsModal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 32px !important;">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div class="alert-danger alert" id="errorMessage">
					</div>
						<input type="hidden" name="cid" id="cid" value="{{$user->gBPAccount()->customerId ?? null}}" />
						<input type="hidden" name="accountId" id="accountId" value="{{$user->gBPAccount()->accountId ?? null}}" />
						<div id="wrapper">
                            <div class="payment-selection">
                                <a href="javascript:;" class="py-3 addBtn"  data-operation="existing">
                                    <h2><i class="fas fa-chevron-right"></i> Pay existing payee</h2>
                                </a>
                                <a href="javascript:;" class="py-3"  >
                                    <h2><i class="fas fa-chevron-right"></i> Transfer to one of your accounts</i></h2>
                                </a>
                                <a href="javascript:;" class="py-3 newpayee addBtn" data-operation="new_payee">
                                    <h2><i class="fas fa-chevron-right"></i> Pay someone new </i></h2>
                                </a>
                                <div class="alert alert-info col-xs-12">
                                    <h5><i class="fas fa-info-circle m-r-2 text-primary"></i>Payee account name check</h5>
                                    <p>
                                        For additional security and to help protect against fraud, we will check the details you provide
                                        against the payee's account details, including the name on their account.
                                    </p>
                                    <p>
                                        All though this does not prevent all types of fraud, this will help give you reassurance that youa re paying the correct person.
                                    </p>
                                </div>
                            </div>
                            <form action="#" class="hide" id="beneficiaryForm">
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn btn-sm btn-primary addBtn" data-operation="existing">
                                        Pay Existing Payee
                                    </button>
                                </div>
                                <div class="row mb-3" >
                                    <div class="col-lg-12">
                                        <label>Select Account Type</label>
                                        <select class="form-control form-select" id="accountType">
                                            <option value="">--Select--</option>
                                            <option value="Personal">Personal Account</option>
                                            <option value="Business">Business Account</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="payeeName">First Name</label>
                                        <input type="text" name="beneficiaryName" id="beneficiaryName" class="form-control" placeholder="First Name" required>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="payeeLastName">Last Name</label>
                                        <input type="text" name="beneficiaryLastName" id="beneficiaryLastName" class="form-control" placeholder="Last Name" required>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="fname">Sort Code</label>
                                        <input type="text" name="sortCode" id="sortCode" class="form-control" placeholder="Sort Code" required>
                                        <small class="text-danger"></small>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="fname">Account Number</label>
                                        <input type="text" name="accountNumber" id="accountNumber" class="form-control" placeholder="Account Number" required>
                                        <small class="text-danger"></small>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="fname">Payment Reference</label>
                                        <input type="text" name="paymentReference" id="paymentReference" class="form-control" placeholder="Payment Reference" required>
                                        <small class="text-danger"></small>
                                    </div>
                                    <div class="col-md-12 mt-3 mb-3">
                                        <label for="amount">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">£<span>
                                            </div>
                                            <input type="number" name="amount" class="form-control" placeholder="Amount" id="amt" min="5" step="100">
                                        </div>
                                    </div>
                                    <div class="col-md-12 submit-button mt-3 ">
                                        <button class="btn btn-primary form-control" type="button" id="benBtn">
                                            Continue <img src="{{asset('asset/images/loader.gif')}}" width="20" class="spinner" />
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form id="paymentForm" class="hide">
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn btn-sm btn-primary addBtn" data-operation="new_payee">
                                        Pay Someone New
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Select Account Type</label>
                                        <select class="form-control form-select" id="accountType">
                                            <option value="">--Select--</option>
                                            <option value="Personal">Personal Account</option>
                                            <option value="Business">Business Account</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <select name="beneficiary" id="beneficiaryId" class="form-select form-control select">
                                            <option value="">Select Beneficiary</option>
                                        </select>
                                        <small class="text-info">Fetching...</small>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <input type="text" name="payeeAccountNumber" id="payeeAccountNumber" class="form-control" placeholder="Enter Destination Account Number" readonly>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <input type="text" name="payeeSortCode" id="payeeSortCode" class="form-control" placeholder="Enter Sort Code" readonly>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <input type="text" name="payeeName" id="payeeName" placeholder="Beneficiary Name" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-12 mt-3 mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">£<span>
                                            </div>
                                            <input type="number" name="amount" class="form-control" placeholder="Amount" id="amount" min="5" step="100">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value="">Select Payment Type</option>
                                            <option value="instant">Instant Payment</option>
                                            <option value="standing_order">Scheduled Payment</option>
                                        </select>
                                    </div>
                                    <div id="standingOrder" >
                                        <div class="col-md-12 mt-3">
                                            <label>Payment Date</label>
                                            <input type="date" name="payment_date" id="payment_date" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-12 submit-button mt-3">
                                        <button class="btn btn-primary form-control" type="button" id="paymentBtn">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->

	{{-- Confirmation modal --}}
	<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="confirmationModalCenterTitle">Confirmation</h5>
				</div>
				<div class="modal-body">
					<div class="card">
						<div class="card-body p-0">
							<table class="table">
								<tbody id="confirmationTable">
								</tbody>
							</table>
						</div>
						<div class="card-footer" id="confirmationModalFooter">
							<a href="javascript:;" class="btn btn-primary btn-sm " id="closeConfirm">
								Cancel
							</a>
							<a href="javascript:;" class="btn btn-info btn-sm confirmPayee" id="confirmPayee">
								Proceed <img src="{{asset('asset/images/loader.gif')}}" width="20" class="spinner" />
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addMoneyModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-550px">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="fw-boldest text-dark fs-3 mb-0">{{__('Add Money')}}</h3>
					<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
						<span class="svg-icon svg-icon-2x">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
							</svg>
						</span>
					</div>
				</div>
				<div class="modal-body scroll-y my-7">
					<a href="javascript:;" id="startOpenbanking">
						<div class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 mb-8">
							<span class="d-flexs">
								<span class="ms-4 ">
									<span class="fs-4 fw-boldest text-gray-900 mb-2 d-block">{{__('Smart Account Topup')}}</span>
									<span class="fw-bold fs-6 text-gray-600">{{__('Use Open Banking to topup account')}}</span> <br />
								</span>
								<div class="open-banking mt-4 mb-4">
									<form action="{{route('payment.open-banking')}}" method="POST" id="openBankingForm">
										@csrf
										<input type="hidden" name="user_id" value="{{ $user->id }}" />
										<div class="input-group">
											<input type="number" name="amount" class="form-control" placeholder="Enter amount" required />
											<div class=" input-group-append">
												<button data-href="{{url('/dashboard/open-banking?_id='.$user->id.'&&amount=100')}}" class="btn btn-primary">
													Proceed
												</button>
											</div>
										</div>
									</form>
								</div>
							</span>
						</div>
					</a>
					<a href="javascript:;">
						<div class="btn btn-outline btn-outline-dashed btn-outline-default d-flexd text-start p-6 shareable-details">
							<div class="d-flexd d-wrapper">
								<span class="ms-4">
									<span class="fs-4 fw-boldest text-gray-900 mb-2 d-block">{{__('Share Account Details')}}</span>
									<span class="fw-bold fs-6 text-gray-600">{{__(' ')}}</span>
										@if ($user->account)
											<div id="accountData" data-clipboard-text="Peter itdo doings an siubdb">
												<span><strong>Account Number:</strong> @if ($user->gBPAccount() != null) {{$user->gBPAccount()->accountNumber}} @endif</span>
												<span><strong>Sort Code:</strong> @if ($user->gBPAccount() != null) {{$user->gBPAccount()->sortCode}} @endif</span>
												<span><strong>IBAN:</strong> @if ($user->euroAccount() != null) {{$user->euroAccount()->iban}} @endif</span>
												<span><strong>BIC:</strong> @if ($user->euroAccount() != null) {{$user->euroAccount()->bic}} @endif</span>
											</div>
											<button
												data-clipboard-text="
												{{'AccountNumber: '}} @if ($user->gBPAccount() != null) {{$user->gBPAccount()->accountNumber}} @endif
												{{'Sort Code: '}} @if ($user->gBPAccount() != null) {{$user->gBPAccount()->sortCode}} @endif
												{{'IBAN: '}}@if ($user->euroAccount() != null) {{$user->euroAccount()->iban}} @endif
												{{'BIC: '}} @if ($user->euroAccount() != null) {{$user->euroAccount()->bic}} @endif
												{{'Address: '.$user->address_line1.' '.$user->postal_code.' '.$user->post_town}}"
												class="copy-btn btn btn-active-color-primary btn-color-dark btn-icon btn-sm btn-outline-light"
											>
												<span class="svg-icon">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
														<path d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z" fill="#B5B5C3" />
													</svg>
												</span>
											</button>
										@endif
								</span>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="cardManager" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-550px">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="fw-boldest text-dark fs-3 mb-0" id="modalTitle">{{__('Add Money')}}</h3>
					<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
						<span class="svg-icon svg-icon-2x">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z" fill="#12131A"></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z" fill="#12131A"></path>
							</svg>
						</span>
					</div>
				</div>
				<div class="modal-body scroll-y my-7">
					<div class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 mb-8">
						<div class="ms-4">
							<form>
								<div class="input-group freeze" style="display: none;">
									<input type="password" name="password" class="form-control passcode" placeholder="Enter account password" required />
									<div class=" input-group-append">
										<button class="btn btn-primary freezeCard">
											Proceed
										</button>
									</div>
								</div>

								<div class="details" style="display: none;">
									<div class="input-group">
										<input type="password" name="password" class="form-control dpasscode" placeholder="Enter account password" required />
										<div class=" input-group-append">
											<button class="btn btn-primary viewCardDetails">
												Proceed
											</button>
										</div>
									</div>
									<div class="mt-5 card-details">
									</div>
								</div>

								<div class="block" style="display: none;">
									<div class="input-group">
										<input type="password" name="password" class="form-control dpasscode" placeholder="Enter account password" required />
										<div class=" input-group-append">
											<button class="btn btn-primary blockCard">
												Proceed
											</button>
										</div>
									</div>
									<div class="mt-5 card-details">
									</div>
								</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
@if(session('waitlist'))
<script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('asset/dashboard/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script>
	$('#waitlist').modal('show');
</script>
@endif
{{Session::forget('waitlist')}}
<script>
	$('.dummy-dd').on('click', function(e) {
		//$(this).off("click").attr('disabled','disabled');
		add.off();
	});
    $("#verifyKyc").on("click", function() {
        //console.log('clicked')
        //$("#spinner").show()
        $(this).attr('disabled', true)
        $("#verificationModal").modal('show')
    })
	$(document).ready(function() {

		let applicantEmail = '{{$user->email}}'
		let applicantPhone = '{{$user->phone_number}}'
		let customI18nMessages = 'Tryba compliance verification'
		let accessToken = ''
		$("#spinner").hide()
		$(".spinnerz").hide()

		$("#closeModal").on("click", function() {
			$("#verificationModal").modal("hide")
			window.location.reload()
		})
	})
</script>
<script>
	let quantityEmail = document.querySelector("#quantityEmail");
	quantityEmail.addEventListener('change',()=>{
		let amountEmail = document.querySelector("#amountEmail");
		amountEmail.value = (quantityEmail.value * {{ getEmailPricePerUnit() }}).toFixed(2)
	});
	quantityEmail.addEventListener('input',()=>{
		let amountEmail = document.querySelector("#amountEmail");
		amountEmail.value = (quantityEmail.value * {{ getEmailPricePerUnit() }}).toFixed(2)
	});
	let emailForm = document.querySelector("#emailBuy");

	emailForm.addEventListener('submit',async (e)=>{
		e.preventDefault();
		let message = document.querySelector("#messageEmail");
		let spinner = document.querySelector("#spinnerEmail");
		let btnText = document.querySelector("#buyemail");

		message.innerText = "";
		spinner.classList.remove('d-none')
		message.innerText = "Making payment ...";
		const res = await fetch("{{ route('user.buyEmail',$user->id) }}", {
            method: 'POST',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            },
            body: JSON.stringify({
               "_token": "{{ csrf_token() }}",
               limit:quantityEmail.value,
            })
        });

        let data = await res.json();
		message.classList.remove('d-none')
		spinner.classList.add('d-none')
		message.innerText = "Buy";
        if(res.status == 200){
			message.classList.add('alert-success')
            message.innerText = data.success
        }else{
			message.classList.add('alert-danger')
            message.innerText = data.error
        }

		setTimeout(() => {
			message.classList.add('d-none')
			message.innerText = ""
		}, 2000);
	});


</script>

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
				height: height,
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
</script>
@endsection
@php
Session::forget('storefront_compliance');
@endphp
