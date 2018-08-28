<div id="filterbar_h">

    @foreach(App\Category::orderBy('order')->get()->toTree() as $category)

    	<div class="item">{{$category->name}}</div>
	@endforeach
</div>