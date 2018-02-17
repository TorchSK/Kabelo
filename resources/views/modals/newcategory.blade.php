<div class="ui mini modal" id="add_category_modal">

<div class="header">
Pridaj kategóriu
</div>
<div class="content">

	<div class="label">Nadradená kategória</div>
    <div class="ui fluid selection dropdown" id="add_category_parent_input">
  <input type="hidden" name="parent_id" value="">
  <i class="dropdown icon"></i>
  <div class="default text">Vyberte kategóriu</div>
  <div class="menu">
    @foreach (App\Category::orderBy('order','asc')->get() as $category)
    	<div class="item" data-value="{{$category->id}}">{{$category->name}}</div>
    @endforeach
  </div>
</div>

	<div class="label">Názov</div>

<div class="ui fluid input">
	<input type="text" placeholder="Názov" id="add_category_input"/>
</div>
</div>

<div class="actions">
<div class="ui black deny button">
  Zruš
</div>
<div class="ui positive right labeled icon button">
  Pridaj
  <i class="checkmark icon"></i>
</div>
</div>
</div>