<!DOCTYPE html>
<html>
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif data-layout="1">

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