@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="caption">Nákupný košík</div>
	<div class="actions delete_cart"><div class="ui red button">Vymaž košík</div></div>
	<div id="grid">
			@foreach( (array)$cartItems as $productid)
				@include('products.row', ['product'=>App\Product::find($productid)])
			@endforeach
	</div>
</div>


@stop