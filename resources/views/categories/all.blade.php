@extends('layouts.master')
@section('content')

<div class="flex_content">
<ul class="category_images">

@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    	<li class="item category @if($category->parent_id) sub @endif" data-id={{$category->id}}>
			<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$category->name}}</a>
			<div class="no_of_items">produktov: {{$categoryCounts['categories'][$category->id] }}</div>



		</li>

		@foreach ($category->children->sortBy('order') as $child)
	    	<li class="item category @if($child->parent_id) sub @endif" data-id={{$child->id}}>
				<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$child->name}}</a>
				<div class="no_of_items">produktov: {{$categoryCounts['categories'][$child->id]}}</div>



					@foreach ($child->children->sortBy('order') as $child2)
				    	<li class="item category @if($child->parent_id) sub2 @endif" data-id={{$child2->id}}>
							<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$child2->name}}</a>
							<div class="no_of_items">produktov: {{$categoryCounts['categories'][$child2->id]}}</div>



						</li>
					@endforeach
			</li>
		@endforeach
		@endforeach

</ul>
</div>

@stop