@extends('layouts.admin')
@section('content')

<div id="admin_categories" class="admin_wrapper">
	<div class="expand_all_toggle" data-target="cats">Rozbal všetko</div>

    <div class="admin_categories_list">
	    <ul class="ui fluid styled accordion" data-target="cats">
		    @foreach ($categories as $category)
		      @include('admin.eshop.categoryRow')
		    @endforeach
	    </ul>
	</div>
  </div>

    
@stop