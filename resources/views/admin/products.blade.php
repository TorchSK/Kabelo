@extends('layouts.master')
@section('content')

       
        <div id="admin" class="content">

          @include('admin.sidebar')

          <div class="right">


            @if (Request::segment(3) != 'unknown')
            <div class="ui horizontal divider active title">Obrázok</div>
 

            <div id="category_image_div">

              <div>@include('categories.row')</div>

              <form action="/category/image/upload" class="dropzone" id="category_image_dropzone"> <input name="_token" hidden value="{!! csrf_token() !!}" /></form>
              <div class="crop_preview"></div>
              <div><div class="crop_ok ui button" data-categoryid="{{$category->id}}">OK</div></div>
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
                <input name="category_id" hidden value="{!! $category->id !!}" />

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
              @if (isset($category))
            <div class="item new_product_btn">
				      <a href="/product/create?category={{$category->id}}">
					   <i class="huge icons">
					  <i class="big thin brown circle icon"></i>
					  <i class="plus brown icon"></i>
					</i>
					Pridaj produkt
				</a>
				</div>
        @endif

    		@foreach ($products as $product)
    			@include('products.row')
    		@endforeach
           </div>

 
         </div>
    </div>

@stop