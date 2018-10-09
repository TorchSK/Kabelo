@extends('layouts.admin')
@section('content')
	
<div class="admin_wrapper" id="admin_settings">

	<div class="orders">

		<div id="files_list">
			@foreach($files as $file)
				<div>
					<i class="huge file outline icon"></i>
					<div class="ui action input"><input value="{{$file->path}}" />  <button class="ui icon teal button" data-tooltip="Kopíruj cestu"><i class="copy icon copy_to_clipboard_btn"></i></button></div>
					
					<form action="/catalogue/changeImage" class="hiden dropzone catalogue_image_dropzone"> 
								<input type="hidden" name="catalogue_id" value="{{$file->id}}" />
			                 <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
			                 <div class="dz-message">Klikni pre nahranie súborov</div>
			        </form>

					<div class="ui icon orange button catalogue_image_btn" data-id="{{$file->id}}"><i class="image icon"></i></div>
					<div class="ui icon red button"><i class="delete icon"></i></div>
				</div>
			@endforeach
		</div>


      <div class="ui fluid labeled input" id="catalogue_url_input">
           <div class="ui label">URL</div>
           <input type="text" name="name" />
      </div>


		<div class="catalogue_path_btn ui blue button"><i class="globe icon"></i>Nový katalóg z webu</div>
		<div class="catalogue_upload_btn ui teal button"><i class="laptop icon"></i>Nový katalóg z PC</div>
		<div class="catalogue_ok_btn ui green button"><i class="checkmark icon"></i>OK</div>

		<form action="/file" class="hiden dropzone" id="catalogue_dropzone"> 
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                 <div class="dz-message">Klikni pre nahranie súborov</div>
        </form>

	</div>
</div>

@stop