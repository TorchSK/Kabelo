<div class="chat_window" data-user="{{$user}}">
  <div class="box">
    <div class="header">
    	<div></div>
    	<div><i class="user circle icon"></i></div>
    	<div><i class="delete icon"></i></div>

    </div>
    <div class="msgs">
      <div class="msg @if(auth()->check() && auth()->user()->admin) own @endif">Dobrý deň, s čím Vám možeme pomocť?</div>
    </div>
    <div class="ui fluid input"><input type="text" class="msg_input" placeholder="Napíšte nám čo Vás trápi" /></div>
  </div>
</div>