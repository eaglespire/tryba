@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<!-- PAGE HEADER : begin -->
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">

						<h1 class="page-header__title">{{__('Track order')}}</h1>
						<!-- BREADCRUMBS : begin -->
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Tracking')}}</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- BREADCRUMBS : end -->
					</div>
				</div>
			</div>
		</div>
		<!-- PAGE HEADER : end -->

		<!-- CORE COLUMNS : begin -->
		<div class="core__columns">
			<div class="core__columns-inner">
				<div class="lsvr-container">

					<!-- COLUMNS GRID : begin -->
					<div class="core__columns-grid lsvr-grid">
						<!-- MAIN COLUMN : begin -->
						<div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">

							<!-- MAIN : begin -->
							<main id="main">
								<div class="main__inner">
									<div class="page contact-page">
										<div class="page__content">
											<!-- FORM : begin -->
											<div class="form-default form-top">
												<form action="{{route('submittrackorder', ['store_url'=>$store->store_url])}}" method="post">
													@csrf
													<div class="form-group">
														<label>{{__('Order ID')}}</label>
														<input type="text" maxlength="11" name="order_id" class="form-control" placeholder="{{__('Tracking number')}}" required>
													</div>
													<div class="row">
														<div class="col-auto mr-auto">
															<div class="form-group">
																<button class="lsvr-button lsvr-form__submit" type="submit">{{__('Submit')}}</button>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- FORM : end -->

									</div>
								</div>
							</main>
							<!-- MAIN : end -->

						</div>
					</div>
					<!-- MAIN COLUMN : end -->
				</div>
				<!-- COLUMNS GRID : end -->
			</div>
		</div>
	</div>
	<!-- CORE COLUMNS : end -->
</div>
@stop