@extends('layouts.admin')
@section('content')

<div id="bulk_products_wrapper" class="admin_wrapper">
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

				<label>Názov / Kód</label>
			    <div class="ui fluid input filter_item name">
			    	<input type="text" name="name" placeholder="Zadajte názov alebo kód produktu" />
				</div>
			</div>

			<div class="field">

			    <div class="ui checkbox filter_item without_category">
			    	<label>Bez kategórie</label>
			    	<input type="checkbox" name="without_category" />
				</div>


			    <div class="ui checkbox filter_item inactive">
			    	<label>Iba neaktívne</label>
			    	<input type="checkbox" name="inactive" />
				</div>

			</div>
		</form>


	</div>

	<div class="actions">
		<div class="left">
		    <div id="bulk_load_btn" class="ui blue button">Filtruj</div>
		    <div id="bulk_save_btn" class="ui green button">Ulož</div>
		    		    <a href="{{route('product.create')}}" class="ui green button">Nový produkt</a>

		</div>
		<div class="right">
		    <div id="bulk_change_category_btn" class="ui brown button">Zmeň kategóriu</div>
		    @include('modals.changecategory')
		    @include('modals.addcategory')
		   	<div id="bulk_add_category_btn" class="ui blue button">Pridaj kategóriu</div>

		</div>
	</div>

	<div id="bulk_products_table">

	</div>


</div>



@stop