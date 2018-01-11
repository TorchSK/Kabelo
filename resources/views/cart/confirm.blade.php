@extends('layouts.master')
@section('content')
	
<div id="cart_detail">
	<div class="cart_icon ct"><i class="shopping basket huge icon"></i></div>
	<div class="caption">Nákupný košík <a class="delete_cart" data-tooltip="Vymazať obsah košíku"><i class="delete icon"></i></a></div>
	

	@include('cart.steps',['step'=>'4'])

	<div class="cart_confirm">

		<div id="grid" class="products">
						<div class="ui horizontal divider">Produkty</div>

			@foreach($products as $key => $product)
				@include('products.row', ['product'=>App\Product::find($product), 'cart_confirm'=> true])
			@endforeach
		</div>

		<div class="delivery ct">

			<div class="ui horizontal divider">Sposob dopravy a platba</div>

			@if ($delivery=='place')
			<div class="ui steps">
			  <div class="step cart_delivery data-delivery="place">
			    <i class="user icon"></i>
			    <div class="content">
			      <div class="title">Osobný odber</div>
			      <div class="description">Na predajni v Banskej Bystrici</div>
			    </div>
			  </div>
			</div>
			@endif

			@if ($delivery=='ppl')
			<div class="ui steps">
			  <div class="step cart_delivery" data-delivery="ppl">
			    <i class="truck icon"></i>
			    <div class="content">
			      <div class="title">PPL kuriér</div>
			      <div class="description">PPL prepravná spoločnosť</div>
			    </div>
			  </div>
			</div>
			@endif


			@if ($payment=='cash')				
			<div class="ui steps">
			  <div class="step cart_payment" data-payment="cash">
			    <i class="money icon"></i>
			    <div class="content">
			      <div class="title">Hotovost</div>
			      <div class="description">Pri prevzatí tovaru</div>
			    </div>
			  </div>
			</div>
			@endif

			@if ($payment=='cod')				
			<div class="ui steps">
			  <div class="step cart_payment" data-payment="cod"> 
			    <i class="cube icon"></i>
			    <div class="content">
			      <div class="title">Dobierkou</div>
			      <div class="description">Pri prevzatí balíku</div>
			    </div>
			  </div>
			</div>
			@endif

		</div>

		<div class="shipping ct">
			<div class="ui horizontal divider">Fakturačné údaje</div>

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
			            <input type="text" value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"/>
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{Auth::user()->invoiceAddress->street}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{Auth::user()->invoiceAddress->city}}"/>
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{Auth::user()->invoiceAddress->zip}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{Auth::user()->phone}}" />
			      	</div><br/>
			      	<div class="ui large disabled input">
			            <input type="text" value="{{Auth::user()->email}}" />
			      	</div><br/>

       			</div>

       		</div>

   		<div class="delivery">
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
			            <input type="text" value="{{Auth::user()->deliveryAddress->name}}"/>
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" value="{{Auth::user()->deliveryAddress->street}}" />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" value="{{Auth::user()->deliveryAddress->city}}"/>
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" value="{{Auth::user()->deliveryAddress->zip}}" />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" value="{{Auth::user()->deliveryAddress->phone}}" />
			      	</div><br/>
			      	<div class="ui large input">
			            <input type="text" value="{{Auth::user()->email}}" />
			      	</div><br/>

       			</div>
       	</div>

	</div>
		</div>

	</div>

	<div class="ct cart_actions">
		<a href="/cart/shipping" class="ui button"><i class="arrow left icon"></i>Spať</a>
		<a href="/cart/shipping" class="ui green button"><i class="upload icon"></i>Odoslať objednávku</a>
	</div>

</div>


@stop