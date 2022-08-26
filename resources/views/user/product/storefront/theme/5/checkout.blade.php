@extends('user.product.theme.5.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{__('Checkout')}}</a></li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder">{{__('SHOPPING CART')}}</h1>
            <div class="tt-shopcart-table-02">
                <form method="post" action="{{route('customer.update.cart')}}">
                    @csrf
                    <table>
                        <tbody>
                            @foreach($cart as $val)
                            <input type="hidden" name="uniqueid[]" value="{{$val->id}}">
                            <tr>
                                <td>
                                    <div class="tt-product-img">
                                        <img @if($val->req->new==0)
                                        data-src="{{asset('asset/images/product-placeholder.jpg')}}"
                                        @else
                                        @php $sub=App\Models\Productimage::whereproduct_id($val->req->id)->first();@endphp
                                        data-src="{{asset('asset/profile/'.$sub->image)}}"
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
                                            <div class="detach-quantity-mobile"></div>
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
                                    <div class="detach-quantity-desctope">
                                        <div class="tt-input-counter style-01">
                                            <span class="minus-btn" id="minus-btn{{$val->id}}"></span>
                                            <input type="number" value="{{$val->quantity}}" id="quantity{{$val->id}}" name="quantity[]" min="1" max="{{$val->req->quantity}}" size="{{$val->req->quantity}}">
                                            <span class="plus-btn" id="plus-btn{{$val->id}}"></span>
                                            <input id="cost{{$val->id}}" value="{{$val->cost}}" type="hidden">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="tt-price subtotal">
                                        {{$store->user->cc->coin->symbol}}<span id="ddtotal{{$val->id}}">{{number_format($val->quantity*$val->cost)}}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('delete.cart', ['id'=>$val->id])}}" class="tt-btn-close"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="tt-shopcart-btn">
                        <div class="col-left">
                            <a class="btn-link" href="{{route('website.link', ['id' => $store->store_url])}}"><i class="icon-e-19"></i>{{__('CONTINUE SHOPPING')}}</a>
                        </div>
                        <div class="col-right">
                            <a class="btn-link" href="{{route('customer.empty.cart', ['id'=>$unique->uniqueid, 'store_url'=>$store->store_url])}}"><i class="icon-h-02"></i>{{__('CLEAR SHOPPING CART')}}</a>
                            <button class="btn btn-primary" type="submit"><i class="icon-h-48"></i>{{__('UPDATE CART')}}</button>
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
                                    <button type="submit" class="btn btn-primary">{{__('Apply')}}</button>
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
                            <p>{{__('Enter your destination to get a shipping estimate')}}.</p>
                            <form action="{{route('check.product')}}" method="post" class="form-default">
                                @csrf
                                <div class="form-group">
                                    <label for="address_country">{{__('Address')}} <sup>*</sup></label>
                                    <select name="shipping" id="ship_fee" onchange="gvals()" class="form-control">
                                        <option value="">Select Address</option>
                                        @foreach($address as $val)
                                        <option value="{{$val->id}}-{{$val->country->amount}}">{{$val->line_1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="2" name="note" placeholder="Additional Note"></textarea>
                                </div>
                                <input type="hidden" id="xship3" name="xship">
                                <input type="hidden" id="xship_fee3" name="shipping_fee">
                                <input type="hidden" id="amount3" value="{{$total}}" name="amount">                  
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
                                            @if($coupon_status==1)
                                            <td>{{$store->user->cc->coin->symbol}}<span id="subtotal3">{{number_format($subtotal+$coupon_amount, 2)}}</td>
                                            @else
                                            <td>{{$store->user->cc->coin->symbol}}<span id="subtotal3">{{number_format($subtotal, 2)}}</td>
                                            @endif
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
                                            <td>{{$store->user->cc->coin->symbol}}<span id="total3">{{number_format($total,2)}}</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="custom-control custom-control-alternative custom-checkbox mb-6 text-left">
                                    <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="terms" checked required>
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <p class="text-muted">{{__('This transaction requires your consent before continuing and we have selected it for you. Please read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                                    </label>
                                </div>
                                @if($errors->has('terms'))
                                <span class="text-xs text-uppercase mt-3">{{$errors->first('terms')}}</span>
                                @endif
                                <div class="text-left">
                                    <h3 class="form-text text-xl text-dark font-weight-bolder">{{__('Payment method')}} </h3>
                                    @if($merchant->cc->bank_pay==1)
                                    @if($merchant->bank_pay==1)
                                    <div class="bg-gray rounded mb-3">
                                        <div class="custom-control custom-control-alternative custom-radio">
                                            <input class="custom-control-input" id="customCheckgLogin" type="radio" name="action" value="bank" required>
                                            <label class="custom-control-label" for="customCheckgLogin">
                                                {{__('Pay with Open Banking')}}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @if($merchant->cc->paypal==1)
                                    @if($merchant->paypal==1)
                                    <div class="bg-gray rounded mb-3">
                                        <div class="custom-control custom-control-alternative custom-radio">
                                            <input class="custom-control-input" id="customCheckxLogin" type="radio" name="action" value="paypal" required>
                                            <label class="custom-control-label" for="customCheckxLogin">
                                                {{__('Pay with Paypal')}}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @if($merchant->cc->coinbase==1)
                                    @if($merchant->coinbase==1)
                                    <div class="bg-gray rounded mb-3">
                                        <div class="custom-control custom-control-alternative custom-radio">
                                            <input class="custom-control-input" id="customCheckdLogin" type="radio" name="action" value="coinbase" required>
                                            <label class="custom-control-label" for="customCheckdLogin">
                                                {{__('Pay with Coinbase')}}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @if($merchant->cc->coinbase==1)
                                    @if($merchant->coinbase==1)
                                    @if($set->buy_crypto!=null)
                                    <p class="text-dark mb-2">{{__('If you don\'t have crypto or you want to buy crypto')}},<a target="_blank" href="{{$set->buy_crypto}}"> {{__('click here')}}</a></p>
                                    @endif
                                    @endif
                                    @endif
                                </div>
                                <div class="text-center mt-6">
                                    <button type="submit" class="btn btn-primary btn-block">{{__('Pay')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
Session::put('return_url', url()->current());
@endphp
@stop
@section('script')
@foreach($cart as $val)
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
@endsection