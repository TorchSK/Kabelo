@extends('layouts.admin')
@section('content')

<form action="/product/{{$product->id}}" method="POST">

  <input name="_method" type="hidden" value="PUT">


<div id="product_options" class="ct">
 <div class="container ct">
  <button type="submit" class="ui teal button" id="edit_product_submit">Ulož zmeny</button>
  <a href="/{{Request::segment(1)}}/{{Request::segment(2)}}/detail" class="ui red button">Zruš editáciu</a>

</div>
</div>

<div id="product_detail" data-id="{{$product->id}}">
      <div class="left">
        <div class="img">

       <div class="edit_product_images">
          @foreach($product->images as $image)
            <div class="image_div @if($image->primary) primary @endif" data-fileid="{{$image->id}}">
              <img src="/{{$image->path}}" width="200px" class="ui image " />
              <div class="edit_product_images_actions">
                <a class="ui circular red label delete_img"><i class="remove icon"></i> Zmaž</a>
                <a class="ui circular blue icon label make_primary_img"><i class="star icon"></i> Primárny</a>
              </div>
           </div>
           @endforeach 
        </div>

        <div class="edit_images">
           <div action="/file/upload" class="dropzone" id="product_detail_dropzone">
            <input name="_token" hidden value="{!! csrf_token() !!}" />
            <div class="dz-message">Klikni pre nahranie súboru</div>

          </div>
         </div>
       </div>

    <div class="ui grid three column">

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

          <div class="ui selection dropdown" id="edit_product_unit_input">
            <input type="hidden" name="unit" value="m">
            <i class="dropdown icon"></i>
            <div class="text">m</div>
            <div class="menu">
              <div class="item" data-value="m">m</div>
              <div class="item" data-value="ks">ks</div>
            </div>
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

    <div class="right">
      
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
    <select multiple="" name="categories[]" id="edit_product_categories_input" class="ui fluid normal dropdown">
    <option value="">Kategória</option>
    @foreach (App\Category::all() as $category)
    <option value="{{$category->id}}" @if(in_array($category->id, $product->categories->pluck('id')->toArray())) selected="true" @endif>{{$category->name}}</option>
    @endforeach
    </select>

    <div class="ui header">Popis</div>

    <div class="ui form">
      <div class="field" id="edit_product_desc_input">
        <textarea name="desc">{{$product->desc}}</textarea>
      </div>
    </div>

      <div class="ui header">Dostupné vo farbe</div>
      <div class="product_color choosable"></div>

      <div class="ui popup transition hidden">
       <div class="product_color pickable"></div>
      <div class="product_color pickable"></div>
       <div class="product_color pickable"></div>
       <div class="product_color pickable"></div>
      </div>
      
      <div class="ui teal button" id="edit_product_add_param_row">Pridaj</div>



    <div class="ui header">Parametre</div>

    <div id="edit_product_params">
      @if ($product->parameters->count() == 0)
        <div class="row">
        <div class="ui search selection dropdown">
          <input type="hidden" name="key[]">
          <i class="dropdown icon"></i>
            <div class="default text">Parameter</div>

          <div class="menu">
            @foreach (App\Category::find($product->categories->first()->id)->parameters as $param)
              @include('products.paramoptions')
            @endforeach
          </div>
        </div>
        <div class="ui input value"><input type="text" name="value[]" /></div>
      </div>

      @else

      @foreach ($product->parameters as $parameter)
      <div class="row">
        <div class="ui search selection dropdown">
          <input type="hidden" name="key[]" value="{{$parameter->categoryParameter->id}}">
          <i class="dropdown icon"></i>
          <div class="text">{{$parameter->categoryParameter->display_key}}</div>

          <div class="menu">
            @foreach (App\Category::find($product->categories->first()->id)->parameters as $param)
              @include('products.paramoptions')
            @endforeach
          </div>
        </div>
        <div class="ui input value"><input type="text" name="value[]" value="{{$parameter->value}}"/></div>
      </div>
      @endforeach
      @endif
    </div>

    <div class="ui teal button" id="edit_product_add_param_row">Pridaj</div>


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

</form>
@stop