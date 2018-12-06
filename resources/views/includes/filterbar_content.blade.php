    @if (Request::segment(1)!='admin' && Route::currentRouteName()!='product.detail' && $appname=='Kabelo')
    <div class="tabs">
        <div class="category tab @if(!Request::get('category')) active @endif">Kategórie</div>
        @if (Route::currentRouteName()!='product.detail')
        <div class="param tab @if(Request::get('category')) active @else disabled  @endif">Parametre</div>
        @endif
    </div>
    @endif

    <div class="ui accordion">
        @if (Route::currentRouteName()!='product.detail' && Route::currentRouteName()!='home')

        @endif

        @if (Request::segment(1)=='admin')
            <div class="sidebar_btn">
            <div class="ui fluid blue button add_category_btn"><i class="add icon"></i>Pridaj kategóriu</div>
        </div>
        @endif
        

        <div @if($appname=='Dedra' && (isset($sticky) && $sticky)) class="sticky_div" @endif>

        <div id="cat_div">

            <div class="active content">
                @include('categories.categories')
            </div>

        </div>

         <div class="params">
             @if(Request::get('category') && Request::segment(1)!='admin' && env('DB_DATABASE_KABELO')=='kabelo')  
                @include('home.makers')
             @endif
        </div>
        </div>
        @if (Request::segment(1)=='admin')
           <div class="ui horizontal divider">Nezaradane produkty</div>
                <div class="sidebar_btn">
                <a href="/admin/unknown" class="ui fluid button">Ukázať <i>({{App\Product::doesntHave('categories')->count()}})</i></a>
            </div>
        @endif

    </div>