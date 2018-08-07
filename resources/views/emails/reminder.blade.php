<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <style type="text/css">
        ul {
            list-style: none;
            margin:0;
            padding:0;
        }
        ul li{
            font-size: 18px;
            font-weight: 100;
            padding: 5px;
        }
        </style>
    </head>
    
    <body style="max-width: 1000px;">
    
    <div style="background-color: #2B2D2D; border: 1px solid #EEE; padding: 10px; color: #FFF; text-align: center; border-radius: 4px 4px 0 0;">
        <img src="<?php echo $message->embed(public_path().'/img/email_logo.jpg'); ?>" width="191">
    </div>

    <div style="background-color: rgba(0,0,0,0.04); padding: 50px; text-align: center;">
    <h1>Reset hesla na stránke Kabelo.sk</h1>
	<div>Pre reset svojho hesla kliknite na tlačítko nižšie</div>
	<br /><br />
    <div> 
    <a href={!! url("/password/reset").'/'.$token !!} style="padding: 10px 30px; background-color: #5E88BF; margin-top: 35px; text-decoration: none; color: white; font-weight: 900; border-radius: 5px;">Reset hesla</a>
	</div>

    </div>

    </body>
</html>