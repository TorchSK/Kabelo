@extends('layouts.master')
@section('content')

<div class="pad wrapper ct">
	<div class="container ct">
		<div action="/admin/import" class="dropzone" id="import_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></div>

</div>
</div>
<div id="admin_import_results">

<table class="ui celled table">
  <thead>
    <tr>
      <th>Názov</th>
      <th>Kód</th>
      <th>Výrobca</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td col="name"></td>
      <td col="code"></td>
      <td col="maker"></td>
    </tr>
  </tbody>
</table>

</div>

@stop