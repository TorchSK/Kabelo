@extends('layouts.admin')
@section('content')

<div id="settings_user" data-userid="{{$user->id}}"></div>

	<div class="user_detail admin_wrapper">


		<div class="header section">

			<div class="name">
			@if ($user->name)
			{{$user->name}}
			@else
			{{$user->email}}
			@endif
			</div>
		</div>

		<div class="detail section">


			<div class="tabs">

			    <a href="/admin/user/{{$user->id}}/detail" class="tabb ui blue button" data-tab="detail">Údaje a adresy</a>
			    <a href="/admin/user/{{$user->id}}/pricing" class="tabb ui basic button" data-tab="type">Cenové zaradenie</a>
			    <a href="/admin/user/{{$user->id}}/orders" class="tabb ui basic button" data-tab="orders">Objednávky ({{$user->orders->count()}})</a>
			    <a href="/admin/user/{{$user->id}}/cart" class="tabb ui basic button" data-tab="cart">Košík ({{$user->cart->products->count()}})</a>

			</div>

		  	<div class="contents" id="right">

		    	<div class="content par active" data-tab="detail">


					<div class="labeled form">
						<div class="ui header">Základné údaje</div>

						<div class="labels">
			       			<div class="item">Email *</div>
			       			<div class="item">Telefón *</div>
			       			<div class="item">Meno *</div>
			       			<div class="item">Priezvisko *</div>

						</div>

						<div class="inputs">
					      	<div class="ui large disabled input">
					            <input type="text" name="email" value="{{$user->email}}" />
					      	</div><br/>
					      	<div class="ui large input">
					            <input type="text" name="phone" value="{{$user->phone}}" />
					      	</div><br/>
					      	<div class="ui large input">
					            <input name="first_name" type="text"  value="{{$user->first_name}}"/>
					      	</div><br/>
					      	<div class="ui large input">
					            <input name="last_name" type="text"  value="{{$user->last_name}}"/>
					      	</div>

			        </div>

						</div>

						<div class="ui header">Fakturačná adresa</div>

						<div class="labeled form">

								<div class="labels">
					       			<div class="item">Ulica *</div>
					       			<div class="item">Mesto *</div>
					       			<div class="item">PSČ *</div>
								</div>

								<div class="inputs">
								
							      
					      
					      	<div class="ui large input">
					            <input type="text" name="invoice_address_street" value="@if($user->invoiceAddress && isset(json_decode($user->invoiceAddress->address)->street)){{json_decode($user->invoiceAddress->address)->street}}@endif" />
					      	</div><br/>
					      	<div class="ui large input">
					            <input type="text"  name="invoice_address_city" value="@if($user->invoiceAddress && isset(json_decode($user->invoiceAddress->address)->city)){{json_decode($user->invoiceAddress->address)->city}}@endif" />
					      	</div><br/>
					      	<div class="ui large input">
					            <input type="text"  name="invoice_address_zip" value="@if($user->invoiceAddress && isset(json_decode($user->invoiceAddress->address)->zip)){{json_decode($user->invoiceAddress->address)->zip}}@endif" />
					      	</div><br/>
									

					        </div>

						</div>

						<div class="ui header">Doručovacia adresa</div>

							<div class="labeled form">

								<div class="labels">
									<div class="item">Meno a priezvisko *</div>
					       			<div class="item">Ulica *</div>
					       			<div class="item">Mesto *</div>
					       			<div class="item">PSČ *</div>
					       			<div class="item">Doplňujúce údaje</div>
					       			<div class="item">Telefón *</div>
								</div>

								<div class="inputs delivery_address">
								
						      	<div class="ui large input">
						            <input type="text" name="delivery_address_name" value="@if($user->deliveryAddresses->count() > 0 && isset(json_decode($user->deliveryAddresses->first()->address)->name)){{json_decode($user->deliveryAddresses->first()->address)->name}}@endif" />
						      	</div><br/>
						      	<div class="ui large input">
						            <input type="text" name="delivery_address_street" value="@if($user->deliveryAddresses->count() > 0 && isset(json_decode($user->deliveryAddresses->first()->address)->street)){{json_decode($user->deliveryAddresses->first()->address)->street}}@endif" />
						      	</div><br/>
						      	<div class="ui large input">
						            <input type="text" name="delivery_address_city" value="@if($user->deliveryAddresses->count() > 0 && isset(json_decode($user->deliveryAddresses->first()->address)->city)){{json_decode($user->deliveryAddresses->first()->address)->city}}@endif" />
						      	</div><br/>
						      	<div class="ui large input">
						            <input type="text" name="delivery_address_zip" value="@if($user->deliveryAddresses->count() > 0 && isset(json_decode($user->deliveryAddresses->first()->address)->zip)){{json_decode($user->deliveryAddresses->first()->address)->zip}}@endif" />
						      	</div><br/>
						      	<div class="ui large input">
						            <input type="text" name="delivery_address_additional" value="@if($user->deliveryAddresses->count() > 0 && isset(json_decode($user->deliveryAddresses->first()->address)->additional)){{json_decode($user->deliveryAddresses->first()->address)->additional}}@endif" />
						      	</div><br/>
						      	<div class="ui large input">
						            <input type="text" name="delivery_address_phone" value="@if($user->deliveryAddresses->count() > 0 && isset(json_decode($user->deliveryAddresses->first()->address)->phone)){{json_decode($user->deliveryAddresses->first()->address)->phone}}@endif" />
						      	</div><br/>


					        </div>

						</div>
					</div>

					
		    		
				</div>
		    

		</div>


		<div id="admin_user_options">
			<div class="ui green button" id="settings_submit_btn">Ulož zmeny</div>
		</div>
		
	</div>

@stop