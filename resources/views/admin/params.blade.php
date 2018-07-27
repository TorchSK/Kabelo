@extends('layouts.admin')
@section('content')
	
	<div id="admin_params">


		<ul id="categories">

			<li class="ui blue fluid button">
				<a href="/admin/params">Parametre</a>
			</li>

			@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
			    	<li class="item category @if($category->parent_id) sub @endif" data-id={{$category->id}}>
						<a href="/admin/params/category/{{$category->id}}">{{$category->name}}</a>
					</li>

					@foreach ($category->children->sortBy('order') as $child)
				    	<li class="item category @if($child->parent_id) sub @endif" data-id={{$child->id}}>
							<a href="/admin/params/category/{{$child->id}}">{{$child->name}}</a>

								@foreach ($child->children->sortBy('order') as $child2)
							    	<li class="item category @if($child->parent_id) sub2 @endif" data-id={{$child2->id}}>
										<a href="/admin/params/category/{{$child2->id}}">{{$child2->name}}</a>
									</li>
								@endforeach
						</li>
					@endforeach
			@endforeach
		</ul>

		<div id="params_list">
			@if (isset($activecategory))
				<div class="caption">{{$activecategory->name}}</div>
				<div class="list">
					@include('params.all',['category'=>$activecategory])
				</div>
					    			<div class="ui green button" id="add_param_btn">Nový parameter</div>

			@else
					@include('params.all',['manage'=>true])
			@endif
		</div>		

	
	</div>

	@include('modals.newparam')
	@include('modals.editparam')

@stop