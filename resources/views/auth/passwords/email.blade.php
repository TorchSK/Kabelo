@extends('layouts.master')
@section('content')


<div id="email_wrapper" class="wrapper">
<div class="lander container ct">

@include ('utils/errors')

    @if (session('status'))

    <div class="ui icon success compact message" id="reminder_msg_ok">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        Email odoslaný
      </div>
      <p>Skontrolujte svoju emailovú schránku pre ďasľšie inštrukcie</p>
    </div>
    </div>

    @else


    <form class="ui form small_form login_form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="field">
          <div class="ui left icon big input">
            <input id="email" type="email" placeholder="Zadajte email" name="email" value="{{ old('email') }}" required>
            <i class="mail icon"></i>
        </div>
    </div>
             

    <button type="submit" class="ui teal large button" id="send_remider_btn">
        Odošli link na email
    </button>

    </form>

    @endif
    </div>
</div>
@stop
