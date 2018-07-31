<grid>
@foreach($products as $product)
	@include('products.row')
@endforeach
</grid>

@if(Request::get('category') || Route::currentRouteName()=='maker.products')

<div class="ct" id="pag">
	<div></div>
    <div class="middle"><div class="ui large teal button" id="more_button">Viac produktov</div></div>
    <div>{{$products->links()}}</div>
</div>
@endif

<a href="{{ $products->nextPageUrl()}}" class="hidden" id="next_page" data-next="{{$products->hasMorePages()}}"></a>
