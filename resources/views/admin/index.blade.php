@extends('layouts.admin')
@section('content')


    @include('admin.sidebar')


<div class="admin_right">

	<div class="tabbs">

	  <div class="tabs">
	    <div class="tabb ui button blue selected" data-tab="categories">Všetky kategórie ({{App\Category::all()->count()}})</div>
	   	<div class="tabb ui button basic" data-tab="news">Všetky novinky ({{App\Product::whereNew(1)->count()}})</div>
	    <div class="tabb ui button basic" data-tab="sales">Všetky zľavy ({{App\Product::whereSale(1)->count()}})</div>
	    <div class="tabb ui button basic" data-tab="inactive">Neaktívne produkty ({{App\Product::whereActive(0)->count()}})</div>
	  </div>

	  <div class="contents">
	  	<div class="content active" data-tab="categories">

		<ul class="admin_categories_list">
		@foreach ($categories as $category)
			@include('admin.categoryRow')
		@endforeach
		</ul>

		</div>

		<div class="content" data-tab="news">

			<table class="ui celled selectable unstackable sortable table" id="new_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereNew('1')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui product new search">
						  <input class="prompt" type="text" placeholder="Pridaj produkt">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

		</div>

		<div class="content" data-tab="sales">

			<table class="ui celled selectable unstackable sortable table" id="sale_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereSale('1')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui product sale search">
						  <input class="prompt" type="text" placeholder="Pridaj produkt">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

		</div>

		<div class="content" data-tab="inactive">

			<table class="ui celled selectable unstackable sortable table" id="inactive_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereActive('0')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui product inactive search">
						  <input class="prompt" type="text" placeholder="Pridaj produkt">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

		</div>
	</div>
</div>
</div>
@stop