@extends('layouts.admin')
@section('content')

	<div class="admin_add_cover">
		<div class="cover_image"></div>

		<form action="/admin/cover/upload" class="dropzone" id="cover_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>
		
		<div class="admin_add_cover_under">

			<div class="crop_preview"></div>

			<div class="inputs">

				<div class="h1_input">
					<div class="ui big input">
					  <input type="text" placeholder="Nadpis" id="admin_add_cover_h1">
					</div>

					<input type="text" class="admin_add_cover_h1_color_btn" value="000">

					<div id="admin_add_cover_h1_size_slider"></div>
				</div>
		


				<div class="h2_input">
					<div class="ui big input">
					  <input type="text" placeholder="Popis" id="admin_add_cover_h2">
					</div>

					<input type="text" class="admin_add_cover_h2_color_btn" value="000">

					<div id="admin_add_cover_h2_size_slider"></div>

				</div>
		


			<form action="/admin/banner" method="POST" id="admin_add_cover_form">
			<input type="hidden" name="x" value="" />
			<input type="hidden" name="y" value="" />
			<input type="hidden" name="w" value="" />
			<input type="hidden" name="h" value="" />

			<input type="hidden" name="left" value="10" />
			<input type="hidden" name="top" value="30" />
			<input type="hidden" name="h1_font"/>
			<input type="hidden" name="h2_font"/>
			<input type="hidden" name="h1_size" value="5" />
			<input type="hidden" name="h2_size" value="4" />
			<input type="hidden" name="h1_color"/>
			<input type="hidden" name="h2_color"/>
			<input type="hidden" name="width"/>
			<input name="_token" hidden value="{!! csrf_token() !!}" />
			<button type="submit" class="ui green button">Ulož</button>

			</form>

			</div>

		</div>

	</div>

@stop