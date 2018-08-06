<div class="ui horizontal divider active title"><i class="dropdown icon"></i>Výrobcovia</div>
<div class="active content">
@foreach($makers->unique('maker') as $maker)
    <div class="ui checkbox pad item @if($filterCounts['parameters']['makers'][$maker->maker]==0) disabled @endif" data-value="{{$maker->maker}}" data-filter="makers" data-display="Výrobca">
      <input type="checkbox" name="example" @if($activeFilters->has('parameters') && isset($activeFilters->get('parameters')['makers']) && in_array($maker->maker, $activeFilters->get('parameters')['makers'])) checked @endif>
      <label>{{$maker->maker}}</label>
      <count>{{$filterCounts['parameters']['makers'][$maker->maker]}}</count>
    </div>
@endforeach
</div>

@foreach($filters as $filter)
<div class="ui horizontal divider active title"><i class="dropdown icon"></i>{{$filter->display_key}}</div>
<div class="active content">
@foreach($filterValues as $parameter)
    <div class="ui checkbox pad item filter @if(isset($filterCounts['parameters'][$filter->id][$parameter]) && $filterCounts['parameters'][$filter->id][$parameter]==0) disabled @endif" data-filter={{$filter->key}} data-filterid="{{$filter->id}}" data-value="{{$parameter}}" data-valueid="{{$parameter}}" data-display="{{$filter->display_key}}">
      <input type="checkbox" name="example" @if($activeFilters->has('parameters') && isset($activeFilters->get('parameters')[$filter->key]) && in_array($parameter, $activeFilters->get('parameters')[$filter->key])) checked @endif>

      <label>{{$parameter}}</label>
      <count>{{$filterCounts['parameters'][$filter->id][$parameter]}}</count>
    </div>
    @endforeach 
    </div>
@endforeach

