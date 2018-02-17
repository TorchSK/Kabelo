<div class="category">
	<div class="image">
		@if($category->image)
			<img src="/{{$category->image}}" />
		@else
			<img src="/img/empty.jpg" width="200" />
		@endif

	</div>
	<div class="name">
		{{$category->name}}
	</div>
</div>