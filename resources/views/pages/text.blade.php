<div id="page_div">


	<div class="ui header ct">{{$page->name}}</div>

	@foreach($page->texts as $text)
	 @include('texts.profile')
	@endforeach
</div>