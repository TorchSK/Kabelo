<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="index, follow">
    

    <title>
    @if(isset($title))
    {{$title}} | {{App\Setting::firstOrCreate(['name'=>'home_title'])->value}}.sk
    @else
    {{App\Setting::firstOrCreate(['name'=>'home_title'])->value}}.sk
    @endif
    </title>



    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
    <script src="/js/semantic.js"></script>

    <link media="all" type="text/css" rel="stylesheet" href="/css/reset.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/semantic.css">

    <style>
    @media print {
    	body{
    		font-size: 12px;
    	}

    }
    	.products .product .name{
    		width: 100%;
    		margin-right: 10px;
    	}

    	.products .product .qty{
    		width: 20%;
    		margin-right: 10px;
    		text-align: right;

    	}

    	.products .product .price{
    		width: 20%;
    		margin-right: 10px;
    		text-align: right;
    	}

    	.products .product .total{
    		width: 30%;
    		text-align: right;
    	}

    	.products .product{
    		padding: 5px 5px;
    	}

    	.products .product:nth-child(even)
    	{
    		background-color: #EEE;
    	}
	</style>


   
</head>

<html>
<body style="max-width: 700px;">
<div style="padding: 25px; margin-bottom: 50px; text-align: center;">
	<img src="/img/email_logo_dedra.png" style="cursor: pointer; width: 60px; display: inline-block;" onclick="window.print();" />
	<div style="display: inline-block; margin-left: 35px; font-size: 22px; font-weight: 800;">Dedraslovakia.sk</div>
</div>

<div class="order" style="margin-left: 50px;">
	<div class="header" style="border-bottom: 1px solid #CCC; display: flex; justify-content: space-between; padding-bottom: 8px;">
		<div>Číslo objednávky: <b>{{$order->id}}</b></div>
		<div>{{Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s')}}</div>
	</div>

	<div class="products">
		<div style="margin-top: 15px; margin-bottom: 10px; font-weight: 600;">Objednali ste si:</div>
		
			<div class="product" style="display: flex; border-bottom: 1px dashed #CCC; padding-bottom: 5px; margin-bottom: 10px;">
				<div class="name">Názov</div>
				<div class="qty">Počet</div>
				<div class="price">Cena za ks</div>
				<div class="total">Cena celkovo</div>
			</div>
		
		@foreach($order->products as $item)
		<div class="product" style="display: flex;">
			<div class="name">{{$item->name}}</div>
			<div class="qty">{{$item->pivot->qty}} ks</div>
			<div class="price">{{$item->pivot->price}} &euro;</div>
			<div class="total">{{$item->pivot->qty * $item->pivot->price}} &euro;</div>
		</div>
		@endforeach

	</div>
	
	<div style="margin-top: 25px; margin-bottom: 10px; font-weight: 600;">Doprava a platba</div>

	<div class="delivery" style="display: flex; justify-content: space-between;">
		<div style="padding-left: 5px;">{{$order->delivery->name}}</div>
		<div style="padding-left: 5px;">{{$order->delivery->price}} &euro;</div>
	</div>

	<div class="payment" style="margin-top: 5px; display: flex; justify-content: space-between;">
		<div style="padding-left: 5px;">{{$order->payment->name}}</div>
		<div style="padding-left: 5px;">{{$order->payment->price}} &euro;</div>
	</div>

	<div class="total" style="margin-top: 25px; display: flex; justify-content: space-between; font-weight: 900;border-bottom: 1px solid #CCC; padding-bottom: 15px;">
		<div style="">Celkom</div>
		<div style="">{{$order->price + $order->shipping_price}} &euro;</div>
	</div>


 <div style="display: inline-block; width: 70%;">
        <div style="margin: 30px 0;">
            <div style="margin-bottom: 10px;"><b><i class="file alternate outline icon"></i> Fakturačné údaje</b></div>
            <div ><b style="display: inline-block; width: 150px;">Meno a priezvisko:</b> {{json_decode($order->invoice_address)->name}}</div>
            <div><b style="display: inline-block; width: 150px;">Ulica:</b> {{json_decode($order->invoice_address)->street}}</div>
            <div><b style="display: inline-block; width: 150px;">Mesto:</b> {{json_decode($order->invoice_address)->city}}</div>
            <div><b style="display: inline-block; width: 150px;">PSČ:</b> {{json_decode($order->invoice_address)->zip}}</div>
            <div><b style="display: inline-block; width: 150px;">Email:</b> {{json_decode($order->invoice_address)->email}}</div>
            <div><b style="display: inline-block; width: 150px;">Telefón:</b> {{json_decode($order->invoice_address)->phone}}</div>

            <br />
            @if(isset(json_decode($order->invoice_address)->company))
            <div><b style="display: inline-block; width: 150px;">Firma: </b>{{json_decode($order->invoice_address)->company}}</div>
            @endif
            @if(isset(json_decode($order->invoice_address)->ico))
            <div><b style="display: inline-block; width: 150px;">IČO: </b>{{json_decode($order->invoice_address)->ico}}</div>
            @endif
            @if(isset(json_decode($order->invoice_address)->dic))
            <div><b style="display: inline-block; width: 150px;">DIČ: </b>{{json_decode($order->invoice_address)->dic}}</div>
            @endif
            @if(isset(json_decode($order->invoice_address)->icdph))
            <div><b style="display: inline-block; width: 150px;">IČ DPH: </b>{{json_decode($order->invoice_address)->icdph}}</div>
            @endif
        </div>

        @if(isset(json_decode($order->delivery_address)->street))
        <div style="margin: 30px 0;" id="delivery_data">
            <div><b><i class="shipping fast icon"></i> Doručovacie údaje</b></div>
            <div><b style="display: inline-block; width: 150px;">Meno a priezvisko:</b> {{json_decode($order->delivery_address)->name}}</div>
            <div><b style="display: inline-block; width: 150px;">Ulica:</b> {{json_decode($order->delivery_address)->street}}</div>
            <div><b style="display: inline-block; width: 150px;">Mesto</b> {{json_decode($order->delivery_address)->city}}</div>
            <div><b style="display: inline-block; width: 150px;">PSČ:</b> {{json_decode($order->delivery_address)->zip}}</div>
        </div>
        @endif

</div>

</body>
</html>