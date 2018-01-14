@extends("layouts.master")
@section("content")

@include('includes.header')

<div class="pad wrapper">
<div class="container ct">


<div class="aligner">
  <div class="aligner-item aligner-item--top"></div>
  <div class="aligner-item">

    <div class="ui icon compact success message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        Success
      </div>
      <p>You password was changed. You may now login.</p>
    </div>
    </div>


    <div class="ct">
    <div class="ui huge green button""><i class="repeat icon"></i>Check your email</div>
    </div>

    </div>


  <div class="aligner-item aligner-item--bottom"></div>
</div>
   
</div> <!-- /container -->
</div>

@stop