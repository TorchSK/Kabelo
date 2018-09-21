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
			    <a href="/admin/user/{{$user->id}}/orders" class="tabb ui blue button" data-tab="orders">Objednávky ({{$user->orders->count()}})</a>
			    <a href="/admin/user/{{$user->id}}/cart" class="tabb ui basic button" data-tab="cart">Košík ({{$user->cart->products->count()}})</a>

			</div>

		  	<div class="contents">

		    

					<div class="content" data-tab="orders">

						<div class="sum">Ceková suma objednávok: <number>{{$userOrdersPrice}} €</number></div>

						<table class="ui celled selectable sortable table">
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
						  	@foreach($user->orders->sortBy('created_at') as $order)
							<tr>
						      <td>{{$order->id}}</td>
						      <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
						   	  <td>{{$order->invoice_name}}</td>
						      <td>{{$order->products->sum('price')}}</td>
						      <td  class="warning">{{$order->status->name}}</td>
						      <td>{{$order->delivery->name}} / {{$order->payment->name}}</td>
						      <td class="collapsing">
						      	<a href="{{route('admin.orderDetail',['order'=>$order->id])}}" class="ui mini icon blue button"><i class="search large icon"></i></a>
						      </td>

						  	</tr>

							@endforeach
						  </tbody>
						</table>


					</div>

	
		    		
				</div>
		    

		</div>
	</div>

@stop