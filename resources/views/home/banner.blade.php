@if(Request::segment(1)=='banner' || Request::segment(1)=='admin')
<div class="banner lazy" loading="lazy" data-type="{{$type}}" data-id="{{$cover->id}}" data-src="{{url($cover->image)}}" style="@if(isset($width)) width: {{$width}}; @endif";>

    <div class="banner_options">
    	<a href="{{route('banner.edit',['cover'=>$cover->id, 'type'=> $type])}}" class="ui blue button">Zmeň</a>
    	<a class="ui red button delete_banner_btn">Zmaž</a>
    </div>

</div>
@else
	<img data-src="{{url($cover->image)}}" loading="lazy" class="lazy" style="@if(isset($width)) width: {{$width}}; @endif" />

@endif
