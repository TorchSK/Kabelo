<div class="ui horizontal divider active title"><i class="dropdown icon"></i>Výrobcovia</div>
<div class="active content">
@foreach($makers as $maker)
    <div class="ui checkbox item" data-makerid="{{$maker->id}}">
      <input type="checkbox" name="example">
      <label>{{$maker->maker}}</label>
    </div>
@endforeach
</div>