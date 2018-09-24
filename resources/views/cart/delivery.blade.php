@extends('layouts.master')
@section('content')

<div id="cart_detail" class="hiden" @if(Auth::check()) data-cartid="{{Auth::user()->cart->id}}" @endif></div>

@include('cart.steps',['step'=>'2'])

<div id="cart_products_wrapper" class="wrapper">
	<div class="container ct">


		<div id="cart_delivery_options">
			<div class="ui horizontal divider">Sposob dopravy</div>

			@foreach(App\DeliveryMethod::all() as $delivery)
				@include('cart.deliveryRow',['context'=>'eshop'])
			@endforeach



		</div>

		<div id="cart_payment_options ct">
			<div class="ui horizontal divider">Sposob plabty</div>
			
			@foreach(App\PaymentMethod::all() as $payment)

			@if ($payment->key != 'faktura'  || ($payment->key == 'faktura' && Auth::check() && Auth::user()->invoice_eligible==1))
				@include('cart.paymentRow',['context'=>'eshop'])
			@endif
			@endforeach

		</div>

	</div>
</div>

<div id="cart_info_wrapper" class="wrapper">
	<div class="container">
		<div class="ct">
		<i class="info huge grey icon"></i>
		</div>
		
		<div class="notes_list">
			<div class="delivery_note">
				@if ($cart['delivery_method'])
					{{App\DeliveryMethod::find($cart['delivery_method'])->note}}
				@endif
			</div>
			<div class="payment_note">
				@if ($cart['payment_method'])
					{{App\PaymentMethod::find($cart['payment_method'])->note}}
				@endif
			</div>
		</div>

	</div>
</div>

<div id="cart_prices_wrapper" class="wrapper">
	<div class="container">

	@if($appname=="kabelo")
	<div id="cart_without_vat_price">Cena bez dph: <price>{{round($cart['price']/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</price><symbol>&euro;</symbol></div>
	<div id="cart_vat">DPH: <price>{{$cart['price'] - round($cart['price']/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</price><symbol>&euro;</symbol></div>
	@endif
	<div id="cart_shipping_price">Cena za prepravu: <price>{{$cart['shipping_price']}}</price><symbol>&euro;</symbol></div>
	<div id="cart_total_price" data-price="{{$cart['price']}}">Celková cena: <price>{{$cart['price'] + $cart['shipping_price']}}</price><symbol>&euro;</symbol></div>

	</div>
</div>



<div id="cart_actions_wrapper" class="wrapper">
	<div class="container">

		<a href="/cart/products" class="ui button"><i class="arrow left icon"></i>Spať</a>

		<a href="/cart/shipping" class="cart_next ui green @if (!$cart['delivery_method']|| !$cart['payment_method']) disabled @endif button">Pokračovať</a>
	</div>

</div>


@stop