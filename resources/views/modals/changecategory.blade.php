<div class="ui modal" id="bulk_change_category_modal">

<div class="header">
Zmeň kategóriu
</div>

<div class="content">

  <div class="label">Pre produkty:</div>
  <div class="product_list"></div>

	<select multiple="true" name="categories[]" id="bulk_change_category_dropdown" class="ui fluid search dropdown filter_item category">
	    <option value="">Kategória</option>

	    @foreach (App\Category::whereActive(1)->orderBy('order','asc')->get() as $category)
		    <option value="{{$category->id}}">
		    	@if($category->parent)
		  		{{$category->parent->name}} - 
		      	@endif
		      	{{$category->name}}
		    </option>
		    @endforeach
    </select>

</div>


<div class="actions">
<div class="ui black deny button">
  Zruš
</div>
<div class="ui positive right labeled icon button">
  Vyber
  <i class="checkmark icon"></i>
</div>
</div>
</div>