@extends('layouts.master')
@section('content')

@if (Auth::check() && Auth::user()->admin)
<div id="product_options_wrapper" class="wrapper">
 <div class="container ct">
  <a href="{{route('product.edit',['product'=>$product->url])}}" class="ui teal button">Edituj produkt</a>
  <a class="ui red button" id="product_detail_delete_btn">Zmaž produkt</a>
</div>
</div>
@endif

<div class="main wrapper" id="product">
<div class="container">

<div class="filterbar_handle ui blue button"><i class="bars icon"></i>Kategórie</div>
<div class="absolute">
@include('includes/filterbar')
</div>


<div id="product_wrapper">
<div id="product_main_wrapper" class="wrapper @if($product->active==0) inactive @endif" data-id="{{$product->id}}" data-gallery="{{$product->code}}" data-index="0">
  <div class="container flex_row">
      
    <div class="images">



        <div class="img">
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" />
           @elseif ($product->image)
           <img src="/{{$product->image->path}}" class="ui image" />
           @endif
        </div>
        
          <div class="other_img">
          @if ($product->images->count() > 1)

          @foreach($product->images as $image)
           <img src="/{{$image->path}}" class="ui image" width="200px" />
           @endforeach
           @endif

          @if ($product->videos->count() > 0)

           @foreach($product->videos as $video)
           <div class="pretty-embed" data-pe-videoid="{{explode('v=',$video->path)[1]}}" data-pe-fitvids="true"></div>

           @endforeach
           @endif


        </div>


    </div>

    <div class="info">
    	
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
        <a href="{{route('category.products',['path'=> $category->parent->parent->full_url])}}" class="effect-1">{{$category->parent->parent->name}}</a> - 
        @endif
        @if(isset($category->parent) && $category->parent->count() > 0)
        <a href="{{route('category.products',['path'=> $category->parent->full_url])}}" class="effect-1">{{$category->parent->name}}</a> - 
        @endif
        <a href="{{route('category.products',['path'=> $category->full_url])}}" class="effect-1">{{$category->name}}</a>
        </div>
   			@endforeach
        </div>

        <div class="" id="maker">Výrobca: <b><a href="/m/{{$product->maker}}" class="effect-1">{{$product->maker}}</a></b></div>

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
                <div class="without_vac">{{round($priceLevel->voc_sale/1.2,2)}} &euro; bez dph</div>
                @else
                <div id="final_price">{{$priceLevel->voc_regular}} &euro;</div>
                <div class="without_vac">{{round($priceLevel->voc_regular/1.2,2)}} &euro; bez dph</div>
                @endif
              @else
                @if($product->sale)
                <div id="price" class="crossed">{{$priceLevel->moc_regular}} &euro; </div>
                <div id="final_price">{{$priceLevel->moc_sale}} &euro;</div>
                <div class="without_vac">{{round($priceLevel->moc_sale/1.2,2)}} &euro; bez dph</div>

                @else
                <div id="final_price">{{$priceLevel->moc_regular}} &euro;</div>
                <div class="without_vac">{{round($priceLevel->moc_regular/1.2,2)}} &euro; bez dph</div>
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


      <div id="product_buy_qty_m_slider" data-min="{{$product->priceLevels->min('threshold')}}" data-max="500" data-step="{{$product->step}}"></div>
      <div id="product_buy_qty_value">Kupujete: <qty>{{$product->priceLevels->min('threshold')}}</qty> {{$product->price_unit}} za 
        <price>
          @if(Auth::check() && Auth::user()->voc)
            @if($product->sale)
            {{$product->priceLevels->min('threshold')*$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_sale}}
            @else
            {{$product->priceLevels->min('threshold')*$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular}}
            @endif
          @else
            @if($product->sale)
            {{$product->priceLevels->min('threshold')*$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale}}
            @else
            {{$product->priceLevels->min('threshold')*$product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular}}
            @endif
          @endif
        </price> &euro;</div>

    <div id="product_detail_tocart_btn" class="ui large brown labeled icon button" data-qty="{{$product->priceLevels->min('threshold')}}"><i class="add to cart icon"></i>Kúpiť</div>


 </div>
</div>
</div>


<div id="product_params_wrapper" class="wrapper">
  <div class="container">

      @if ($product->parameters->count() > 0)

      <table class="ui celled unstackable table">
       <tbody>
          @foreach ($product->parameters as $parameter)
              <tr>
                <td class="collapsing"><b>{{$parameter->definition->display_key}}</b></td>
                <td> {{$parameter->value}}</td>
              </tr>
          @endforeach
        @else
          Žiadne parametre
        @endif
          </tbody>
    </table>

@foreach($product->files as $file)
<a href={{ asset($file->path) }} target="_blank"><i class="icon huge brown file pdf outline" ></i> Katalógový list</a>
@endforeach

</div>
</div>

<div class="pad wrapper" id="product_detail_suggested_wrapper">

  <div class="container">
    
    <div class="caption">
    <div class="ui header">Ďalšie súvisiace produkty</div>
      @if(Auth::check() && Auth::user()->admin)
      <div id="suggested_wrapper_speed">
          <i class="minus circle icon"></i>
          <span>Pauza: <value>{{App\Setting::firstOrCreate(['name'=>'suggested_wrapper_speed'])->value}}</value></span>
          <i class="plus circle icon"></i>
      </div>
      @endif
      <arrows><i class="chevron circle left icon"></i><i class="chevron circle right icon"></i></arrows>
    </div>

      <div class="related_products_carousel">
        @if($product->relatedProducts->count() > 0)

          @foreach($product->relatedProducts as $relprod)
            @include('products.row',['product'=>$relprod])
          @endforeach
        
        @else

          @foreach(App\Product::inRandomOrder()->whereHas('categories', function ($query) use ($product) {$query->whereIn('id', $product->categories->pluck('id'));})->where('id','!=',$product->id)->take(50)->get() as $relprod)
            @include('products.row',['product'=>$relprod])
          @endforeach

        @endif

      </div>
</div>
</div>


</div>
</div>
</div>

@stop