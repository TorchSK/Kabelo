@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	

	@include('cart.steps',['step'=>'4'])

	<div id="grid">
		@foreach( array_unique((array)$cartItems) as $productid)
			@include('products.row', ['product'=>App\Product::find($productid), 'cart'=> true])
		@endforeach
	</div>

	<div class="ct cart_actions">
		<div class="ui green button">Pokračovať</div>
	</div>

</div>


@stop