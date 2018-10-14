@extends('layouts.admin')
@section('content')



<div id="admin_settings_invoice" class="admin_wrapper">



<div class="short">
	<form method="POST" action="/admin/settings/invoice/save">
        {{ csrf_field() }}

	<div id="admin_invoice_settings_div">
	<div class="ui header">Všeobecné údaje</div>

	<div class="item setting">
		<div class="label">Názov spoločnosti (na faktúre)</div>
		<div class="ui input">
		  <input type="text" name="company_name" value="{{App\Setting::firstOrCreate(['name'=>'company_name'])->value}}">
		</div>	
	</div>

	<div class="ui header">Kontaktná adresa</div>


		<div class="item setting">
		<div class="label">Ulica</div>
		<div class="ui input">
		  <input type="text" name="contact_street" value="{{App\Setting::firstOrCreate(['name'=>'contact_street'])->value}}">
		</div>	
	</div>

		<div class="item setting">
		<div class="label">Mesto</div>
		<div class="ui input">
		  <input type="text" name="contact_city" value="{{App\Setting::firstOrCreate(['name'=>'contact_city'])->value}}">
		</div>	
	</div>

		<div class="item setting">
		<div class="label">PSČ</div>
		<div class="ui input">
		  <input type="text" name="contact_zip" value="{{App\Setting::firstOrCreate(['name'=>'contact_zip'])->value}}">
		</div>	
	</div>

		<div class="item setting">
		<div class="label">Štát</div>
		<div class="ui input">
		  <input type="text" name="contact_state" value="{{App\Setting::firstOrCreate(['name'=>'contact_state'])->value}}">
		</div>	
	</div>

	<div class="ui header">Fakturačné údaje</div>

	<div class="item setting">
		<div class="label">IČO</div>
		<div class="ui input">
		  <input type="text" name="ico" value="{{App\Setting::firstOrCreate(['name'=>'ico'])->value}}">
		</div>	
	</div>

	<div class="item setting">
		<div class="label">DIČ</div>
		<div class="ui input">
		  <input type="text" name="dic" value="{{App\Setting::firstOrCreate(['name'=>'dic'])->value}}">
		</div>	
	</div>

	<div class="item setting">
		<div class="label">IČ DPH</div>
		<div class="ui input">
		  <input type="text" name="icdph" value="{{App\Setting::firstOrCreate(['name'=>'icdph'])->value}}">
		</div>	
	</div>

	<div class="item setting">
		<div class="label">Ďaľšie údaje</div>
		<div class="ui input">
		  <input type="text" name="invoice_additional_1" value="{{App\Setting::firstOrCreate(['name'=>'invoice_additional_1'])->value}}">
		</div>	
	</div>

	<div class="ui header">Fakturačná adresa</div>

		<div class="item setting">
		<div class="label">Ulica</div>
		<div class="ui input">
		  <input type="text" name="street" value="{{App\Setting::firstOrCreate(['name'=>'street'])->value}}">
		</div>	
	</div>

		<div class="item setting">
		<div class="label">Mesto</div>
		<div class="ui input">
		  <input type="text" name="city" value="{{App\Setting::firstOrCreate(['name'=>'city'])->value}}">
		</div>	
	</div>

		<div class="item setting">
		<div class="label">PSČ</div>
		<div class="ui input">
		  <input type="text" name="zip" value="{{App\Setting::firstOrCreate(['name'=>'zip'])->value}}">
		</div>	
	</div>

		<div class="item setting">
		<div class="label">Štát</div>
		<div class="ui input">
		  <input type="text" name="state" value="{{App\Setting::firstOrCreate(['name'=>'state'])->value}}">
		</div>	
	</div>

	<div class="ui header">Emaily</div>


		<div class="item setting">
		<div class="label">Email 1</div>
		<div class="ui input">
		  <input type="text" name="email1" value="{{App\Setting::firstOrCreate(['name'=>'email1'])->value}}">
		</div>	
		</div>
	
		<div class="item setting">
			<div class="label">Email 2</div>
			<div class="ui input">
			  <input type="text" name="email2" value="{{App\Setting::firstOrCreate(['name'=>'email2'])->value}}">
			</div>	
		</div>
		
		<div class="item setting">
		<div class="label">Email 3</div>
		<div class="ui input">
		  <input type="text" name="email3" value="{{App\Setting::firstOrCreate(['name'=>'email13'])->value}}">
		</div>	
		</div>

		<div class="ui header">Telefóny</div>
	
		<div class="item setting">
			<div class="label">Telefón 1</div>
			<div class="ui input">
			  <input type="text" name="phone1" value="{{App\Setting::firstOrCreate(['name'=>'phone1'])->value}}">
			</div>	
		</div>

		<div class="item setting">
			<div class="label">Telefón 2</div>
			<div class="ui input">
			  <input type="text" name="phone2" value="{{App\Setting::firstOrCreate(['name'=>'phone2'])->value}}">
			</div>	
		</div>


		<div class="item setting">
			<div class="label">Fax</div>
			<div class="ui input">
			  <input type="text" name="fax" value="{{App\Setting::firstOrCreate(['name'=>'fax'])->value}}">
			</div>	
		</div>

	</div>

	<button type="submit" class="ui green button settings_save">Ulož</button>

	</form>

</div>


</div>

@stop

