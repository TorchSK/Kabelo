@extends('layouts.admin')
@section('content')



<div id="admin_settings_banner" class="admin_wrapper">


	<div class="admin_cover_list">
     	@foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach

        <form action="{{route('cover.store')}}" class="dropzone" id="add_cover_dropzone"> 
			<input name="_token" hidden value="{!! csrf_token() !!}" />
		</form>

	</div>
	
	<button class="ui blue button" id="add_cover_btn">Nový cover</button>
	<a href="{{route('admin.makeCover')}}" class="ui teal button"><i class="settings icon"></i> Vyrobiť cover</a>
</div>

@stop

