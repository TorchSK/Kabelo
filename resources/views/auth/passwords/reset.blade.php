@extends('layouts.master')
@section('content')


<div class="flex_content content">
    <div class="lander ct">

    @include ('utils/errors')


    <form class="ui form small_form login_form" method="POST" action="{{ route('password.request') }}">

        <input type="hidden" name="token" value="{{$token}}">

        {{ csrf_field() }}
        <div class="field">
          <div class="ui left icon big input">
            <input id="email" type="email" placeholder="Zadajte email" name="email" value="{{ old('email') }}" required>
            <i class="mail icon"></i>
        </div>
        </div>

        <div class="field">
          <div class="ui left icon big input">
            <input type="password" placeholder="Zadajte heslo" name="password" required>
            <i class="lock icon"></i>
        </div>
        </div>

        <div class="field">
          <div class="ui left icon big input">
            <input type="password" placeholder="Zadajte heslo znovu" name="password_confirmation" required>
            <i class="lock icon"></i>
        </div>
     </div>

            

    <button type="submit" class="ui teal large button">
        Nastav nové heslo
    </button>

    </form>
        
    </div>
</div>
@stop
