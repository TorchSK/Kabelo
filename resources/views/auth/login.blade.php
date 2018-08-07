@extends('layouts.master')
@section('content')


<div class="flex_content content">

<div class="lander ct">
@include ('utils/errors')
<form action="login" method="POST" autocomplete="true" class="ui form small_form login_form">
              <input name="_token" type="hidden" value="{{csrf_token()}}">

    <div class="field">
      <div class="ui left icon big input">
        <input name="email" type="text" placeholder="Email">
        <i class="user icon"></i>
      </div>
    </div>
  <div class="field">
    <div class="ui left icon big input">
      <input name="password" type="password" placeholder="Heslo">
      <i class="lock icon"></i>

    </div>
  </div>



  <input type="submit" class="ui brown big fluid button" value="Login">

  <div class="ui horizontal divider">Alebo</div>  
  <div class="inline field"><a href="#">Reset hesla</a></div>

</form>

</div>

</div>
@stop
