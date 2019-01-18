<div class="product" data-productid={{$product->id}} data-minqty="{{$product->priceLevels->min('threshold')}}">
	
	<div class="count">{{$product->pivot->qty}} {{$product->price_unit}}</div>

	<div class="image_div">
		@if ($product->images->count() == 0)
			<a href="{{route('product.detail',['url'=>$product->url])}}"><img src="/img/empty.jpg" class="ui image" /></a>
		@elseif ($product->image)
           <a href="{{route('product.detail',['url'=>$product->url])}}"><img src="{{url($product->image->path)}}" class="ui image" /></a>
		@endif
	</div>

	<div class="code"><a href="{{route('product.detail',['url'=>$product->url])}}">{{$product->code}}</a></div>

	<div class="name"><a href="{{route('product.detail',['url'=>$product->url])}}">{{$product->name}}</a></div>


    <div class="price">
    	{{$product->pivot->price}} &euro;
    </div>

</div>