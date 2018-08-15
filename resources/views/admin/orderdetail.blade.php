@extends('layouts.admin')
@section('content')

	<div class="order_detail">

		<div class="header section">

			<div class="status_div">
				<text>Stav: </text>
				<div class="ui big label status" data-statusid="{{$order->status->id}}">{{$order->status->name}}</div>
			</div>

			<div class="new_statuses">
				<text>Zmeň stav na: </text>
				@foreach(App\OrderStatus::all() as $newstatus)
					@if($newstatus->name != $order->status->name)
						<div class="ui big label status" data-statusid="{{$newstatus->id}}">{{$newstatus->name}}</div>
					@endif
				@endforeach
			</div>
		</div>

		<div class="detail section">
		
		<div class="tabbs">

			<div class="tabs">

			    <div class="tabb ui brown button" data-tab="detail">Detail</div>
			    <div class="tabb ui basic button" data-tab="recommended">Dokumenty</div>
			    <div class="tabb ui basic button" data-tab="ratings">Emaily</div>

			</div>

		  	<div class="contents">

		    	<div class="content par active" data-tab="detail">

		    		<table class="ui very basic collapsing unstackable table">
		    			<thead >
					    <tr><th colspan="2">
					      Detaily
					    </th>
					  </tr></thead>
					  <tbody>
					    <tr>
					      <td>Číslo objednávky</td>
					      <td>{{$order->id}}</td>
					    </tr>
					    <tr>
					      <td>Dátum vytvorenia</td>
			      		  <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
					    </tr>
					    <tr>
					      <td>Zákazník</td>
					      <td>{{$order->user->email}}</td>
					    </tr>
					  </tbody>
					</table>

		    		<table class="ui very basic collapsing unstackable table">
		    			<thead >
					    <tr><th colspan="2">
					      &nbsp;
					    </th>
					  </tr></thead>
					  <tbody>
					    <tr>
					      <td>Sposob doručenia</td>
					      <td>{{$order->delivery->name}}</td>
					    </tr>
					    <tr>
					      <td>Sposob platby</td>
					      <td>{{$order->payment->name}}</td>
					    </tr>
					    <tr>
					      <td>Cena</td>
					      <td>{{$order->price}} €</td>
					    </tr>
					  </tbody>
					</table>
					

				</div>


				<div id="order_detail_prodcuts" class="order_products_list">
					@foreach($order->products as $product)
						@include('orders.product')
					@endforeach

				</div>
		    
		  </div>

		</div>
	</div>
	</div>

@stop