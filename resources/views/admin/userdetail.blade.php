@extends('layouts.admin')
@section('content')

	<div class="user_detail">

		<div class="header section">

			<div class="name">
			@if ($user->name)
			{{$user->name}}
			@else
			{{$user->email}}
			@endif
			</div>
		</div>

		<div class="detail section">
		
		<div class="tabbs">

			<div class="tabs">

			    <div class="tabb ui brown button" data-tab="detail">Základné údaje</div>
			    <div class="tabb ui basic button" data-tab="recommended">Cenová zaradenie</div>
			    <div class="tabb ui basic button" data-tab="ratings">Objednávky ({{$user->orders->count()}})</div>

			</div>

		  	<div class="contents">

		    	<div class="content par active" data-tab="detail">

		    		
				</div>
		    
		  </div>

		</div>
	</div>

@stop