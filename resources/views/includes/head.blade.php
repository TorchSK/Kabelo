<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="CY9IwgJZGjaR_icVxrolcCKFZUjWhHfx9QDnJ32_MLE" />
    
    <meta name="keywords" content="darček,darčeky pre muža,darčeky pre ženu,dedra,drogeria,dekoracie,šperky,doplnky do domácnosti,do bytu,domov, stolovanie,porcelán,bižutéria,cestovanie,keramika">
    
    <meta name="description" content="DEDRA EKO čistiace prostriedky, darčeky pre mužov, darčeky pre ženy, šperky, drogéria pre domácnosť">
    <meta name="robots" content="index, follow">
    
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@if(isset($product)){{$product->name}} @else Dedra @endif"/>
    <meta property="og:description" content="@if(isset($product)){{substr($product->desc,0,100)}} @else Dedra @endif" />
    @if (isset($product) && $product->image)
    <meta property="og:image" content="@if(isset($product)){{$product->image->path}} @else {{url('img/'.$appname)}}_favico.png @endif" />
    @endif

    <title>
    @if(isset($title))
    {{$title}} | {{App\Setting::firstOrCreate(['name'=>'home_title'])->value}}.sk
    @else
    {{App\Setting::firstOrCreate(['name'=>'home_title'])->value}}.sk
    @endif
    </title>

    <link rel="icon" type="image/png" href="{{url('img/'.$appname)}}_favico.png" />

    @if($appname=='kabelo')
    <link rel="canonical" href="https://www.dedra.kabelo.sk/">
    @else
    <link rel="canonical" href="https://www.{{$appname}}.sk/">
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
    <script src="/js/semantic.js"></script>
    <script src="/js/flickity.js"></script>
    <script src="/js/wNumb.js"></script>
    <script src="/js/nouislider.js"></script>
    <script src="/js/cropper.js"></script>
    <script src="/js/rating.js"></script>
    <script src="/js/spectrum.js"></script>
    <script src="/js/tablesorter.js"></script>
    <script src="/js/modulobox.min.js"></script>
    <script src="/js/nestedsortable.js"></script>
    <script src="/js/dropzone.js"></script>
    <script src="/js/infinite.js"></script>
    <script src="/js/handsontable.full.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    @if(request()->route()->getName() != 'slug')
    <link media="all" type="text/css" rel="stylesheet" href="/css/reset.css">
    @endif
    
    <link media="all" type="text/css" rel="stylesheet" href="/css/rateyo.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/spectrum.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/semantic.css">
    <link media="all" type="text/css" rel="stylesheet" href="https://use.typekit.net/nnc8ofe.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/flickity.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/nouislider.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/dropzone.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/cropper.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/modulobox.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/handsontable.full.min.css">

    <link media="all" type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">


    @if(App\Setting::where('name','layout')->first()->value == 1 || Request::segment(1)=='admin')
    <link media="all" type="text/css" rel="stylesheet" href="/css/app_layout_1.css">
    @else
    <link media="all" type="text/css" rel="stylesheet" href="/css/app_layout_2.css">
    @endif

    <link media="all" type="text/css" rel="stylesheet" href="/css/{{$appname}}.css">


    <script src="/js/app.js"></script>

    <!-- Global site tag (gtag.js) - AdWords: 795715349 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-795715349"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-795715349');
    </script>

    <script>
      gtag('event', 'page_view', {
        'send_to': 'AW-795715349',
        'dynx_itemid': 'replace with value',
        'dynx_itemid2': 'replace with value',
        'dynx_pagetype': 'replace with value',
        'dynx_totalvalue': 'replace with value',
        'user_id': 'replace with value'
      });
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdqx8xXl2sxDke485SNJXjXXd2UZu_ofc&libraries=places"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qf9bxbfqc0n3wz9w142mp9fu5fybtks16oqfiduv88ea66zi"></script>

</head>