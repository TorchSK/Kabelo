<div class="title">
	
	<div class="name">
		@if($category->children->where('active',1)->count() > 0) 
		<i class="dropdown icon"></i>
		@else
		<i class="cube icon"></i>
		@endif

		{{$category->name}}
	</div>
	
	<div class="no_of_items">produktov: {{$categoryCounts['categories'][$category->id] }}</div>
	<a class="edit_category_btn" href="{{route('admin.eshop.products',['category'=>$category->url])}}"><div class="ui teal mini icon button"><i class="edit icon"></i></div></a>

</div>

<div class="content">
	<div class="accordion">
		@foreach ($category->children as $child)
			@include('admin.eshop.categoryRow',['category' => $child])
		@endforeach
	</div>
</div>

