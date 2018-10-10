@extends('layouts.admin')
@section('content')

<div id="sticker_wrapper" class="admin_wrapper">

<div class="ui checkbox" id="sticker_product_row">
  <input type="checkbox" @if($sticker->product_row) checked @endif name="example">
  <label>Zobrazovať na boxe produktu</label>
</div>

<br />

<div class="ui checkbox" id="sticker_product_detail">
  <input type="checkbox" @if($sticker->product_detail) checked @endif name="example">
  <label>Zobrazovať na detaile produktu</label>
</div>


<div class="sticker_preview_div">

	<div class="sticker" style="left: {{$sticker->left}}px; top: {{$sticker->top}}px; width: {{$sticker->width}}px; height: {{$sticker->height}}px;">
		<img src="{{url($sticker->path)}}" />
	</div>
</div>


<button type="submit" class="ui green button" id="edit_sticker_submit" data-id="{{$sticker->id}}">Ulož</button>


</div>


@stop