@extends("layouts.master")
@section("content")

@include('includes.header')

<div class="container fh ct">
<div class="am">

    
    @if (session('status'))

    <div class="aligner">
  <div class="aligner-item aligner-item--top"></div>
  <div class="aligner-item">


    <div class="ui icon success message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        Check your email
      </div>
      <p>Check you email inbox for further instructions</p>
    </div>
    </div>

    </div>


  <div class="aligner-item aligner-item--bottom"></div>

</div>
    @else

    @include ('utils/errors')
    
    <div class="lander">

    {!! Form::open([
        "route"        => "remind.postEmail",
        "autocomplete" => "off",
        "class" => "ui form segment small_form content",
        "id" => "remind_form"
    ]) !!}


  <div class="field">
    <div class="ui big left icon input">
      {!! Form::email('email', null, ['required' => true, 'placeholder' => "Enter email for new password.." ]) !!}
      <i class="mail icon"></i>
      <div class="ui tiny corner label">
        <i class="icon asterisk"></i>
      </div>
    </div>
  </div>

      
    <div class="ui big teal submit fluid button" type="submit" id="remind_form_btn">Send reset email</div>


    {!! Form::close() !!}

    </div>

    @endif
</div> <!-- /container -->
</div>

@stop