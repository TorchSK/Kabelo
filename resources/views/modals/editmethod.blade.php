<div class="ui mini modal" id="edit_method_modal">

<div class="header">
Zmeň
</div>

<div class="content">


    <div class="label">Názov</div>

  <div class="ui fluid input">
    <input type="text" placeholder="Názov" id="edit_method_name_input" />
  </div>

  <div class="label">Popis</div>

  <div class="ui fluid input">
    <input type="text" placeholder="Popis" id="edit_method_desc_input" />
  </div>

    <div class="label">Cena</div>

  <div class="ui fluid input">
    <input type="text" placeholder="Popis" id="edit_method_price_input" />
  </div>

<div class="ui form">
  <div class="field">
    <label>Poznámka</label>
    <textarea id="edit_method_note_input"></textarea>
  </div>
</div>

  <div class="label">Ikona</div>

  <div class="ui selection big dropdown edit">
    <input type="hidden" name="gender">
    <i class="dropdown icon"></i>
    <div class="default text">Ikona</div>
    <div class="menu">
      <div class="item" data-value="money"><i class="big icon money"></i></div>
      <div class="item" data-value="user"><i class="big icon user"></i></div>
      <div class="item" data-value="truck"><i class="big icon truck"></i></div>
      <div class="item" data-value="motorcycle"><i class="big icon motorcycle"></i></div>

    </div>
  </div>

  </div>

<div class="actions">
<div class="ui black deny button">
  Zruš
</div>
<div class="ui positive right labeled icon button">
  Zmeň
  <i class="checkmark icon"></i>
</div>
</div>
</div>