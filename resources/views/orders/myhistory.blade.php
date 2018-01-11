@extends('layouts.master')
@section('content')

<div class="pad wrapper ct">
<div class="order_success ct">
	
	@foreach(Auth::user()->orders as $order)
		{{$order}}
	@endforeach

</div>
</div>
@stop