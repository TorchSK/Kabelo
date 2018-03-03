<div class="cover @if(isset($editable)) editable @endif" style="background-image: url('/img/overlays/dot.png'), url(/{{$cover->image}});background-size: auto, cover;" data-id="{{$cover->id}}">
    <div class="cover_div" style="top: {{$cover->top}}% ;left: {{$cover->left}}%;text-align: center; width: {{$cover->width}}%;">
        <h1 class="slogan" style="color: {{$cover->h1_color}}; font-size:{{$cover->h1_size}}vw">{{$cover->h1_text}}</h1>
        <h2 class="sub_slogan" style="color: {{$cover->h2_color}}; font-size:{{$cover->h2_size}}vw; text-shadow: 1px 1px 1px #555">{{$cover->h2_text}}</h2>
    </div>

    <div class="cover_options">
    	<a href="{{route('admin.editcover',['cover'=>$cover->id])}}" class="ui blue button">Zmeň</a>
    	<a class="ui red button delete_cover_btn">Zmaž</a>
    </div>
</div>