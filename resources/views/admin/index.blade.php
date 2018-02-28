@extends('layouts.admin')
@section('content')


    @include('admin.sidebar')

		<div class="admin_categories_list">
    	@if ($categories->count() > 0 )
		@foreach ($categories as $category)
    	<div class="item category" data-id={{$category->id}}>
			<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$category->name}}</a>
			<div class="no_of_items">produktov: {{$category->products()->count()}}</div>
			<a class="admin_delete_category_btn ui red label">Zmaž</a>
			<a href="/category/{{$category->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

		</div>
		@endforeach
		@endif



    </div>

@stop