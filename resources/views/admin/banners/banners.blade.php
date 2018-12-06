@extends('layouts.admin')
@section('content')



<div id="admin_settings_banner" class="admin_wrapper">

	@include('admin.info',['text'=>'Nastavenie zobrazovania bannerov na úvodnej strane eshopu'])

	<div class="admin_banner_list">
     	@foreach(App\Banner::orderBy('order')->get() as $cover)
            @include('home.banner')
        @endforeach

        <form action="{{route('banner.store')}}" class="dropzone" id="add_banner_dropzone"> 
			<input name="_token" hidden value="{!! csrf_token() !!}" />
		</form>

	</div>
	
	<button class="ui blue button" id="add_banner_btn">Nový baner</button>
</div>

@stop

