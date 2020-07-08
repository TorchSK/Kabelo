@extends('layouts.master')
@section('content')



    @if($layout == 2)
    @include('includes/filterbar_horizontal')
    @endif

    <div id="m_categories_wrapper">
        <div class="ui red  small fluid button" id="catbar_handle">Kategorie</div>
    </div>


@stop