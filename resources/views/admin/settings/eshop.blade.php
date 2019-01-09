@extends('layouts.admin')
@section('content')



<div id="admin_settings_eshop" class="admin_wrapper">


<div class="short">

<form method="POST" action="/admin/settings/save">

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
			  <input type="text" name="ppp" value="{{App\Setting::firstOrCreate(['name'=>'ppp'],['value'=> 28])->value}}">
			</div>	
		</div><br />

		<div class="item">
			<div>Výška DPH</div>
			<div class="ui right labeled input">
			  <input type="text" name="vat" value="{{App\Setting::firstOrCreate(['name'=>'vat'],['value'=> 20])->value}}">
			    <div class="ui basic label">%</div>
			</div>	
		</div>

		<div class="item">
			<div>Email pre kopiu objednavky</div>
			<div class="ui input">
			  <input type="text" name="order_email_1" value="{{App\Setting::firstOrCreate(['name'=>'order_email_1'])->value}}">
			</div>	
		</div>

		</div>	

	<button type="submit" class="ui green button settings_save">Ulož</button>

	</form>


</div>
</div>

@stop

