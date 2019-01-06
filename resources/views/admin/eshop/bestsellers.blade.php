@extends('layouts.admin')
@section('content')

    <div id="admin_bestsellers_wrapper" class="admin_wrapper">

		<div class="content" data-tab="bestsellers">

			@include('admin.info',['text'=>'Nastavenie zobrazovania bestsellerov na úvodnej strane eshopu'])
			@include('admin.info',['text'=>'V prípade viacerých vybraných kategórií sa kategória zobrazuje náhodne pri každom obnovení stránky'])
			@include('admin.info',['text'=>'V prípade, že pridáte produkt manuálne, zobrazuje sa na prvom mieste v prípade, že je zobrazená zodpovedajúca kategória'])

			<div class="active_bestseller_categories_caption">Aktuálne nastavené kategórie pre zobrazovanie bestsellerov</div>

			<table class="ui celled selectable unstackable sortable table" id="bestseller_category_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Odobrať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Category::whereBestseller('1')->get() as $category)
				<tr data-id="{{$category->id}}">
			      <td>{{$category->id}}</td>
			      <td>{{$category->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui category bestseller search">
						  <input class="prompt" type="text" placeholder="Pridaj kategóriu">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

			<div class="active_bestseller_products_caption">Aktuálne nastavené produkty pre zobrazovanie bestsellerov</div>


			<table class="ui celled selectable unstackable sortable table" id="bestseller_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Odobrať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereBestseller('1')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui product bestseller search">
						  <input class="prompt" type="text" placeholder="Pridaj produkt">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

		</div>
	</div>
@stop
