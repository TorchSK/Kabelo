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
    
    <body style="width: 100%; margin: 0; padding: 0; font-family: 'raleway-regular',Helvetica,Arial,sans-serif; font-size: 14px; font-weight: 300;">
    
    <div style="border-top: 15px #0d345b solid; border-bottom: 1px solid #EEE; padding: 30px; color: #FFF; text-align: center; box-sizing: content-box">
        <img src="<?php echo $message->embed(public_path().'/img/email_logo_'.$appname.'.png'); ?>" width="191">
    </div>

    <div style="padding: 50px; text-align: center;border-radius: 0 0 6px 6px;">

        <div style="margin: 15px 0;">Ďakujeme za registráciu na eshope Dedraslovakia.sk</div>

        <div style="margin: 15px 0; margin-bottom: 35px;">Svoju registráciu dokončite prosím klikom na tlačítko nižšie</div>
        <a href="{!! url("/user/activate").'/'.$token !!}" style="padding: 10px 30px; background-color: #f22b6c; margin-top: 35px; text-decoration: none; color: white; font-weight: 900; border-radius: 5px;">Aktivovať učet</a>
    </div>


    </body>
</html>