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
    
    <div style="background-color: #FFF; border: 1px solid #EEE; padding: 10px; color: #FFF; text-align: center; border-radius: 4px 4px 0 0;">
        
    </div>

    <div style="background-color: rgba(0,0,0,0.04); padding: 50px; text-align: center;">

        <div style="margin: 15px 0; font-size: 18px">You registered to XXX with following info</div>

        <ul>
        <li>Email: <b>{!! $user->email !!}</b></li>
        @if (strlen($user->password) < 20)
        <li>Password: <b>{!! $user->password !!}</b></li>
        @endif
        </ul>

        <div style="margin: 15px 0; font-size: 18px">To finish the registration please activate you account by clicking the button below</div>
        <a href="{!! url("/user/activate").'/'.$token !!}" style="padding: 10px 30px; background-color: rgba(0,0,0,0.4); margin-top: 35px; text-decoration: none; color: white; font-weight: 900; border-radius: 5px;">Activate account</a>
    </div>


    </body>
</html>