<div class="item">
<a href="/{{strtolower($product->maker)}}/{{$product->code}}/detail">
	<div class="image_div">
		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" width="200" class="ui image" />
		@else
           <img src="/{{$product->image->path}}"  width="200" class="ui image" />

	@endif

	</div>
	<div class="title">{{$product->name}}</div>
	<div class="desc">{{$product->desc}}</div>
	<div class="price">{{$product->price}} Eur</div>
	<div class="availability"></div>
	<a href="/a" class="to_cart">
		<button class="ui teal icon button">
	  		<i class="shop icon"></i>
	  		Kúpiť
		</button>
	</a>
</a>
</div>