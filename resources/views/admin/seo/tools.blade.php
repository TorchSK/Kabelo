@extends('layouts.admin')
@section('content')

<div id="seo_wrapper" class="admin_wrapper">
	<div class="list">

		@foreach(App\SeoTool::all() as $tool)
		<div class="item @if($tool->active) active  @endif" data-id="{{$tool->id}}">
			<div class="left">
				<div class="name">{{$tool->name}}</div>
				<div class="ui toggle checkbox">
				  <input type="checkbox" @if($tool->active) checked  @endif">
				  <label></label>
				</div>
			</div>
			<div class="right">
				<a href="{{route('seo.tool', $tool->url)}}" class="edit item"><i class="edit icon"></i></a>
				<a class="delete item"><i class="delete icon"></i></a>
			</div>
		</div>
		@endforeach

	</div>

	<div class="add_seo_tool_btn ui blue button">Pridaj vlastný</div>

</div>

@stop