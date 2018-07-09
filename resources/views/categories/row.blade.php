<li class="category title item @if(Request::has('category') && App\Category::find(Request::get('category'))->parent && App\Category::find(Request::get('category'))->parent->parent_id == $category->id) active @endif @if(Request::get('category') == $category->id) selected @endif @if(Request::get('category') == $category->id || in_array(Request::get('category'), (array)$category->children->pluck('id')->toArray())) active @endif @if($category->parent_id) sub @endif" data-filter="category" data-value="{{$category->id}}" data-categoryid="{{$category->id}}">
   
    <div class="caption title">
    @if($category->children->count() > 0) 
        <i class="@if(Request::has('category') && (Request::get('category') == $category->id || (App\Category::find(Request::get('category'))->parent && App\Category::find(Request::get('category'))->parent->parent_id == $category->id) || in_array(Request::get('category'), (array)$category->children->pluck('id')->toArray()))) minus @else plus @endif square outline icon"></i>
        @else
        <i class="cube icon"></i>
    @endif

    @if (Request::segment(1)=='admin')
    <a href="{{route('admin.category',['category'=>$category->url])}}" class="filter">
    @else
    <a href="/category/{{$category->url}}" class="filter">
    @endif

        <text>{{$category->name}}</text>
        <count>{{$categoryCounts['categories'][$category->id]}}</count>
    </a>
    </div>

    <ul class="content  @if(Request::has('category')  && (Request::get('category') == $category->id || in_array(Request::get('category'), (array)$category->children->pluck('id')->toArray()))) active @endif @if(Request::has('category') && App\Category::find(Request::get('category'))->parent&& App\Category::find(Request::get('category'))->parent->parent_id == $category->id) active @endif">

        @foreach($category->children->sortBy('order') as $child)
            @include('categories.row',['category'=>$child])
        @endforeach


    </ul>

</li>
