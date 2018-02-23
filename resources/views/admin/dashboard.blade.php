@extends('layouts.admin')
@section('content')

<div class="admin_dashboard">

	<div class="dashboard_tabs">
		<div class="new tab ui blue button"><i class="asterisk icon"></i> Najnovšie</div>
		<div class="overall tab ui basic button"><i class="archive icon"></i> Súhrnné</div>
	</div>

	<div class="boxes new">

		<div class="box">
			<div class="caption">Najnovšie objednávky</div>
		</div>


		<div class="box">

			<div class="caption">Najnovšie produkty</div>
		</div>

		<div class="box">

			<div class="caption">Najnovší uživatelia</div>
		</div>

	</div>

	<div class="boxes hidden overall">

		<div class="box">
			<div class="caption">bjednávky</div>
		</div>


		<div class="box">

			<div class="caption">Najnovšie produkty</div>
		</div>

		<div class="box">

			<div class="caption">Najnovší uživatelia</div>
		</div>

	</div>
</div>

@stop