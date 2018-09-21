@extends('layouts.admin')
@section('content')

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

			    <a href="/admin/user/{{$user->id}}/detail" class="tabb ui basic button" data-tab="detail">Údaje a adresy</a>
			    <a href="/admin/user/{{$user->id}}/pricing" class="tabb ui basic button" data-tab="type">Cenové zaradenie</a>
			    <a href="/admin/user/{{$user->id}}/orders" class="tabb ui basic button" data-tab="orders">Objednávky ({{$user->orders->count()}})</a>
			    <a href="/admin/user/{{$user->id}}/cart" class="tabb ui blue button" data-tab="cart">Košík ({{$user->cart->products->count()}})</a>

			</div>

		  	<div class="contents">
					<div id="cart_products_wrapper" class="content cart" data-cartid="{{$user->cart->id}}">
											
							<div class="ui inverted dimmer">
							    <div class="ui text loader">Prepočítavam</div>
							 </div>

							@if ($user->cart->count()> 0)
							
								@foreach($user->cart->products as $product)
									@include('cart.row')
								@endforeach
							
							@else
								<div id="empty_cart_text">Prázdný košík</div>
							@endif

					
								<div class="ui product cart search">
							  <input class="prompt" type="text" placeholder="Pridaj produkt">
							  <div class="results"></div>
							</div>

					</div>
		    		
				</div>
		    

		</div>
	</div>

@stop