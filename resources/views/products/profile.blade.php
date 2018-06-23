@extends('layouts.master')
@section('content')

<div class="flex_content">


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
    <div id="sale" class="ui green large label"><i class="money icon"></i> Zľava</div>
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
    <div id="desc">
    {{$product->desc}}
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
<div class="pad wrapper ct" id="product_detail_params">
<div class="container">
        <div class="ui horizontal divider">Parametre</div>

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

<div class="pad wrapper ct">
  <div class="container">
  <div class="ui horizontal divider">Doporučené výrobky</div>

      <div id="grid">

      @foreach($product->relatedProducts as $relprod)
        @include('products.row',['product'=>$relprod])
      @endforeach

      </div>
</div>
</div>

<div class="pad wrapper ct">
      <div class="container ct">

             <div class="ui horizontal divider">Hodnotenia</div>

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
  
@stop