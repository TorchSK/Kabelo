$(document).ready(function(){
	
// append csrf token to all ajax calls
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var path = window.location.pathname.split( '/' );

if (path[2] == 'eshop')
{
  scrollTo('#grid');
}

$('.ui.checkbox').checkbox();

$('#header .account.item').popup({
	popup : $('#auth_popup'),
	on    : 'click'
});

$('.ui.accordion').accordion({
  exclusive: false
}); 


$('#filterbar .ui.accordion').accordion({
  exclusive: false,
    selector    : {
    accordion : '.accordion',
    title     : '.title',
    trigger   : '.title i',
    content   : '.content'
  }
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
    onApprove : function() {
    	$name = $('#add_category_input').val();
      $parent_id = $('#add_category_parent_input input').val();

    	$.ajax({
    		type: "POST",
    		url: "/category/",
    		data: {name: $name, parent_id:$parent_id},
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

$('#create_product_add_param_row').click(function(){
  $html = $('#create_product_params .row:first-child').html();
  $('#create_product_params').append('<div class="row">'+$html+'</div>');
  $('.ui.dropdown').dropdown();
})

$('#edit_product_add_param_row').click(function(){
  $html = $('#edit_product_params .row:first-child').html();
  $('#edit_product_params').append('<div class="row">'+$html+'</div>');
  $('.ui.dropdown').dropdown();
})

$('#create_product_categories_input').dropdown({
  maxSelections: 1,
  onAdd: function(addedValue, addedText, $addedChoice){
    console.log(addedValue);
  }
})


$('#edit_product_categories_input').dropdown({
  maxSelections: 1,
  onAdd: function(addedValue, addedText, $addedChoice){
    console.log(addedValue);
  }
})

$('#create_product_form').submit(function(e){
  $validation = 1;

  $name = $('#product_detail input[name="name"]').val();
  $code = $('#product_detail input[name="code"]').val();
  $maker = $('#product_detail input[name="maker"]').val();


  if ($name=='') {$validation=0; $('#product_detail input[name="name"]').parent().addClass('error');}
  if ($code=='') {$validation=0; $('#product_detail input[name="code"]').parent().addClass('error');}
  if ($maker=='') {$validation=0; $('#product_detail input[name="maker"]').parent().addClass('error');}

 if ($validation==1)
 {
    return true
  }

  return false;
})



$('#edit_category_submit').click(function(){
  $categoryid = $('#category_options').data('categoryid');
  $name = $('#edit_product_name_input input').val()
  $url = $('#edit_product_url_input input').val()

    $.ajax({
      method: "PUT",
      url: "/category/"+$categoryid,
      data: {name: $name, url: $url},
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
    method: "POST",
    url: '/cart/'+productid,
    data: {},
    global: false,
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
          location.replace('/cart/products');
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
  return $('.categories .item.selected').data('categoryid');
}

function getDesiredSortBy(){
  return $('.sort.active').data('sortby');
}

function getDesiredSortOrder(){
  return $('.sort.active').data('sortorder');
}

function initPriceSlider(){

    var checkExists = $('#price_slider').length;

    var window_width = $(window).width();
    
    if (window_width < 770){
      $pipsCount = 5;
      $decimals = 1;
    } else {
      $pipsCount = 10;
      $decimals = 2;
    }

    if (checkExists)
    {

      if ($('#price_slider')[0].noUiSlider)
      {
        $('#price_slider')[0].noUiSlider.destroy();
      }

      var priceSlider = document.getElementById('price_slider');

      if ($('#grid_stats').data('maxprice'))
      {
        $max = $('#grid_stats').data('maxprice')
      }
      else
      {
        $max = 1;
      }

      noUiSlider.create(priceSlider, {
        start: [ getPriceFilter('price')[0], getPriceFilter('price')[1]],
        connect: true,
        range: {
          'min': 0,
          'max': $max
        },
        pips: { 
          mode: 'count', 
          density: 1,
          values: $pipsCount,
          format: wNumb({
            decimals: $decimals,
            postfix: '€'
          })
        }
      });

      priceSlider.noUiSlider.on('set', function()
      {
        $min = priceSlider.noUiSlider.get()[0];
        $max = priceSlider.noUiSlider.get()[1];

        removeFilter('price');
        addFilter('price',  priceSlider.noUiSlider.get(), 'Cena medzi: '+$min+' a '+$max);
        doSort();
      });

    }
}

initPriceSlider();
filtersInit();

function doSort(){

  //console.log(getPriceFilter('price'));

  $grid = $('#grid').find('grid');
  $filtersDiv = $('#filterbar').find('.params');

  $sortBy = getDesiredSortBy();
  $sortOrder = getDesiredSortOrder();


  $filters = getActiveFilters();
  $categoryid = getActiveCategory();

  $.get('/product/list',{category: $categoryid, sortBy: $sortBy, sortOrder: $sortOrder, filters: $filters}, function(data){
    $grid.html(data.products);
    $filtersDiv.html(data.filters);
    filtersInit();
    $('#grid').find('.dimmer').removeClass('active');
    $('#grid').show();
    $('.sorts').show();
    $('#price_slider').show();
    
    initPriceSlider();

    
   
  })
};

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
  if ($(this).hasClass('active'))
  {
    if ($(this).data('sortorder')=='asc')
    {
      $(this).data('sortorder','desc');
      $(this).find('i').removeClass('ascending').addClass('descending');
    }
    else
    {
      $(this).data('sortorder','asc');
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



$('.categories .item .icon').click(function(e){
  $(this).toggleClass('minus plus');
})


$('#cart_delivery_options .step').click(function(){
  $('#cart_delivery_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
  if ($(this).data('delivery_method')=='place')
  {
    $('#cart_payment_options .step[data-payment_method="cash"]').removeClass('active disabled');
    $('#cart_payment_options .step[data-payment_method="cod"]').addClass('disabled').removeClass('completed active');
  }
  else
  {
    $('#cart_payment_options .step[data-payment_method="cod"]').removeClass('active disabled');
    $('#cart_payment_options .step[data-payment_method="cash"]').addClass('disabled').removeClass('completed active');;
  }

  if ($('#cart_payment_options .step.completed').length > 0)
  {
    $('.cart_next').removeClass('disabled');
  }
   else
  {
    $('.cart_next').addClass('disabled');
  }
})

$('#cart_payment_options .step').click(function(){
  $('#cart_payment_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
  if ($('#cart_delivery_options .step.completed').length > 0)
  {
    $('.cart_next').removeClass('disabled');
  }
  else
  {
    $('.cart_next').addClass('disabled');
  }
})

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
  $productid = $('#product_detail').data('id');
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



$(document).ajaxStart(function() {
  $('#grid').find('.dimmer').addClass('active');
});

$(document).ajaxStop(function() {
  $('#grid').find('.dimmer').removeClass('active');
});

$(".product_search_input input").keyup(function(e){

  $query = $(this).val();
  removeFilter('search');
  if ($query!='') 
  {
    addFilter('search',$query,'hľadaj: '+$query)
  }
  else
  {
    removeFilter('search')

  };
  doSort();

})


$('#settings_submit_btn').click(function(){
  $validation = 1;

  $userid = $('#settings_user').data('userid');

  $container = $('#settings_user').find('#right');

  $data = {
    first_name: $container.find('input[name="first_name"]').val(),
    last_name: $container.find('input[name="last_name"]').val(),
    phone: $container.find('input[name="phone"]').val(),
    invoiceAddress: {
      street: $container.find('input[name="invoice_address_street"]').val(),
      zip: $container.find('input[name="invoice_address_zip"]').val(),
      city: $container.find('input[name="invoice_address_city"]').val(),
    },
    deliveryAddress: {
      name: $container.find('input[name="delivery_address_name"]').val(),
      street: $container.find('input[name="delivery_address_street"]').val(),
      city: $container.find('input[name="delivery_address_city"]').val(),
      zip: $container.find('input[name="delivery_address_zip"]').val(),
      additional: $container.find('input[name="delivery_address_additional"]').val(),
      phone: $container.find('input[name="delivery_address_phone"]').val(),
    },
  };

  /*
  if ($data.invoiceAddress.street && (!$data.invoiceAddress.zip || !$data.invoiceAddress.city))
  {
    $validation = 0;
    $container.find('input[name="invoice_address_zip"]').closest('.input').addClass('error');
    $container.find('input[name="invoice_address_city"]').closest('.input').addClass('error');
  }

  if ($data.invoiceAddress.zip && (!$data.invoiceAddress.street || !$data.invoiceAddress.city))
  {
    $validation = 0;
    $container.find('input[name="invoice_address_street"]').closest('.input').addClass('error');
    $container.find('input[name="invoice_address_city"]').closest('.input').addClass('error');
  }

  if ($data.invoiceAddress.city && (!$data.invoiceAddress.zip || !$data.invoiceAddress.street))
  {
    $validation = 0;
    $container.find('input[name="invoice_address_zip"]').closest('.input').addClass('error');
    $container.find('input[name="invoice_address_street"]').closest('.input').addClass('error');
  }

  */
  
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

  $data.invoiceAddress = JSON.stringify($data.invoiceAddress);
  $data.deliveryAddress = JSON.stringify($data.deliveryAddress);

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

$(".cart_delivery").click(function(){
  $delivery = $(this).data('delivery_method');

  $.ajax({
    method: "POST",
    url: '/cart',
    data: {delivery_method: $delivery}
  })
})

$(".cart_payment").click(function(){
  $payment = $(this).data('payment_method');

  $.ajax({
    method: "POST",
    url: '/cart',
    data: {payment_method: $payment}
  })
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


$('#cart_shipping_next_btn').click(function(e){
    $validation = 1;

    $invoiceAddress = {};
    $deliveryAddress = {};
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
    
    if ($deliveryAdressFlag)
    {
      $deliveryAddressInputs = $('.cart_address').find('.delivery').find('.input');
      $deliveryAddressInputs.each(function(index, item){
        $type = $(item).data('column');
        $deliveryAddress[$type] = $(item).find('input').val();
        if ($(item).find('input').val() == '')
        {
          $validation = 0;
          $(item).addClass('error');
        }
      })
    }


    console.log($validation);

    

    if ($validation)
    { 
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


$('#admin #grid .product.item').draggable({ 
  opacity: 0.6, 
  helper: "clone"
});

$('.categories .item').droppable({
  tolerance: "pointer",
  accept: ".product",
  over: function( event, ui ) {
    $(this).addClass('active');
  },
  out: function( event, ui ) {
    $(this).removeClass('active');
  },
  deactivate: function( event, ui ) {
    $(this).removeClass('active');
  },
  drop: function( event, ui ) {
    $categoryId = $(this).data('categoryid');
    $product = $(ui.draggable);

    $.post('/product/'+$product.data('productid')+'/change/category/'+$categoryId,{},function(){
          $product.remove();
    });

    $(this).removeClass('active');
  }

});


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
  $('#catbar').sidebar('toggle');
})

$('#catbar .categories .item').click(function(){
  $('#catbar').sidebar('hide');
})

$("#parambarbar_handle").click(function(){
  $('#parambar').sidebar('toggle');
})

$('.close_btn').click(function(){
  $('.ui.sidebar').sidebar('hide');
})

$('#home_sales_div').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false,
    prevNextButtons: false,
    imagesLoaded: true
});

$('#home_news_div').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false,
    prevNextButtons: false,
    imagesLoaded: true
});

$('#admin_add_category_param_btn').click(function(){
  $html = $('#admin_filters_div .row:first-child').clone();
  $('#admin_filters_div').append($html);
})

$('#product_detail_dropzone').dropzone({
    params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#import_dropzone').dropzone({
    success: function(param, data){
      $table = $('#admin_import_results').find('table');
      $row = $table.find('tbody tr');
      $.each(data, function(index,item){
        $lastRow = $table.find('tbody tr:last-child');
        $lastRow.find('td[col="name"]').html(item['name']);
        $lastRow.find('td[col="code"]').html(item['code']);
        $lastRow.find('td[col="maker"]').html(item['maker']);

        console.log(item);

        $row.clone().appendTo($table);

      })

      //delete the duplicate last row
      $table.find('tbody tr:last-child').remove();
    },
    params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    }
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

$('.ui.dropdown').dropdown({
  allowCategorySelection: true
});

$('#category_image_dropzone').dropzone({
  success: function(file, response){
    var $x, $y, $w, $h;
    this.removeAllFiles(true); 
    $('.crop_preview').html("<img src=/"+response+" height='50' />").unbind('focus');
    $('.crok_ok').show();

    $('.crop_preview img').cropper({
      guides: false,
      viewMode: 1,
      aspectRatio: 1.78,
      autoCropArea: 1,
      crop: function(e){
        $x = e.x;
        $y = e.y;
        $w = e.width;
        $h = e.height;
      },
      preview: $('.category_image .image')
    });

    // confirm crop
    $('.crop_ok').show().click(function(){
      $categoryid = $(this).data('categoryid');

      $.ajax({
        method: "POST",
        url: '/category/'+$categoryid+'/image/confirmCrop',
        data: {filename: file.name, x: $x, y:$y, w:$w, h:$h},
        success: function(){
          location.reload();
        }
      })
    });

  }
});

$('.covers').flickity({
  autoPlay: 6000,
  adaptiveHeight: true

});


$('.admin_wrapper .categories').nestedSortable({
  handle: 'div',
  items: 'li',
  toleranceElement: '> div',
  listType: 'ul',
  disableParentChange: true,
  relocate: function(event, ui){
    $data = {};

    $('.admin_wrapper .categories .category.item').each(function(index, item){
      $data[$(item).data('categoryid')] = index;
    });
    console.log($data);

    $.ajax({
      method: "PUT",
      url: '/categories/setorder',
      data: $data
    })
  }
});

$('.tabs .tab').click(function(){
  $('.tabs .tab').removeClass('brown').addClass('basic');
  $(this).addClass('brown').removeClass('basic')
  $('.tabs .content').removeClass('active');
  $('.tabs .content[data-tab="'+$(this).data("tab")+'"]').addClass('active');
})

$('.my.rating').rateYo({
  rating: $('#myrating').data('rating')
})

$('.rating:not(.disabled)').rateYo().on("rateyo.set", function(e, data){

      $('#new_rating_modal').modal('setting', {
        autofocus: true,
        onApprove : function() {
          $text = $('#new_rating_modal textarea').val();
          $id = $('#product_detail').data('id');
          $.ajax({
            type: "POST",
            url: "/product/"+$id+"/rating",
            data: {value: data.rating},
            success: function(){
              location.reload();
            }
          })
        }
        }).modal('show');
    });


$('.disabled.rating').rateYo({
  readOnly: true,
})




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
    onApprove : function() {
      $key = $('#add_delivery_method_key_input').val();
      $name = $('#add_delivery_method_name_input').val();
      
      $.ajax({
        type: "POST",
        url: "/admin/delivery/",
        data: {name: $name, key:$key},
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
      $key = $('#add_payment_method_key_input').val();
      $name = $('#add_payment_method_name_input').val();
      
      $.ajax({
        type: "POST",
        url: "/admin/payment/",
        data: {name: $name, key:$key},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})


$(document).on('click','.admin_method_list i.action', function(){
  $row = $(this).closest('tr');
  $type = $(this).closest('tbody').data('type');
  $id = $row.data('id');
  $this = $(this);
  $key = $row.find('td:first-child').text();
  $name = $row.find('td:nth-child(2)').text();
  $desc = $row.find('td:nth-child(3)').text();
  $icon = $row.find('.ui.dropdown').dropdown('get value');


  if ($(this).hasClass('edit'))
  {
      $row.find('i.red').css('display','inline-block');
      $(this).toggleClass('edit check square green');

      $row.find('td:not(:last-child):not(:nth-child(4))').prop('contenteditable',true).addClass('editable');
      $row.find('.ui.dropdown').show();
      $row.find('td:nth-child(4)>i.icon').hide();
  }
  else
  {
      $.ajax({
        type: "PUT",
        url: "/admin/"+$type+"/"+$id,
        data: {name:$name, key: $key, desc:$desc, icon: $icon},
        success: function(){
            $this.toggleClass('edit check square green');
            isEditable=$row.is('.editable');
            $row.find('td:not(:last-child)').prop('contenteditable',false).removeClass('editable');
            $row.find('i.red').hide();
            $row.find('.ui.dropdown').hide();
            $row.find('td:nth-child(4)>i.icon').attr('class','').addClass('big icon '+$icon).show();
        }
      })
  };
})

$('.admin_method_list i.red').click(function(){
  $(this).hide();
  $row = $(this).closest('tr');
  $row.find('td:not(:last-child)').prop('contenteditable',false).removeClass('editable');
  $('.admin_method_list i.green.square.check').toggleClass('green square check edit');
              $row.find('.ui.dropdown').hide();
            $row.find('td:nth-child(4)>i.icon').show();
})



$('.tabbs .tabb').click(function(){
  $('.tabbs .tabb').removeClass('brown').addClass('basic');
  $(this).addClass('brown').removeClass('basic')
  $('.tabbs+.contents .content').removeClass('active');
  $('.tabbs+.contents .content[data-tab="'+$(this).data("tab")+'"]').addClass('active');
})


});


