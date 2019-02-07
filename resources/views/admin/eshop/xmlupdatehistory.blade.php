@extends('layouts.admin')
@section('content')

<div id="admin_xmlupdate_wrapper" class="admin_wrapper">
		
		<div class="ui fluid styled accordion">
			@foreach(App\Log::groupBy('created_at')->get(['created_at']) as $log)
		  		<div class="title">
				    <i class="dropdown icon"></i>
				    {{$log->created_at->format('d.m.Y h:m')}} - 

				    @if($log->type="product_update")
				    	Aktualizácia produktov
				    @endif
		  		</div>

		  		<div class="content">

			  	@foreach(App\Log::whereType($log->type)->whereCreatedAt($log->created_at)->get() as $content)
			  		<div class="accordion">
			  			<div class="title">
						    <i class="dropdown icon"></i>
						    @if($content->operation=='new_categories')
						    Pridané kategórie ({{collect($content->log)->count()}})
						    @endif
						    @if($content->operation=='new_products')
						    Pridané produkty ({{collect($content->log)->count()}})
						    @endif						   
						    @if($content->operation=='removed_products')
						    Zneaktivnené produkty ({{collect($content->log)->count()}})
						    @endif
				  		</div>

				  		<div class="content">
						    	@if(is_array($content->log) && count($content->log) > 0)
							    	@foreach($content->log as $item)
							    		<div class="item">
							    			<div class="id">{{$item['id']}}</div>
							    			@if(isset($item['code']) && App\File::where('product_id',$item['id'])->count() > 0)
							    			<div class="image"><img src="{{App\File::where('product_id',$item['id'])->first()->path}}" /></div>
							    			@endif
							    			@if(isset($item['code']))
							    			<div class="code">{{$item['code']}}</div>
							    			@endif
							    			<div class="name">{{$item['name']}}</div>

							    		</div>
							    	@endforeach
						    	@endif
						</div>
			 	@endforeach
			 </div>

			</div>

		  @endforeach
		</div>
</div>



@stop
