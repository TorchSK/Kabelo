<div class="category_image">
	<a href="/{{$category->url}}">
	<div class="image">
		@if($category->image)
			<img src="/{{$category->image}}" />
		@else
			<img src="/img/category.jpg" width="400" />
		@endif

	</div>

	@if (Request::segment(1)!='admin')
	<div class="name">
		{{$category->name}}
	</div>
	@endif
	</a>
</div>
