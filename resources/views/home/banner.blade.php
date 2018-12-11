@if(Request::segment(1)=='admin')
<div class="banner" data-type="{{$type}}" data-id="{{$cover->id}}">
	<img src="{{url($cover->image)}}" />

    <div class="banner_options">
    	<a href="{{route('banner.edit',['cover'=>$cover->id, 'type'=> $type])}}" class="ui blue button">Zmeň</a>
    	<a class="ui red button delete_banner_btn">Zmaž</a>
    </div>

</div>
@else
<a href="" class="banner" data-type="{{$type}}">
	<img src="{{url($cover->image)}}" />
</a>
@endif
