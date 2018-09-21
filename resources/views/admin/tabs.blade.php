<div id="admin_menu" class="ui vertical menu">

  <div class="ct">
  <img src="{{url('img/adminLogo.png')}}" style="padding: 15px; display: inline-block;" width="140" />
  </div>

  <div class="item">
    <div class="header"><i class="chart pie icon"></i> Prehľad</div>
    <div class="menu">
      <a href="{{route('admin.dashboard.new')}}" class="item">Najnovšie</a>
      <a href="{{route('admin.dashboard.overall')}}" class="item">Súhrnné</a>
    </div>
  </div>

  <div class="item">
	<div class="header"><i class="cube icon"></i> Eshop</div>
    <div class="menu">
      <a href="{{route('admin.eshop.categories')}}" class="item">Zoznam kategórií</a>
      <a href="{{route('admin.eshop.products',['category'=>App\Category::first()->url])}}" class="item">Kategórie / Produkty</a>
      <a href="{{route('admin.eshop.new')}}" class="item">Novinky</a>
      <a href="{{route('admin.eshop.sale')}}" class="item">Zľavy</a>
      <a href="{{route('admin.eshop.inactive')}}" class="item">Neaktívne</a>
    </div>
  </div>

  <div class="item">
	<div class="header"><i class="tasks icon"></i> Parametre</div>
    <div class="menu">
      <a href="{{route('admin.params.index')}}" class="item">Zoznam parametrov</a>
    </div>
  </div>

  <div class="item">
	<div class="header"><i class="users icon"></i> Uživatelia</div>
    <div class="menu">
      <a href="{{route('admin.users.index')}}" class="item">Zoznam uživateľov</a>
    </div>
  </div>

  <div class="item">
	<div class="header"><i class="cart icon"></i> Objednávky</div>
    <div class="menu">
      <a href="{{route('admin.orders.index')}}" class="item">Objednávky</a>
    </div>
  </div>

  <div class="item">
	<div class="header"><i class="settings icon"></i> Nastavenia</div>
    <div class="menu">
      <a href="{{route('admin.settings.banners')}}" class="item">Bannery</a>
      <a href="{{route('admin.settings.eshop')}}" class="item">Eshop</a>
      <a href="{{route('admin.settings.delivery')}}" class="item">Doprava</a>
      <a href="{{route('admin.settings.invoice')}}" class="item">Fakturačné údaje</a>
    </div>

  </div>
    <div class="item">
	<div class="header"><i class="file icon"></i> Súbory</div>
    <div class="menu">
      <a href="{{route('admin.files')}}" class="item">Zoznam súborov</a>
    </div>
  </div>
    <div class="item">
	<div class="header"><i class="tv icon"></i> Šáblóna webu</div>
    <div class="menu">
      <a href="{{route('admin.layout')}}" class="item">Zoznam šablón</a>
    </div>
  </div>
</div>

@if( Route::currentRouteName() == 'admin.eshop.products')
@include('admin.sidebar')
@endif


