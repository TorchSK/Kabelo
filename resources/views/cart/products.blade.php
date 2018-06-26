@extends('layouts.master')
@section('content')
	
<div class="flex_content" id="cart_detail">
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	
	@include('cart.steps',['step'=>'1'])


	<div id="grid">
		@if (sizeof($cart['items']) > 0)
		
			@foreach($cart->products as $product)
				@include('products.row', ['productOptions'=> true])
			@endforeach
		
		@else
			<div id="empty_cart_text">Prázdný košík</div>
		
		@endif
	</div>

	<div class="ct cart_actions">
		@if (sizeof($cart['items']) > 0)
		<a href="/cart/delivery" class="ui green button">Pokračovať</a>
		@else
		<a href="/" class="ui green button">Do obchodu</a>
		@endif
	</div>

</div>


@stop