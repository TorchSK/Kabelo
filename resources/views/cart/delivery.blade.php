@extends('layouts.master')
@section('content')
	
<div class="flex_content content cart" id="cart_detail" @if(Auth::check())data-cartid="{{Auth::user()->cart->id}}" @endif>
	
	@include('cart.steps',['step'=>'2'])

	<div class="pad wrapper ct" id="cart_delivery">
	<div class="container ct">

		<div id="cart_delivery_options">
			<div class="ui horizontal divider">Sposob dopravy</div>

			@foreach(App\DeliveryMethod::all() as $delivery)
			<div class="ui steps">
			  <a class="step cart_delivery @if ($cart['delivery_method']==$delivery->id) completed active @endif" data-delivery_method="{{$delivery->id}}">
			    <i class="{{$delivery->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{$delivery->name}}</div>
			      <div class="description">{{$delivery->desc}}</div>
			    </div>
			  </a>
			</div>
			@endforeach



		</div>

		<div id="cart_payment_options">
			<div class="ui horizontal divider">Sposob plabty</div>
			
			@foreach(App\PaymentMethod::all() as $payment)
			<div class="ui steps">
			  <a class="step cart_payment @if ($cart['payment_method']==$payment->id) completed active @endif @if ($cart['delivery_method'] && !in_array($cart['delivery_method'], $payment->deliveryMethods->pluck('id')->toArray())) disabled @endif" data-payment_method="{{$payment->id}}" data-delivery_methods="{{$payment->deliveryMethods->pluck('id')}}">
			    <i class="{{$payment->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{$payment->name}}</div>
			      <div class="description">{{$payment->desc}}</div>
			    </div>
			  </a>
			</div>
			@endforeach

		</div>

	</div>

		@include('cart.prices')


	<div class="ct cart_actions">
		<a href="/cart/products" class="ui button"><i class="arrow left icon"></i>Spať</a>

		<a href="/cart/shipping" class="cart_next ui green @if ($cart['delivery_method']=='' || $cart['payment_method']=='') disabled @endif button">Pokračovať</a>
	</div>

</div>
</div>

@stop