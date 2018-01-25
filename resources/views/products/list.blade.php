<div id="grid_stats" data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}">
@foreach($products as $product)
	@include('products.row')
@endforeach
</div>