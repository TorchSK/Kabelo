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
        
        @if (Request::segment(1)=='admin')
        <div class="sidebar_btn">
            <a href="/admin/import" class="ui fluid green button"><i class="cloud upload icon"></i>Import zo súboru</a>
            </div>

            <div class="sidebar_btn">
            <div class="ui fluid blue button" id="add_category_btn"><i class="add icon"></i>Pridaj kategóriu</div>
        </div>
        @endif
        
        @if (Request::segment(1)!='admin')
        <a href="/categories/all" class="pad item all_products_btn"><i class="cubes icon"></i> Všetky kategórie</a>
        @endif
        
        <div id="cat_div">
        <div class="ui horizontal divider active title"><i class="dropdown icon"></i>Kategórie</div>

        <div class="active content">
            @include('categories.categories')
        </div>
        </div>

         <div class="params">
             @if(Request::get('category'))  
                @include('home.makers')
             @endif
        </div>
        
        @if (Request::segment(1)=='admin')
           <div class="ui horizontal divider">Nezaradane produkty</div>
                <div class="sidebar_btn">
                <a href="/admin/unknown" class="ui fluid button">Ukázať <i>({{App\Product::doesntHave('categories')->count()}})</i></a>
            </div>
        @endif

    </div>

</div>