@extends('layouts.master')
@section('content')
	

<div class="flex_content content cart" id="cart_detail" @if(Auth::check())data-cartid="{{Auth::user()->cart->id}}" @endif>

	

	@include('cart.steps',['step'=>'4'])

	<div class="cart_confirm">

		<div id="grid" class="products">
						<div class="ui horizontal divider">Produkty</div>

			@foreach($cart->products as $key => $product)
				@include('products.row',['cart_confirm'=>true])
			@endforeach
		</div>

		<div class="delivery ct">

			<div class="ui horizontal divider">Sposob dopravy a platba</div>

			@foreach(App\DeliveryMethod::all() as $delivery)
			<div class="ui steps">
			  <a class="step cart_delivery @if ($cart['delivery_method']==$delivery->id) completed active @endif" data-delivery_method="{{$delivery->id}}">
			    <i class="{{$delivery->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{$delivery->name}}</div>
			      <div class="description">{{$delivery->desc}}</div>
			    </div>
			  </a>
			</div>
			@endforeach

			
			@foreach(App\PaymentMethod::all() as $payment)
			<div class="ui steps">
			  <a class="step cart_payment @if ($cart['payment_method']==$payment->id) completed active @endif @if ($cart['delivery_method'] && !in_array($cart['delivery_method'], $payment->deliveryMethods->pluck('id')->toArray())) disabled @endif" data-payment_method="{{$payment->id}}" data-delivery_methods="{{$payment->deliveryMethods->pluck('id')}}">
			    <i class="{{$payment->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{$payment->name}}</div>
			      <div class="description">{{$payment->desc}}</div>
			    </div>
			  </a>
			</div>
			@endforeach
			
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
   				<div class="ui horizontal divider">Dodacie údaje</div>

   				<div class="labels">
	       			<div class="item">IČO *</div>
	       			<div class="item">DIČ *</div>
	       			<div class="item">IČ DPH *</div>
				</div>

				<div class="inputs">
				
			       	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->ico}}" @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->dic}}"  @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>1) value="{{json_decode($cart['invoice_address'])->icdph}}" @endif />
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
			            <input type="text" @if(count(json_decode($cart['delivery_address'], true))>1) value="{{json_decode($cart['delivery_address'])['name']}}" @endif />
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

	<div class="ct">
		<a class="ui huge green button" id="submit_order_btn"><i class="upload icon"></i>Odoslať objednávku</a>
	</div>

	<div class="ct cart_actions">
		<a href="/cart/shipping" class="ui button"><i class="arrow left icon"></i>Spať</a>
	</div>

</div>


@stop