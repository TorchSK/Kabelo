@extends('layouts.admin')
@section('content')

<div id="page_settings_wrapper" class="wrapper">
	<div class="flex_row">
		<div id="page_settings">	
			<div class="item">
				<div class="ui checkbox admin_page_settings" id="admin_filterbar_image_chekcbox">
				  <input type="checkbox" data-item="filterbar_image" data-target="filterbar" data-view="includes.filterbar_horizontal" @if(App\Setting::firstOrCreate(['name'=>'filterbar_image'])->value == 1) checked @endif>
				  <label>Zobrazovať obrázok</label>
				</div>
			</div>
			<div class="item">
				<input class="admin_page_color_chooser" data-default="#F3F3F3" data-item="filterbar_wrapper" data-property="background-color" data-target="filterbar"> Farba pozadia
			</div>

			<div class="item">	
				<input class="admin_page_color_chooser" data-default="#FFF" data-item="filterbar_container" data-property="background-color" data-target="filterbar"> Farba lišty
			</div>

 		</div>
 		<div id="page_preview">
 			<div id="p_filterbar">
 				@include('includes/filterbar_horizontal')
 			</div>
		</div>		
 	</div>
</div>
    
@stop