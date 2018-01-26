<!DOCTYPE html>
<html>
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif>

    @include('includes.header')
    @include('includes.sidebar')

   	<div class="pusher">
		@yield('content')
		<div class="push"></div>
	</div>

	@include('includes.footer')

    </body>
</html>