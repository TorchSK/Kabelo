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



        <div class="img ct" style="height: 50vh;">
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
             <img src="{{$image->thumb}}" class="ui image" data-full="{{$image->path}}" style="max-height: 130px; max-width: 130px; display: inline-block;"/>
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
    	
    	<div id="name" style="font-weight: 600; font-size: 30px;">{{$product->name}}</div>

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
      @if (strlen($product->desc)>800)
        {!!substr($product->desc, 0, 800)!!} ... <a href="#product_detail_wrapper" class="load_more"><b>Viac info</b></a>
        @else
        {{$product->desc}}
        @endif
    </div>

    <div class="ui divider"></div>

    <div id="prices">
        <span style="font-size: 1.6em; color: #F2711C; font-weight: 700; margin-right: 10px;">Cena:</span> 
        <div id="price" class="crossed">{{$product->price*1.25}} &euro; </div>
        <div id="final_price">{{$product->price}} &euro;</div>
    </div>

    <div id="product_detail_tocart_btn" class="ui large brown labeled icon button" data-qty="{{$product->priceLevels->min('threshold')}}"><i class="add to cart icon"></i>Kúpiť</div>


 </div>
</div>


<div id="product_tabs">


<div class="pad wrapper ct" id="product_detail_wrapper">

  <div class="container">
    <div class="ui header">Detailný popis</div>
     <p>{{trim($product->desc)}}</p>
   
  </div>
</div>


<div class="pad wrapper ct" id="product_detail_suggested_wrapper">

  <div class="container">
    <div class="ui header">Ďalšie súvisiace produkty</div>

      <div id="grid">

      @foreach(App\Product::inRandomOrder()->whereHas('categories', function ($query) use ($product) {$query->whereIn('id', $product->categories->pluck('id'));})->where('id','!=',$product->id)->take(14)->get() as $relprod)
        @include('products.row',['product'=>$relprod])
      @endforeach

      </div>
</div>
</div>


</div>
</div>
</div>

</div>

@stop