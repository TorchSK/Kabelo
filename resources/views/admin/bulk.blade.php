@extends('layouts.admin')
@section('content')

<div id="bulk_products_wrapper" class="admin_wrapper">
	<div class="filters">

		<form class="filters_form">
			<select multiple="true" name="categories[]" id="bulk_filter_category" class="ui fluid search dropdown filter_item category">
			    <option value="">Kategória</option>

			    @foreach (App\Category::orderBy('path','asc')->get() as $category)
				    <option value="{{$category->id}}">
				    	@if($category->parent)
				  		{{$category->parent->name}} - 
				      	@endif
				      	{{$category->name}}
				    </option>
				    @endforeach
		    </select>
		</form>


	</div>

	<div class="actions">
	    <div id="bulk_load_btn" class="ui blue button">Filtruj</div>
	    <div id="bulk_save_btn" class="ui green button">Ulož</div>
	</div>

	<div id="bulk_products_table">

	</div>


</div>



@stop