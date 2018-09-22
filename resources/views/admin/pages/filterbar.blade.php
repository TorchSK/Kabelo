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

 		</div>
 		<div id="page_preview">
 			<div id="p_filterbar">
 				@include('includes/filterbar_horizontal')
 			</div>
		</div>		
 	</div>
</div>
    
@stop