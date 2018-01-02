@extends('layouts.master')
@section('content')

       
        <div id="admin" class="content">

            <div id="filters">

                <div id="product_search">
                    <div class="ui left icon huge input">
                      <input type="text" placeholder="Hľadaj produkt...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <div class="makers">
   					<div class="ui fluid brown button" id="add_maker_btn"><i class="add icon"></i>Pridaj výrobcu</div>

   					<div class="ui tiny modal" id="add_maker_modal">
					  
					  <div class="header">
					    Pridaj výrobcu
					  </div>
					  <div class="content">
					    <div class="ui fluid input">
					    	<input type="text" placeholder="Názov" />
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

					@if ($makers->count() > 0 )
					@foreach ($makers as $maker)


					@endforeach
					@else
						Žiadny výrobcovia
					@endif


                </div>

                <div class="categories">
                   
                </div>


            </div>

            <div id="grid">

           </div>

 

    </div>

@stop