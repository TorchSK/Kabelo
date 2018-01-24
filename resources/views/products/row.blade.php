<div class="item product" data-productid={{$product->id}}>
<a href="/{{strtolower($product->maker)}}/{{$product->code}}/detail">
	


	<div class="image_div">

	 <div class="labels">
		@if ($product->sale)
		<div class="ui green label">- {{round(1 - ($product->sale_price/$product->price),2)*100}} %</div>
		@endif

		@if ($product->new)
		<div class="ui blue label">Novinka</div>
		@endif

	</div>

		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" width="200" class="ui image" />
		@elseif ($product->image)
           <img src="/{{$product->image->path}}" class="ui image" />
	@endif

	</div>
	<div class="title">{{$product->name}}</div>
	 



	<div class="prices">
    <div class="price @if($product->sale) crossed @endif">{{$product->price}} &euro;</div>
    @if ($product->sale)
    <div class="sale_price">{{$product->sale_price}} &euro;</div>
    @endif
    </div>

	<div class="availability"></div>

	@if((!isset($cart) || !$cart) && Request::segment(1) != 'admin'  && (!isset($cart_confirm) || !$cart_confirm))
	<a class="to_cart ui teal icon button"><i class="shop icon"></i> Kúpiť</a>
	@elseif(Request::segment(1) == 'admin')
		<div class="actions">
		<a href="/product/create?duplicate={{$product->id}}" class="ui teal small button">Duplikuj</a>
		<a href="/{{$product->maker}}/{{$product->code}}/edit" class="ui blue small button">Zmeň</a>
		<a class="ui red small button product_row_delete_btn">Zmaž</a>
		</div>	
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