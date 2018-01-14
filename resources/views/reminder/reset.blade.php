@extends("layouts.master")
@section("content")

@include('includes.header')

<div class="pad wrapper">
<div class="container ct">

    @if (session('success'))

    <div class="ui icon success message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        Check your email
      </div>
      <p>Check you email inbox for further instructions</p>
    </div>
    </div>

    @else

    @include ('utils/errors')

    @endif

    <div class="lander">

    {!! Form::open([
        "class" => "ui form segment small_form content",
        "id" => "reset_form"
    ]) !!}

    {!! Form::hidden('token',$token) !!}

      <div class="field">
    <div class="ui big left icon input">
     <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="Enter your email">
      <i class="mail icon"></i>
      <div class="ui tiny corner label">
        <i class="icon asterisk"></i>
      </div>
    </div>
  </div>



  <div class="field">
    <div class="ui big left icon input">
      <input name="password" type="password" placeholder="New password">
      <i class="lock icon"></i>
      <div class="ui tiny corner label">
        <i class="icon asterisk"></i>
      </div>
    </div>
  </div>

    <div class="field">
    <div class="ui big left icon input">
      <input name="password_confirmation" type="password" placeholder="New password again">
      <i class="lock icon"></i>
      <div class="ui tiny corner label">
        <i class="icon asterisk"></i>
      </div>
    </div>
  </div>

    {!! Form::submit("Reset", [
            'class' => 'ui big fluid teal submit button'
        ]) !!}
    {!! Form::close() !!}

    </div>

</div> <!-- /container -->
</div>

@stop