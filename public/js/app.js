$(document).ready(function(){
	
// append csrf token to all ajax calls
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('.ui.checkbox').checkbox();

$('#header .account.item').popup({
	popup : $('#auth_popup'),
	on    : 'click'
});

$('#register_btn').click(function(){
	$popup = $('#auth_popup');
	$email = $('#register_div').find('input[name="email"]').val();
	$password = $('#register_div').find('input[name="password"]').val();

	$.post('/register',{email:$email, password: $password}, function(){
		$popup.html('Check you email');
	})

})


$('#login_btn').click(function(){
	$popup = $('#auth_popup');
	$email = $('#login_div').find('input[name="email"]').val();
	$password = $('#login_div').find('input[name="password"]').val();

	$.post('/login',{email:$email, password: $password}, function(){
		location.reload('/');
	})

});

$('#add_category_btn').click(function(){
	$('#add_category_modal').modal('setting', {
    onApprove : function() {
    	$name = $('#add_category_input').val();
    	$.ajax({
    		type: "POST",
    		url: "/category/",
    		data: {name: $name},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})

// scrolTo smooth 
function scrollTo(element){
  $('html,body').animate({scrollTop: $(element).offset().top});  
}

$('.ui.dropdown')
  .dropdown({
  })
;

$('#create_product_add_param_row').click(function(){
  $html = '<div class="row"><div class="ui input key"><input type="text" /></div><div class="ui input value"><input type="text" /></div></div>';
  $('#create_product_params').append($html);
})


$('#create_product_submit').click(function(){
  $params = {};
  $validation = 1;

  $name = $('#create_product_name_input input').val();
  $code = $('#create_product_code_input input').val();
  $categories = $('#create_product_categories_input').val();
  $desc = $('#create_product_desc_input textarea').val();
  $price = $('#create_product_price_input input').val();
  $unit = $('#create_product_unit_input input').val();
  $maker = $('#create_product_maker_input input').val();

  $("#create_product_params .row").each(function( index ) {
     if ($(this).find('.key').find('input').val()) {$key = $(this).find('.key').find('input').val();};
     if ($(this).find('.value').find('input').val()) {$value = $(this).find('.value').find('input').val();}

     if (typeof $key!=='undefined' && typeof $value !== 'undefined')
     {
        $params[$key] = $value;
     }

  });

  if ($params.length > 0)
  {
    $params = JSON.stringify($params);
  }

  if ($name=='') {$validation=0; $('#create_product_name_input').addClass('error');}

 if ($validation==1)
 {
    $.post('/product',{name:$name, categories: $categories, desc: $desc, params: $params, price:$price, unit:$unit, code: $code, maker: $maker}, function(data){
      location.replace('/'+data);
    })
  }
})

$('#edit_product_submit').click(function(){
  $productid = $('#product_detail').data('id');
    $.ajax({
      method: "PUT",
      url: "/product/"+$productid,
      success: function(data){
        location.replace(data)
      } 
    })
});

$('#edit_category_submit').click(function(){
  $categoryid = $('#category_options').data('categoryid');
  $name = $('#edit_product_name_input input').val()
    $.ajax({
      method: "PUT",
      url: "/category/"+$categoryid,
      data: {name: $name},
      success: function(data){
        location.replace(data)
      } 
    })
});

$('.other_img img').click(function(){
  $('#product_detail .img img').attr('src', $(this).attr('src'));
})



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


function addToCart(productid){
  var cart = $('#header .cart.item');
  var number = parseFloat(cart.find('text number').text());
  var price = parseFloat(cart.find('price number').text());

  $.ajax({
    method: "PUT",
    url: '/cart/add/'+productid,
    data: {},
    success: function(data){
      cart.find('text number').text(number+1);
      cart.find('price number').text(price+parseFloat(data.price));
    }
  })
}


$('#product_detail_tocart_btn').click(function(){
  $product = $('#product_detail').data('id');
  var cart = $('#header .cart.item');
  var img = $('#product_detail').find('.img');
  flyToElement(img, cart);
  
  addToCart($product);

})


$(document).on('click', '#grid .to_cart',function(){
  $product = $(this).closest('.product').data('productid');
  var cart = $('#header .cart.item');
  var img = $(this).closest('.product').find('.image_div');
  flyToElement(img, cart);
  
  addToCart($product);

})

$('.delete_cart').click(function(){
    $('#delete_cart_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/cart/all",
        data: {},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})


$('.cart_delete_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $.ajax({
    type: "DELETE",
    url: "/cart/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

$('.cart_plus_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $.ajax({
    type: "PUT",
    url: "/cart/plus/"+$productid,
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
    url: "/cart/minus/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

///// Sorting and filtering ////////

function getActiveFilters(){
  
  $filters={};

  $('#active_filters span').each(function(index, element){
    $filters[$(element).data('filter')]={};
  });

  $.each($filters,function(key,value){
    $('#active_filters span.'+key).each(function(index, element) {
      $filters[key]['item'+index] = $(element).data('value');
    });
  });

  return $filters;
}

function getActiveCategory(){
  return $('.categories .item.active').data('categoryid');
}

function doSort(){
  $grid = $('#grid').find('grid');

  $filters = getActiveFilters();
  $categoryid = getActiveCategory();

  $.get('/product/list',{categoryid:$categoryid, filters: $filters}, function(data){
    $grid.html(data);
    $('#grid').find('.dimmer').removeClass('active');
  })
};

function addFilter(key, value, desc){
$('#active_filters').append('<span data-value="'+value+'" data-filter="'+key+'" class="'+key+' ui large teal label">'+desc+'<i class="delete icon"></i></span>');

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


function makersInit(){
  $('.makers  .ui.checkbox').checkbox({
    onChecked: function(){
      $makerid = $(this).closest('.checkbox').data('makerid');
      $text = $(this).closest('.checkbox').find('label').text();
      addFilter('makers',$makerid, 'Výrobca: '+ $text)
      doSort();
    },
    onUnchecked: function(){
        removeFilter('makers',$makerid);
        doSort();
    }
  })
}

$('.categories .item').click(function(){

  if (!$(this).hasClass('active'))
  {
    $.get('/category/'+$(this).data('categoryid')+'/makers',{}, function(data){
        $('#home_content .makers').html(data);
        makersInit();
    });

    removeFilter('makers');
    addFilter('category',$(this).data('categoryid'),$(this).text());

  }

  $('.categories .item').removeClass('active');
  $(this).addClass('active');


  doSort();

})


$('#cart_delivery_options .step').click(function(){
  $('#cart_delivery_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
  if ($(this).data('delivery')=='place')
  {
    $('#cart_payment_options .step[data-payment="cash"]').removeClass('disabled');
    $('#cart_payment_options .step[data-payment="cod"]').addClass('disabled').removeClass('completed');
  }
  else
  {
    $('#cart_payment_options .step[data-payment="cod"]').removeClass('disabled');
    $('#cart_payment_options .step[data-payment="cash"]').addClass('disabled').removeClass('completed');;
  }
})

$('#cart_payment_options .step').click(function(){
  $('#cart_payment_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
})

$('#view_goods_btn').click(function(){
  scrollTo('#home_content');
})

$('#login_password_input').keypress(function(e){
  if(e.which == 13) {
        $('#login_btn').click();
    }
});

$('#product_detail_delete_btn').click(function(){
  $productid = $('#product_detail').data('id');
  $('#delete_product_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/product/"+$productid,
        data: {},
        success: function(){
          location.replace('/admin');
        }
      })
    }
  }).modal('show');
})

$(".product_search_input input").keyup(function(e){

  $( document ).ajaxStart(function() {
    $('#grid').find('.dimmer').addClass('active');
  });

  $query = $(this).val();
  removeFilter('search');
  if ($query!='') {addFilter('search',$query,'hľadaj: '+$query)};
  doSort();

})

});