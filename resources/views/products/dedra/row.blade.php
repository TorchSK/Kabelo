<div class="item product @if(isset($grid) && $grid)grid @endif @if($product->active==0) inactive @endif" data-productid={{$product->id}} data-minqty="{{$product->priceLevels->min('threshold')}}">
	<a class="p_anch" href="{{route('product.detail',['url'=>$product->url])}}">@if($product->categories->count() > 0) {{$product->categories->first()->name}} @endif, {{$product->code}} - {{$product->name}}</a>
	


	<div class="image_div ct" style="height: 220px;">

		@if($product->rowStickers->count() > 0)
	      @foreach($product->rowStickers as $sticker)
	        <div class="sticker" style="left: {{$sticker->left}}px; top: {{$sticker->top}}px; width: {{$sticker->width}}px; height: {{$sticker->height}}px;">
	          <img src="{{url($sticker->path)}}" >
	        </div>
	      @endforeach
	     @endif

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
			@if($product->thumbnail_flag==1)
			 <img src="{{$product->image->thumb}}" class="ui image" alt="{{$product->code}}" style="max-height: 187px; display: inline-block;"/>
			@else
			 <img src="{{$product->image->path}}" class="ui image" alt="{{$product->code}}" style="max-height: 187px; display: inline-block;"/>
           @endif
	@endif

	</div>

	<div class="title">{{$product->name}}</div>


	@if(!isset($showdesc))
	<div class="desc">{{substr(trim($product->desc, "\xA0"),0,2000)}}</div>
	@endif
	
	
	@if(Auth::check() && Auth::user()->admin && $appname=='aa')
	<div class="code">{{$product->code}}</div>
	@endif



    <div class="prices">
    	@if($product->sale)
	    <div class="price crossed">{{number_format($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular,2)}} &euro; </div>
	    <div class="final_price">{{number_format($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale,2)}} &euro;</div>
	    @else
	    <div class="final_price">{{number_format($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular,2)}} &euro;</div>
	    @endif
    </div>


	<div class="availability"></div>

	@if((!isset($productOptions) || !$productOptions) && Request::segment(1) != 'admin'  && (!isset($cart_confirm) || !$cart_confirm))
	<div class="buttons_div">
		@if(Auth::check() && Auth::user()->admin)
		<div class="ui icon fluid buttons">
		<a href="{{route('product.edit',['product'=>$product->url])}}" class=" ui blue  button"><i class="edit icon"></i></a>
		<a href="{{route('product.create',['duplicate'=>$product->id])}}" class=" ui yellow  button"><i class="clone icon"></i></a>
		<a class=" ui red button product_row_delete_btn"><i class="delete icon"></i></a>
		</div>
		@endif

		<a class="to_cart ui fluid icon button"><i class="shop icon"></i> Kúpiť</a>
	</div>
	@elseif(Request::segment(1) == 'admin')
		<div class="actions ui fluid icon buttons">
		<a href="{{route('product.edit',['product'=>$product->url])}}" class="ui blue small button"><i class="edit icon"></i></a>
		<a href="{{route('product.create',['duplicate'=>$product->id])}}" class="ui teal small button"><i class="copy icon"></i></a>
		<a class="ui red small button product_row_delete_btn"><i class="delete icon"></i></a>
		</div>	
	@endif



</div>