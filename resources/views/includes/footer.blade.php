<footer>
	<div class="column">
		 <a class="logo item" href="/">
          <img src="/img/logo.png" width="36"/>
          <text>Kabelo.sk</text>
        </a>

	</div>
	<div class="column"></div>
	<div class="column"></div>
	<div class="column social">
		<i class="facebook square icon"></i>
		<i class="twitter square icon"></i>
		<i class="instagram square icon"></i>

	</div>

    @if (!Auth::user()->cookies)  
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


  <div class="ui mini modal" id="new_rating_modal">
            
    <div class="header">
      Pridať hodnotienie
    </div>
    <div class="content">
       <div class="ui form">
        <h4 class="ui dividing header">Napíšte krátky komentár</h4>
        <div class="field">
          <label>Komentár</label>
          <textarea></textarea>
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