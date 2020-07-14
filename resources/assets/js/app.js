
$(document).ready(function(){

//$('img.lazy').Lazy();

$(document).on('click', '.to_cart',function(){
  $product = $(this).closest('.product').data('productid');
  $product_code = $(this).closest('.product').data('productcode');
  $product_name = $(this).closest('.product').find('.title').text();
  var cart = $('#header .cart.item');
  var img = $(this).closest('.product').find('.image_div');
  $qty = $(this).closest('.product').data('minqty');

  if($(this).hasClass('sizes'))
  {
  	$('#sizes_modal').modal('setting', {
  		duration: 200,
  		onShow: function(){	
  			$('#sizes_modal').find('.image img').attr('src',img.find('img').attr('src'));
  			$('#sizes_modal > .header').html($product_name);

  			$.get('/api/product/'+$product+'/sizes',{}, function(data){
  				$('#sizes_modal').find("#sizes").html('');
  				$(data).each(function(i,e){
  					if(e.stock=='PRODEJ UKONČEN')
  					{
  						$class='inactive';
  					}
  					else
  					{
  						$class="active";
  					}

  					if(e.size_code==$product_code)
  					{
  						$selected=' selected';
  					}
  					else
  					{
  						$selected="";
  					}

  					$('#sizes_modal').find("#sizes").append('<div class="size '+$class+$selected+'" data-code="'+e.size_code+'">'+e.text+'</div>');

  					$('#sizes_modal .size.active').click(function(){
						$('#sizes_modal .size').removeClass('selected');
						$(this).addClass('selected');
					})


  				});
  			})
  		},	

	    onApprove : function() {
	    	$size = $('#sizes_modal').find('.selected.size').data('code');
	      	addToCart($product, $qty, $size);
	      	flyToElement(img, cart);

	 	}
	  }).modal('show');
  }
  else
  {
  	flyToElement(img, cart);
  	addToCart($product, $qty);
  }

});


// append csrf token to all ajax calls
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var path = window.location.href.split( '/' );
console.log(path);

if (path[3] != '' && path[3]!='admin' && $( window ).width() > 680)
{
  scrollTo('#grid.main');
}

// scrolTo smooth 
function scrollTo(element){
  if($(element).length){
  $('html,body').scrollTop($(element).offset().top);  
  }
}

window.onpopstate = function(event) {
    if(event && event.state) {
        location.reload()
    }
}

$('.ui.checkbox').checkbox();

$('#header .account.item').popup({
	popup : $('#auth_popup'),
	on    : 'click'
});

$('#header .catalogues.item').popup({
	popup : $('#catalogues_popup'),
	on    : 'hover',
	hoverable: true

});

$('#header .cart.item').popup({
	popup : $('#cart_popup'),
	on    : 'hover',
	hoverable: true

});

$('#header .cart.item').click(function(){
	window.location.href = $(this).attr('href');
});


$('.register_form').click(function(){
	$popup = $('#auth_popup');
	$email = $('#register_div').find('input[name="email"]').val();
	$password = $('#register_div').find('input[name="password"]').val();


})


$('.login_form').submit(function(){
	$validation = 1;

  $popup = $('#auth_popup');
  $email = $('#login_div').find('input[name="email"]').val();
	$password = $('#login_div').find('input[name="password"]').val();

  if ($validation==1){
    return true
  } else {
    return false;
  }


});

$('.add_category_btn').click(function(){
	$('#add_category_modal').modal('setting', {
    autofocus: false,
    onShow: function(){
    	$('.dropdown').dropdown();
    },
    onApprove : function() {
    	$name = $('#add_category_input').val();
      	$parent_id = $('input[name="parent_id"]').val();

    	$.ajax({
    		type: "POST",
    		url: "/category",
    		data: {name: $name, parent_id:$parent_id},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})


$('#create_product_add_param_row').click(function(){
  $html = $('#create_product_params .row:first-child').html();
  $('#create_product_params').append('<div class="row">'+$html+'</div>');
  $('.ui.dropdown').dropdown();
})

$('#edit_product_add_param_row').click(function(){
  $html = $('#param_template .row').html();
  $('#edit_product_params').append('<div class="row">'+$html+'</div>');
  $('.ui.dropdown').dropdown();
})

$('#create_product_categories_input').dropdown({
  maxSelections: 1,
  onAdd: function(addedValue, addedText, $addedChoice){
    console.log(addedValue);
  }
})



$('#create_product_form').submit(function(e){
  $validation = 1;

  $name = $('#product_main_wrapper input[name="name"]').val();
  $code = $('#product_main_wrapper input[name="code"]').val();
  $maker = $('#product_main_wrapper input[name="maker"]').val();
  $threshold = $('#product_main_wrapper input[name^="thresholds"]').val();
  $moc = $('#product_main_wrapper input[name^="mocs"]').val();
  $mocs = $('#product_main_wrapper input[name^="moc_sales"]').val();
  $voc = $('#product_main_wrapper input[name^="vocs"]').val();
  $vocs = $('#product_main_wrapper input[name^="voc_sales"]').val();

  if ($name=='') {$validation=0; $('#product_main_wrapper input[name="name"]').parent().addClass('error');}
  if ($code=='') {$validation=0; $('#product_main_wrapper input[name="code"]').parent().addClass('error');}
  if ($maker=='') {$validation=0; $('#product_main_wrapper input[name="maker"]').parent().addClass('error');}
  if ($threshold=='') {$validation=0; $('#product_main_wrapper input[name^="thresholds"]').parent().addClass('error');}
  if ($moc=='') {$validation=0; $('#product_main_wrapper input[name^="moc"]').parent().addClass('error');}
  if ($mocs=='') {$validation=0; $('#product_main_wrapper input[name^="mocs"]').parent().addClass('error');}
  if ($voc=='') {$validation=0; $('#product_main_wrapper input[name^="voc"]').parent().addClass('error');}
  if ($vocs=='') {$validation=0; $('#product_main_wrapper input[name^="vocs"]').parent().addClass('error');}

 if ($validation==1)
 {
    return true
  }

  return false;
})



$('.other_img .img').click(function(e){
	e.preventDefault();
  $('#product_main_wrapper .img.main img').attr('src', '/img/loader.gif');

  $index = $(this).find('img').data('index');

  $('#product_main_wrapper').data('index', $index);

  var img = new Image() 
  var src = $(this).find('img').data('full');
  img.src = src;

  img.onload = function() {
  	$('#product_main_wrapper .img.main img').attr('src', src);
  	 $('#product_main_wrapper .img.main').attr('href', src);
  };


});

$('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;


function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 5;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top+80 + "px", left: $(flyer).offset().left+100 + "px", opacity: 1, 'z-index': 1000});
    $('body').append($(flyerClone));
    $(flyerClone).width('350');
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;
     
    $(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY,
        width: $(flyer).width()/divider,
        height: $(flyer).height()/divider
    }, 700,
    function () {
        $(flyingTo).fadeOut('fast', function () {
            $(flyingTo).fadeIn('fast', function () {
                $(flyerClone).fadeOut('fast', function () {
                    $(flyerClone).remove();
                });
            });
        });
    });
}


function addToCart(productid, qty, size=null){
  var cart = $('#header .cart.item');
  var price = parseFloat(cart.find('price number').text());
  var cartid = $('.content.cart').data('cartid');
  var cartpopup = $('#cart_popup');

  data = {};
  data['qty'] = qty;	

  if(size!=null) data['size'] = size;

  $.ajax({
    method: "POST",
    url: '/cart/'+cartid+"/"+productid,
    data: data,
    global: false,
    success: function(data){
    	console.log(data);
      	cart.find('.label').text(data.count);
      	cart.find('price number').text(parseFloat(price+parseFloat(data.price)).toFixed(2));
      	cartpopup.find('.button').before(data.row);
      	cartpopup.find('.noitems').hide();
    }
  })
}


$('#product_detail_tocart_btn').click(function(){
  $product = $('#product_main_wrapper').data('id');
  $qty = $(this).data('qty');
  $size = $('#product_main_wrapper .sizes .size.selected').data('code');

  var cart = $('#header .cart.item');
  var img = $('#product_main_wrapper').find('.img');
  flyToElement(img, cart);
  
  addToCart($product, $qty, $size);

})




$(document).on('click','.delete_cart', function(){
	console.log(1);
    $('#delete_cart_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/cart/all",
        data: {},
        success: function(){
          location.replace('/cart/products');
        }
      })
    }
  }).modal('show');
})


$(document).on('click','.catalogue_delete_btn', function(){
	$catalogueid = $(this).closest('.catalogue').data('id');
    $('#delete_catalogue_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/file/"+$catalogueid,
        data: {},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})


$('.catalogue_primary_btn').click(function(){

$catalogueid = $(this).closest('.catalogue').data('id');

 $.ajax({
    type: "PUT",
    url: "/file/"+$catalogueid,
    data: {'primary':1},
    success: function(){
      location.reload();
    }
  })
})

$('.catalogue_save_btn').click(function(){

$catalogueid = $(this).closest('.catalogue').data('id');
$path = $(this).closest('.catalogue').find('input').val();
$(this).addClass('loading');

 $.ajax({
    type: "PUT",
    url: "/file/"+$catalogueid,
    data: {'path':$path},
    success: function(){
      location.reload();
    }
  })
})

$('.cart_delete_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $cartid = $('.cart.content').data('cartid');

  $.ajax({
    type: "DELETE",
    url: "/cart/"+$cartid+"/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

$('.cart_plus_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $.ajax({
    type: "POST",
    url: "/cart/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

$('.cart_minus_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $.ajax({
    type: "PUT",
    url: "/cart/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

///// Sorting and filtering ////////

function getActiveFilters(){
  
  $filters={};
  $filters['parameters'] = {};

  $('#active_filters span').each(function(index, element){
    var group = $(element).data('group');
    var filter = $(element).data('filter');

    if ($(element).data('group'))
    {

      $filters[group][filter] = [];
    }
    else
    {
      $filters[$(element).data('filter')]={};
    }
  });

  console.log($filters);

  $('#active_filters span').each(function(index, element) {
      var group = $(element).data('group');
      var filter = $(element).data('filter');
      if (group!=null)
      {
        $filters[group][filter].push($(element).data('value'));
      }
      else
      {
        $filters[filter] = $(element).data('value');
      }
    });

  return $filters;
}

function getActiveCategory(){
  return $('#category_path_wrapper').data('categoryid');
}

function getDesiredSortBy(){
  return $('.sort.active').data('sortby');
}

function getDesiredSortOrder(){
  return $('.sort.active').data('sortorder');
}



filtersInit();


function initCoverHeightSlider(){

    var checkExists = $('#cover_height_slider').length;

    if (checkExists)
    {

      if ($('#cover_height_slider')[0].noUiSlider)
      {
        $('#cover_height_slider')[0].noUiSlider.destroy();
      }

      var coverHeightSLider = document.getElementById('cover_height_slider');

      noUiSlider.create(coverHeightSLider, {
        start: $('input[name="cover_height"]').val(),
        connect: [true,false],
        range: {
          'min': 0,
          'max': 1000
        },
        format: wNumb({
            decimals: 0,
          }),
        
        step: 1
      });

      coverHeightSLider.noUiSlider.on('slide', function()
      {
      	$('input[name="cover_height"').val(coverHeightSLider.noUiSlider.get());
      	chanegCoverHeight((coverHeightSLider.noUiSlider.get()));
      });

    }
}

function initCoverWidthSlider(){

    var checkExists = $('#cover_width_slider').length;

    if (checkExists)
    {

      if ($('#cover_width_slider')[0].noUiSlider)
      {
        $('#cover_width_slider')[0].noUiSlider.destroy();
      }

      var coverHeightSLider = document.getElementById('cover_width_slider');

      noUiSlider.create(coverHeightSLider, {
        start: $('input[name="cover_width"]').val(),
        connect: [true,false],
        range: {
          'min': 50,
          'max':90
        },
        format: wNumb({
            decimals: 0,
          }),
        
        step: 1
      });

      coverHeightSLider.noUiSlider.on('slide', function()
      {
      	$('input[name="cover_width"').val(coverHeightSLider.noUiSlider.get());
      	changeCoverWidth((coverHeightSLider.noUiSlider.get()));
      });

    }
}

function changeCoverWidth(width){
	$('.banner_preview .cover').width(width+'%');
	$('#cover_dimensions_settings').find('width').text($('.banner_preview .cover').width());

	$coverRatio = ($('.banner_preview .cover').width()/$('.banner_preview .cover').height()).toFixed(2)
	$('#cover_dimensions_settings').find('ratio').text($coverRatio);
	
	$bannerRatio = ($('.banner_preview .banner').width()/$('.banner_preview .banner').height()).toFixed(2)
	$('#banner_dimensions_settings').find('ratio').text($bannerRatio);

	$('#banner_dimensions_settings').find('width').text($('.banner_preview .banner').width());
	
	$('input[name="cover_ratio"]').val($coverRatio);
	$('input[name="banner_ratio"]').val($bannerRatio);
}

function chanegCoverHeight(height){
	$('.banner_preview .cover').height(height-2);
	$('.banner_preview .banners').height(height);

	$('#cover_dimensions_settings').find('height').text($('.banner_preview .cover').height());

	$coverRatio = ($('.banner_preview .cover').width()/$('.banner_preview .cover').height()).toFixed(2)
	$('#cover_dimensions_settings').find('ratio').text($coverRatio);
	
	$bannerRatio = ($('.banner_preview .banner').width()/$('.banner_preview .banner').height()).toFixed(2)
	$('#banner_dimensions_settings').find('ratio').text($bannerRatio);

	$('#banner_dimensions_settings').find('height').text($('.banner_preview .banner').height());
	
	$('input[name="cover_ratio"]').val($coverRatio);
	$('input[name="banner_ratio"]').val($bannerRatio);

}


$('#banners_visible_checkbox').checkbox({
  onChecked: function(){
    $('.banner_preview').find('.banners').show();
	$('.banner_preview .cover').width($('input[name="cover_width"').val()+'%');
	$('#cover_width_setting').show();

  },
  onUnchecked: function(){
     $('.banner_preview').find('.banners').hide();
	 $('.banner_preview .cover').width('100%');
	 $('#cover_width_setting').hide();
  }
})


initCoverHeightSlider();
initCoverWidthSlider();

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function doSort(){

  //console.log(getPriceFilter('price'));

  $grid = $('#grid_wrapper').find('grid');
  $filtersDiv = $('#filterbar').find('.params');

  $sortBy = getDesiredSortBy();
  $sortOrder = getDesiredSortOrder();

  $filters = getActiveFilters();
  $categoryid = getActiveCategory();

  $page = getUrlParameter('page');

  $.get('/product/list',{category: $categoryid, sortBy: $sortBy, sortOrder: $sortOrder, filters: $filters, page: $page}, function(data){
    $grid.html(data.products);

    $filtersDiv.html(data.filters);
    
    filtersInit();
     $('img.ui.image').Lazy();

    $('#grid_wrapper').find('.dimmer').removeClass('active');
    $('#grid_wrapper').show();
    $('.sorts').show();
    $('#price_slider').show();
    $('.sort').removeClass('loading');

    $grid.on('click','.view_more_button',function(){
    	$('.view_more_button').addClass('loading');
    	$.get($('#next_page').attr('href'),{category: $categoryid, sortBy: $sortBy, sortOrder: $sortOrder, filters: $filters}, function(data){
    		$('#grid_div').remove();
    		$grid.find('.item').last().after($(data.products));
   		    $('#grid_wrapper').find('.dimmer').removeClass('active');
   		    $('.view_more_button').removeClass('loading');
   		         $('img.ui.image').Lazy();

    	});
    })
  })

};

if ($('body').attr('id')=='category_products_body' || $('body').attr('id')=='search_body')
{
	doSort();
}

function addFilter(key, value, desc, group=null){
  $('#active_filters').append('<span data-value="'+value+'" data-filter="'+key+'" data-group="'+group+'" class="'+key+' ui large teal label">'+desc+'<i class="delete icon"></i></span>');
}

function getPriceFilter(key){
  $div = $('#active_filters').find('span[data-filter="'+key+'"]')

  if ($div.length){
    $array = $div.data('value').split(',');
    return $array;
  }else{
    return [0,$('#grid_stats').data('maxprice')];
  }
}


function removeFilter(key, value=''){
  if(value=='')
  {
    $('#active_filters').find('span[data-filter="'+key+'"]').remove();
  }
  else
  {
    $('#active_filters').find('span[data-value="'+value+'"][data-filter="'+key+'"]').remove();
  }
}


$('.sort').click(function(){
	$(this).addClass('loading');
  if ($(this).hasClass('active'))
  {
    if ($(this).data('sortorder')=='asc')
    {
      if($(this).data('sortby')!='created_at') {$(this).data('sortorder','desc');}
      $(this).find('i').removeClass('ascending').addClass('descending');
    }
    else
    {
      if($(this).data('sortby')!='created_at') {$(this).data('sortorder','asc');}
      $(this).find('i').removeClass('descending').addClass('ascending');
    }
  }
  else
  {
    $('.sort').removeClass('active');
    $(this).addClass('active');
  }
  doSort();
})

function filtersInit(){
  $('#filterbar  .ui.checkbox').checkbox({
    onChecked: function(){
      $value = $(this).closest('.checkbox').data('value');
      $text = $(this).closest('.checkbox').find('label').text();
      $filter = $(this).closest('.checkbox').data('filter');
      $display = $(this).closest('.checkbox').data('display');

      addFilter($filter, $value, $display+': '+ $text, 'parameters')
      doSort();
    },
    onUnchecked: function(){
      $value = $(this).closest('.checkbox').data('value');
      $text = $(this).closest('.checkbox').find('label').text();
      $filter = $(this).closest('.checkbox').data('filter');
      $display = $(this).closest('.checkbox').data('display');

      removeFilter($filter,$value);
      doSort();
    }
  })
}



$('.categories .item .icon.plus').click(function(e){
  $(this).toggleClass('minus plus');
})

$('.categories .item .icon.minus').click(function(e){
  $(this).toggleClass('minus plus');
})




$(".cart_delivery.eshop").click(function(){
  $this = $(this);
	$deliveryNote = $this.data('note');

  if(!$this.hasClass('completed'))
  {
  $delivery = $(this).data('delivery_method');


  $('.cart_payment').each(function(index, element){
    $(element).removeClass('disabled completed active');
    if ($.inArray($delivery, $(element).data('delivery_methods'))==-1)
    {
      $(element).addClass('disabled');
    }
  });


  $shipping_price = parseFloat($(this).data('price'));

  $data = {delivery_method: $delivery};

  if ($('.cart_payment.completed.active').length && $(".cart_delivery.completed.active").length)
  {
  	$shipping_price = parseFloat($(this).data('price'));
  	$data['payment_method'] = '';
  	$data['shipping_price'] = $shipping_price;

  	$('#cart_shipping_price').find('price').text(parseFloat($data['shipping_price']));

  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	$('.cart_next').addClass('disabled');
  }


  if ($('.cart_payment.completed.active').length && !$(".cart_delivery.completed.active").length)
  {
  	$data['shipping_price'] = $shipping_price + parseFloat($('.cart_delivery.completed.active').data('price'));
  	 
  	 $('#cart_shipping_price').find('price').text(parseFloat($data['shipping_price']));

  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	$('.cart_next').removeClass('disabled');
  }


  if (!$('.cart_payment.completed.active').length && $(".cart_delivery.completed.active").length)
  {
  	$shipping_price = parseFloat($(this).data('price'));
  	$data['payment_method'] = '';
  	$(".cart_payment").removeClass('completed active');
  	$data['shipping_price'] = $shipping_price;
  	
  	$('#cart_shipping_price').find('price').text(parseFloat($data['shipping_price']));

  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	  	$('.cart_next').addClass('disabled');

  }

  if (!$('.cart_payment.completed.active').length && !$(".cart_delivery.completed.active").length)
  {
  	$shipping_price = parseFloat($(this).data('price'));
  	$data['payment_method'] = '';
  	$(".cart_payment").removeClass('completed active');

  	$data['shipping_price'] = $shipping_price;

	 $('#cart_shipping_price').find('price').text(parseFloat($data['shipping_price']));

  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  }

   $(".cart_delivery").removeClass('completed active');

  $.ajax({
    method: "POST",
    url: '/cart',
    data: $data,
    success: function(data){
    	if (!$this.hasClass('completed'))
    	{
    		$this.addClass('completed active');
    		$('#cart_info_wrapper').find('.delivery_note').html($deliveryNote);
    		if($deliveryNote)
    		{
    			$('#cart_info_wrapper').show();
    		}
    	}
    
    }
  });
}

})

$(".cart_payment.eshop").click(function(){
  $this = $(this);
  $paymentNote = $this.data('note');

  if(!$this.hasClass('completed'))
  {
  $payment = $(this).data('payment_method');
  
  $shipping_price = parseFloat($(this).data('price'));

  $data = {payment_method: $payment};

  if ($('.cart_payment.completed.active').length && $(".cart_delivery.completed.active").length)
  {
  	$shipping_price = $shipping_price  + parseFloat($('.cart_delivery.completed.active').data('price'));
  	$data['shipping_price'] = $shipping_price;
  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	$('#cart_shipping_price').find('price').text($shipping_price);

  }


  if ($('.cart_payment.completed.active').length && !$(".cart_delivery.completed.active").length)
  {
  	$shipping_price = parseFloat($(this).data('price'));
  	$data['shipping_price'] = $shipping_price;
  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	$('#cart_shipping_price').find('price').text($shipping_price);

  }


  if (!$('.cart_payment.completed.active').length && $(".cart_delivery.completed.active").length)
  {
  	$shipping_price = $shipping_price + parseFloat($('.cart_delivery.completed.active').data('price'));
  	$data['shipping_price'] = $shipping_price;
  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	  	$('.cart_next').removeClass('disabled');
  	$('#cart_shipping_price').find('price').text($shipping_price);

  }

  if (!$('.cart_payment.completed.active').length && !$(".cart_delivery.completed.active").length)
  {
  	$shipping_price = parseFloat($(this).data('price'));
  	$data['shipping_price'] = $shipping_price;
  	$('#cart_total_price').find('price').text(parseFloat($('#cart_total_price').data('price')) + $shipping_price);
  	  	$('#cart_shipping_price').find('price').text($shipping_price);

  }


  $(".cart_payment").removeClass('completed active');

  $.ajax({
    method: "POST",
    url: '/cart',
    data: $data,
    success: function(){
    	if (!$this.hasClass('completed'))
    	{
    		$this.addClass('completed active');
    		$('#cart_info_wrapper').find('.payment_note').html($paymentNote);
    		if($paymentNote)
    		{
    			$('#cart_info_wrapper').show();
    		}

    	}
    }
  })
}
})

if($('body').attr('id')=='body_cart_delivery')
{
	$deliveryprice = parseFloat($('.cart_delivery.active').data('price')) || 0;
	$paymentprice = parseFloat($('.cart_payment.active').data('price')) || 0;
	$('#cart_shipping_price').find('price').html($deliveryprice + $paymentprice);
	$('#cart_total_price').find('price').html(parseFloat($deliveryprice + $paymentprice + parseFloat($('#cart_without_vat_price').find('price').text() || 0) +  parseFloat($('#cart_vat').find('price').text() || 0) + parseFloat($('#cart_price').find('price').text() || 0 )).toFixed(2)) ;

	 $.ajax({
	    method: "POST",
	    url: '/cart',
	    data: {'shipping_price': $deliveryprice + $paymentprice}
	});
}



$('#view_goods_btn').click(function(){
  scrollTo('#home_content');
})

$('#login_password_input').keypress(function(e){
  if(e.which == 13) {
        $('#login_form').submit();
    }
});

$('#register_password_input').keypress(function(e){
  if(e.which == 13) {
        $('#register_btn').click();
    }
});


$('#product_detail_delete_btn').click(function(){
  $productid = $('#product_main_wrapper').data('id');
  $('#delete_product_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/product/"+$productid,
        data: {},
        success: function(){
          location.replace('/admin/products');
        }
      })
    }
  }).modal('show');
})

$('.admin_delete_category_btn').click(function(){
  $categoryid = $(this).closest('.category').data('id');
  $('#delete_category_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/category/"+$categoryid,
        data: {},
        success: function(){
          location.replace('/admin/products');
        }
      })
    }
  }).modal('show');
})

$('.product_row_delete_btn').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $('#delete_product_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/product/"+$productid,
        data: {},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})




var timeout = null;

$(".product_search_input input").keyup(function(e){
  	$query = $(this).val();
 	removeFilter('search');
	if ($query!='') 
	  {
	    addFilter('search',$query,'hľadaj: '+$query)
		doSort();
	  }

})


$('#settings_submit_btn').click(function(){
  $validation = 1;

  $userid = $('#settings_user').data('userid');

  $container = $('#right');

  $data = {};

  $rawdata = {
    first_name: $container.find('input[name="first_name"]').val(),
    last_name: $container.find('input[name="last_name"]').val(),
    phone: $container.find('input[name="phone"]').val(),
    invoice_address: {
      street: $container.find('input[name="invoice_address_street"]').val(),
      zip: $container.find('input[name="invoice_address_zip"]').val(),
      city: $container.find('input[name="invoice_address_city"]').val(),
      
      company: $container.find('input[name="invoice_address_company"]').val(),
      ico: $container.find('input[name="invoice_address_ico"]').val(),
      dic: $container.find('input[name="invoice_address_dic"]').val(),
      icdph: $container.find('input[name="invoice_address_icdph"]').val(),
    },
    delivery_address: {
      name: $container.find('input[name="delivery_address_name"]').val(),
      street: $container.find('input[name="delivery_address_street"]').val(),
      city: $container.find('input[name="delivery_address_city"]').val(),
      zip: $container.find('input[name="delivery_address_zip"]').val(),
      additional: $container.find('input[name="delivery_address_additional"]').val(),
      phone: $container.find('input[name="delivery_address_phone"]').val(),
    },
  };

  /*
  $deliveryInputsLength = $('.delivery_address.inputs .input').length;
  $deliveryAddressEmpty = [];

  $('.delivery_address.inputs .input input').each(function(index, element){
    if ($(element).val()=='')
    {
      $deliveryAddressEmpty.push($(element).attr('name'));
    }
  })

  if ($deliveryInputsLength != $deliveryAddressEmpty.length){
    $.each($deliveryAddressEmpty, function(i, item) {
      $('input[name="'+item+'"]').closest('.input').addClass('error');
      $validation = 0;
    });
  }
  */

  $data.invoice_address = JSON.stringify($rawdata.invoice_address);
  $data.delivery_address = JSON.stringify($rawdata.delivery_address);
  $data.first_name = $rawdata.first_name;
  $data.last_name = $rawdata.last_name;
  $data.phone = $rawdata.phone;

  $data['redirect'] = $(this).data('redirect');
  
  if ($validation)
  {
    $.ajax({
      method: "PUT",
      url: '/user/'+$userid,
      data: $data,
      success: function(data){
        location.reload();
        //console.log(data)
      }
    })
  } 
})

$('#use_delivery_address_input').checkbox({
  onChecked: function(){
    $('.cart_address .delivery').fadeIn();

    $.ajax({
      method: "POST",
      url: '/cart',
      data: {delivery_address_flag: 1}
    })

  },
  onUnchecked: function(){
    $('.cart_address .delivery').fadeOut();

    $.ajax({
      method: "POST",
      url: '/cart',
      data: {delivery_address_flag: 0}
    })
  },
})


$('#use_ico_input').checkbox({
  onChecked: function(){
    $('.cart_address .ico').fadeIn();

    $.ajax({
      method: "POST",
      url: '/cart',
      data: {ico_flag: 1}
    })

  },
  onUnchecked: function(){
    $('.cart_address .ico').fadeOut();

    $.ajax({
      method: "POST",
      url: '/cart',
      data: {ico_flag: 0}
    })
  },
})

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$('#cart_shipping_next_btn').click(function(e){
    $validation = 1;

    $invoiceAddress = {};
    $deliveryAddress = {};
    $ico = {};

    $button = $(this);
    $button.addClass('loading');
    
    $invoiceAddressInputs = $('.cart_address').find('.invoice').find('.input');


    $invoiceAddressInputs.each(function(index, item){
      $type = $(item).data('column');
      $invoiceAddress[$type] = $(item).find('input').val();
      if ($(item).find('input').val() == '')
      {
        $validation = 0;
        $(item).addClass('error');
      }
    })

    $deliveryAdressFlag = $('#use_delivery_address_input').checkbox('is checked');
    $icoFlag = $('#use_ico_input').checkbox('is checked');
    $email = $('input[type="email"]').val();

    if (!isEmail($email))
    {
    	$validation = 0;
    	$('input[type="email"]').parent().addClass('error');
    }

    $phone = $('.input[data-column="phone"] input').val();

    if (!$.isNumeric($phone))
    {
    	$validation = 0;
    	$('.input[data-column="phone"]').addClass('error');
    }


    if ($deliveryAdressFlag)
    {
      $deliveryAddressInputs = $('.cart_address').find('.delivery').find('.input');
      $deliveryAddressInputs.each(function(index, item){
        $type = $(item).data('column');
        $deliveryAddress[$type] = $(item).find('input').val();
        if ($(item).filter('.mandatory').find('input').val() == '')
        {
          $validation = 0;
          $(item).addClass('error');
        }
      })
    }

    if ($icoFlag)
    {
    	$icoInputs = $('.cart_address').find('.ico').find('.input');
        $icoInputs.each(function(index, item){
        $type = $(item).data('column');
        $ico[$type] = $(item).find('input').val();
        if ($(item).filter('.mandatory').find('input').val() == '')
        {
          $validation = 0;
          $(item).addClass('error');
        }
      })
    }

    console.log($validation);

    

    if ($validation)
    { 
	   $.extend($invoiceAddress, $ico);

      $.ajax({
        method: "POST",
        url: '/cart',
        data: {invoice_address: JSON.stringify($invoiceAddress), delivery_address: JSON.stringify($deliveryAddress)}
      });

      e.preventDefault();
      setTimeout(function(){
          $.get($(this).attr('href'),{}, function(){
          location.replace($button.attr('href'));
        })
      },1000);
    }
    else{
      e.preventDefault();
      $button.removeClass('loading');
    }

})


$('#submit_order_btn').click(function(){
  $button = $(this);
  $button.addClass('loading');
  $.ajax({
    method: 'POST',
    url: '/order',
    success: function(){
      location.replace("/order/success");
    }
  })

})





$(document).on('click', '.admin_delete_user_btn', function(){
  $userid = $(this).closest('.user').data('userid');
  $.ajax({
    method: "DELETE",
    url: '/user/'+$userid,
    success: function(){
      location.reload();
    }
  })
});



$('.admin_admin_checkbox').checkbox({
  onChecked: function(){

    $userid = $(this).closest('.user').data('userid');

    $.ajax({
      method: "PUT",
      url: '/user/'+$userid,
      data: {admin: 1}
    })

  },
  onUnchecked: function(){

    $userid = $(this).closest('.user').data('userid');

    $.ajax({
      method: "PUT",
      url: '/user/'+$userid,
      data: {admin: 0}
    })
  },
})


$('.delete_img').click(function(){
  $image = $(this).closest('.image_div');
  $imageid = $image.data('fileid');

   $.ajax({
    method: "DELETE",
    url: '/file/'+$imageid,
    data: {},
    success: function(){
      $image.remove();
    }
  })
})


$('.make_primary_img').click(function(){
  $image = $(this).closest('.image_div');
  $imageid = $image.data('fileid');

   $.ajax({
    method: "PUT",
    url: '/file/'+$imageid,
    data: {primary:1},
    success: function(){
      $('.image_div').removeClass('primary');
     $image.addClass('primary');
    }
  })
})

// callback for clicking the active filter delete icon
$("#active_filters").on('click','span .delete', function () {
    $filter = $(this).parent().data('filter');
    $value = $(this).parent().data('value');
    $(this).parent().remove();
    $('.filter[data-filter="'+$filter+'"][data-value="'+$value+'"]').removeClass('active');
    doSort();
});


$("#sidebar_handle").click(function(){
  $('#sidebar').sidebar('toggle');
})

$("#catbar_handle").click(function(){
  $('#catbar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
})

$("#parambarbar_handle").click(function(){
  $('#parambar').sidebar('toggle');
})

$('.close_btn').click(function(){
  $('.ui.sidebar').sidebar('hide');
})






$('#admin_add_category_param_btn').click(function(){
  $html = $('#admin_filters_div .row:first-child').clone();
  $('#admin_filters_div').append($html);
})



$('#filterbar .tabs .category.tab').click(function(){
  $('#cat_div').show();
  $('#filterbar .tabs .tab').removeClass('active');
  $(this).addClass('active');
})


$('#filterbar .tabs .param.tab:not(".disabled")').click(function(){
    $('#cat_div').hide();
      $('#filterbar .tabs .tab').removeClass('active');
  $(this).addClass('active');
})



$carousel = $('.covers').flickity({
  autoPlay: 4000,
  setGallerySize: false,
  lazyLoad: 1
});


$carousel.on( 'pointerUp.flickity', function(){
	$('#search_results').hide();
});


$('.expand_all_toggle').click(function(){
	$target = $(this).data('target');
	if ($(this).hasClass('expanded'))
	{
		$('[data-target="'+$target+'"]').find('.title').removeClass('active');
		$('[data-target="'+$target+'"]').find('.content').removeClass('active');
		$(this).removeClass('expanded').text('Rozbal všetko');
	}
	else
	{
		$('[data-target="'+$target+'"]').find('.title').addClass('active');
		$('[data-target="'+$target+'"]').find('.content').addClass('active');
		$(this).addClass('expanded').text('Zbal všetko');
	}

})





$('.tabs .tab').click(function(){
  $('.tabs .tab').removeClass('brown').addClass('basic');
  $(this).addClass('brown').removeClass('basic')
  $('.tabs .content').removeClass('active');
  $('.tabs .content[data-tab="'+$(this).data("tab")+'"]').addClass('active');
})





$('#new_page_btn').click(function(){
$('#add_page_modal').modal('setting', {
	autofocus: true,
	onApprove : function() {
	  $name = $('#add_page_name_input').val();
	  $url = $('#add_page_url_input').val();
	  $.ajax({
	    type: "POST",
	    url: "/page",
	    data: {name: $name, url: $url},
	    success: function(){
	      location.reload();
	    }
	  })
	}
}).modal('show');
});


$('#new_text_btn').click(function(){
$('#add_text_modal').modal('setting', {
	autofocus: true,
	onApprove : function() {
	  $name = $('#add_text_name_input').val();
	  $.ajax({
	    type: "POST",
	    url: "/text",
	    data: {name: $name},
	    success: function(){
	      location.reload();
	    }
	  })
	}
}).modal('show');
});



$('.disabled.rating').each(function(index, item){
  //console.log($(item).data('rating'));
  $(item).rateYo('rating', $(item).data('rating'));
})


$('.dashboard_tabs .new.tab').click(function(){
  $('.dashboard_tabs .overall.tab').removeClass('blue').addClass('basic');
  $(this).addClass('blue').removeClass('basic');
  $('.admin_dashboard .new.boxes').removeClass('hidden');
  $('.admin_dashboard .overall.boxes').addClass('hidden');
});


$('.dashboard_tabs .overall.tab').click(function(){
  $('.dashboard_tabs .new.tab').removeClass('blue').addClass('basic');
  $(this).addClass('blue').removeClass('basic');
  $('.admin_dashboard .new.boxes').addClass('hidden');
  $('.admin_dashboard .overall.boxes').removeClass('hidden');
});




$('.add_delivery_method_btn').click(function(){
    $('#add_delivery_method_modal').modal('setting', {
    onVisible: function() {
    	$('.ui.dropdown').dropdown();
    },
    onApprove : function() {
      $name = $('#add_delivery_method_name_input').val();
      $desc = $('#add_delivery_method_desc_input').val();
      $price = $('#add_delivery_method_price_input').val();
      $icon = $('#add_delivery_method_modal').find('.ui.dropdown.add').dropdown('get value');
      $note = $('add_delivery_method_note_input').val();

      $.ajax({
        type: "POST",
        url: "/admin/delivery",
        data: {name: $name, desc:$desc, icon: $icon, note: $note, price: $price},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})



$('.add_payment_method_btn').click(function(){
    $('#add_payment_method_modal').modal('setting', {
    onApprove : function() {
      $name = $('#add_payment_method_name_input').val();
      $desc = $('#add_payment_method_desc_input').val();
      $price = $('#add_payment_method_price_input').val();
      $icon = $('#add_payment_method_modal').find('.ui.dropdown.add').dropdown('get value');
      $note = $('add_payment_method_note_input').val();

      $.ajax({
        type: "POST",
        url: "/admin/payment",
        data: {name: $name, desc:$desc, icon: $icon, note: $note, price: $price},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})



$('.admin_method_list i.delete').click(function(){
  $item = $(this).closest('.step');
  $id = $(this).closest('.step').data('id');
  $type = $(this).closest('.step').data('type');

   $('#delete_method_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
      $.ajax({
	    type: "DELETE",
	    url: "/admin/"+$type+"/"+$id,
	    success: function(){
	      $item.remove();
	    }
	  })
    }
  }).modal('show');
})

$('.page_delete_btn').click(function(){
  $id = $(this).closest('.item').data('id');

   $('#delete_page_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
	    type: "DELETE",
	    url: "/page/"+$id,
	    success: function(){
	      location.reload();
	    }
	  })
    }
  }).modal('show');
})



$('.text_delete_btn').click(function(){
  $id = $(this).closest('.item').data('id');

   $('#delete_text_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
	    type: "DELETE",
	    url: "/text/"+$id,
	    success: function(){
	      location.reload();
	    }
	  })
    }
  }).modal('show');
})

$('.sticker_delete_btn').click(function(){
  $id = $(this).closest('.item').data('id');

   $('#delete_sticker_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
	    type: "DELETE",
	    url: "/sticker/"+$id,
	    success: function(){
	      location.reload();
	    }
	  })
    }
  }).modal('show');
})

var sticker_left, sticker_top;
var sticker_width, sticker_height;




$('#edit_sticker_submit').click(function(){

	$id = $(this).data('id');
	$sticker_product_row = $('#sticker_product_row').checkbox('is checked');
	$sticker_product_detail = $('#sticker_product_detail').checkbox('is checked');;

	$.ajax({
		url: '/sticker/'+$id,
		method: "PUT",
		data: {left: sticker_left, top: sticker_top, width: sticker_width, height: sticker_height, product_row: $sticker_product_row, product_detail: $sticker_product_detail},
		success: function(){
			location.reload();
		}

	})
})


$('.admin_method_list i.edit').click(function(){
  $item = $(this).closest('.step');
  $id = $item.data('id');
  $type = $item.data('type');

   $('#edit_method_modal').modal('setting', {
    autofocus: false,
    onShow: function(){

    	$('#edit_method_name_input').val($item.data('name'));
      	$('#edit_method_desc_input').val($item.data('desc'));
     	$('#edit_method_price_input').val($item.data('price'));
      	$('#edit_method_modal').find('.ui.dropdown.edit').dropdown('set value',$item.data('icon'));
      	$('#edit_method_modal').find('.ui.dropdown.edit').dropdown('set text',"<i class='big icon "+$item.data('icon')+"'></i>");

      	$('#edit_method_note_input').val($item.data('note'));
    },
    onApprove : function() {

    	$name = $('#edit_method_name_input').val();
      	$desc = $('#edit_method_desc_input').val();
     	$price = $('#edit_method_price_input').val();
      	$icon = $('#edit_method_modal').find('.ui.dropdown.edit').dropdown('get value');
      	$note = $('#edit_method_note_input').val();

      	console.log($note);
      	
		$.ajax({
			type: "PUT",
			url: "/admin/"+$type+"/"+$id,
        	data: {name: $name, desc:$desc, icon: $icon, note: $note, price: $price},
			success: function(){
			 	location.reload();
			}
		})
    }
  }).modal('show');
})




$('.tabbs .tabb').click(function(){
  $('.tabbs .tabb').removeClass('blue selected').addClass('basic');
  $(this).addClass('blue selected').removeClass('basic')
  $('.tabbs .contents .content').removeClass('active');
  $('.tabbs .contents .content[data-tab="'+$(this).data("tab")+'"]').addClass('active');
})



$('.delivery_payment_checkbox').checkbox({
  onChecked: function(){
    $delivery_method_id = $(this).closest('tr').data('delivery_method_id');
    $payment_method_id = $(this).closest('tr').data('payment_method_id');

    $.ajax({
      method: 'POST',
      url: '/admin/deliverypayment',
      data: {delivery_method_id: $delivery_method_id, payment_method_id: $payment_method_id}
    })
  },
  onUnchecked: function(){
    $delivery_method_id = $(this).closest('tr').data('delivery_method_id');
    $payment_method_id = $(this).closest('tr').data('payment_method_id');

    $.ajax({
      method: 'DELETE',
      url: '/admin/deliverypayment',
      data: {delivery_method_id: $delivery_method_id, payment_method_id: $payment_method_id}
    })
  }
})

$('input.delivery_price').keyup(function(){
    $delivery_method_id = $(this).closest('tr').data('delivery_method_id');
    $payment_method_id = $(this).closest('tr').data('payment_method_id');
    $price = $(this).val();

    $.ajax({
      method: 'PUT',
      url: '/admin/deliverypayment',
      data: {delivery_method_id: $delivery_method_id, payment_method_id: $payment_method_id, price: $price}
    })
});






var h1Slider = document.getElementById('admin_add_cover_h1_size_slider');
var h2Slider = document.getElementById('admin_add_cover_h2_size_slider');

if ($('#admin_add_cover_h1_size_slider').length)
{
  noUiSlider.create(h1Slider ,{
   start: $('#admin_add_cover_form input[name="h1_size"]').val(),
      connect: true,
      range: {
        'min': 0,
        'max': 6
      },
    });

  noUiSlider.create(h2Slider ,{
   start: $('#admin_add_cover_form input[name="h2_size"]').val(),
      connect: true,
      range: {
        'min': 0,
        'max': 6
      },
    });


  h1Slider.noUiSlider.on('update', function(aa){
      $('.cover_div h1').css('font-size',aa[0]+'vw'); 
      $('#admin_add_cover_form input[name="h1_size"]').val(aa[0]);
  });


  h2Slider.noUiSlider.on('update', function(aa){
      $('.cover_div h2').css('font-size',aa[0]+'vw'); 
      $('#admin_add_cover_form input[name="h2_size"]').val(aa[0]);

  });

}


$('#admin_add_cover_h1').on('keyup', function(e, color) {
    $('.cover_div h1').html($(this).val());
    $('#admin_add_cover_form input[name="h1_text"]').val($(this).val());
});

$('#admin_add_cover_h2').on('keyup', function(e, color) {
    $('.cover_div h2').html($(this).val());
    $('#admin_add_cover_form input[name="h2_text"]').val($(this).val());
});




$('.delete_banner_btn').click(function(){
  $btn = $(this);
  $('#delete_banner_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
      $id = $btn.closest('.banner').data('id');
      $.ajax({
        type: "DELETE",
        url: "/admin/banner/"+$id,
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})





$('#admin_new_wrapper table tbody .checkbox').checkbox({
    onChecked: function(){
      $id = $(this).closest('tr').data('id');
      $.ajax({
        method: 'PUT',
        url: '/api/product/'+$id,
        data: {new_carousel: 1}         
      })
    },
    onUnchecked: function(){
      $id = $(this).closest('tr').data('id');
      $.ajax({
        method: 'PUT',
        url: '/api/product/'+$id,
        data: {new_carousel: 0}         
      })
    }
  });



$('#admin_sale_wrapper table tbody .checkbox').checkbox({
    onChecked: function(){
      $id = $(this).closest('tr').data('id');
      $.ajax({
        method: 'PUT',
        url: '/api/product/'+$id,
        data: {sale_carousel: 1}         
      })
    },
    onUnchecked: function(){
      $id = $(this).closest('tr').data('id');
      $.ajax({
        method: 'PUT',
        url: '/api/product/'+$id,
        data: {sale_carousel: 0}         
      })
    }
  });



if ($('body').attr('id')=='dashboard')
{
  initCharts();
  drawCharts();
}

function drawCharts(){

  $('canvas').each(function(index, item)
  {
    var days = $(item).closest('.box').data('days');
    var resource = $(item).closest('.box').data('resource');
    var type = $(item).closest('.box').data('type');
    var chart = $(item).closest('.box').data('resource')+$(item).closest('.box').data('type');

    $.get('/api/'+resource+'/'+type+'/'+days, {}, function(data){

      var labels = getLastDays(days).reverse();
      var chartdata = getDataByDays(data, days).reverse();

      drawChart(chart, labels, chartdata);

    })


  })

}

function drawChart(chart, labels, data){

    $charts[chart].data.labels = [];
    $charts[chart].data.datasets.forEach((dataset) => {
        dataset.data = [];
    }); 

    $(data).each(function(index, element){
      addChartData($charts[chart], labels[index], data[index]);
    })

}


function addChartData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}



function getLastDays(goBackDays)
{
    var today = new Date();
    var days = [];

    for(var i = 0; i < goBackDays; i++)
    {
        var newDate = new Date(today.setDate(today.getDate() - 1));
        days.push(newDate.getFullYear()+'-'+parseInt(newDate.getMonth()+1)+'-'+newDate.getDate());
    }

    return days;
}

function getDataByDays(data, goBackDays)
{ 
    var result = [];

    var days = getLastDays(goBackDays);
    assocData = {};

    $(data).each(function(index, element){
      assocData[element.date] = element.count;
    })

    $(days).each(function(index, element){
      if (assocData[element]){
        result.push(assocData[element]);
      }
      else
      {
        result.push(0);
      }
    })
    return result;
}

function randomColor(){
  var colorR = Math.floor((Math.random() * 256));
  var colorG = Math.floor((Math.random() * 256));
  var colorB = Math.floor((Math.random() * 256));
  rand="rgb(" + colorR + "," + colorG + "," + colorB + ")";
  return rand;
}

function initCharts()
{
  $charts = {};
  $('canvas').each(function(index, item){
    var canvas = item;
    var ctx = canvas.getContext('2d');
    var color = randomColor();
    canvas.height = $(canvas).parent().height();

    $charts[$(item).closest('.box').data('resource')+$(item).closest('.box').data('type')] = new Chart(ctx, {
        type: 'line',

        data: {
            labels: [],
            datasets: [{
                label: "Počet",
                backgroundColor: color,
                borderColor: color,
                data:[],
                fill: false,
                lineTension: 0
            }]
        },

        options: {
          responsive: true,
          responsiveAnimationDuration: 0,
          maintainAspectRatio: false,

          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              ticks: {
                stepSize: 1
              }
            }]
          },
        },

    });
  })

}





$('.chart_days_btn').click(function(){
  var box = $(this).closest('.box');
  var days = $(this).data('days');
  var resource = $(this).closest('.box').data('resource');
  var type = $(this).closest('.box').data('type');
  var chart =  resource+type;

  $.get('/api/'+resource+'/'+type+'/'+days, {}, function(data){
    var labels = getLastDays(days).reverse();
    var chartdata = getDataByDays(data, days).reverse();
    drawChart(chart, labels, chartdata);
  })

  $(this).closest('.fr').find('.chart_days_btn').removeClass('selected');
  $(this).addClass('selected');

});


$('.layout_div').click(function(){
  $layout = $(this).data('layout');
  $.post('/admin/layout/set',{layout:$layout}, function(){
    location.reload();
  })
})


$('.ui.new.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
     	url: '',

    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {new: 1}, 
        success: function(data){
          $row = $('#new_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#new_product_table tbody tr:last-child').before($row);
          $('.ui.new.product.search input').val('');
        }   
      })
    }
  }).unbind('ajaxStart');;

$('#new_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {new: 0}, 
    success: function(data){
      $row.remove();
    }   
  })
})


$('.ui.sale.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
      	  url: '',

    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {sale: 1}, 
        success: function(data){
          $row = $('#sale_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#sale_product_table tbody tr:last-child').before($row);
          $('.ui.sale.product.search input').val('');
        }   
      })
    }
  });

$('#sale_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {sale: 0}, 
    success: function(data){
      $row.remove();
    }   
  })
})



$('.ui.inactive.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
      	  url: '',

    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {active: 0}, 
        success: function(data){
          $row = $('#inactive_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#inactive_product_table tbody tr:last-child').before($row);
        }   
      })
    }
  });

$('#inactive_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {active: 1}, 
    success: function(data){
      $row.remove();
    }   
  })
})

$('.ui.bestseller.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
     	url: '',

    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {bestseller: 1}, 
        success: function(data){
          $row = $('#bestseller_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#bestseller_product_table tbody tr:last-child').before($row);
          $('.ui.bestseller.product.search input').val('');
        }   
      })
    }
  }).unbind('ajaxStart');;

$('#bestseller_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {bestseller: 0}, 
    success: function(data){
      $row.remove();
    }   
  })
})


$('.ui.bestseller.category.search')
  .search({
    apiSettings: {
      url: '/api/categories/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'full_url',
      image  : '',
      action : '',  
	  actionText: '',    
	  actionURL: '' ,
	  url: '',
    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/category/'+result.id,
        data: {bestseller: 1}, 
        success: function(data){
          $row = $('#bestseller_category_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#bestseller_category_table tbody tr:last-child').before($row);
          $('.ui.bestseller.category.search input').val('');
        }   
      })
    }
  }).unbind('ajaxStart');;

$('#bestseller_category_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/category/'+$id,
    data: {bestseller: 0}, 
    success: function(data){
      $row.remove();
    }   
  })
})


$('.ui.cart.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
      	  url: '',

    },
    onSelect: function(result, response){
       $cartid = $('.cart.content').data('cartid');
       $.ajax({
        method: 'POST',
        url: "/cart/"+$cartid+"/"+result.id,
        data: {qty: 1}, 
        success: function(data){
          location.reload();
        }   
      })
    }
  });




$('#import_json_btn').click(function(){
  $json = $.parseJSON($('#import_json').find('textarea').val());
  $table = $('#import_json_table');
  $tbody = $table.find('tbody');
  $table.show();

  $($json).each(function(i,e){
    $tbody.find('tr:last-child td:nth-child(2)').html('<img src="'+e.img+'" width="100" />');
    $tbody.find('tr:last-child td:nth-child(3)').text(e.id);
    $tbody.find('tr:last-child td:nth-child(4)').text(e.nome);
    $tbody.find('tr:last-child td:nth-child(5)').text(e.descr);
    $tbody.find('tr:last-child').clone().appendTo($tbody);
  })

  $('.ui.checkbox').checkbox();

})

$('#import_json_accept').click(function(){
  var json = $('#import_json_table').tableToJSON();
  console.log(json);
  $.post('/admin/import/json', {json: $('#import_json').find('textarea').val()}, function(e){
    console.log(e);
  })
})

$('.add_color_btn').click(function(){
    $('#add_color_modal').modal('setting', {
    onApprove : function() {
      $key = $('#add_color_key_input').val();
      $value = $('#add_color_value_input').val();
      
      $.ajax({
        type: "POST",
        url: "/admin/color/",
        data: {key: $key, value:$value},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})




function initCartProductSlider(){

  var sliders = document.getElementsByClassName('cart_length_slider');
    $min = [];
    $old = [];
  for ( var i = 0; i < sliders.length; i++ ) {
     $ii = i;

     $qty = $(sliders[i]).data('qty');
     $step = $(sliders[i]).data('step');
     $thresholds = $(sliders[i]).data('thresholds');
   

     $prices = JSON.parse($(sliders[i]).data('prices'));
     $min[i] = $(sliders[i]).data('min');


     noUiSlider.create(sliders[i], {
          start: $qty,
          step: $step,
          connect: "lower",
          orientation: "horizontal",
          tooltips: true,
          range: {
              'min': 0,
              'max': 500
          },
        
          format: wNumb({
            decimals: 0,
          })
      });

     sliders[i].noUiSlider.on('slide', function ( values, handle ) {
      $level = getClosestValue($thresholds,values[handle]); 
      $index = $thresholds.indexOf($level);
      $newprice =$prices[$index];
      $($(this)[0].target).closest('.item.product').find('.final_price').html($newprice+ ' &euro;');
     });

      $cartid = $('.cart.content').data('cartid');
      
      $old[i] = sliders[i].noUiSlider.get();

      sliders[i].noUiSlider.on('change', function ( values, handle ) {
	  	if ( values[handle] < $($(this)[0].target).data('min') ) {
	      sliders[$ii].noUiSlider.set($old[$ii]);
	    }
	    else
	    {
	   		$('#grid_wrapper .dimmer').addClass('active');

	      $.ajax({
	        type: "PUT",
	        url: "/cart/"+$cartid+"/"+$($(this)[0].target).data('productid'),
	        data: {qty: values[handle]},
	        success: function(){
	          location.reload();
	        }
	      })
	  };

     });

  }
  

}

initCartProductSlider();


function getClosestValue(myArray, myValue){
    //optional
    var i = 0;

    while(myArray[++i] <= myValue);

    return myArray[--i];
}





$('#add_price_level_btn').click(function(){
  $.get('/api/view/pricelevel',{}, function(data){
    $('#product_price_levels_list').append(data);
  })
})

/*
$('#product_detail .img img').loupe({
    width: 250, // width of magnifier
  height: 200, // height of magnifier
  loupe: 'loupe' // css class for magnifier
});
*/

$('.admin_checkbox_onthefly').checkbox({
    onChecked: function(){
      $resource = $(this).parent().data('resource');
      $name = $(this).attr('name');
      $id = $(this).parent().data('id');
      $data = {};
      $data[$name] = 1;
      $.ajax({
        method: 'PUT',
        url: '/'+$resource+'/'+$id,
        data: $data          
      })
    },
    onUnchecked: function(){
      $resource = $(this).parent().data('resource');
      $name = $(this).attr('name');
      $id = $(this).parent().data('id');
      $data = {};
      $data[$name] = 0;
      $.ajax({
        method: 'PUT',
        url: '/'+$resource+'/'+$id,
        data: $data          
      })
    }
  });

if ($('body').attr('id')=="body_bulk")
{

	container = document.getElementById('bulk_products_table');
	var cellChanges = [];
	var selectedCells = [];
	var selectedIds = [];
	var categoryChanges = [];

	$data = {};
	$data['changes'] = [];

	$data['categoryChanges'] = {};
	$data['categoryChanges']['categories'] = [];
	$data['categoryChanges']['products'] = [];

	$data['categoryAdds'] = {};
	$data['categoryAdds']['categories'] = [];
	$data['categoryAdds']['products'] = [];

	$data['categoryRemoved'] = {};
	$data['categoryRemoved']['categories'] = [];
	$data['categoryRemoved']['products'] = [];

	$data['addEcoImages'] = {};
	$data['removeEcoImages'] = {};

	hot = new Handsontable(container, {
	 columns: [
	 	{data: "url", renderer: detailRenderer},
	 	{data: "active", type: 'checkbox',checkedTemplate: 1,uncheckedTemplate: 0},
	 	{data: "image", renderer: imageRenderer},
	    {data: "code"},
	    {data: "name"},
	    {data: "price_levels.0.moc_regular"},
	    {data: "price_levels.0.moc_sale"},
	    {data: "sale", type: 'checkbox',checkedTemplate: 1,uncheckedTemplate: 0},
	    {data: "categories", renderer: categoryRenderer}
	  ],
	  colHeaders: ['', 'Aktívny', 'Obrázok','Kód', 'Názov','Cena','Cena v zlave', "Zlava", 'Kategórie'],
	  colWidths: [5,7,7,10,'',10,10,5,''],
	  rowHeaders: true,
	  minSpareRows: 1,
	  stretchH: 'all',
	  columnSorting: true,
	  rowHeights: 60 ,

	  outsideClickDeselects : false,
	  afterChange: function(change, source){
	  	if(source=='edit' || source=='CopyPaste.paste'){
	  		if (change[0][2] != change[0][3]){
	  			cellChanges.push({'rowid':change[0][0], 'colid':this.propToCol(change[0][1])});
	  			$data['changes'].push(this.getSourceDataAtRow(change[0][0]));
	  		}

	  		$.each(cellChanges, function (index, element) { 
		  		$this.getCell(element['rowid'], element['colid'], false).className = 'changed'; 
		  	});
		  	console.log($data['changes']);
	  	}
	  },
	  afterRender: function(){
	  	$this = this;
	  	$.each(cellChanges, function (index, element) { 
	  		$this.getCell(element['rowid'], element['colid'], false).className = 'changed'; 
	  	});
	  },
	  afterSelection: function(row, column, row2, column2, preventScrolling, selectionLayerLevel){
  		selectedIds = [];
  		selectedCells = [];

  		$ins = this; 
	  	$('#bulk_products_wrapper .actions >.right').show();

		var j;

		$(this.getSelected()).each(function(i,e){
		  	for (j = e[0]; j <= e[2]; j++) { 
		  		selectedCells.push($ins.getSourceDataAtRow(j)); 
		  		selectedIds.push($ins.getSourceDataAtRow(j).id); 
		  	}
		})


		var i;
		for (i = row; i <= row2; i++) { 
	  		selectedCells.push(this.getSourceDataAtRow(i)); 
	  		selectedIds.push(this.getSourceDataAtRow(i).id); 
	  	}

	  },
	  afterDeselect: function(){
	  	$('#bulk_products_wrapper .actions .right').hide();
	  		selectedCells = []; 
	  		selectedIds = [];
	  }
	});

	function detailRenderer (instance, td, row, col, prop, value, cellProperties) {
		$(td).html('<a class="blue icon mini button" href="/p/'+value+'"><i class="search icon"><i></a>');
		$(td).append('<a class="teal icon mini button" href="/admin/eshop/product/'+value+'"><i class="edit icon"><i></a>');
		return td;
	}

	function categoryRenderer (instance, td, row, col, prop, value, cellProperties) {
		var row = [];

		$(value).each(function(i,e){
			row[i] = e.path + "<br/>";
		})

		$(td).html(row);
		return td;
	}

	function imageRenderer (instance, td, row, col, prop, value, cellProperties) {
		$(function() {
	        $('.lazy').Lazy();
	    });
	    
	    if(value)
	    {
	    	if(value.path && value.path.toString().indexOf('http') !== -1)
	    	{
				$(td).html('<div class="image"><img class="lazy" data-src="'+value.path+'" /></div>');
			}
			else
			{
				$(td).html('<div class="image"><img class="lazy" data-src="/'+value.path+'" /></div>');
			}
		}

		return td;
	}

	var load_btn = document.getElementById('bulk_load_btn');

	Handsontable.dom.addEvent(load_btn, 'click', function() {
		
		$(load_btn).addClass('loading');

		$filters = {
			"categories" : $('.filter_item.category').dropdown('get value'),
			"name" : $('.filter_item.name').find('input').val(),
			"without_category" : $('.filter_item.without_category').checkbox('is checked'),
			"inactive_only" : $('.filter_item.inactive').checkbox('is checked')
		}

		$.ajax({
			url: '/api/products/filter', 
			method: 'GET', 
			data: $filters,
			success: function(data) {
				$('#bulk_products_table').show();
				$('#bulk_save_btn').css('display','inline-block');
				$(load_btn).removeClass('loading');
			   	hot.getInstance().loadData(data);
			   	hot.getInstance().render();
		}

		});
	});


	$('#bulk_change_category_dropdown').dropdown({
	  maxSelections: 10,
	  fullTextSearch: true,
	  onAdd: function(addedValue, addedText, $addedChoice){
	   	categoryChanges.push(addedValue);
	  }
	})

	$('#bulk_change_category_btn').click(function(){
		$('#bulk_change_category_modal').modal('setting', {
	    autofocus: false,
	    onShow: function(){
	    	$.ajax({
				method: "GET",
				url: '/api/products/simplelist',
				data: {id: selectedIds},
	    		success: function(data)	{
	    			$('#bulk_change_category_modal').find('.product_list').html(data);
	    		}
	    	})
	    },
	    onApprove : function() {
	    	$data['categoryChanges']['products'] = selectedIds;
	    	$data['categoryChanges']['categories'].push($('#bulk_change_category_dropdown').dropdown('get value'));
	    }
	  }).modal('show');
	})

	$('#bulk_add_category_btn').click(function(){
		$('#bulk_add_category_modal').modal('setting', {
	    autofocus: false,
	    onShow: function(){
	    	$.ajax({
				method: "GET",
				url: '/api/products/simplelist',
				data: {id: selectedIds},
	    		success: function(data)	{
	    			$('#bulk_add_category_modal').find('.product_list').html(data);
	    		}
	    	})
	    },
	    onApprove : function() {
	    	$data['categoryAdds']['products'] = selectedIds;
	    	$data['categoryAdds']['categories'].push($('#bulk_add_category_dropdown').dropdown('get value'));
	    }
	  }).modal('show');
	})

	$('#bulk_add_eco_images_btn').click(function(){
	    $data['addEcoImages'] = selectedIds;
	});

	$('#bulk_remove_eco_images_btn').click(function(){
	    $data['removeEcoImages'] = selectedIds;
	});

	var save_btn = document.getElementById('bulk_save_btn');

	Handsontable.dom.addEvent(save_btn, 'click', function() {
		$(save_btn).addClass('loading');

		console.log(JSON.stringify($data));

		// save all cell's data
		$.ajax({
			url: '/api/bulk', 
			method: 'POST', 
			data: JSON.stringify($data),
			success: function (res) {
			$(save_btn).removeClass('loading');
	   		$('#bulk_products_table').find('td').removeClass('changed');
	   	}

	  });
	});

}

$('#bulk_filter_category').dropdown({
  maxSelections: 10,
  fullTextSearch: true,
  onAdd: function(addedValue, addedText, $addedChoice){
   
  }
})

$('#cookies_consent_btn').click(function(){
	$(document).unbind('ajaxStart');
  $('#cookies_msg').hide();
  $.ajax({
    method: "POST",
    url: '/cookies',
    data: {name: 'cookies_consent',value: 1, expiry: 9999999},
    success: function(){
    	$(document).bind('ajaxStart');
    }
  })
});

$('#product_sticker_load_btn').click(function(){

	$filters = {
		"categories" : $('.filter_item.category').dropdown('get value'),
		"name" : $('.filter_item.name input').val(),
	}

	if ($('#filters_stickers_active_checkbox').checkbox('is checked'))
	{
		$filters['with_stickers_only'] = 1;

	}
	

	$button = $(this);
	$button.addClass('loading')

	$.ajax({
		url: '/api/products/filter', 
		method: 'GET', 
		data: $filters,
		success: function(data) {
			$('.product_list .list').html('');
			$(data).each(function(i,e){

				$stickers = [];
				

				if (e.stickers.length != 0)
				{
					$(e.stickers).each(function(i,e){
						if(e.path.toString().indexOf('http') !== -1)
						{
							$stickers.push('<img src='+e.path+' data-productid='+e.pivot.product_id+' data-stickerid='+e.pivot.sticker_id+'>');
						}
						else
						{
							$stickers.push('<img src=/'+e.path+' data-productid='+e.pivot.product_id+' data-stickerid='+e.pivot.sticker_id+'>');
						}
					})
				}

				$html = "<div class='item' data-id='"+e.id+"'>"
				$html += "<div class='ui checkbox'><input type='checkbox'><label></label></div>";
				$html += "<div class='name'>"+e.name+"</div>";
				$html += "<div class='active_stickers'>"+$stickers.toString()+"</div>";
				$html += "</div>"
				$('.product_list .list').append($html);

				$('.product_list .list .checkbox').checkbox({
				    onChecked: function(){
				      $item = $(this).closest('.item');
				      $item.addClass('selected');

				    },
				    onUnchecked: function(){
				      $item = $(this).closest('.item');
				      $item.removeClass('selected');
				    }
				})

			})
			$button.removeClass('loading');
			$('#product_sticker_save_btn').css('display','inline-block');

			$('.active_stickers img').click(function(){
				$image = $(this);
				$productid = $(this).data('productid');
				$stickerid = $(this).data('stickerid');
				$.ajax({
					url: '/product/'+$productid+'/sticker/'+$stickerid, 
					method: 'DELETE', 
					success: function(data) {
						$image.remove();
					}
				})
			})
	}
	})
})

$('.sticker_list .sticker').click(function(){
	$(this).toggleClass('selected');
})


$('#product_sticker_save_btn').click(function(){
	$data = {};
	$data['products'] = [];
	$data['stickers'] = [];
	$data['sticker_paths'] = [];

	$('.sticker_list .sticker.selected').each(function(i,e){
		$data['stickers'][i] = $(e).data('id');
		$data['sticker_paths'][i] = $(e).find('img').attr('src');

	})

	$('.product_list .list .item.selected').each(function(i,e){
		$data['products'][i] = $(e).data('id');
	})

	$.ajax({
		url: '/stickers/attach', 
		method: 'POST', 
		data: $data,
		success: function(data) {
			$('.product_list .list .item.selected').each(function(i,e){
				$(e).find('.active_stickers').append('<img src='+$data['sticker_paths']+'>');
			})
		}
	})

})

if($('body').attr('id')=='cartproducts')
{
	/*
	$cart_price = 0;

	$('#cart_detail .product').each(function(index,item){
	  $cart_price = $cart_price + parseFloat($(item).find('.final_price').text());
	})

	//$('#cart_total_price').find('price').text(parseFloat($cart_price).toFixed(2));

	if(parseFloat($('#cart_total_price').find('price').text()) < parseFloat($('#cart_min_price').find('price').text()))
	{
		$('#cart_continue_btn').addClass('disabled');
	}

	$freeShippingPrice = parseFloat($('#cart_free_shipping_price').data('price')) - parseFloat($('#cart_total_price').find('price').text()).toFixed(2);
	
	if ($freeShippingPrice > 0)
	{
		$freeShippingPrice = parseFloat($freeShippingPrice).toFixed(2);
		console.log($freeShippingPrice);
		$('#cart_free_shipping_price').find('price').text($freeShippingPrice);
	}
	else
	{
		//$('#cart_free_shipping_price').hide();
	}
	*/
}

$('.filterbar_handle').mouseover(function(){
  $('.absolute').show();
})

$('.absolute #filterbar').mouseleave(function(){
  setTimeout(function(){
    $('.absolute').hide();
  },600)
})

$('.admin_delete_category_param_btn').click(function(){
  $.ajax({
    method: "DELETE",
    url: '/category/parameter/'+$(this).data('paramid'),
    success: function(){
      location.reload();
    }
  })
})

$('.category i.setting').click(function(e){
  e.preventDefault();

  location.replace($(this).data('href'));
})


$('#change_grid_view_btn').click(function(){
  $('#grid_wrapper').find('.item').addClass('grid').removeClass('list');
  $(this).addClass('active');
  $('#change_list_view_btn').removeClass('active');
})


$('#change_list_view_btn').click(function(){
  $('#grid_wrapper').find('.item').addClass('list').removeClass('grid');
    $(this).addClass('active');
  $('#change_grid_view_btn').removeClass('active');
})

$('#cart_continue_btn').click(function(){
  $price = $('#cart_total_price price').text();

   $.ajax({
    type: "POST",
    url: "/cart/",
    data: {price: $price},
    success: function(){
      //
    }
  });
}).unbind('ajaxStart');



$('#add_param_btn').click(function(){
	$('#add_param_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
    	$key = $('#add_param_modal input[name="key"]').val();
        $display_key = $('#add_param_modal input[name="display_key"]').val();

    	$.ajax({
    		type: "POST",
    		url: "/param/",
    		data: {key: $key, display_key:$display_key},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})

$('.edit_param_btn').click(function(){
	 $id = $(this).closest('.param.item').data('paramid');
	 $val = $(this).closest('.param.item').data('val');

	$('#edit_param_modal').modal('setting', {
    autofocus: false,
    onShow: function(){
    	$('#edit_param_modal input[name="display_key"]').val($val);
    },
    onApprove : function() {

        $display_key = $('#edit_param_modal input[name="display_key"]').val();

    	$.ajax({
    		type: "PUT",
    		url: "/param/"+$id,
    		data: {display_key:$display_key},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})


$('.delete_param_btn').click(function(){
	 $id = $(this).closest('.param.item').data('paramid');

	$('#delete_param_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {

    	$.ajax({
    		type: "DELETE",
    		url: "/param/"+$id,
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
});


$(document).on('click', '#params_list .param.item:not(.manage)', function(e){
   if( e.target == this ||  $(e.target).hasClass('name')  ||  $(e.target).hasClass('eye') ) 
   {
		$paramid = $(this).data('paramid');
		$catid = $(this).data('categoryid');
		$this = $(this);
		$this.find('.dimmer').addClass('active');
		if ($this.hasClass('active'))
		{
			$.ajax({
				type: "DELETE",
				url: "/category/parameter/"+$paramid,
				data: {category_id: $catid},
				success: function(){
					$this.removeClass('active');
						$this.find('.dimmer').removeClass('active');

				}
			})	
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "/category/parameter/add",
				data: {parameter_id: $paramid, category_id: $catid},
				success: function(){
					$this.addClass('active');
					$this.find('.dimmer').removeClass('active');

				}
			})	
		}
	}
});

if ($('#admin_category_params_selection').length > 0)
{
$('.dropdown').dropdown({
	onAdd: function(addedValue, addedText, $addedChoice){
		$catid = $('#category_image_div').data('categoryid');
		$.ajax({
			type: "POST",
			url: "/category/parameter/add",
			data: {parameter_id: addedValue, category_id: $catid},
			success: function(){

			}
		})
	},
	onRemove: function(removedValue, removedText, $removedChoice){
		$catid = $('#category_image_div').data('categoryid');
		$.ajax({
			type: "DELETE",
			url: "/category/parameter/"+removedValue,
			data: {category_id: $catid},
			success: function(){

			}
		})	
	}
})
}

$('#admin_order_params_save').click(function(){
	$data = {};
	$data['min_order_price'] = $('input[name="min_order_price"]').val();
	$data['min_free_shipping_price'] = $('input[name="min_free_shipping_price"]').val();

	$.post('/set/config', $data, function(){

	})
})

$(document).on('click', '.delete_product_param', function(){
	$(this).closest('.row').remove();
})

$('#send_remider_btn').click(function(){
	$(this).addClass('loading');
})

$(document).on('click','.delete_price_level_btn', function(){
	$(this).closest('.product_price_level').remove();
});


$('.delete_order_btn').click(function(){
	$orderid = $(this).closest('tr').data('order_id');

	$('#delete_order_modal').modal('setting', {

    onApprove : function() {
		$.ajax({
			type: "DELETE",
			url: "/order/"+$orderid,
			success: function(){
				location.reload();
			}
		})
	}
	}).modal('show');
  
  })

$('.close_order_btn').click(function(){
	$orderid = $(this).closest('tr').data('order_id');

	$('#change_order_modal').modal('setting', {

    onApprove : function() {
		$.ajax({
			type: "PUT",
			url: "/order/"+$orderid,
			data: {status_id: 5},
			success: function(){
				location.reload();
			}
		})
	}
	}).modal('show');
  
  })

$('.delete_user_btn').click(function(){
	$userid = $(this).closest('tr').data('user_id');

	$('#delete_user_modal').modal('setting', {

    onApprove : function() {
		$.ajax({
			type: "DELETE",
			url: "/user/"+$userid,
			success: function(){
				location.reload();
			}
		})
	}
	}).modal('show');
  
  })


$('.order_change_status_btn').click(function(){
	$orderid = $('.order_detail').data('orderid');
	$status_id = $(this).data('statusid');

	if($status_id == 0)
		{
		$('#change_order_modal').modal('setting', {

	    onApprove : function() {
			$.ajax({
				type: "PUT",
				url: "/order/"+$orderid,
				data: {status_id: $status_id},
				success: function(){
					location.reload();
				}
			})
		}
		}).modal('show');
	}

	if($status_id == 1)
		{
		$('#change_order_modal_sent').modal('setting', {

	    onApprove : function() {
			$.ajax({
				type: "PUT",
				url: "/order/"+$orderid,
				data: {status_id: $status_id, package_number: $('input[name="package_number"]').val()},
				success: function(){
					location.reload();
				}
			})
		}
		}).modal('show');
	}
  
  	if($status_id == 4)
		{
		$('#change_order_modal_cancelled').modal('setting', {

	    onApprove : function() {
			$.ajax({
				type: "PUT",
				url: "/order/"+$orderid,
				data: {status_id: $status_id, cancel_text: $('input[name="cancel_text"]').val()},
				success: function(){
					location.reload();
				}
			})
		}
		}).modal('show');
	}

  })

$('#main_search input').keyup(function(e){
    if(e.which == 13) 
    {
    	location.replace('/search/'+$query);
	}	
	else
	{
		$(document).unbind('ajaxStart');
		$query = $(this).val();
		$('.search_view_all_btn').attr('href', '/search/'+$query);
		$.ajax({
			type: "GET",
			url: "/api/search/"+$query,
			success: function(data){
				$('#search_results.desktop').show();
				$('#search_results.desktop').find('.products').html(data.products);
				$('#search_results.desktop').find('.users').html(data.users);
				$(document).bind('ajaxStart');
			}
		})	
	}
})


$('body').mouseup(function(e) 
{
    var container = $("#search_results.desktop");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});



 var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 18,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
  }

function codeAddress() {
var address = $('#address_map').text();
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == 'OK') {
    map.setCenter(results[0].geometry.location);
    var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
    });
  } else {
    alert('Geocode was not successful for the following reason: ' + status);
  }
});
}


if($('body').attr('id') == 'body_contact')
{
	initialize();
	codeAddress();
}


/*
if($('body').attr('id') == 'cart_shipping')
{
	 var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            $('.invoice_'+component).val('');
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            console.log(addressType);
            $('.invoice_'+addressType).val(val);
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
 		initAutocomplete();

      $('#autocomplete').focus(function(){
      	geolocate();
      })
}
*/




$('.text_save_btn').click(function(){
	$('.text_form').submit();	
})




$('.page_texts_list .item').click(function(){
	$button = $(this);
	$pageid = $(this).data('pageid');
	$textid = $(this).data('textid'); 

	if(!$button.hasClass('active'))
	{
	$.ajax({
		type: "POST",
		url: "/page/"+$pageid+"/attach/"+$textid,
		success: function(data){
			$button.addClass('active');

			$.ajax({
				method: "GET",
				url: '/text/'+$textid,
				success: function(data){
					$('.page_preview').append(data);
				}
			})
		}
	})	
	}
	else{
		$.ajax({
			type: "POST",
			url: "/page/"+$pageid+"/detach/"+$textid,
			success: function(data){
				$button.removeClass('active');

				$('.text_form[data-textid="'+$textid+'"]').remove();
			}
		})	
	}
})

$('.copy_to_clipboard_btn').click(function(){

	var copyText = $(this).closest('.input').find('input');

	/* Select the text field */
	copyText.select();

	/* Copy the text inside the text field */
	document.execCommand("copy");

	$(this).closest('.button').toggleClass('teal green');
	$(this).toggleClass('copy checkmark');
})







function initRelatedSlider(speed){

	$related_carousel = $('.related_products_carousel').flickity({
	    cellAlign: 'left',
	    contain: true,
	    pageDots: false,
	    prevNextButtons: false,
	    imagesLoaded: true,
	    autoPlay: speed,
	});

	$related_carousel.on( 'staticClick.flickity', function( event, pointer, cellElement, cellIndex ) {
		$link = $(cellElement).find('.p_anch').attr('href');
		
		if($($(pointer)[0].target).hasClass('to_cart')==false  && $($(pointer)[0].target).hasClass('icon')==false )
		{
			window.location.href = $link;
		}
	});


}

initRelatedSlider(parseInt($('#suggested_wrapper_speed').find('value').html()));


$("#grid_wrapper").on('click', '.product.item', function(e){
	$link = $(this).find('.p_anch').attr('href');
	if($(e.target).hasClass('to_cart')==false  && $(e.target).hasClass('icon')==false )
	{
		window.location.href = $link;
	}
});




var mobx = $.ModuloBox({
	mediaSelector: '.mobx',
	history: true,
	controls: ['zoom', 'play', 'fullScreen', 'download', 'share', 'close'],
	loop : 1
});

mobx.init();

$('#product_main_wrapper .main').click(function(e){
	e.preventDefault();
	$gallery = $('#product_main_wrapper').data('gallery');
	$index = $('#product_main_wrapper').data('index');
	mobx.open($gallery,$index);
	mobx.play();
})


$('.active_flag').click(function(){
	$item = $(this).closest('.item');
	$icon = $(this).find('i');
	$type = $(this).closest('.item').data('type');
	$id = $(this).closest('.item').data('id');
	$state = $(this).closest('.item').data('active');

	if($state == 1)
	{
		$.ajax({
			type: "PUT",
			url: "/"+$type+"/set/"+$id,
			data: {active: 0},
			success: function(data){
				$icon.toggleClass('red green');
				$item.data('active',0)
			}
		})	
	}
	else
	{
		$.ajax({
			type: "PUT",
			url: "/"+$type+"/set/"+$id,
			data: {active: 1},
			success: function(data){
				$icon.toggleClass('red green');
				$item.data('active',1)
			}
		})	
	}
})


$('#filterbar.horizontal .item').each(function() {
  var $el = $(this);
  $el.popup({    
    popup: '#cat_popup_'+$el.data('cat'),
    on: 'hover',
    hoverable: true,
    exclusive: true,
    position: 'bottom left',
    duration: 0,
    lastResort: 'bottom left'
  });
});


function setSetting($changes, $view ,$load=false, $target){
	$data = {};

	$data['changes'] = $changes;
    $data['view'] = $view;

	$.ajax({
		type: "PUT",
		url: "/admin/page/setting/",
		data: $data,
		success: function(data){
			if ($load){
				$('#page_preview').find('#'+$target).html(data);
			}
		}
	});
}

$('#suggested_wrapper_speed i').click(function(){
	$div = $(this).closest('#suggested_wrapper_speed');
	$this = $(this);
	$speed = parseInt($div.find('value').html());

	if($this.hasClass('plus'))
	{
		$newSpeed = $speed + 100;
		initRelatedSlider($newSpeed);
		$div.find('value').html($newSpeed);
	}
	else
	{
		$newSpeed = $speed - 100;
		initRelatedSlider($newSpeed);
		$div.find('value').html($newSpeed);
	}

	$.ajax({
		type: "PUT",
		url: "/admin/setting/",
		data: {'suggested_wrapper_speed': $newSpeed}
	})	

})

$('.admin_page_settings').checkbox({
    onChecked: function(){
      $item = $(this).data('item');
      $target = $(this).data('target');
      $view = $(this).data('view');

      $changes = {};
      $changes[$item] = 1;

	  setSetting($changes, $view, true, $target);

    },
    onUnchecked: function(){
      $item = $(this).data('item');
      $target = $(this).data('target');
      $view = $(this).data('view');

      $changes = {};
      $changes[$item] = 0;

	  setSetting($changes, $view, true, $target);

    }
})







$('#cover_product_url')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'url',
      image  : '',
      action : '',  
	  actionText: '',    
	  actionURL: '' ,
	  url: '',
    },
    onSelect: function(result, response){
    	$('#admin_add_cover_form').find('input[name="url"]').val(result.full_url);
    }
  }).unbind('ajaxStart');;

$('#cover_category_url')
  .search({
    apiSettings: {
      url: '/api/categories/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'full_url',
      image  : '',
      action : '',  
	  actionText: '',    
	  actionURL: '' ,
	  url: '',
    },
    onSelect: function(result, response){
    	$('#admin_add_cover_form').find('input[name="url"]').val(result.full_url);
    }
  }).unbind('ajaxStart');;

$('#cover_other_url input').change(function(){
$('#admin_add_cover_form').find('input[name="url"]').val($(this).val());
})








$('.catalogue_path_btn').click(function(){
	$('#catalogue_url_input').css('display','flex');
	$('.catalogue_ok_btn').css('display','inline-block');
	$('.catalogue_upload_btn').hide();
	$('.catalogue_path_btn').hide();
})

$('.sticker_path_btn').click(function(){
	$('#sticker_url_input').css('display','flex');
	$('.sticker_ok_btn').css('display','inline-block');
	$('.sticker_upload_btn').hide();
	$('.sticker_path_btn').hide();
})

$('.catalogue_ok_btn').click(function(){
	$path  = $('#catalogue_url_input input').val();
	$.ajax({
		type: "POST",
		url: "/file",
		data: {type: 'catalogue', path: $path, do_not_upload: true},
		success: function(data){
			location.reload();
		}
	})	
})

$('.sticker_ok_btn').click(function(){
	$path  = $('#sticker_url_input input').val();
	$.ajax({
		type: "POST",
		url: "/sticker",
		data: {path: $path, do_not_upload: true},
		success: function(data){
			location.reload();
		}
	})	
})

$('#xml_update_check_btn').click(function(){
	$url =  $('#xml_url_input').val();
	$external = $('#xml_url_input').data('external');
	$(this).addClass('loading');

	$.ajax({
		type: "PUT",
		url: "/admin/eshop/postXmlUpdate/",
		data: {'external': $external, 'url': $url},
		success: function(data){
			$('#xml_results').show();
			$('#xml_results').find('.new_categories_count value').text(data.changes.new_categories.length);
			$('#xml_results').find('.new_products_count value').text(data.changes.new_products.length);
			$('#xml_results').find('.removed_categories_count value').text(data.changes.removed_categories.length);
			$('#xml_results').find('.removed_products_count value').text(data.changes.removed_products);

			$('#xml_results').find('.new_categories_list .list').html(data.newCategories);
			$('#xml_results').find('.new_products_list .list').html(data.newProducts);

			$('#xml_results').find('.removed_categories_list .list').html(data.removedCategories);
			$('#xml_results').find('.removed_products_list .list').html(data.removedProducts);

			$('#xml_update_check_btn').removeClass('loading');
			$('#xml_update_confirm_btn').css('display','inline-block');
		}
	})
});

$('#edit_product_categories_input').dropdown({
  maxSelections: 10,
  fullTextSearch: true,
  onAdd: function(addedValue, addedText, $addedChoice){
    console.log(addedValue);
  }
})

$('#add_banner_radioboxes').find('.checkbox:eq(0)')
  .checkbox({
    onChecked: function() {
     $('#cover_category_url').show();
     $('#cover_product_url').hide();
     $('#cover_other_url').hide();
    },
});


$('#add_banner_radioboxes').find('.checkbox:eq(1)')
  .checkbox({
    onChecked: function() {
     $('#cover_category_url').hide();
     $('#cover_product_url').show();
     $('#cover_other_url').hide();

    },
});

$('#add_banner_radioboxes').find('.checkbox:eq(2)')
  .checkbox({
    onChecked: function() {
     $('#cover_category_url').hide();
     $('#cover_product_url').hide();
     $('#cover_other_url').show();

    },
});


$('.scroll_to_top').click(function(){
  $("html, body").animate({ scrollTop: 0 }, "fast");
})


$('#home_sales_div').on('click','.right.icon',function(){
	$sales_carousel.flickity('next');
}).on('click','.left.icon',function(){
	$sales_carousel.flickity('previous');
});

$('#home_news_div').on('click','.right.icon',function(){
	$news_carousel.flickity('next');
}).on('click','.left.icon',function(){
	$news_carousel.flickity('previous');
});


$('#cartproducts').on('click', 'i.qty', function(){
	$productid = $(this).closest('.product').data('productid');
	$cartid = $('.cart.content').data('cartid');
	$qty = $(this).closest('.actions').find('.cart_qty_input').val();

	if ($(this).hasClass('plus')){
		$newqty = parseFloat($qty)+1;
	}
	else
	{
		$newqty = parseFloat($qty)-1;
	}

	$.ajax({
		type: "PUT",
		url: "/cart/"+$cartid+"/"+$productid,
		data: {qty: $newqty},
		success: function(){
		  location.reload();
		}
	})
})


$('#cartproducts').on('blur', '.cart_qty_input', function(){
	$productid = $(this).closest('.product').data('productid');
	$cartid = $('.cart.content').data('cartid');
	$qty = $(this).val();

	$.ajax({
		type: "PUT",
		url: "/cart/"+$cartid+"/"+$productid,
		data: {qty: $qty},
		success: function(){
		  location.reload();
		}
	})
})


$('#product_detail_translate_btn').click(function(){
	$productid = $('#product_main_wrapper').data('id');

	$.ajax({
		type: "PUT",
		url: "/product/"+$productid+'/translate',
		success: function(){
		  location.reload();
		}
	})
})



$('.pages_list .checkbox').checkbox({
  onChecked: function(){
    $pageid = $(this).closest('.item').data('id');
	$.ajax({
		type: "PUT",
		url: "/api/page/"+$pageid,
		data: {footer: 1},
		success: function(){
		  location.reload();
		}
	})

  },
  onUnchecked: function(){
     $pageid = $(this).closest('.item').data('id');
	 $.ajax({
		type: "PUT",
		url: "/api/page/"+$pageid,
		data: {footer: 0},
		success: function(){
		  location.reload();
		}
	})
  }
})


$('#product_main_wrapper .sizes .size.active').click(function(){
	$code = $(this).data('code');
	$('#product_main_wrapper #code scode').text($code);

	$('#product_main_wrapper .sizes .size').removeClass('selected');
	$(this).addClass('selected');
})


$('#seo_wrapper .checkbox').checkbox({
  onChecked: function(){
    $id = $(this).closest('.item').data('id');
	$.ajax({
		type: "PUT",
		url: "/api/seo/tool/"+$id,
		data: {active: 1},
		success: function(){
		  location.reload();
		}
	})

  },
  onUnchecked: function(){
     $id = $(this).closest('.item').data('id');
	 $.ajax({
		type: "PUT",
		url: "/api/seo/tool/"+$id,
		data: {active: 0},
		success: function(){
		  location.reload();
		}
	})
  }
})

$('#new_xml_field_btn').click(function(){
	$html = $('#seo_tool_profile_wrapper').find('.xml_field').html();
	$('#seo_tool_profile_wrapper .field_list').append($html);

})

$('#product_update_btn').click(function(){
	$id = $(this).data('id');
	$(this).addClass('loading disabled');
	$.ajax({
		type: "POST",
		url: "/api/product/"+$id+"/xmlupdate",
		success: function(data){
		  location.reload();
		  console.log(data);
		}
	})
})

/*

$(document).unbind('keypress').on('keypress', '.msg_input', function(e) {
	$this = $(this);
	$text = $this.val();
	$user = $this.closest('.chat_window').data('user');

	if(e.which == 13) {
	   	$.post('/chat/message', {'text':$text, 'user': $user}, function(data){
	   		$this.val('');
	    });
   	}
});

$(document).unbind('click').on('click', '.chat_window i.delete', function(e) {
	$window = $(this).closest('.chat_window');
	$window.hide();
	$('.chat_icon.user').show();
});

if(Laravel.user.admin)
{
	// activate chat for users
	$('.chat_icon.operator').click(function(){
		$this=$(this);

		if($this.hasClass('inactive'))
		{
			$.post('/chat/activate', {}, function(data){
				$this.addClass('active').removeClass('inactive');
			});
		}
		else
		{
			$.post('/chat/deactivate', {}, function(data){
				$this.addClass('inactive').removeClass('active');
			});	
		}
	})

	//listen for all opened chats
	Echo.private('chats').listen('InitChat', (e) => {
        Echo.channel('chat.'+e.data['user']).listen('MessageSent', (f) => {

			$window = $('.chat_window[data-user="'+e.data['user']+'"]');

			$exists = $window.length;

			if($exists==0)
			{
				$.get('/chat/window/html',{user: e.data['user']}, function(data){
					$('.chat_windows').prepend(data);
					$window = $('.chat_window[data-user="'+e.data['user']+'"]');
					$window.show();
					if(f.data['sender'] == Laravel.user.id)
					{
						$window.find('.msgs').append('<div class="msg own">'+f.data['text']+'</div>');
					}
					else
					{
						$window.find('.msgs').append('<div class="msg">'+f.data['text']+'</div>');
					}
				})
			}
			else
			{
				$window = $('.chat_window[data-user="'+e.data['user']+'"]');
				$window.show();
				if(f.data['sender'] == Laravel.user.id)
				{
					$window.find('.msgs').append('<div class="msg own">'+f.data['text']+'</div>');
				}
				else
				{
					$window.find('.msgs').append('<div class="msg">'+f.data['text']+'</div>');
				}
			}


        }) 
    });
}
else
{
	// init chat on click
	$('.chat_icon.user').click(function(){
		$this = $(this);
		$this.hide();

		if(!$this.hasClass('initiated'))
		{
			$.post('/chat/init', {'user':Laravel.user.id}, function(data){
				$('.chat_window').show();
				$this.addClass('initiated');
			});
		}
		else
		{
			$('.chat_window').show();
		}
	})


	Echo.channel('chat.'+Laravel.user.id).listen('MessageSent', (e) => {
		$window = $('.chat_window[data-user="'+e.data['user']+'"]');
		
		if(e.data['sender'] == Laravel.user.id)
		{
			$window.find('.msgs').append('<div class="msg own">'+e.data['text']+'</div>');
		}
		else
		{
			$window.find('.msgs').append('<div class="msg">'+e.data['text']+'</div>');
		}
	})

	Echo.channel('chats').listen('ActivateChat', (e) => {
		$('.chat_icon.user').show();
	});

	Echo.channel('chats').listen('DeactivateChat', (e) => {
		$('.chat_icon.user').hide();
	});
}



*/

});

$(document).scroll(function() {
  var y = $(this).scrollTop();
  if (y > 800) {
    $('.scroll_to_top').fadeIn();
  } else {
    $('.scroll_to_top').fadeOut();
  }

});

var sticky;
var div;


$(document).on("scroll", function(){
	if($(document).scrollTop() > 100)
	{
	  	$("#header.shrinkable").addClass("shrink");
	}
	else
	{
		$("#header.shrinkable").removeClass("shrink");
	}
});


$(window).on('load', function(){
	if($('.sticky_div').length)
	{
		sticky = $('.sticky_div').offset().top - 20;
		window.onscroll = function() {
			myFunction()
		};
	}

function myFunction() {
	div = $('.sticky_div');

	if (window.pageYOffset >= sticky) {
		div.addClass("stickyy");
		$('#product_content #filterbar').css('position','fixed');
	} else {
		div.removeClass("stickyy");
		$('#product_content #filterbar').css('position','absolute');
	}

}
});




