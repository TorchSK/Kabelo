@extends('layouts.master')
@section('content')
        
    <div class="covers">
        @foreach(App\Cover::orderBy('order')->get() as $cover)
            @include('home.cover')
        @endforeach
    </div>

    <div class="under_cover">               
      &nbsp;
    </div>

    <div id="eshop">
    <div class="flex flex_content" id="home_content">

        <!-- mobile -->
        <div id="m_categories_btn">
            <div class="ui brown  small fluid button" id="catbar_handle">Kategorie</div>
        </div>

        @include('includes/filterbar')

        <div id="grid">

            @if (Request::has('category'))

                <div class="caption">
                @if(App\Category::find(Request::get('category'))->parent_id)
                    <a class="effect-1" href="/category/{{App\Category::find(Request::get('category'))->parent->url}}">{{App\Category::find(App\Category::find(Request::get('category'))->parent_id)->name}}</a> -
                @endif
                    <a>{{App\Category::find(Request::get('category'))->name}}</a>
                </div>

                <div class="ui horizontal divider active title"></i>Podkategórie</div>

            @endif


            @if(Request::get('category') && App\Category::find(Request::get('category'))->children->count() > 0)
            <div class="subcategories">
                @foreach(App\Category::find(Request::get('category'))->children as $child)
                    @include('categories.image',['category'=>$child])
                @endforeach         
            </div>

                    <div class="ui horizontal divider active title"></i>Produkty</div>

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

                @if(Request::get('category') || Route::currentRouteName()=='maker.products')

                    @include('products.list')

                @else

                    @include('home.initial')

                @endif
               
            </grid>

        </div>

    </div>
</div>

        <div class="under_cover">               
      &nbsp;
    </div>

@stop