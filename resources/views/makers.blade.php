<div class="ui horizontal divider active title"><i class="dropdown icon"></i>Výrobcovia</div>
<div class="active content">
@foreach($makers as $maker)
    <div class="ui checkbox item" data-valueid="{{$maker->id}}" data-filter="maker" data-display="Výrobca">
      <input type="checkbox" name="example">
      <label>{{$maker->maker}}</label>
    </div>
@endforeach
</div>

@foreach($filters as $filter)
<div class="ui horizontal divider active title"><i class="dropdown icon"></i>{{$filter->display_key}}</div>
<div class="active content">
@foreach($filter->parameters as $parameter)
    <div class="ui checkbox item filter" data-filter={{$filter->key}} data-filterid="{{$filter->id}}" data-value="{{$parameter->value}}" data-valueid="{{$parameter->id}}" data-display="{{$filter->display_key}}">
      <input type="checkbox" name="example">
      <label>{{$parameter->value}}</label>
    </div>
    @endforeach
    </div>
@endforeach
