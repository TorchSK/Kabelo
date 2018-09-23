@extends('layouts.admin')
@section('content')



<div id="admin_settings_delivery" class="admin_wrapper">

<div class="short">

	<div class="ui horizontal divider">Sposoby dopravy</div>

	<div class="admin_method_list" data-type="delivery">
	@foreach(App\DeliveryMethod::all() as $delivery)
		@include('cart.deliveryRow',['context'=>'admin'])
	@endforeach
	</div>
	<div class="ui blue button add_delivery_method_btn">Pridať</div>

	@include('modals.newdelivery')

	<div class="ui horizontal divider">Sposoby platby</div>

	<div class="admin_method_list" data-type="payment">
	@foreach(App\PaymentMethod::all() as $payment)
		@include('cart.paymentRow',['context'=>'admin'])
	@endforeach
	</div>

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
		<tr data-delivery_method_id="{{$deliveryMethod->id}}" data-payment_method_id="{{$paymentMethod->id}}">
			<td>{{$deliveryMethod->name}}</td>
			<td>{{$paymentMethod->name}}</td>
			<td>
				<div class="ui checkbox delivery_payment_checkbox @if(in_array($paymentMethod->id, $deliveryMethod->paymentMethods->pluck('id')->toArray())) checked @endif">
				  <input type="checkbox" @if(in_array($paymentMethod->id, $deliveryMethod->paymentMethods->pluck('id')->toArray())) checked @endif>
				</div>
			</td>
		</tr>
	@endforeach
	@endforeach
	</tbody>
	</table>
	@include('modals.newpayment')




</div>
</div>

@stop

