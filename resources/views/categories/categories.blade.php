<ul class="categories">
    @foreach(App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
        @include('categories.row')
    @endforeach
</ul>