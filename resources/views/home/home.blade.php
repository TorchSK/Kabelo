@extends('layouts.master')
@section('content')

    <div class="covers">
        @foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach
    </div>

 
    @if($layout == 1)
    <div class="stripes divider">               
      &nbsp;
    </div>  
    @endif

    @if($layout == 2)
    @include('includes/filterbar_horizontal')
    @endif

    <!-- mobile -->
    <div id="m_categories_btn">
        <div class="ui brown  small fluid button" id="catbar_handle">Kategorie</div>
    </div>

    @if($layout == 1)
    @include('includes/filterbar', ['sticky'=> true])
    @endif

    <div id="home_news_div" class="wrapper">
        <div class="container">
            <div class="caption ct">
                Novinky
            </div>
            <div class="items">
            @foreach(App\Product::where('new',1)->get() as $product)
                @include('products.row')
            @endforeach
            </div>
        </div>
    </div>

    <div id="home_sales_div" class="wrapper">
        <div class="container">

            <div class="caption ct">
                Akcie
            </div>
            <div class="items">
            @foreach(App\Product::where('sale',1)->get() as $product)
                @include('products.row')
            @endforeach
            </div>
        </div>
    </div>


               


        <div class="under_cover">               
      &nbsp;
    </div>


@stop