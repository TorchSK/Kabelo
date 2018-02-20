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