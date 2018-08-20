<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif data-layout="{{App\Setting::whereName('layout')->first()->value}}">

    @include('includes.sidebar')
    @include('includes.catbar')
    @include('includes.parambar')   

    <div class="pusher">
    @include('includes.header')

    @yield('content')

	@include('includes.footer')
    </div>

    </body>
</html>