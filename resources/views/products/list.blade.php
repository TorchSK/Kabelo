@foreach($products as $product)
	@include('products.row')
@endforeach

{{ $products->links() }}