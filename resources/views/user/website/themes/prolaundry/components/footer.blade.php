<footer id="tt-footer">
	<div class="footer-wrapper01">
	<div class="container container-fluid-xl">
		<div class="row f-col-wrapper">
			<div class="col-md-4">
				<a href="{{ route('website.link',$website->websiteUrl) }}">
                    @if(empty($website->logo_url))
					    <img src="{{ asset('asset/new_homepage/logo-white.svg') }}" height="100px" width="100px" alt="">
                    @else
                        <img src="{{ $website->logo_url }}" height="100px" width="100px" alt="">
                    @endif
				</a>
				<div class="f-text">
					{{ $website->meta_description }}
				</div>
				<ul class="f-social">
					<li><a href="{{ ($website->user->twitter) ? $website->user->twitter : 'https://twitter.com' }}" target="_blank" class="icons-733635"></a></li>
					<li><a href="{{ ($website->user->facebook) ? $website->user->facebook : 'https://facebook.com' }}" target="_blank" class="icons-59439"></a></li>
					<li><a href="{{ ($website->user->linkedin) ? $website->user->linkedin : 'https://linkedin.com' }}" target="_blank" class="icons-2111532"></a></li>
					<li><a href="{{ ($website->user->instagram) ? $website->user->instagram : 'https://instagram.com' }}" target="_blank" class="icons-733614"></a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<h6 class="f-title">Contacts</h6>
				<ul class="f-info">
                    @if($website->bookingConfiguration->whereServiceRendered ==  1)
					    <li><i class="icons-484169"></i>{{ $website->bookingConfiguration->line }} ,{{ $website->bookingConfiguration->city}}, {{ $website->bookingConfiguration->postCode }}</li>
                    @endif
					<li><i class="icons-59252"></i> Mon-Fri:  {{ $website->bookingConfiguration->businessHours['monday']['startTime'] }}am -  {{ $website->bookingConfiguration->businessHours['monday']['endTime'] - 12 }}pm<br> Sat-Sun:  {{ $website->bookingConfiguration->businessHours['saturday']['startTime'] }}am -  {{ $website->bookingConfiguration->businessHours['saturday']['endTime'] - 12 }}pm</li>
					<li><a href="mailto:{{ $website->user->email }}"><i class="icons-1004017"></i> {{ $website->user->email }}</a></li>
					<li><strong><a href="tel:{{ $website->user->phone }}"><i class="icons-4839471"></i>{{ $website->user->phone }}</a></strong></li>
				</ul>
			</div>
			<div class="col-md-4">
				<h6 class="f-title">Quick Links</h6>
                <ul class="f-info">
                    @foreach($website->webCustomization->menus as $menu)
					    <li><i class="icons-arrow_right"></i><a href="{{ $menu['href'] }}">{{ $menu['text'] }}</a></li>
                    @endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container container-fluid-xl">
	<div class="f-holder">
		<div class="f-copyright">
			&copy; {{ now()->year }} {{ $website->websiteName }}. All Rights Reserved.
		</div>
		<ul class="f-link">
			<li><a href="#">Terms and Conditions</a></li>
			<li><a href="#">Privacy Policy</a></li>
		</ul>
	</div>
</div>
</footer>