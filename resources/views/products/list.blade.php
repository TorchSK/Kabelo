@foreach($products as $product)
	@include('products.row',['grid'=>1])
@endforeach

<div id="grid_div">
	<div class="column"></div>
    <div class="column"><div class="ui large blue button view_more_button">Viac produktov</div></div>
    <div class="column">
    <a href="{{ $products->appends(['sortBy' => $sortBy, 'sortOrder' => $sortOrder, 'category'=>$category->id])->nextPageUrl()}}" id="next_page" data-next="{{$products->hasMorePages()}}"></a>
    {{ $products->links() }}
	</div>

</div>

