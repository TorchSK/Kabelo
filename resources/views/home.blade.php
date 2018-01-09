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

        <div class="content" id="home_content">

            <div id="filters">

                <div id="product_search">
                    <div class="ui left icon huge input product_search_input" >
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

           
                <div class="categories">
                    <div class="header item">Určenie</div>
                    @foreach(App\Category::all() as $category)
                        <div class="item" data-categoryid="{{$category->id}}">{{$category->name}}</div>
                    @endforeach
                </div>

                 <div class="makers">
             
                </div>

            </div>

            <div id="grid">

                 <div class="ui inverted dimmer">
                    <div class="ui text loader">Loading</div>
                  </div>

                <div class="tabbs">
                    <a class="tabb ui brown large label">Všetky produkty</a>
                    <a class="tabb ui basic large label">Novinky</a>
                    <a class="tabb ui basic large label">V akcii</a>
                </div>

               <div id="active_filters"></div>
               <grid>

               </grid>

        </div>

    </div>

@stop