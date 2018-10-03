@extends('layouts.master')
@section('content')

<div class="order_history wrapper">
	<div class="container">

	<div class="header">Moje objednávky</div>

	<div class="orders">
	<div class="ui horizontal divider">Otvorené objednávky</div>

	@foreach(Auth::user()->orders as $order)
		<div class="item">
			<div class="id">{{$order->id}}</div>
			<div class="date">{{Carbon\Carbon::parse($order->created_at)->day.'.'.Carbon\Carbon::parse($order->created_at)->month.'.'.Carbon\Carbon::parse($order->created_at)->year}}</div>
			<div class="price">{{$order->price}} Eur</div>
			<div class="detail">{{$order->status->name}}</div>

		</div>
	@endforeach
	</div>

	<div class="ui horizontal divider">Vybavené objednávky</div>

	@foreach(Auth::user()->orders->where('status_id',3) as $order)
		<div class="item">
			<div class="id">{{$order->id}}</div>
			<div class="date">{{Carbon\Carbon::parse($order->created_at)->day.'.'.Carbon\Carbon::parse($order->created_at)->month.'.'.Carbon\Carbon::parse($order->created_at)->year}}</div>
			<div class="price">{{$order->price}} Eur</div>
			<div class="detail">{{$order->status->name}}</div>

		</div>
	@endforeach
</div>
</div>

@stop