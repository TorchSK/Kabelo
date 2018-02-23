@extends('layouts.admin')
@section('content')

<div class="users">
	<div class="ui accordion">
	  @include('admin.userlist')
	</div>
</div>

@stop