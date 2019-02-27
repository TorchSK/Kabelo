@extends('layouts.admin')
@section('content')

<div id="seo_wrapper" class="admin_wrapper">
	<div class="list">

		@foreach(App\SeoTool::all() as $tool)
		<div class="item">
			<div class="name">{{$tool->name}}</div>
			<div class="ui toggle checkbox">
			  <input type="checkbox">
			  <label></label>
			</div>
		</div>
		@endforeach

	</div>

	<div class="add_seo_tool_btn ui blue button">Pridaj vlastný</div>

</div>

@stop