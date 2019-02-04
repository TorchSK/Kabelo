<div id="filterbar" class="horizontal" data-item="filterbar_wrapper">
	<div class="container" data-item="filterbar_container">
    @foreach(App\Category::where('active',1)->orderBy('order')->get()->toTree()->take(5) as $category)

    	<a href="{{route('slug',['category'=>$category->full_url])}}" class="item top @if(isset($requestCategory) && ($category->id == $requestCategory->id || in_array($category->id,$requestCategory->ancestors->pluck('id')->toArray()))) active @endif" data-cat="{{$category->id}}">
    		@if(App\Setting::firstOrCreate(['name'=>'filterbar_image'])->value == 1)
    		<div class="image_div">
    			<img src="{{url($category->image)}}" alt="{{$category->name}}"/>
    		</div>
    		@endif
    		<name>{{$category->name}}</name>
    	</a>

    	<div class="ui fluid basic popup bottom left transition hidden" id="cat_popup_{{$category->id}}">

    		<div class="subcats">
			@foreach($category->children as $child)
				<div class="sub1">
					<a href="{{route('slug',['category'=>$child->full_url])}}" class="name">{{$child->name}}</a>
							@foreach($child->children as $child2)
								<div class="sub2">
									<a href="{{route('slug',['category'=>$child2->full_url])}}" class="name">{{$child2->name}}</a>
								</div>
							@endforeach	
				</div>
			@endforeach	

			<div class="sub1">
					<img src="/img/menu_{{$category->url}}.png" alt="{{$category->name}}" />
			</div>

			</div>

		</div>

	@endforeach

</div>
</div>
