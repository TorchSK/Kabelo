<li>
	<div class="item category @if($category->parent_id) sub @endif" data-id="{{$category->id}}" data-active="{{$category->active}}">
		<div class="active_flag">
			@if($category->active)
				<i class="green circle icon"></i>
			@else	
				<i class="red circle icon"></i>

			@endif
		</div>
		<div class="image"><img src="{{url($category->image)}}" /></div>

	<a class="name" href="{{route('admin.eshop.products',['category'=>$category->url])}}">{{$category->name}}</a>

	<div class="no_of_items">produktov: {{$categoryCounts['categories'][$category->id] }}</div>

	<a class="admin_delete_category_btn ui red label">Zmaž</a>
	</div>

	<ul>
	@foreach ($category->children as $child)
			@include('admin.eshop.categoryRow',['category' => $child])
	@endforeach
	</ul>
	


</li>