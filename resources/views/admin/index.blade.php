@extends('layouts.admin')
@section('content')


    @include('admin.sidebar')

		<ul class="admin_categories_list">
		@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    	<li class="item category @if($category->parent_id) sub @endif" data-id={{$category->id}}>
			<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$category->name}}</a>
			<div class="no_of_items">produktov: {{$categoryCounts['categories'][$category->id] }}</div>


			<a class="admin_delete_category_btn ui red label">Zmaž</a>
			<a href="/category/{{$category->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

		</li>

		@foreach ($category->children as $child)
	    	<li class="item category @if($child->parent_id) sub @endif" data-id={{$category->id}}>
				<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$child->name}}</a>
				<div class="no_of_items">produktov: {{$categoryCounts['categories'][$child->id]}}</div>


				<a class="admin_delete_category_btn ui red label">Zmaž</a>
				<a href="/category/{{$child->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

					@foreach ($child->children as $child2)
				    	<li class="item category @if($child->parent_id) sub2 @endif" data-id={{$category->id}}>
							<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$child2->name}}</a>
							<div class="no_of_items">produktov: {{$categoryCounts['categories'][$child2->id]}}</div>


							<a class="admin_delete_category_btn ui red label">Zmaž</a>
							<a href="/category/{{$category->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

						</li>
					@endforeach
			</li>
		@endforeach
		@endforeach
		</ul>




@stop