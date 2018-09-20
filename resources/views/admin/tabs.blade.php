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
      <a href="{{route('admin.eshop.categories')}}" class="item">Kategórie</a>
      <a href="{{route('admin.eshop.products')}}" class="item">Produkty</a>
      <a class="item">Zľavy</a>
      <a class="item">Neaktívne produkty</a>
    </div>
  </div>
  <div class="item">
	<a href="{{route('admin.params')}}" class="header"><i class="tasks icon"></i> Parametre</a>
    <div class="menu">
      <a class="item">Nastavenia</a>
    </div>
  </div>
  <div class="item">
	<a href="{{route('admin.users')}}" class="header"><i class="users icon"></i> Uživatelia</a>
    <div class="menu">
      <a class="item">E-mail Support</a>
      <a class="item">FAQs</a>
    </div>
  </div>
    <div class="item">
	<a href="{{route('admin.orders')}}" class="header"><i class="cart icon"></i> Objednávky</a>
    <div class="menu">
      <a class="item">E-mail Support</a>
      <a class="item">FAQs</a>
    </div>
  </div>
  <div class="item">
	<a href="{{route('admin.settingsBanners')}}" class="header"><i class="settings icon"></i> Nastavenia</a>
    <div class="menu">
      <a class="item">E-mail Support</a>
      <a class="item">FAQs</a>
    </div>
  </div>
    <div class="item">
	<a href="{{route('admin.files')}}" class="header"><i class="file icon"></i> Súbory</a>
    <div class="menu">
      <a class="item">E-mail Support</a>
      <a class="item">FAQs</a>
    </div>
  </div>
    <div class="item">
	<a href="{{route('admin.layout')}}" class="header"><i class="tv icon"></i> Šáblóna webu</a>
    <div class="menu">
      <a class="item">E-mail Support</a>
      <a class="item">FAQs</a>
    </div>
  </div>
</div>



