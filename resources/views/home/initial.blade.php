<div class="ui horizontal divider active title">Akcie</div>

<div id="home_sales_div">
@foreach(App\Product::where('sale',1)->get() as $product)
    @include('products.row')
@endforeach
</div>

<div class="ui horizontal divider active title">Novinky</div>

<div id="home_news_div">
@foreach(App\Product::where('new',1)->get() as $product)
    @include('products.row')
@endforeach
</div>

<div class="ui horizontal divider active title">Katalógy</div>


@if($appname=="Dedra")
<div id="home_catalaogue_div">

	<a href="{{asset('storage/catalogues/9/page-001-L.jpg')}}" class="cat_img" data-rel="9" >
		<img src="/img/catalogue9.jpg" width="250"/>
	</a>

    <div class="hiden">
	  @foreach(Storage::disk('public')->files('catalogues/9') as $image)
	    <a class="img ct cat_img" href="{{asset('storage/'.$image)}}" @if(strpos($image,'001')==false) data-rel="9" @endif>
	     	<img src="{{asset('storage/'.$image)}}" class="ui image"/>
	    </a>
	   @endforeach
 </div>

	<a href="">
		<img src="/img/catalogue8.jpg" width="250"/>
	</a>

	<a href="">
		<img src="/img/catalogue7.jpg" width="250"/>

	</a>

</div>
@endif