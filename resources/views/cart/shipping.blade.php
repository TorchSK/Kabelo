@extends('layouts.master')
@section('content')

@include('cart.steps',['step'=>'3'])

<div id="cart_shipping_wrapper" class="wrapper">
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
			       	<div class="ui large input" data-column="name">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->name}}" @elseif(Auth::check()) value="{{Auth::user()->first_name.' '.Auth::user()->last_name}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="street">
			            <input type="text" class=" class="invoice_street_number" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->street}}" @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->street)) value="{{json_decode(Auth::user()->invoiceAddress->address)->street}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="city">
			            <input type="text" class="invoice_administrative_area_level_1" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->city}}"  @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->city)) value="{{json_decode(Auth::user()->invoiceAddress->address)->city}}" @endif/>
			      	</div><br/>
			      	<div class="ui large input" data-column="zip">
			            <input type="text" class="invoice_postal_code" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->zip}}"  @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->zip)) value="{{json_decode(Auth::user()->invoiceAddress->address)->zip}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="phone">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->phone}}" @elseif(Auth::check() && isset(Auth::user()->phone)) value="{{Auth::user()->phone}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="email">
			            <input type="email" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->email}}" @elseif(Auth::check()) value="{{Auth::user()->email}}" @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->street)) value="{{json_decode(Auth::user()->invoiceAddress->address)->street}}" @endif />
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
   					<div class="item">Firma *</div>
	       			<div class="item">ICO *</div>
	       			<div class="item">DIC *</div>
	       			<div class="item">IC DPH</div>
				</div>

				<div class="inputs">
				     <div class="ui large mandatory input" data-column="company">
			            <input type="text" id="autocomplete" class=" class="invoice_company" @if(isset(json_decode($cart['invoice_address'])->company)) value="{{json_decode($cart['invoice_address'])->company}}" @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->company)) value="{{json_decode(Auth::user()->invoiceAddress->address)->company}}" @endif />
			      	</div><br/>
				     <div class="ui large mandatory input" data-column="ico">
			            <input type="text" id="autocomplete" class=" class="invoice_company" @if(isset(json_decode($cart['invoice_address'])->ico)) value="{{json_decode($cart['invoice_address'])->ico}}" @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->ico)) value="{{json_decode(Auth::user()->invoiceAddress->address)->ico}}" @endif />
			      	</div><br/>
			   		<div class="ui large mandatory input" data-column="dic">
			            <input type="text" id="autocomplete" class=" class="invoice_company" @if(isset(json_decode($cart['invoice_address'])->dic)) value="{{json_decode($cart['invoice_address'])->company}}" @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->dic)) value="{{json_decode(Auth::user()->invoiceAddress->address)->dic}}" @endif />
			      	</div><br/>
			      	<div class="ui large input" data-column="icdph">
			            <input type="text" id="autocomplete" class=" class="invoice_company" @if(isset(json_decode($cart['invoice_address'])->icdph)) value="{{json_decode($cart['invoice_address'])->company}}" @elseif(Auth::check() && isset(json_decode(Auth::user()->invoiceAddress->address)->icdph)) value="{{json_decode(Auth::user()->invoiceAddress->address)->icdph}}" @endif />
			      	</div><br/>


       			</div>
       	</div>

       	@if($cart['delivery_method'] != 1)

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
       	@endif
       	
	</div>

	</div>
</div>


<div id="cart_actions_wrapper" class="wrapper">
	<div class="container">
		<a href="/cart/delivery" class="ui button"><i class="arrow left icon"></i>Spať</a>
		<a href="/cart/confirm" class="ui green button" id="cart_shipping_next_btn">Pokračovať</a>
	</div>
</div>

@stop