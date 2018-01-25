@extends('layouts.master')
@section('content')

        <div id="cover">
            <div id="cover_div">
                <div id="slogan"><o>Trochu iné spojenie</o></div>
                <div id="sub_slogan">Ponúkame najkvalitenjšie káble značky Tasker. Nájdete u nás celý sortiment od audio, video až po datové káble.</div>
                <div id="view_goods_btn" class="ui huge inverted brown button"><i class="icon cubes"></i>Sortiment</div>
            </div>
        </div>

        <div id="under_cover">               
            <img src="/img/tasker.png" width="100" class="ui image" />

        </div>

        <div class="content" id="home_content">


            <!-- mobile -->
            <div id="m_categories_btn">Kategorie</div>

            <!-- desktop/tablet -->
            <div id="filters">
            <div class="ui accordion">

                <div id="product_search">
                    <div class="ui left icon huge fluid input product_search_input" >
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <a href="{{route('home')}}/home/eshop" class="item">Úvodná stránka<i class="home large icon"></i></a>

                <div class="categories">
                    <div class="ui horizontal divider active title"><i class="dropdown icon"></i>Kategórie</div>
                    <div class="active content">
                    @foreach(App\Category::all() as $category)
                        <div class="item filter" data-filter="category" data-value="{{$category->id}}" data-categoryid="{{$category->id}}">
                            <text>{{$category->name}}</text>
                            <div class="label">{{$category->products->count()}}</div>
                        </div>
                    @endforeach
                    </div>
                </div>

                 <div class="filters">
             
                </div>

            </div>

            </div>

            <div id="grid">


                <div class="sorts">
                    <div class="active sort" data-sortby="name" data-sortorder="asc"><i class="sort alphabet ascending icon"></i> Nazov</div>
                    <div class="sort" data-sortby="price" data-sortorder="asc"><i class="sort numeric    ascending icon"></i> Cena</div>
                </div>

                 <div class="ui inverted dimmer">
                    <div class="ui text loader">Loading</div>
                  </div>

                  <div id="price_slider"></div>


               <div id="active_filters"></div>
               

               <grid>
                
                <div class="ui horizontal divider active title">Akcie</div>
                <div id="home_sales_div">
                @foreach(App\Product::where('sale',1)->get() as $product)
                    @include('products.row')
                @endforeach
                </div>

                 <div class="ui horizontal divider active title">Novinky</div>
                 <div id="home_news_div">

                @foreach(App\Product::where('new',1)->get() as $product)
                    @include('products.row')
                @endforeach
            </div>
               
               </grid>

        </div>

    </div>

@stop