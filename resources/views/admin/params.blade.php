@extends('layouts.admin')
@section('content')
	
	<div id="admin_params">
		<ul id="categories">

			@foreach (App\Category::whereNull('parent_id')->orderBy('order')->get() as $category)
			    	<li class="item category @if($category->parent_id) sub @endif" data-id={{$category->id}}>
						<a href="/admin/params/category/{{$category->id}}">{{$category->name}}</a>
					</li>

					@foreach ($category->children->sortBy('order') as $child)
				    	<li class="item category @if($child->parent_id) sub @endif" data-id={{$child->id}}>
							{{$child->name}}

								@foreach ($child->children->sortBy('order') as $child2)
							    	<li class="item category @if($child->parent_id) sub2 @endif" data-id={{$child2->id}}>
										{{$child2->name}}
									</li>
								@endforeach
						</li>
					@endforeach
			@endforeach
		</ul>

		<div id="active_params">
			@if (isset($activecategory))
				<div class="caption">{{$activecategory->name}}</div>
				<div class="list">


				</div>
			@endif
		</div>		

	    <div id="all_params">
	    	@foreach(App\Parameter::all() as $param)

	    		<div class="arrow"><i class="icon large brown chevron left"></i></div>
	    		<div class="param item" data-paramid="{{$param->id}}">
	    			<div class="name">
	    				<div><i class="key icon"></i> {{$param->key}}</div> 
	    			    <div><i class="eye icon"></i> {{$param->display_key}}</div>
	    			   </div>
	    			<div class="actions"><i class="edit large icon edit_param_btn"></i><i class="delete large icon delete_param_btn"></i></div>

	    		</div>
	    	@endforeach

	    	<div class="ui green fluid button" id="add_param_btn">Nový parameter</div>
		</div>
	
	</div>

	@include('modals.newparam')
	@include('modals.editparam')

@stop