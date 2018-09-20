<div class="ui right sidebar inverted vertical menu" id="sidebar">
    <a class="header right aligned item close_btn"><i class="chevron left icon"></i>Close</a>

  @if (Auth::check())
    <a href="/settings/account" class="item"><i class="user icon"></i> Nastavenia účtu</a>
    <a href="/orders/mine" class="item"><i class="history icon"></i> História objednávok</a>
    @if(Auth::check() && Auth::user()->admin)
    <a href="{{route('admin.dashboard.new')}}" class="item"><i class="setting icon"></i> Administrácia</a>
    @endif
 
    <a href="/logout" class="item"><i class="power icon"></i> Odhlásiť</a>
    @endif

  
</div>