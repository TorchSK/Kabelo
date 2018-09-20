@extends('layouts.admin')
@section('content')

<div class="admin_dashboard">


	<div class="boxes overall">

		<div class="box" data-resource="orders" data-type="countbydays" data-days="7">

			 <div class="ui inverted dimmer">
			    <div class="ui loader"></div>
			  </div>


			<div class="caption">
				Objednávky 
				<i class="table icon"></i>
				<i class="chart line icon"></i>
				<div class="fr">
					<a class="chart_days_btn selected" data-days="7">7 dní</a>
					<a class="chart_days_btn" data-days="30">30 dní</a>
					<a class="chart_days_btn" data-days="160">6 mes.</a>
					<a class="chart_days_btn" data-days="365">Všetko</a>
				</div>	
			</div>

				<canvas id="orders_chart"></canvas>

		</div>


		<div class="box" data-resource="users" data-type="countbydays" data-days="7">


			 <div class="ui inverted dimmer">
			    <div class="ui loader"></div>
			  </div>


			<div class="caption">Registrácie
				<i class="table icon"></i>
				<i class="chart line icon"></i>
				<div class="fr">
					<a class="chart_days_btn selected" data-days="7">7 dní</a> 
					<a class="chart_days_btn" data-days="30">30 dní</a>
					<a class="chart_days_btn" data-days="160">6 mes.</a>
					<a class="chart_days_btn" data-days="365">Všetko</a>
				</div>	
			</div>

				<canvas id="reg_chart" width="400" height="400"></canvas>

		</div>

		<div class="box">

			<div class="caption">Najpredávanejšie produkty</div>

			<table class="ui celled selectable unstackable sortable table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Pocet objednávok</th>
			    <th>Suma objednávok</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::with('orders')->take(10)->get()->sortByDesc(function($q){return $q->orders->count();}); as $product)
				<tr>
			      <td><a href="/product/{{$product->maker}}/{{$product->code}}">{{$product->id}}</a></td>
			      <td>{{$product->name}}</td>
			      <td>{{$product->orders->count()}}</td>
			      <td>{{$product->orders->count()*$product->price}} €</td>

			  	</tr>

				@endforeach
			  </tbody>
			</table>

		</div>

	</div>

</div>

@stop