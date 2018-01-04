@extends('layouts.master')
@section('content')

<div id="product_options" class="ct">
 <div class="container ct">
  <a class="ui teal button" id="edit_product_submit">Ulož zmeny</a>
  <a href="/{{Request::segment(1)}}/{{Request::segment(2)}}/detail" class="ui red button">Zruš editáciu</a>

</div>
</div>

<div id="product_detail" data-id="{{$product->id}}">
    <div class="left">
        <div class="edit_images">

           @foreach($product->images as $image)
            <img src="/{{$image->path}}" width="30%"/>
           @endforeach 
           <form action="/file/upload" class="dropzone" id="product_detail_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>
        </div>
    </div>

    <div class="right">
      
      <div class="ui header">Název</div>

        <div class="ui fluid input" id="edit_product_name_input">
           <input type="text" value="{{$product->name}}" />
      </div>

    <div class="ui header">Kód produktu</div>

        <div class="ui fluid input" id="edit_product_code_input">
           <input type="text" value="{{$product->code}}"  />
      </div>

    <div class="ui header">Výrobca</div>

        <div class="ui fluid input" id="create_product_maker_input">
           <input type="text" value="{{$product->maker}}" />
      </div>

      <div class="ui header">Kategória</div>
    <select multiple="" name="edit_product_categories" id="edit_product_categories_input" class="ui fluid normal dropdown">
    <option value="">Kategória</option>
    @foreach (App\Category::all() as $category)
    <option value="{{$category->id}}" @if(in_array($category->id, $product->categories->pluck('id')->toArray())) selected="true" @endif>{{$category->name}}</option>
    @endforeach
    </select>

    <div class="ui header">Popis</div>

    <div class="ui form">
      <div class="field" id="edit_product_desc_input">
        <textarea>{{$product->desc}}</textarea>
      </div>
    </div>

    <div class="ui header">Parametre</div>

    <div id="edit_product_params">
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

        <div class="ui teal button" id="edit_product_add_param_row">Pridaj</div>


     <div class="ui header">Cena</div>

        <div class="ui right labeled fluid huge input" id="edit_product_price_input">
      <input type="text" value="{{$product->price}}">
      <div class="ui basic label">
        Eur
      </div>
    </div>

      <div class="ui header">Jendotky</div>

    <div class="ui fluid selection dropdown" id="edit_product_unit_input">
      <input type="hidden" name="unit" value="{{$product->price_unit}}">
      <i class="dropdown icon"></i>
      <div class="default text">{{$product->price_unit}}"</div>
      <div class="menu">
        <div class="item" data-value="m">m</div>
        <div class="item" data-value="ks">ks</div>
      </div>
    </div>


 </div>
</div>

@stop