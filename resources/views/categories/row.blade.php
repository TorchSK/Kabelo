<div class="category title item @if(Request::get('category') == $category->id || in_array(Request::get('category'), (array)$category->children->pluck('id')->toArray())) selected @endif @if($category->parent_id) sub @endif">

    <div href="?category={{$category->id}}" class="filter" data-filter="category" data-value="{{$category->id}}" data-categoryid="{{$category->id}}">
        <i class="dropdown icon"></i>
        <text>{{$category->name}}</text>
        <count>{{$category->products->count()}}</count>
    </div>

</div>

<div class="content">
@foreach($category->children as $child)
    @include('categories.row',['category'=>$child])
@endforeach
</div>