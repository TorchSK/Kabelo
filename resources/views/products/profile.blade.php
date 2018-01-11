@extends('layouts.master')
@section('content')

<div id="product_options" class="ct">
 <div class="container ct">
  <a href="/{{Request::segment(1)}}/{{Request::segment(2)}}/edit" class="ui teal button">Edituj produkt</a>
  <a class="ui red button" id="product_detail_delete_btn">Zmaž produkt</a>

</div>
</div>

<div id="product_detail" data-id={{$product->id}}>

      <div class="other_img">
          @if ($product->images->count() > 1)
          @foreach($product->images as $image)
           <img src="/{{$image->path}}" class="ui image" width="200px" />
           @endforeach
           @endif
        </div>


    <div class="left">
        <div class="img">
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" />
           @else
           <img src="/{{$product->image->path}}" class="ui image" />
           @endif
        </div>



    </div>

    <div class="right">
    	
    	<div id="name">{{$product->name}}</div>

		<div id="code">{{$product->code}} <div class="ui teal large label">{{$product->maker}}</div></div>

   		<div class="ui header">
   			@foreach ($product->categories as $category)
   			{{$category->name}}
   			@endforeach
   		</div>

		<div class="ui divider"></div>


		<div id="parameters" class="@if($product->parameters->count()==0) empty @endif" >
          <div class="ui header">Parametre</div>

      @if ($product->parameters->count() > 0)
          <div class="ui bulleted list">

          @foreach ($product->parameters as $parameter)
              <div class="item"><b>{{$parameter->key}}:</b> {{$parameter->value}}</div>
          @endforeach
        </div>
        @else
          Žiadne parametre
        @endif

    </div>

    <div class="ui divider"></div>


    <div id="price">{{$product->price}} &euro;</div>
    <div id="product_detail_tocart_btn" class="ui large brown button"><i class="add to cart icon"></i>Kúpiť</div>


 </div>
</div>



  <div class="ui mini modal" id="delete_product_modal">
            
    <div class="header">
      Zmazať produkt
    </div>
    <div class="content">
       Naozaj chcete vymazať produkt
    </div>
    <div class="actions">
      <div class="ui red deny button">
        Níe
      </div>
      <div class="ui positive right labeled icon button">
        Áno
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>


@stop