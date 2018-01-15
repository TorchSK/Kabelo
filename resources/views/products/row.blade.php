<div class="item product" data-productid={{$product->id}}>
<a href="/{{strtolower($product->maker)}}/{{$product->code}}/detail">
	<div class="image_div">
		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" width="200" class="ui image" />
		@else
           <img src="/{{$product->image->path}}" class="ui image" />

	@endif

	</div>
	<div class="title">{{$product->name}}</div>
	<div class="price">{{$product->price}} Eur</div>
	<div class="availability"></div>

	@if((!isset($cart) || !$cart) && Request::segment(1) != 'admin'  && (!isset($cart_confirm) || !$cart_confirm))
	<a class="to_cart">
		<button class="ui teal icon button">
	  		<i class="shop icon"></i>
	  		Kúpiť
		</button>
	</a>
	@elseif(Request::segment(1) == 'admin')
		<a href="/product/create?duplicate={{$product->id}}" class="ui button">Duplikuj</a>
	@endif

</a>

@if(isset($cart) && $cart && (!isset($cart_confirm) || !$cart_confirm))
<div class="cart_item_actions">
	<div class="ui right labeled action input">
		<input type="text" value="{{array_count_values($cartItems)[$product->id]}}" />
		<div class="ui basic label">ks</div>
	</div>

	<a class="cart_plus_product"><i class="plus icon"></i></a>
	<a class="cart_minus_product"><i class="minus icon"></i></a>
	
	<div>
		<div class="ui red button cart_delete_product">Vymaž</div>
	</div>

</div>
@endif

</div>