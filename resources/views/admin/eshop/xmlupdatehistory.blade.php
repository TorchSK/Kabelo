@extends('layouts.admin')
@section('content')

    <div id="admin_xmlupdate_wrapper" class="admin_wrapper">
		
		<div class="ui accordion">
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
				    <p class="transition hidden">
				    	@if(is_array($content->log) && count($content->log) > 0)
					    	@foreach($content->log as $item)
					    		{{$item['id']}}
					    	@endforeach
				    	@endif
				    </p>
			  @endforeach

			</div>

		  @endforeach
		</div>

    </div>

@stop
