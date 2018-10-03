@extends('layouts.admin')
@section('content')

<div id="admin_categories" class="admin_wrapper">

    <div class="admin_categories_list">
	    <div class="ui fluid styled accordion">
		    @foreach ($categories as $category)
		      @include('admin.eshop.categoryRow')
		    @endforeach
	    </div>
	</div>
  </div>

    
@stop