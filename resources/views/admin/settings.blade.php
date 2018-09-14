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

        <form action="/admin/banner/upload" class="dropzone" id="banner_dropzone"> 
			<input name="_token" hidden value="{!! csrf_token() !!}" />
			 <div class="dz-message">Nový banner</div>
		</form>

	</div>
	
	<a href="{{route('admin.addCover')}}" class="ui blue button">Vyrobiť baner</a>
</div>

@stop

