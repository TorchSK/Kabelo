@extends('layouts.admin')
@section('content')
	
	<div class="orders">
	<div class="ui horizontal divider">Uživatelia</div>
	
	<table class="ui celled selectable sortable table">
	  <thead>
	    <tr>
	    <th></th>
	    <th>ID</th>
	 	<th>Meno</th>
	    <th>Email</th>
	    <th>Admin</th>
	   	<th>VOC</th>
	   	<th>Faktura</th>
	   	<th>Datum registrácie</th>
	   	<th>Počet objednávok</th>
	   	<th></th>

	  </tr></thead>
	  <tbody>
	  	@foreach(App\User::orderBy('created_at','desc')->get() as $user)
		<tr data-user_id="{{$user->id}}">
		  <td class="collapsing">
	      	<a href="{{route('admin.userDetail',['user'=>$user->id])}}" class="ui mini icon blue button"><i class="search large icon"></i></a>
	      </td>

	      <td>{{$user->id}}</td>
	   	  <td>{{$user->name}}</td>
	      <td>{{$user->email}}</td>
		  <td>
	      	<div class="ui checkbox admin_checkbox_onthefly" data-resource="user" data-id="{{$user->id}}" >
			  <input type="checkbox" name="admin" @if($user->admin) checked @endif>
			  <label></label>
			</div>
		  </td>
	      <td>
	      	<div class="ui checkbox admin_checkbox_onthefly" data-resource="user" data-id="{{$user->id}}" >
			  <input type="checkbox" name="voc" @if($user->voc) checked @endif>
			  <label></label>
			</div>
		  </td>
		  <td>
	      	<div class="ui checkbox admin_checkbox_onthefly" data-resource="user" data-id="{{$user->id}}" >
			  <input type="checkbox" name="invoice_eligible" @if($user->invoice_eligible) checked @endif>
			  <label></label>
			</div>
		  </td>
	      <td>{{Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i:s')}}</td>
	      <td>{{$user->orders->count()}}</td>

	      <td class="collapsing">
	      	<div class="ui icon red button delete_user_btn"><i class="delete icon"></i></div>
	      </td>

	  	</tr>

		@endforeach
	  </tbody>
	</table>
</div>
@stop