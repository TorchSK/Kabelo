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
			    <a href="/admin/user/{{$user->id}}/pricing" class="tabb ui blue button" data-tab="type">Cenové zaradenie</a>
			    <a href="/admin/user/{{$user->id}}/orders" class="tabb ui basic button" data-tab="orders">Objednávky ({{$user->orders->count()}})</a>
			    <a href="/admin/user/{{$user->id}}/cart" class="tabb ui basic button" data-tab="cart">Košík ({{$user->cart->products->count()}})</a>

			</div>

		  	<div class="contents">

					<div class="content" data-tab="type">
						<form action="/user/{{$user->id}}" method="POST" class="admin_user_form" data-userid="{{$user->id}}">
						
           					<input name="_token" hidden value="{!! csrf_token() !!}" />
							<input name="_method" type="hidden" value="PUT">
							<input name="redirect" type="hidden" value="admin/user/{{$user->id}}">


							<div class="ui checkbox admin_checkbox_onthefly" data-resource="user" data-id="{{$user->id}}">
							  <input type="checkbox" name="voc" @if($user->voc) checked @endif >
							  <label>VOC</label>
							</div>

							<br />
							<div class="ui checkbox admin_checkbox_onthefly" data-resource="user" data-id="{{$user->id}}">
							  <input type="checkbox" name="invoice_eligible" @if($user->invoice_eligible) checked @endif >
							  <label>Nákup na faktúru</label>
							</div>

							<br /> <br />
							<div class="ui labeled input">
							  <div class="ui label">
							    Zľava %
							  </div>
							  <input type="text" name="discount" placeholder="0" value="{{$user->discount}}">
							</div>

							<div id="admin_user_options">
								<button type="submit" class="ui green button">Ulož zmeny</button>
							</div>

						</form>

					</div>

			
		    	
				</div>
		    

		</div>

		

	</div>

@stop