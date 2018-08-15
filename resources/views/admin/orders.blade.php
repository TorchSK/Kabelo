@extends('layouts.admin')
@section('content')
	
	<div class="orders">
	<div class="ui horizontal divider">Otvorené objednávky</div>
	
	<table class="ui celled selectable table">
	  <thead>
	    <tr>
	   	<th>ID</th>
	    <th>ID</th>
	    <th>Datum prijatia</th>
	 	<th>Meno</th>
	    <th>Suma</th>
	    <th>Stav</th>
	    <th>Dodanie</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\Order::orderBy('created_at','desc')->get() as $order)
		<tr data-order_id={{$order->id}}>
		  <td class="collapsing">
	      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui icon blue button"><i class="search icon"></i></a>
	      </td>
	      <td>{{$order->id}}</td>
	      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
	   	  <td>{{$order->invoice_name}}</td>
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