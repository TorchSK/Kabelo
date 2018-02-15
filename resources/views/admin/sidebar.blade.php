  <div id="filters">

  	<div>
                <div id="product_search">
                    <div class="ui left icon huge input">
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <div class="categories">
                	<div class="sidebar_btn item">
						<a href="/admin/products">Admin prehlad</a>
                	</div>
					<div class="ui horizontal divider">Pridaj</div>

                	<div class="sidebar_btn">
   					<a href="/admin/import" class="ui fluid green button"><i class="cloud upload icon"></i>Import zo súboru</a>
   					</div>

                	<div class="sidebar_btn">
   					<div class="ui fluid blue button" id="add_category_btn"><i class="add icon"></i>Pridaj kategóriu</div>
   					</div>


					<div class="ui horizontal divider">Kategórie</div>

   					<div class="ui mini modal" id="add_category_modal">
					  
					  <div class="header">
					    Pridaj kategóriu
					  </div>
					  <div class="content">

					  	<div class="label">Nadradená kategória</div>
				  	    <div class="ui fluid selection dropdown" id="add_category_parent_input">
					      <input type="hidden" name="parent_id" value="">
					      <i class="dropdown icon"></i>
					      <div class="default text">Vyberte kategóriu</div>
					      <div class="menu">
					        @foreach (App\Category::orderBy('order','asc')->get() as $category)
					        	<div class="item" data-value="{{$category->id}}">{{$category->name}}</div>
					        @endforeach
					      </div>
					    </div>

					  	<div class="label">Názov</div>

					    <div class="ui fluid input">
					    	<input type="text" placeholder="Názov" id="add_category_input"/>
					    </div>
					  </div>
					  
					  <div class="actions">
					    <div class="ui black deny button">
					      Zruš
					    </div>
					    <div class="ui positive right labeled icon button">
					      Pridaj
					      <i class="checkmark icon"></i>
					    </div>
					  </div>
					</div>
					
					@if ($categories->count() > 0 )
					@foreach ($categories as $category)
						<a href="/admin/category/{{$category->id}}/products" class="item @if(Request::segment(1)=='admin' && Request::segment(2)=='category' && Request::segment(3) == $category->id) active @endif @if($category->parent_id) subcategory @else category @endif" data-categoryid="{{$category->id}}">
							@if($category->parent_id)
							<i class="circle thin icon"></i> 
							@endif
							{{$category->name}}
							<count>{{$category->products()->count()}}</count>
						</a>

					@endforeach
					@else
						<div class="ct">
						Žiadne kategórie
						</div>
					@endif


                </div>

                <div class="ui horizontal divider">Nezaradane produkty</div>
   				<div class="sidebar_btn">
   				<a href="/admin/category/unknown/products" class="ui fluid button">Ukázať <i>({{App\Product::doesntHave('categories')->count()}})</i></a>
   				</div>


   			</div>
</div>
