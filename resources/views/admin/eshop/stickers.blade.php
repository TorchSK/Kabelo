@extends('layouts.admin')
@section('content')

    <div id="admin_product_sticker_wrapper" class="admin_wrapper">
    	<div class="sticker_list">
    		@foreach(App\Sticker::all() as $sticker)
    			<div class="item sticker" data-id="{{$sticker->id}}">
    				<div class="image"><img src="{{url($sticker->path)}}" /></div>
    			</div>
    		@endforeach
    	</div>	

    	<div class="product_list">

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

				<div class="ui checkbox" id="filters_stickers_active_checkbox">
				  <input type="checkbox">
				  <label>Produkty so stickerom</label>
				</div>

			</form>

	

		    <div id="product_sticker_load_btn" class="ui blue button">Filtruj</div>
		    <div id="product_sticker_save_btn" class="ui green button">Pridaj sticker</div>

		    <div class="list">


		    </div>

    	</div>

	</div>
@stop
