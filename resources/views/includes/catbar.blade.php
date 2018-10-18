<div class="ui sidebar inverted vertical top menu" id="catbar">
	@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    <a class="item" href="{{route('slug',['category'=>$category->full_url])}}">
     <text>{{$category->name}}</text>
     <count>{{$categoryCounts['categories'][$category->id]}}</count>
    </a>

    		@foreach ($category->children->sortBy('order') as $child)
    		    <a class="item sub" href="{{route('slug',['category'=>$child->full_url])}}">
    			 <text>{{$child->name}}</text>
    			 <count>{{$categoryCounts['categories'][$child->id]}}</count>
    			</a>

    		@endforeach

    @endforeach
  </div>