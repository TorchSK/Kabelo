@extends('layouts.admin')
@section('content')



<div class="admin_settings">

	<div class="tabs">

	    <a href="/admin/settings/banners" class="tabb ui blue button">Bannery</a>
	    <a href="/admin/settings/eshop" class="tabb ui basic button">Eshop</a>
	   	<a href="/admin/settings/delivery" class="tabb ui basic button">Preprava</a>
	    <a href="/admin/settings/invoice" class="tabb ui basic button">Faktura</a>

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

