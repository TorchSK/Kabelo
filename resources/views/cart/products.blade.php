@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	
	@include('cart.steps',['step'=>'1'])


	<div id="grid">
		@if (sizeof($cartItems) > 0)
		
			@foreach( array_unique((array)$cartItems) as $productid)
				@include('products.row', ['product'=>App\Product::find($productid), 'cart'=> true])
			@endforeach
		
		@else
			<div id="empty_cart_text">Prázdný košík</div>
		
		@endif
	</div>

	<div class="ct cart_actions">
		@if (sizeof($cartItems) > 0)
		<a href="/cart/delivery" class="ui green button">Pokračovať</a>
		@else
		<a href="/" class="ui green button">Do obchodu</a>
		@endif
	</div>

</div>


@stop