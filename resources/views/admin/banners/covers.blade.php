@extends('layouts.admin')
@section('content')



<div id="admin_settings_banner" class="admin_wrapper">


	<div class="admin_cover_list">
     	@foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach
	</div>
	
	<a href="{{route('cover.create')}}" class="ui blue button">Nový cover</a>
</div>

@stop

