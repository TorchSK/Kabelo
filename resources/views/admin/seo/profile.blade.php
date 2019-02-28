@extends('layouts.admin')
@section('content')



<div class="admin_wrapper">

<div class="short">
	<form method="POST" action="/admin/seo/tool/{{$tool->id}}">
        {{ csrf_field() }}

	<div class="ui header">{{$tool->name}}</div>

	<div class="item setting">
		<div class="label">Názov</div>
		<div class="ui input">
		  <input type="text" name="company_name" value="{{$tool->name}}">
		</div>	
	</div>

	<div class="item setting">
		<div class="label">Petiodický</div>
		<div class="ui toggle checkbox">
		  <input type="checkbox" name="periodic" @if($tool->periodic) checked @endif">
		</div>	
	</div>

	<div class="item setting">
		<div class="label">Frekvencia (s)</div>
		<div class="ui input">
		  <input type="text" name="company_name" value="{{$tool->frequency}}">
		</div>	
	</div>

	<div class="ui header">Polia v súbore</div>

	@foreach(json_decode($tool->columns, true) as $key => $column)

		<div class="item setting">
			<div class="label">{{$key}}</div>
			<div class="ui input">
			  <input type="text" name="company_name" value="{{$column}}">
			</div>	
		</div>

	@endforeach

	<button type="submit" class="ui green button">Ulož</button>

	</form>

</div>


</div>

@stop

