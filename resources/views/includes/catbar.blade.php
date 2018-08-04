<div class="ui sidebar inverted vertical menu" id="catbar">
	@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    <a class="item" href="/category/{{$category->url}}">
     {{$category->name}}
    </a>

    		@foreach ($category->children->sortBy('order') as $child)
    		    <a class="item sub" href="/category/{{$child->url}}">
    			 {{$child->name}}
    			</a>
    		@endforeach

    @endforeach
  </div>