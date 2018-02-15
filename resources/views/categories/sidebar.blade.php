<div class="categories accordion">
    @foreach(App\Category::whereNull('parent_id')->get() as $category)
        @include('categories.row')
    @endforeach
</div>