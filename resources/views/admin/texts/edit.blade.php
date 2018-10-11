@extends('layouts.admin')
@section('content')

<div id="text_wrapper" class="admin_wrapper">


@include('texts.profile', ['editable'=>true])

<div class="text_save_btn ui green button" data-id="{{$text->id}}">Ulož</div>
@stop