@extends('layouts.admin')
@section('content')



<div id="seo_tool_profile_wrapper" class="admin_wrapper">

<div class="hiden">
<div class="xml_field">
	<div class="item setting">
		<div class="ui input"><input type="text" name="key[]"></div>	
		<div class="ui input"><input type="text" name="value[]"></div>	
	</div>
</div>
</div>

<div class="short">
	<form method="POST" action="{{route('seo.tool.update', $tool->id)}}">
		  <input name="_method" type="hidden" value="PUT">

        {{ csrf_field() }}

	<div class="ui header">{{$tool->name}}</div>

	<div class="item setting">
		<div class="label">Názov</div>
		<div class="ui input">
		  <input type="text" name="company_name" value="{{$tool->name}}">
		</div>	
	</div>

	<div class="item setting">
		<div class="label">Periodický</div>
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

	<div class="field_list">


	@foreach(json_decode($tool->columns, true) as $key => $column)

		<div class="item setting">
			<div class="label">{{$key}}</div>
			<div class="ui input">
			  <input type="text" name="company_name" value="{{$column}}">
			</div>	
		</div>

	@endforeach
	</div>

	<div class="ui button" id="new_xml_field_btn">Nové pole</div>

	<div>
	<button type="submit" class="ui green button">Ulož</button>
	</div>

	</form>

</div>


</div>

@stop

