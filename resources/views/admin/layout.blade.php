@extends('layouts.admin')
@section('content')



<div class="admin_wrapper" id="admin_layouts">

	<div class="layout_div @if(App\Setting::where('key','layout')->first()->value==1) selected @endif" data-layout="1">
		<img src="/img/resp1.png" width="300" />
	</div>

	<div class="layout_div @if(App\Setting::where('key','layout')->first()->value==2) selected @endif" data-layout="2">
		<img src="/img/resp2.png" width="300" />
	</div>
</div>

@stop



