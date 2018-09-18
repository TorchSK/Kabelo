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

    <div id="category_path_wrapper" class="wrapper">
        <div class="container">
        
        @if(App\Category::find($requestCategory->parent_id)->parent_id)
            <a class="effect-1" href="{{route('category.products',['path'=> App\Category::find(App\Category::find($requestCategory->parent_id)->parent_id)->full_url])}}">{{App\Category::find(App\Category::find($requestCategory->parent_id)->parent_id)->name}}</a> -
        @endif

        @if($requestCategory->parent_id)
            <a class="effect-1" href="{{route('category.products',['path'=> App\Category::find($requestCategory->parent_id)->full_url])}}">{{App\Category::find($requestCategory->parent_id)->name}}</a> -
        @endif

            <a>{{$requestCategory->name}}</a>
        </div>
    </div>

    <div id="subcategories_wrapper" class="wrapper">
        <div class="container">

        @if($requestCategory->children->count() > 0)
        <div class="subcategories">
            @foreach($requestCategory->children->sortBy('order') as $child)
                @include('categories.image',['category'=>$child])
            @endforeach         
        </div>
        @endif
    </div>
    </div>

    <div id="grid_wrapper" class="wrapper">
        <div class="container">

            <div id="grid_stats" @if(isset($priceRange)) data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}" @else data-minprice="0" data-maxprice="1" @endif ></div>

            <div class="options">
                <div class="sorts">
                    <div class="active sort" data-sortby="name" data-sortorder="asc"><i class="sort alphabet ascending icon"></i> Nazov</div>
                    <div class="sort" data-sortby="price" data-sortorder="asc"><i class="sort numeric ascending icon"></i> Cena</div>
                </div>
            </div>
            
        

            @if($appname=='kabelo')
            <div id="price_slider"></div>
            @endif

             <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
              </div>



           <div id="active_filters"></div>
           

           <grid @if($appname=="dedra") class="infinite" @endif>

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

 
    @if($layout == 1)
    <div class="stripes divider">               
      &nbsp;
    </div>  
    @endif

@stop