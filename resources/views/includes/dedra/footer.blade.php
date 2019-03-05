<footer>
<div class="container">
	<div class="column">
		 <a class="logo item" href="/">
         <img src="/img/logo_{{strtolower($appname)}}.png" alt="logo" height="50"/>
          <text>{{ucfirst($appname)}}</text>
        </a>

	</div>

  <div class="stretch">
    @foreach(App\Page::whereFooter(1)->orderBy('order')->get() as $page)
	   <div class="column"><a href="{{route('slug',$page->url)}}" class="effect-1">{{$page->name}}</a></div>
    @endforeach
  </div>  

	<div class="column social">
		<a href="https://www.facebook.com/dedraslovakia/" target="_blank"><i class="facebook f icon"></i></a>
		<a href="/" target="_blank"><i class="twitter icon"></i></a>
		<a href="/" target="_blank"><i class="instagram icon"></i></a>
   <div id="td">Made with <o>love</o> by &copy; <a class="effect-1" href="mailto:jan.krnac@email.cz" target="_top">Ján Krnáč</a></div>
	</div> 


      @if(Cookie::get('cookies_consent')==null)  
      <div id="cookies_msg">Tento web používa súbory cookies. Prehliadaním webu vyjadrujete súhlas s ich používaním. <a href="/cookies/info">Viac informácií.</a><button class="ui blue mini button" id="cookies_consent_btn">OK</button></div>
      @endif

</div>
<div class="container last">

  <div class="">
    Táto stránka nie je oficiálna stránka spoločnosti VAŠE DEDRA
  </div>
</div>

@if(auth()->check() && auth()->user()->admin)
  <div class="chat_windows"></div>
@else
  <div class="chat_icon user">
    <i class="life ring blue icon"></i>
  </div>
@endif

@if(!auth()->check() || (auth()->check() && auth()->user()->admin==0))
  @include('chat.window',['user'=>Session::getId()])
@endif

</footer>	

