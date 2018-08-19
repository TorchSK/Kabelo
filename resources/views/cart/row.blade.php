<div class="product" data-productid={{$product->id}} data-minqty="{{$product->priceLevels->min('threshold')}}">
	<div class="image_div">
		@if ($product->images->count() == 0)
			<a href="/{{$product->maker}}/{{$product->code}}/detail"><img src="/img/empty.jpg" class="ui image" /></a>
		@elseif ($product->image)
           <a href="{{$product->maker}}/{{$product->code}}/detail"><img src="/{{$product->image->path}}" class="ui image" /></a>
		@endif
	</div>

	<div class="name"><a href="/{{$product->maker}}/{{$product->code}}/detail">{{$product->name}}</a></div>
	<div class="delete cart_delete_product" data-tooltip="Zmazat"><i class="icon red large delete"></i></div>

	@if(!isset($cart_confirm) || !$cart_confirm)
	<div class="actions">
		
		<div class="cart_slider" >
			@if (Auth::check())
			<div class="cart_length_slider" data-productid="{{$product->id}}" data-qty="{{$product->pivot->qty}}" data-min="{{$product->priceLevels->min('threshold')}}" data-thresholds="{{$product->priceLevels->pluck('threshold')}}" data-prices="@if(Auth::user()->voc)@if($product->sale){{$product->priceLevels->pluck('voc_sale')}}@else{{$product->priceLevels->pluck('voc_regular')}}@endif @else @if($product->sale) {{$product->priceLevels->pluck('moc_sale')}} @else {{$product->priceLevels->pluck('moc_regular') }} @endif @endif"></div>
			@else
			<div class="cart_length_slider" data-productid="{{$product->id}}" data-qty="{{$cart['counts'][$product->id]}}" data-min="{{$product->priceLevels->min('threshold')}}" data-thresholds="{{$product->priceLevels->pluck('threshold')}}" data-prices=" @if($product->sale){{$product->priceLevels->pluck('moc_sale')}}@else{{$product->priceLevels->pluck('moc_regular')}}@endif "></div>
			@endif
		</div>

	</div>
	@endif

	<div class="level">
		<div>Cena: 
			@if(Auth::check())
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
			@else
				@if($product->sale)
			    	{{App\PriceLevel::find($cart['price_levels'][$product->id])->moc_sale}} &euro;
		    	@else
			    	{{App\PriceLevel::find($cart['price_levels'][$product->id])->moc_regular}} &euro;
		   		@endif
			@endif
		</div>
		@if(Auth::check())
		<div>Množstvo: {{$product->pivot->qty}}</div>
		@else
		<div>Množstvo: {{$cart['counts'][$product->id]}}</div>
		@endif
	</div>

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

</div>