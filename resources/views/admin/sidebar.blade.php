  <div id="filters">

                <div id="product_search">
                    <div class="ui left icon huge input">
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <div class="categories">
                	<div class="sidebar_btn">
   					<div class="ui fluid brown button" id="add_category_btn"><i class="add icon"></i>Pridaj kategóriu</div>
   					</div>
   					<div class="sidebar_btn">
   					<a href="/product/create" class="ui fluid blue button"><i class="add icon"></i>Pridaj produkt</a>
   					</div>

					<div class="ui horizontal divider">Kategórie</div>

   					<div class="ui mini modal" id="add_category_modal">
					  
					  <div class="header">
					    Pridaj kategóriu
					  </div>
					  <div class="content">
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
						<a href="/admin/category/{{$category->id}}/products" class="item @if(Request::segment(1)=='admin' && Request::segment(2)=='category' && Request::segment(3) == $category->id) active @endif">
							{{$category->name}}
						</a>

					@endforeach
					@else
						Žiadne kategórie
					@endif


                </div>


            </div>
