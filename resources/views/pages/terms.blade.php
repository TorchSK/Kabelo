@extends('layouts.master')
@section('content')

<div class="flex_content flex" >

<div id="terms_div">

<div class="ui header ct">Obchodné podmienky</div>

@if(Auth::check() && Auth::user()->admin)
<div>
<div class="ui green button" data-key="terms" id="text_save_btn">Ulož</div>
</div>
@endif

{!!App\Text::firstOrCreate(['key'=>'terms'])->text!!}


<div class="richtext @if(Auth::check() && Auth::user()->admin) editable @endif">
{!!App\Text::firstOrCreate(['key'=>'terms'])->text!!}
</div>
</div>
</div>
@stop