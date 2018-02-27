@extends('layouts.admin')
@section('content')
	
	<div class="orders">
	<div class="ui horizontal divider">Uživatelia</div>
	
	<table class="ui celled selectable table">
	  <thead>
	    <tr>
	    <th>ID</th>
	 	<th>Meno</th>
	    <th>Email</th>
	    <th>Admin</th>
	   	<th>Datum registrácie</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\User::orderBy('created_at','desc')->get() as $user)
		<tr>
	      <td>{{$user->id}}</td>
	   	  <td>{{$user->name}}</td>
	      <td>{{$user->email}}</td>
	      <td>{{$user->admin}}</td>
	      <td>{{Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i:s')}}</td>

	      <td>
	      	<a href="{{route('admin.userDetail',['user'=>$user->id])}}" class="ui mini icon blue button"><i class="search large icon"></i></a>
	      </td>

	  	</tr>

		@endforeach
	  </tbody>
	</table>

@stop