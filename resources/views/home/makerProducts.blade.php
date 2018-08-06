@extends('layouts.master')
@section('content')

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

         <div class="caption">Výrobca: {{$maker}}</div>

        <div class="ui horizontal divider active title"></i>Kategórie</div>


		<div class="subcategories">
		    @foreach ($categories as $category)
                @include('categories.image',['category'=>App\Category::find($category)])
		    @endforeach  
		</div>

        <div class="ui horizontal divider active title"></i>Produkty</div>



            <div id="grid_stats" @if(isset($priceRange)) data-minprice="{{$priceRange[0]}}" data-maxprice="{{$priceRange[1]}}" @else data-minprice="0" data-maxprice="1" @endif ></div>

            <div class="options">

            <div class="sorts">
                <div class="active sort" data-sortby="name" data-sortorder="asc"><i class="sort alphabet ascending icon"></i> Nazov</div>
                <div class="sort" data-sortby="price" data-sortorder="asc"><i class="sort numeric    ascending icon"></i> Cena</div>
            </div>
            </div>
            
            <div id="price_slider"></div>


             <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
              </div>



           <div id="active_filters">
				<span data-value="{{$maker}}" data-filter="makers" data-group="parameters" class="makers ui large teal label">Výrobca: {{$maker}}<i class="delete icon"></i></span>      
			</div>     

           <grid>
                @include('products.list')
            </grid>

        </div>

    </div>
</div>

        <div class="under_cover">               
      &nbsp;
    </div>

@stop