@extends('layouts.master')
@section('content')


<div id="register_wrapper" class="wrapper">

<div class="lander container ct">


@include ('utils/errors')
<form  action="register" method="POST" autocomplete="true" class="ui form small_form register_form">
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



  <input type="submit" class="ui brown big fluid button" value="Registrovať">
    

</form>

</>

</div>
</div>
@stop
