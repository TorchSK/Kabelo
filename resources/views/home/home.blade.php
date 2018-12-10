@extends('layouts.master')
@section('content')



    @if($layout == 2)
    @include('includes/filterbar_horizontal')
    @endif

    <div id="m_categories_wrapper">
        <div class="ui red  small fluid button" id="catbar_handle">Kategorie</div>
    </div>

    <div class="main wrapper">


        <div class="container">

        <div class="flex_row">

            @include('includes/filterbar')

            <div class="grow">

                    <div class="top_banner_row">

                        <div class="covers">
                            @foreach(App\Banner::where('type','cover')->orderBy('order')->get() as $cover)
                                @include('home.cover',['type'=>'cover'])
                            @endforeach
                        </div>


                        <div class="top_banners">
                            @foreach(App\Banner::where('type','banner')->orderBy('order')->get() as $cover)
                                @include('home.banner',['type'=>'banner'])
                            @endforeach
                        </div>
                    </div>

       

                <div id="home_news_div" class="wrapper">
                    <div class="container">
                        <div class="caption">
                            <name>Novinky</name>
                            <arrows><i class="chevron circle left icon"></i><i class="chevron circle right icon"></i></arrows>
                        </div>
                        <div class="items">
                        @foreach(App\Product::where('new',1)->orderBy('updated_at','desc')->get() as $product)
                            @include('products.row',['showdesc'=>false])
                        @endforeach
                        </div>
                    </div>
                </div>

                <div class="wrapper" id="makers_div">
                <div class="container">
                    <a><img src="/img/velleman-logo.png" /></a>
                    <a><img src="/img/tasker_dark.png" /></a>
                    <a><img src="/img/peaktech_dark.png" /></a>
                    <a><img src="/img/distrelec_dark.png" /></a>

                </div>
                </div>

                <div id="home_sales_div" class="wrapper">
                    <div class="container">

                        <div class="caption">
                            <name>Akcie</name>
                            <arrows><i class="chevron circle left icon"></i><i class="chevron circle right icon"></i></arrows>
                        </div>

                        <div class="items">
                        @foreach(App\Product::where('sale',1)->orderBy('updated_at','desc')->get() as $product)
                            @include('products.row',['showdesc'=>false])
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>


@stop