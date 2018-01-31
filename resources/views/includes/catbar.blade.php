<div class="ui top sidebar inverted vertical menu" id="catbar">
    <a class="header right aligned item close_btn"><i class="chevron left icon"></i>Close</a>

    <div class="categories">
		    @foreach(App\Category::all() as $category)
		    <div class="item filter" data-filter="category" data-value="{{$category->id}}" data-categoryid="{{$category->id}}">
		        <text>{{$category->name}}</text>
		        <count>{{$category->products->count()}}</count>
		    </div>
		    @endforeach
	  </div>


  
</div>