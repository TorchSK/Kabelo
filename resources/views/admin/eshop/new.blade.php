@extends('layouts.admin')
@section('content')

    <div id="admin_new_wrapper" class="admin_wrapper">

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
	</div>
@stop
