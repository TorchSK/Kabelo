@extends('layouts.admin')
@section('content')
	
	<div class="orders">
	<div class="ui horizontal divider">Otvorené objednávky</div>
	
	<table class="ui celled selectable table orders_table">
	  <thead>
	    <tr>
	   	<th></th>
	    <th>ID</th>
	    <th>Datum prijatia</th>
	    <th>Registrovany</th>
	 	<th>Meno</th>
	    <th>Suma</th>
	    <th>Stav</th>
	    <th>Dodanie</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\Order::whereIn('status_id',[0,1,2])->orderBy('status_id', 'asc')->orderBy('created_at','desc')->get() as $order)
		<tr data-order_id={{$order->id}}>
		  <td class="collapsing">
	      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui icon blue button"><i class="search icon"></i></a>
	      </td>
	      <td>{{$order->id}}</td>
	      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
	      <td class="collapsing">
	      	@if($order->user_id)
	      	Ano
	      	@else
	      	Nie
	      	@endif
	      </td>
	   	  <td>{{json_decode($order->invoice_address)->name}}</td>
	      <td>{{$order->price}}</td>
	      <td  @if($order->status_id==0) class="new" @else  class="sent" @endif>{{$order->status->name}}</td>
	      <td>{{$order->delivery->name}} / {{$order->payment->name}}</td>
	      <td class="collapsing">
	      	<div class="ui icon red button delete_order_btn"><i class="delete icon"></i></div>
	      </td>

	  	</tr>

		@endforeach
	  </tbody>
	</table>

	<div class="ui horizontal divider">Vybavené objednávky</div>
	
	<table class="ui celled selectable table">
	  <thead>
	    <tr>
	   	<th></th>
	    <th>ID</th>
	    <th>Datum prijatia</th>
	    <th>Registrovany</th>
	 	<th>Meno</th>
	    <th>Suma</th>
	    <th>Stav</th>
	    <th>Dodanie</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\Order::whereIn('status_id',[3,4])->orderBy('created_at','desc')->get() as $order)
		<tr data-order_id={{$order->id}}>
		  <td class="collapsing">
	      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui icon blue button"><i class="search icon"></i></a>
	      </td>
	      <td>{{$order->id}}</td>
	      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
	      <td class="collapsing">
	      	@if($order->user_id)
	      	Ano
	      	@else
	      	Nie
	      	@endif
	      </td>
	   	  <td>{{json_decode($order->invoice_address)->name}}</td>
	      <td>{{$order->price}}</td>
	      <td  class="warning">{{$order->status->name}}</td>
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