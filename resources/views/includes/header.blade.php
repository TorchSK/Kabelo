  <div id="header">
      <div class="container">
        <a class="logo item" href="/">
          <div class="image"><img class="{{strtolower($appname)}}" src="/img/logo_{{strtolower($appname)}}.png" /></div>
          <text>{{$appname}}</text>
        </a>

    
        
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

           <a class="search_view_all_btn" href="#">Všetky výsledky</a>
          </div>
        </div>

        <a class="item" id="sidebar_handle">
          <i class="icon content"></i>
        </a>

        <a class="cart item hvr-curl-top-left" href="/cart/products">
          <div id="cart_icon"><i class="shop big icon"></i></div>
          <div id="cart_text">
              <text>Nákupný košík (<number>{{$cart['number']}}</number>)</text>
              <price><number>{{$cart['price']}}</number> Eur</price>
          </div>
        </a>

   
      @if(Auth::check() && Auth::user()->admin && App\Order::whereIn('status_id',[0])->count() > 0)
        <div class="item orders">
        <a href="/admin/orders">
         <i class="shopping basket icon"></i> <count> {{App\Order::whereIn('status_id',[0])->count()}}</count>
        </a>
      </div>
        @endif

        <div class="account item">
          @if (Auth::check())
            {{Auth::user()->email}}
          @endif
          <i class="@if(Auth::check() && Auth::user()->admin) doctor @else user @endif  big icon"></i>
          <i class="chevron down icon"></i>
        </div>



        <div class="ui basic popup transition" id="auth_popup">
            <div class="msgs">

            </div>

           @if (Auth::check())
              <div class="left">
                <a href="/settings/account" class="row"><i class="user icon"></i> Nastavenia účtu</a>
                <a href="/orders/mine" class="row"><i class="history icon"></i> História objednávok</a>
                @if(Auth::check() && Auth::user()->admin)
                  <div class="ui horizontal divider"><i class="caret down icon"></i> Admin <i class="caret down icon"></i></div>

                  <a href="{{route('admin.dashboard')}}" class="row ui blue fluid button"><i class="setting icon"></i> Administrácia</a>

                @endif

              </div>
              
              <div class="right ct">

    
                <a href="/logout" class="ui red button">Odhlásiť</a>
              </div>
           @else

          <div class="left" id="login_div">

            <form action="/login" class="login_form" method="POST">
              <input name="_token" type="hidden" value="{{csrf_token()}}">

              <div class="ui fluid input">
                <input type="text" name="email" placeholder="email">
              </div>

              <div class="ui fluid input" id="login_password_input">
                <input type="password" name="password" placeholder="heslo">
              </div>

              <button type="submit" class="ui green fluid button" id="login_btn">Prihlásiť</button>
              <a href="/password/reset" id="reset_pwd_link"><i class="lock icon"></i> Zabudnuté heslo</a>

            </form>

          </div>

          <div class="right" id="register_div">


            <form action="/register" class="register_form" method="POST">
              <input name="_token" type="hidden" value="{{csrf_token()}}">

          <div class="ui fluid input">
            <input type="text" name="email" placeholder="email">
          </div>

          <div class="ui fluid input" id="register_password_input">
            <input type="text" name="password" placeholder="heslo">
          </div>

          <button type="submit" class="ui brown fluid button" id="register_btn">Registrovať</button>
        </form>
        </div>

        @endif



      </div>


   </div>

    <div id="routename" class="hiden">{{Route::currentRouteName()}}</div>


  </div>