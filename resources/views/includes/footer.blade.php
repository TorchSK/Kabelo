<footer>

	<div class="column">
		 <a class="logo item" href="/">
          <img src="/img/logo.png" width="36"/>
          <text>Kabelo.sk</text>
        </a>

	</div>

  <div class="stretch">
	<div class="column"><a href="#" class="effect-1">Obchodné podmienky</a></div>
	<div class="column"><a href="#" class="effect-1">O spoločnosti</a></div>
  <div class="column"><a href="#" class="effect-1">Kontakt</a></div>
  </div>

	<div class="column social">
		<a href="https://www.facebook.com/kabeloshop/" target="_blank"><i class="facebook square icon"></i></a>
		<a href="/" target="_blank"><i class="twitter square icon"></i></a>
		<a href="/" target="_blank"><i class="instagram square icon"></i></a>
   <div id="td">Made by &copy; <a class="effect-1" href="mailto:jan.krnac@seznam.cz" target="_top">Ján Krnáč</a></div>
	</div> 

    @if (!Auth::guest() && !Auth::user()->cookies)  
  <div id="cookies_msg">Tento web používa súbory cookies. Prehliadaním webu vyjadrujete súhlas s ich používaním. <a href="/cookies/info">Viac informácií.</a><i class="delete icon" data-user_id="{{Auth::user()->id}}"></i></div>
  @endif  

</footer>	













<div class="ui mini modal" id="delete_cart_modal">
				  
  <div class="header">
    Košík
  </div>
  <div class="content">
     Naozaj chcete vymazať košík
  </div>
  <div class="actions">
    <div class="ui red deny button">
      Níe
    </div>
    <div class="ui positive right labeled icon button">
      Áno
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>


  <div class="ui mini modal" id="delete_product_modal">
            
    <div class="header">
      Zmazať produkt
    </div>
    <div class="content">
       Naozaj chcete vymazať produkt
    </div>
    <div class="actions">
      <div class="ui red deny button">
        Níe
      </div>
      <div class="ui positive right labeled icon button">
        Áno
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>


  <div class="ui mini modal" id="delete_cover_modal">
            
    <div class="header">
      Zmazať banner
    </div>
    <div class="content">
       Naozaj chcete vymazať bannner
    </div>
    <div class="actions">
      <div class="ui red deny button">
        Níe
      </div>
      <div class="ui positive right labeled icon button">
        Áno
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>



  <div class="ui mini modal" id="delete_category_modal">
            
    <div class="header">
      Zmazať kategóriu
    </div>
    <div class="content">
       Naozaj chcete vymazať kategóriu
    </div>
    <div class="actions">
      <div class="ui red deny button">
        Níe
      </div>
      <div class="ui positive right labeled icon button">
        Áno
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>

    <div class="ui mini modal" id="delete_param_modal">
            
    <div class="header">
      Zmazať parameter
    </div>
    <div class="content">
       Naozaj chcete vymazať parameter
    </div>
    <div class="actions">
      <div class="ui red deny button">
        Níe
      </div>
      <div class="ui positive right labeled icon button">
        Áno
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>



  <div class="ui mini modal" id="new_rating_modal">
            
    <div class="header">
      Pridať hodnotienie
    </div>
    <div class="content">
       <div class="ui form">
        <h4 class="ui dividing header">Napíšte krátky komentár</h4>
        <div class="field">
          <label>Komentár</label>
          <textarea name="text"></textarea>
        </div>
        </div>
      </div>
    <div class="actions">
      <div class="ui red deny button">
        Storno
      </div>
      <div class="ui positive right labeled icon button">
        OK
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>