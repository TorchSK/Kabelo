@extends('layouts.master')
@section('content')

<div id="admin">
<div class="users">
<div class="ui accordion">
  @include('admin.userlist')
</div>
</div>
</div>

@stop