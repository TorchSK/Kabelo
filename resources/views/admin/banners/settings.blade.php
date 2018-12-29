@extends('layouts.admin')
@section('content')


<div id="admin_settings_banner" class="admin_wrapper">

	<div class="short">
		<form method="POST" action="{{route('settings.bulkUpdate')}}">
	        {{ csrf_field() }}

			<div id="admin_banners_settings_div">
			
				<div class="ui header">Nastavenia bannerov</div>

				<div class="item setting">
					<div class="label">Zobrazenie coverov</div>
					<div class="ui toggle checkbox">
					  <input type='hidden' value="off" name='covers_visible'>
					  <input type="checkbox" name="covers_visible" @if (App\Setting::firstOrCreate(['name'=>'covers_visible'],['value'=>1])->value == 1) checked @endif>
					</div>	
				</div>

				<div class="item setting">
					<div class="label">Zobrazenie bannerov</div>
					<div class="ui toggle checkbox" id="banners_visible_checkbox">
					  <input type='hidden' value="off" name='banners_visible'>
					  <input type="checkbox" name="banners_visible" @if (App\Setting::firstOrCreate(['name'=>'banners_visible'],['value'=>1])->value == 1) checked @endif>
					</div>	
				</div>

				<div class="item setting">
					<div class="label">Výška coveru</div>
					<div class="ui right labeled input">
					  <input type="text" name="cover_height" value="{{App\Setting::firstOrCreate(['name'=>'cover_height'],['value'=>500])->value}}">
					  <div class="ui dropdown label">px</div>
					</div>	
					<div id="cover_height_slider"></div>

				</div>

				<div class="item setting" id="cover_width_setting">
					<div class="label">Šírka coveru</div>
					<div class="ui right labeled input">
					  <input type="text" name="cover_width" value="{{App\Setting::firstOrCreate(['name'=>'cover_width'],['value'=>75])->value}}">
					  <div class="ui dropdown label">%</div>
					</div>	
					<div id="cover_width_slider"></div>

				</div>

				<div class="item setting" id="cover_dimensions_settings">
					<div class="label">Rozmery coveru</div>
					<div class="ui right labeled input">
						<width>{{14*App\Setting::firstOrCreate(['name'=>'cover_width'])->value}}</width>&nbsp;x&nbsp;<height>{{App\Setting::firstOrCreate(['name'=>'cover_height'])->value}}</height>&nbsp;(<ratio>{{round(14*App\Setting::firstOrCreate(['name'=>'cover_width'])->value / App\Setting::firstOrCreate(['name'=>'cover_height'])->value,2)}}</ratio>)
					</div>	
				</div>

				<div class="item setting" id="banner_dimensions_settings">
					<div class="label">Rozmery banneru</div>
					<div class="ui right labeled input">
						<width>{{14*(100-App\Setting::firstOrCreate(['name'=>'cover_width'])->value) - 35 }}</width>&nbsp;x&nbsp;<height>{{(App\Setting::firstOrCreate(['name'=>'cover_height'])->value -35) / 2}}</height>
						&nbsp;
						(
						<ratio>
						
							{{round((14*(100-App\Setting::firstOrCreate(['name'=>'cover_width'])->value) - 35) / ((App\Setting::firstOrCreate(['name'=>'cover_height'])->value -35) / 2),2)}}
						</ratio>
						)
					</div>	
				</div>


			</div>

				<input type="hidden" name="cover_ratio" value="{{App\Setting::firstOrCreate(['name'=>'cover_ratio'],['value'=>2.8])->value}}">
				<input type="hidden" name="banner_ratio" value="{{App\Setting::firstOrCreate(['name'=>'cover_ratio'],['value'=>1.8])->value}}">

			<button type="submit" class="ui green button settings_save">Ulož</button>

		</form>

	</div>


<div class="banner_preview">
	<div class="cover" style="height: {{App\Setting::firstOrCreate(['name'=>'cover_height'])->value}}px;  @if (App\Setting::firstOrCreate(['name'=>'banners_visible'],['value'=>1])->value == 1) width: {{App\Setting::firstOrCreate(['name'=>'cover_width'])->value}}% @else width: 100% @endif;"></div>
	<div class="banners" style="width: {{100-App\Setting::firstOrCreate(['name'=>'cover_width'])->value}}%; height: {{App\Setting::firstOrCreate(['name'=>'cover_height'])->value}}px;  @if (App\Setting::firstOrCreate(['name'=>'banners_visible'],['value'=>1])->value == 0) display: none; @endif">
		<div class="banner"></div>
		<div class="banner"></div>
	</div>

	</div>
</div>

@stop

