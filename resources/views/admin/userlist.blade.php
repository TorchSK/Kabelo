@foreach($users as $user)
<div class="item user" data-userid="{{$user->id}}">
	<div class="title">
		<div class="email">{{$user->email}}</div>
		<div class="name">{{$user->first_name}} {{$user->last_name}}</div>
	</div>
	<div class="content">
		<div class="ui red button admin_delete_user_btn">Zmazať uživatela</div>

		<div class="ui checkbox admin_admin_checkbox">
		  <input type="checkbox" name="example" @if($user->admin) checked @endif>
		  <label>Admin</label>
		</div>

	</div>
</div>
@endforeach