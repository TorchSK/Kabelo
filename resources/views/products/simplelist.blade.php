@foreach($products as $product)
	<div>{{$product->code}} - {{$product->name}}</div>
@endforeach