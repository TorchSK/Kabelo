<!-- desktop/tablet -->
<div id="filterbar">
    
    @if (Request::segment(1)!='admin')
    <div class="tabs">
        <div class="category tab @if(!Request::get('category')) active @endif">Kategórie</div>
        <div class="params tab @if(Request::get('category')) active @else disabled  @endif">Parametre</div>
    </div>
    @endif

    <div class="ui accordion">

        <div id="product_search">
            <div class="ui left icon huge fluid input product_search_input" >
              <input type="text" placeholder="Hľadaj produkt...">
                <i class="search icon"></i>
            </div>
        </div>

        <a href="{{route('home')}}/categories/all" class="pad item all_products_btn"><i class="cubes icon"></i> Všetky kategórie</a>
        
        <div class="ui horizontal divider active title"><i class="dropdown icon"></i>Kategórie</div>

        <div class="active content">
            @include('categories.categories')
        </div>

         <div class="params">
             @if(Request::get('category'))  
                @include('home.makers')
             @endif
        </div>

    </div>

</div>