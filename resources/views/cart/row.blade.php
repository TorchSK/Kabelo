<div class="product" data-productid={{$product->id}} data-minqty="{{$product->priceLevels->min('threshold')}}">
	<div class="image_div">
		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" class="ui image" />
		@elseif ($product->image)
           <img src="/{{$product->image->path}}" class="ui image" />
		@endif
	</div>

	<div class="name">{{$product->name}}</div>
	<div class="delete cart_delete_product" data-tooltip="Zmazat"><i class="icon red large delete"></i></div>

	@if(!isset($cart_confirm) || !$cart_confirm)
	<div class="actions">
		
		<div class="cart_slider" >
			<div class="cart_length_slider" data-productid="{{$product->id}}" data-qty="{{$product->pivot->qty}}" data-min="{{$product->priceLevels->min('threshold')}}" data-thresholds="{{$product->priceLevels->pluck('threshold')}}" data-prices="@if(Auth::user()->voc)@if($product->sale){{$product->priceLevels->pluck('voc_sale')}}@else{{$product->priceLevels->pluck('voc_regular')}}@endif @else @if($product->sale) {{$product->priceLevels->pluck('moc_sale')}} @else {{$product->priceLevels->pluck('moc_regular') }} @endif @endif"></div>
		</div>

	</div>
	@endif

	<div class="level">
		<div>Cena: 
			@if(Auth::user()->voc)
		    @if($product->sale)
		    {{App\PriceLevel::find($product->pivot->price_level_id)->voc_sale}} &euro;
		    @else
		    {{App\PriceLevel::find($product->pivot->price_level_id)->voc_regular}} &euro;
		    @endif
		  	@else
		    @if($product->sale)
		    {{App\PriceLevel::find($product->pivot->price_level_id)->moc_sale}} &euro;
		    @else
		    {{App\PriceLevel::find($product->pivot->price_level_id)->moc_regular}} &euro;
		    @endif
		  @endif
		</div>
		<div>Množstvo: {{$product->pivot->qty}}</div>
	</div>

    <div class="price">
    @if(Auth::user()->voc)
	    @if($product->sale)
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->voc_sale*$product->pivot->qty}} &euro; </div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->voc_regular*$product->pivot->qty}} &euro;</div>
	    @endif
	  	@else
	    @if($product->sale)
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_sale*$product->pivot->qty}} &euro;</div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_regular*$product->pivot->qty}} &euro;</div>
	    @endif
	  @endif
    </div>

</div>