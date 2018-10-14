@extends('layouts.admin')
@section('content')



<div id="admin_settings_site" class="admin_wrapper">



<div class="short">
	<form method="POST" action="/admin/settings/invoice/save">
        {{ csrf_field() }}

		<div class="ui header">Nastavenia webu</div>

		<div class="item setting">
			<div class="label">Title</div>
			<div class="ui input">
			  <input type="text" name="home_title" value="{{App\Setting::firstOrCreate(['name'=>'home_title'])->value}}">
			</div>	
		</div>

		<button type="submit" class="ui green button settings_save">Ulož</button>

	</form>

</div>


</div>

@stop

