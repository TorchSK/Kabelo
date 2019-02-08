@extends('layouts.admin')
@section('content')


<div id="admin_settings_banner" class="admin_wrapper">

	@include('admin.info',['text'=>'Nastavenie zobrazovania bannerov na úvodnej strane eshopu'])

	<div class="ui header">Covery</div>

	<div class="admin_cover_list">
     	@foreach(App\Banner::where('type','cover')->orderBy('order')->get() as $cover)
            @include('home.banner',['type'=>'cover','width'=> 'calc(100px * '.App\Setting::firstOrCreate(['name'=>'cover_ratio'],['value'=>2.8])->value.')'])
        @endforeach

	</div>
	
	<a href="{{route('banner.create',['type'=>'cover'])}}" class="ui blue button">Nový cover</a>
</div>

<div id="admin_settings_banner" class="admin_wrapper">


	<div class="ui header">Bannery</div>

	<div class="admin_banner_list">
     	@foreach(App\Banner::where('type','banner')->orderBy('order')->get() as $cover)
            @include('home.banner',['type'=>'banner','width'=> 'calc(100px * '.App\Setting::firstOrCreate(['name'=>'banner_ratio'],['value'=>2.8])->value.')'])
        @endforeach

	</div>
	
	<a href="{{route('banner.create',['type'=>'banner'])}}" class="ui blue button">Nový banner</a>
</div>

@stop

