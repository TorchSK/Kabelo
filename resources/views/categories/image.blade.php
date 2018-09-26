<div class="category_image">
	@if(Request::segment(1)=='admin')
		<a href="/admin/category/{{$category->url}}">
	@else
		<a href="{{route('category.products',['path'=> $category->full_url])}}">
	@endif
	<div class="image @if (Request::segment(1)!='admin') btn-4  @endif">
		<img src="{{url($category->image)}}" alt="{{$category->name}}"/>
		@if(Request::segment(1)=='admin')
		<div class="options">
			<a class="ui green tiny button change_cat_img_btn">Zmeň obrázok</a>
		</div>
		@endif
	
	</div>

	<div class="name">
		{{$category->name}}
	</div>
	
	</a>
</div>
