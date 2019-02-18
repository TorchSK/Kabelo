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

	
	@if(is_array(json_decode($product->pivot->sizes)) && count(json_decode($product->pivot->sizes)) > 0)
	<div class="sizes">
		Veľkosti: 
		<div class="list">
			@foreach(array_unique(json_decode($product->pivot->sizes)) as $size)
			<div class="size">
				<div class="text">{{App\Size::where('size_code', $size)->first()->text}}</div>
				<div class="count">{{array_count_values(json_decode($product->pivot->sizes))[$size]}}</div>
			</div>
			@endforeach
		</div>
	</div>
	@endif


    <div class="price">
    	<div>{{$product->pivot->price / $product->pivot->qty}} &euro; / {{$product->price_unit}}</div>
    	<div><b>{{$product->pivot->price}} &euro; </b></div>
    </div>

</div>