@extends('user.profile.index')

@section('mainpage')
<div class="tab-pane fade @if(route('user.billing')==url()->current())show active @endif" role="tabpanel">
    <div class="card mb-6 mb-xl-9">
		<!--begin::Card body-->
		<div class="card-body">
			<!--begin::Row-->
			<div class="row">
                @if($user->plan)
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
                            @if ($user->email_limit != null)
                                <!--begin::Text-->
                                <div class="d-flex text-muted fw-boldest fs-4 pb-3">
                                    <span class="flex-grow-1 text-dark">{{__('Email Limit using Tryba SMTP')}}</span>
                                    <span class="text-gray-800">{{$user->used_email}} {{__('of')}} {{ $user->email_limit }}</span>
                                </div>
                                <!--end::Text-->
                            @endif
							<!--begin::Progress-->
							<div class="progress h-8px bg-light-primary mb-3">
								@if($user->email_limit!=null)
									<div class="progress-bar bg-primary" role="progressbar" style="width:{{ ($user->used_email) ? $user->used_email/$user->email_limit * 100 : 0}}%" aria-valuenow="{{ ($user->used_email) ? $user->used_email/$user->plan->email_limit * 100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
								@else
								<div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								@endif
							</div>
							<!--end::Progress-->
                            @if($user->email_limit!=null)
							    <p class="text-dark fw-bold mb-6 mb-lg-15">{{$user->email_limit - $user->used_email}} {{__('remaining until your plan upgrade.')}} <a href="#" data-bs-toggle="modal" data-bs-target="#buyMore"class="btn-link">Click here</a> to buy more</p>
							@endif
                            <!--begin::Text-->
						</div>
						<div class="col-lg-6">
                            @if($user->sms_limit != null)
                                <div class="d-flex text-muted fw-boldest fs-4 pb-3">
                                    <span class="flex-grow-1 text-dark">{{__('SMS')}}</span>
                                    <span class="text-gray-800">{{ $user->used_sms }} {{__('of')}} {{ $user->sms_limit }}</span>
                                </div>
                                <!--end::Text-->
                            @endif
							<!--begin::Progress-->
							<div class="progress h-8px bg-light-primary mb-3">
								@if($user->sms_limit != null)
									<div class="progress-bar bg-primary" role="progressbar" style="width:{{ ($user->used_sms > 1) ? $user->used_sms/$user->sms_limit * 100 : 0}}%" aria-valuenow="{{ ($user->used_sms > 1) ? $user->used_sms/$user->sms_limit * 100 : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
								@else
									<div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								@endif
							</div>
							<!--end::Progress-->
							<!--begin::Description-->
                            @if($user->sms_limit != null)
                                <p class="text-dark fw-bold mb-6 mb-lg-15">{{$user->sms_limit - $user->used_sms}} {{__('remaining until your plan upgrade.')}} <a href="#" data-bs-toggle="modal" data-bs-target="#buyMoreSMS"class="btn-link">Click here</a> to buy more</p>
							@endif
                            <!--end::Description-->
						</div>
					</div>
				</div>
				<!--end::Col-->
                @else
                <div class="p-4">
                    <p class="text-center fs-4 fw-boldest">You do not have a subscription yet</p>
                    <div class="d-flex justify-content-center my-9">
                        <img src="{{ asset("asset/new_dashboard/media/svg/no-subscription.svg") }}" alt="">
                    </div>
                </div>
                @endif
			</div>
				<!--end::Col-->
		</div>
			<!--end::Row-->
		</div>
		<!--end::Card body-->
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
</div>
@endsection

@section('script')
<script>
	let quantitySMS = document.querySelector("#quantitySMS");
	quantitySMS.addEventListener('change',()=>{
		let amountSMS = document.querySelector("#amountSMS");
		amountEmail.value = (quantitySMS.value * {{ getSMSPricePerUnit() }}).toFixed(2)
	});
	quantitySMS.addEventListener('input',()=>{
		let amountSMS = document.querySelector("#amountSMS");
		amountSMS.value = (quantitySMS.value * {{ getSMSPricePerUnit() }}).toFixed(2)
	});

	let smsForm = document.querySelector("#smsBuy");

	smsForm.addEventListener('submit',async (e)=>{
		e.preventDefault();
		let message = document.querySelector("#messageSMS");
		let spinner = document.querySelector("#spinnerSMS");
		let btnText = document.querySelector("#buysms");

		message.innerText = "";
		spinner.classList.remove('d-none')
		message.innerText = "Making payment ...";
		const res = await fetch("{{ route('user.smsEmail',$user->id) }}", {
			method: 'POST',
			headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
			},
			body: JSON.stringify({
			"_token": "{{ csrf_token() }}",
			limit:quantitySMS.value,
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
@endsection
