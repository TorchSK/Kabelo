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

    
    <script src="/js/jquery.min.js"></script>
        <script src="/js/admin.js"></script>

    <script src="/js/app.js"></script>

    <script src="/js/nestedsortable.js"></script>

    <script src="/js/flickity.js"></script>
    <script src="/js/cropper.js"></script>
    <script src="/js/modulobox.min.js"></script>
    <script src="/js/dropzone.js"></script>
    <script src="/js/handsontable.full.min.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qf9bxbfqc0n3wz9w142mp9fu5fybtks16oqfiduv88ea66zi"></script>

    </body>
</html>