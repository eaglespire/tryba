@extends('user.website.themes.prolaundry.layout')

@section('content')
@include('user.website.themes.prolaundry.components.breadcrumb')
<main id="tt-pageContent">
	<div class="section-inner">
		<div class="container container-fluid-lg">
			<div class="title-block text-center">
				<div class="title-block__label">
					[ Get in Touch With Us ]
				</div>
				<h4 class="title-block__title">
					Contact Information
				</h4>
			</div>
			<div class="row info03__wrapper">
				<div class="col-custom-450 col-6 col-md-3">
					<div class="info03">
						<i class="info03__icon icons-484169"></i>
						<h6 class="info03__title">Post Address</h6>
						<address>
							{{ $website->bookingConfiguration->line }} <br> {{ $website->bookingConfiguration->city }}, {{ $website->bookingConfiguration->postCode }}
						</address>
					</div>
				</div>
				<div class="col-custom-450 col-6 col-md-3">
					<div class="info03">
						<i class="info03__icon icons-483947"></i>
						<h6 class="info03__title">Contact Phone</h6>
						<address>
							<a href="tel:{{  $website->user->phone }}">{{  $website->user->phone }}</a>
						</address>
					</div>
				</div>
				<div class="col-custom-450 col-6 col-md-3">
					<div class="info03">
						<i class="info03__icon icons-1004017"></i>
						<h6 class="info03__title">E-mail Address</h6>
						<address>
							<a href="mailto:{{  $website->user->email }}">{{  $website->user->email }}</a>
						</address>
					</div>
				</div>
				<div class="col-custom-450 col-6 col-md-3">
					<div class="info03">
						<i class="info03__icon icons-59252"></i>
						<h6 class="info03__title">Opening Hours</h6>
						<address>
							Mon-Fri 0{{ $website->bookingConfiguration->businessHours['monday']['startTime'] }}:00 AM - 0{{ $website->bookingConfiguration->businessHours['monday']['endTime'] -12 }}:00 PM
						</address>
						<address>
							Sat-Sun 0{{ $website->bookingConfiguration->businessHours['saturday']['startTime'] }}:00 AM -  0{{ $website->bookingConfiguration->businessHours['saturday']['endTime'] -12 }}:00 PM
						</address>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tt-posirion-relative">
		<div class="container container-fluid-lg">
			<div class="row">
				<div class="col-lg-6">
					<div class="map-layout">
						<div class="title-block">
							<h4 class="title-block__title">
								Get in Touch.  <br>We're Here to Help.
							</h4>
						</div>
						<p>
							We look forward to helping you create and maintain a clean, healthy environment that’s as enjoyable as it is functional.
						</p>
                        <p class="text-sm text-danger" id="error"></p>
                        <p class="text-sm text-success" id="success"></p>
						<form class="form-default" id="contact" method="post" novalidate="novalidate">
							<div class="form-group">
								<input type="text" name="name" id="name" class="form-control" placeholder="Your name">
							</div>
							<div class="row row-align-col">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="email" id="email" class="form-control" placeholder="E-mail">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="phonenumber" id="phone" class="form-control" placeholder="Phone">
									</div>
								</div>
							</div>
							<div class="form-group">
								<textarea name="message" id="message" rows="7" class="form-control" placeholder="Your message"></textarea>
							</div>
							<div class="tt-btn tt-btn__wide">
								<span class="mask">Send Question</span>
								<button type="submit" class="button">Send Message</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="map" class="map-layout-wrapper lazyload" data-bg="images/map-contact.jpg">
			<iframe src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload" data-expand="-220" data-src="https://maps.google.com/maps?&amp;q={{ urlencode($website->bookingConfiguration->line.'+'.$website->bookingConfiguration->city) }}&amp;output=embed" allowfullscreen="" aria-hidden="false"></iframe>
		</div>
	</div>
</main>
@endsection

@section('script')
<script>
    let form = document.querySelector('#contact');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();     
        let name = document.querySelector('#name');
        let email = document.querySelector('#email');
        let phone = document.querySelector('#phone');
        let error = document.querySelector('#error');
        let success = document.querySelector('#success');
        let message = document.querySelector('#message');
        error.innerText = "";
        const res = await fetch("{{ route('website.contact',$website->websiteUrl) }}", {
            method: 'POST',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            },
            body: JSON.stringify({
               "_token": "{{ csrf_token() }}",
               name:name.value,
               email:email.value,
               phone:phone.value,
               message:message.value
            })
        });

        let data = await res.json();
        if(res.status == 200){
            success.innerText = data.success
        }else{
            error.innerText = data.error
        }
    });
</script>
@endsection