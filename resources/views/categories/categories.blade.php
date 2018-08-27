<ul class="categories">
    @foreach(App\Category::whereNull('parent_id')->with('children','children.children','children.children.children','children.children.children.children','children.children','descendants')->orderBy('order')->get() as $category)
        @include('categories.row', ['requestCategory'=> App\Category::find(Request::get('category'))])
    @endforeach
</ul>