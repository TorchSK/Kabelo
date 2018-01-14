<div id="errors">
    @if ($errors->all())
    <div class="ui large error compact message">
     <div class="header">
      Prosím opravte nasledujúce chyby
    </div>
      <ul class="list">
        @foreach($errors->all() as $error)
            <li>{!! $error !!}</li>
        @endforeach
      </ul>
    </div>
    <br />
    @endif
</div>