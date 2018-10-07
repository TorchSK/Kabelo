@extends('layouts.admin')
@section('content')

<div id="text_wrapper" class="admin_wrapper">

@include('texts.profile', ['editable'=>true])

<div id="text_save_btn" class="ui green button" data-id="{{$text->id}}">Ulož</div>
@stop