<div class="ui top sidebar inverted vertical menu" id="catbar">
    <a class="header right aligned item close_btn"><i class="chevron left icon"></i>Close</a>

    <div class="categories">
    @foreach(App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
		    <a href="/{{$category->url}}" class="item filter" data-filter="category" data-value="{{$category->id}}" data-categoryid="{{$category->id}}">
		        <text>{{$category->name}}</text>
		        <count>{{$category->products->count()}}</count>
		    </a>
		    @endforeach
	  </div>


  
</div>