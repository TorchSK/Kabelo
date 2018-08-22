@extends('layouts.admin')
@section('content')



<div class="admin_settings">

	<div class="tabs">

	    @include('admin.settingstabs',['active'=>1])

	</div>


	<div class="ui horizontal divider">Banery</div>

	<div class="admin_cover_list">
     	@foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach
	</div>
	
	<a href="{{route('admin.addCover')}}" class="ui blue button">Pridať baner</a>
</div>

@stop

