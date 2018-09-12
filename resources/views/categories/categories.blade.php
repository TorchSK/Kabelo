<ul class="categories">
    @foreach($categories->where('active',1) as $category)
        @include('categories.row', ['requestCategory'=> App\Category::find(Request::get('category'))])
    @endforeach
</ul>