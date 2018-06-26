<div class="item product" data-productid={{$product->id}}>
<a href="/{{strtolower($product->maker)}}/{{$product->code}}/detail">
	


	<div class="image_div">

	 <div class="labels">
		@if ($product->sale)
		<div class="ui green label">-

			@if(Auth::user()->voc)
			{{round(1 - ($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_sale/$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular),2)*100}} 
			@else
			{{round(1 - ($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale/$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular),2)*100}} 
			@endif

		%</div>
		@endif

		@if ($product->new)
		<div class="ui blue label">Novinka</div>
		@endif

	</div>

		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" class="ui image" />
		@elseif ($product->image)
           <img src="/{{$product->image->path}}" class="ui image" />
	@endif

	</div>
		<div class="desc">{{$product->desc}}</div>

	<div class="title">{{$product->name}}</div>
	 


	@if(isset($productOptions) && $productOptions)

    <div class="prices">
    @if(Auth::user()->voc)
	    @if($product->sale)
	    <div class="price crossed">{{App\PriceLevel::find($product->pivot->price_level_id)->voc_regular}} &euro; </div>
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->voc_sale}} &euro; </div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id->voc_regular)}} &euro;</div>
	    @endif
	  @else
	    @if($product->sale)
	    <div class="price crossed">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_regular}} &euro; </div>
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_sale}} &euro;</div>
	    @else
	    <div class="final_price">{{App\PriceLevel::find($product->pivot->price_level_id)->moc_regular}} &euro;</div>
	    @endif
	  @endif
    </div>

    @else
    	<div class="prices">
    @if(Auth::user()->voc)
	    @if($product->sale)
	    <div class="price crossed">{{$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular}} &euro; </div>
	    <div class="final_price">{{$$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_sale}} &euro; </div>
	    @else
	    <div class="final_price">{{$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular}} &euro;</div>
	    @endif
	  @else
	    @if($product->sale)
	    <div class="price crossed">{{$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular}} &euro; </div>
	    <div class="final_price">{{$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale}} &euro;</div>
	    @else
	    <div class="final_price">{{$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular}} &euro;</div>
	    @endif
	  @endif
    </div>

    @endif

	<div class="availability"></div>

	@if((!isset($productOptions) || !$productOptions) && Request::segment(1) != 'admin'  && (!isset($cart_confirm) || !$cart_confirm))
	<a class="to_cart ui teal icon button"><i class="shop icon"></i> Kúpiť</a>
	@elseif(Request::segment(1) == 'admin')
		<div class="actions ui fluid icon buttons">
		<a href="/product/create?duplicate={{$product->id}}" class="ui teal small button"><i class="copy icon"></i></a>
		<a href="/{{$product->maker}}/{{$product->code}}/edit" class="ui blue small button"><i class="edit icon"></i></a>
		<a class="ui red small button product_row_delete_btn"><i class="delete icon"></i></a>
		</div>	
	@endif

</a>

@if(isset($productOptions) && $productOptions && (!isset($cart_confirm) || !$cart_confirm))
<div class="cart_item_actions">
	@if ($product->price_unit == 'ks')
	<div class="ui right labeled action input">
		<input type="text" value="{{array_count_values($cart['items'])[$product->id]}}" />
		<div class="ui basic label">ks</div>
	</div>

	<a class="cart_plus_product"><i class="plus icon"></i></a>
	<a class="cart_minus_product"><i class="minus icon"></i></a>
	
	<div>
		<div class="ui red button cart_delete_product">Vymaž</div>
	</div>
	@else
	<div class="cart_slider" >
		<div class="cart_length_slider" data-productid="{{$product->id}}" data-qty="{{$product->pivot->qty}}" data-min="{{$product->priceLevels->min('threshold')}}" data-thresholds="{{$product->priceLevels->pluck('threshold')}}" data-prices="@if(Auth::user()->voc)@if($product->sale){{$product->priceLevels->pluck('voc_sale')}}@else{{$product->priceLevels->pluck('voc_regular')}}@endif @else @if($product->sale) {{$product->priceLevels->pluck('moc_sale')}} @else {{$product->priceLevels->pluck('moc_regular') }} @endif @endif"></div>
	</div>
	@endif
</div>
@endif

</div>