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
    
    <div style="background-color: #2B2D2D; border: 1px solid #EEE; padding: 10px; color: #FFF; text-align: center; border-radius: 6px 6px 0 0;">
        <img src="<?php echo $message->embed(public_path().'/img/email_logo.jpg'); ?>" width="191">
    </div>

    <div style="background-color: rgba(0,0,0,0.04); padding: 50px; text-align: center;border-radius: 0 0 6px 6px;">

        <div style="margin: 15px 0; font-size: 18px">Ďakujeme za registráciu na eshope Kabelo.sk</div>

        <div style="margin: 15px 0; font-size: 18px; margin-bottom: 35px;">Svoju registráciu dokončite prosím klikom na tlačítko nižšie</div>
        <a href="{!! url("/user/activate").'/'.$token !!}" style="padding: 10px 30px; background-color: #A5673F; margin-top: 35px; text-decoration: none; color: white; font-weight: 900; border-radius: 5px;">Aktivovať učet</a>
    </div>


    </body>
</html>