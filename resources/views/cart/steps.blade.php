<div id="order_steps_wrapper" class="wrapper">
    <div class="container">
  <div class="ui ordered fluid steps" id="order_steps">
    <a class="@if($step==1)active @endif @if($step==2 || $step==3 || $step==4)completed @endif step" @if($step==1)active @endif @if($step==2 || $step==3 || $step==4) href="/cart/products" @endif>
      <div class="content">
        <div class="title">Produkty</div>
        <div class="description">Skontrolte obsah Vášho košíku</div>
      </div>
    </a>
    <a class="@if($step==2)active @endif @if($step==3 || $step==4)completed @endif step" @if($step==3 || $step==4) href="/cart/delivery" @endif>
      <div class="content">
        <div class="title">Doprava a platba</div>
        <div class="description">Zadajte dopravu a sposob platby</div>
      </div>
    </a>
    <a class="@if($step==3)active @endif @if($step==4)completed @endif step"  @if($step==4) href="/cart/shipping" @endif>
      <div class="content">
        <div class="title">Dodacie údaje</div>
        <div class="description">Zadajte adresu doručenia</div>
      </div>
    </a>
    <a class="@if($step==4)active @endif step">
      <div class="content">
        <div class="title">Potvrdenie</div>
        <div class="description">Potvrdenie objednávky</div>
      </div>
    </a>
  </div>
  </div>
</div>