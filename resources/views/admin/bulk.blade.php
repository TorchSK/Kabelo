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
      <th>Level 1</th>
      <th>MOC</th>
      <th>MOC*</th>
      <th>VOC</th>
      <th>VOC*</th>
      <th>Level 2</th>
      <th>MOC</th>
      <th>MOC*</th>
      <th>VOC</th>
      <th>VOC*</th>
      <th>Level 3</th>
      <th>MOC</th>
      <th>MOC*</th>
      <th>VOC</th>
      <th>VOC*</th>
      <th>Level 4</th>
      <th>MOC</th>
      <th>MOC*</th>
      <th>VOC</th>
      <th>VOC*</th>
      <th>Level 5</th>
      <th>MOC</th>
      <th>MOC*</th>
      <th>VOC</th>
      <th>VOC*</th>
    </tr>
  </thead>
  <tbody>
  	@foreach(App\Product::all() as $product)
    <tr data-id="{{$product->id}}">
      <td>{{$product->id}}</td>
      <td data-order="{{$product->name}}" data-name="name"><div class="ui input product_param"><input type="text" value="{{$product->name}}" /></div></td>
      <td data-order="{{$product->code}}"  data-name="code"><div class="ui input product_param"><input type="text" value="{{$product->code}}" /></div></td>
      <td data-order="{{$product->maker}}"  data-name="maker"><div class="ui input product_param"><input type="text" value="{{$product->maker}}" /></div></td>
      <td data-order="{{$product->desc}}"  data-name="desc"><div class="ui input product_param"><input type="text" value="{{$product->desc}}" /></div></td>
      <td data-order="{{$product->desc}}"  data-name="new"><div class="ui checkbox product_param"><input type="checkbox" value="{{$product->new}}" /></div></td>
      <td data-order="{{$product->desc}}"  data-name="sale"><div class="ui checkbox product_param"><input type="checkbox" value="{{$product->sale}}" /></div></td>
      @foreach($product->priceLevels as $priceLevel)
      <td><div class="ui input product_param"><input type="text" value="{{$priceLevel->threshold}}" /></div></td>
      <td><div class="ui input product_param"><input type="text" value="{{$priceLevel->moc_regular}}" /></div></td>
      <td><div class="ui input product_param"><input type="text" value="{{$priceLevel->moc_sale}}" /></div></td>
      <td><div class="ui input product_param"><input type="text" value="{{$priceLevel->voc_regular}}" /></div></td>
      <td><div class="ui input product_param"><input type="text" value="{{$priceLevel->voc_sale}}" /></div></td>

      @for ($i = $product->priceLevels->count() + 1; $i <= 5; $i++)
	  <td><div class="ui input product_param"><input type="text" /></div></td>
      <td><div class="ui input product_param"><input type="text" /></div></td>
      <td><div class="ui input product_param"><input type="text" /></div></td>
      <td><div class="ui input product_param"><input type="text" /></div></td>
      <td><div class="ui input product_param"><input type="text" /></div></td>
	  @endfor


      @endforeach
    </tr>
    @endforeach

  </tbody>

</table>
<div class="ui teal button" id="bulk_save_btn">Ulož</div>


</div>



@stop