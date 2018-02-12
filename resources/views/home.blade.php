@extends('layouts.master')
@section('content')
        
        <div class="covers">
            <div class="cover" style="background-image: url('/img/overlays/dot.png'), url('/img/tasker_cover2.jpg');background-size: auto, cover; background-position: 0 0, 80% 75%;">
                <div class="cover_div" style="top: 25%;left: 2%;text-align: center;width: 50%;">
                    <div id="slogan" style="color: rgba(255,255,255,0.8);">Tasker káble</div>
                    <div id="sub_slogan" style="color: rgba(255,255,255,0.9); text-shadow: 1px 1px 1px #555">Ponúkame najkvalitenjšie káble značky Tasker. Nájdete u nás celý sortiment od audio, video až po datové káble.</div>
                </div>
            </div>

            <div class="cover" style="background-image: url('/img/peaktech_cover.jpg');background-size: cover; background-position: 0 0, 80% 18%;">
                <div class="cover_div" style="top: 25%;right: 12%;text-align: center;width: 50%;">
                    <div id="slogan" style="color: rgba(0,0,0,0.6);">Multimetre Peaktech</div>
                    <div id="sub_slogan" style="color: rgba(255,255,255,0.9); text-shadow: 1px 1px 1px #555">Ponúkame najkvalitenjšie káble značky Tasker. Nájdete u nás celý sortiment od audio, video až po datové káble.</div>
                </div>
                    
            </div>
        </div>

        <div id="under_cover">               
          &nbsp;

        </div>

        <div class="content" id="home_content">


            <!-- mobile -->
            <div id="m_categories_btn">
                <div class="ui brown  small fluid button" id="catbar_handle">Kategorie</div>
            </div>

            <!-- desktop/tablet -->
            <div id="filters">

            <div class="tabs">
                <div class="category tab @if(!Request::get('category')) active @endif">Kategórie</div>
                <div class="params tab @if(Request::get('category')) active @else disabled  @endif">Parametre</div>
            </div>


            <div class="ui accordion">

                <div id="product_search">
                    <div class="ui left icon huge fluid input product_search_input" >
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <a href="{{route('home')}}/home/eshop" class="item">Úvodná stránka</a>

                <div class="categories @if(Request::get('category')) hidden @endif">
                    <div class="ui horizontal divider active title"><i class="dropdown icon"></i>Kategórie</div>
                    <div class="active content">
                    @foreach(App\Category::whereNull('parent_id')->get() as $category)
                        <div class="category @if(Request::get('category') == $category->id || in_array(Request::get('category'), (array)$category->children->pluck('id')->toArray()) ) active @endif">

                            <a href="?category={{$category->id}}" class="item filter @if(Request::get('category') == $category->id) active @endif" data-filter="category" data-value="{{$category->id}}" data-categoryid="{{$category->id}}">
                                <i class="cubes icon"></i>
                                <text>{{$category->name}}</text>
                                <count>{{$category->products->count()}}</count>
                            </a>

                            @foreach($category->children as $child)
                                <a href="?category={{$child->id}}" class="item sub filter @if(Request::get('category') == $child->id) active @endif" data-filter="category" data-value="{{$child->id}}" data-categoryid="{{$child->id}}">
                                    <i class="cube icon"></i>
                                    <text>{{$child->name}}</text>
                                    <count>{{$child->products->count()}}</count>
                               </a>
                            @endforeach

                        </div>

                    @endforeach
                    </div>
                </div>

                 <div class="filters">
                     @if(Request::get('category'))  
                        @include('makers')
                     @endif
                </div>

            </div>

            </div>

            <div id="grid">



                @if (Request::has('category'))
                <div class="caption">
                @if(App\Category::find(Request::get('category'))->parent_id)
                    <a href="?category={{App\Category::find(Request::get('category'))->parent_id}}">{{App\Category::find(App\Category::find(Request::get('category'))->parent_id)->name}}</a> -
                @endif
                    <a>{{App\Category::find(Request::get('category'))->name}}</a>
                </div>
                @endif

                @if(Request::get('category') && !App\Category::find(Request::get('category'))->parent_id && App\Category::find(Request::get('category'))->children->count() > 0)
                <div class="subcategories">
                    @foreach($category->children as $child)
                        @include('categories.row',['category'=>$child])
                                 
                    @endforeach         
                </div>
                @endif 

                @if (Request::has('category'))
                <div id="grid_stats" @if(isset($priceRange)) data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}" @else data-minprice="0" data-maxprice="1" @endif >
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

                @endif
               
               </grid>

        </div>

    </div>

@stop