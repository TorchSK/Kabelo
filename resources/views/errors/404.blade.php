@extends('layouts.master')
@section('content')



<div class="not_found wrapper flex_column">
<div class="container">
	<i class="blue up arrow icon"></i>
	<div class="search text">Vyhľadajte prosím podobný produkt vyšsie</div>

	<i class="red times circle icon"></i>
	<div class="text"><i>Táto stránka neexistuje</i></div>
	<a class="ui huge teal button" href="{{route('home.index')}}">Úvodná stránka</a>

</div>
</div>

@stop