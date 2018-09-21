@extends('layouts.admin')
@section('content')



<div id="admin_categories" class="admin_wrapper">

    <ul class="admin_categories_list">
    @foreach ($categories as $category)
      @include('admin.eshop.categoryRow')
    @endforeach
    </ul>

  </div>

    
@stop