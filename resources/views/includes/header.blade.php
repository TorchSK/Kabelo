  <div id="header">
      <div class="container">
        <a class="logo item" href="/">
          <img src="/img/logo.png" width="36"/>
          <text>Kabelo</text>
        </a>


        <a class="cart item" href="/cart/products">
          <div id="cart_icon"><i class="shop big icon"></i></div>
          <div id="cart_text">
              <text>Nákupný košík (<number>{{$cartNumber}}</number>)</text>
              <price><number>{{$cartPrice}}</number> Eur</price>
          </div>
        </a>

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

                  <a href="{{route('admin.manageProducts')}}" class="row"><i class="setting icon"></i> Administruj produkty</a>
                  <a href="{{route('admin.manageOrders')}}" class="row"><i class="hourglass start icon"></i> Čakajúce objednávky</a>
                @endif

              </div>
              
              <div class="right ct">

    
                <a href="/logout" class="ui red button">Odhlásiť</a>
              </div>
           @else

          <div class="left" id="login_div">

            <form action="/login" id="login_form" method="POST">
              <input name="_token" type="hidden" value="{{csrf_token()}}">

              <div class="ui fluid input">
                <input type="text" name="email" placeholder="email">
              </div>

              <div class="ui fluid input" id="login_password_input">
                <input type="password" name="password" placeholder="heslo">
              </div>

              <button type="submit" class="ui green fluid button" id="login_btn">Prihlásiť</button>

            </form>

          </div>

          <div class="right" id="register_div">

          <div class="ui fluid input">
            <input type="text" name="email" placeholder="email">
          </div>

          <div class="ui fluid input" id="register_password_input">
            <input type="text" name="password" placeholder="heslo">
          </div>

          <div class="ui brown fluid button" id="register_btn">Registrovať</div>

        </div>

        @endif



      </div>


   </div>


  </div>