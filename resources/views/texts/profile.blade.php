<form method="POST" class="text_form" action="/text/{{$text->id}}" data-textid="{{$text->id}}">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT" />
	

	@if(isset($editable) && $editable==true)
    <div class="ui fluid labeled input attribute" data-attribute="name">
        <div class="ui label">Názov</div>
        <input type="text" name="name" value="{{$text->name}}" />
    </div>
    
    <div class="text_save_btn ui green button" data-id="{{$text->id}}">Ulož</div>
    @endif

    <div class="text_files_list">
    	@foreach(App\File::where('type','system')->get() as $file)
    	<div class="item" data-content="{{$file->path}}">
    		<div class="image">
    			@if(pathinfo($file->path,PATHINFO_EXTENSION)=='jpg')
    				<img src="{{url($file->path)}}" />
    			@else
    				<i class="file outline big icon"></i>
    			@endif
    		</div>
    		<div class="name">{{basename($file->path)}}</div>
    	</div>
    	@endforeach
    </div>

	<div class="richtext @if(isset($editable) && $editable==true) editable @endif" id="mce">
		{!! $text->text !!}
	</div>
</form>