@extends('layouts.admin')
@section('content')

<div id="bulk_products">

<table class="ui celled table" id="bulk_products_table" style="width:100%">
  <thead>
    <tr>
      <th>ID</th>
      <th>Názov</th>
      <th>Kód</th>
      <th>Výrobca</th>
      <th>Popis</th>
      <th>Novinka</th>
      <th>Zľava</th>
    </tr>
  </thead>
  <tbody>
  	@foreach(App\Product::all() as $product)
    <tr data-id="{{$product->id}}">
      <td>{{$product->id}}</td>
      <td data-order="{{$product->name}}" data-name="name" class="edit"><div class="ui input product_param"><input type="text" value="{{$product->name}}" /></div></td>
      <td data-order="{{$product->code}}"  data-name="code" class="edit"><div class="ui input product_param"><input type="text" value="{{$product->code}}" /></div></td>
      <td data-order="{{$product->maker}}"  data-name="maker" class="edit"><div class="ui input product_param"><input type="text" value="{{$product->maker}}" /></div></td>
      <td data-order="{{$product->desc}}"  data-name="desc" class="edit"><div class="ui input product_param"><input type="text" value="{{$product->desc}}" /></div></td>
      <td data-order="{{$product->new}}"  data-name="new" class="edit"><div class="ui checkbox product_param"><input type="checkbox" @if($product->new) checked @endif value="{{$product->new}}" /></div></td>
      <td data-order="{{$product->sale}}"  data-name="sale"><div class="ui checkbox product_param"><input type="checkbox"  @if($product->sale) checked @endif value="{{$product->sale}}" /></div></td>
    </tr>
    @endforeach

  </tbody>

</table>
<div class="ui teal button" id="bulk_save_btn">Ulož</div>


</div>



@stop