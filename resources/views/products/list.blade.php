@foreach($products as $product)
	@include('products.row')
@endforeach

@if(Request::get('category') || Route::currentRouteName()=='maker.products')

<div class="ct @if($appname=="Dedra") hidden @endif" id="pag" style="position: absolute;">
	<div></div>
	
	<!--
    <div class="middle"><div class="ui large teal button" id="more_button">Viac produktov</div></div>
	-->

    <div style="position: absolute;" class="hidden">{{$products->links()}}</div>
</div>

@endif

<a href="{{ $products->nextPageUrl()}}" class="hidden" id="next_page" data-next="{{$products->hasMorePages()}}"></a>
