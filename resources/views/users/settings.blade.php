@extends('layouts.master')
@section('content')

<div class="flex_content" id="settings_user" data-userid="{{Auth::user()->id}}">

<div id="left" class="ct">
		<div class="avatar">
			@if (Auth::user()->avatar)
				<img src="/img/{{Auth::user()->avatar}}" />
			@else
				<i class="user huge icon"></i>
			@endif
		</div>

		<div class="name">
			@if (Auth::user()->first_name)
				{{Auth::user()->first_name}} {{Auth::user()->last_name}}
			@else
				{{Auth::user()->email}}
			@endif
		</div>

		<div class="links">
			<div class="item">
				<div class="ui teal fluid button"><i class="user icon"></i> Účet</div>
			</div>
			
			<div class="item">
				<div class="ui brown fluid button"><i class="archive icon"></i> Fakturačné údaje</div>
			</div>
			<div class="item">
				<div class="ui brown fluid button"><i class="shipping icon"></i> Doručovacie adresy</div>
			</div>
		</div>
</div>

<div class="wrapper" id="right">

	<div class="settings_account_div">
	<div class="ui header">Základné údáje</div>

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

	<div class="ui header">Fakturačná adresa</div>

	<div class="labeled form">

			<div class="labels">
       			<div class="item">Ulica *</div>
       			<div class="item">Mesto *</div>
       			<div class="item">PSČ *</div>
			</div>

			<div class="inputs">
			
		      
		      	<div class="ui large input">
		            <input type="text" name="invoice_address_street" value="@if(Auth::user()->invoiceAddress){{json_decode(Auth::user()->invoiceAddress->address, true)['street']}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text"  name="invoice_address_city" value="@if(Auth::user()->invoiceAddress){{json_decode(Auth::user()->invoiceAddress->address, true)['city']}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text"  name="invoice_address_zip" value="@if(Auth::user()->invoiceAddress){{json_decode(Auth::user()->invoiceAddress->address, true)['zip']}}@endif" />
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
		            <input type="text" name="delivery_address_name" value="@if(Auth::user()->deliveryAddress){{Auth::user()->deliveryAddress->name}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_street" value="@if(Auth::user()->deliveryAddress){{Auth::user()->deliveryAddress->street}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_city" value="@if(Auth::user()->deliveryAddress){{Auth::user()->deliveryAddress->city}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_zip" value="@if(Auth::user()->deliveryAddress){{Auth::user()->deliveryAddress->zip}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_additional" value="@if(Auth::user()->deliveryAddress){{Auth::user()->deliveryAddress->additional}}@endif" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" name="delivery_address_phone" value="@if(Auth::user()->deliveryAddress){{Auth::user()->deliveryAddress->phone}}@endif" />
		      	</div><br/>


        </div>

	</div>

		<div class="ui green button" id="settings_submit_btn">Uložiť zmeny</div>

</div>



</div>
</div>
@stop