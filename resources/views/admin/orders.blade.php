@extends('layouts.admin')
@section('content')
	
	<div class="orders">
	<div class="ui horizontal divider">Otvorené objednávky</div>
	
	<table class="ui celled selectable table">
	  <thead>
	    <tr>
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
		<tr>
	      <td>{{$order->id}}</td>
	      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
	   	  <td>{{$order->invoice_name}}</td>
	      <td>{{$order->price}}</td>
	      <td  class="warning">{{$order->status->name}}</td>
	      <td>{{$order->delivery->name}} / {{$order->payment->name}}</td>
	      <td>
	      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui mini icon blue button"><i class="search large icon"></i></a>
	      </td>

	  	</tr>

		@endforeach
	  </tbody>
	</table>
</div>
@stop