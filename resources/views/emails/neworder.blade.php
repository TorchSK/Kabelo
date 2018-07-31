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

          .product{
            text-align: left;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            background-color: #FFF;
            padding: 7px;
            margin-bottom: 4px;
            border-radius: 3px;
            align-content: center;
            align-items: center;   
          }

          .image{
            width: 60px;
            margin-right: 15px;
          }

          .image img{
            width: 60px;
          }

          .name{
            margin-right: 15px;
            padding-top: 15px;
            font-weight: 900;
          }

          .desc{
            display: inline-block;
            padding-top: 15px;
          }
      }

        </style>
    </head>
    
    <body style="max-width: 1000px; color: #000;">
    
    <div style="background-color: #2B2D2D; border: 1px solid #EEE; padding: 10px; color: #FFF; border-radius: 6px 6px 0 0;  text-align: center;">
        <img src="<?php echo $message->embed(public_path().'/img/email_logo.jpg'); ?>" width="191">
    </div>

    <div style="background-color: rgba(0,0,0,0.04); padding: 50px;border-radius: 0 0 6px 6px;">

        <div style="margin: 15px 0; font-size: 18px">Ďakujeme za Vašu objednávku</div>

        <div style="margin: 15px 0; font-size: 18px; font-weight: 100;" >Objednali ste si:</div>

        @foreach($products as $key => $product)
            <div class="product">

                <div class="image">
                    @if($images[$key]['path'] != null)
                    <img src="{{ $message->embed($images[$key]['path']) }}">
                    @else
                    <img src="{{ $message->embed(public_path().'/img/empty.jpg') }}">
                    @endif
                </div>

                <div class="name">{{$product->name}}</div>
               
                <div class="desc">{{substr($product->desc,0,100)}}</div>

            </div>
        @endforeach
        <div style="margin: 30px 0;">
            <span>Budeme Vás informovať o stave.</span>
            <span style="font-size: 14px; float: right">Celková cena: <span style="font-weight: 900">{{$order->price}}</span> &euro;</span>
        </div>

        <div style="margin: 30px 0; font-size: 14px;">Stav objednávky si možte skontrolovat aj po kliknuti na</div>

    </div>


    </body>
</html>