<div class="category_image">
	@if(Request::segment(1)=='admin')
	<a href="/admin/category/{{$category->url}}">
	@else
	<a href="/category/{{$category->url}}">
	@endif
	<div class="image @if (Request::segment(1)!='admin') btn-4  @endif">
		@if($category->image)
			<img src="/{{$category->image}}" width="180"/>
		@else
			<img src="/img/category.jpg" width="180" />
		@endif

		<div class="options">
			<a class="ui green tiny button change_cat_img_btn">Zmeň obrázok</a>
		</div>
	
	</div>

	<div class="name">
		{{$category->name}}
	</div>
	
	</a>
</div>
