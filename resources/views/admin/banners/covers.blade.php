@extends('layouts.admin')
@section('content')



<div id="admin_settings_banner" class="admin_wrapper">


	<div class="admin_cover_list">
     	@foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach

        <form action="/admin/banner/upload" class="dropzone" id="banner_dropzone"> 
			<input name="_token" hidden value="{!! csrf_token() !!}" />
			 <div class="dz-message">Nový banner</div>
		</form>

	</div>
	
	<a href="{{route('admin.addCover')}}" class="ui blue button">Nový cover</a>
	<a href="{{route('admin.addCover')}}" class="ui teal button"><i class="settings icon"></i> Vyrobiť cover</a>
</div>

@stop

