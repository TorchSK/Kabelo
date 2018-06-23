@extends('layouts.admin')
@section('content')

       

          @include('admin.sidebar')

          <div class="right">


            @if ($category!='unknown')

            <div class="ui horizontal divider active title">URL kategórie</div>

              <div class="ui labeled input" id="edit_product_name_input">
                 <div class="ui label">Názov</div>
                 <input type="text" value="{{$category->name}}" />
            </div>

              <div class="ui labeled input" id="edit_product_url_input">
                <div class="ui label">URL</div>
                 <input type="text" value="{{$category->url}}" />
            </div>
            <br />
            <a class="ui green button" id="edit_category_submit" data-categoryid="{{$category->id}}">Ulož</a>

            <div class="ui horizontal divider active title">Obrázok kategórie</div>
 
            <div id="category_image_div">

              <div>@include('categories.image')</div>

              <form action="/category/image/upload" class="dropzone" id="category_image_dropzone"> 
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
              </form>
              <div class="crop_preview"></div>
              <div><div class="crop_ok ui green button" data-categoryid="{{$category->id}}">OK</div></div>
            </div>

            <div class="ui horizontal divider active title">Podkategórie</div>

            <div class="subcategories" id="category_subcat_div">
              @foreach($category->children->sortBy('order') as $child)
                @include('categories.image',['category'=>$child])
              @endforeach 

              <div class="add_category_btn">
                <i class="big icons">
                  <i class="plus brown icon"></i>
                </i>
                <div class="text">Pridaj subkategóriu</div>
              </div>
            </div>


            <div class="ui horizontal divider active title">Parametre / Filtre</div>

            <div class="admin_filters">

              <div class="active">
              @foreach (App\CategoryParameter::where('category_id', $category->id)->get() as $param)
                <div class="item">
                  <key>{{$param->key}}</key>
                  <dkey>({{$param->display_key}})</dkey>
                  <a href="/category/parameter/{{$param->id}}/edit" class="ui small teal button" id="admin_change_category_param_btn">Zmeň</a>
                </div>
              @endforeach
            </div>  

              <form action="/category/parameter/add" method="POST">
                <input name="_token" hidden value="{!! csrf_token() !!}" />
                <input name="category_url" hidden value="{!! $category->url !!}" />

                <div id="admin_filters_div">
                <div class="row">
                <div class="ui input"><input type="text" placeholder="Kluc" name="keys[]" /></div>
                <div class="ui input"><input type="text" placeholder="Zobrazenie" name="dkeys[]" /></div>
                </div>
                </div>

                <br/>

                <div class="ui blue button" id="admin_add_category_param_btn">Pridaj parameter</div>
                <button type="submit" class="ui green button" id="admin_submit_category_param_btn">Ulož</button>
              </form>

            </div>
            @endif


            <div class="ui horizontal divider active title">Produkty</div>

            <div id="grid">
            
            @if ($category!='unknown')
				      <a class="item new_product_btn" href="/product/create?category={{$category->id}}">
    					   <i class="huge icons">
    					  <i class="plus brown icon"></i>
    					</i>
    					Pridaj produkt
    				</a>
        @endif

    		@foreach ($products as $product)
    			@include('products.row')
    		@endforeach
           </div>

 
         </div>

@stop