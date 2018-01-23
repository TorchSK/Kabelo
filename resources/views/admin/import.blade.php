@extends('layouts.master')
@section('content')

<div action="/admin/import" class="dropzone" id="import_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></div>


@stop