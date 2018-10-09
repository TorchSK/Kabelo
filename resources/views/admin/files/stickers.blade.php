@extends('layouts.admin')
@section('content')

 <div id="admin_stickers_wrapper" class="admin_wrapper">
		<ul id="stickers_list">
			@foreach($stickers as $sticker)
				<li class="item" data-id="{{$sticker->id}}" data-type="stickers" data-active="{{$sticker->active}}">
					<div class="image"><img src="{{url($sticker->path)}}" /></div>

					<div class="name"><b>{{$sticker->path}}</b></div>
					<div class="stretch"></div>
					<div class="actions">
						<a href="{{route('admin.files.stickerEdit', ['id' => $sticker->id])}}" class="ui mini green icon button"><i class="search icon"></i></a>
						<div class="ui mini red icon button sticker_delete_btn"><i class="delete icon"></i></div>
					</div>
				</li>
			@endforeach
		</ul>

		<div class="ui fluid labeled input" id="sticker_url_input">
		   <div class="ui label">URL</div>
		   <input type="text" name="name" />
		</div>

		<div class="sticker_path_btn ui blue button"><i class="globe icon"></i>Nový sticker z webu</div>
		<div class="sticker_upload_btn ui teal button"><i class="laptop icon"></i>Nový sticker z PC</div>
		<div class="sticker_ok_btn ui green button"><i class="checkmark icon"></i>OK</div>

		<form action="/sticker" class="hiden dropzone" id="sticker_dropzone"> 
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                 <div class="dz-message">Klikni pre nahranie súborov</div>
        </form>

</div>

@stop
