@extends('layouts.admin')
@section('content')

    <div id="admin_new_wrapper" class="admin_wrapper">

	<div class="filters">

		<form class="filters_form ui form">
			<div class="field">

				<label>Kategória</label>

				<select multiple="true" name="categories[]" id="bulk_filter_category" class="ui fluid search dropdown filter_item category">
				    <option value="">Vyberte kategóriu</option>

				    @foreach (App\Category::orderBy('path','asc')->get() as $category)
					    <option value="{{$category->id}}">
					    	@if($category->parent)
					  		{{$category->parent->name}} - 
					      	@endif
					      	{{$category->name}}
					    </option>
					    @endforeach
			    </select>
			</div>
			
			<div class="field">

				<label>Názov</label>
			    <div class="ui fluid input filter_item name">
			    	<input type="text" name="name" placeholder="Zadajte názov produktu" />
				</div>
			</div>

			<div class="field">

			    <div class="ui checkbox filter_item without_category">
			    	<label>Bez kategórie</label>

			    	<input type="checkbox" name="name" placeholder="Zadajte názov produktu" />
				</div>
			</div>
		</form>


	</div>
	
		<div class="content" data-tab="inactive">

			<table class="ui celled selectable unstackable sortable table" id="inactive_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Kód</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereActive('0')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->code}}</td>
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
@stop
