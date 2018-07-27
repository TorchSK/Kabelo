@foreach (App\Parameter::all() as $param)
	@include('params.row')
@endforeach