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
            font-weight: 100;
            padding: 5px;
        }

        @media screen {
         

          body {
            font-size: 17px;
            font-family: "Roboto", Sans-Serif;
            text-align: center;
            line-height: 20px;
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


          .code{
            margin-right: 15px;
            padding-top: 5px;
            font-weight: 900;
            width: 10%;
          }

          .name{
            margin-right: 15px;
            padding-top: 5px;
            font-weight: 400;
            width: 60%;
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
        <div style="color:#444; font-weight: 800; font-size: 16px;">Dedraslovakia.sk</div>
    </div>

    <div style="background-color: rgba(0,0,0,0.02); padding: 50px;border-radius: 0 0 6px 6px; text-align: center;">
        <div style="width: 100%; max-width: 800px; display: inline-block; text-align: left;">

        <div style="margin: 15px 0;  font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;"><p>
        Dobrý deň, <br/><br/>
        ďakujeme za Vašu objednávku.<br />Tovar bude expedovaný najneskôr do 15 pracovných dní.

        </p>
        </div>
        <br/>
        <div style="margin: 15px 0; font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;" >Objednali ste si:</div>

        @foreach($products as $key => $product)
            <div class="product">

                <div class="image">
                    @if($images[$key]['path'] != null)
                    <img src="{{$images[$key]['path']}}" height="80">
                    @else
                    <img src="{{public_path().'/img/empty.jpg'}}" height="80">
                    @endif
                </div>

                <div class="code">{{$product->code}}</div>
                <div class="name">{{$product->name}}</div>
                <div class="qty"> {{$product->pivot->qty}}{{$product->price_unit}}</div>

                <div class="price">
                    {{$product->pivot->price / $product->pivot->qty}} &euro; / {{$product->price_unit}}
                    <div><b>{{$product->pivot->price}} &euro;</b></div>
                </div>


            </div>
        @endforeach

        <div style="vertical-align: top;">

        <div style="display: inline-block; width: 70%;">
        <div style="margin: 30px 0; font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;" id="invoice_data">
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

        <div style="margin: 30px 0; font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;" id="shipping_data">
            <div><b>Sposob dopravy: </b>{{$delivery_method->name}}, {{$delivery_method->desc}}</div>
            <div><b>Sposob platby: </b>{{$payment_method->name}}, {{$payment_method->desc}}</div>

            @if($payment_method->id == 1)
            <div>{{$payment_method->note}}</div>
            @endif

        </div>
        </div>

        <div style="margin: 30px 0; display: inline-block; vertical-align: top; text-align: right; width: 29%; font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;">
            
            <div style="text-align: right;">
                <div>Cena za tovar: <span style="font-weight: 900;">{{$order->price}}</span> &euro;</div>
                <div>Cena za prepravu: <span style="font-weight: 900;">{{$order->shipping_price}}</span> &euro;</div>

                @if($appname=='copper')
                <div>Celková cena bez DPH: <span style="font-weight: 900">{{round(($order->price + $order->shipping_price)/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</span> &euro;</div>
                <div>DPH: <span style="font-weight: 900">{{($order->price + $order->shipping_price) - round(($order->price + $order->shipping_price)/(1 + App\Setting::where('name','vat')->first()->value/100),2)}}</span> &euro;</div>
                @endif
                
                <div>Celková cena: <span style="font-weight: 900">{{$order->price + $order->shipping_price}}</span> &euro;</div>
            </div>
        </div>

        </div>
        
        @if($order->user_id)
        <div style="text-align: center;margin: 30px 0; font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;" >Stav objednávky si možte skontrolovat aj po kliknuti na</div>

        <div style="text-align: center;">
        <a id="detail_btn" target="_blank" href="{!! url("/order").'/'.$order->id !!}">Detail objednávky</a>
        </div>
        @endif

        <div style="padding: 25px 0; border-top: 1px solid #EEE; margin-top: 50px;">

<pre style="font-family: 'Roboto', Sans-Serif; font-size: 15px; font-weight: 200;">
Vaša 
DEDRA SLOVAKIA
Koordinátor: Monika Tagajová
Číslo koordinátora: 133538

mobil :0904 857 725
mail : obchod@dedraslovakia.sk
web: www.dedraslovakia.sk

V prílohe zasielame Všeobecné obchodné podmienky.
</pre>

</div>

    </body>
</html>