<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif class="eshop" data-layout="{{App\Setting::whereName('layout')->first()->value}}">

    @include('includes.sidebar')
    @include('includes.catbar')
    @include('includes.parambar')   

    <div class="pusher flex_column">
        @include('includes.header')
        @yield('content')
    </div>

    @include('includes.footer')


    </body>
</html>