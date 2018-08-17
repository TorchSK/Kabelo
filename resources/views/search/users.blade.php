@foreach($users as $user)
	<a class="row" href="/admin/user/{{$user->id}}/detail">
		<div class="image">
			<i class="user big circle icon"></i>
		</div>
		<div class="name">{{$user->name}}</div>
		<div class="email">({{$user->email}})</div>
	</a>
@endforeach