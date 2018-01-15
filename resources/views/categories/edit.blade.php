@extends('layouts.master')
@section('content')
	
<div id="category_options" class="ct" data-categoryid={{$category->id}}>
 <div class="container ct">
  <a class="ui teal button" id="edit_category_submit">Ulož zmeny</a>
  <a href="/admin/products" class="ui red button">Zruš editáciu</a>
</div>
</div>

<div class="ct pad wrapper">
<div class="container">
      <div class="ui header">Názov</div>

        <div class="ui fluid input" id="edit_product_name_input">
           <input type="text" value="{{$category->name}}" />
      </div>
</div>
</div>

@stop