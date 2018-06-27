<!DOCTYPE html>
<html>
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif data-layout="{{$layout}}">

    @include('includes.sidebar')
    @include('includes.catbar')
    @include('includes.parambar')
    
    @include('includes.header')

    @yield('content')

	@include('includes.footer')

    </body>
</html>