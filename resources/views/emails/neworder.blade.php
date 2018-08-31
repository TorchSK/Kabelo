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
            width: 10%;
            margin-right: 15px;
          }

          .image img{
            width: 60px;
          }

          .name{
            margin-right: 15px;
            padding-top: 15px;
            font-weight: 900;
            width: 10%;
          }

          .desc{
            display: inline-block;
            padding-top: 15px;
            width:70%;
          }


          .price{
            display: inline-block;
            padding-top: 15px;
            float: right;
            width: 10%;
          }

          #detail_btn{
            padding: 15px 25px;
            background-color: #235299;
            border-radius: 3px;
            text-decoration: none;
            color: #FFF;
            font-weight: 900;
          }

          #invoice_data div{
            font-size: 15px;
          }
      
        #delivery_data div{
            font-size: 15px;
          }

        #invoice_data div b{
            width: 100px;   
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

                <div class="price">{{$product->pivot->qty}}{{$product->price_unit}} / {{$product->pivot->price}} &euro;</div>


            </div>
        @endforeach

        <div style="margin: 30px 0;" id="invoice_data">
            <div><b>Fakturačné údaje</b></div>
            <div>{{json_decode($order->invoice_address)->name}}</div>
            <div>{{json_decode($order->invoice_address)->street}}</div>
            <div>{{json_decode($order->invoice_address)->city}}</div>
            <div>{{json_decode($order->invoice_address)->zip}}</div>
            <div>{{json_decode($order->invoice_address)->email}}</div>
            <br />
            @if(isset(json_decode($order->invoice_address)->company))
            <div><b>Firma: </b>{{json_decode($order->invoice_address)->company}}</div>
            @endif
            @if(isset(json_decode($order->invoice_address)->ico))
            <div><b>IČO: </b>{{json_decode($order->invoice_address)->ico}}</div>
            @endif
            @if(isset(json_decode($order->invoice_address)->dic))
            <div><b>DIČ: </b>{{json_decode($order->invoice_address)->dic}}</div>
            @endif
            @if(isset(json_decode($order->invoice_address)->icdph))
            <div><b>IČ DPH: </b>{{json_decode($order->invoice_address)->icdph}}</div>
            @endif
        </div>
        @if(isset(json_decode($order->delivery_address)->street))
        <div style="margin: 30px 0;" id="delivery_data">
            <div><b>Doručovacie údaje</b></div>
            <div>{{json_decode($order->delivery_address)->name}}</div>
            <div>{{json_decode($order->delivery_address)->street}}</div>
            <div>{{json_decode($order->delivery_address)->city}}</div>
            <div>{{json_decode($order->delivery_address)->zip}}</div>
        </div>
        @endif

        <div style="margin: 30px 0;" id="shipping_data">
            <div><b>Sposob dopravy: </b>{{$delivery_method->name}}</div>
            <div><b>Sposob platby: </b>{{$payment_method->name}}</div>
        </div>

        <div style="margin: 30px 0;">

            <span>Budeme Vás informovať o stave.</span>
            
            <div style="font-size: 14px; text-align: right;">
                <div style="font-size: 14px;">Cena za tovar s DPH: <span style="font-weight: 900">{{$order->price}}</span> &euro;</div>
                <div style="font-size: 14px;">Cena za prepravu s DPH: <span style="font-weight: 900">{{$order->shipping_price}}</span> &euro;</div>

                <div style="font-size: 14px;">Celková cena bez DPH: <span style="font-weight: 900">{{round(($order->price + $order->shipping_price)/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</span> &euro;</div>
                <div style="font-size: 14px;">DPH: <span style="font-weight: 900">{{($order->price + $order->shipping_price) - round(($order->price + $order->shipping_price)/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</span> &euro;</div>

                <div style="font-size: 14px;">Celková cena s DPH: <span style="font-weight: 900">{{$order->price + $order->shipping_price}}</span> &euro;</div>
            </div>
        </div>

        <div style="margin: 30px 0; font-size: 14px;">Stav objednávky si možte skontrolovat aj po kliknuti na</div>

        <a id="detail_btn" target="_blank" href="{!! url("/order").'/'.$order->id !!}">Detail objednávky</a>
    </div>


    </body>
</html>