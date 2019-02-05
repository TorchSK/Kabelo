@extends('layouts.master')
@section('content')


@if (Auth::check() && Auth::user()->admin)
<div id="product_options_wrapper" class="wrapper">
 <div class="container ct">
  <a href="{{route('product.edit',['product'=>$product->url])}}" class="ui teal button">Edituj produkt</a>
  <a class="ui red button" id="product_detail_delete_btn">Zmaž produkt</a>
  <a class="ui blue button" id="product_detail_translate_btn">Prelož do SK</a>

</div>
</div>
@endif

@include('includes/filterbar_horizontal')

<div id="product_main_wrapper" class="wrapper @if($product->active==0) inactive @endif" data-id="{{$product->id}}" data-gallery="{{$product->code}}" data-index="0">
  <div class="container flex_row">


      <div class="ui header" id="product_categories_path">
        <div>
          <div>
            <a href="/" class=""><i class="home icon"></i></a> /
          @if(isset($product->categories->first()->parent->parent->parent) && $product->categories->first()->parent->count() > 0  && isset($product->categories->first()->parent->parent) && $product->categories->first()->parent->parent->has('parent'))
          <a href="{{route('category.products',['path'=> $product->categories->first()->parent->parent->parent->full_url])}}" class="effect-1">{{$product->categories->first()->parent->parent->parent->name}}</a> / 
          @endif
          @if(isset($product->categories->first()->parent) && $product->categories->first()->parent->count() > 0  && isset($product->categories->first()->parent->parent) && $product->categories->first()->parent->has('parent'))
          <a href="{{route('category.products',['path'=> $product->categories->first()->parent->parent->full_url])}}" class="effect-1">{{$product->categories->first()->parent->parent->name}}</a> / 
          @endif
          @if(isset($product->categories->first()->parent) && $product->categories->first()->parent->count() > 0)
          <a href="{{route('category.products',['path'=> $product->categories->first()->parent->full_url])}}" class="effect-1">{{$product->categories->first()->parent->name}}</a> / 
          @endif
          @if($product->categories->count() > 0)
          <a href="{{route('category.products',['path'=> $product->categories->first()->full_url])}}" class="effect-1">{{$product->categories->first()->name}}</a>
          @endif
          </div>
        </div>
      </div>

    <div class="images">

        <div class="hiden">
          @foreach($product->images as $key => $image)
            @if($appname=='dedra')
            <a class="img ct mobx" href="{{$image->path}}" style="display: inline-block;"  data-rel="{{$product->code}}" data-index="{{$key}}">
             <img src="{{$image->thumb}}" class="ui image" alt="{{$product->code}}-{{$product->name}}" data-full="{{$image->path}}" style="max-height: 130px; max-width: 130px; display: inline-block;"/>
             </a>
            @else
             <img src="{{$image->path}}" class="ui image" width="200px"  alt="{{$product->code}}-{{$product->name}}" />
           @endif
           @endforeach
         </div>

        <a class="img ct main" @if ($product->image)href="{{$product->image->path}}"@endif  data-rel="{{$product->code}}" >
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" alt="{{$product->code}}-{{$product->name}}"/>
           @elseif ($product->image)
           <img src="{{$product->image->path}}" class="ui image" alt="{{$product->code}}-{{$product->name}}"/>
           @endif
        </a>
        
          <div class="other_img ct">
          @if ($product->images->count() > 1)

          @foreach($product->images as $key => $image)
            @if($appname=='dedra')
            <a class="img ct" href="{{$image->path}}" style="display: inline-block;" >
             <img src="{{$image->thumb}}" class="ui image" data-full="{{$image->path}}" data-index="{{$key}}" alt="{{$product->code}}-{{$product->name}}"/>
             </a>
            @else
             <img src="{{$image->path}}" class="ui image" width="200px" alt="{{$product->code}}-{{$product->name}}" />
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

    <div class="info">
    	
    	 <h1 id="name" style="font-weight: 600; font-size: 25px;">{{$product->name}}</h1>

		  <div id="code">Kód produktu: {{$product->code}} </div>

    @if ($product->new)
    <div id="new" class="ui blue large label" style="margin-left: 15px;"><i class="star icon"></i> Novinka</div>
    @endif
    
      @if ($product->sale)
    <div id="sale" class="ui green large label"><i class="money icon"></i> Zľava</div>
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


   		</div>

		<div class="ui divider"></div>
    <div id="desc">
        <div class="desc">{{$product->desc}}</div>
        @if($product->variants->count() > 0)
        <div class="variants">
          <div class="caption">Varianty</div>
          @foreach($product->variants as $variant)
            @if($variant->variant_text)
            <a class="variant" href="{{route('product.detail',['product'=>$variant->url])}}">{{$variant->variant_text}}</a>
            @endif
          @endforeach
        </div>
        @endif

     @if($product->colors->count() > 0)
        <div class="colors">
          <div class="caption">Farby</div>
          @foreach($product->colors as $variant)
            <a class="color" href="{{route('product.detail',['product'=>$variant->url])}}"><img src="{{url($variant->image->path)}}"/></a>
          @endforeach
        </div>
        @endif

    </div>

            
      @if($product->detailStickers->count() > 0)
       <div class="product_stickers">
        @foreach($product->detailStickers as $sticker)
          <div class="sticker">
            <img src="{{url($sticker->path)}}" >
          </div>
        @endforeach
       </div>
       @endif
       
    <div class="ui divider"></div>

    <div id="prices">
        <span style="font-size: 1.6em; color: #F2711C; font-weight: 700; margin-right: 10px;">Cena:</span> 
        @if($product->sale)
        <div id="price" class="crossed">{{number_format($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular,2)}} &euro; </div>
        <div id="final_price">{{number_format($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale,2)}} &euro;</div>
        @else
        <div id="final_price">{{number_format($product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular,2)}} &euro;</div>
        @endif
    </div>

    <div class="product_bottom">
    <div id="product_detail_tocart_btn" class="ui large labeled icon button" data-qty="{{$product->priceLevels->min('threshold')}}"><i class="add to cart icon"></i>Kúpiť</div>

   </div>
   
 </div>


</div>
</div>

<div id="product_detail_wrapper" class="wrapper">

  <div class="container">
    <div class="ui header">Detailný popis</div>
     <p style="text-align: justify;">{{ preg_replace("/(^\h+|\h+$)/mu", "", preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n",  $product->desc)))}}</p>

    @if($product->back1)
    <div class="product_back">
      <i class="info teal circle icon"></i>
      <a href="{{$product->back1}}" target="_blank">Etiketa výrobku</a>
    </div>
    @endif

    @if($product->back2)
    <div class="product_back">
      <i class="info teal circle icon"></i>
      <a href="{{$product->back2}}" target="_blank">Etiketa výrobku</a>
    </div>
    @endif

    @if($product->back3)
    <div class="product_back">
      <i class="info teal circle icon"></i>
      <a href="{{$product->back3}}" target="_blank">Etiketa výrobku</a>
    </div>
    @endif


  </div>
</div>


<div class="wrapper ct" id="product_detail_suggested_wrapper">
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
        @foreach(App\Product::inRandomOrder()->whereHas('categories', function ($query) use ($product) {$query->whereIn('id', $product->categories->pluck('id'));})->where('id','!=',$product->id)->take(50)->get() as $relprod)
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