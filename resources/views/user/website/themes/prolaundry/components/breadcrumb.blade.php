<div id="subtitle-wrapper" class="lazyload" data-bg="images/subtitle-wrapper01.jpg">
	<div class="subtitle-wrapper-img lazyload" data-bg="{{ ($website->webCustomization->slider !== NULL) ? $website->webCustomization->slider[0]['url']  : "" }}">
		<div class="container container-fluid-xl">
				<div class="tt-breadcrumbs">
				<ul>
					<li><a href="{{ route('website.link',$website->websiteUrl) }}">Home</a></li>
					<li>{{ $title  }}</li>
				</ul>
			</div>
			<h1 class="subtitle__title">{{ $title }}</h1>
		</div>
		<div class="bubbleContainer">
			<div class="bubble-1"></div>
			<div class="bubble-2"></div>
			<div class="bubble-3"></div>
			<div class="bubble-4"></div>
			<div class="bubble-5"></div>
			<div class="bubble-6"></div>
			<div class="bubble-7"></div>
			<div class="bubble-8"></div>
			<div class="bubble-9"></div>
			<div class="bubble-10"></div>
		</div>
	</div>
</div>