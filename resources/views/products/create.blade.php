@extends('layouts.master')
@section('content')

<div id="product_detail">
    <div class="left">
        <div class="img">
           <form action="/file/upload" class="dropzone" id="product_detail_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>
        </div>

        <div class="ui right labeled fluid huge input">
		  <input type="text" placeholder="Cena">
		  <div class="ui basic label">
		    Eur
		  </div>
		</div>

 		<div class="ui right labeled huge fluid input">
			  <input type="text" placeholder="Jednotky">
			  <div class="ui dropdown label">
			    <div class="text">m</div>
			    <i class="dropdown icon"></i>
			    <div class="menu">
			      <div class="item">m</div>
			      <div class="item">ks</div>
			    </div>
			  </div>
			</div>

		<div class="ui huge brown button" id="create_product_submit">
			Vytvor produkt
		</div>
    </div>

    <div class="right">
        <div class="ui fluid input" id="product_name_input">
           <input type="text" placeholder="Názov produktu" />
   		</div>


   		<div class="ui header">Kategória</div>
		<select multiple="" name="create_product_categories" class="ui fluid normal dropdown">
		<option value="">Kategória</option>
		@foreach (App\Category::all() as $category)
		<option value="{{$category->name}}">{{$category->name}}</option>
		@endforeach
		</select>

		<div class="ui header">Popis</div>

		<div class="ui form">
		  <div class="field">
		    <textarea></textarea>
		  </div>
		</div>

		<div class="ui header">Parametre</div>

		<div id="create_product_params">
			<div class="row">
				<div class="ui input"><input type="text" /></div>
				<div class="ui input"><input type="text" /></div>
			</div>
			<div class="row">
				<div class="ui input"><input type="text" /></div>
				<div class="ui input"><input type="text" /></div>
			</div>
			<div class="row">
				<div class="ui input"><input type="text" /></div>
				<div class="ui input"><input type="text" /></div>
			</div>
		</div>

 </div>
</div>

@stop