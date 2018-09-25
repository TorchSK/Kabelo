@if(Request::segment(1)=='admin')
<div class="cover @if(isset($editable)) editable @endif" style="background-image: @if($appname=='kabelo')url('/img/overlays/dot.png'),@endif url({{$cover->image}});background-size: @if($appname=='kabelo')auto,@endif cover;" data-id="{{$cover->id}}">
	@else
<a href="/{{$cover->url}}" class="cover @if(isset($editable)) editable @endif" style="background-image: @if($appname=='kabelo')url('/img/overlays/dot.png'), @endif url({{$cover->image}});background-size: @if($appname=='kabelo')auto,@endif cover;" data-id="{{$cover->id}}">
@endif

    <div class="cover_div" style="top: {{$cover->top}}% ;left: {{$cover->left}}%;text-align: center; width: {{$cover->width}}%;">
        <h1 class="slogan" style="color: {{$cover->h1_color}}; @if($layout==1)font-size:{{$cover->h1_size}}vw @else font-size:{{$cover->h1_size*0.7}}vw @endif">{{$cover->h1_text}}</h1>
        <h2 class="sub_slogan" style="color: {{$cover->h2_color}};  @if($layout==1)font-size:{{$cover->h2_size}}vw @else font-size:{{$cover->h2_size*0.7}}vw @endif; text-shadow: 1px 1px 1px #555">{{$cover->h2_text}}</h2>
    </div>

    @if(Request::segment(1)=='admin')
    <div class="cover_options">
    	<a href="{{route('admin.editcover',['cover'=>$cover->id])}}" class="ui blue button">Zmeň</a>
    	<a class="ui red button delete_cover_btn">Zmaž</a>
    </div>
    @endif
@if(Request::segment(1)=='admin')
</div>
@else
</a>
@endif