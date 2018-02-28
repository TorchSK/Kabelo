@extends('layouts.admin')
@section('content')



<div class="admin_settings">
	<div class="ui horizontal divider">Banery</div>

	<div class="admin_banner_list">
		@foreach(App\Cover::all() as $cover)
			<img src="/{{$cover->image}}" />
		@endforeach

		<a href="{{route('admin.addCover')}}" class="ui blue button">Pridať baner</a>
	</div>



	<div class="ui horizontal divider">Sposoby dopravy</div>

	<table class="ui celled padded table">
	  <thead>
	    <tr>
		    <th>Kód</th>
		    <th>Názov</th>
		   	<th>Popis</th>
		    <th>Ikona</th>
		    <th>Akcie</th>
	  	</tr>
	</thead>
	<tbody class="admin_method_list" data-type="delivery">
	@foreach(App\DeliveryMethod::all() as $method)
		<tr data-id={{$method->id}}>
			<td>{{$method->key}}</td>
			<td>{{$method->name}}</td>
			<td>{{$method->desc}}</td>
			<td data-val="{{$method->icon}}">
				<i class="{{$method->icon}} big icon"></i>
				  
			  <div class="ui selection big dropdown">
			    <input type="hidden" name="gender">
			    <i class="dropdown icon"></i>
			    <div class="default text">Ikona</div>
			    <div class="menu">
			      <div class="item" data-value="money"><i class="big icon money"></i></div>
			      <div class="item" data-value="user"><i class="big icon user"></i></div>
			      <div class="item" data-value="truck"><i class="big icon truck"></i></div>
			      <div class="item" data-value="motorcycle"><i class="big icon motorcycle"></i></div>

			    </div>
			  </div>

				<div>
			</td>
			<td class="collapsing">
				<i class="edit large icon action"></i>
				<i class="delete circle red large icon"></i>
				<i class="chevron circle down large icon"></i>
				<i class="chevron circle up large icon"></i>
			</td>

		</tr>
	@endforeach
	</tbody>
	</table>
	<div class="ui blue button add_delivery_method_btn">Pridať</div>

	@include('modals.newdelivery')

	<div class="ui horizontal divider">Sposoby platby</div>

	<table class="ui celled padded table">
	  <thead>
	    <tr>
		    <th>Kód</th>
		    <th>Názov</th>
		   	<th>Popis</th>
		    <th>Ikona</th>
		   	<th>Akcie</th>

	  	</tr>
	</thead>
	<tbody class="admin_method_list" data-type="payment">
	@foreach(App\PaymentMethod::all() as $method)
		<tr data-id={{$method->id}}>
			<td>{{$method->key}}</td>
			<td>{{$method->name}}</td>
			<td>{{$method->desc}}</td>
			<td data-val="{{$method->icon}}">
				<i class="{{$method->icon}} big icon"></i>
				  
			  <div class="ui selection big dropdown">
			    <input type="hidden" name="gender">
			    <i class="dropdown icon"></i>
			    <div class="default text">Ikona</div>
			    <div class="menu">
			      <div class="item" data-value="money"><i class="big icon money"></i></div>
			      <div class="item" data-value="user"><i class="big icon user"></i></div>
			      <div class="item" data-value="truck"><i class="big icon truck"></i></div>
			      <div class="item" data-value="motorcycle"><i class="big icon motorcycle"></i></div>

			    </div>
			  </div>

				<div>
			</td>
			<td class="collapsing">
				<i class="edit large icon action"></i>
				<i class="delete circle red large icon"></i>
				<i class="chevron circle down large icon"></i>
				<i class="chevron circle up large icon"></i>
			</td>

		</tr>
	@endforeach
	</tbody>
	</table>

	<div class="ui blue button add_payment_method_btn">Pridať</div>

	<div class="ui horizontal divider">Doprava / Platba</div>
	<table class="ui celled padded table">
	  <thead>
	    <tr>
		    <th>Doprava</th>
		    <th>Platba</th>
		   	<th>Povolené</th>
	  	</tr>
	</thead>
	<tbody class="admin_method_list" data-type="payment">
	@foreach(App\DeliveryMethod::all() as $deliveryMethod)
	@foreach(App\PaymentMethod::all() as $paymentMethod)
		<tr data-delivery_method_id={{$deliveryMethod->id}} data-payment_method_id={{$paymentMethod->id}}>
			<td>{{$deliveryMethod->name}}</td>
			<td>{{$paymentMethod->name}}</td>
			<td>
				<div class="ui checkbox delivery_payment_checkbox @if(in_array($paymentMethod->id, $deliveryMethod->paymentMethods->pluck('id')->toArray())) checked @endif">
				  <input type="checkbox" name="example" @if(in_array($paymentMethod->id, $deliveryMethod->paymentMethods->pluck('id')->toArray())) checked @endif>
				</div>
			</td>
		</tr>
	@endforeach
	@endforeach
	</tbody>
	</table>

	@include('modals.newpayment')

</div>

@stop

