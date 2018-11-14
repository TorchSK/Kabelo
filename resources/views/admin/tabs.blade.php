<div id="admin_menu" class="ui vertical accordion menu">

  <div class="ct">
  <img src="{{url('img/adminLogo.png')}}" style="padding: 15px; display: inline-block;" width="140" />
  </div>

  <div class="item">
    <div class="header title @if(strpos(Route::currentRouteName(),'admin.dashboard')!==false) active @endif">
      <i class="chart pie icon"></i>
      Prehľad
      <i class="dropdown icon"></i>
    </div>
    <div class="content menu @if(strpos(Route::currentRouteName(),'admin.dashboard')!==false) active @endif">
      <a href="{{route('admin.dashboard.new')}}" class="item @if(Route::currentRouteName()=='admin.dashboard.new') active @endif">Najnovšie</a>
      <a href="{{route('admin.dashboard.overall')}}" class="item @if(Route::currentRouteName()=='admin.dashboard.overall') active @endif">Súhrnné</a>
    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.eshop')!==false) active @endif">
    <i class="cube icon"></i>
      Eshop
      <i class="dropdown icon"></i>
    </div>
    <div class="content menu @if(strpos(Route::currentRouteName(),'admin.eshop')!==false) active @endif">
      <a href="{{route('admin.eshop.categories')}}" class="item @if(Route::currentRouteName()=='admin.eshop.categories') active @endif">Kategórie</a>
      <a href="{{route('admin.eshop.products')}}" class="item @if(Route::currentRouteName()=='admin.eshop.products') active @endif">Produkty</a>
      <a href="{{route('admin.eshop.new')}}" class="item @if(Route::currentRouteName()=='admin.eshop.new') active @endif">Novinky</a>
      <a href="{{route('admin.eshop.sale')}}" class="item @if(Route::currentRouteName()=='admin.eshop.sale') active @endif">Zľavy</a>
      <a href="{{route('admin.eshop.inactive')}}" class="item @if(Route::currentRouteName()=='admin.eshop.inactive') active @endif">Neaktívne</a>
      <a href="{{route('admin.eshop.stickers')}}" class="item @if(Route::currentRouteName()=='admin.eshop.stickers') active @endif">Stickers</a>
      @if($appname=='Dedra')
      <a href="{{route('admin.eshop.xmlupdate')}}" class="item @if(Route::currentRouteName()=='admin.eshop.xmlupdate') active @endif">Aktualizácia z XML</a>
      @endif

    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.params')!==false) active @endif">
    <i class="tasks icon"></i>
      <i class="dropdown icon"></i>
      Parametre
    </div>
    <div class="content menu @if(strpos(Route::currentRouteName(),'admin.params')!==false) active @endif">
      <a href="{{route('admin.params.index')}}" class="item @if(Route::currentRouteName()=='admin.params.index') active @endif">Zoznam parametrov</a>
    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.users')!==false) active @endif">
    <i class="users icon"></i>
      <i class="dropdown icon"></i>
      Uživatelia
    </div>
    <div class="menu content @if(strpos(Route::currentRouteName(),'admin.users')!==false) active @endif">
      <a href="{{route('admin.users.index')}}" class="item @if(Route::currentRouteName()=='admin.users.index') active @endif">Zoznam uživateľov</a>
    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.orders')!==false) active @endif">
    <i class="cart icon"></i>
      <i class="dropdown icon"></i>
      Objednávky
    </div>
    <div class="menu content @if(strpos(Route::currentRouteName(),'admin.orders')!==false) active @endif">
      <a href="{{route('admin.orders.index')}}" class="item">Objednávky</a>
    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.settings')!==false) active @endif">
    <i class="settings icon"></i>
      <i class="dropdown icon"></i>
      Nastavenia
    </div>
    <div class="menu content @if(strpos(Route::currentRouteName(),'admin.settings')!==false) active @endif">
      <a href="{{route('admin.settings.banners')}}" class="item @if(Route::currentRouteName()=='admin.settings.banners') active @endif">Bannery</a>
      <a href="{{route('admin.settings.eshop')}}" class="item @if(Route::currentRouteName()=='admin.settings.eshop') active @endif">Eshop</a>
      <a href="{{route('admin.settings.delivery')}}" class="item @if(Route::currentRouteName()=='admin.settings.delivery') active @endif">Doprava</a>
      <a href="{{route('admin.settings.invoice')}}" class="item @if(Route::currentRouteName()=='admin.settings.invoice') active @endif">Fakturačné údaje</a>
      <a href="{{route('admin.settings.site')}}" class="item @if(Route::currentRouteName()=='admin.settings.site') active @endif">Web</a>

    </div>

  </div>
    <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.files')!==false) active @endif">
    <i class="file icon"></i>
      <i class="dropdown icon"></i>
      Súbory
    </div>
    <div class="menu content @if(strpos(Route::currentRouteName(),'admin.files')!==false) active @endif">
      <a href="{{route('admin.files.files')}}" class="item @if(Route::currentRouteName()=='admin.files.files') active @endif">Súbory</a>
      <a href="{{route('admin.files.catalogues')}}" class="item @if(Route::currentRouteName()=='admin.files.catalogues') active @endif">Katalógy</a>
      <a href="{{route('admin.files.stickers')}}" class="item @if(Route::currentRouteName()=='admin.files.stickers') active @endif">Stickers</a>
    </div>
  </div>

  <div class="item">
  <div class="header title @if(strpos(Route::currentRouteName(),'admin.layout')!==false) active @endif">
    <i class="columns icon"></i>
      <i class="dropdown icon"></i>
      Podstránky webu
    </div>
    <div class="content menu @if(strpos(Route::currentRouteName(),'admin.pages')!==false) active @endif">
      <a href="{{route('admin.pages.list')}}" class="item @if(Route::currentRouteName()=='admin.pages.list') active @endif">Zoznam podstránok</a>
      <a href="{{route('admin.pages.texts')}}" class="item @if(Route::currentRouteName()=='admin.pages.texts') active @endif">Zoznam textov</a>
    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.layout')!==false) active @endif">
    <i class="tv icon"></i>
      <i class="dropdown icon"></i>
      Šáblóna webu
    </div>
    <div class="content menu @if(strpos(Route::currentRouteName(),'admin.layout')!==false) active @endif">
      <a href="{{route('admin.layout.templates')}}" class="item @if(Route::currentRouteName()=='admin.layout.templates') active @endif">Zoznam šablón</a>
      <a href="{{route('admin.layout.pages')}}" class="item @if(Route::currentRouteName()=='admin.layout.pages') active @endif">Úprava stránok</a>
    </div>
  </div>
</div>


