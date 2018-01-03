@extends('layouts.master')
@section('content')

<div id="product_detail">
    <div class="left">
        <div class="img">
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" />
           @else

           @endif
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

    </div>

    <div class="right">
    	
    	<div id="name">{{$product->name}}</div>

		<div id="code">id: {{$product->code}} <div class="ui teal large label">{{$product->maker}}</div></div>

   		<div class="ui header">
   			@foreach ($product->categories as $category)
   			{{$category->name}}
   			@endforeach
   		</div>

		

		<div class="ui header">Parametre</div>

		<div class="ui header">
   			@foreach ($product->parameters as $parameter)
   			
   			@endforeach
   		</div>



 </div>
</div>

@stop