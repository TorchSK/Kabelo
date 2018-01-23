@extends('layouts.master')
@section('content')

<div class="pad wrapper ct">
	<div class="container ct">
		<div action="/admin/import" class="dropzone" id="import_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></div>

</div>
</div>

<div id="admin_import_results">

	</div>
	
@stop