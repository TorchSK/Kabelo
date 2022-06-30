@extends('layouts.master')
@section('content')
	
@include('cart.steps',['step'=>'4'])

<div id="cart_confirm_wrapper" class="wrapper wrapper">
	<div class="container ct">


		<grid>

			@if (Auth::check())
				@foreach($cart->products as $product)
					@include('cart.row',['cart_confirm'=>true])
				@endforeach
			@else
				@foreach($cart['items'] as $productid)
					@if(isset(App\PriceLevel::find($cart['price_levels'][$productid])->moc_regular))
						@include('cart.row', ['product' => App\Product::find($productid),'cart_confirm'=>true])
					@endif
				@endforeach
			@endif

		</grid>

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
			    <i class="{{App\PaymentMethod::find($cart['payment_method'])->icon}} icon"></i>
			    <div class="content">
			      <div class="title">{{App\PaymentMethod::find($cart['payment_method'])->name}}</div>
			      <div class="description">{{App\PaymentMethod::find($cart['payment_method'])->desc}}</div>
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
   					<div class="item">Firma *</div>
	       			<div class="item">IČO *</div>
	       			<div class="item">DIČ *</div>
	       			<div class="item">IČ DPH</div>
				</div>

				<div class="inputs">
				   	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>6) value="{{json_decode($cart['invoice_address'])->company}}" @endif />
			      	</div><br/>
			       	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>6) value="{{json_decode($cart['invoice_address'])->ico}}" @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(count(json_decode($cart['invoice_address'], true))>6) value="{{json_decode($cart['invoice_address'])->dic}}"  @endif />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" @if(isset(json_decode($cart['invoice_address'])->icdph)) value="{{json_decode($cart['invoice_address'])->icdph}}" @endif />
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

<div id="cart_prices_wrapper" class="wrapper">
	<div class="container">

	@if($appname=="kabelo")
	<div id="cart_without_vat_price">Cena bez dph: <price>{{round($cart['price']/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</price><symbol>&euro;</symbol></div>
	<div id="cart_vat">DPH: <price>{{$cart['price'] - round($cart['price']/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</price><symbol>&euro;</symbol></div>
	@endif
	<div id="cart_product_price">Cena za tovar celkovo: <price>{{$cart['price'] }}</price> <symbol>&euro;</symbol></div>	
	<div id="cart_shipping_price">Cena za prepravu: <price>{{$cart['shipping_price']}}</price> <symbol>&euro;</symbol></div>

	@if(App\PaymentMethod::find($cart['payment_method'])->key=="dobierka" && App\DeliveryMethod::find($cart['delivery_method'])->key=='kurier-dpda')
	<div id="cart_total_price">Celková cena: 
		<price>

		

		</price> 
		<symbol>&euro;</symbol>
	</div>
	@else
	<div id="cart_total_price">Celková cena: <price>{{$cart['price'] + $cart['shipping_price']}}</price> <symbol>&euro;</symbol></div>
	@endif

</div>
</div>

<div id="cart_prices_wrapper" class="wrapper">
	<div class="container">


	<div class="ct">

		 <div class="vop_info">Stlačením „Dokončiť objednávku s povinnosťou platby“ potvrdzujete, že ste sa oboznámili s <a href="/obchodne-podmienky" target="_blank">obchodnými podmienkami</a></div>
		 <div class="gdpr_info"><a href="/obchodne-podmienky" target="_blank">Info o spracovaní osobných údajov</a></div>

		<a class="ui huge green button" id="submit_order_btn"><i class="upload icon"></i>Odoslať objednávku</a> 

	
		<div class="text_info" style="margin-top: 15px; font-size: 1.2em;">Odosielate objednávku s povinnosťou platby</div>
		
	</div>

</div>
</div>



<div id="cart_actions_wrapper" class="wrapper">
	<div class="container">
		<a href="/cart/shipping" class="ui button"><i class="arrow left icon"></i>Spať</a>
	</div>
</div>

@stop