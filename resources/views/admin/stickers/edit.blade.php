@extends('layouts.admin')
@section('content')

<div id="sticker_wrapper" class="admin_wrapper">

<div class="ui checkbox">
  <input type="checkbox" name="example">
  <label>Zobrazovať na boxe produktu</label>
</div>

<br />

<div class="ui checkbox">
  <input type="checkbox" name="example">
  <label>Zobrazovať na detaile produktu</label>
</div>


<div class="sticker_preview_div">

	<div class="sticker">
		<img src="{{url($sticker->path)}}" />
	</div>
</div>

</div>


@stop