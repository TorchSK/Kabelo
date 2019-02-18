<div class="ui right sidebar inverted vertical menu" id="sidebar">
    <a class="header right aligned item close_btn"><i class="chevron left icon"></i>Close</a>

        <div class="item search">
          <div class="ui left icon input" id="main_search">
            <input type="text" placeholder="Hľadať produkty..." />
                        <i class="search icon"></i>

          </div>

          <div id="search_results">
           <div class="ui horizontal divider active title">Produkty</div>
           <div class="products"></div>

           @if(Auth::check() && Auth::user()->admin)
           <div class="ui horizontal divider active title">Uživatelia</div>
           <div class="users"></div>
           @endif

           <a class="ui blue button search_view_all_btn" href="#">Všetky výsledky</a>
          </div>
        </div>


  @if (Auth::check())
    <a href="/settings/account" class="item"><i class="user icon"></i> Nastavenia účtu</a>
    <a href="/orders/mine" class="item"><i class="history icon"></i> História objednávok</a>
    @if(Auth::check() && Auth::user()->admin)
    <a href="{{route('admin.dashboard.new')}}" class="item"><i class="setting icon"></i> Administrácia</a>
    @endif
 
    <a href="/logout" class="item"><i class="power icon"></i> Odhlásiť</a>
    @endif

  
</div>