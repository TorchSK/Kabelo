<div class="ui mini modal" id="add_category_modal">

<div class="header">
Pridaj kategóriu
</div>
<div class="content">

	<div class="label">Nadradená kategória</div>

  <div class="ui fluid selection dropdown" id="add_category_parent_input">

    <input type="hidden" name="parent_id" @if (isset($category)) value="{{$category->id}}" @endif>
    <i class="dropdown icon"></i>

    @if (isset($category))
    <div class="text">{{$category->name}}</div>
    @else
    <div class="default text">Vyberte kategóriu</div>
    @endif

    <div class="menu">
      @foreach (App\Category::whereNull('parent_id')->orderBy('order','asc')->get() as $cat)
      	<div class="item @if(isset($category) && $cat->id == $category->id) active selected @endif" data-value="{{$cat->id}}">
            <span class="text">{{$cat->name}}</span>
        </div>

        @if($cat->children->count() > 0)
          @foreach($cat->children as $sub1)
            <div class="sub item" data-value="{{$sub1->id}}">{{$sub1->name}}</div>

                 @if($sub1->children->count() > 0)
                  @foreach($sub1->children as $sub2)
                    <div class="sub2 item" data-value="{{$sub2->id}}">{{$sub2->name}}</div>
                  @endforeach
                @endif
          @endforeach
        @endif

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