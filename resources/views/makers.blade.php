<div class="ui horizontal divider active title"><i class="dropdown icon"></i>Výrobcovia</div>
<div class="active content">
@foreach($makers as $maker)
    <div class="ui checkbox item @if($filterCounts['parameters']['makers'][$maker->maker]==0) disabled @endif" data-value="{{$maker->maker}}" data-filter="makers" data-display="Výrobca">
      <input type="checkbox" name="example" @if($activeFilters->has('parameters') && isset($activeFilters->get('parameters')['makers']) && in_array($maker->maker, $activeFilters->get('parameters')['makers'])) checked @endif>
      <label>{{$maker->maker}}</label>
      <count>{{$filterCounts['parameters']['makers'][$maker->maker]}}</count>
    </div>
@endforeach
</div>

@foreach($filters as $filter)
<div class="ui horizontal divider active title"><i class="dropdown icon"></i>{{$filter->display_key}}</div>
<div class="active content">
@foreach($filter->parameters->unique('value') as $parameter)
    <div class="ui checkbox item filter @if($filterCounts['parameters'][$filter->id][$parameter->value]==0) disabled @endif" data-filter={{$filter->key}} data-filterid="{{$filter->id}}" data-value="{{$parameter->value}}" data-valueid="{{$parameter->id}}" data-display="{{$filter->display_key}}">
      <input type="checkbox" name="example" @if($activeFilters->has('parameters') && isset($activeFilters->get('parameters')[$filter->key]) && in_array($parameter->value, $activeFilters->get('parameters')[$filter->key])) checked @endif>
      <label>{{$parameter->value}}</label>
      <count>{{$filterCounts['parameters'][$filter->id][$parameter->value]}}</count>
    </div>
    @endforeach 
    </div>
@endforeach

