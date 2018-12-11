@extends('layouts.admin')
@section('content')

	<div class="admin_add_cover">
		

		<div class="ui form" id="add_banner_radioboxes">
		  <div class="inline fields">
		    <label>Vyberte typ odkazu</label>
		    <div class="field">
		      <div class="ui radio checkbox">
		        <input type="radio" name="frequency">
		        <label>Kategória</label>
		      </div>
		    </div>
		    <div class="field">
		      <div class="ui radio checkbox">
		        <input type="radio" name="frequency">
		        <label>Produkt</label>
		      </div>
		    </div>
		    <div class="field">
		      <div class="ui radio checkbox">
		        <input type="radio" name="frequency">
		        <label>Vlastný</label>
		      </div>
		    </div>
		  </div>
		</div>


		<div class="ui search" id="cover_category_url">
			<input type="text" class="prompt" @if(isset($cover)) value="{{$cover->url}}" @endif placeholder="URL pre odkaz na kategóriu" />
			 <div class="results"></div>
		</div>

		<div class="ui hiden search" id="cover_product_url">
			<input type="text" class="prompt" @if(isset($cover)) value="{{$cover->url}}" @endif placeholder="URL pre odkaz na produkt" />
			 <div class="results"></div>
		</div>

		<div class="ui hiden search" id="cover_other_url">
			<input type="text" class="prompt" @if(isset($cover)) value="{{$cover->url}}" @endif placeholder="URL pre odkaz" />
			 <div class="results"></div>
		</div>


		@if (isset($cover))
		<form action="/admin/cover/upload" class="dropzone hidden" id="cover_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>

		 <div class="cover_image">
		 @include('home.banner', ['type'=>Request::get('type')])
		</div>
		@else
		<div class="cover_image hidden">
			<div class="editable cover"></div>
		</div>

		<form action="/admin/cover/upload" class="dropzone" id="cover_dropzone"> 
			<input name="_token" hidden value="{!! csrf_token() !!}" />
			 <div class="dz-message">Klikni pre nahranie obrázkov/súborov</div>
		</form>
		@endif
		
		<div class="admin_add_cover_under">

			<div class="ui blue button @if(!isset($cover)) hidden @endif" id="admin_add_cover_change_image_btn">Zmeň obrázok</div>

			<div class="crop_preview"></div>

			<div class="inputs">

				<div class="h1_input">
					<div class="ui big input">
					  <input type="text" @if(isset($cover)) value="{{$cover->h1_text}}" @else value="Nadpis" @endif id="admin_add_cover_h1">
					</div>

					<input type="text" class="admin_add_cover_h1_color_btn" value="000">

					<div id="admin_add_cover_h1_size_slider"></div>
				</div>
		


				<div class="h2_input">
					<div class="ui big input">
					  <input type="text" @if(isset($cover)) value="{{$cover->h2_text}}" @else value="Text ktory sa zobrazi pod nadpisom" @endif id="admin_add_cover_h2">
					</div>

					<input type="text" class="admin_add_cover_h2_color_btn" value="000">

					<div id="admin_add_cover_h2_size_slider"></div>

				</div>
			
	


			<form @if (isset($cover)) action="{{route('banner.update',['cover'=>$cover->id])}}" method="POST" @else action="{{route('banner.store')}}" method="POST" @endif id="admin_add_cover_form">
			
			@if (isset($cover))
			<input type="hidden" name="_method" value="PUT" />
			@endif

			<input type="hidden" name="filename" value="" />

			<input type="hidden" name="x" value="" />
			<input type="hidden" name="y" value="" />
			<input type="hidden" name="w" value="" />
			<input type="hidden" name="h" value="" />
			<input type="hidden" name="url" value="" />

			<input type="hidden" name="type" value="{{Request::get('type')}}" />

			<input type="hidden" name="left" @if(isset($cover)) value="{{$cover->left}}" @else value="10" @endif />
			<input type="hidden" name="top"  @if(isset($cover)) value="{{$cover->top}}" @else value="30" @endif />
			<input type="hidden" name="h1_font"  @if(isset($cover)) value="{{$cover->h1_font}}" @else value="inherit" @endif />
			<input type="hidden" name="h2_font"  @if(isset($cover)) value="{{$cover->h2_font}}" @else value="inherit" @endif />
			<input type="hidden" name="h1_size"  @if(isset($cover)) value="{{$cover->h1_size}}" @else value="4" @endif />
			<input type="hidden" name="h2_size"  @if(isset($cover)) value="{{$cover->h2_size}}" @else value="1.5" @endif />
			<input type="hidden" name="h1_color"  @if(isset($cover)) value="{{$cover->h1_color}}" @else value="000" @endif />
			<input type="hidden" name="h2_color"  @if(isset($cover)) value="{{$cover->h2_color}}" @else value="000" @endif />
			<input type="hidden" name="width"  @if(isset($cover)) value="{{$cover->width}}" @else value="40" @endif />

			<input type="hidden" name="h1_text" @if(isset($cover)) value="{{$cover->h1_text}}" @else value="Nadpis" @endif  />
			<input type="hidden" name="h2_text" @if(isset($cover)) value="{{$cover->h2_text}}" @else value="Text ktory sa zobrazi pod nadpisom" @endif />

			<input name="_token" hidden value="{!! csrf_token() !!}" />
			<button type="submit" class="ui green button">@if (isset($cover)) Zmeň @else Vytvor @endif {{Request::get('type')}}</button>

			</form>

			</div>

		</div>

	</div>

@stop