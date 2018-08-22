@extends('layouts.master')
@section('content')
	

<div class="flex_content content cart" id="cart_detail" @if(Auth::check())data-cartid="{{Auth::user()->cart->id}}" @endif>

	

	@include('cart.steps',['step'=>'4'])

	<div class="cart_confirm">

		<div id="grid" class="products">
			<div class="ui horizontal divider">Produkty</div>

			@foreach($cart['items'] as $productid)
				@include('products.row',['product'=> App\Product::find($productid), 'cart_confirm'=>true])
			@endforeach
		</div>

		<div class="delivery ct">

			<div class="ui horizontal divider">Sposob dopravy a platba</div>

			<div class="ui steps">
			  <a class="step">
			    <i class="{{App\DeliveryMethod::find($cart['delivery_method'])->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{App\DeliveryMethod::find($cart['delivery_method'])->name}}</div>
			      <div class="description">{{App\DeliveryMethod::find($cart['delivery_method'])->desc}}</div>
			    </div>
			  </a>
			</div>

			
			<div class="ui steps">
			  <a class="step">
			    <i class="{{App\PaymentMethod::find($cart['delivery_method'])->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{App\PaymentMethod::find($cart['delivery_method'])->name}}</div>
			      <div class="description">{{App\PaymentMethod::find($cart['delivery_method'])->desc}}</div>
			    </div>
			  </a>
			</div>
			
		</div>	


		<div class="shipping ct">
			<div class="ui horizontal divider">Fakturačné @if(!$cart['delivery_address_flag'])a dodacie @endif údaje</div>

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
				
			       	<div class="ui large disabled input">
			            <input type="text" value="{{json_decode($cart['invoice_address'], true)['name']}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{json_decode($cart['invoice_address'])->street}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{json_decode($cart['invoice_address'])->city}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{json_decode($cart['invoice_address'])->zip}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{json_decode($cart['invoice_address'])->phone}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{json_decode($cart['invoice_address'])->email}}" />
			      	</div><br/>

       			</div>

       		</div>

   		<div class="ico @if($cart['ico_flag']) active @endif">
   				<div class="labels">
	       			<div class="item">IČO *</div>
	       			<div class="item">DIČ *</div>
	       			<div class="item">IČ DPH *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>6) value="{{json_decode($cart['invoice_address'])->ico}}" @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>6) value="{{json_decode($cart['invoice_address'])->dic}}"  @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>6) value="{{json_decode($cart['invoice_address'])->icdph}}" @endif />
			      	</div><br/>


       			</div>
       	</div>


   		<div class="delivery @if($cart['delivery_address_flag']) active @endif">
   				<div class="ui horizontal divider">Dodacie údaje</div>

   				<div class="labels">
	       			<div class="item">Meno *</div>
	       			<div class="item">Ulica *</div>
	       			<div class="item">Mesto *</div>
	       			<div class="item">PSČ *</div>
	       			<div class="item">Telefón *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->name}}" @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->street}}"  @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->city}}" @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->zip}}"  @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])->phone}}"  @endif />
			      	</div><br/>


       			</div>
       	</div>

	</div>
		</div>

	</div>

	<div id="cart_product_price">Cena za tovar: <price>{{$cart['price'] }}</price> <symbol>&euro;</symbol></div>	
	<div id="cart_shipping_price">Cena za prepravu: <price>{{$cart['shipping_price']}}</price> <symbol>&euro;</symbol></div>
	<div id="cart_total_price">Celková cena: <price>{{$cart['price'] + $cart['shipping_price']}}</price> <symbol>&euro;</symbol></div>

	<div class="ct">
		<div>
		<div class="ui checkbox" id="agreements_checkbox">
		  <input type="checkbox" name="example">
		  <label>Suhlasím s <a href="/obchodne-podmienky" target="_blank">obchodnými podmienkami</a> a <a href="/gdpr" target="_blank">ochranou osobných údajov</a></label>
		</div>
		</div>
		<a class="ui huge disabled green button" id="submit_order_btn"><i class="upload icon"></i>Odoslať objednávku</a>
	</div>

	<div class="ct cart_actions">
		<a href="/cart/shipping" class="ui button"><i class="arrow left icon"></i>Spať</a>
	</div>

</div>


@stop