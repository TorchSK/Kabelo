@if(Request::segment(1)=='admin')
<div class="banner" data-type="{{$type}}">
	<img src="{{url($cover->image)}}" />
</div>
@else
<a href="" class="banner" data-type="{{$type}}">
	<img src="{{url($cover->image)}}" />
</a>
@endif
