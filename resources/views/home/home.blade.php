@extends('layouts.master')
@section('content')
        
    <div class="covers">
        <div class="cover" style="background-image: url('/img/overlays/dot.png'), url('/img/tasker_cover2.jpg');background-size: auto, cover; background-position: 0 0, 80% 75%;">
            <div class="cover_div" style="top: 25%;left: 2%;text-align: center;width: 50%;">
                <div id="slogan" style="color: rgba(255,255,255,0.8);">Tasker káble</div>
                <div id="sub_slogan" style="color: rgba(255,255,255,0.9); text-shadow: 1px 1px 1px #555">Ponúkame najkvalitenjšie káble značky Tasker. Nájdete u nás celý sortiment od audio, video až po datové káble.</div>
            </div>
        </div>
    </div>

    <div id="under_cover">               
      &nbsp;
    </div>

    <div class="flex" id="home_content">

        <!-- mobile -->
        <div id="m_categories_btn">
            <div class="ui brown  small fluid button" id="catbar_handle">Kategorie</div>
        </div>

        @include('includes/filterbar')

        <div id="grid">

            @if (Request::has('category'))

            <div class="caption">
            @if(App\Category::find(Request::get('category'))->parent_id)
                <a href="?category={{App\Category::find(Request::get('category'))->parent_id}}">{{App\Category::find(App\Category::find(Request::get('category'))->parent_id)->name}}</a> -
            @endif
                <a>{{App\Category::find(Request::get('category'))->name}}</a>
            </div>
            @endif

            @if(Request::get('category') && App\Category::find(Request::get('category'))->children->count() > 0)
            <div class="subcategories">
                @foreach(App\Category::find(Request::get('category'))->children as $child)
                    @include('categories.image',['category'=>$child])
                @endforeach         
            </div>
            @endif 

            @if (Request::has('category'))
            <div id="grid_stats" @if(isset($priceRange)) data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}" @else data-minprice="0" data-maxprice="1" @endif ></div>
            <div class="sorts">
                <div class="active sort" data-sortby="name" data-sortorder="asc"><i class="sort alphabet ascending icon"></i> Nazov</div>
                <div class="sort" data-sortby="price" data-sortorder="asc"><i class="sort numeric    ascending icon"></i> Cena</div>
            </div>
                              <div id="price_slider"></div>

            @endif

             <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
              </div>



           <div id="active_filters"></div>
           

           <grid>

                @if(Request::get('category'))

                    @include('products.list')

                @else

                    @include('home.initial')

                @endif
               
            </grid>

        </div>

    </div>

@stop