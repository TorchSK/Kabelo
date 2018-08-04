<div class="ui sidebar inverted vertical top menu" id="catbar">
	@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    <a class="item" href="/category/{{$category->url}}">
     <text>{{$category->name}}</text>
     <count>{{$categoryCounts['categories'][$category->id]}}</count>
    </a>

    		@foreach ($category->children->sortBy('order') as $child)
    		    <a class="item sub" href="/category/{{$child->url}}">
    			 <text>{{$child->name}}</text>
    			 <count>{{$categoryCounts['categories'][$child->id]}}</count>
    			</a>

    		@endforeach

    @endforeach
  </div>