@extends('layouts.master')
@section('content')

<div class="content" id="settings_user">

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

	<div class="settings_action ct">
		<div class="ui green button">Uložiť zmeny</div>
	</div>


	<div class="settings_account_div">
	<div class="ui header">Základné údáje</div>

		<div class="labeled form">

			<div class="labels">
       			<div class="item">Email *</div>
       			<div class="item">Meno *</div>
       			<div class="item">Priezvisko *</div>

			</div>

			<div class="inputs">
		      	<div class="ui large input">
		            <input type="text" value="{{Auth::user()->email}}" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div>

        </div>

	</div>

	<div class="ui header">Fakturačná adresa</div>

	<div class="labeled form">

			<div class="labels">
       			<div class="item">Ulica *</div>
       			<div class="item">Číslo *</div>
       			<div class="item">Mesto *</div>
       			<div class="item">PSČ *</div>
       			<div class="item">Telefón *</div>
       			<div class="item">Email *</div>
			</div>

			<div class="inputs">
			
		      
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div>

        </div>

	</div>

	<div class="ui header">Doručovacia adresa</div>

		<div class="labeled form">

			<div class="labels">
       			<div class="item">Ulica *</div>
       			<div class="item">Číslo *</div>
       			<div class="item">Mesto *</div>
       			<div class="item">PSČ *</div>
       			<div class="item">Telefón *</div>
       			<div class="item">Email *</div>
			</div>

			<div class="inputs">
			
		      
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div><br/>
		      	<div class="ui large input">
		            <input type="text" />
		      	</div>

        </div>

	</div>
</div>

</div>

@stop