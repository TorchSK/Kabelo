<div class="item product grid @if($product->active==0) inactive @endif" data-productid={{$product->id}} data-minqty="{{$product->priceLevels->min('threshold')}}">
<a href="/{{strtolower($product->maker)}}/{{$product->code}}/detail">
	


	<div class="image_div ct">

	 <div class="labels">
		@if ($product->sale || (Auth::check() && Auth::user()->discount > 0))
		<div class="ui green label">-

			@if(Auth::check())

				@if(Auth::user()->voc)
				{{$product->sale*round(1 - ($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_sale/$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular),2)*100}} 
				@else
				{{$product->sale*round(1 - ($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale/$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular),2)*100}} 
				@endif

			@else
			{{$product->sale*round(1 - ($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale/$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular),2)*100}} 
			@endif

		%</div>
		@endif

		@if ($product->new)
		<div class="ui blue label">Novinka</div>
		@endif

	</div>

		@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" class="ui image"/>
		@elseif ($product->image)
           <img src="{{$product->image->path}}" class="ui image" height="187" style="display: inline-block;"/>
	@endif

	</div>

	<div class="desc">{{$product->desc}}</div>

	<div class="title">{{$product->name}}</div>
	
	@if(Auth::check() && Auth::user()->admin)
	<div class="code">{{$product->code}}</div>
	@endif



    <div class="prices">
	    <div class="final_price">{{$product->price}} &euro;</div>
    </div>


	<div class="availability"></div>

	@if((!isset($productOptions) || !$productOptions) && Request::segment(1) != 'admin'  && (!isset($cart_confirm) || !$cart_confirm))
	<div class="buttons_div">
		@if(Auth::check() && Auth::user()->admin)
		<div class="ui icon fluid buttons">
		<a href="/{{$product->maker}}/{{$product->code}}/edit" class=" ui blue  button"><i class="edit icon"></i></a>
		<a href="/product/create?duplicate={{$product->id}}" class=" ui yellow  button"><i class="clone icon"></i></a>
		<a class=" ui red button product_row_delete_btn"><i class="delete icon"></i></a>
		</div>
		@endif

		<a class="to_cart ui fluid teal icon button"><i class="shop icon"></i> Kúpiť &nbsp;{{$product->priceLevels->min('threshold')}} {{$product->price_unit}}</a>
	</div>
	@elseif(Request::segment(1) == 'admin')
		<div class="actions ui fluid icon buttons">
		<a href="/{{$product->maker}}/{{$product->code}}/edit" class="ui blue small button"><i class="edit icon"></i></a>
		<a href="/product/create?duplicate={{$product->id}}" class="ui teal small button"><i class="copy icon"></i></a>
		<a class="ui red small button product_row_delete_btn"><i class="delete icon"></i></a>
		</div>	
	@endif

	<div class="stock @if($product->stock >0) instock @else outstock @endif">
		@if($product->stock > 0)
		Skladom 		{{$product->stock}} {{$product->price_unit}}
		@else
		Na objednávku 
		@endif


	</div>
</a>


</div>