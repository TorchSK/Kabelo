<form method="POST" class="text_form" action="/text/{{$text->id}}" data-textid="{{$text->id}}">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT" />
	

	@if(isset($editable) && $editable==true)
    <div class="ui fluid labeled input attribute" data-attribute="name">
        <div class="ui label">Názov</div>
        <input type="text" name="name" value="{{$text->name}}" />
    </div>
    @endif
    

	<div class="richtext @if(isset($editable) && $editable==true) editable @endif">
		{!! $text->text !!}
	</div>
</form>