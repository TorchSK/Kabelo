@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík</div>
	<div class="actions delete_cart"><div class="ui red button">Vymaž košík</div></div>

	<div class="status">
	<div class="ui ordered steps">
	  <a class="active step">
	    <div class="content">
	      <div class="title">Shipping</div>
	      <div class="description">Choose your shipping options</div>
	    </div>
	  </a>
	  <div class="step">
	    <div class="content">
	      <div class="title">Billing</div>
	      <div class="description">Enter billing information</div>
	    </div>
	  </div>
	  <div class="step">
	    <div class="content">
	      <div class="title">Confirm Order</div>
	      <div class="description">Verify order details</div>
	    </div>
	  </div>
	</div>
	</div>

	<div id="grid">
			@foreach( (array)$cartItems as $productid)
				@include('products.row', ['product'=>App\Product::find($productid), 'cart'=> true])
			@endforeach
	</div>
</div>


@stop