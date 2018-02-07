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
                                <a href="?category={{$child->id}}" class="item subcategory filter @if(Request::get('category') == $child->id) active @endif" data-filter="category" data-value="{{$child->id}}" data-categoryid="{{$child->id}}">
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

                @if(Request::get('category') && !App\Category::find(Request::get('category'))->parent_id)
                <div class="subcategories">
                    @foreach($category->children as $child)

                        <a href="?category={{$child->id}}" class="subcategory ui yellow button"><i class="cube icon"></i>{{$child->name}}</a>          
                    @endforeach         
                </div>
                @endif 

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