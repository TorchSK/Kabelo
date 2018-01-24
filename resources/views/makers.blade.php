<div class="ui horizontal divider active title"><i class="dropdown icon"></i>Výrobcovia</div>
<div class="active content">
@foreach($makers as $maker)
    <div class="ui checkbox item" data-value="{{$maker->maker}}" data-filter="maker" data-display="Výrobca">
      <input type="checkbox" name="example" @if($activeFilters->has('maker') && in_array($maker->maker, $activeFilters->get('maker'))) checked @endif>
      <label>{{$maker->maker}}</label>
      <div class="label">{{$filterCounts['makers'][$maker->maker]}}</div>
    </div>
@endforeach
</div>

@foreach($filters as $filter)
<div class="ui horizontal divider active title"><i class="dropdown icon"></i>{{$filter->display_key}}</div>
<div class="active content">
@foreach($filter->parameters as $parameter)
    <div class="ui checkbox item filter" data-filter={{$filter->key}} data-filterid="{{$filter->id}}" data-value="{{$parameter->value}}" data-valueid="{{$parameter->id}}" data-display="{{$filter->display_key}}">
      <input type="checkbox" name="example" @if($activeFilters->has($filter->key) && in_array($parameter->value, $activeFilters->get($filter->key))) checked @endif>
      <label>{{$parameter->value}}</label>
      <div class="label"></div>
    </div>
    @endforeach
    </div>
@endforeach

