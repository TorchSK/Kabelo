$(document).ready(function(){
	
// append csrf token to all ajax calls
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


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



})

