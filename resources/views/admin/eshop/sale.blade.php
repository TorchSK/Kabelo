@extends('layouts.admin')
@section('content')

    <div id="admin_sale_wrapper" class="admin_wrapper">
		<div class="content" data-tab="inactive">

			<table class="ui celled selectable unstackable sortable table" id="sale_product_table">
			  <thead>
			    <tr>
			    <th></th>
			    <th>Carousel</th>
			    <th>ID</th>
			    <th>Názov</th>
			    <th>Zmazať</th>
			  </tr></thead>
			  <tbody>
			  	@foreach(App\Product::whereSale('1')->orderBy('sale_order')->get() as $product)
				<tr data-id="{{$product->id}}">
				  <td class="collapsing"><i class="content icon"></i></td>
				  <td class="collapsing"><div class="ui checkbox"><input type="checkbox" name="sale_carousel" @if($product->new_carousel)checked @endif></div></td>
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
@stop
