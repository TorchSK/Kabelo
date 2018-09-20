@extends('layouts.admin')
@section('content')

<div class="admin_dashboard">

	<div class="boxes">

		<div class="box">
			<div class="caption">Najnovšie objednávky</div>

			<table class="ui celled selectable unstackable sortable table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Datum prijatia</th>
			 	<th>Meno</th>
			    <th>Suma</th>
			    <th>Stav</th>
			    <th>Dodanie</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Order::orderBy('created_at','desc')->take(10)->get() as $order)
				<tr>
			      <td>{{$order->id}}</td>
			      <td>{{Carbon\Carbon::parse($order->created_at)->format('j.n.Y H:i:s')}}</td>
			   	  <td>{{json_decode($order->invoice_address)->name}}</td>
			      <td>{{$order->products->sum('price')}} €</td>
			      <td  class="warning">{{$order->status->name}}</td>
			      <td>{{$order->delivery->name}} / {{$order->payment->name}}</td>

			  	</tr>

				@endforeach
			  </tbody>
			</table>

		</div>


		<div class="box">

			<div class="caption">Najnovšie produkty</div>

				<table class="ui celled selectable unstackable sortable table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Datum vytvorenia</th>
			 	<th>Názov</th>
			    <th>Kategória</th>
			    <th>Cena</th>
			    <th>Akcie</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::orderBy('created_at','desc')->take(10)->get() as $product)
				<tr>
			      <td><a href="/{{$product->maker}}/{{$product->code}}/detail">{{$product->id}}</a></td>
			      <td>{{Carbon\Carbon::parse($product->created_at)->format('d.m.Y H:i:s')}}</td>
			   	  <td>{{$product->name}}</td>
			   	  <td>{{$product->categories->first()->name}}</td>
			   	  <td>{{$product->price}}</td>
			      <td></td>

			  	</tr>

				@endforeach
			  </tbody>
			</table>


		</div>

		<div class="box">

			<div class="caption">Najnovší uživatelia</div>

			<table class="ui celled selectable unstackable sortable table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Datum registrácie</th>
			 	<th>Email</th>
			    <th>Meno</th>
			    <th>Admin</th>
			    <th>Akcie</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\User::orderBy('created_at','desc')->take(10)->get() as $user)
				<tr>
			      <td>{{$user->id}}</td>
			      <td>{{Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i:s')}}</td>
			   	  <td>{{$user->email}}</td>
			      <td>{{$user->name}}</td>
			      <td>{{$user->admin}}</td>
			      <td></td>

			  	</tr>

				@endforeach
			  </tbody>
			</table>

		</div>

	</div>

</div>

@stop