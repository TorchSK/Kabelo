<!DOCTYPE html>
<html>
    @include('includes.head')

    <body id="welcome">

    	<div id="cover">
			
			<div class="welcome_center">

				<div id="msg">
					Na eshope sa pracuje
	    		</div>

	    		<div id="login_div">

	    		<form action="/login" class="login_form" method="POST">
	              <input name="_token" type="hidden" value="{{csrf_token()}}">

	              <div class="ui fluid big input">
	                <input type="text" name="email" placeholder="email">
	              </div>

	              <div class="ui fluid big input" id="login_password_input">
	                <input type="password" name="password" placeholder="heslo">
	              </div>

	              <button type="submit" class="ui brown big fluid button" id="login_btn">Prihlásiť</button>

	            </form>

	    		</div>

	    	</div>

    	</div>

    </body>
</html>