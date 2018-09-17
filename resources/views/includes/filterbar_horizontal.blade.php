<div id="filterbar_h">

    @foreach(App\Category::orderBy('order')->get()->toTree() as $category)

    	<a href="{{route('home.category',['category'=>$category->url])}}" class="item" data-cat="{{$category->id}}">{{$category->name}}</a>

    	<div class="ui fluid basic popup bottom left transition hidden" id="cat_popup_{{$category->id}}">

			@foreach($category->children as $child)
				<div>{{$child->name}}</div>
			@endforeach

		</div>

	@endforeach




</div>
