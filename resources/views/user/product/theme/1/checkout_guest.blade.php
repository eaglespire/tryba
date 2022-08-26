@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<!-- PAGE HEADER : begin -->
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">

						<h1 class="page-header__title">{{__('Checkout')}}</h1>
						<!-- BREADCRUMBS : begin -->
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Checkout')}}</a>
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
                                            <div class="tt-shopcart-table-02">
                                                <form action="{{route('customer.update.cart')}}" method="post">
                                                    @csrf
                                                    <table>
                                                        <tbody>
                                                            @foreach(getStorefrontCart($store->id) as $val)
                                                            <input type="hidden" name="uniqueid[]" value="{{$val->id}}">
                                                            <tr>
                                                                <td>
                                                                    <div class="tt-product-img">
                                                                    <img @if($val->req->new==0)
                                                                        src="{{asset('asset/images/product-placeholder.jpg')}}"
                                                                        @else
                                                                        @php $sub=App\Models\Productimage::whereproduct_id($val->req->id)->first();@endphp
                                                                        src="{{asset('asset/profile/'.$sub->image)}}"
                                                                        @endif alt="$val->req->name">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h2 class="tt-title">
                                                                        <a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->req->ref_id])}}">{{$val->title}}</a>
                                                                    </h2>
                                                                    <ul class="tt-list-description">
                                                                        @if($val->size!=null)
                                                                        <li>{{__('Size')}}: {{$val->size}}</li>
                                                                        @endif
                                                                        @if($val->color!=null)
                                                                        <li>{{__('Color')}}: <span style="background-color:{{$val->color}};min-width: 10px;max-width: 10px;min-height: 10px;max-height: 10px; border-radius: 50%; display: inline-block;"></span></li>
                                                                        @endif
                                                                        @if($val->length!=null)
                                                                        <li>{{__('Length')}}: {{$val->length}}</li>
                                                                        @endif
                                                                        @if($val->weight!=null)
                                                                        <li>{{__('Weight')}}: {{$val->weight}}</li>
                                                                        @endif
                                                                    </ul>
                                                                    <ul class="tt-list-parameters">
                                                                        <li>
                                                                            <div class="tt-price">
                                                                                {{$store->user->cc->coin->symbol}}{{number_format($val->cost)}}
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                        <p class="product-cart__item-quantity quantity-field">
                                                                            <input type="text" class="quantity-field__input" value="{{$val->quantity}}" id="quantity{{$val->id}}" name="quantity[]" min="1" max="{{$val->req->quantity}}" size="{{$val->req->quantity}}">
                                                                            <button type="button" class="quantity-field__btn quantity-field__btn--add" title="Add one">
                                                                                <span class="quantity-field__btn-icon" id="plus-btn{{$val->id}}" aria-hidden="true"></span>
                                                                            </button>
                                                                            <button type="button" class="quantity-field__btn quantity-field__btn--remove" title="Remove one">
                                                                                <span class="quantity-field__btn-icon" id="minus-btn{{$val->id}}" aria-hidden="true"></span>
                                                                            </button>
                                                                            <input id="cost{{$val->id}}" value="{{$val->cost}}" name="cost[]" type="hidden">
                                                                        </p>
                                                                        </li>
                                                                        <li>
                                                                            <div class="tt-price subtotal">
                                                                                {{$store->user->cc->coin->symbol}}<span id="dmtotal{{$val->id}}">{{number_format($val->quantity*$val->cost)}}</span>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <div class="tt-price">
                                                                        {{$store->user->cc->coin->symbol}}{{number_format($val->cost)}}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="product-cart__item-quantity quantity-field">
                                                                        <input type="text" class="quantity-field__input" value="{{$val->quantity}}" id="quantity{{$val->id}}" name="quantity[]" min="1" max="{{$val->req->quantity}}" size="{{$val->req->quantity}}">
                                                                        <button type="button" class="quantity-field__btn quantity-field__btn--add" title="Add one">
                                                                            <span class="quantity-field__btn-icon" id="plus-btn{{$val->id}}" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button type="button" class="quantity-field__btn quantity-field__btn--remove" title="Remove one">
                                                                            <span class="quantity-field__btn-icon" id="minus-btn{{$val->id}}" aria-hidden="true"></span>
                                                                        </button>
                                                                        <input id="cost{{$val->id}}" value="{{$val->cost}}" name="cost[]" type="hidden">
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    <div class="tt-price subtotal">
                                                                        {{$store->user->cc->coin->symbol}}<span id="ddtotal{{$val->id}}">{{number_format($val->quantity*$val->cost)}}</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="{{route('delete.cart', ['id'=>$val->id])}}" class="fal fa-trash"></a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="tt-shopcart-btn">
                                                        <div class="col-left">
                                                            <a class="mb-2" href="{{route('website.link', ['id' => $store->store_url])}}"><i class="icon-e-19"></i>{{__('CONTINUE SHOPPING')}}</a>
                                                        </div>
                                                        <div class="col-right">
                                                            @if(count(getStorefrontCart($store->id))>0)
                                                            <a class="mr-2 mb-2" href="{{route('customer.empty.cart', ['id'=>$unique->uniqueid, 'store_url'=>$store->store_url])}}"><i class="icon-h-02"></i>{{__('CLEAR SHOPPING CART')}}</a>
                                                            @endif
                                                            <button class="lsvr-button lsvr-form__submit mb-2" type="submit"><i class="icon-h-48"></i>{{__('UPDATE CART')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            @if(count(getStorefrontCart($store->id))>0)
                                            <div class="tt-shopcart-col">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12">
                                                        <div class="tt-shopcart-box">
                                                            <h4 class="tt-title">
                                                                {{__('Coupon')}}
                                                            </h4>
                                                            <form action="{{route('check.coupon', ['id'=> getStorefrontCartFirst($store->id)->uniqueid])}}" method="post" class="form-default">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input class="form-control" type="text" @if($coupon_status==1) value="{{$coupon->code}}" @endif name="code" placeholder="Enter Coupon Code">
                                                                </div>
                                                                <div class="text-left mt-6">
                                                                    <button type="submit" class="lsvr-button lsvr-form__submit">{{__('Apply')}}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            @endif         
                                            <div class="tt-shopcart-col">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12">
                                                        <div class="tt-shopcart-box">
                                                            <h4 class="tt-title">
                                                                {{__('ESTIMATE SHIPPING')}}
                                                            </h4>
                                                            <p>{{__('Enter your destination to get a shipping estimate.')}}</p>
                                                            <form action="{{route('check.product')}}"  id="payment-form" method="post" class="form-default">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="loginInputEmail">{{__('E-MAIL')}} *</label>
                                                                    <input type="email" name="email" class="form-control" id="loginInputEmail"  value="@if(session('email')){{session('email')}}@endif" placeholder="{{__('Enter E-mail')}}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('STATE/COUNTY')}} *</label>
                                                                    <select class="form-control" id="state" @if(session('country')==$val->id)selected @endif onchange="gvals2()" name="shipping" required>
                                                                        <option value="">{{__('Select your state/county')}}</option>
                                                                        @foreach($shipping as $val)
                                                                        <option value="{{$val->state}}*{{$val->id}}*{{$val->amount}}*{{$val->shippingState->iso2}}">{{$val->shippingState->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea class="form-control" rows="3" name="note" placeholder="{{__('Additional Note')}}">@if(session('note')){{session('note')}}@endif</textarea>
                                                                </div>
                                                                <input type="hidden" id="xship3" name="xship">
                                                                <input type="hidden" id="xship_fee3" name="shipping_fee">
                                                                <input type="hidden" id="amount3" value="{{number_format($total)}}" name="amount">
                                                                @if($coupon_status==1)
                                                                <input type="hidden" id="coupon" value="{{$coupon_amount}}" name="coupon">
                                                                <input type="hidden" value="{{$coupon->code}}" name="coupon_code">
                                                                @else
                                                                <input type="hidden" id="coupon" value="0" name="coupon">
                                                                <input type="hidden" id="coupon" value="0" name="coupon">
                                                                @endif
                                                                <input type="hidden" value="{{$coupon_status}}" name="coupon_status">
                                                                <input type="hidden" id="tax" value="{{$subtotal*$store->tax/100}}" name="amount">
                                                                <input type="hidden" name="product_id" value="{{$product->uniqueid}}">
                                                                <table class="tt-shopcart-table01 text-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>{{__('SUBTOTAL')}}</th>
                                                                            <td>{{$store->user->cc->coin->symbol}}<span id="subtotal3">{{number_format($subtotal)}}</td>
                                                                        </tr>
                                                                        @if($coupon_status==1)                                  
                                                                        <tr>
                                                                            <th>{{__('COUPON')}}</th>
                                                                            <td>-{{$store->user->cc->coin->symbol}}<span id="coupon3">{{number_format($coupon_amount, 2)}}</span></td>
                                                                        </tr> 
                                                                        @endif 
                                                                        <tr>
                                                                            <th>{{__('SHIPPING')}}</th>
                                                                            <td>+{{$store->user->cc->coin->symbol}}<span id="flat3">0</span></td>
                                                                        </tr>
                                                                        @if($store->vat!=null)                                    
                                                                        <tr>
                                                                            <th>{{__('VAT')}} ({{$store->tax}}%)</th>
                                                                            <td>+{{$store->user->cc->coin->symbol}}<span id="tax3">{{number_format($subtotal*$store->tax/100, 2)}}</span></td>
                                                                        </tr>
                                                                        @endif
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>{{__('GRAND TOTAL')}}</th>
                                                                            <td>{{$store->user->cc->coin->symbol}}<span id="total3">{{number_format($total)}}</span></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="text-left">
                                                                    <h3 class="form-text text-xl font-weight-bolder">{{__('Payment method')}} </h3>
                                                                    @if($merchant->cc->bank_pay == 1 AND $merchant->bank_pay==1)
                                                                        <div class="bg-gray rounded mb-3">
                                                                            <div class="custom-control custom-control-alternative custom-radio form-inline">
                                                                                <input class="custom-control-input" id="customCheckgLogin" type="radio" name="action" value="bank" required>
                                                                                <label class="custom-control-label ml-2" for="customCheckgLogin">
                                                                                    {{__('Pay with Open Banking')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($merchant->cc->paypal == 1 AND $merchant->paypal == 1)
                                                                        <div class="bg-gray rounded mb-3">
                                                                            <div class="custom-control custom-control-alternative custom-radio form-inline">
                                                                                <input class="custom-control-input" id="customCheckxLogin" type="radio" name="action" value="paypal" required>
                                                                                <label class="custom-control-label ml-2" for="customCheckxLogin">
                                                                                    {{__('Pay with Paypal')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($merchant->cc->coinbase == 1 AND $merchant->coinbase == 1)
                                                                        <div class="bg-gray rounded mb-3">
                                                                            <div class="custom-control custom-control-alternative custom-radio form-inline">
                                                                                <input class="custom-control-input" id="customCheckdLogin" type="radio" name="action" value="coinbase" required>
                                                                                <label class="custom-control-label ml-2" for="customCheckdLogin">
                                                                                    {{__('Pay with Coinbase')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    @if($merchant->cc->coinbase==1 AND $merchant->coinbase==1 AND $set->buy_crypto!=null)
                                                                        <p class="mb-3">{{__('If you don\'t have crypto or you want to buy crypto')}},<a target="_blank" href="{{$set->buy_crypto}}"> {{__('click here')}}</a></p>
                                                                    @endif
                                                                </div>
                                                                <div class="text-center mt-6">
                                                                    <button type="submit" id="ggglogin" class="lsvr-button lsvr-form__submit">{{__('Pay')}}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										</div>
										<!-- FORM : end -->

									</div>
								</div>
							</main>
						</div>
						<!-- MAIN : end -->

					</div>
					<!-- MAIN COLUMN : end -->
				</div>
				<!-- COLUMNS GRID : end -->
			</div>
		</div>
	</div>
	<!-- CORE COLUMNS : end -->
</div>
@php
Session::put('return_url', url()->current());
@endphp
@stop
@php
Session::forget('email');
Session::forget('first_name');
Session::forget('last_name');
Session::forget('code');
Session::forget('phone');
Session::forget('note');
Session::forget('country');
Session::forget('state');
Session::forget('city');
Session::forget('line_1');
Session::forget('line_2');
Session::forget('postal_code');
@endphp
@section('script')
@foreach(getStorefrontCart($store->id) as $val)
<script>
	$(document).ready(function() {
		var quantitiy@php echo $val->id;@endphp = 0;
		$('#plus-btn{{$val->id}}').click(function(e) {
			e.preventDefault();
			var quantity@php echo $val->id;@endphp = parseInt($('#quantity{{$val->id}}').val());
			var cost@php echo $val->id;@endphp = $('#cost{{$val->id}}').val();
			var max@php echo $val->id;@endphp = $('#quantity{{$val->id}}').attr('max');
			if (quantity@php echo $val->id; @endphp < max@php echo $val->id; @endphp) {
				var cc@php echo $val->id;@endphp = quantity@php echo $val->id;@endphp + 1;
				var sub@php echo $val->id;@endphp = cc@php echo $val->id;@endphp * parseFloat(cost@php echo $val->id; @endphp);
				$('#quantity{{$val->id}}').val(quantity@php echo $val->id; @endphp + 1);
				$('#ddtotal{{$val->id}}').text(Math.round(sub@php echo $val->id; @endphp));
				$('#dmtotal{{$val->id}}').text(Math.round(sub@php echo $val->id; @endphp));
			}
		});
		$('#minus-btn{{$val->id}}').click(function(e) {
			e.preventDefault();
			var quantity@php echo $val->id;@endphp = parseInt($('#quantity{{$val->id}}').val());
			var cost@php echo $val->id;@endphp = $('#cost{{$val->id}}').val();
			var min@php echo $val->id;@endphp = $('#quantity{{$val->id}}').attr('min');
			if (quantity@php echo $val->id;@endphp > min@php echo $val->id;@endphp) {
				var cc@php echo $val->id;@endphp = quantity@php echo $val->id;@endphp - 1;
				var sub@php echo $val->id;@endphp = cc@php echo $val->id;@endphp * parseFloat(cost@php echo $val->id;@endphp);
				$('#quantity{{$val->id}}').val(quantity@php echo $val->id; @endphp - 1);
				$('#ddtotal{{$val->id}}').text(Math.round(sub@php echo $val->id;@endphp));
				$('#dmtotal{{$val->id}}').text(Math.round(sub@php echo $val->id;@endphp));
			}
		});

	});
</script>
@endforeach
<script>
    function addresschange() {
      var selectedState = $("#state").find(":selected").val();
      $.ajax({
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "{{route('customer.address.state')}}",
        data: {
          "_token": "{{ csrf_token() }}",
          state: selectedState
        },
        success: function(response) {
          console.log(response);
          if (response.trim() == '') {
            $('#showState').hide();
            $('#city').removeAttr('required', '');
          } else {
            $('#showState').show();
            $('#city').html(response);
            $('#city').attr('required', '');
          }
        },
        error: function(err) {
          console.log(err)
        }
      });
    }
    $("#state").change(addresschange);
  </script>
@endsection