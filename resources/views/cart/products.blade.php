@extends('layouts.master')
@section('content')
	
<div class="flex_content content cart" id="cart_detail" data-cartid="{{Auth::user()->cart->id}}">
	
	@include('cart.steps',['step'=>'1'])


	<div id="grid">
		<div class="ui inverted dimmer">
		    <div class="ui text loader">Prepočítavam</div>
		 </div>

		@if (sizeof($cart['items']) > 0)
		
			@foreach($cart->products as $product)
				@include('cart.row')
			@endforeach
		
		@else
			<div id="empty_cart_text">Prázdný košík</div>
		
		@endif
	</div>
	@if(Auth::check())
	<div id="cart_user_discount" @if(Auth::user()->discount==0) class="hidden" @endif>Vaša zľava: <price>{{Auth::user()->discount}}</price> <symbol>%</symbol></div>
	@else
	<div id="cart_user_discount" class="hidden">Vaša zľava: <price>0</price> <symbol>%</symbol></div>
	@endif

	<div id="cart_total_price">Celková cena: <price></price> <symbol>&euro;</symbol></div>

	<div class="cart_actions">
		@if (sizeof($cart['items']) > 0)
		<a href="/#eshop" class="ui blue button"><i class="icon arrow left"></i>Do eshopu</a>
		<a href="/cart/delivery" class="ui green button" id="cart_continue_btn">Pokračovať</a>

		@else
		<a href="/" class="ui green button">Do eshopu</a>
		@endif
	</div>

</div>


@stop