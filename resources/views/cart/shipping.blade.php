@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	
	@include('cart.steps',['step'=>'3'])

	<div class="pad wrapper ct" id="cart_shipping">
	<div class="container ct">

		<div class="cart_address">

			<div class="invoice">

				<div class="labels">
	       			<div class="item">Meno *</div>
	       			<div class="item">Ulica *</div>
	       			<div class="item">Mesto *</div>
	       			<div class="item">PSČ *</div>
	       			<div class="item">Telefón *</div>
	       			<div class="item">Email *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large input">
			            <input type="text" @if(Auth::check()) value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}" @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->invoiceAddress) value="{{Auth::user()->invoiceAddress->street}}" @endif  />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->invoiceAddress) value="{{Auth::user()->invoiceAddress->city}}" @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->invoiceAddress) value="{{Auth::user()->invoiceAddress->zip}}" @endif  />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check()) value="{{Auth::user()->phone}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check()) value="{{Auth::user()->email}}"  @endif />
			      	</div><br/>

       			</div>

       		</div>


		
		<div class="ui checkbox @if($deliveryAddress) checked @endif item" id="use_delivery_address_input">
		  <input type="checkbox" name="example" @if($deliveryAddress) checked @endif>
		  <label>Chcem doručiť na inú ako fakturačnú adresu</label>
		</div>

		
   		<div class="delivery  @if($deliveryAddress) active @endif">
   				<div class="labels">
	       			<div class="item">Meno *</div>
	       			<div class="item">Ulica *</div>
	       			<div class="item">Mesto *</div>
	       			<div class="item">PSČ *</div>
	       			<div class="item">Telefón *</div>
	       			<div class="item">Email *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->deliveryAddress) value="{{Auth::user()->deliveryAddress->name}}" @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->deliveryAddress)  value="{{Auth::user()->deliveryAddress->street}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->deliveryAddress) value="{{Auth::user()->deliveryAddress->city}}" @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->deliveryAddress) value="{{Auth::user()->deliveryAddress->zip}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check() && Auth::user()->deliveryAddress) value="{{Auth::user()->deliveryAddress->phone}}" @endif  />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" @if(Auth::check()) value="{{Auth::user()->email}}"  @endif />
			      	</div><br/>

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