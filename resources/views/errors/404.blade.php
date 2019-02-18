@extends('layouts.master')
@section('content')



<div class="not_found wrapper flex_column">
<div class="container">

	<i class="red times circle icon"></i>
	<div class="text">Táto stránka neexistuje</div>
	<a class="ui huge teal button" href="{{route('home.index')}}">Úvodná stránka</a>

</div>
</div>

@stop