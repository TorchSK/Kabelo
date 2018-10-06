@extends('layouts.admin')
@section('content')

          <div id="admin_products_wrapper" class="admin_wrapper">


            @if ($category!='unknown')

            <div class="ui horizontal divider active title">Parametre kategórie</div>

            <form action="{{route('category.update',['category'=>$category->id])}}" method="POST" class="admin_category_attributes">
              {{ csrf_field() }}

          <input type="hidden" name="_method" value="PUT" />

              <div class="ui fluid labeled input" data-attribute="name">
                   <div class="ui label">Názov</div>
                   <input type="text" name="name" value="{{$category->name}}" />
              </div>

                <div class="ui fluid labeled input" data-attribute="url">
                  <div class="ui label">URL</div>
                   <input type="text" name="url" value="{{$category->url}}" />
              </div>

                <div class="ui fluid labeled input" data-attribute="url">
                  <div class="ui label">Popis</div>
                   <input type="text" name="desc" value="{{$category->desc}}" />
              </div>
              
              <div class="ui fluid labeled input" data-attribute="url">
                  <div class="ui label">Title</div>
                   <input type="text" name="title" value="{{$category->title}}" />
              </div>
              
                <div class="ui fluid labeled input" data-attribute="url">
                  <div class="ui label">Keywords</div>
                   <input type="text" name="keywords" value="{{$category->keywords}}" />
              </div>
              
              
              <button type="submit" class="ui green button" id="edit_category_submit" data-categoryid="{{$category->id}}">Ulož</button>

            </form>


            <div class="ui horizontal divider active title">Obrázok kategórie</div>
 
            <div id="category_image_div" data-categoryid="{{$category->id}}">

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

            @if($appname=='kabelo')
            <div class="ui horizontal divider active title">Parametre / Filtre</div>

            <div class="admin_filters">

              <div class="active">
              <select class="ui fluid search dropdown" multiple="" id="admin_category_params_selection">
              @foreach (App\Parameter::all() as $param)
                <option value="{{$param->id}}" @if(App\Category::find($category->id)->parameters->contains($param->id)) selected @endif>{{$param->display_key}}</option>
              @endforeach
              </select>
            </div>  

            
            </div>
            @endif
            @endif


 
         </div>

@stop