<ul class="categories">
    @foreach(App\Category::with('children','descendants')->whereNull('parent_id')->orderBy('order')->get() as $category)
        @include('categories.row', ['requestCategory'=> App\Category::find(Request::get('category'))])
    @endforeach
</ul>