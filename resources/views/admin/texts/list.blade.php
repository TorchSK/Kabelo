@extends('layouts.admin')
@section('content')

<div id="pages_wrapper" class="admin_wrapper">
	<ul class="pages_list">
	@foreach($texts as $text)
		<li class="item" data-id="{{$text->id}}" data-type="texts" data-active="{{$text->active}}" data-name="{{$text->name}}" data-url="{{$text->url}}">
			<div class="name">Názov: <b>{{$text->name}}</b></div>
			<div class="stretch"></div>
			<div class="actions">
				<a href="{{route('admin.pages.textEdit', ['id' => $text->id])}}" class="ui mini green icon button"><i class="search icon"></i></a>
				<div class="ui mini red icon button page_delete_btn"><i class="delete icon"></i></div>
			</div>
		</li>
	@endforeach
	</ul>

	<div class="ui blue button" id="new_text_btn">Nový text</div>

@include('modals.newtext')

</div>


@stop