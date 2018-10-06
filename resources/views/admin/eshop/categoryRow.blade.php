<li class="category item" data-id="{{$category->id}}" data-active="{{$category->active}}" data-type="category">
	<div class="title">
	

		<div class="handle">
			<i class="bars icon"></i>
		</div>
	<div class="active_flag">
			@if($category->active)
				<i class="green circle icon"></i>
			@else	
				<i class="red circle icon"></i>

			@endif
		</div>
		<div class="image">
			<a href="{{route('admin.eshop.category',['category'=>$category->url])}}"><img src="{{url($category->image)}}" width="50"/></a>
		</div>

		<div class="name">
			@if($category->children->where('active',1)->count() > 0) 
			<i class="dropdown icon"></i>
			@else
			<i class="cube icon"></i>
			@endif

			{{$category->name}}
		</div>
		
		<a class="edit_category_btn" href="{{route('admin.eshop.category',['category'=>$category->url])}}"><div class="ui teal mini icon button"><i class="edit icon"></i></div></a>
		<div class="no_of_items">produktov: <b>{{$categoryCounts['categories'][$category->id] }}</b></div>

	</div>

	<div class="content">
		<ul class="accordion">
			@foreach ($category->children as $child)
				@include('admin.eshop.categoryRow',['category' => $child])
			@endforeach
		</ul>
	</div>
</li>