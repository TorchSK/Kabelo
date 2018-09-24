@extends('layouts.master')
@section('content')

<div id="contact_wrapper" class="wrapper">
	<div class="container">

<div class="ui hiden" id="address_map">{{App\Setting::firstOrCreate(['name'=>'street'])->value}}, {{App\Setting::firstOrCreate(['name'=>'zip'])->value}},{{App\Setting::firstOrCreate(['name'=>'city'])->value}}, {{App\Setting::firstOrCreate(['name'=>'state'])->value}}</div>

<div class="flex_row">
<div id="contact_left">

<div id="address" class="box">
	<div>
		<i class="home huge teal icon"></i>
	</div>
	<div>W
		<div>{{App\Setting::firstOrCreate(['name'=>'company_name'])->value}}</div>
		<div>{{App\Setting::firstOrCreate(['name'=>'street'])->value}}</div>
		<div>{{App\Setting::firstOrCreate(['name'=>'zip'])->value}} {{App\Setting::firstOrCreate(['name'=>'city'])->value}}</div>
		<div>{{App\Setting::firstOrCreate(['name'=>'state'])->value}}</div>
		<div>{{App\Setting::firstOrCreate(['name'=>'text1'])->value}}</div>

	</div>
</div>

<div id="legal" class="box">
	<div>
		<i class="legal huge teal icon"></i>
	</div>
	<div>
		<div><b>IČO:</b> {{App\Setting::firstOrCreate(['name'=>'ico'])->value}}</div>
		<div><b>IČ DPH:</b> {{App\Setting::firstOrCreate(['name'=>'icdph'])->value}}</div>
		<br/>
		<div>{{App\Setting::firstOrCreate(['name'=>'invoice_additional_1'])->value}}</div>
	</div>
</div>

<div id="phones" class="box">
	<div>
		<i class="phone huge teal icon"></i>
	</div>
	<div>
		<div><b>Tel:</b> {{App\Setting::firstOrCreate(['name'=>'phone1'])->value}}</div>
		<div><b>Fax:</b>  {{App\Setting::firstOrCreate(['name'=>'fax'])->value}}</div>
		<div><b>Mobil</b>  {{App\Setting::firstOrCreate(['name'=>'phone2'])->value}}</div>
	</div>
</div>

<div id="emails" class="box">
	<div>
		<i class="at huge teal icon"></i>
	</div>
	<div>
		 <div><a href="mailto:{{App\Setting::firstOrCreate(['name'=>'email1'])->value}}">{{App\Setting::firstOrCreate(['name'=>'email1'])->value}}</a></div>
		 <div>{{App\Setting::firstOrCreate(['name'=>'email2'])->value}}</div>
	</div>
</div>

@if($appname=='kabelo')
<div id="hours" class="box">
	<div>
		<i class="clock huge teal icon"></i>
	</div>
	<div>
		<div><b>pondelok</b>8:00-12:30   13:00-17:00</div>
		<div><b>utorok</b>8:00-12:30   13:00-17:00</div>
		<div><b>streda</b>8:00-12:30   13:00-17:00</div>
		<div><b>štvrtok</b>8:00-12:30   13:00-17:00</div>  
		<div><b>piatok</b>8:00-12:30   13:00-17:00</div>  
		<div><b>sobota</b>ZATVORENÉ</div>
		<div><b>nedeľa</b>ZATVORENÉ</div>
	</div>
</div>
@endif

</div>


<div id="map">asdas</div>


</div>
</div>
</div>
@stop