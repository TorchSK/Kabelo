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
        ul li{            font-weight: 100;
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
            font-size: 14px;
            font-family: "Lato", "Lucida Grande", "Lucida Sans Unicode", Tahoma, Sans-Serif;
            text-align: center;
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
            width: 15%;
            margin-right: 15px;
          }

          .image{
            width: 80px;
            height: 80px;
          }

          .image img{
            max-width: 100%;
            max-height: 100%;
          }

          .name{
            margin-right: 15px;
            padding-top: 10px;
            font-weight: 900;
            width: 70%;
          }


          .price{
            display: inline-block;
            padding-top: 10px;
            float: right;
            width: 15%;
            text-align: right;
          }

          #detail_btn{
            padding: 15px 25px;
            background-color: #f22b6c;
            border-radius: 3px;
            text-decoration: none;
            color: #FFF;
            font-weight: 900;
            display: inline-block;
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
    
    <body style="width: 100%;margin: 0; padding: 0; ">
    
    <div style="border-top: 15px #0d345b solid; border-bottom: 1px solid #EEE; padding: 30px; color: #FFF; text-align: center; box-sizing: content-box">
        <img src="<?php echo $message->embed(public_path().'/img/email_logo_'.$appname.'.png'); ?>" width="56">
    </div>

    <div style="background-color: rgba(0,0,0,0.02); padding: 50px;border-radius: 0 0 6px 6px; text-align: center;">
        <div style="width: 100%; max-width: 800px; display: inline-block; text-align: left;">

        <div style="margin: 15px 0;">Vaša objednávka č. {{$order->id}} bola <b>zrušená</b></div>
        <div style="margin: 15px 0;">Dôvod zrušenia: {{$order->cancel_text}} </div>

        <div style="margin: 15px 0;; font-weight: 100;" >Objednali ste si:</div>

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
               
                <div class="price">{{$product->pivot->qty}}{{$product->price_unit}} / {{$product->pivot->price}} &euro;</div>


            </div>
        @endforeach

        <div style="vertical-align: top;">

        <div style="display: inline-block; width: 70%;">
        <div style="margin: 30px 0;" id="invoice_data">
            <div><b>Fakturačné údaje</b></div>
            <div>{{json_decode($order->invoice_address)->name}}</div>
            <div>{{json_decode($order->invoice_address)->street}}</div>
            <div>{{json_decode($order->invoice_address)->city}}</div>
            <div>{{json_decode($order->invoice_address)->zip}}</div>
            <div>{{json_decode($order->invoice_address)->email}}</div>
            <div>{{json_decode($order->invoice_address)->phone}}</div>

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
        </div>

        <div style="margin: 30px 0; display: inline-block; vertical-align: top; text-align: right; width: 29%;">
            
            <div style="font-size: 14px; text-align: right;">
                <div style="font-size: 14px;">Cena za tovar s DPH: <span style="font-weight: 900">{{$order->price}}</span> &euro;</div>
                <div style="font-size: 14px;">Cena za prepravu s DPH: <span style="font-weight: 900">{{$order->shipping_price}}</span> &euro;</div>

                @if($appname=='copper')
                <div style="font-size: 14px;">Celková cena bez DPH: <span style="font-weight: 900">{{round(($order->price + $order->shipping_price)/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</span> &euro;</div>
                <div style="font-size: 14px;">DPH: <span style="font-weight: 900">{{($order->price + $order->shipping_price) - round(($order->price + $order->shipping_price)/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</span> &euro;</div>
                @endif
                
                <div style="font-size: 14px;">Celková cena s DPH: <span style="font-weight: 900">{{$order->price + $order->shipping_price}}</span> &euro;</div>
            </div>
        </div>

        </div>

        <div style="text-align: center;margin: 30px 0; font-size: 14px;">Stav objednávky si možte skontrolovat aj po kliknuti na</div>

        <div style="text-align: center;">
        <a id="detail_btn" target="_blank" href="{!! url("/order").'/'.$order->id !!}">Detail objednávky</a>
    </div>
    </div>
</div>

    </body>
</html>