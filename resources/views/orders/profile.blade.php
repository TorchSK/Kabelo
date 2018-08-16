@extends('layouts.master')
@section('content')

	<div class="order_detail" data-orderid="{{$order->id}}">

		<div class="header section">

			<div class="status_div">
				<text>Stav: </text>
				<div class="ui big label status" data-statusid="{{$order->status->id}}">{{$order->status->name}}</div>
			</div>

		</div>

		<div class="detail section">
		
		<div class="tabbs">

			<div class="tabs">

			    <div class="tabb ui brown button" data-tab="detail">Detail</div>
	

			</div>

		  	<div class="contents">

		    	<div class="content par active" data-tab="detail">

		    		<table class="ui very basic collapsing unstackable table">
		    			<thead >
					    <tr><th colspan="2">
					      Detaily
					    </th>
					  </tr></thead>
					  <tbody>
					    <tr>
					      <td>Číslo objednávky</td>
					      <td>{{$order->id}}</td>
					    </tr>
					    <tr>
					      <td>Dátum vytvorenia</td>
			      		  <td>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</td>
					    </tr>
					    <tr>
					      <td>Zákazník</td>
					      <td>
					      	@if($order->user)
					      	{{$order->user->email}}
					      	@else
					      	<i>Neprihlásený</i>
					      	@endif
					      </td>
					    </tr>
					  </tbody>
					</table>

		    		<table class="ui very basic collapsing unstackable table">
		    			<thead >
					    <tr><th colspan="2">
					      &nbsp;
					    </th>
					  </tr></thead>
					  <tbody>
					    <tr>
					      <td>Sposob doručenia</td>
					      <td>{{$order->delivery->name}}</td>
					    </tr>
					    <tr>
					      <td>Sposob platby</td>
					      <td>{{$order->payment->name}}</td>
					    </tr>
					        <tr>
					      <td>Cenové zaradenie</td>
					      <td>
					      	@if($order->user && $order->user->voc)
					      	VOC
					      	@else
					      	MOC
					      	@endif
					      </td>
					    </tr>
					  </tbody>
					</table>
					

		    		<table class="ui very basic collapsing unstackable table">
		    			<thead >
					    <tr><th colspan="2">
					      &nbsp;
					    </th>
					  </tr></thead>
					  <tbody>
					    <tr>
					      <td>Cena za tovar</td>
					      <td>{{$order->price}} €</td>
					    </tr>
					    <tr>
					      <td>Cena za dopravu</td>
					      <td>{{$order->shipping_price}} €</td>
					    </tr>
					    <tr>
					      <td>Celková cena</td>
					      <td>{{$order->price + $order->shipping_price}} €</td>
					    </tr>
					  </tbody>
					</table>

				<div id="order_detail_prodcuts" class="order_products_list">
					@foreach($order->products as $product)
						@include('orders.product')
					@endforeach

				</div>

	    		<table class="ui very basic collapsing unstackable table">
	    			<thead >
				    <tr><th colspan="2">
				      Fakturačné údaje
				    </th>
				  </tr></thead>
				  <tbody>
				    <tr>
				      <td>Meno</td>
				      <td>{{json_decode($order->invoice_address)->name}}</td>
				    </tr>
				    <tr>
				      <td>Ulica</td>
				      <td>{{json_decode($order->invoice_address)->street}}</td>
				    </tr>
				    <tr>
				      <td>Mesto</td>
				      <td>{{json_decode($order->invoice_address)->city}}</td>
				    </tr>
				    <tr>
				      <td>PSČ</td>
				      <td>{{json_decode($order->invoice_address)->zip}}</td>
				    </tr>
					<tr>
				      <td>email</td>
				      <td>{{json_decode($order->invoice_address)->email}}</td>
				    </tr>
				    @if(isset(json_decode($order->invoice_address)->ico))
				    <tr>
				      <td>IČO</td>
				      <td>{{json_decode($order->invoice_address)->ico}}</td>
				    </tr>
				    @endif
				    @if(isset(json_decode($order->invoice_address)->dic))
				    <tr>
				      <td>DIČ</td>
				      <td>{{json_decode($order->invoice_address)->dic}}</td>
				    </tr>
				    @endif
				    @if(isset(json_decode($order->invoice_address)->icdph))
				    <tr>
				      <td>IČDPH</td>
				      <td>{{json_decode($order->invoice_address)->icdph}}</td>
				    </tr>
				    @endif
				  </tbody>
				</table>


				
				</div>


	
		    
		  </div>

		</div>
	</div>
	</div>

@stop