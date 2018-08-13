@extends('layouts.admin')
@section('content')



<div class="admin_settings">

	<div class="tabs">

	    <a href="/admin/settings/banners" class="tabb ui basic button">Bannery</a>
	    <a href="/admin/settings/eshop" class="tabb ui blue button">Eshop</a>
	   	<a href="/admin/settings/delivery" class="tabb ui basic button">Preprava</a>
	    <a href="/admin/settings/invoice" class="tabb ui basic button">Faktura</a>

	</div>



<div class="short">

<form method="POST" action="/admin/settings/eshop/save">

	<div class="ui horizontal divider">Parametre objednávky</div>

        {{ csrf_field() }}

		<div id="admin_order_params_list">


		<div class="item">
			<div>Minimálna objednávka</div>
			<div class="ui right labeled input">
			  <input type="text" name="min_order_price" value="{{App\Setting::where('name','min_order_price')->first()->value}}">
			    <div class="ui basic label">&euro;</div>
			</div>	
		</div>

		<div class="item">
			<div>Minimálna cena pre dopravu zdarma</div>
			<div class="ui right labeled input">
			  <input type="text" name="min_free_shipping_price" value="{{App\Setting::where('name','min_free_shipping_price')->first()->value}}">
			  <div class="ui basic label">&euro;</div>
			</div>
		</div>
		</div>

		<div class="ui horizontal divider">Parametre eshopu</div>

		<div id="admin_eshop_params_list">


		<div class="item">
			<div>Počet produktov na stránku</div>
			<div class="ui input">
			  <input type="text" name="ppp" value="{{App\Setting::where('name','ppp')->first()->value}}">
			</div>	
		</div>

		</div>	

	<button type="submit" class="ui green button settings_save">Ulož</button>

	</form>


</div>
</div>

@stop

