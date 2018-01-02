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

$('#add_maker_btn').click(function(){
	$('#add_maker_modal').modal('show');
})


})

