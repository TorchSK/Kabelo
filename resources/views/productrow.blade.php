<div class="item">
<a href="/{{strtolower($product->maker)}}/{{$product->code}}">
	<div class="image_div">
		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" width="200" class="ui image" />

		@else

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