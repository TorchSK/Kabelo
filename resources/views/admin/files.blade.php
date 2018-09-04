@extends('layouts.admin')
@section('content')
	
<div class="admin_wrapper" id="admin_settings">

	<div class="orders">

		<div id="files_list">
			@foreach($files as $file)
				<i class="huge file outline icon"></i>
				{{$file->path}}
			@endforeach
		</div>
	
		<form action="/file" class="dropzone" id="file_dropzone"> 
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                 <div class="dz-message">Klikni pre nahranie súborov</div>
        </form>

	</div>
</div>

@stop