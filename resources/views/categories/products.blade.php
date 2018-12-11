@extends('layouts.master')
@section('content')
        

 

    @if($layout == 2)
    @include('includes/filterbar_horizontal')
    @endif

    <!-- mobile -->
    <div id="m_categories_wrapper">
        <div class="ui red  small fluid button" id="catbar_handle">Kategorie</div>
    </div>

    <div class="main wrapper">


    <div class="container">

    <div class="flex_row">
    @if($layout == 1)
    @include('includes/filterbar', ['sticky'=> true])
    @endif

    <div class="flex_column">
    <div id="category_path_wrapper" class="wrapper" data-categoryid="{{$requestCategory->id}}">
        <div class="container">
        <h1>
        @if($requestCategory->parent_id && App\Category::find($requestCategory->parent_id)->parent_id)
            <a class="effect-1" href="{{route('category.products',['path'=> App\Category::find(App\Category::find($requestCategory->parent_id)->parent_id)->full_url])}}">{{App\Category::find(App\Category::find($requestCategory->parent_id)->parent_id)->name}}</a> -
        @endif

        @if($requestCategory->parent_id)
            <a class="effect-1" href="{{route('category.products',['path'=> App\Category::find($requestCategory->parent_id)->full_url])}}">{{App\Category::find($requestCategory->parent_id)->name}}</a> -
        @endif

            <a>{{$requestCategory->name}}</a>
        </h1>
        </div>
    </div>

    @if($requestCategory->children->count() > 0)
    <div id="subcategories_wrapper" class="wrapper">
        <div class="container">
            <div class="subcategories">
                @foreach($requestCategory->children->where('active',1)->sortBy('order') as $child)
                    @include('categories.image',['category'=>$child])
                @endforeach         
            </div>
    </div>
    </div>
    @endif

    <div id="grid_wrapper" class="wrapper">
        <div class="container">

            <div id="grid_stats" @if(isset($priceRange)) data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}" @else data-minprice="0" data-maxprice="1" @endif ></div>

            @if($products->count() > 0)

            <div class="options">
                <div class="sorts">
                    <div class="active sort" data-sortby="name" data-sortorder="asc"><i class="sort alphabet ascending icon"></i> Nazov</div>
                    <div class="sort" data-sortby="price" data-sortorder="asc"><i class="sort numeric ascending icon"></i> Cena</div>
                </div>
            </div>
            
            @endif
        

            @if($appname=='kabelo')
            <div id="price_slider"></div>
            @endif

             <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
              </div>



           <div id="active_filters"></div>
           

           <grid @if($appname=="dedra") class="infinite" @endif>

                @include('products.list')
               
            </grid>
            
            @if($products->count() > 0)
            <div class="ct">
                <div class="ui large blue button view-more-button">Viac produktov</div>
            </div>
            @endif

        </div>

        </div>
    </div>
</div>
</div>
</div>
</div>

@stop