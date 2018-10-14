@extends("layouts.master")
@section("content")

@include('includes.header')

<div id="password_wrapper" class="wrapper">
<div class="container lander ct">

    <h1 class="ui header">Reset password</h1>
    
    @if (session('status'))

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
        
    {!! Form::open([
        "route"        => "remind.postEmail",
        "autocomplete" => "off",
        "class" => "ui larhge form stacked segment small_form",
    ]) !!}


  <div class="field">
    <div class="ui big left icon input">
      {!! Form::email('email', null, ['required' => true, 'placeholder' => "Enter email for new password.." ]) !!}
      <i class="mail icon"></i>
      <div class="ui corner label">
        <i class="icon asterisk"></i>
      </div>
    </div>
  </div>

        {!! Form::submit("Send email" ,[
        	'class' => 'ui big fluid teal submit button'
        ]) !!}

    {!! Form::close() !!}

    @endif
</div> <!-- /container -->
</div>

@stop