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

    <script src="/js/jquery.min.js"></script>
    <script defer async src="/js/app.js"></script>


    <script defer async src="/js/flickity.js"></script>
    <script defer async src="/js/cropper.js"></script>
    <script defer async src="/js/modulobox.min.js"></script>
    <script defer async src="/js/dropzone.js"></script>
    <script defer async src="/js/handsontable.full.min.js"></script>

    </body>
</html>