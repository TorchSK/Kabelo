<!DOCTYPE html>
<html>
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif>

    @include('includes.header')

   	<div class="pusher">
		@yield('content')
		<div class="push"></div>
	</div>

	@include('includes.footer')

    </body>
</html>