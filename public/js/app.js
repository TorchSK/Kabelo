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
  $name = $('#create_product_name_input input').val();
  $code = $('#create_product_code_input input').val();
  $categories = $('#create_product_categories_input').val();
  $desc = $('#create_product_desc_input textarea').val();
  $price = $('#create_product_price_input input').val();
  $unit = $('#create_product_unit_input input').val();
  $maker = $('#create_product_maker_input input').val();

  $("#create_product_params .row").each(function( index ) {
     $key = $(this).find('.key').find('input').val();
     $value = $(this).find('.value').find('input').val();

     $params[$key] = $value;
  });

  if ($params.length > 0)
  {
    $params = JSON.stringify($params);
  }

  $.post('/product',{name:$name, categories: $categories, desc: $desc, params: $params, price:$price, unit:$unit, code: $code, maker: $maker}, function(data){
    location.replace('/product/'+data);
  })

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
  })
};

$('.makers  .ui.checkbox').checkbox({
  onChecked: function(){
      $('#active_filters').append('<span data-value="'+$(this).closest('.checkbox').data('makerid')+'" data-filter="maker" class="maker ui large teal label">'+$(this).closest('.checkbox').find('label').text()+'<i class="delete icon"></i></span>');
      doSort();
  },
  onUnchecked: function(){
      $('#active_filters').find('span[data-value="'+$(this).closest('.checkbox').data('makerid')+'"][data-filter="maker"]').remove();
      doSort();
  }
})


$('.categories .item').click(function(){
  $('.categories .item').removeClass('active');
  $(this).addClass('active');
  doSort();
})

});