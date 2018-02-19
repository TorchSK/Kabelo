<div class="category_image">
	<a href="/{{$category->url}}">
	<div class="image @if (Request::segment(1)!='admin') hover @endif">
		@if($category->image)
			<img src="/{{$category->image}}" width="350"/>
		@else
			<img src="/img/category.jpg" width="350" />
		@endif

	</div>

	@if (Request::segment(1)!='admin')
	<div class="name">
		{{$category->name}}
	</div>
	@endif
	</a>
</div>
