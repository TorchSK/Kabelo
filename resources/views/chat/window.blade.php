<div class="chat_window" data-user="{{$user}}">
  <div class="box">
    <div class="icon"><i class="user circle icon"></i></div>
    <div class="msgs">
      <div class="msg @if(auth()->check() && auth()->user()->admin) own @endif">Dobrý deň, s čím Vám možeme pomocť?</div>
    </div>
    <div class="ui fluid input"><input type="text" id="msg_input" placeholder="Napíšte nám čo Vás trápi" /></div>
  </div>
</div>