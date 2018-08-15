@extends('layouts.master')
@section('content')
	
<div class="flex_content content cart" id="cart_detail" @if(Auth::check())data-cartid="{{Auth::user()->cart->id}}" @endif>
	
	@include('cart.steps',['step'=>'3'])

	<div class="pad wrapper ct" id="cart_shipping">
	<div class="container ct">

		<div class="cart_address">

			<div class="invoice">

				<div class="labels">
	       			<div class="item">Meno *<br />(Firma)</div>
	       			<div class="item">Ulica *</div>
	       			<div class="item">Mesto *</div>
	       			<div class="item">PSČ *</div>
	       			<div class="item">Telefón *</div>
	       			<div class="item">Email *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large input" data-column="name">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->name}}" @elseif(Auth::check()) value="{{Auth::user()->name}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="street">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->street}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="city">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->city}}"  @endif/>
			      	</div><br/>
			      	<div class="ui large input" data-column="zip">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->zip}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="phone">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->phone}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="email">
			            <input type="email" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->email}}" @elseif(Auth::check()) value="{{Auth::user()->email}}" @endif />
			      	</div><br/>

       			</div>

       		</div>


		<div class="ui checkbox @if($cart['ico_flag']) checked @endif item" id="use_ico_input">
		  <input type="checkbox" name="example" @if($cart['ico_flag']) checked @endif>
		  <label>Chcem doplniť firemné údaje</label>
		</div>
		<br />

		   <div class="ico  @if($cart['ico_flag']) active @endif">
   				<div class="labels">
	       			<div class="item">ICO *</div>
	       			<div class="item">DIC *</div>
	       			<div class="item">IC DPH *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large input" data-column="ico">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->ico}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="dic">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1)  value="{{json_decode($cart['invoice_address'])->dic}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="icdph">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->icdph}}" @endif />
			      	</div><br/>


       			</div>
       	</div>


		<div class="ui checkbox @if($cart['delivery_address_flag']) checked @endif item" id="use_delivery_address_input">
		  <input type="checkbox" name="example" @if($cart['delivery_address_flag']) checked @endif>
		  <label>Chcem doručiť na inú ako fakturačnú adresu</label>
		</div>

   		<div class="delivery  @if($cart['delivery_address_flag']) active @endif">
   				<div class="labels">
	       			<div class="item">Meno *</div>
	       			<div class="item">Ulica *</div>
	       			<div class="item">Mesto *</div>
	       			<div class="item">PSČ *</div>
	       			<div class="item">Telefón *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large input" data-column="name">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->name}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="street">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1)  value="{{json_decode($cart['delivery_address'])->street}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="city">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->city}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="zip">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->zip}}"  @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="phone">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->phone}}" @endif  />
			      	</div><br/>


       			</div>
       	</div>

	</div>

	</div>
	</div>

	<div class="ct cart_actions">
		<a href="/cart/delivery" class="ui button"><i class="arrow left icon"></i>Spať</a>
		<a href="/cart/confirm" class="ui green button" id="cart_shipping_next_btn">Pokračovať</a>
	</div>


</div>


@stop