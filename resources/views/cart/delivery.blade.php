@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	
	@include('cart.steps',['step'=>'2'])

	<div class="pad wrapper ct" id="cart_delivery">
	<div class="container ct">

		<div id="cart_delivery_options">
			<div class="ui horizontal divider">Sposob dopravy</div>

			<div class="ui steps">
			  <a class="step" data-delivery="place">
			    <i class="user icon"></i>
			    <div class="content">
			      <div class="title">Osobný odber</div>
			      <div class="description">Na predajni v Banskej Bystrici</div>
			    </div>
			  </a>
			</div>
			

			<div class="ui steps">
			  <a class="step" data-delivery="ppl">
			    <i class="truck icon"></i>
			    <div class="content">
			      <div class="title">PPL kuriér</div>
			      <div class="description">PPL prepravná spoločnosť</div>
			    </div>
			  </a>
			</div>


		</div>

		<div id="cart_payment_options">
			<div class="ui horizontal divider">Sposob plabty</div>

								
			<div class="ui steps">
			  <a class="step" data-payment="cash">
			    <i class="money icon"></i>
			    <div class="content">
			      <div class="title">Hotovost</div>
			      <div class="description">Pri prevzatí tovaru</div>
			    </div>
			  </a>
			</div>

			<div class="ui steps">
			  <a class="step" data-payment="cod"> 
			    <i class="cube icon"></i>
			    <div class="content">
			      <div class="title">Dobierkou</div>
			      <div class="description">Pri prevzatí balíku</div>
			    </div>
			  </a>
			</div>
		</div>

	</div>

	<div class="ct cart_actions">
		<a href="/cart/products" class="ui button"><i class="arrow left icon"></i>Spať</a>
		<a href="/cart/shipping" class="ui green button">Pokračovať</a>
	</div>

</div>


@stop