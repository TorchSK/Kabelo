<!DOCTYPE html>
<html>
    @include('includes.head')

    <body>

    @include('includes.header')

   	<div class="pusher">
		@yield('content')
	</div>

	@include('includes.footer')

    </body>
</html>