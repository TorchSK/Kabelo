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

        @media screen {
          @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
          }

          body {
            font-family: "Lato", "Lucida Grande", "Lucida Sans Unicode", Tahoma, Sans-Serif;
          }

        </style>
    </head>
    
    <body style="max-width: 1000px; color: #000;">
    
    <div style="background-color: #2B2D2D; border: 1px solid #EEE; padding: 10px; color: #FFF; text-align: center; border-radius: 6px 6px 0 0;">
        <img src="<?php echo $message->embed(public_path().'/img/email_logo.jpg'); ?>" width="191">
    </div>

    <div style="background-color: rgba(0,0,0,0.04); padding: 50px; text-align: center;border-radius: 0 0 6px 6px;">

        <div style="margin: 15px 0; font-size: 18px">Ďakujeme za Vašu objednávku</div>

        <div style="margin: 15px 0; font-size: 18px; font-weight: 100;" >Objednali ste si:</div>
        @foreach($order->products as $product)
            <div style="padding: 10px; background-color: #FFF; border-right: 5px; text-align: left;">{{$product->name}}</div>
        @endforeach
        <div style="margin: 30px 0; font-size: 14px;">Budeme Vás informovať o stave.</div>
    </div>


    </body>
</html>