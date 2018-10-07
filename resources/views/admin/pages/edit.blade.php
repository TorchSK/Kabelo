@extends('layouts.admin')
@section('content')

<div id="page_wrapper" class="admin_wrapper">

<form action="{{route('page.update',['page'=>$page->id])}}" method="POST" class="admin_page_attributes">
	{{ csrf_field() }}

	<input type="hidden" name="_method" value="PUT" />

	<div class="ui fluid labeled input" data-attribute="name">
	   <div class="ui label">Názov</div>
	   <input type="text" name="name" value="{{$page->name}}" />
	</div>

	<div class="ui fluid labeled input" data-attribute="url">
	  <div class="ui label">URL</div>
	   <input type="text" name="url" value="{{$page->url}}" />
	</div>




	<button type="submit" class="ui green button" id="edit_category_submit" data-categoryid="{{$page->id}}">Ulož</button>

</form>


Zoznam textov
<div class="page_texts_list">
	@foreach($texts as $text)
		<div class="item text @if(in_array($text->id, $page->texts->pluck('id')->toArray())) active @endif" data-pageid="{{$page->id}}" data-textid="{{$text->id}}">
			<div class="icon"><i class="list ul icon"></i></div>
			<div class="name">{{$text->name}}</div>
		</div>
	@endforeach
</div>

<div class="page_preview">
	<div class="ui header ct">{{$page->name}}</div>
	@foreach($page->texts as $text)
		@include('texts.profile')
	@endforeach	
</div>

</div>


@stop