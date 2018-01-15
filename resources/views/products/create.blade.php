@extends('layouts.master')
@section('content')

<div id="product_detail">
    <div class="left">
        <div class="img">
           <form action="/file/upload" class="dropzone" id="product_detail_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>
        </div>

   		<div class="ui header">Cena</div>

        <div class="ui right labeled fluid huge input" id="create_product_price_input">
		  <input type="text" placeholder="Cena">
		  <div class="ui basic label">
		    Eur
		  </div>
		</div>

   		<div class="ui header">Jendotky</div>

 		<div class="ui fluid selection dropdown" id="create_product_unit_input">
		  <input type="hidden" name="unit" value="m">
		  <i class="dropdown icon"></i>
		  <div class="default text">m</div>
		  <div class="menu">
		    <div class="item" data-value="m">m</div>
		    <div class="item" data-value="ks">ks</div>
		  </div>
		</div>	

		<div id="create_product_new_flag">
		<div class="ui checkbox">
		  <input type="checkbox" name="example">
		  <label>Novinka</label>
		</div>
		</div>

		<div id="create_product_sale_flag">
		<div class="ui checkbox">
		  <input type="checkbox" name="example">
		  <label>V zľave</label>
		</div>
		  	<div class="ui right labeled input" id="create_product_sale_value">
			  <input type="text" placeholder="Nová cena">
			    <div class="ui basic label">
		    Eur
		  </div>
			</div>
			
		</div>

		<div class="ui huge brown button" id="create_product_submit">
			Vytvor produkt
		</div>
    </div>

    <div class="right">
    	
    	<div class="ui header">Názov</div>

        <div class="ui fluid input" id="create_product_name_input">
           <input type="text" placeholder="Názov produktu" @if(Request::has('duplicate'))value="{{App\Product::find(Request::get('duplicate'))->name}}@endif" />
   		</div>

		<div class="ui header">Kód produktu</div>

        <div class="ui fluid input" id="create_product_code_input">
           <input type="text" placeholder="Kód produktu" @if(Request::has('duplicate'))value="{{App\Product::find(Request::get('duplicate'))->code}}@endif" />
   		</div>

		<div class="ui header">Výrobca</div>

        <div class="ui fluid input" id="create_product_maker_input">
           <input type="text" placeholder="Výrobca" @if(Request::has('duplicate'))value="{{App\Product::find(Request::get('duplicate'))->maker}}@endif"/>
   		</div>


   		<div class="ui header">Kategória</div>
		<select multiple="" name="create_product_categories" id="create_product_categories_input" class="ui fluid normal dropdown">
		<option value="">Kategória</option>
		@foreach (App\Category::all() as $category)
		<option @if(isset($selectedCategory) && $selectedCategory->id==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
		@endforeach
		</select>

		<div class="ui header">Popis</div>

		<div class="ui form">
		  <div class="field" id="create_product_desc_input">
		    <textarea>@if(Request::has('duplicate')){{App\Product::find(Request::get('duplicate'))->desc}}@endif</textarea>
		  </div>
		</div>

		<div class="ui header">Parametre</div>

		<div id="create_product_params">
			<div class="row">
				<div class="ui input key"><input type="text" /></div>
				<div class="ui input value"><input type="text" /></div>
			</div>
			<div class="row">
				<div class="ui input key"><input type="text" /></div>
				<div class="ui input value"><input type="text" /></div>
			</div>
			<div class="row">
				<div class="ui input key"><input type="text" /></div>
				<div class="ui input value"><input type="text" /></div>
			</div>
		</div>

		<div class="ui teal button" id="create_product_add_param_row">Pridaj</div>

 </div>
</div>

@stop