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
      <a href="{{route('admin.eshop.categories')}}" class="item @if(Route::currentRouteName()=='admin.eshop.categories') active @endif">Zoznam kategórií</a>
      <a href="{{route('admin.eshop.products',['category'=>App\Category::first()->url])}}" class="item">Kategórie / Produkty</a>
      <a href="{{route('admin.eshop.new')}}" class="item">Novinky</a>
      <a href="{{route('admin.eshop.sale')}}" class="item">Zľavy</a>
      <a href="{{route('admin.eshop.inactive')}}" class="item">Neaktívne</a>
    </div>
  </div>

  <div class="item">
	<div class="header title @if(strpos(Route::currentRouteName(),'admin.params')!==false) active @endif">
    <i class="tasks icon"></i>
      <i class="dropdown icon"></i>
      Parametre
    </div>
    <div class="content menu @if(strpos(Route::currentRouteName(),'admin.params')!==false) active @endif">
      <a href="{{route('admin.params.index')}}" class="item">Zoznam parametrov</a>
    </div>
  </div>

  <div class="item">
	<div class="header title">
    <i class="users icon"></i>
      <i class="dropdown icon"></i>
      Uživatelia
    </div>
    <div class="menu content">
      <a href="{{route('admin.users.index')}}" class="item">Zoznam uživateľov</a>
    </div>
  </div>

  <div class="item">
	<div class="header title">
    <i class="cart icon"></i>
      <i class="dropdown icon"></i>
      Objednávky
    </div>
    <div class="menu content">
      <a href="{{route('admin.orders.index')}}" class="item">Objednávky</a>
    </div>
  </div>

  <div class="item">
	<div class="header title">
    <i class="settings icon"></i>
      <i class="dropdown icon"></i>
      Nastavenia
    </div>
    <div class="menu content">
      <a href="{{route('admin.settings.banners')}}" class="item">Bannery</a>
      <a href="{{route('admin.settings.eshop')}}" class="item">Eshop</a>
      <a href="{{route('admin.settings.delivery')}}" class="item">Doprava</a>
      <a href="{{route('admin.settings.invoice')}}" class="item">Fakturačné údaje</a>
    </div>

  </div>
    <div class="item">
	<div class="header title">
    <i class="file icon"></i>
      <i class="dropdown icon"></i>
      Súbory
    </div>
    <div class="menu content">
      <a href="{{route('admin.files')}}" class="item">Zoznam súborov</a>
    </div>
  </div>

  <div class="item">
	<div class="header title">
    <i class="tv icon"></i>
      <i class="dropdown icon"></i>
      Šáblóna webu
    </div>
    <div class="content menu">
      <a href="{{route('admin.layout')}}" class="item">Zoznam šablón</a>
    </div>
  </div>
</div>

@if( Route::currentRouteName() == 'admin.eshop.products')
@include('admin.sidebar')
@endif


