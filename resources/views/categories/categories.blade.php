<ul class="categories">
    @foreach(App\Category::with('descendants')->get()->toTree() as $category)
        @include('categories.row', ['requestCategory'=> App\Category::find(Request::get('category'))])
    @endforeach
</ul>