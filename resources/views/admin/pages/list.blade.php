@extends('layouts.admin')
@section('content')

<div id="pages_wrapper" class="admin_wrapper">
	<ul class="pages_list">
	@foreach($pages as $page)
		<li class="item" data-id="{{$page->id}}" data-type="page" data-active="{{$page->active}}" data-name="{{$page->name}}" data-url="{{$page->url}}">
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
			<div class="name">Názov: <b>{{$page->name}}</b></div>
			<div class="url">URL: <b>{{$page->url}}</b></div>
			<div class="stretch"></div>
			<div class="actions">
				<a href="{{route('admin.pages.pageEdit',['page'=>$page->url])}}" class="ui mini green icon button"><i class="search icon"></i></a>
				<div class="ui mini red icon button page_delete_btn"><i class="delete icon"></i></div>
			</div>
		</li>
	@endforeach
	</ul>

	<div class="ui blue button" id="new_page_btn">Nová stránka</div>

@include('modals.newpage')
@include('modals.editpage')

</div>


@stop