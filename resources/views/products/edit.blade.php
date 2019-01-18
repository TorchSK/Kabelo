@extends('layouts.admin')
@section('content')

    <div id="param_template">

        <div class="row">
        <div class="ui search selection dropdown">
          <input type="hidden" name="key[]">
          <i class="dropdown icon"></i>
            <div class="default text">Parameter</div>

          <div class="menu">
            @if($product->categories->count() > 0)
            @foreach (App\Category::find($product->categories->first()->id)->parameters as $param)
              @include('products.paramoptions')
            @endforeach
            @endif
          </div>
        </div>
        <div class="ui input value"><input type="text" name="value[]" /></div>

        <div class="ui icon red button delete_product_param"><i class="delete icon"></i></div>

      </div>

    </div>


<form action="/product/{{$product->id}}" method="POST"  class="admin_wrapper">
  {!! csrf_field()!!}
  <input name="_method" type="hidden" value="PUT">
  

<div id="product_options_top">
 <div class="container">
  <button type="submit" class="ui green button" id="edit_product_submit">Ulož zmeny</button>
  <a href="{{route('product.detail',['url'=>$product->url])}}" class="ui red button">Zruš editáciu</a>

</div>
</div>

<div id="product_main_wrapper" class="product_detail flex_row" data-id="{{$product->id}}">
    
    <div class="images">
     <div class="edit_product_images">
        @foreach($product->allfiles as $image)
          <div class="image_div @if($image->primary) primary @endif" data-fileid="{{$image->id}}">
            <div class="image">
              @if ($image->type=='image')
              <img src="{{url($image->path)}}" />
              @elseif ($image->type!='video')
              <i class="icon huge brown file pdf outline" ></i>
              @endif
            </div>

            <div class="path">
              <div class="ui fluid action input">
                <input type="text" name="image_ids[]" value="{{$image->id}}" />
                <input type="text" name="image_paths[]" value="{{$image->path}}" />
                <div class="ui red icon button delete_img"><i class="delete icon"></i></div>
                <div class="ui blue icon button make_primary_img"><i class="star icon"></i></div>

              </div>
            </div>

         </div>
         @endforeach 
      </div>

      <div class="img">
        <div class="edit_images">
           <div action="/file/upload" class="dropzone" id="product_detail_dropzone">
            <input name="_token" hidden value="{!! csrf_token() !!}" />
            <div class="dz-message">Klikni pre nahranie obrázkov/súborov</div>
          </div>
         </div>
       </div>

    <div class="ui checkbox">
      <input type="checkbox" name="thumbnail_flag" @if($product->thumbnail_flag) checked="1"  @endif>
      <label>Zobrazovať pôvodný zmenšený obrázok</label>
    </div>

  <div id="video_inputs">
         @foreach($product->videos as $video)
          <div class="ui large fluid left icon input"><i class="youtube icon"></i><input type="text" name="videos[]" value="{{$video->path}}"></div>
         @endforeach
          <div class="ui large fluid left icon input"><i class="youtube icon"></i><input type="text" name="videos[]"></div>
          <div class="ui large fluid left icon input"><i class="youtube icon"></i><input type="text" name="videos[]"></div>
          <div class="ui large fluid left icon input"><i class="youtube icon"></i><input type="text" name="videos[]"></div>
       </div>
    <div class="ui grid four column">

    <div class="column">
    <div id="create_product_new_flag">
    <div class="ui checkbox">
      <input type="checkbox" name="new" @if($product->new) checked="1"  @endif>
      <label>Novinka</label>
    </div>
    </div>
   </div>

       <div class="column">
    <div id="create_product_sale_flag">
    <div class="ui checkbox">
      <input type="checkbox" name="sale"  @if($product->sale) checked="1" @endif>
      <label>V zľave</label>
    </div>
    </div>
  </div>

         <div class="column">
    <div id="create_product_active_flag">
    <div class="ui checkbox">
      <input type="checkbox" name="active"  @if($product->active) checked="1" @endif>
      <label>Aktívny</label>
    </div>
    </div>
  </div>


      <div class="column">

          <div class="ui fluid  selection dropdown" id="edit_product_unit_input">
            <input type="hidden" name="price_unit" value="{{$product->price_unit}}">
            <i class="dropdown icon"></i>
            <div class="text">m</div>
            <div class="menu">
              <div class="item" data-value="m">m</div>
              <div class="item" data-value="ks">ks</div>
            </div>
          </div>
        </div>

  </div>


    <div class="ui grid two column">

    <div class="column">
        <div class="ui fluid labeled input">
          <div class="ui label">Balenie po (m)</div>
          <input type="text" name="step" placeholder="" value="{{$product->step}}">
       </div>
    </div>
   </div>


    <div id="product_price_levels_list">
      @foreach($product->priceLevels as $priceLevel)
       @include('products.pricelevel')
      @endforeach
    </div>
    


      <div class="ui teal button" id="add_price_level_btn">Pridaj cenovú úroveň</div>
      

    <div class="product_price_levels_edit">


    </div>

    </div>

    <div class="info">
      
      <div class="ui header">Název</div>

        <div class="ui fluid input" id="edit_product_name_input">
           <input type="text" name="name" value="{{$product->name}}" />
      </div>

    <div class="ui header">Kód produktu</div>

        <div class="ui fluid input" id="edit_product_code_input">
           <input type="text" name="code" value="{{$product->code}}"  />
      </div>

    <div class="ui header">Výrobca</div>

        <div class="ui fluid input" id="create_product_maker_input">
           <input type="text" name="maker" value="{{$product->maker}}" />
      </div>

      <div class="ui header">Kategória</div>
    <select multiple="true" name="categories[]" id="edit_product_categories_input" class="ui fluid search dropdown">
    <option value="">Kategória</option>
    @foreach (App\Category::orderBy('path','asc')->get() as $category)
    <option value="{{$category->id}}" @if($product->categories->count()>0 && in_array($category->id, $product->categories->pluck('id')->toArray())) selected="true" @endif>
    @if($category->parent)
     {{$category->parent->name}} - 
      @endif
      {{$category->name}}
 
    </option>
    @endforeach
    </select>

    <div class="ui header">Popis</div>

    <div class="ui form">
      <div class="field" id="edit_product_desc_input">
        <textarea name="desc">{{$product->desc}}</textarea>
      </div>
    </div>

    <!--
      <div class="ui header">Dostupné vo farbe</div>
      <div class="product_color choosable"></div>

      <div class="ui popup transition hidden">
       <div class="product_color pickable"></div>
      <div class="product_color pickable"></div>
       <div class="product_color pickable"></div>
       <div class="product_color pickable"></div>
      </div>
      
      <div class="ui teal button" id="edit_product_add_param_row">Pridaj</div>
  -->


    <div class="ui header">Parametre</div>




    <div id="edit_product_params">

      @if ($product->parameters->count() == 0)


      @else

      @foreach ($product->parameters as $parameter)
      <div class="row">
        <div class="ui search selection dropdown">
          <input type="hidden" name="key[]" value="{{$parameter->definition->id}}">
          <i class="dropdown icon"></i>
          <div class="text">{{$parameter->definition->display_key}}</div>

          <div class="menu">
            @if($product->categories->count() > 0)
            @foreach (App\Category::find($product->categories->first()->id)->parameters as $param)
              @include('products.paramoptions')
            @endforeach
            @endif
          </div>
        </div>

        <div class="ui input value"><input type="text" name="value[]" value="{{$parameter->value}}"/></div>

        <div class="ui icon red button delete_product_param"><i class="delete icon"></i></div>

      </div>
      @endforeach
      @endif
    </div>

    <div class="ui teal button" id="edit_product_add_param_row">Pridaj</div>

    <div class="ui header">Zadný obal</div>


    <div class="ui fluid input">
        <input type="text" name="back1" value="{{$product->back1}}" />
    </div>


    <div class="ui fluid input">
        <input type="text" name="back2" value="{{$product->back2}}" />
    </div>



    <div class="ui fluid input">
        <input type="text" name="back3" value="{{$product->back3}}" />
    </div>


    <div class="ui header">Doporúčane produkty</div>

    <div class="ui fluid multiple search normal selection dropdown">
      <input type="hidden" name="related_products[]">
      <i class="dropdown icon"></i>
      <div class="default text">Hľadať produkt</div>
      <div class="menu">
        @foreach(App\Product::where('id', "!=", $product->id)->get() as $pro)
        <div class="item" data-value="{{$pro->id}}">{{$pro->name}}</div>
        @endforeach
      </div>
    </div>


 </div>
</div>


<div id="product_options">
 <div class="container">
  <button type="submit" class="ui green button" id="edit_product_submit">Ulož zmeny</button>
  <a href="{{route('product.detail',['url'=>$product->url])}}" class="ui red button">Zruš editáciu</a>

</div>
</div>

</form>
@stop