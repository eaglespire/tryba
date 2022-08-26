@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('UPDATE ACCOUNT')}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Account')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Update')}}</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="core__columns">
			<div class="core__columns-inner">
				<div class="lsvr-container">
					<div class="core__columns-grid lsvr-grid">
						<div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">
							<main id="main">
								<div class="main__inner">
									<div class="page contact-page">
										<div class="page__content">
											<div class="form-default form-top">
												<form action="{{route('customer.account.update', ['store_url'=>$store->store_url])}}" method="post">
													@csrf
													<div class="lsvr-grid lsvr-grid--2-cols lsvr-grid--md-2-cols">
														<div class="lsvr-grid__col">
															<div class="form-group">
																<label for="loginInputFirst">{{__('FIRST NAME')}} *</label>
																<input type="text" name="first_name" class="form-control" value="{{$customer->first_name}}" id="loginInputFirst" placeholder="{{__('Enter First name')}}" required>
															</div>
														</div>
														<div class="lsvr-grid__col">
															<div class="form-group">
																<label for="loginInputLast">{{__('LAST NAME')}} *</label>
																<input type="text" name="last_name" class="form-control" value="{{$customer->last_name}}" id="loginInputLast" placeholder="{{__('Enter Last name')}}" required>
															</div>
														</div>
													</div>
													<input type="hidden" name="store_id" value="{{$store->id}}">
													<input type="hidden" name="customer_id" value="{{$customer->id}}">
													<div class="form-group">
														<label for="loginInputEmail">{{__('E-MAIL')}} *</label>
														<input type="email" name="email" class="form-control" value="{{$customer->email}}" id="loginInputEmail" disabled placeholder="{{__('Enter E-mail')}}" required>
													</div>
													<div class="row mb-4">
														<label class="col-lg-12">{{__('MOBILE')}} *</label>
														<div class="col-lg-12">
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-prepend">
																			<span class="input-group-text">+{{$store->user->getCountry()->phonecode}}</span>
																		</span>
																		<input type="tel" name="phone" value="{{$customer->real_phone}}" maxlength="14" class="form-control" placeholder="{{__('Phone number')}}" required>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-auto mr-auto">
															<div class="form-group">
																<button class="lsvr-button lsvr-form__submit" id="ggglogin" type="submit">{{__('UPDATE ACCOUNT')}}</button>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</main>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop