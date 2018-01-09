<div class="status">
<div class="ui ordered steps">
  <a class="@if($step==1)active @endif @if($step==2)completed @endif step">
    <div class="content">
      <div class="title">Produkty</div>
      <div class="description">Skontrolte obsah Vášho košíku</div>
    </div>
  </a>
  <div class="@if($step==2)active @endif step">
    <div class="content">
      <div class="title">Doprava a platba</div>
      <div class="description">Zadajte dopravu a sposob platby</div>
    </div>
  </div>
  <div class="@if($step==3)active @endif step">
    <div class="content">
      <div class="title">Dodacie údaje</div>
      <div class="description">Zadajte adresu doručenia</div>
    </div>
  </div>
  <div class="@if($step==4)active @endif step">
    <div class="content">
      <div class="title">Potvrdenie</div>
      <div class="description">Potvrdenie objednávky</div>
    </div>
  </div>
</div>
</div>