@extends('layouts.admin')
@section('content')
	
	<div id="admin_orders" class="admin_wrapper">

	<div class="ui horizontal divider">Otvorené objednávky</div>

	<table class="ui celled selectable table orders_table">
	  <thead>
	    <tr>
	   	<th></th>
	    <th>ID</th>
	    <th>Datum prijatia</th>
	 	<th>Meno</th>
	 	<th>Telefón</th>
	 	<th>Email</th>
	    <th>Suma</th>
	    <th>Stav</th>
	    <th>Dodanie</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\Order::whereIn('status_id',[0])->orderBy('status_id', 'asc')->orderBy('created_at','desc')->get() as $order)
		<tr data-order_id={{$order->id}}>
		  <td class="collapsing">
	      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui icon blue button"><i class="search icon"></i></a>
	      </td>
	      <td>{{$order->id}}</td>
	      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
	   	  <td>{{json_decode($order->invoice_address)->name}}</td>
	   	  <td>{{json_decode($order->invoice_address)->phone}}</td>
	   	  <td>{{json_decode($order->invoice_address)->email}}</td>
	      <td>{{$order->price}} &euro;</td>
	      <td  class="status collapsing" data-statusid="{{$order->status_id}}">{{$order->status->name}}</td>
	      <td>{{$order->delivery->name}} / {{$order->payment->name}}</td>
	      <td class="collapsing">
	      	<div class="ui icon red button delete_order_btn" data-tooltip="Zmazať objednávku" data-position="top right"><i class="delete icon"></i></div>
	      	<div class="ui icon blue button close_order_btn" data-tooltip="Uzavrieť objednávku bez odoslania emailu" data-position="top right"><i class="check icon"></i></div>
	      </td>

	  	</tr>

		@endforeach
	  </tbody>
	</table>

	<div class="ui horizontal divider">Vybavené objednávky</div>
	
	<table class="ui celled selectable table orders_table">
	  <thead>
	    <tr>
	   	<th></th>
	    <th>ID</th>
	    <th>Datum prijatia</th>
	 	<th>Meno</th>
	 	<th>Telefón</th>
	 	<th>Email</th>
	    <th>Suma</th>
	    <th>Stav</th>
	    <th>Dodanie</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\Order::whereIn('status_id',[1,2,3,4,5])->orderBy('created_at','desc')->get() as $order)
		<tr data-order_id={{$order->id}}>
		  <td class="collapsing">
	      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui icon blue button"><i class="search icon"></i></a>
	      </td>
	      <td>{{$order->id}}</td>
	      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
	   	  <td>{{json_decode($order->invoice_address)->name}}</td>
	   	  <td>{{json_decode($order->invoice_address)->phone}}</td>
	   	  <td>{{json_decode($order->invoice_address)->email}}</td>
	      <td>{{$order->price}}&euro;</td>
	      <td  class="status collapsing" data-statusid="{{$order->status_id}}">{{$order->status->name}}</td>
	      <td>{{$order->delivery->name}} / {{$order->payment->name}}</td>
	      <td class="collapsing">
	      	<div class="ui icon red button delete_order_btn"><i class="delete icon"></i></div>
	      </td>

	  	</tr>

		@endforeach
	  </tbody>
	</table>
</div>
@stop