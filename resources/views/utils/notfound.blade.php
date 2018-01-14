@extends('layouts.master')
@section('content')

@include('includes.header')

<div class="pad wrapper">
<div class="container ct">

<i class="massive remove red circle icon"></i>

<h1 class="ui header">
	@if (Request::segment(1)=='kennel' && Request::segment(3))
	This litter is not yet registered
	@else
	This {!!Request::segment(1)!!} is not yet registered
	@endif

</h1>
<a href="/{!!Request::segment(1)!!}" class="ui labeled blue icon button" id="back_to_homepage_btn">
<i class="left arrow icon"></i>
Display all {!!Request::segment(1)!!}s
</a>

</div>
</div>



@stop