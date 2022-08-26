@extends('user.website.themes.prolaundry.layout')

@section('content')
<main id="tt-pageContent">
	<div id="js-mainSlider">
		<div class="mainSlider-preloader"><span class="tt-base-color">Pro</span>Laundry</div>
		<div class="mainSlider-wrapper">
            <div class="slick-default main-slider">
                <div class="item">
                    <div class="item_left">
                        <div class="item__img">
                            <picture>
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-01-md.webp') }}" media="(max-width: 1024px)" type="image/webp">
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-01-md.jpg') }}" media="(max-width: 1024px)" type="image/jpg">
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-01.webp') }}" type="image/webp">
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-01.jpg') }}" type="image/jpg">
                                <img src="{{  asset('asset/themes/website/prolaundry/images/mainslide01-01.jpg') }}" alt="">
                            </picture>
                        </div>
                        <div class="item__content">
                            <div class="content-align js-rotation">
                                <h4 class="main-slider__title">Laundry<br> Service</h4>
                                <p>We Care for the Clothes You Wear</p>
                                <a href="#" class="tt-btn tt-btn__top" data-toggle="modal" data-target="#modalMRequestQuote">
                                    <span class="mask">Order Now</span>
                                    <div class="button">Order Now</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="item_right">
                        <div class="item__img">
                            <picture>
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-02-md.webp') }}" media="(max-width: 1024px)" type="image/webp">
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-02-md.jpg') }}" media="(max-width: 1024px)" type="image/jpg">
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-02.webp') }}" type="image/webp">
                                <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide01-02.jpg') }}" type="image/jpg">
                                <img src="{{  asset('asset/themes/website/prolaundry/images/mainslide01-02.jpg') }}" alt="">
                            </picture>
                        </div>
                        <div class="item__content">
                            <div class="content-align js-rotation">
                                <h4 class="main-slider__title">Dry<br> Cleaning</h4>
                                <p>Cleaning Excellence Guaranteed!</p>
                                <a href="#" class="tt-btn tt-btn__top" data-toggle="modal" data-target="#modalMRequestQuote">
                                    <span class="mask">Order Now</span>
                                    <div class="button">Order Now</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="item">
                            <div class="item_left">
                                <div class="item__img">
                                    <picture>
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-01-md.webp') }}" media="(max-width: 1024px)" type="image/webp">
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-01-md.jpg') }}" media="(max-width: 1024px)" type="image/jpg">
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-01.webp') }}" type="image/webp">
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-01.jpg"') }} type="image/jpg">
                                        <img src="{{  asset('asset/themes/website/prolaundry/images/mainslide02-01.jpg') }}" alt="">
                                    </picture>
                                </div>
                                <div class="item__content">
                                    <div class="content-align js-rotation">
                                        <h4 class="main-slider__title">Laundry<br> Service</h4>
                                        <p>We Care for the Clothes You Wear</p>
                                        <a href="#" class="tt-btn tt-btn__top" data-toggle="modal" data-target="#modalMRequestQuote">
                                            <span class="mask">Order Now</span>
                                            <div class="button">Order Now</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item_right">
                                <div class="item__img">
                                    <picture>
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-02-md.webp') }}" media="(max-width: 1024px)" type="image/webp">
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-02-md.jpg') }}" media="(max-width: 1024px)" type="image/jpg">
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-02.webp') }}" type="image/webp">
                                        <source srcset="{{  asset('asset/themes/website/prolaundry/images/mainslide02-02.jpg') }}" type="image/jpg">
                                        <img src="{{  asset('asset/themes/website/prolaundry/images/mainslide02-02.jpg;') }}" alt="">
                                    </picture>
                                </div>
                                <div class="item__content">
                                    <div class="js-rotation content-align">
                                        <h4 class="main-slider__title">Dry<br> Cleaning</h4>
                                        <p>Cleaning Excellence Guaranteed!</p>
                                        <a href="#" class="tt-btn tt-btn__top" data-toggle="modal" data-target="#modalMRequestQuote">
                                            <span class="mask">Order Now</span>
                                            <div class="button">Order Now</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bubbles-container" id="bubbles">
                        <div style="top: 60.3%; margin-left: -2.1%;">
                            <img src="images/bubbles-06.png" class="bubbles-response-03" alt="">
                        </div>
                        <div style="top: 52.3%; margin-left: -5.3%;">
                            <img src="images/stars-01.png" class="bubbles-stars"  alt="">
                        </div>
                        <div style="top: 39.5%; margin-left: 0.7%;">
                            <img src="images/bubbles-03.png" class="bubbles-response-03" alt="">
                        </div>
                        <div style="top: 26.5%; margin-left: -3.8%;">
                            <img src="images/bubbles-05.png" alt="">
                        </div>
                        <div style="top: 11.4%; margin-left: 0.7%;">
                            <img src="images/bubbles-01.png" class="bubbles-response-01"  alt="">
                        </div>
                        <div style="top: 81%; margin-left: -1.5%;">
                            <img src="images/bubbles-07.png" alt="">
                        </div>
                        <div style="top: 54.8%; margin-left: -2.3%;">
                            <img src="images/bubbles-09.png" alt="">
                        </div>
                        <div style="top: 8.9%; margin-left: -3.1%;">
                            <img src="images/stars-02.png" class="bubbles-stars" alt="">
                        </div>
                        <div style="top: 68.2%; margin-left: 1.3%;">
                            <img src="images/bubbles-10.png" alt="">
                        </div>
                        <div style="top: 67.2%; margin-left: 0.1%;">
                            <img src="images/bubbles-02.png" class="bubbles-response-02" alt="">
                        </div>
                        <div style="top: 77.2%; margin-left: 1.2%;">
                            <img src="images/bubbles-11.png" alt="">
                        </div>
                        <div style="top: 7.2%; margin-left: -6.3%;">
                            <img src="images/stars-03.png" class="bubbles-stars" alt="">
                        </div>
                        <div style="top: 7.8%; margin-left: 4.1%;">
                            <img src="images/bubbles-08.png" alt="">
                        </div>
                        <div style="top: 6.7%; margin-left: 2.3%;">
                            <img src="images/stars-04.png" class="bubbles-stars" alt="">
                        </div>
                        <div style="top: 38.5%; margin-left: -2.5%;">
                            <img src="images/stars-06.png" class="bubbles-stars" alt="">
                        </div>
                        <div style="top: 83.5%; margin-left: 5.4%;">
                            <img src="images/stars-07.png" class="bubbles-stars" alt="">
                        </div>
                        <div style="top: 16.5%; margin-left: 5.5%;">
                            <img src="images/stars-05.png" class="bubbles-stars" alt="">
                        </div>
                    </div>
        </div>
	</div>
	<div class="section-inner lazyload bg-top-left move-top-bottom tt-overflow-hidden" data-bg="images/wrapper01.png">
		<div class="container container-fluid-xl">
			<div class="box01">
				<div class="box01__img">
					<img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAfoAAAHtAQMAAADLCC4pAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADZJREFUeNrtwTEBAAAAwiD7p7bDbmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAxQF9LQABorKvFgAAAABJRU5ErkJggg==" class="lazyload" data-src="{{  asset('asset/themes/website/prolaundry/images/img01.jpg') }}" alt="">
					<img class="tt-arrow lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{  asset('asset/themes/website/prolaundry/images/arrow-img-right.png') }}" alt="">
					<div class="box01__img-label">
						<div class="tt-text01">25</div>
						years of <br> experience
					</div>
				</div>
				<div class="box01__content">
					<div class="title-block">
						<div class="title-block__label">
							More than 25 Years of Experience
						</div>
						<h4 class="title-block__title">
							We are Passionate About Laundry
						</h4>
					</div>
					<div class="box01__wrapper-img">
						<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload" data-src="{{  asset('asset/themes/website/prolaundry/images/img01.jpg') }}" alt="">
						<div class="box01__img-label">
							<div class="tt-text01">25</div>
							years of<br>experience
						</div>
					</div>
					<p>
						We are professionals in the laundry and dry cleaning business, which means we always stay up to date on the latest technologies, cleaning methods, and solutions for dealing with stains or delicate fabrics. Plus, we maintain the highest standards of business integrity by following local and national regulations and environmental safety rules. We are passionate about the way you think about laundry!
					</p>
					<div class="row row-custom01 no-gutters">
						<div class="col-lg-6">
							<ul class="tt-list01">
								<li>100% Customer Satisfaction</li>
								<li>Free Collection & Delivery</li>
								<li>Affordable Prices</li>
								<li>Best Quality</li>
							</ul>
						</div>
						<div class="col-lg-6">
							<a href="tel:1(800)765-43-21" class="info01">
								<div class="info01__icon"><i class="icons-483947"></i></div>
								<div class="info01__content">
									<div class="info01__title">
										Call for Quality Services
									</div>
									<address>
										{{ $website->user->phone }}
									</address>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="added-info added-info__top row no-gutters-row js-init-carusel-tablet slick-default">
				<a href="contact-areas.html" class="added-info__item col-md-4">
					<div class="added-info__icon icons-806765"></div>
					<div class="added-info__description">
						<h6 class="added-info__title"><span>Save Time & Money</span></h6>
						No more wasted time driving to the laundromats, we pickup and deliver for free!
					</div>
				</a>
				<a href="contact.html" class="added-info__item col-md-4">
					<div class="added-info__icon icons-1485715"></div>
					<div class="added-info__description">
						<h6 class="added-info__title"><span>Pay Online in Seconds</span></h6>
						Manage your Press account and billing online from your smartphone or computer.
					</div>
				</a>
				<a href="#" class="added-info__item col-md-4">
					<div class="added-info__icon icons-3037040"></div>
					<div class="added-info__description">
						<h6 class="added-info__title"><span>Eco-Friendly</span></h6>
						We use safe and clean perc-free solvents, so you, and the Earth, can look good.
					</div>
				</a>
			</div>
		</div>
	</div>
	<div class="lazyload bg-top-right" data-bg="images/wrapper02.png">
		<div class="section-indent no-margin">
			<div class="container-fluid">
				<div class="title-block text-center">
					<div class="title-block__label">
						[ Our Services ]
					</div>
					<h4 class="title-block__title">
						Dry Cleaning & Laundry,<br>Free Delivery
					</h4>
				</div>
				<div class="slick-default slick-arrow-align imgbox-inner__wrapper" data-slick='{
						"slidesToShow": 3,
						"autoplaySpeed": 7500,
						"slidesToScroll": 3,
						"arrows": true,
						"autoplay":true,
						"responsive": [
							{
								"breakpoint": 1750,
								"settings": {
									"arrows": false
								}
							},
							{
								"breakpoint": 1024,
								"arrows": false,
								"settings": {
									"slidesToShow": 2
								}
							},
							{
								"breakpoint": 651,
								"settings": {
									"slidesToShow": 1,
									"slidesToScroll": 1
								}
							}
						]
					}'>
					<div class="tt-item">
						<a href="services-item.html" class="imgbox-inner svg-animation-01">
							<div class="imgbox-inner__img">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAIIAQMAAACIJgJoAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAD1JREFUeNrtwTEBAAAAwiD7pzbDfmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACQHmmAAAa/2RGEAAAAASUVORK5CYII=
" data-src="images/imgbox-inner__img01.jpg" class="lazyload" alt="">
							</div>
							<div class="imgbox-inner__description">
								<div class="imgbox-inner__row">
									<div class="imgbox-inner__icon">
										<svg class="svg-vacuumcleaner-icon animated-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="300" height="300" viewBox="0 0 39 32">
											<path class="tube" d="M37.644 31.192h-9.893c-0.259-1.001 0.157-1.911 0.717-2.333 0.567-0.428 1.67-0.211 2.641-0.338-0.084-0.428-0.199-0.965-0.386-1.344-4.045-8.229-8.121-16.452-12.166-24.681-0.223-0.458-0.705-0.729-1.212-0.699-0.567 0.030-1.145 0.006-1.766 0.006v-1.718c1.121 0 2.267-0.084 3.388 0.048 0.35 0.042 0.717 0.621 0.922 1.037 2.888 5.787 5.745 11.593 8.615 17.393 1.248 2.526 2.514 5.046 3.732 7.59 0.338 0.705 0.663 1.459 0.983 2.399 0.416 0 0.826 0.012 1.459 0.018 1.019 0.012 1.447 0.241 2.020 0.965 0.47 0.591 0.627 0.904 1.031 1.537-0.042 0.048-0.054 0.060-0.084 0.121z"></path>
											<path class="hose" d="M14.12 0.898c0 0.41 0 0.711 0 0.892-0.953 0.362-1.887 0.591-2.701 1.043-1.616 0.892-2.182 2.417-1.682 4.184 0.518 1.833 1.718 3.231 2.99 4.576 3.286 3.473 6.601 6.921 9.863 10.412 0.603 0.645 1.097 1.411 1.513 2.194 1.278 2.436 0.32 4.105-2.496 4.317 0-0.326 0-0.651 0-0.983 0.036-0.024 0.078-0.072 0.127-0.078 1.857-0.247 2.363-1.079 1.411-2.695-0.723-1.224-1.634-2.369-2.604-3.418-3.153-3.4-6.402-6.71-9.543-10.116-0.784-0.85-1.429-1.893-1.917-2.948-1.495-3.255-0.006-6.246 3.466-7.138 0.494-0.115 1.007-0.151 1.573-0.241z"></path>
											<path class="vacuumcleaner" d="M7.049 20.883c-3.069 0-5.558 2.49-5.558 5.558s2.49 5.558 5.558 5.558c3.069 0 5.558-2.49 5.558-5.558s-2.49-5.558-5.558-5.558zM7.049 29.468c-1.67 0-3.026-1.356-3.026-3.026s1.356-3.026 3.026-3.026c1.67 0 3.026 1.356 3.026 3.026s-1.356 3.026-3.026 3.026z"></path>
											<path class="vacuumcleaner" d="M19.48 23.059c-1.748-1.272-3.442-2.616-5.227-3.828-0.663-0.452-1.501-0.868-2.279-0.904-2.616-0.115-5.245-0.066-7.867-0.036-0.669 0.006-1.17 0.398-1.23 1.103-0.054 0.681-0.018 1.375-0.012 2.176 1.157-1.043 2.683-1.682 4.365-1.682 3.593 0 6.511 2.912 6.511 6.511 0 1.338-0.404 2.586-1.097 3.617 2.393 0 4.769 0.030 7.144-0.024 0.748-0.018 1.037-0.639 1.049-1.35 0.012-0.953-0.024-1.905 0.012-2.852 0.018-1.164-0.434-2.050-1.369-2.731z"></path>
										</svg>
									</div>
									<div class="imgbox-inner__content">
										<h4 class="imgbox-inner__title">Carpet Cleaning</h4>
										<p>To keep carpet at peak performance, we recommend professional deep cleaning your carpet every 12 to 18 months.</p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="tt-item">
						<a href="services-item.html" class="imgbox-inner svg-animation-02">
							<div class="imgbox-inner__img">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAIIAQMAAACIJgJoAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAD1JREFUeNrtwTEBAAAAwiD7pzbDfmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACQHmmAAAa/2RGEAAAAASUVORK5CYII=
" data-src="images/imgbox-inner__img02.jpg" class="lazyload" alt="">
							</div>
							<div class="imgbox-inner__description">
								<div class="imgbox-inner__row">
									<div class="imgbox-inner__icon">
										<svg class="tt-size-01" version="1.1" xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024">
											<title></title>
											<g id="icomoon-ignore">
											</g>
											<path fill="currentColor" d="M928.001 928.001c0 48.605-39.407 87.999-87.999 87.999h-655.998c-48.594 0-87.999-39.394-87.999-87.999v-832.002c0-48.605 39.406-87.999 87.999-87.999h655.998c48.594 0 87.999 39.394 87.999 87.999v832.002zM880.002 95.999c0-22.094-17.905-39.999-39.999-39.999h-655.998c-22.094 0-39.999 17.905-39.999 39.999v832.002c0 22.094 17.905 39.999 39.999 39.999h655.998c22.094 0 39.999-17.905 39.999-39.999v-832.002z"></path>
											<path fill="currentColor" d="M897.167 312.003h-784.003c-13.25 0-17.168-10.739-17.168-24v-184.306c0-49.182 39.248-95.696 87.981-95.696h649.921c51.426 0 94.093 50.431 94.093 95.696v184.306c0 13.261-17.585 24-30.835 24zM143.998 264h735.997v-160.303c0-21.599-24.35-47.697-46.094-47.697h-649.921c-21.873 0-39.982 25.41-39.982 47.697v160.303z"></path>
											<path fill="currentColor" d="M376.002 304.003c-13.25 0-24-10.739-24-24v-239.998c0-13.262 10.75-24 24-24s24 10.739 24 24v239.998c0 13.261-10.75 24-24 24z"></path>
											<path fill="currentColor" d="M819.283 163.827c0 22.863-18.511 41.392-41.374 41.392s-41.374-18.529-41.374-41.392c0-22.846 18.511-41.374 41.374-41.374s41.374 18.529 41.374 41.374z"></path>
											<path fill="currentColor" d="M703.426 163.827c0 22.863-18.511 41.392-41.374 41.392s-41.374-18.529-41.374-41.392c0-22.846 18.511-41.374 41.374-41.374s41.374 18.529 41.374 41.374z"></path>
											<path fill="currentColor" d="M587.569 163.827c0 22.863-18.546 41.392-41.374 41.392-22.863 0-41.374-18.529-41.374-41.392 0-22.846 18.511-41.374 41.374-41.374 22.835 0 41.374 18.529 41.374 41.374z"></path>
											<path fill="currentColor" d="M499.63 893.345c-126.752 0-229.87-103.101-229.87-229.856s103.119-229.856 229.87-229.856c126.734 0 229.87 103.101 229.87 229.856s-103.137 229.856-229.87 229.856zM499.63 481.632c-100.287 0-181.871 81.566-181.871 181.853 0 100.27 81.584 181.853 181.871 181.853 100.27 0 181.871-81.584 181.871-181.853 0-100.287-81.602-181.853-181.871-181.853z"></path>
											<path fill="currentColor" d="M412.033 739.395c-56.127 0-104.85-32.734-129.519-58.942-9.090-9.649-8.641-24.833 1.026-33.923 9.585-9.090 24.769-8.659 33.87 0.962v0c3.327 3.473 82.243 84.351 163.022 16.658 91.425-76.497 187.506-33.17 225.507 0.431 9.934 8.769 10.878 23.936 2.098 33.87-8.787 9.923-23.953 10.867-33.87 2.098-3.17-2.768-80.672-68.433-162.911 0.413-33.439 27.985-67.505 38.432-99.215 38.432z"></path>
											<path fill="currentColor" d="M628.946 710.034c0 9.154-7.405 16.559-16.559 16.559-9.136 0-16.541-7.405-16.541-16.559 0-9.136 7.405-16.541 16.541-16.541 9.154 0 16.559 7.405 16.559 16.541z"></path>
											<path fill="currentColor" d="M612.387 776.242c0 9.136-7.405 16.559-16.541 16.559s-16.559-7.423-16.559-16.559 7.423-16.541 16.559-16.541c9.136 0 16.541 7.405 16.541 16.541z"></path>
											<path fill="currentColor" d="M546.19 726.593c0 9.136-7.405 16.541-16.559 16.541s-16.559-7.405-16.559-16.541c0-9.154 7.405-16.559 16.559-16.559s16.559 7.405 16.559 16.559z"></path>
											<path fill="currentColor" d="M513.072 792.801c0 9.136-7.405 16.541-16.541 16.541s-16.541-7.405-16.541-16.541c0-9.154 7.405-16.559 16.541-16.559s16.541 7.405 16.541 16.559z"></path>
											<path fill="currentColor" d="M413.758 759.694c0 9.136-7.405 16.541-16.541 16.541s-16.541-7.405-16.541-16.541 7.405-16.559 16.541-16.559c9.136 0 16.541 7.423 16.541 16.559z"></path>
										</svg>
									</div>
									<div class="imgbox-inner__content">
										<h4 class="imgbox-inner__title">Laundry Services</h4>
										<p>Let us pick up your dirty laundry, sort it, pre-treat stains, wash, dry, fold and deliver back to you in one neat, easy package.</p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="tt-item">
						<a href="services-item.html" class="imgbox-inner svg-animation-03">
							<div class="imgbox-inner__img">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAIIAQMAAACIJgJoAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAD1JREFUeNrtwTEBAAAAwiD7pzbDfmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACQHmmAAAa/2RGEAAAAASUVORK5CYII=
" data-src="images/imgbox-inner__img03.jpg" class="lazyload" alt="">
							</div>
							<div class="imgbox-inner__description">
								<div class="imgbox-inner__row">
									<div class="imgbox-inner__icon">
										<svg class="tt-size-02" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="300" height="300" viewBox="0 0 35 32">
											<path class="hanger" d="M32.702 20.62l-13.413-12.155c-0.15-0.137-0.316-0.252-0.489-0.352v-1.965h-0.128c-0.088-0.27-0.301-0.497-0.673-0.583-0.831-0.191-1.748-0.465-2.315-1.143-0.274-0.328-0.359-0.76-0.242-0.988 0.664-1.294 2.593-0.9 3.702-0.421 1.181 0.51 2.21-1.211 1.019-1.725-2.057-0.889-5.404-1.289-6.511 1.245-0.855 1.956 0.436 3.464 2.078 4.32v1.245c-0.184 0.104-0.36 0.223-0.52 0.367l-13.411 12.155c-1.127 1.021-0.748 1.849 0.845 1.849h6.377v-2.155h-3.674l11.312-10.251c0.145-0.132 0.361-0.208 0.592-0.208s0.447 0.075 0.592 0.208l11.312 10.251h-3.747v2.155h6.45c1.593 0 1.971-0.828 0.845-1.849z"></path>
											<path class="clothes" d="M10.097 20.314v11.686l3.376-1.023-0.031-6.447c-0.003-0.594 0.477-1.081 1.072-1.083 0.002 0 0.004 0 0.005 0 0.593 0 1.075 0.479 1.077 1.072l0.028 5.806 8.704-2.636v-9.561h-14.232v2.186z"></path>
										</svg>
									</div>
									<div class="imgbox-inner__content">
										<h4 class="imgbox-inner__title">Dry Cleaning Services</h4>
										<p>SMU students and local residents love on our reliable dry cleaning services for the fast, accurate, top quality results.</p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="tt-item">
						<a href="services-item.html" class="imgbox-inner">
							<div class="imgbox-inner__img">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAIIAQMAAACIJgJoAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAD1JREFUeNrtwTEBAAAAwiD7pzbDfmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACQHmmAAAa/2RGEAAAAASUVORK5CYII=
" data-src="images/imgbox-inner__img04.jpg" class="lazyload" alt="">
							</div>
							<div class="imgbox-inner__description">
								<div class="imgbox-inner__row">
									<div class="imgbox-inner__icon"><i class="icons-sewing-machine"></i></div>
									<div class="imgbox-inner__content">
										<h4 class="imgbox-inner__title">Alterations & Repairs</h4>
										<p>We have expert seamstresses and tailors on staff to ensure we meet  and exceed your fitting requirements.</p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="tt-item">
						<a href="services-item.html" class="imgbox-inner">
							<div class="imgbox-inner__img">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAIIAQMAAACIJgJoAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAD1JREFUeNrtwTEBAAAAwiD7pzbDfmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACQHmmAAAa/2RGEAAAAASUVORK5CYII=
" data-src="images/imgbox-inner__img05.jpg" class="lazyload" alt="">
							</div>
							<div class="imgbox-inner__description">
								<div class="imgbox-inner__row">
									<div class="imgbox-inner__icon"><i class="icons-ironing-board"></i></div>
									<div class="imgbox-inner__content">
										<h4 class="imgbox-inner__title">Steam Iron</h4>
										<p>These services are accomplished under the guidance of adroit personnel who have affluent industry proficiency. </p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="tt-item">
						<a href="services-item.html" class="imgbox-inner">
							<div class="imgbox-inner__img">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAIIAQMAAACIJgJoAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAD1JREFUeNrtwTEBAAAAwiD7pzbDfmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACQHmmAAAa/2RGEAAAAASUVORK5CYII=
" data-src="images/imgbox-inner__img06.jpg"  class="lazyload" alt="">
							</div>
							<div class="imgbox-inner__description">
								<div class="imgbox-inner__row">
									<div class="imgbox-inner__icon"><i class="icons-shoes"></i></div>
									<div class="imgbox-inner__content">
										<h4 class="imgbox-inner__title">Shoes Cleaning</h4>
										<p>We use premium cleaning products and standardised processes to take care of your shoes and give them refreshed look.</p>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="section-indent">
			<div class="container container-fluid-lg">
				<div class="row align-items-center stepbox_wrapper" style="overflow: hidden;">
					<div class="col-md-6 col-lg-5 stepbox__layout">
						<img class="tt-arrow lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/arrow-img-right02.png" alt="">
						<div class="title-block">
							<div class="title-block__label">
								[ Get Your Clothes Collected & Delivered ]
							</div>
							<h4 class="title-block__title">
								How We Work
							</h4>
						</div>
						<p>
							Our Service is dedicated to making your life easier by providing pick up laundry service. Give yourself one less thing to worry about and try our residential wash and fold service that includes pick up and delivery.
						</p>
						<p>
							We have been in the laundry business for more than 12 years and would love to earn your business. Try us today and save $10 Off your first laundry service of 20 pounds or more.
						</p>
						<a href="#" class="tt-btn tt-btn__top" data-toggle="modal" data-target="#modalMRequestQuote">
							<span class="mask">Get Service Now</span>
							<div class="button">Get Service Now</div>
						</a>
					</div>
					<div class="col-md-6 col-lg-6 offset-lg-1">
						<div class="slider-stepbox" id="js-stepbox__layout">
							<div class="tt-item active" data-number="1">
								<div class="stepbox">
									<div class="stepbox__img">
										<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/stepbox-img01.png" alt="">
									</div>
									<div class="stepbox__content">
										<div class="stepbox__number">01</div>
										<div class="stepbox__limitation">
											<h6 class="stepbox__title"><span class="tt-base-color">Bag Up</span> All Your Dirty Clothes</h6>
											<p>We are pleased to pickup your<br> laundry and ensure that it is expertly laundered and pressed.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="tt-item" data-number="2">
								<div class="stepbox">
										<div class="stepbox__img">
										<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/stepbox-img02.png" alt="">
									</div>
									<div class="stepbox__content">
										<div class="stepbox__number">02</div>
										<div class="stepbox__limitation">
											<h6 class="stepbox__title">We <span class="tt-base-color">Pick Up</span> Your Clothes</h6>
											<p>Morning of your pickup, leave your bags in their designated pickup location by 8:00 am for a driver to pick up.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="tt-item" data-number="3">
								<div class="stepbox">
										<div class="stepbox__img">
										<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/stepbox-img03.png" alt="">
									</div>
									<div class="stepbox__content">
										<div class="stepbox__number">03</div>
										<div class="stepbox__limitation">
											<h6 class="stepbox__title">We <span class="tt-base-color">Clean</span> Your Clothes</h6>
											<p>Our facilities are so good we guarantee you’ll be satisfied – we put a quality guarantee on all items</p>
										</div>
									</div>
								</div>
							</div>
							<div class="tt-item" data-number="4">
								<div class="stepbox">
										<div class="stepbox__img">
										<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/stepbox-img04.png" alt="">
									</div>
									<div class="stepbox__content">
										<div class="stepbox__number">04</div>
										<div class="stepbox__limitation">
											<h6 class="stepbox__title">We <span class="tt-base-color">Deliver</span> Clean, Folded Clothes</h6>
											<p>We’ll deliver your pristine garments back to you, anytime and anywhere</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="stepbox-dots__wrapper" id="js-stepbox__nav" data-number="1">
							<div class="stepbox-dots__line01 lazyload" data-bg="images/step-line-x.png"></div>
							<div class="stepbox-dots__line02 lazyload" data-bg="images/step-line2-x.png"></div>
							<ul class="stepbox-dots" role="tablist">
								<li class="active nav-01" data-number="1"><button type="button" role="tab">1</button></li>
								<li data-number="2"><button type="button" role="tab">2</button></li>
								<li data-number="3"><button type="button" role="tab">3</button></li>
								<li data-number="4"><button type="button" role="tab">4</button></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tt-position-relative bg-top-left move-bottom-top lazyload" data-bg="images/wrapper03.png">
		<div class="section-inner">
			<div class="box02 box02__img-left">
				<div class="box02__img">
					<picture>
						<source srcset="images/box02-img01-sm.webp" media="(max-width: 650px)" type="image/webp">
						<source srcset="images/box02-img01-sm.jpg" media="(max-width: 650px)" type="image/png">
						<source srcset="images/box02-img01-md.webp" media="(max-width: 1024px)" type="image/webp">
						<source srcset="images/box02-img01-md.jpg" media="(max-width: 1024px)" type="image/png">
						<source srcset="images/box02-img01.webp" type="image/webp">
						<source srcset="images/box02-img01.jpg" type="image/png">
						<img src="dimages/box02-img01.jpg" alt="">
					</picture>
					<img class="tt-arrow lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/arrow-img-right03.png" alt="">
				</div>
				<div class="box02__content">
					<div class="title-block">
						<div class="title-block__label">
							[ Laundry service for your business! ]
						</div>
						<h4 class="title-block__title">
							Commercial Laundry<br> Service
						</h4>
					</div>
					<p>
						Large corporations have determined that there is a financial benefit to outsourcing back office work because it saves money. Allowing us to do your laundry is cost effective and will allow you and your employees to focus on your core business. We offer smart solutions to meet your commercial laundry needs. Our Commercial Laundry Clients include:
					</p>
					<div class="row tt-list01__top">
						<div class="col-lg-6">
							<ul class="tt-list01">
								<li>Salons &amp; Spas</li>
								<li>Restaurants and Caterers</li>
								<li>Religious Organizations</li>
								<li>Daycare centers</li>
							</ul>
						</div>
						<div class="col-lg-6">
							<ul class="tt-list01">
								<li>Assisted Living / Nursing Homes</li>
								<li>Hotels &amp; Motels</li>
								<li>Nail Salons</li>
								<li>Athletic Facilities / Gyms</li>
							</ul>
						</div>
					</div>
					<div class="box02-list-col"></div>
				</div>
			</div>
		</div>
		<div class="tt-position-relative">
			<div class="lazyload tt-obj01-bg" data-bg="images/wrapper04.png"></div>
			<div class="section-indent no-margin ">
				<div class="container container-fluid-lg">
					<div class="title-block text-center">
						<div class="title-block__label">
							[ Important Information ]
						</div>
						<h4 class="title-block__title">
							Trusted Laundry Service
						</h4>
					</div>
					<div class="tabs-default tab-layout01">
						<div class="tt-ajax-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link show active" data-toggle="tab" href="#tt-tab-01" role="tab">Our Approach</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab"  href="#tt-tab-02" role="tab" data-ajax-include="ajax-content/tabs-questions-answers.html">Questions / Answers</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tt-tab-03" role="tab"  data-ajax-include="ajax-content/tabs-why-choose-us.html">Why Choose Us</a>
								</li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active fade" id="tt-tab-01" role="tabpanel">
								<div class="row align-items-lg-center">
									<div class="col-sm-6 col-lg-5">
										<h5 class="tab-layout01__title">Our Approach</h5>
										<p>
											We approach workforce accommodations with a property development mindset. Our “Develop. Own. Operate.” business model produces integrated solutions that enable clients to focus on their core business.
										</p>
										<p>
											Clients benefit from consistent service delivery with greater cost and quality control as well as more efficient use of their operational and financial resources.
										</p>
									</div>
									<div class="divider-sm d-block d-sm-none"></div>
									<div class="col-sm-6 col-lg-6 offset-lg-1 text-right">
										<a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="tt-obj-video js-video-popup">
											<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/video-img01.jpg" alt="">
											<div class="btn-video-holder" data-video="https://www.youtube.com/embed/_sI_Ps7JSEk">
												<div class="btn-video icons-254434"></div>
											</div>
										</a>
									</div>
								</div>
								<div class="added-info02 added-info02__top row">
									<a href="contact-areas.html" class="added-info02__item col-md-4">
										<div class="added-info02__icon icons-3022225"></div>
										<div class="added-info02__description">
											<h6 class="added-info02__title"><span>High Quality</span></h6>
											We work hard to make sure that the clothes you get back are spotless and ready for action.
										</div>
									</a>
									<a href="contact.html" class="added-info02__item col-md-4">
										<div class="added-info02__icon icons-3096677"></div>
										<div class="added-info02__description">
											<h6 class="added-info02__title"><span>Cleaner & Greener</span></h6>
											We work with the environment in mind. No harsh chemicals.
										</div>
									</a>
									<a href="#" class="added-info02__item col-md-4">
										<div class="added-info02__icon icons-686308"></div>
										<div class="added-info02__description">
											<h6 class="added-info02__title"><span>Happiness Guarantee</span></h6>
											If you're not completely satisfied with the wash or dry cleaning, we will re-process your clothes for free!
										</div>
									</a>
								</div>
							</div>
							<div class="tab-pane" id="tt-tab-02" role="tabpanel"></div>
							<div class="tab-pane" id="tt-tab-03" role="tabpanel"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tt-position-relative">
			<div class="section-indent">
				<div class="lazyload tt-obj02-bg" data-bg="images/wrapper05.png"></div>
				<div class="container">
					<div class="title-block text-center">
						<div class="title-block__label">
							[ Affordable Prices ]
						</div>
						<h4 class="title-block__title">
							Our Dry Cleaning & Laundry Prices
						</h4>
						<div class="title-block__text">
							Our prices are simple and affordable which are easy on pocket<br> in comparison with the high street prices
						</div>
					</div>
					<div class="slick-default promo03__wrapper" data-slick='{
							"slidesToShow": 4,
							"autoplaySpeed": 4500,
							"slidesToScroll": 4,
							"autoplay":true,
							"responsive": [
								{
									"breakpoint": 1025,
									"arrows": false,
									"settings": {
										"slidesToShow": 2,
										"slidesToScroll": 2
									}
								},
								{
									"breakpoint": 651,
									"settings": {
										"slidesToShow": 1,
										"slidesToScroll": 1
									}
								}
							]
						}'>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon icons-884417"></div>
									<div class="promo03__title">Shirts Service</div>
									<div class="promo03__subtitle">Washed and Pressed</div>
									<div class="promo03__price">
										<span class="tt-value">$2.00</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon icons-868044"></div>
									<div class="promo03__title">Day Dress Service</div>
									<div class="promo03__subtitle">Dry Clean</div>
									<div class="promo03__price">
										<span class="tt-value">$10.50</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon icons-1233149"></div>
									<div class="promo03__title">Dry Cleaning</div>
									<div class="promo03__subtitle">Wash, Dry and Fold</div>
									<div class="promo03__price">
										<span class="tt-value">$2.00</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon icons-495018"></div>
									<div class="promo03__title">Bedding</div>
									<div class="promo03__subtitle">Bed Set (Wash and Press)</div>
									<div class="promo03__price">
										<span class="tt-value">$10.50</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon"><i class="icons-2737832"></i></div>
									<div class="promo03__title">Blanket Service</div>
									<div class="promo03__subtitle">Washed and Pressed</div>
									<div class="promo03__price">
										<span class="tt-value">$25.00</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon"><i class="icons-863958"></i></div>
									<div class="promo03__title">Curtains Service</div>
									<div class="promo03__subtitle">Washed and Pressed</div>
									<div class="promo03__price">
										<span class="tt-value">$22.00</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon"><i class="icons-486676"></i></div>
									<div class="promo03__title">Ironing Service</div>
									<div class="promo03__subtitle">Iron and Fold</div>
									<div class="promo03__price">
										<span class="tt-value">$3.00</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tt-item">
							<div class="promo03 js-handler">
								<div class="promo03__move">
									<div class="promo03__icon"><i class="icons-1072668"></i></div>
									<div class="promo03__title">Repairs & Alterations</div>
									<div class="promo03__subtitle">Simple Sewing</div>
									<div class="promo03__price">
										<span class="tt-value">$12.00</span>
									</div>
									<div class="promo03__show-btn">
										<a href="#" class="tt-btn">
											<span class="mask">Order Now</span>
											<div class="button">Order Now</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="section-indent">
		<div class="container-fluid no-gutters">
			<div class="box02 box02__img-right">
				<div class="box02__img">
					<picture>
						<source srcset="images/box02-img02-sm.webp" media="(max-width: 650px)" type="image/webp">
						<source srcset="images/box02-img02-sm.jpg" media="(max-width: 650px)" type="image/png">
						<source srcset="images/box02-img02-md.webp" media="(max-width: 1024px)" type="image/webp">
						<source srcset="images/box02-img02-md.jpg" media="(max-width: 1024px)" type="image/png">
						<source srcset="images/box02-img02.webp" type="image/webp">
						<img src="images/box02-img02.jpg" alt="">
					</picture>
					<img class="tt-arrow" src="images/arrow-img-left02.png" alt="">
				</div>
				<div class="box02__content">
					<div class="title-block">
						<div class="title-block__label">
							[ Order even faster ]
						</div>
						<h4 class="title-block__title">
							Tap. Clean. Deliver.
						</h4>
					</div>
					<p>
						Download the our app and request our laundry service. Your clothes washed, folded and delivered to your doorstep. So go ahead and say yes to more time with the family, more happy hours, and more slapping the snooze button every morning — we've got laundry day covered.
					</p>
					<ul class="tt-list-img tt-list-img__top">
						<li><a href="#"><img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/img05.png" alt=""></a></li>
						<li><a href="#"><img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/img06.png" alt=""></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="section-indent">
		<div class="container container-fluid-lg">
			<div class="blog-slider" id="blog-slider">
				<div class="blog-slider__img">
					<div class="tt-item-wrapper">
						<div class="tt-item">
							<i><img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/quotes-img01.png" alt=""></i>
							<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/blog-slider-img01.jpg" alt="">
						</div>
						<div class="tt-item">
							<i><img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/quotes-img01.png" alt=""></i>
							<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/blog-slider-img02.jpg" alt="">
						</div>
						<div class="tt-item">
							<i><img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/quotes-img01.png" alt=""></i>
							<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/blog-slider-img03.jpg" alt="">
						</div>
						<div class="tt-item">
							<i><img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/quotes-img01.png" alt=""></i>
							<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="  class="lazyload" data-src="images/blog-slider-img04.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="blog-slider__layout slick-default slick-dots-left">
					<div class="tt-item">
						<div class="title-block">
							<div class="title-block__label">
								[ Our Testimonials ]
							</div>
							<h4 class="title-block__title">
								Professional, Reliable & Cost Effective
							</h4>
						</div>
						<blockquote>
							<p>
								"This was my first time coming to a Laundromat ever. I was greeted by a woman with a warm smile. I was looking around and she could tell I needed help. She started me up with purchasing a Laundry Card. She then gave me recommendations per the clothes I had. She was so helpful and friendly. Being new to the city this is now my go to. Very clean and up date machines. :)"
							</p>
							<p><strong class="tt-base-color02">- Teresa and Kevin K.</strong></p>
						</blockquote>
					</div>
					<div class="tt-item">
						<div class="title-block">
							<div class="title-block__label">
								[ Our Testimonials ]
							</div>
							<h4 class="title-block__title">
								Very Pleased. Will Definitely be Back.
							</h4>
						</div>
						<blockquote>
							<p>
								I don’t dry clean a lot of clothes, but I’ve been going here for 5 years and they have never once been late, the customer service is always great, and I’ve never had a quality concern. As I recall from my previous dry cleaner, they might be slightly above market cost, but I’m willing to pay a small premium for consistency though I recognize that cost may be the most important consideration.
							</p>
							<p><strong class="tt-base-color02">- Alice Munguia</strong></p>
						</blockquote>
					</div>
					<div class="tt-item">
						<div class="title-block">
							<div class="title-block__label">
								[ Our Testimonials ]
							</div>
							<h4 class="title-block__title">
								Excellent and Superb Customer Service
							</h4>
						</div>
						<blockquote>
							<p>
								“The washer and dryer at my apartment building are not so great, so this has become my go-to spot every weekend. The prices are pretty reasonable, and they have big washers so I can get a lot done at once. There are plenty of couches and tables and chairs. They have TVs, arcade games, and a pool table. It’s not a bad place to hang out and do laundry.”
							</p>
							<p><strong class="tt-base-color02">- Lena Broughton</strong></p>
						</blockquote>
					</div>
					<div class="tt-item">
						<div class="title-block">
							<div class="title-block__label">
								[ Our Testimonials ]
							</div>
							<h4 class="title-block__title">
								The Quality of Work Was Excellent!
							</h4>
						</div>
						<blockquote>
							<p>
								"I was skeptical about leaving my clothes to be washed dried and folded by someone I did not know, and let me tell you I was beyond amazed by the quality they put into the process of washing drying and folding. It was packaged and put back into the bin I delivered my dirty clothes in, and was notified through email and text when it was ready!"
							</p>
							<p><strong class="tt-base-color02">- Beverly Garmon</strong></p>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tt-position-relative tt-overflow-hidden">
		<div class="lazyload tt-obj03-bg" data-bg="images/wrapper06.png"></div>
		<div class="section-indent">
			<div class="container container-fluid-lg">
				<div class="title-block text-center">
					<div class="title-block__label">
						[ What we offer ]
					</div>
					<h4 class="title-block__title">
						Price Packages
					</h4>
					<div class="title-block__text">
						Our prices are simple and affordable which are easy on pocket<br> in comparison with the high street prices
					</div>
				</div>
				<div class="promo02__wrapper row js-init-carusel-tablet slick-default">
					<div class="tt-item col-md-4">
						<div class="promo02 js-handler">
							<div class="promo02__icon"><i class="icons-2840435"></i></div>
							<div class="promo02__title">Standard Package</div>
							<div class="promo02__subtitle">50 Clothes Per Month</div>
							<div class="promo02__show-layout">
								<ul>
									<li>4 T-Shirts</li>
									<li>1 Pairs of Jeans</li>
									<li>3 Button-Down Shirts</li>
									<li>1 Pair of Shorts</li>
									<li>7 Pairs of Underwear</li>
									<li>6 Pairs of Socks</li>
									<li>1 Towel</li>
									<li>1 Set of Sheets</li>
								</ul>
							</div>
							<div class="promo02__price">
								$349.00
							</div>
							<div class="promo02__show-btn">
								<a href="#" class="tt-btn tt-btn__wide">
									<span class="mask">Order Now</span>
									<div class="button">Order Now</div>
								</a>
							</div>
						</div>
					</div>
					<div class="tt-item col-md-4">
						<div class="promo02 js-handler">
							<div class="promo02__icon"><i class="icons-2840421"></i></div>
							<div class="promo02__title">Enterprise Package</div>
							<div class="promo02__subtitle">60 Clothes Per Month</div>
							<div class="promo02__show-layout">
								<ul>
									<li>4 T-Shirts</li>
									<li>2 Pairs of Jeans</li>
									<li>4 Button-Down Shirts</li>
									<li>2 Pair of Shorts</li>
									<li>8 Pairs of Underwear</li>
									<li>6 Pairs of Socks</li>
									<li>2 Towel</li>
									<li>2 Set of Sheets</li>
								</ul>
							</div>
							<div class="promo02__price">
								$399.00
							</div>
							<div class="promo02__show-btn">
								<a href="#" class="tt-btn tt-btn__wide">
									<span class="mask">Order Now</span>
									<div class="button">Order Now</div>
								</a>
							</div>
						</div>
					</div>
					<div class="tt-item col-md-4">
						<div class="promo02 js-handler">
							<div class="promo02__icon"><i class="icons-2230769"></i></div>
							<div class="promo02__title">Premium Package</div>
							<div class="promo02__subtitle">80 Clothes Per Month</div>
							<div class="promo02__show-layout">
								<ul>
									<li>6 T-Shirts</li>
									<li>3 Pairs of Jeans</li>
									<li>4 Button-Down Shirts</li>
									<li>2 Pair of Shorts</li>
									<li>9 Pairs of Underwear</li>
									<li>8 Pairs of Socks</li>
									<li>2 Towel</li>
									<li>2 Set of Sheets</li>
								</ul>
							</div>
							<div class="promo02__price">
								<span class="old-price">$449.00</span>
								<span class="new-price">$449.00</span>
							</div>
							<div class="promo02__show-btn">
								<a href="#" class="tt-btn tt-btn__wide">
									<span class="mask">Order Now</span>
									<div class="button">Order Now</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container section-inner container-fluid-xl no-gutters">
			<div class="tt-promo">
				<div class="tt-promo__descriptions">
					<h6 class="tt-promo__title">
						Quality Service with <br class="d-none d-lg-block">Free <span class="tt-base-color">Collection &amp; Delivery</span>
					</h6>
					<p>
						It is our goal to offer you the best possible laundry<br> and dry cleaning service available.
					</p>
					<address>
						<a href="tel:1(800)7654321">1 (800) 765-43-21</a>
					</address>
				</div>
				<div class="tt-promo__img">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAmkAAAFiAQMAAACXkN3PAAAABlBMVEUAAADq6urlXPy5AAAAAnRSTlMAAQGU/a4AAAA0SURBVHja7cExDQAAAAIgT/snNocbEAAAAAAAAAAAAAAAAAAAAOBJAwAAAAAAAAAAAABwa9XlAAnqWLNnAAAAAElFTkSuQmCC"  class="lazyload" data-src="images/promo-img-01.png" alt="">
					<img class="tt-arrow lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="images/arrow-img-left.png" alt="">
				</div>
			</div>
		</div>
	</div>
	<div id="map" class="lazyload" data-bg="images/map-index.jpg">
		<iframe src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload" data-expand="-220" data-src="https://maps.google.com/maps?&amp;q={{ urlencode($website->bookingConfiguration->line.'+'.$website->bookingConfiguration->city) }}&amp;output=embed" allowfullscreen="" aria-hidden="false"></iframe>
	</div>
</main>
@endsection