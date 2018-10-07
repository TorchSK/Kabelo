<div id="page_div">

	@if(Auth::check() && Auth::user()->admin)
	<a class="ui teal button" href="{{route('admin.pages.pageEdit',['page'=>$page->url])}}">Edituj</a>
	@endif

	<div class="ui header ct">{{$page->name}}</div>

	@foreach($page->texts as $text)
	 @include('texts.profile')
	@endforeach
</div>