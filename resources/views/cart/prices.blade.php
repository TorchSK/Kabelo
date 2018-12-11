<div id="cart_prices_wrapper" class="wrapper">
	<div class="container">
@if(Auth::check())
<div id="cart_user_discount" @if(Auth::user()->discount==0) class="hidden" @endif>Vaša zľava: <price>{{Auth::user()->discount}}</price> <symbol>%</symbol></div>
@else
<div id="cart_user_discount" class="hidden">Vaša zľava: <price>0</price> <symbol>%</symbol></div>
@endif

@if($appname=="kabelo")
<div id="cart_without_vat_price">Cena bez dph: <price></price> <symbol>{{ round($cart['price'] / (1 + App\Setting::firstOrCreate(['name'=>'vat'])->value/100),2)}} &euro;</symbol></div>
<div id="cart_vat">DPH: <price></price> <symbol>{{$cart['price'] - round($cart['price']/(1 + App\Setting::firstOrCreate(['name'=>'vat'])->value/100),2)}} &euro;</symbol></div>
@endif

<div id="cart_total_price">Celková cena: <price></price> <symbol>{{$cart['price']}} &euro;</symbol></div>

@if(App\Setting::firstOrCreate(['name'=>'min_order_price'])->value > 0)
<div id="cart_min_price">Minimálna výška objednávky je <price>{{App\Setting::firstOrCreate(['name'=>'min_order_price'])->value }}</price>&euro;</div>
@endif

@if($cart['price'] < App\Setting::firstOrCreate(['name'=>'min_free_shipping_price'])->value)
<div id="cart_free_shipping_price" data-price="{{App\Setting::firstOrCreate(['name'=>'min_free_shipping_price'])->value }}">Už len <price>{{round(App\Setting::firstOrCreate(['name'=>'min_free_shipping_price'])->value - $cart['price'],2)}}</price>&euro; a máte dopravu zdarma</div>
@endif
</div>
</div>
