@if($layout == 1)
<div class="ui horizontal divider active title">Novinky</div>
@endif

<div id="home_news_div">
<div class="caption">
	Novinky
</div>
<div class="items">
@foreach(App\Product::where('new',1)->get() as $product)
    @include('products.row')
@endforeach
</div>
</div>

@if($layout == 1)
<div class="ui horizontal divider active title">Akcie</div>
@endif

<div id="home_sales_div">
<div class="caption">
	Akcie
</div>
<div class="items">
@foreach(App\Product::where('sale',1)->get() as $product)
    @include('products.row')
@endforeach
</div>

</div>

