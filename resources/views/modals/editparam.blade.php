<div class="ui mini modal" id="edit_param_modal" @if(isset($param))data-paramid="{{$param->id}}" @endif>

<div class="header">
Pridaj parameter
</div>

<div class="content">

    <div class="label">Kód</div>

  <div class="ui fluid input">
    <input type="text"  name="key" @if(isset($param))value="{{$param->key}}"  @endif/ >
  </div>



  <div class="label">Zobrazenie</div>

  <div class="ui fluid input">
    <input type="text" name="display_key" @if(isset($param))value="{{$param->display_key}}"  @endif/>
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