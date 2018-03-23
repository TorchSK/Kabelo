@extends('layouts.admin')
@section('content')


    @include('admin.sidebar')

<div class="admin_right">

	<div class="tabbs">

	  <div class="tabs">
	    <div class="tabb ui button blue selected" data-tab="categories">Všetky kategórie</div>
	   	<div class="tabb ui button basic" data-tab="news">Všetky novinky</div>
	    <div class="tabb ui button basic" data-tab="sales">Všetky zľavy</div>
	  </div>

	  <div class="contents">
	  	<div class="content active" data-tab="categories">

		<ul class="admin_categories_list">
		@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
    	<li class="item category @if($category->parent_id) sub @endif" data-id={{$category->id}}>
			<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$category->name}}</a>
			<div class="no_of_items">produktov: {{$categoryCounts['categories'][$category->id] }}</div>


			<a class="admin_delete_category_btn ui red label">Zmaž</a>
			<a href="/category/{{$category->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

		</li>

		@foreach ($category->children->sortBy('order') as $child)
	    	<li class="item category @if($child->parent_id) sub @endif" data-id={{$category->id}}>
				<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$child->name}}</a>
				<div class="no_of_items">produktov: {{$categoryCounts['categories'][$child->id]}}</div>


				<a class="admin_delete_category_btn ui red label">Zmaž</a>
				<a href="/category/{{$child->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

					@foreach ($child->children->sortBy('order') as $child2)
				    	<li class="item category @if($child->parent_id) sub2 @endif" data-id={{$category->id}}>
							<a class="name" href="{{route('admin.category',['category'=>$category->url])}}">{{$child2->name}}</a>
							<div class="no_of_items">produktov: {{$categoryCounts['categories'][$child2->id]}}</div>


							<a class="admin_delete_category_btn ui red label">Zmaž</a>
							<a href="/category/{{$category->id}}/edit" class="admin_edit_category_btn ui brown label">Zmeň</a>

						</li>
					@endforeach
			</li>
		@endforeach
		@endforeach
		</ul>

		</div>

		<div class="content" data-tab="news">

			<table class="ui celled selectable unstackable sortable table" id="new_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereNew('1')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui product new search">
						  <input class="prompt" type="text" placeholder="Pridaj produkt">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

		</div>

		<div class="content" data-tab="sales">

			<table class="ui celled selectable unstackable sortable table" id="sale_product_table">
			  <thead>
			    <tr>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereSale('1')->get() as $product)
				<tr data-id="{{$product->id}}">
			      <td>{{$product->id}}</td>
			      <td>{{$product->name}}</td>
			      <td class="collapsing"><a class="ui mini icon red button"><i class="delete large icon"></i></a></td>
			  	</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<div class="ui product sale search">
						  <input class="prompt" type="text" placeholder="Pridaj produkt">
						  <div class="results"></div>
						</div>
					</td>
				</tr>
			  </tbody>
			</table>

		</div>
	</div>
</div>
</div>
@stop