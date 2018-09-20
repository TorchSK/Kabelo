<!DOCTYPE html>
<html>
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif class="admin" data-layout="1">

    <div class="pusher">

    @include('includes.header')

    <div class="flex_row">
        @include('admin.tabs')

        <div class="flex_column">
            @yield('content')
        </div>
    </div>

	</div>

    </body>
</html>