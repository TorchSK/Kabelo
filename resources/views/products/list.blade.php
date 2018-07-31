@foreach($products as $product)
	@include('products.row')
@endforeach

<a href="{{ $products->nextPageUrl()}}" class="hidden" id="next_page" data-next="{{$products->hasMorePages()}}"></a>
