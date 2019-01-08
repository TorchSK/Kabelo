@foreach($products as $product)
	@include('products.row',['grid'=>1])
@endforeach

<div class="scroll_to_top"><i class="big icon teal circular inverted angle double up"></i></div>

<a href="{{ $products->nextPageUrl()}}" class="hidden" id="next_page" data-next="{{$products->hasMorePages()}}"></a>
