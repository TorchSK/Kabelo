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

  <div class="tabbs">
    <div class="tabb ui brown button" data-tab="parameters">Parametre ({{$product->parameters->count()}})</div>
    <div class="tabb ui basic button" data-tab="recommended">Doporučene produkty ({{$product->relatedProducts->count()}})</div>
    <div class="tabb ui basic button" data-tab="ratings">Hodnotenia ({{$product->ratings->count()}})</div>
  </div>

  <div class="contents">
    <div class="content par active" data-tab="parameters">
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
    <div class="content rec" data-tab="recommended">
      <div id="grid">

      @foreach($product->relatedProducts as $relprod)
        @include('products.row',['product'=>$relprod])
      @endforeach

      </div>
    </div>
    <div class="content rat" data-tab="ratings">
      
      <div class="wrapper ct">

        <div class="overall_rating">
          <div class="rating_number"><number>@if($product->ratings->pluck('value')->avg() > 0) {{$product->ratings->pluck('value')->avg()}}</number> @else 0 @endif <span>({{$product->ratings->count()}} hodnotení)</span></div>
          <div class="disabled rating" @if($product->ratings->count()>0) data-rating="{{$product->ratings->pluck('value')->avg()}}" @else data-rating="0" @endif">
          </div>
        </div>

        <div class="my_rating">
          <div class="rating_number"><number>@if(App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value) {{App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value}}</number> @else 0 @endif <span>(Moje hodnotenie)</span></div>

           <div class="my rating" @if(App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value > 0) data-rating="{{App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value}}" @else data-rating="0" @endif>
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

    </div>

  </div>
  
  <div id="myrating" @if(App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value > 0) data-rating="{{App\Rating::where('user_id',Auth::user()->id)->where('ratingable_id', $product->id)->first()->value}}" @else data-rating="0" @endif></div>


</div>

  
@stop