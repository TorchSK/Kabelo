@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	
	@include('cart.steps',['step'=>'3'])

	<div class="pad wrapper ct" id="cart_shipping">
	<div class="container ct">

		<div class="cart_address">

			<div class="labels">
       			<div class="item">Meno *</div>
       			<div class="item">Priezvisko *</div>
       			<div class="item">Ulica *</div>
       			<div class="item">Číslo *</div>
       			<div class="item">Mesto *</div>
       			<div class="item">PSČ *</div>
       			<div class="item">Telefón *</div>
       			<div class="item">Email *</div>
			</div>

			<div class="inputs">
			
		       	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		       	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div>

        </div>
</div>

	</div>
	</div>

	<div class="ct cart_actions">
		<a href="/cart/delivery" class="ui button"><i class="arrow left icon"></i>Spať</a>
		<a href="/cart/confirm" class="ui green button">Pokračovať</a>
	</div>


</div>


@stop