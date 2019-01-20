@extends('layouts.master')
@section('content')
        

 
    @if($layout == 1)
    <div class="stripes divider">               
      &nbsp;
    </div>  
    @endif

    @if($layout == 2)
    @include('includes/filterbar_horizontal')
    @endif

    <!-- mobile -->
    <div id="m_categories_wrapper">
        <div class="ui red  small fluid button" id="catbar_handle">Kategorie</div>
    </div>


    <div class="flex_row">
    @if($layout == 1)
    @include('includes/filterbar', ['sticky'=> true])
    @endif

    <div class="flex_column">
    <div id="category_path_wrapper" class="wrapper">
       
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

               
            </grid>
            
            <div class="ct">
            <div class="ui large blue button view-more-button">Viac produktov</div>
            </div>

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
</div>

    @if($layout == 1)
    <div class="stripes divider">               
      &nbsp;
    </div>  
    @endif

@stop