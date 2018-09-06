@extends('layouts.master')
@section('content')
        
    <div class="covers">
        @foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach
    </div>
    
    @if($layout == 1)
    <div class="under_cover">               
      &nbsp;
    </div>  
    @endif

    @if($layout == 2)
    @include('includes/filterbar_horizontal')
    @endif

    @if(Auth::check())
    <div class="content cart hidden" data-cartid="{{Auth::user()->cart->id}}"></div>
    @endif

    <div id="eshop">
    <div class="flex flex_content" id="home_content">

        <!-- mobile -->
        <div id="m_categories_btn">
            <div class="ui brown  small fluid button" id="catbar_handle">Kategorie</div>
        </div>

        @if($layout == 1)
        @include('includes/filterbar', ['sticky'=> true])
        @endif

        <div id="grid" class="main">

            @if (Request::has('category'))

                <div class="caption">
                @if($requestCategory->parent_id)
                    <a class="effect-1" href="/category/{{$requestCategory->parent->url}}">{{App\Category::find($requestCategory->parent_id)->name}}</a> -
                @endif
                    <a>{{$requestCategory->name}}</a>
                    @if (Auth::check() && Auth::user()->admin)
                    <a href="/admin/category/{{$requestCategory->url}}" data-tooltip="Administrácia"><i class="setting teal icon"></i></a>
                    @endif
                </div>

                <div class="ui horizontal divider active title"></i>Podkategórie</div>

            @endif


            @if(Request::get('category') && $requestCategory->children->count() > 0)
            <div class="subcategories">
                @foreach($requestCategory->children->sortBy('order') as $child)
                    @include('categories.image',['category'=>$child])
                @endforeach         
            </div>

            <div class="ui horizontal divider active title"></i>Produkty</div>

            @endif 


            @if (Request::has('category'))
            <div id="grid_stats" @if(isset($priceRange)) data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}" @else data-minprice="0" data-maxprice="1" @endif ></div>

            <div class="options">
                <div class="sorts">
                    <div class="active sort" data-sortby="name" data-sortorder="asc"><i class="sort alphabet ascending icon"></i> Nazov</div>
                    <div class="sort" data-sortby="price" data-sortorder="asc"><i class="sort numeric ascending icon"></i> Cena</div>
                </div>

                <div class="views">
                    <i class="table icon large active" id="change_grid_view_btn"></i>
                    <i class="icon large list" id="change_list_view_btn"></i>
                </div>
            </div>
            
        

            @if($appname=='Kabelo')
            <div id="price_slider"></div>
            @endif

            @endif

             <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
              </div>



           <div id="active_filters"></div>
           

           <grid @if($appname=="Dedra") class="infinite" @endif>

                @if(Request::get('category') || Route::currentRouteName()=='maker.products')

                    @include('products.list')

                @else

                    @include('home.initial')

                @endif
               
            </grid>

    

        </div>

        <div id="search_grid">
                <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
              </div>
            <div class="caption">Vyhľadávanie</div>

            <grid>
                
            </grid>
        </div>


    </div>
</div>

        <div class="under_cover">               
      &nbsp;
    </div>

@stop