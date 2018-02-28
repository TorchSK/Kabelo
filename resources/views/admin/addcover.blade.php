@extends('layouts.admin')
@section('content')

	<div class="admin_add_cover">
		<div class="cover_image"></div>

		<form action="/admin/cover/upload" class="dropzone" id="cover_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>
		
		<div class="admin_add_cover_under">

			<div class="crop_preview"></div>

			<div class="inputs">
				<div class="ui fluid input">
				  <input type="text" placeholder="Nadpis" id="admin_add_cover_h1">
				</div>

				<div class="ui fluid input">
				  <input type="text" placeholder="Text" id="admin_add_cover_h2">
				</div>

			<div class="ui green button">Ulož</div>


			</div>

		</div>

	</div>

@stop