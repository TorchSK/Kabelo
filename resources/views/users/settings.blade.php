@extends('layouts.master')
@section('content')



<div id="settings_user" class="wrapper" data-userid="{{Auth::user()->id}}">

	<div class="settings_account_div container" id="right">

	<div class="ui header">Základné údaje</div>

		<div class="labeled form">

			<div class="labels">
       			<div class="item">Email *</div>
       			<div class="item">Telefón *</div>
       			<div class="item">Meno *</div>
       			<div class="item">Priezvisko *</div>

			</div>

			<div class="inputs">
		      	<div class="ui large disabled input">
		            <input type="text" name="email" value="{{Auth::user()->email}}" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="phone" value="{{Auth::user()->phone}}" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input name="first_name" type="text"  value="{{Auth::user()->first_name}}"/>
		      	</div><br/>
		      	<div class="ui large input">
		            <input name="last_name" type="text"  value="{{Auth::user()->last_name}}"/>
		      	</div>

       		 </div>

		</div>

			<div class="ui header">Firemné údaje</div>

		<div class="labeled form">

			<div class="labels">
				<div class="item">Firma</div>
       			<div class="item">IČO</div>
       			<div class="item">DIČ</div>
       			<div class="item">IČ DPH</div>

			</div>

			<div class="inputs">
				<div class="ui large input">
		            <input type="text" name="invoice_address_company" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->company)){{json_decode(Auth::user()->invoiceAddress->address)->company}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="invoice_address_ico" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->ico)){{json_decode(Auth::user()->invoiceAddress->address)->ico}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text"  name="invoice_address_dic" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->dic)){{json_decode(Auth::user()->invoiceAddress->address)->dic}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text"  name="invoice_address_icdph" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->icdph)){{json_decode(Auth::user()->invoiceAddress->address)->icdph}}@endif" />
		      	</div><br/>

       		 </div>

		</div>

	<div class="ui header">Fakturačná adresa</div>

	<div class="labeled form">

			<div class="labels">
       			<div class="item">Ulica *</div>
       			<div class="item">Mesto *</div>
       			<div class="item">PSČ *</div>
			</div>

			<div class="inputs">
			
		      
		      	<div class="ui large input">
		            <input type="text" name="invoice_address_street" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->street)){{json_decode(Auth::user()->invoiceAddress->address)->street}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text"  name="invoice_address_city" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->city)){{json_decode(Auth::user()->invoiceAddress->address)->city}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text"  name="invoice_address_zip" value="@if(Auth::user()->invoiceAddress && isset(json_decode(Auth::user()->invoiceAddress->address)->zip)){{json_decode(Auth::user()->invoiceAddress->address)->zip}}@endif" />
		      	</div><br/>
	

        </div>

	</div>

	<div class="ui header">Doručovacia adresa</div>

		<div class="labeled form">

			<div class="labels">
				<div class="item">Meno a priezvisko *</div>
       			<div class="item">Ulica *</div>
       			<div class="item">Mesto *</div>
       			<div class="item">PSČ *</div>
       			<div class="item">Doplňujúce údaje</div>
       			<div class="item">Telefón *</div>
			</div>
			<div class="inputs delivery_address">
			
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_name" value="@if(Auth::user()->deliveryAddresses->count() > 0 && isset(json_decode(Auth::user()->deliveryAddresses->first()->address)->name)){{json_decode(Auth::user()->deliveryAddresses->first()->address)->name}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_street" value="@if(Auth::user()->deliveryAddresses->count() > 0 && isset(json_decode(Auth::user()->deliveryAddresses->first()->address)->street)){{json_decode(Auth::user()->deliveryAddresses->first()->address)->street}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_city" value="@if(Auth::user()->deliveryAddresses->count() > 0 && isset(json_decode(Auth::user()->deliveryAddresses->first()->address)->city)){{json_decode(Auth::user()->deliveryAddresses->first()->address)->city}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_zip" value="@if(Auth::user()->deliveryAddresses->count() > 0 && isset(json_decode(Auth::user()->deliveryAddresses->first()->address)->zip)){{json_decode(Auth::user()->deliveryAddresses->first()->address)->zip}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_additional" value="@if(Auth::user()->deliveryAddresses->count() > 0 && isset(json_decode(Auth::user()->deliveryAddresses->first()->address)->additional)){{json_decode(Auth::user()->deliveryAddresses->first()->address)->additional}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_phone" value="@if(Auth::user()->deliveryAddresses->count() > 0 && isset(json_decode(Auth::user()->deliveryAddresses->first()->address)->phone)){{json_decode(Auth::user()->deliveryAddresses->first()->address)->phone}}@endif" />
		      	</div><br/>


        </div>

	</div>

	<div class="ui green button" id="settings_submit_btn" data-redirect="/seettings/account">Uložiť zmeny</div>

</div>



</div>

@stop