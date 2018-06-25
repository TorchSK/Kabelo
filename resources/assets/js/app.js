!function(a){"use strict";a.fn.tableToJSON=function(b){var c={ignoreColumns:[],onlyColumns:null,ignoreHiddenRows:!0,ignoreEmptyRows:!1,headings:null,allowHTML:!1,includeRowId:!1,textDataOverride:"data-override",extractor:null,textExtractor:null};b=a.extend(c,b);var d=function(a){return void 0!==a&&null!==a},e=function(a){return void 0!==a&&a.length>0},f=function(c){return d(b.onlyColumns)?-1===a.inArray(c,b.onlyColumns):-1!==a.inArray(c,b.ignoreColumns)},g=function(b,c){var f={},g=0;return a.each(c,function(a,c){g<b.length&&d(c)&&(e(b[g])&&(f[b[g]]=c),g++)}),f},h=function(c,d,e){var f,g=a(d),h=b.extractor||b.textExtractor,i=g.attr(b.textDataOverride);return null===h||e?a.trim(i||(b.allowHTML?g.html():d.textContent||g.text())||""):a.isFunction(h)?(f=i||h(c,g),"string"==typeof f?a.trim(f):f):"object"==typeof h&&a.isFunction(h[c])?(f=i||h[c](c,g),"string"==typeof f?a.trim(f):f):a.trim(i||(b.allowHTML?g.html():d.textContent||g.text())||"")},i=function(c,d){var e=[],f=b.includeRowId,g="boolean"==typeof f?f:"string"==typeof f,i="string"==typeof f==!0?f:"rowId";return g&&void 0===a(c).attr("id")&&e.push(i),a(c).children("td,th").each(function(a,b){e.push(h(a,b,d))}),e},j=function(a){var c=a.find("tr:first").first();return d(b.headings)?b.headings:i(c,!0)};return function(c,e){var i,j,k,l,m,n,o,p=[],q=0,r=[];return c.children("tbody,*").children("tr").each(function(c,e){if(c>0||d(b.headings)){var f=b.includeRowId,g="boolean"==typeof f?f:"string"==typeof f;n=a(e);var r=n.find("td").length===n.find("td:empty").length;!n.is(":visible")&&b.ignoreHiddenRows||r&&b.ignoreEmptyRows||n.data("ignore")&&"false"!==n.data("ignore")||(q=0,p[c]||(p[c]=[]),g&&(q+=1,void 0!==n.attr("id")?p[c].push(n.attr("id")):p[c].push("")),n.children().each(function(){for(o=a(this);p[c][q];)q++;if(o.filter("[rowspan]").length)for(k=parseInt(o.attr("rowspan"),10)-1,m=h(q,o),i=1;i<=k;i++)p[c+i]||(p[c+i]=[]),p[c+i][q]=m;if(o.filter("[colspan]").length)for(k=parseInt(o.attr("colspan"),10)-1,m=h(q,o),i=1;i<=k;i++)if(o.filter("[rowspan]").length)for(l=parseInt(o.attr("rowspan"),10),j=0;j<l;j++)p[c+j][q+i]=m;else p[c][q+i]=m;m=p[c][q]||h(q,o),d(m)&&(p[c][q]=m),q++}))}}),a.each(p,function(c,h){if(d(h)){var i=d(b.onlyColumns)||b.ignoreColumns.length?a.grep(h,function(a,b){return!f(b)}):h,j=d(b.headings)?e:a.grep(e,function(a,b){return!f(b)});m=g(j,i),r[r.length]=m}}),r}(this,j(this))}}(jQuery);


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
  $price = $('#product_detail input[name="price"]').val();


  if ($name=='') {$validation=0; $('#product_detail input[name="name"]').parent().addClass('error');}
  if ($code=='') {$validation=0; $('#product_detail input[name="code"]').parent().addClass('error');}
  if ($maker=='') {$validation=0; $('#product_detail input[name="maker"]').parent().addClass('error');}
  if ($price=='') {$validation=0; $('#product_detail input[name="price"]').parent().addClass('error');}

 if ($validation==1)
 {
    return true
  }

  return false;
})



$('#edit_category_submit').click(function(){
  $categoryid = $(this).data('categoryid');
  $name = $('#edit_product_name_input input').val()
  $url = $('#edit_product_url_input input').val()

    $.ajax({
      method: "PUT",
      url: "/category/"+$categoryid,
      data: {name: $name, url: $url},
      success: function(data){
        location.reload();
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



$('.categories .item .icon.plus').click(function(e){
  $(this).toggleClass('minus plus');
})


$('#cart_delivery_options .step').click(function(){
  $('#cart_delivery_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
  $delivery_method_id = $(this).data('delivery_method');

  $('#cart_payment_options .step').each(function(index, element){
    $(element).removeClass('disabled completed active');
    if ($.inArray($delivery_method_id, $(element).data('delivery_methods'))==-1)
    {
      $(element).addClass('disabled');
    }
  });

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
      viewMode: 0,
      aspectRatio: 1.78,
      autoCropArea: 1,
      crop: function(e){
        $x = e.x;
        $y = e.y;
        $w = e.width;
        $h = e.height;
      },
      preview: $('#category_image_div .category_image .image')
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
  autoPlay: 4000,
  adaptiveHeight: true
});


$('.admin_wrapper .categories').nestedSortable({
  handle: 'div',
  items: 'li',
  toleranceElement: '> div',
  listType: 'ul',
  disableParentChange: false,
  stop: function(event, ui){
    $data = [];
    $orders = {};
    $parents = {};

    $('.admin_wrapper .categories .category.item').each(function(index, item){
      $orders[$(item).data('categoryid')] = index;
      $parents[$(item).data('categoryid')] = $(item).closest('li').parent().closest('li').data('categoryid');
    });
    //console.log($(ui.item).closest('li').parent().closest('li').data('categoryid'));

    $.ajax({
      method: "PUT",
      url: '/categories/setorder',
      data: {'orders':$orders, 'parents': $parents}
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
      $name = $('#add_delivery_method_name_input').val();
      $desc = $('#add_delivery_method_desc_input').val();
      $icon = $('#add_delivery_method_modal').find('.ui.dropdown').dropdown('get value');

      $.ajax({
        type: "POST",
        url: "/admin/delivery/",
        data: {name: $name, desc:$desc, icon: $icon},
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
      $icon = $('#add_payment_method_modal').find('.ui.dropdown').dropdown('get value');
      
      $.ajax({
        type: "POST",
        url: "/admin/payment/",
        data: {name: $name, desc:$desc, icon: $icon},
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


function initCoverEdit()
{
    $('.cover.editable .cover_div').resizable({
        stop: function stop() {
          $('#admin_add_cover_form input[name="width"]').val($(this).width() / $(this).parent().width() * 100);
        }
      }).draggable({
      containment: ".cover_image",
      start: function start(event, ui) {
        var left = parseInt($(this).css('left'), 10);
        left = isNaN(left) ? 0 : left;
        var top = parseInt($(this).css('top'), 10);
        top = isNaN(top) ? 0 : top;
        __recoupLeft = left - ui.position.left;
        __recoupTop = top - ui.position.top;
      },
      drag: function drag(event, ui) {
        //resize bug fix ui drag `enter code here`
        __dx = ui.position.left - ui.originalPosition.left;
        __dy = ui.position.top - ui.originalPosition.top;
        //ui.position.left = ui.originalPosition.left + ( __dx/__scale);
        //ui.position.top = ui.originalPosition.top + ( __dy/__scale );
        ui.position.left = ui.originalPosition.left + __dx;
        ui.position.top = ui.originalPosition.top + __dy;
        //
        ui.position.left += __recoupLeft;
        ui.position.top += __recoupTop;
      },
      stop: function stop() {
        var pos = {};

        $('#admin_add_cover_form input[name="left"]').val($(this).position().left / $(this).parent().width() * 100);
        $('#admin_add_cover_form input[name="top"]').val($(this).position().top / $(this).parent().height() * 100);
      }
    });

    $('.cover_div h1').css('color',$('#admin_add_cover_form input[name="h1_color"]').val());
    $('.cover_div h1').css('font-size',$('#admin_add_cover_form input[name="h1_size"]').val()+'vw');
    $('.cover_div h2').css('color',$('#admin_add_cover_form input[name="h2_color"]').val());
    $('.cover_div h2').css('font-size',$('#admin_add_cover_form input[name="h2_size"]').val()+'vw');
    $('.cover_div h1').text($('#admin_add_cover_form input[name="h1_text"]').val());
    $('.cover_div h2').text($('#admin_add_cover_form input[name="h2_text"]').val());

    $('.cover_div').css('left',$('#admin_add_cover_form input[name="left"]').val()+'%');
    $('.cover_div').css('top',$('#admin_add_cover_form input[name="top"]').val()+'%');
    $('.cover_div').css('width',$('#admin_add_cover_form input[name="width"]').val()+'%');

}

initCoverEdit();

$('#cover_dropzone').dropzone({
  clickable: ['#admin_add_cover_change_image_btn', '#cover_dropzone'],
  success: function(file, response){
    var $x, $y, $w, $h;
    this.removeAllFiles(true); 
    $('.crop_preview').html("<img src=/"+response+" />").unbind('focus');
    $('.admin_add_cover_under').css('display','flex');
    $('.cover_image').show();
    $('#cover_dropzone').hide();
    $('#admin_add_cover_form input[name="filename"]').val(file.name);
    $('#admin_add_cover_change_image_btn').hide();

    $('.crop_preview img').cropper({
      guides: false,
      viewMode: 1,
      aspectRatio: 3.3,
      autoCropArea: 1,

      crop: function(e){
        $('#admin_add_cover_form input[name="x"]').val(e.x);
        $('#admin_add_cover_form input[name="y"]').val(e.y);
        $('#admin_add_cover_form input[name="w"]').val(e.width);
        $('#admin_add_cover_form input[name="h"]').val(e.height);

        if ($('.cover_image').find('.cover_div').length == 0)
        {
         $('.cover_image .cover').append('<div class="cover_div"><h1>Nadpis</h1><h2>Text ktory sa zobrazi pod nadpisom</h2></div>');
        }

        initCoverEdit();

      },
      preview: $('.cover_image .cover')
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


$('.admin_add_cover_h1_color_btn').spectrum({
      color:  $('#admin_add_cover_form input[name="h1_color"]').val(),
      showAlpha: true
});

$('.admin_add_cover_h2_color_btn').spectrum({
      color:  $('#admin_add_cover_form input[name="h2_color"]').val(),
      showAlpha: true

});

$(".admin_add_cover_h1_color_btn").on('move.spectrum', function(e, color) {
    $('.cover_div h1').css('color',color.toRgbString());
    $('#admin_add_cover_form input[name="h1_color"]').val(color.toRgbString());
});

$(".admin_add_cover_h2_color_btn").on('move.spectrum', function(e, color) {
    $('.cover_div h2').css('color',color.toRgbString()); 
    $('#admin_add_cover_form input[name="h2_color"]').val(color.toRgbString());
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


$('.admin_cover_list h1').each(function(index,element){
  $(element).css('font-size', parseFloat(($(element).css('font-size')))*0.18);
});

$('.admin_cover_list h2').each(function(index,element){
  $(element).css('font-size', parseFloat(($(element).css('font-size')))*0.2);
});



$('.delete_cover_btn').click(function(){
  $btn = $(this);
  $('#delete_cover_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
      $id = $btn.closest('.cover').data('id');
      $.ajax({
        type: "DELETE",
        url: "/admin/cover/"+$id,
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})


$('.admin_cover_list').sortable({
  stop: function(){
    $data = {};

    $('.admin_cover_list .cover').each(function(index, item){
      $data[$(item).data('id')] = index;
    });

    $.ajax({
      method: "PUT",
      url: '/admin/cover/setorder',
      data: $data
    })
  }
});

$('table.sortable').tablesorter({
  cssAsc:'sorted ascending',
  cssDesc:'sorted descending'
});


setTimeout(function () {
  $('.covers').fadeTo("slow", 1);
}, 100);

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
        }   
      })
    }
  });

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


$('.change_cat_img_btn').click(function(){
  $('#category_image_dropzone').click();
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



$('.product_color.editable').spectrum({
    showPaletteOnly: true,
    hideAfterPaletteSelect:true,
    color: 'blanchedalmond',
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ]
});

$(".product_color.editable").on('change.spectrum', function(e, color) {
    $(this).css('background-color',color.toRgbString());
    $('#add_color_value_input').val(color.toHexString());
});

$('.product_color.choosable')
  .popup({
    popup : $('.flowing.popup'),
    on    : 'hover',
    hoverable: true
  })
;

});


