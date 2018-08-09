@extends('layouts.admin')
@section('content')



<div class="admin_settings">

	<div class="tabs">

	    <a href="/admin/settings/banners" class="tabb ui basic button">Bannery</a>
	    <a href="/admin/settings/eshop" class="tabb ui blue button">Eshop</a>
	    <a href="/admin/settings/invoice" class="tabb ui basic button">Faktura</a>

	</div>



<div class="short">

	<div id="admin_invoice_params_list">
	<div class="ct">
		<div class="ui green button" id="admin_eshop_params_save">Ulož zmeny</div>
	</div>

	<div class="item">
		<div>Počet produktov na stránku</div>
		<div class="ui input">
		  <input type="text" name="ppp" value="{{config('app.ppp')}}">
		</div>	
	</div>

	</div>

</div>
</div>

@stop

