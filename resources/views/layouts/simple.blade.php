<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif data-layout="{{App\Setting::whereName('layout')->first()->value}}">


    <div class="pusher">

    @yield('content')

    </div>

    </body>
</html>