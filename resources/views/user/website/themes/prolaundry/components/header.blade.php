<nav class="panel-menu" id="mobile-menu">
	<ul>

	</ul>
	<div class="mm-navbtn-names">
		<div class="mm-closebtn">Close</div>
		<div class="mm-backbtn">Back</div>
	</div>
</nav>
<header id="tt-header">
	<!-- holder-top (desktop) -->
	<div class="holder-top-desktop d-none d-md-block">
		<div class="row">
			<div class="col-auto">
				<div class="h-info01">
                    @if($website->bookingConfiguration->line)
                        <div class="tt-item">
                            <address>
                                {{ $website->bookingConfiguration->line }}
                            </address>
                        </div>
                    @endif
                    @if($website->bookingConfiguration->businessHours)
					<div class="tt-item">
						Mon-Fri 0{{ $website->bookingConfiguration->businessHours['monday']['startTime'] }}:00 AM - 0{{ $website->bookingConfiguration->businessHours['monday']['endTime'] - 12 }}:00 PM
					</div>
                    @endif
					<div class="tt-item">
						<a href="mailto:{{ $website->user->email }}">
							{{ $website->user->email }}
						</a>
					</div>
				</div>
			</div>
			<div class="col-auto ml-auto">
				<div class="tt-obj">
					<div class="h-info02">
						<div class="tt-item">
							<address>
								<a href="tel:{{ $website->user->phone }}"><span class="icons-483947"></span> {{ $website->user->phone }}</a>
							</address>
						</div>
					</div>
				</div>
				<div class="tt-obj">
					<ul class="h-social">
						<li><a href="{{ ($website->user->twitter) ? $website->user->twitter : 'https://twitter.com' }}" target="_blank" class="icons-733635"></a></li>
						<li><a href="{{ ($website->user->facebook) ? $website->user->facebook : 'https://www.facebook.com/' }}" target="_blank" class="icons-59439"></a></li>
						<li><a href="{{ ($website->user->twitter) ? $website->user->twitter : 'https://www.linkedin.com/' }}" target="_blank" class="icons-2111532"></a></li>
						<li><a href="{{ ($website->user->instagram) ? $website->user->instagram : 'https://www.instagram.com/' }}" target="_blank" class="icons-733614"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- /holder-top (desktop) -->
	<!-- holder- -->
	<div id="js-init-sticky">
		<div class="tt-holder-wrapper">
			<div class="tt-holder">
				<div class="tt-col-left">
					<!-- logo -->
					<a href="{{ route('website.link',$website->websiteUrl) }}" class="tt-logo tt-logo-alignment">
                        @if(empty($website->logo_url))
                            <img src="{{ asset('asset/new_homepage/logo.svg') }}" height="100px" width="100px" alt="">
                        @else
                            <img src="{{ $website->logo_url }}" height="100px" width="100px" alt="">
                        @endif
                    </a>
					<!-- /logo -->
				</div>
				<div class="tt-col-center tt-col-wide tt-col-objects text-center">
					<div class="tt-col__item">
						<!-- desktop-nav -->
						<nav id="tt-nav">
	<ul>
        @foreach($website->webCustomization->menus as $menu)
		    <li>
                <a href="{{ $menu['href'] }}">{{ $menu['text'] }} </a>
                @if(array_key_exists('children',$menu))
                    <ul>
                        @foreach ($menu['children'] as $subitem)
                            <li><a href="{{ $subitem['href'] }}">{{ $subitem['text'] }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
	</ul>
</nav>
						<!-- /desktop-nav -->
					</div>
				</div>
				<div class="tt-col-right tt-col-objects">
					<div class="tt-col__item d-block d-lg-none">
						<div class="h-info02">
							<div class="tt-item">
								<address>
									<a href="tel:1(800)7654321"><span class="icons-483947"></span> 1 (800) 765-43-21</a>
								</address>
							</div>
						</div>
					</div>
					<div class="tt-col__item">
						<div class="tt-obj tt-obj-cart js-dropdown-cart">
							<a href="{{ route('website.getCart',['id' => $website->websiteUrl]) }}" class="tt-obj__btn">
								<i class="icons-711897"></i>
								<div class="tt-obj__badge">{{ count(getWebsiteCart()) }}</div>
							</a>
						</div>
					</div>
					<div class="tt-col__item d-none d-md-block">
						<a href="{{ route('website.services',$website->websiteUrl) }}" class="tt-btn">
							<span class="mask">Make an appointment</span>
							<div class="button">Make an appointment</div>
						</a>
					</div>
					<div class="tt-col__item toggle-wrapper">
						<a href="#" id="tt-menu-toggle" class="icons-1828859"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>