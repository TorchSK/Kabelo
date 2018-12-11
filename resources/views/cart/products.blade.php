@extends('layouts.master')
@section('content')

<div id="cart_detail" class="hiden" @if(Auth::check()) data-cartid="{{Auth::user()->cart->id}}" @endif></div>

@include('cart.steps',['step'=>'1'])

<div id="cart_products_wrapper" class="wrapper">
	<div class="container">
		@if (sizeof($cart['items']) > 0)
		<div class="delete_cart">Vymazať košík</div>
		@endif

		<div class="ui inverted dimmer">
		    <div class="ui text loader">Prepočítavam</div>
		 </div>

		@if (sizeof($cart['items']) > 0)
			
			@if (Auth::check())
				@foreach($cart->products as $product)
					@include('cart.row')
				@endforeach
			@else
				@foreach($cart['items'] as $productid)
					@if(isset(App\PriceLevel::find($cart['price_levels'][$productid])->moc_regular))
						@include('cart.row', ['product' => App\Product::find($productid)])
					@endif
				@endforeach
			@endif
			
		@else
			<div id="empty_cart_text">Prázdný košík</div>
		
		@endif
	</div>
</div>

@include('cart.prices')


<div id="cart_actions_wrapper" class="wrapper">
	<div class="container">
	@if (sizeof($cart['items']) > 0)
	<a href="/#eshop" class="ui blue button"><i class="icon arrow left"></i>Do eshopu</a>
	<a href="/cart/delivery" class="ui green button @if(App\Setting::firstOrCreate(['name'=>'min_order_price'])->first()->value > $cart['price']) disabled @endif" id="cart_continue_btn">Pokračovať</a>

	@else
	<a href="/" class="ui green button">Do eshopu</a>
	@endif
</div>
</div>



@stop