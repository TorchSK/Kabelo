@extends('layouts.master')
@section('content')

<div class="category_images">

	@foreach(App\Category::orderBy('order')->get() as $category)
		@include('categories/image')
	@endforeach

</div>

@stop