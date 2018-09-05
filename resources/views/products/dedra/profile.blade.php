@extends('layouts.master')
@section('content')


<div class="flex_content">
  @if (Auth::check())
    <div class="content cart hidden" data-cartid="{{Auth::user()->cart->id}}"></div>
    @endif
<div class="flex flex_content @if($product->active==0) inactive @endif" id="product_content">



<div id="product_right">

<div class="ui button filterbar_handle">
  Zobrazit katalóg
</div>


<div id="m_categories_btn">
    <div class="ui brown  small fluid button" id="catbar_handle">Kategorie</div>
</div>


@include('includes/filterbar')

@if (Auth::check() && Auth::user()->admin)
<div id="product_options" class="ct">
 <div class="container ct">
  <a href="/{{Request::segment(1)}}/{{Request::segment(2)}}/edit" class="ui teal button">Edituj produkt</a>
  <a class="ui red button" id="product_detail_delete_btn">Zmaž produkt</a>
</div>
</div>
  @endif

<div id="product_detail" data-id={{$product->id}}>


    <div class="left">



        <div class="img ct" style="height: 70vh;">
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" />
           @elseif ($product->image)
           <img src="{{$product->image->path}}" class="ui image" style="max-height: 100%; max-width: 100%; width: auto; display: inline-block;"/>
           @endif
        </div>
        
          <div class="other_img">
          @if ($product->images->count() > 1)

          @foreach($product->images as $image)
            @if($appname=='Dedra')
             <img src="{{$image->thumb}}" class="ui image" style="max-height: 100px; max-width: 100px; display: inline-block;"/>
            @else
             <img src="{{$image->path}}" class="ui image" width="200px" />
           @endif
           @endforeach
           @endif

          @if ($product->videos->count() > 0)

           @foreach($product->videos as $video)
           <div class="pretty-embed" data-pe-videoid="{{explode('v=',$video->path)[1]}}" data-pe-fitvids="true"></div>

           @endforeach
           @endif


        </div>


    </div>

    <div class="right">
    	
    	<div id="name">{{$product->name}}</div>

		<div id="code">{{$product->code}} </div>
      @if ($product->sale)
    <div id="sale" class="ui green large label"><i class="money icon"></i> Zľava</div>
    @endif

    @if ($product->new)
    <div id="new" class="ui blue large label"><i class="star icon"></i> Novinka</div>
    @endif

   		<div class="ui header" id="product_categories">
        <div>
   			@foreach ($product->categories as $category)
        <div>
        @if(isset($category->parent) && $category->parent->count() > 0  && isset($category->parent->parent) && $category->parent->has('parent'))
        <a href="/category/{{$category->parent->parent->url}}#eshop" class="effect-1">{{$category->parent->parent->name}}</a> - 
        @endif
        @if(isset($category->parent) && $category->parent->count() > 0)
        <a href="/category/{{$category->parent->url}}#eshop" class="effect-1">{{$category->parent->name}}</a> - 
        @endif
        <a href="/category/{{$category->url}}#eshop" class="effect-1">{{$category->name}}</a>
        </div>
   			@endforeach
        </div>

        <div class="" id="maker">Výrobca: <b><a href="/maker/{{$product->maker}}" class="effect-1">{{$product->maker}}</a></b></div>

   		</div>

		<div class="ui divider"></div>
    <div id="desc">
    {{$product->desc}}
    </div>

    <div class="ui divider"></div>

    <div id="prices">
      <div id="price_type_info">
      @if(Auth::check() && Auth::user()->voc)
      Všetky ceny sú veľkoobchodné
      @else
      Všetky ceny sú maloobchodné
      @endif
      </div>
      <table class="ui unstackable table">
        <thead>
          <tr>
            <th>
              @if($product->price_unit=='m')
              Minimálny počet metrov
              @else
              Minimálny počet kusov
              @endif
              </th>
            <th>Cena za {{$product->price_unit}}</th>
  
          </tr>
        </thead>
        <tbody id="product_price_thresholds">
          @foreach($product->priceLevels as $key=>$priceLevel)
          <tr @if($key==0) class="positive" @endif>
            <td class="threshold" data-value="{{$priceLevel->threshold}}">{{$priceLevel->threshold}}</td>
            <td>
              @if(Auth::check() && Auth::user()->voc)
                @if($product->sale)
                <div id="price" class="crossed">{{$priceLevel->voc_regular}} &euro; </div>
                <div id="final_price">{{$priceLevel->voc_sale}} &euro; </div>
                @else
                <div id="final_price">{{$priceLevel->voc_regular}} &euro;</div>
                @endif
              @else
                @if($product->sale)
                <div id="price" class="crossed">{{$priceLevel->moc_regular}} &euro; </div>
                <div id="final_price">{{$priceLevel->moc_sale}} &euro;</div>
                @else
                <div id="final_price">{{$priceLevel->moc_regular}} &euro;</div>
                @endif
              @endif
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>
      </div>

  <div class="stock @if($product->stock >0) instock @else outstock @endif">
    @if($product->stock > 0)
    Skladom     {{$product->stock}} {{$product->price_unit}}
    @else
    Na objednávku 
    @endif
  </div>


      <div id="product_buy_qty_m_slider" data-min="{{$product->priceLevels->min('threshold')}}" data-max="200"></div>
      <div id="product_buy_qty_value">Kupujete: <qty>{{$product->priceLevels->min('threshold')}}</qty> {{$product->price_unit}} za 
        <price>
          {{$product->price}}
        </price> &euro;
      </div>

    <div id="product_detail_tocart_btn" class="ui large brown labeled icon button" data-qty="{{$product->priceLevels->min('threshold')}}"><i class="add to cart icon"></i>Kúpiť</div>


 </div>
</div>


<div id="product_tabs">


@if($product->relatedProducts->count() > 0)
<div class="pad wrapper ct" id="product_detail_suggested_wrapper">

  <div class="container">
    <div class="ui header">Doporučené výrobky</div>

      <div id="grid">

      @foreach($product->relatedProducts as $relprod)
        @include('products.row',['product'=>$relprod])
      @endforeach

      </div>
</div>
</div>

@endif

</div>
</div>
</div>

</div>

@stop