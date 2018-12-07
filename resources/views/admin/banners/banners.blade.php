@extends('layouts.admin')
@section('content')



<div id="admin_settings_banner" class="admin_wrapper">

	@include('admin.info',['text'=>'Nastavenie zobrazovania bannerov na úvodnej strane eshopu'])

	<div class="admin_banner_list">
     	@foreach(App\Banner::orderBy('order')->get() as $cover)
            @include('home.banner')
        @endforeach

	</div>
	
	<a href="{{route('banner.create')}}" class="ui blue button">Nový cover</a>
</div>

@stop

