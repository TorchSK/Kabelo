@extends('layouts.master')
@section('content')

        <div id="cover">
            <div id="cover_div">
                <div id="slogan">Profesionálne <o>Audio</o> a <o>video</o> káble</div>
                <div id="view_goods_btn" class="ui huge inverted brown button"><i class="icon cubes"></i>Sortiment</div>
            </div>
        </div>

        <div id="under_cover">               
            <img src="img/tasker.png" width="100" class="ui image" />
            <img src="img/tasker.png" width="100" class="ui image" />
            <img src="img/tasker.png" width="100" class="ui image" />

        </div>

        <div class="content">

            <div id="filters">

                <div id="product_search">
                    <div class="ui left icon huge input">
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <div class="makers">
                    <div class="header item">Výrobca</div>
                    <div class="item">Tasker</div>
                    <div class="item">Tasker</div>
                    <div class="item">Tasker</div>
                </div>

                <div class="categories">
                    <div class="header item">Určenie</div>
                    <div class="item">Káble na prenos dát<div class="ui brown label">12</div></div>
                    <div class="item">Káble video<div class="ui brown label">12</div></div>
                    <div class="item">Káble koaxiálne<div class="ui brown label">12</div></div>
                    <div class="item">Káble netienené<div class="ui brown label">12</div></div>
                    <div class="item">Káble mikrofónne<div class="ui brown label">12</div></div>
                    <div class="item">Káble DMX<div class="ui brown label">12</div></div>
                    <div class="item">Káble reproduktorové<div class="ui brown label">12</div></div>
                    <div class="item">Káble tienené<div class="ui brown label">12</div></div>
                    <div class="item">Káble silikónové<div class="ui brown label">12</div></div>
                    <div class="item">Káble telefónne<div class="ui brown label">12</div></div>
                    <div class="item">Odporové drôty, drôty<div class="ui brown label">12</div></div>
                </div>


            </div>

            <div id="grid">

               <div class="breadcrumb">Všetky produkty</div>

             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')
             @include('productrow')

    </div>

@stop