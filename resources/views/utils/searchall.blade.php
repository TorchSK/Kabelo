@extends('layouts.master')
@section('content')

@include('includes.header')

<div class="pad wrapper">

<!-- Nav tabs -->
<div class="container">

  <div id="search_tabs" class="ct">
  <div class="ui teal large label tabb @if ($users->count()==0) disabled @endif" data-target="users">Users <div class="detail">{!!$users->count()!!}</div></div>
  <div class="ui teal large label tabb @if ($dogs->count()==0) disabled @endif" data-target="dogs">Dogs <div class="detail">{!!$dogs->count()!!}</div></div>
  <div class="ui teal large label tabb @if ($kennels->count()==0) disabled @endif" data-target="kennels">Kennels <div class="detail">{!!$kennels->count()!!}</div></div>
  </div>

  <div class="asset list tabb_content" data-target="users">
  @foreach ($users as $user)
  	@include ('users/userbox')
  @endforeach
  </div>

  <div class="asset list hiden tabb_content" data-target="dogs">
  @foreach ($dogs as $dog)
      @include('assets/assetbox',['asset'=>$dog,'segment'=>'dog'])
  @endforeach
  </div>

  <div class="asset list hiden tabb_content" data-target="kennels">
  @foreach ($kennels as $kennel)
      @include('assets/assetbox',['asset'=>$kennel,'segment'=>'kennel'])
  @endforeach
  </div>


</div>
</div>



@stop