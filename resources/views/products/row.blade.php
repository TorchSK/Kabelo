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

	@if(!isset($cart) || !$cart)
	<a href="/a" class="to_cart">
		<button class="ui teal icon button">
	  		<i class="shop icon"></i>
	  		Kúpiť
		</button>
	</a>
	@endif

</a>
@if(isset($cart) && $cart)
<div class="cart_item_actions">
	<div class="ui right labeled action input">
		<input type="text" value="{{array_count_values($cartItems)[$product->id]}}" />
		<div class="ui basic label">ks</div>
		<div type="submit" class="ui icon button"><i class="plus icon"></i></div>
		<div type="submit" class="ui icon button"><i class="minus icon"></i></div>
	</div>
	
	<div>
		<div class="ui red button">Vymaž</div>
	</div>

</div>
@endif

</div>