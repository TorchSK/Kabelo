<div class="ui fluid steps">
  <a class="step cart_delivery {{$context}} @if ($cart['delivery_method']==$delivery->id) completed active @endif" data-delivery_method="{{$delivery->id}}" data-id="{{$delivery->id}}" data-type="delivery" @if($cart['price'] < App\Setting::whereName('min_free_shipping_price')->first()->value) data-price="{{$delivery->price}}" @else data-price="0" @endif data-note="{{$delivery->note}}">
    <i class="{{$delivery->icon}} icon"></i>
    <div class="content">
      <div class="title">{{$delivery->name}}</div>
      <div class="description">{{$delivery->desc}}</div>
    </div>
   	<div class="price">@if(App\Setting::whereName('min_free_shipping_price')->first()->value==0 || $cart['price'] < App\Setting::whereName('min_free_shipping_price')->first()->value){{$delivery->price}}@else 0 @endif &euro;</div>

	  @if($context=='admin')
	  	<div class="options">
	  		<icons>	  			
	  			<i class="big teal edit icon"></i>
	  			<i class="big red delete icon"></i>
	  		</icons>
	  	</div>
	  @endif

  </a>


</div>