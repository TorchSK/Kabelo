    @if(Auth::check())
    <div class="content cart hidden" data-cartid="{{Auth::user()->cart->id}}"></div>
    @endif

@include('products.list')
