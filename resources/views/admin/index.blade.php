@extends('layouts.master')
@section('content')

    <div id="admin" class="content">

    @include('admin.sidebar')

    <div class="admin_categories_list">
    	@if ($categories->count() > 0 )
		@foreach ($categories as $category)
    	<div class="item">
			<a class="name" href="/admin/category/{{$category->id}}/products">{{$category->name}}</a>
			<div class="no_of_items">produktov: {{$category->products()->count()}}</div>
			<a href="/category/{{$category->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>
		</div>
		@endforeach
		@endif

    </div>


	</div>

@stop