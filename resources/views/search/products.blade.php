@foreach($products as $product)
	<a class="row" href="/{{$product->maker}}/{{$product->code}}/detail">
		<div class="image">
			@if ($product->images->count() == 0)
			<img src="/img/empty.jpg" class="ui image" />
				@elseif ($product->image)
		           <img src="/{{$product->image->path}}" class="ui image" />
			@endif
		</div>
		<div class="name">{{$product->name}}</div>
	</a>
@endforeach