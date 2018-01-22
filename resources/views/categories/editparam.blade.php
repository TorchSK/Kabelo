@extends('layouts.master')
@section('content')

<form action= "/category/parameter/{{$param->id}}" method="POST">
  
  	<input name="_method" type="hidden" value="PUT">
	<input name="_token" hidden value="{!! csrf_token() !!}" />

<div id="category_options" class="ct" data-categoryid={{$param->id}}>
 <div class="container ct">
  <button type="submit" class="ui teal button">Ulož zmeny</button>
  <a href="/admin/products" class="ui red button">Zruš editáciu</a>
</div>
</div>

<div class="ct pad wrapper">
<div class="container">
      <div class="ui header">Kľúč</div>

        <div class="ui fluid input">
           <input type="text" name="key" value="{{$param->key}}" />
      </div>
      <div class="ui header">Zobrazenie</div>

          <div class="ui fluid input">
           <input type="text" name="display_key" value="{{$param->display_key}}" />
      </div>
</div>
</div>
</form>

@stop