@extends('layouts.master')
@section('content')

<div class="flex_content">

<div class="flex flex_content" id="product_content">

@include('includes/filterbar')

<div id="product_right">


<div id="product_detail" data-id={{$product->id}}>


    <div class="left">



        <div class="img">
           @if ($product->images->count() == 0)
           <img src="/img/empty.jpg" class="ui image" />
           @elseif ($product->image)
           <img src="/{{$product->image->path}}" class="ui image" />
           @endif
        </div>
        
          @if ($product->images->count() > 1)

          <div class="other_img">
          @foreach($product->images as $image)
           <img src="/{{$image->path}}" class="ui image" width="200px" />
           @endforeach
        </div>
           @endif


    </div>

    <div class="right">
    	
    	<div id="name">{{$product->name}}</div>

		<div id="code">{{$product->code}} </div>
    <div class="ui teal large label" id="maker">Výrobca: {{$product->maker}}</div>
    @if ($product->sale)
    <div id="sale" class="ui green large label"><i class="money icon"></i> Zľava</div>
    @endif

    @if ($product->new)
    <div id="new" class="ui blue large label"><i class="star icon"></i> Novinka</div>
    @endif

   		<div class="ui header">
   			@foreach ($product->categories as $category)
        @if(isset($category->parent) && $category->parent->count() > 0  && isset($category->parent->parent) && $category->parent->has('parent'))
        <a href="/{{$category->parent->parent->url}}#eshop" class="effect-1">{{$category->parent->parent->name}}</a> - 
        @endif
        @if(isset($category->parent) && $category->parent->count() > 0)
        <a href="/{{$category->parent->url}}#eshop" class="effect-1">{{$category->parent->name}}</a> - 
        @endif
        <a href="/{{$category->url}}#eshop" class="effect-1">{{$category->name}}</a>
   			@endforeach
   		</div>

		<div class="ui divider"></div>
    <div id="desc">
    {{$product->desc}}
    </div>

    <div class="ui divider"></div>

    <div id="prices">
      <div id="price_type_info">
      @if(Auth::user()->voc)
      Všetky ceny sú veľkoobchodné
      @else
      Všetky ceny sú maloobchodné
      @endif
      </div>
      <table class="ui table">
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
              @if(Auth::user()->voc)
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

      <div id="product_buy_qty_m_slider" data-min="{{$product->priceLevels->min('threshold')}}" data-max="200"></div>
      <div id="product_buy_qty_value">Kupujete: <qty>{{$product->priceLevels->min('threshold')}}</qty> {{$product->price_unit}} za 
        <price>
          @if(Auth::user()->voc)
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


<div id="product_tabs">
<div class="pad wrapper ct" id="product_detail_params">
          <div class="ui horizontal divider">Parametre</div>

<div class="container">

      @if ($product->parameters->count() > 0)

      <table class="ui celled table">
       <tbody>
          @foreach ($product->parameters as $parameter)
              <tr>
                <td class="collapsing"><b>{{$parameter->categoryParameter->display_key}}</b></td>
                <td> {{$parameter->value}}</td>
              </tr>
          @endforeach
        </div>
        @else
          Žiadne parametre
        @endif
          </tbody>
</table>
</div>
</div>

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

<div class="pad wrapper ct">
               <div class="ui horizontal divider">Hodnotenia</div>

      <div class="container ct">


        <div class="overall_rating">
          <div class="rating_number"><number>@if($product->ratings->pluck('value')->avg() > 0) {{$product->ratings->pluck('value')->avg()}}</number> @else 0 @endif <span>({{$product->ratings->count()}} hodnotení)</span></div>
          <div class="disabled rating" @if($product->ratings->count()>0) data-rating="{{$product->ratings->pluck('value')->avg()}}" @else data-rating="0" @endif">
          </div>
        </div>

        <div class="my_rating">
          <div class="rating_number"><number>@if(App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->count() >0) {{App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value}}</number> @else 0 @endif <span>(Moje hodnotenie)</span></div>

           <div class="my rating" @if(App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->count() >0) data-rating="{{App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value}}" @else data-rating="0" @endif>
          </div>
        </div>

        <div class="ratings_list">
          @foreach($product->ratings as $rating)
            <div class="rating_div">
              <div class="user">{{$rating->user->email}}</div>
              <div class="value">

                  <div class="disabled rating" data-rating="{{$rating->value}}">
                    </div>

              </div>
            </div>
          @endforeach
        </div>
  </div>
  <div id="myrating" @if(App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->count() >0) data-rating="{{App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value}}" @else data-rating="0" @endif></div>


</div>
</div>
</div>
</div>

</div>

@stop