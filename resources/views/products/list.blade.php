@foreach($products as $product)
	@include('products.row',['grid'=>1])
@endforeach


<a href="{{ $products->nextPageUrl()}}" class="hidden" id="next_page" data-next="{{$products->hasMorePages()}}"></a>
