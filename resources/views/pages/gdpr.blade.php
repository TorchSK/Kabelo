@extends('layouts.master')
@section('content')

<div class="flex_content flex" >

<div id="terms_div">

<div class="ui header ct">Ochrana osobných údajov</div>

@if(Auth::check() && Auth::user()->admin)
<div>
<div class="ui green button" data-key="gdpr" id="text_save_btn">Ulož</div>
</div>
@endif

<div class="richtext @if(Auth::check() && Auth::user()->admin) editable @endif">
{!!App\Text::firstOrCreate(['key'=>'gdpr'])->text!!}
</div>
</div>
</div>
@stop