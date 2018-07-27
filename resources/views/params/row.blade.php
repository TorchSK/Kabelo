<div class="param item @if(isset($category) && $category->parameters->contains($param->id)) active @endif  @if (isset($manage) && $manage==true) manage @endif" data-paramid="{{$param->id}}" data-categoryid="{{$category->id}}">
	  <div class="ui inverted dimmer">
	    <div class="ui loader"></div>
	  </div>

	<div class="upper">
		<div class="name">
		    <div class="name"><i class="eye icon"></i> {{$param->display_key}}</div>
		   </div>
	  @if (isset($manage) && $manage==true)
	<div class="actions"><i class="edit large icon edit_param_btn"></i><i class="delete large icon delete_param_btn"></i></div>
		@endif
	</div>
	  @if (isset($manage) && $manage==true)

	<div class="lower">
		<div class="info">
			<div>Počet v kategóriách: {{$param->categories->count()}}</div>
			<div>Počet v produktoch: {{$param->productParameters->count()}}</div>
		</div>
	</div>
	@endif

</div>