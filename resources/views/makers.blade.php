<div class="header item">Výrobcovia</div>
@foreach($makers as $maker)
    <div class="ui checkbox item" data-makerid="{{$maker->id}}">
      <input type="checkbox" name="example">
      <label>{{$maker->maker}}</label>
    </div>
@endforeach