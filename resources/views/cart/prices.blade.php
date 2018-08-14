	@if(Auth::check())
	<div id="cart_user_discount" @if(Auth::user()->discount==0) class="hidden" @endif>Vaša zľava: <price>{{Auth::user()->discount}}</price> <symbol>%</symbol></div>
	@else
	<div id="cart_user_discount" class="hidden">Vaša zľava: <price>0</price> <symbol>%</symbol></div>
	@endif

	<div id="cart_total_price">Celková cena: <price></price> <symbol>&euro;</symbol></div>

	@if(App\Setting::whereName('min_order_price')->first()->value > 0)
	<div id="cart_min_price">Minimálna výška objednávky je <price>{{App\Setting::whereName('min_order_price')->first()->value }}</price>&euro;</div>
	<div id="cart_free_shipping_price" data-price="{{App\Setting::whereName('min_free_shipping_price')->first()->value }}">Už len <price></price>&euro; a máte dopravu zdarma</div>
		@endif
