<div class="item">
	<div class="image">@if($product->image)<img src="{{$product->image->path}}"  />@endif</div>
	<div class="code">{{$product->code}}</div>
	<div class="name">{{$product->name}}</div>
	<div class="price">{{$product->price}} &euro;</div>
	<div class="category">{{$product->category_path}}</div>

</div>