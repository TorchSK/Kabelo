<!DOCTYPE html>
<html>
    @include('includes.head')

    <body @if (isset($bodyid)) id="{{$bodyid}}" @endif data-layout="1">

       	<div class="pusher">

                @include('includes.header')

                <div class="admin_wrapper">
                    <div class="admin_tabs">@include('admin.tabs')</div>
    		        @yield('content')
    		        <div class="push"></div>
    	       </div>
        </div>

	@include('includes.footer')

    </body>
</html>