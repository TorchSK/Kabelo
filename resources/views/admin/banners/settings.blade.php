@extends('layouts.admin')
@section('content')


<div id="admin_settings_banner" class="admin_wrapper">

	<div class="short">
		<form method="POST" action="/admin/banners/settings/save">
	        {{ csrf_field() }}

			<div id="admin_banners_settings_div">
			
			<div class="ui header">Nastavenia bannerov</div>

			<div class="item setting">
				<div class="label">Zobrazenie coverov</div>
				<div class="ui toggle checkbox">
				  <input type="checkbox" name="covers_visible" @if (App\Setting::firstOrCreate(['name'=>'covers_visible'],['value'=>1])->value == 1) checked @endif>
				</div>	
			</div>

			<div class="item setting">
				<div class="label">Zobrazenie bannerov</div>
				<div class="ui toggle checkbox">
				  <input type="checkbox" name="banners_visible" @if (App\Setting::firstOrCreate(['name'=>'banners_visible'],['value'=>1])->value == 1) checked @endif>
				</div>	
			</div>

			<div class="item setting">
				<div class="label">Výška coveru</div>
				<div class="ui right labeled input">
				  <input type="text" name="cover_height" value="{{App\Setting::firstOrCreate(['name'=>'cover_height'],['value'=>500])->value}}">
				  <div class="ui dropdown label">px</div>
				</div>	

			</div>
				<div id="cover_height_slider"></div>

			<div class="item setting">
				<div class="label">Výška banneru</div>
				<div class="ui right labeled input">
				  <input type="text" name="banner_height" value="{{App\Setting::firstOrCreate(['name'=>'icdph'])->value}}">
				  <div class="ui dropdown label">px</div>
				</div>	
			</div>


			</div>

			<button type="submit" class="ui green button settings_save">Ulož</button>

		</form>

	</div>


<div class="banner_preview"></div>

</div>

@stop

