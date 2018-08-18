<div class="ui sidebar inverted vertical top menu" id="catbar">
	@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    <a class="item" href="/category/{{$category->url}}">
     <text>{{$category->name}}</text>
             @if (env('DB_DATABASE_KABELO')=='kabelo')

     <count>{{$categoryCounts['categories'][$category->id]}}</count>
     @endif
    </a>

    		@foreach ($category->children->sortBy('order') as $child)
    		    <a class="item sub" href="/category/{{$child->url}}">
    			 <text>{{$child->name}}</text>
            @if (env('DB_DATABASE_KABELO')=='kabelo')
    			 <count>{{$categoryCounts['categories'][$child->id]}}</count>
           @endif
    			</a>

    		@endforeach

    @endforeach
  </div>