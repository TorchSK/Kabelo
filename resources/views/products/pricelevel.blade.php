<div class="product_price_level">

	<div class="ui labeled fluid input">
  		<div class="ui label">ks</div>
 		<input type="text" name="thresholds[]" placeholder="Min. počet kusov" @if(isset($priceLevel)) value="{{$priceLevel->threshold}}" @endif >
	</div>

	<div class="ui grid four column">
		<div class="column">
			<div class="ui fluid labeled input">
		  		<div class="ui label">MOC</div>
		 		<input type="text" name="mocs[]" placeholder="" @if(isset($priceLevel)) value="{{$priceLevel->moc_regular}}" @endif>
			</div>
		</div>

		<div class="column">
			<div class="ui fluid labeled input">
		  		<div class="ui label">MOC *</div>
		 		<input type="text" name="moc_sales[]" placeholder="" @if(isset($priceLevel)) value="{{$priceLevel->moc_sale}}" @endif>
			</div>
		</div>

		<div class="column">
			<div class="ui fluid labeled input">
		  		<div class="ui label">VOC</div>
		 		<input type="text" name="vocs[]"placeholder="" @if(isset($priceLevel)) value="{{$priceLevel->voc_regular}}" @endif>
			</div>
		</div>

		<div class="column">
			<div class="ui fluid labeled input">
		  		<div class="ui label">VOC *</div>
		 		<input type="text" name="voc_sales[]" placeholder="" @if(isset($priceLevel)) value="{{$priceLevel->voc_sale}}" @endif>
			</div>
		</div>

	
	</div>

</div>