@extends('layouts.master')
@section('content')

@if (Auth::check() && Auth::user()->admin)
<div id="product_options" class="ct">
 <div class="container ct">
  <a href="/{{Request::segment(1)}}/{{Request::segment(2)}}/edit" class="ui teal button">Edituj produkt</a>
  <a class="ui red button" id="product_detail_delete_btn">Zmaž produkt</a>

</div>
</div>
@endif

<div id="product_detail" data-id={{$product->id}}>

      <div class="other_img">
          @if ($product->images->count() > 0)
          @foreach($product->images as $image)
           <img src="/{{$image->path}}" class="ui image" width="200px" />
           @endforeach
           @endif
        </div>


    <div class="left">
        <div class="img">
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" />
           @elseif ($product->image)
           <img src="/{{$product->image->path}}" class="ui image" />
           @endif
        </div>



    </div>

    <div class="right">
    	
    	<div id="name">{{$product->name}}</div>

		<div id="code">{{$product->code}} </div>
    <div class="ui teal large label" id="maker">Výrobca: {{$product->maker}}</div>
    @if ($product->sale)
    <div id="sale" class="ui brown large label"><i class="money icon"></i> Zľava</div>
    @endif

    @if ($product->new)
    <div id="new" class="ui blue large label"><i class="star icon"></i> Novinka</div>
    @endif

   		<div class="ui header">
   			@foreach ($product->categories as $category)
   			{{$category->name}}
   			@endforeach
   		</div>

		<div class="ui divider"></div>

    {{$product->desc}}
		<div id="parameters" class="@if($product->parameters->count()==0) empty @endif" >
          <div class="ui header">Parametre</div>

      @if ($product->parameters->count() > 0)
          <div class="ui bulleted list">

          @foreach ($product->parameters as $parameter)
              <div class="item"><b>{{$parameter->categoryParameter->display_key}}:</b> {{$parameter->value}}</div>
          @endforeach
        </div>
        @else
          Žiadne parametre
        @endif

    </div>

    <div class="ui divider"></div>

    <div id="prices">
    <div id="price" @if($product->sale) class="crossed" @endif>{{$product->price}} &euro;</div>
    @if ($product->sale)
    <div id="sale_price">{{$product->sale_price}} &euro;</div>
    @endif
    </div>
    <div id="product_detail_tocart_btn" class="ui large brown button"><i class="add to cart icon"></i>Kúpiť</div>


 </div>
</div>


<div id="product_tabs">

  <div class="tabs">
    <div class="tab ui brown button" data-tab="parameters">Parametre</div>
    <div class="tab ui basic button" data-tab="recommended">Doporučene produkty</div>
    <div class="tab ui basic button" data-tab="ratings">Hodnotenia</div>
  </div>

  <div class="contents">
    <div class="content active" data-tab="parameters">
      <div id="parameters">
      @if ($product->parameters->count() > 0)
          <div class="ui bulleted list">

          @foreach ($product->parameters as $parameter)
              <div class="item"><b>{{$parameter->categoryParameter->display_key}}:</b> {{$parameter->value}}</div>
          @endforeach
        </div>
        @else
          Žiadne parametre
        @endif
      </div>
    </div>
    <div class="content" data-tab="recommended">sa</div>
    <div class="content" data-tab="ratings">sa</div>

  </div>


</div>


@stop