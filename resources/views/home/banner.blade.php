@if(Request::segment(1)=='admin')
<div class="banner">
	<img src="{{url($cover->image)}}" />
</div>
@else
<a href="" class="banner">
	<img src="{{url($cover->image)}}" />
</a>
@endif
