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
				@if($activecategory->children->count() == 0)
					<div class="caption">{{$activecategory->name}}<a href="/admin/category/{{$activecategory->url}}" data-tooltip="Administrácia"><i class="setting teal icon"></i></a>
					</div>
					            <div class="ui horizontal divider active title"></i>Parametre</div>

					<div class="list">
						@include('params.all',['category'=>$activecategory])
					</div>
				@else
					<div class="c_header">
						<div>Na nadradenú kategóriu nie je možné zadať parameter. Prosim zadajte parameter až na poslednú úroveň kategórií.</div>
					</div>
				@endif

			@else
					<div>
					@include('params.all',['manage'=>true])
					</div>
					
					<div class="ui green button" id="add_param_btn">Nový parameter</div>

			@endif
		</div>		

	
	</div>

	@include('modals.newparam')
	@include('modals.editparam')

@stop