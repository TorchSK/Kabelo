<div class="ui mini modal" id="edit_param_modal" data-paramid="{{$param->id}}">

<div class="header">
Pridaj parameter
</div>

<div class="content">

    <div class="label">Kód</div>

  <div class="ui fluid input">
    <input type="text"  name="key" value="{{$param->key}}"/>
  </div>



  <div class="label">Zobrazenie</div>

  <div class="ui fluid input">
    <input type="text" name="display_key" value="{{$param->display_key}}"/>
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