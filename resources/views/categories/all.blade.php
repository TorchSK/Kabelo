@extends('layouts.master')
@section('content')

<div class="category_images">

    <div class="ui horizontal divider">Základné kategórie</div>

	@foreach(App\Category::orderBy('order')->whereNull('parent_id')->get() as $category)
		@include('categories/image')
	@endforeach
    
    <div class="ui horizontal divider">Podrobné kategórie</div>

	@foreach(App\Category::orderBy('order')->whereNotNull('parent_id')->get() as $category)
		@include('categories/image')
	@endforeach

</div>

@stop