@extends('layouts.master')
@section('content')

       
        <div id="admin" class="content">

          @include('admin.sidebar')
          
            <div id="grid">
            <div class="item new_product_btn">
				<a href="/product/create?category={{$category->id}}">
					<i class="huge icons">
					  <i class="big thin brown circle icon"></i>
					  <i class="plus brown icon"></i>
					</i>
					Pridaj produkt
				</a>
				</div>

    		@foreach ($products as $product)
    			@include('products.row')
    		@endforeach
           </div>

 

    </div>

@stop