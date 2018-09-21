@extends('layouts.master')
@section('content')


<div id="terms_div">

<div class="ui header ct">Ochrana osobných údajov</div>

@if(Auth::check() && Auth::user()->admin)
<div>
@if($editmode==1)
<div class="ui green button" data-key="gdpr" id="text_save_btn">Ulož</div>
@else
<a class="ui teal button" href="{{url()->current()}}/edit" id="text_save_btn">Edituj</a>
@endif
</div>
@endif

<div class="richtext @if(Auth::check() && Auth::user()->admin && $editmode==1) editable @endif">
{!!App\Text::firstOrCreate(['key'=>'gdpr'])->text!!}
</div>
</div>
@stop