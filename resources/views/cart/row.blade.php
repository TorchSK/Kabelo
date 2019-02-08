<div class="product" data-productid={{$product->id}} data-minqty="{{$product->priceLevels->min('threshold')}}">
	<div class="image_div">
		@if ($product->images->count() == 0)
			<a href="{{route('product.detail',['url'=>$product->url])}}"><img src="/img/empty.jpg" class="ui image" /></a>
		@else
           <a href="{{route('product.detail',['url'=>$product->url])}}"><img src="{{url($product->image->path)}}" class="ui image" /></a>
		@endif
	</div>

	<div class="name"><a href="{{route('product.detail',['url'=>$product->url])}}">{{$product->name}}</a></div>
	@if(!isset($cart_confirm) || !$cart_confirm)
	<div class="delete cart_delete_product" data-tooltip="Zmazat"><i class="icon red large delete"></i></div>
	@endif

	@if(!isset($cart_confirm) || !$cart_confirm)
	<div class="actions">
		<div class="qty">
			<i class="icon minus qty circle cart_minus_qty"></i>
			<div class="ui right labeled input">

				@if($product->pivot || isset($cart['counts']))
			  	<input type="text" value="@if(Auth::check()) {{$product->pivot->qty}} @else {{$cart['counts'][$product->id]}} @endif" class="cart_qty_input">

			  		<div class="ui basic label">ks</div>
			  	@endif
			</div>
			<i class="icon plus qty circle cart_plus_qty"></i>


		</div>

	</div>
	@else
		<div class="actions">
		</div>
	@endif

	@if($product->pivot)
    <div class="price">
    @if(Auth::check())
    
    @if(Auth::user()->voc)
	    @if($product->sale)
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->voc_sale*$product->pivot->qty*(1-Auth::user()->discount/100)}} &euro; </div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->voc_regular*$product->pivot->qty*(1-Auth::user()->discount/100)}} &euro;</div>
	    @endif
	  	@else
	    @if($product->sale)
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_sale*$product->pivot->qty*(1-Auth::user()->discount/100)}} &euro;</div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_regular*$product->pivot->qty*(1-Auth::user()->discount/100)}} &euro;</div>
	    @endif
	  @endif
	@else
  	
  	@if($product->sale)
	    <div class="final_price">{{App\PriceLevel::find($cart['price_levels'][$product->id])->moc_sale*$cart['counts'][$product->id]}} &euro; </div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($cart['price_levels'][$product->id])->moc_regular*$cart['counts'][$product->id]}} &euro; </div>
	    @endif
	 @endif
    </div>
    @endif

</div>