<div id="filterbar_h">

    @foreach(App\Category::orderBy('order')->get()->toTree() as $category)

    	<a href="{{route('home.category',['category'=>$category->url])}}" class="item" data-cat="{{$category->id}}">{{$category->name}}</a>

    	<div class="ui fluid basic popup bottom left transition hidden" id="cat_popup_{{$category->id}}">

    		<div class="subcats">
			@foreach($category->children as $child)
				<div class="sub1">
					<a href="{{route('home.category',['category'=>$child->url])}}" class="name">{{$child->name}}</a>
							@foreach($child->children as $child2)
								<div class="sub2">
									<a href="{{route('home.category',['category'=>$child2->url])}}" class="name">{{$child2->name}}</a>
								</div>
							@endforeach	
				</div>
			@endforeach	
			</div>

		</div>

	@endforeach




</div>
