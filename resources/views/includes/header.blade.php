  <div id="header">
      <div class="container">
        <a class="logo item" href="/">
          <img src="img/logo.png" width="36"/>
          <text>Kvalitnékáble</text>
        </a>

        <div class="cart item">
          <div id="cart_icon"><i class="shop big icon"></i></div>
          <div id="cart_text">
              <caption>Nákupný košík (0)</caption>
              <price>0 Eur</price>
          </div>
        </div>

        <div class="account item">
          @if (Auth::check())
            {{Auth::user()->email}}
          @endif
          <i class="user big icon"></i>
        </div>

        <div class="ui basic popup transition" id="auth_popup">
           @if (Auth::check())
              <div class="left">
                <a href="/admin" class="row"><i class="setting icon"></i> Administruj produkty</a>
              </div>
              
              <div class="right ct">
                <a href="/logout" class="ui red button">Odhlásiť</a>
              </div>
           @else

          <div class="left" id="login_div">

            <div class="ui fluid input">
              <input type="text" name="email" placeholder="email">
            </div>

            <div class="ui fluid input">
              <input type="text" name="password" placeholder="password">
            </div>

            <div class="ui green fluid button" id="login_btn">Prihlásiť</div>

          </div>

          <div class="right" id="register_div">

          <div class="ui fluid input">
            <input type="text" name="email" placeholder="email">
          </div>

          <div class="ui fluid input">
            <input type="text" name="password" placeholder="password">
          </div>

          <div class="ui brown fluid button" id="register_btn">Registrovať</div>

        </div>

        @endif

      </div>


   </div>


  </div>