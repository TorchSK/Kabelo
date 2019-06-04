@extends('layouts.admin')
@section('content')
	
<div class="admin_wrapper" id="admin_settings">

		<div id="files_list">
			@foreach($catalogues as $index => $catalogue)
				<div class="catalogue" data-id="{{$catalogue->id}}">
					<div class="img">
						@if($catalogue->thumbnail)
						<img src="{{url($catalogue->thumbnail->path)}}" />
						@else
						<i class="huge file outline icon"></i>
					@endif
					</div>
					<div class="ui action input">
						<input value="{{$catalogue->path}}" />  
						<button class="ui icon button" data-tooltip="Kopíruj cestu"><i class="copy icon copy_to_clipboard_btn"></i></button>
						<button class="ui icon green button" data-tooltip="Ulož cestu"><i class="checkmark icon catalogue_save_btn"></i></button>

					</div>
					
					<form action="/catalogue/changeImage" class="hiden dropzone" id="catalogue_image_dropzone_{{$index}}"> 
							<input type="hidden" name="catalogue_id" value="{{$catalogue->id}}" />
			                 <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
			                 <div class="dz-message">Klikni pre nahranie súborov</div>
			        </form>

					<div class="ui icon orange button catalogue_image_btn" data-id="{{$catalogue->id}}"  data-tooltip="Nahraj obrázok katalógu"><i class="image icon"></i></div>
					<div class="ui icon red button catalogue_delete_btn"  data-tooltip="Zmazať katalóg"><i class="delete icon"></i></div>
					<div class="ui icon blue button @if($catalogue->primary) primary @endif catalogue_primary_btn"  data-tooltip="Nastaviť ako primárny"><i class="star icon"></i></div>

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

@stop