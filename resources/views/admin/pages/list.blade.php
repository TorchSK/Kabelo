@extends('layouts.admin')
@section('content')

<div id="pages_wrapper" class="admin_wrapper">
	<ul class="pages_list">
	@foreach($pages as $page)
		<li class="item" data-id="{{$page->id}}" data-type="page" data-active="{{$page->active}}">
			<div class="handle">
				<i class="bars icon"></i>
			</div>
			<div class="active_flag">
				@if($page->active)
					<i class="green circle icon"></i>
				@else	
					<i class="red circle icon"></i>
				@endif
			</div>
			<div class="name">{{$page->name}}</div>
			<div class="url">{{$page->url}}</div>
		</li>
	@endforeach
	</ul>

	<div class="ui blue button" id="new_page_btn">Nová stránka</div>

@include('modals.newpage')
@include('modals.editpage')

</div>


@stop