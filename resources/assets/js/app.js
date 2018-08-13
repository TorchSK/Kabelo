!function(a){"use strict";a.fn.tableToJSON=function(b){var c={ignoreColumns:[],onlyColumns:null,ignoreHiddenRows:!0,ignoreEmptyRows:!1,headings:null,allowHTML:!1,includeRowId:!1,textDataOverride:"data-override",extractor:null,textExtractor:null};b=a.extend(c,b);var d=function(a){return void 0!==a&&null!==a},e=function(a){return void 0!==a&&a.length>0},f=function(c){return d(b.onlyColumns)?-1===a.inArray(c,b.onlyColumns):-1!==a.inArray(c,b.ignoreColumns)},g=function(b,c){var f={},g=0;return a.each(c,function(a,c){g<b.length&&d(c)&&(e(b[g])&&(f[b[g]]=c),g++)}),f},h=function(c,d,e){var f,g=a(d),h=b.extractor||b.textExtractor,i=g.attr(b.textDataOverride);return null===h||e?a.trim(i||(b.allowHTML?g.html():d.textContent||g.text())||""):a.isFunction(h)?(f=i||h(c,g),"string"==typeof f?a.trim(f):f):"object"==typeof h&&a.isFunction(h[c])?(f=i||h[c](c,g),"string"==typeof f?a.trim(f):f):a.trim(i||(b.allowHTML?g.html():d.textContent||g.text())||"")},i=function(c,d){var e=[],f=b.includeRowId,g="boolean"==typeof f?f:"string"==typeof f,i="string"==typeof f==!0?f:"rowId";return g&&void 0===a(c).attr("id")&&e.push(i),a(c).children("td,th").each(function(a,b){e.push(h(a,b,d))}),e},j=function(a){var c=a.find("tr:first").first();return d(b.headings)?b.headings:i(c,!0)};return function(c,e){var i,j,k,l,m,n,o,p=[],q=0,r=[];return c.children("tbody,*").children("tr").each(function(c,e){if(c>0||d(b.headings)){var f=b.includeRowId,g="boolean"==typeof f?f:"string"==typeof f;n=a(e);var r=n.find("td").length===n.find("td:empty").length;!n.is(":visible")&&b.ignoreHiddenRows||r&&b.ignoreEmptyRows||n.data("ignore")&&"false"!==n.data("ignore")||(q=0,p[c]||(p[c]=[]),g&&(q+=1,void 0!==n.attr("id")?p[c].push(n.attr("id")):p[c].push("")),n.children().each(function(){for(o=a(this);p[c][q];)q++;if(o.filter("[rowspan]").length)for(k=parseInt(o.attr("rowspan"),10)-1,m=h(q,o),i=1;i<=k;i++)p[c+i]||(p[c+i]=[]),p[c+i][q]=m;if(o.filter("[colspan]").length)for(k=parseInt(o.attr("colspan"),10)-1,m=h(q,o),i=1;i<=k;i++)if(o.filter("[rowspan]").length)for(l=parseInt(o.attr("rowspan"),10),j=0;j<l;j++)p[c+j][q+i]=m;else p[c][q+i]=m;m=p[c][q]||h(q,o),d(m)&&(p[c][q]=m),q++}))}}),a.each(p,function(c,h){if(d(h)){var i=d(b.onlyColumns)||b.ignoreColumns.length?a.grep(h,function(a,b){return!f(b)}):h,j=d(b.headings)?e:a.grep(e,function(a,b){return!f(b)});m=g(j,i),r[r.length]=m}}),r}(this,j(this))}}(jQuery);

// (c) 2010 jdbartlett, MIT license
(function(a){a.fn.loupe=function(b){var c=a.extend({loupe:"loupe",width:200,height:150},b||{});return this.length?this.each(function(){var j=a(this),g,k,f=j.is("img")?j:j.find("img:first"),e,h=function(){k.hide()},i;if(j.data("loupe")!=null){return j.data("loupe",b)}e=function(p){var o=f.offset(),q=f.outerWidth(),m=f.outerHeight(),l=c.width/2,n=c.height/2;if(!j.data("loupe")||p.pageX>q+o.left+10||p.pageX<o.left-10||p.pageY>m+o.top+10||p.pageY<o.top-10){return h()}i=i?clearTimeout(i):0;k.show().css({left:p.pageX-l,top:p.pageY-n});g.css({left:-(((p.pageX-o.left)/q)*g.width()-l)|0,top:-(((p.pageY-o.top)/m)*g.height()-n)|0})};k=a("<div />").addClass(c.loupe).css({width:c.width,height:c.height,position:"absolute",overflow:"hidden"}).append(g=a("<img />").attr("src",j.attr(j.is("img")?"src":"href")).css("position","absolute")).mousemove(e).hide().appendTo("body");j.data("loupe",true).mouseenter(e).mouseout(function(){i=setTimeout(h,10)})}):this}}(jQuery));
$(document).ready(function(){


!function(a,b){a.fn.prettyEmbed=function(c){function g(d){var e=d.find("img").outerWidth(!0),f=d.find("img").outerHeight(!0),g="",h="";d.attr("data-pe-videoid")!==b?h=d.attr("data-pe-videoid"):c.videoID!==b?h=c.videoID:(h=b,console.error("PrettyEmbed.js Error:  Misformed or missing video ID.")),("false"===d.attr("data-pe-show-info")||c.showInfo===!1)&&(g+="&showinfo=0"),("false"===d.attr("data-pe-show-controls")||c.showControls===!1)&&(g+="&controls=0"),("true"===d.attr("data-pe-loop")||c.loop===!0)&&(g+="&loop=1"),("true"===d.attr("data-pe-closed-captions")||c.closedCaptions===!0)&&(g+="&cc_load_policy=1"),(d.attr("data-pe-localization")!==b||c.localization!==b)&&(d.attr("data-pe-localization")!==b?g+="&hl="+d.attr("data-pe-localization"):c.localization!==b&&(g+="&hl="+c.localization)),("light"==d.attr("data-pe-color-scheme")||"light"==c.colorScheme)&&(g+="&theme=light"),g+="false"===d.attr("data-pe-show-related")||c.showRelated===!1?"&rel=0":"&rel=1",fullScreenFlag="false"===d.attr("data-pe-allow-fullscreen")||c.allowFullScreen===!1?"":"allowfullscreen ",d.html('<iframe width="'+e+'" height="'+f+'" '+fullScreenFlag+'style="border:none;" src="//www.youtube.com/embed/'+h+"?autoplay=1"+g+'"></iframe>').addClass("play"),c.useFitVids&&a.isFunction(a.fn.fitVids)&&d.parent().fitVids()}function h(a){var b=/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/,c=a.match(b);return c&&11==c[7].length?c[7]:(console.error("PrettyEmbed.js Error:  Bad URL."),void 0)}c=a.extend({},a.fn.prettyEmbed.options,c);var d=/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)?!0:!1;0===a("#pretty-embed-style").length&&a("<style />",{id:"pretty-embed-style",html:'.pretty-embed{position:relative;cursor:pointer;display:block}.pretty-embed img{width:100%;height:auto}.pretty-embed iframe{border:0 solid transparent}.pretty-embed:after{display:block;content:"";position:absolute;top:50%;margin-top:-19px;left:50%;margin-left:-27px;width:54px;height:38px;background-image:url(data:image/png;base64,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);-webkit-background-size:cover;background-size:cover}.pretty-embed.play:after{display:none}.pretty-embed:hover:after{background-image:url(data:image/png;base64,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)}'}).appendTo("head"),c.useFitVids&&(a.isFunction(a.fn.fitVids)||console.error("PrettyEmbed.js Error:  options.useFitVids is set to true; FitVids not found!"));var f;f=0===a(this).length?a(".pretty-embed"):a(this),f.each(function(){a(this).addClass("pretty-embed");var e,j,k,l,m,n,o,p,q,f="",g="",i="";if(f=a(this).attr("data-pe-videoid")!==b?a(this).attr("data-pe-videoid"):a(this).attr("href")!==b?h(a(this).attr("href")):c.videoID,g=a(this).attr("data-pe-preview-size")!==b?a(this).attr("data-pe-preview-size"):c.previewSize!==b?c.previewSize:b,i=a(this).attr("data-pe-custom-preview-image")!==b?a(this).attr("data-pe-custom-preview-image"):c.customPreviewImage!==b?c.customPreviewImage:b,j=a(this).attr("data-pe-show-info")!==b?a(this).attr("data-pe-show-info"):c.showInfo!==b?c.showInfo:b,k=a(this).attr("data-pe-show-controls")!==b?a(this).attr("data-pe-show-controls"):c.showControls!==b?c.showControls:b,l=a(this).attr("data-pe-loop")!==b?a(this).attr("data-pe-loop"):c.loop!==b?c.loop:b,m=a(this).attr("data-pe-closed-captions")!==b?a(this).attr("data-pe-closed-captions"):c.closedCaptions!==b?c.closedCaptions:b,n=a(this).attr("data-pe-localization")!==b?a(this).attr("data-pe-localization"):c.localization!==b?c.localization:b,o=a(this).attr("data-pe-color-scheme")!==b?a(this).attr("data-pe-color-scheme"):c.colorScheme!==b?c.colorScheme:b,p=a(this).attr("data-pe-show-related")!==b?a(this).attr("data-pe-show-related"):c.showRelated!==b?c.showRelated:b,q=a(this).attr("data-pe-allow-fullscreen")!==b?a(this).attr("data-pe-allow-fullscreen"):c.allowFullScreen!==b?c.allowFullScreen:b,a(this).is("a")&&(e=a("<div />").addClass("pretty-embed"),e.attr("data-pe-videoid",f).attr("data-pe-preview-size",g).attr("data-pe-custom-preview-image",i).attr("data-pe-show-info",j).attr("data-pe-show-controls",k).attr("data-pe-loop",l).attr("data-pe-closed-captions",m).attr("data-pe-localization",n).attr("data-pe-color-scheme",o).attr("data-pe-show-related",p).attr("data-pe-allow-fullscreen",q),a(this).after(e)),i!==b&&""!==i)a(this).html('<img src="'+i+'" width="100%" alt="YouTube Video Preview" />');else{var s="";switch(g){case"thumb-default":s="default";break;case"thumb-1":s="1";break;case"thumb-2":s="2";break;case"thumb-3":s="3";break;case"default":s="mqdefault";break;case"medium":s="0";break;case"high":s="hqdefault";break;default:s="mqdefault"}a(this).html('<img src="//img.youtube.com/vi/'+f+"/"+s+'.jpg" width="100%" alt="YouTube Video Preview" />')}a(this).is("a")&&(e.html(a(this).html()),a(this).remove()),d&&a(window).on("load",function(){a(".pretty-embed").trigger("click")})}),a("body").on("click",".pretty-embed",function(b){b.preventDefault(),g(a(this))}),a.fn.prettyEmbed.options={videoID:"",previewSize:"",customPreviewImage:"",showInfo:!0,showControls:!0,loop:!1,closedCaptions:!1,colorScheme:"dark",showRelated:!1,useFitVids:!1}}}(jQuery);


/*! Lity - v2.3.1 - 2018-04-20
* http://sorgalla.com/lity/
* Copyright (c) 2015-2018 Jan Sorgalla; Licensed MIT */

!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(c){return b(a,c)}):"object"==typeof module&&"object"==typeof module.exports?module.exports=b(a,require("jquery")):a.lity=b(a,a.jQuery||a.Zepto)}("undefined"!=typeof window?window:this,function(a,b){"use strict";function c(a){var b=B();return N&&a.length?(a.one(N,b.resolve),setTimeout(b.resolve,500)):b.resolve(),b.promise()}function d(a,c,d){if(1===arguments.length)return b.extend({},a);if("string"==typeof c){if(void 0===d)return void 0===a[c]?null:a[c];a[c]=d}else b.extend(a,c);return this}function e(a){for(var b,c=decodeURI(a.split("#")[0]).split("&"),d={},e=0,f=c.length;e<f;e++)c[e]&&(b=c[e].split("="),d[b[0]]=b[1]);return d}function f(a,c){return a+(a.indexOf("?")>-1?"&":"?")+b.param(c)}function g(a,b){var c=a.indexOf("#");return-1===c?b:(c>0&&(a=a.substr(c)),b+a)}function h(a){return b('<span class="lity-error"/>').append(a)}function i(a,c){var d=c.opener()&&c.opener().data("lity-desc")||"Image with no description",e=b('<img src="'+a+'" alt="'+d+'"/>'),f=B(),g=function(){f.reject(h("Failed loading image"))};return e.on("load",function(){if(0===this.naturalWidth)return g();f.resolve(e)}).on("error",g),f.promise()}function j(a,c){var d,e,f;try{d=b(a)}catch(a){return!1}return!!d.length&&(e=b('<i style="display:none !important"/>'),f=d.hasClass("lity-hide"),c.element().one("lity:remove",function(){e.before(d).remove(),f&&!d.closest(".lity-content").length&&d.addClass("lity-hide")}),d.removeClass("lity-hide").after(e))}function k(a){var c=J.exec(a);return!!c&&o(g(a,f("https://www.youtube"+(c[2]||"")+".com/embed/"+c[4],b.extend({autoplay:1},e(c[5]||"")))))}function l(a){var c=K.exec(a);return!!c&&o(g(a,f("https://player.vimeo.com/video/"+c[3],b.extend({autoplay:1},e(c[4]||"")))))}function m(a){var c=M.exec(a);return!!c&&(0!==a.indexOf("http")&&(a="https:"+a),o(g(a,f("https://www.facebook.com/plugins/video.php?href="+a,b.extend({autoplay:1},e(c[4]||""))))))}function n(a){var b=L.exec(a);return!!b&&o(g(a,f("https://www.google."+b[3]+"/maps?"+b[6],{output:b[6].indexOf("layer=c")>0?"svembed":"embed"})))}function o(a){return'<div class="lity-iframe-container"><iframe frameborder="0" allowfullscreen src="'+a+'"/></div>'}function p(){return z.documentElement.clientHeight?z.documentElement.clientHeight:Math.round(A.height())}function q(a){var b=v();b&&(27===a.keyCode&&b.options("esc")&&b.close(),9===a.keyCode&&r(a,b))}function r(a,b){var c=b.element().find(G),d=c.index(z.activeElement);a.shiftKey&&d<=0?(c.get(c.length-1).focus(),a.preventDefault()):a.shiftKey||d!==c.length-1||(c.get(0).focus(),a.preventDefault())}function s(){b.each(D,function(a,b){b.resize()})}function t(a){1===D.unshift(a)&&(C.addClass("lity-active"),A.on({resize:s,keydown:q})),b("body > *").not(a.element()).addClass("lity-hidden").each(function(){var a=b(this);void 0===a.data(F)&&a.data(F,a.attr(E)||null)}).attr(E,"true")}function u(a){var c;a.element().attr(E,"true"),1===D.length&&(C.removeClass("lity-active"),A.off({resize:s,keydown:q})),D=b.grep(D,function(b){return a!==b}),c=D.length?D[0].element():b(".lity-hidden"),c.removeClass("lity-hidden").each(function(){var a=b(this),c=a.data(F);c?a.attr(E,c):a.removeAttr(E),a.removeData(F)})}function v(){return 0===D.length?null:D[0]}function w(a,c,d,e){var f,g="inline",h=b.extend({},d);return e&&h[e]?(f=h[e](a,c),g=e):(b.each(["inline","iframe"],function(a,b){delete h[b],h[b]=d[b]}),b.each(h,function(b,d){return!d||(!(!d.test||d.test(a,c))||(f=d(a,c),!1!==f?(g=b,!1):void 0))})),{handler:g,content:f||""}}function x(a,e,f,g){function h(a){k=b(a).css("max-height",p()+"px"),j.find(".lity-loader").each(function(){var a=b(this);c(a).always(function(){a.remove()})}),j.removeClass("lity-loading").find(".lity-content").empty().append(k),m=!0,k.trigger("lity:ready",[l])}var i,j,k,l=this,m=!1,n=!1;e=b.extend({},H,e),j=b(e.template),l.element=function(){return j},l.opener=function(){return f},l.options=b.proxy(d,l,e),l.handlers=b.proxy(d,l,e.handlers),l.resize=function(){m&&!n&&k.css("max-height",p()+"px").trigger("lity:resize",[l])},l.close=function(){if(m&&!n){n=!0,u(l);var a=B();if(g&&(z.activeElement===j[0]||b.contains(j[0],z.activeElement)))try{g.focus()}catch(a){}return k.trigger("lity:close",[l]),j.removeClass("lity-opened").addClass("lity-closed"),c(k.add(j)).always(function(){k.trigger("lity:remove",[l]),j.remove(),j=void 0,a.resolve()}),a.promise()}},i=w(a,l,e.handlers,e.handler),j.attr(E,"false").addClass("lity-loading lity-opened lity-"+i.handler).appendTo("body").focus().on("click","[data-lity-close]",function(a){b(a.target).is("[data-lity-close]")&&l.close()}).trigger("lity:open",[l]),t(l),b.when(i.content).always(h)}function y(a,c,d){a.preventDefault?(a.preventDefault(),d=b(this),a=d.data("lity-target")||d.attr("href")||d.attr("src")):d=b(d);var e=new x(a,b.extend({},d.data("lity-options")||d.data("lity"),c),d,z.activeElement);if(!a.preventDefault)return e}var z=a.document,A=b(a),B=b.Deferred,C=b("html"),D=[],E="aria-hidden",F="lity-"+E,G='a[href],area[href],input:not([disabled]),select:not([disabled]),textarea:not([disabled]),button:not([disabled]),iframe,object,embed,[contenteditable],[tabindex]:not([tabindex^="-"])',H={esc:!0,handler:null,handlers:{image:i,inline:j,youtube:k,vimeo:l,googlemaps:n,facebookvideo:m,iframe:o},template:'<div class="lity" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1"><div class="lity-wrap" data-lity-close role="document"><div class="lity-loader" aria-hidden="true">Loading...</div><div class="lity-container"><div class="lity-content"></div><button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>&times;</button></div></div></div>'},I=/(^data:image\/)|(\.(png|jpe?g|gif|svg|webp|bmp|ico|tiff?)(\?\S*)?$)/i,J=/(youtube(-nocookie)?\.com|youtu\.be)\/(watch\?v=|v\/|u\/|embed\/?)?([\w-]{11})(.*)?/i,K=/(vimeo(pro)?.com)\/(?:[^\d]+)?(\d+)\??(.*)?$/,L=/((maps|www)\.)?google\.([^\/\?]+)\/?((maps\/?)?\?)(.*)/i,M=/(facebook\.com)\/([a-z0-9_-]*)\/videos\/([0-9]*)(.*)?$/i,N=function(){var a=z.createElement("div"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return b[c];return!1}();return i.test=function(a){return I.test(a)},y.version="2.3.1",y.options=b.proxy(d,y,H),y.handlers=b.proxy(d,y,H.handlers),y.current=v,b(z).on("click.lity","[data-lity]",y),y});


/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

;(function( $ ){

  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'object',
        'embed'
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('name')){
          var videoName = 'fitvid' + $.fn.fitVids._count;
          $this.attr('name', videoName);
          $.fn.fitVids._count++;
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
  
  // Internal counter for unique video names.
  $.fn.fitVids._count = 0;
  
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );


// append csrf token to all ajax calls
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var path = window.location.href.split( '/' );
console.log(path);

if (path[3] != '' && path[3]!='admin' && $( window ).width() > 680)
{
  scrollTo('#grid');
}

// scrolTo smooth 
function scrollTo(element){
  if($(element).length){
  $('html,body').scrollTop($(element).offset().top);  
  }
}

window.onpopstate = function(event) {
    if(event && event.state) {
        location.reload()
    }
}

$('.ui.checkbox').checkbox();

$('#header .account.item').popup({
	popup : $('#auth_popup'),
	on    : 'click'
});

$('.ui.accordion').accordion({
  exclusive: false
}); 


$('#filterbar .ui.accordion').accordion({
  exclusive: false,
    selector    : {
    accordion : '.accordion',
    title     : '.title',
    trigger   : '.title i',
    content   : '.content'
  }
}); 

$('.register_form').click(function(){
	$popup = $('#auth_popup');
	$email = $('#register_div').find('input[name="email"]').val();
	$password = $('#register_div').find('input[name="password"]').val();


})


$('.login_form').submit(function(){
	$validation = 1;

  $popup = $('#auth_popup');
  $email = $('#login_div').find('input[name="email"]').val();
	$password = $('#login_div').find('input[name="password"]').val();

  if ($validation==1){
    return true
  } else {
    return false;
  }


});

$('.add_category_btn').click(function(){
	$('#add_category_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
    	$name = $('#add_category_input').val();
      $parent_id = $('input[name="parent_id"]').val();

    	$.ajax({
    		type: "POST",
    		url: "/category/",
    		data: {name: $name, parent_id:$parent_id},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})


$('#create_product_add_param_row').click(function(){
  $html = $('#create_product_params .row:first-child').html();
  $('#create_product_params').append('<div class="row">'+$html+'</div>');
  $('.ui.dropdown').dropdown();
})

$('#edit_product_add_param_row').click(function(){
  $html = $('#param_template .row').html();
  $('#edit_product_params').append('<div class="row">'+$html+'</div>');
  $('.ui.dropdown').dropdown();
})

$('#create_product_categories_input').dropdown({
  maxSelections: 1,
  onAdd: function(addedValue, addedText, $addedChoice){
    console.log(addedValue);
  }
})


$('#edit_product_categories_input').dropdown({
  maxSelections: 10,
  onAdd: function(addedValue, addedText, $addedChoice){
    console.log(addedValue);
  }
})

$('#create_product_form').submit(function(e){
  $validation = 1;

  $name = $('#product_detail input[name="name"]').val();
  $code = $('#product_detail input[name="code"]').val();
  $maker = $('#product_detail input[name="maker"]').val();
  $threshold = $('#product_detail input[name^="thresholds"]').val();
  $moc = $('#product_detail input[name^="mocs"]').val();
  $mocs = $('#product_detail input[name^="moc_sales"]').val();
  $voc = $('#product_detail input[name^="vocs"]').val();
  $vocs = $('#product_detail input[name^="voc_sales"]').val();

  if ($name=='') {$validation=0; $('#product_detail input[name="name"]').parent().addClass('error');}
  if ($code=='') {$validation=0; $('#product_detail input[name="code"]').parent().addClass('error');}
  if ($maker=='') {$validation=0; $('#product_detail input[name="maker"]').parent().addClass('error');}
  if ($threshold=='') {$validation=0; $('#product_detail input[name^="thresholds"]').parent().addClass('error');}
  if ($moc=='') {$validation=0; $('#product_detail input[name^="moc"]').parent().addClass('error');}
  if ($mocs=='') {$validation=0; $('#product_detail input[name^="mocs"]').parent().addClass('error');}
  if ($voc=='') {$validation=0; $('#product_detail input[name^="voc"]').parent().addClass('error');}
  if ($vocs=='') {$validation=0; $('#product_detail input[name^="vocs"]').parent().addClass('error');}

 if ($validation==1)
 {
    return true
  }

  return false;
})



$('#edit_category_submit').click(function(){
  $categoryid = $(this).data('categoryid');
  $name = $('#edit_product_name_input input').val()
  $url = $('#edit_product_url_input input').val()

    $.ajax({
      method: "PUT",
      url: "/category/"+$categoryid,
      data: {name: $name, url: $url},
      success: function(data){
        location.reload();
      } 
    })
});

$('.other_img img').click(function(){
  $('#product_detail .img img').attr('src', $(this).attr('src'));
})



function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 5;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top+80 + "px", left: $(flyer).offset().left+100 + "px", opacity: 1, 'z-index': 1000});
    $('body').append($(flyerClone));
    $(flyerClone).width('350');
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;
     
    $(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY,
        width: $(flyer).width()/divider,
        height: $(flyer).height()/divider
    }, 700,
    function () {
        $(flyingTo).fadeOut('fast', function () {
            $(flyingTo).fadeIn('fast', function () {
                $(flyerClone).fadeOut('fast', function () {
                    $(flyerClone).remove();
                });
            });
        });
    });
}


function addToCart(productid, qty){
  var cart = $('#header .cart.item');
  var price = parseFloat(cart.find('price number').text());
  var cartid = $('.content.cart').data('cartid');

  $.ajax({
    method: "POST",
    url: '/cart/'+cartid+"/"+productid,
    data: {qty: qty},
    global: false,
    success: function(data){
      cart.find('text number').text(data.count);
      cart.find('price number').text(parseFloat(price+parseFloat(data.price)).toFixed(2));
    }
  })
}


$('#product_detail_tocart_btn').click(function(){
  $product = $('#product_detail').data('id');
  $qty = $(this).data('qty');

  var cart = $('#header .cart.item');
  var img = $('#product_detail').find('.img');
  flyToElement(img, cart);
  
  addToCart($product, $qty);

})


$(document).on('click', 'grid .to_cart',function(){
  $product = $(this).closest('.product').data('productid');
  var cart = $('#header .cart.item');
  var img = $(this).closest('.product').find('.image_div');
  $qty = $(this).closest('.product').data('minqty');

  flyToElement(img, cart);
  
  addToCart($product, $qty);

})

$(document).on('click','.delete_cart', function(){
    $('#delete_cart_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/cart/all",
        data: {},
        success: function(){
          location.replace('/cart/products');
        }
      })
    }
  }).modal('show');
})


$('.cart_delete_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $cartid = $('.cart.content').data('cartid');

  $.ajax({
    type: "DELETE",
    url: "/cart/"+$cartid+"/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

$('.cart_plus_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $.ajax({
    type: "POST",
    url: "/cart/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

$('.cart_minus_product').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $.ajax({
    type: "PUT",
    url: "/cart/"+$productid,
    data: {},
    success: function(){
      location.reload();
    }
  })
})

///// Sorting and filtering ////////

function getActiveFilters(){
  
  $filters={};
  $filters['parameters'] = {};

  $('#active_filters span').each(function(index, element){
    var group = $(element).data('group');
    var filter = $(element).data('filter');

    if ($(element).data('group'))
    {

      $filters[group][filter] = [];
    }
    else
    {
      $filters[$(element).data('filter')]={};
    }
  });

  console.log($filters);

  $('#active_filters span').each(function(index, element) {
      var group = $(element).data('group');
      var filter = $(element).data('filter');
      if (group!=null)
      {
        $filters[group][filter].push($(element).data('value'));
      }
      else
      {
        $filters[filter] = $(element).data('value');
      }
    });

  return $filters;
}

function getActiveCategory(){
  return $('.categories .item.selected').data('categoryid');
}

function getDesiredSortBy(){
  return $('.sort.active').data('sortby');
}

function getDesiredSortOrder(){
  return $('.sort.active').data('sortorder');
}

function initPriceSlider(){

    var checkExists = $('#price_slider').length;

    var window_width = $(window).width();
    
    if (window_width < 770){
      $pipsCount = 5;
      $decimals = 1;
    } else {
      $pipsCount = 10;
      $decimals = 2;
    }

    if (checkExists)
    {

      if ($('#price_slider')[0].noUiSlider)
      {
        $('#price_slider')[0].noUiSlider.destroy();
      }

      var priceSlider = document.getElementById('price_slider');

      if ($('#grid_stats').data('maxprice'))
      {
        $max = $('#grid_stats').data('maxprice')
      }
      else
      {
        $max = 1;
      }

      noUiSlider.create(priceSlider, {
        start: [ getPriceFilter('price')[0], getPriceFilter('price')[1]],
        connect: true,
        range: {
          'min': 0,
          'max': $max
        },
        pips: { 
          mode: 'count', 
          density: 1,
          values: $pipsCount,
          format: wNumb({
            decimals: $decimals,
            postfix: '€'
          })
        }
      });

      priceSlider.noUiSlider.on('set', function()
      {
        $min = priceSlider.noUiSlider.get()[0];
        $max = priceSlider.noUiSlider.get()[1];

        removeFilter('price');
        addFilter('price',  priceSlider.noUiSlider.get(), 'Cena medzi: '+$min+' a '+$max);
        doSort();
      });

    }
}

initPriceSlider();
filtersInit();

function doSort(){

  //console.log(getPriceFilter('price'));

  $grid = $('#grid').find('grid');
  $filtersDiv = $('#filterbar').find('.params');

  $sortBy = getDesiredSortBy();
  $sortOrder = getDesiredSortOrder();


  $filters = getActiveFilters();
  $categoryid = getActiveCategory();

 if($('#routename').text()=='maker.products')
 {
	$.get('/makerproduct/list',{category: $categoryid, sortBy: $sortBy, sortOrder: $sortOrder, filters: $filters}, function(data){
	    $grid.html(data.products);
		

	    $filtersDiv.html(data.filters);
	    filtersInit();
	    $('#grid').find('.dimmer').removeClass('active');
	    $('#grid').show();
	    $('.sorts').show();
	    $('#price_slider').show();
	    
	    initPriceSlider();
	    
	   
	  })
 }
 else
 {
  $.get('/product/list',{category: $categoryid, sortBy: $sortBy, sortOrder: $sortOrder, filters: $filters}, function(data){
    $grid.html(data.products);
	

    $filtersDiv.html(data.filters);
    filtersInit();
    $('#grid').find('.dimmer').removeClass('active');
    $('#grid').show();
    $('.sorts').show();
    $('#price_slider').show();
    
    initPriceSlider();
    
   
  })
 }
};

function addFilter(key, value, desc, group=null){
  $('#active_filters').append('<span data-value="'+value+'" data-filter="'+key+'" data-group="'+group+'" class="'+key+' ui large teal label">'+desc+'<i class="delete icon"></i></span>');
}

function getPriceFilter(key){
  $div = $('#active_filters').find('span[data-filter="'+key+'"]')

  if ($div.length){
    $array = $div.data('value').split(',');
    return $array;
  }else{
    return [0,$('#grid_stats').data('maxprice')];
  }
}


function removeFilter(key, value=''){
  if(value=='')
  {
    $('#active_filters').find('span[data-filter="'+key+'"]').remove();
  }
  else
  {
    $('#active_filters').find('span[data-value="'+value+'"][data-filter="'+key+'"]').remove();
  }
}


$('.sort').click(function(){
  if ($(this).hasClass('active'))
  {
    if ($(this).data('sortorder')=='asc')
    {
      $(this).data('sortorder','desc');
      $(this).find('i').removeClass('ascending').addClass('descending');
    }
    else
    {
      $(this).data('sortorder','asc');
      $(this).find('i').removeClass('descending').addClass('ascending');
    }
  }
  else
  {
    $('.sort').removeClass('active');
    $(this).addClass('active');
  }
  doSort();
})

function filtersInit(){
  $('#filterbar  .ui.checkbox').checkbox({
    onChecked: function(){
      $value = $(this).closest('.checkbox').data('value');
      $text = $(this).closest('.checkbox').find('label').text();
      $filter = $(this).closest('.checkbox').data('filter');
      $display = $(this).closest('.checkbox').data('display');

      addFilter($filter, $value, $display+': '+ $text, 'parameters')
      doSort();
    },
    onUnchecked: function(){
      $value = $(this).closest('.checkbox').data('value');
      $text = $(this).closest('.checkbox').find('label').text();
      $filter = $(this).closest('.checkbox').data('filter');
      $display = $(this).closest('.checkbox').data('display');

      removeFilter($filter,$value);
      doSort();
    }
  })
}



$('.categories .item .icon.plus').click(function(e){
  $(this).toggleClass('minus plus');
})

$('.categories .item .icon.minus').click(function(e){
  $(this).toggleClass('minus plus');
})



$('#cart_delivery_options .step').click(function(){
  $('#cart_delivery_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
  $delivery_method_id = $(this).data('delivery_method');

  $('#cart_payment_options .step').each(function(index, element){
    $(element).removeClass('disabled completed active');
    if ($.inArray($delivery_method_id, $(element).data('delivery_methods'))==-1)
    {
      $(element).addClass('disabled');
    }
  });

  if ($('#cart_payment_options .step.completed').length > 0)
  {
    $('.cart_next').removeClass('disabled');
  }
   else
  {
    $('.cart_next').addClass('disabled');
  }
})

$('#cart_payment_options .step').click(function(){
  $('#cart_payment_options .step').removeClass('completed').removeClass('active');
  $(this).addClass('completed active');
  if ($('#cart_delivery_options .step.completed').length > 0)
  {
    $('.cart_next').removeClass('disabled');
  }
  else
  {
    $('.cart_next').addClass('disabled');
  }
})

$('#view_goods_btn').click(function(){
  scrollTo('#home_content');
})

$('#login_password_input').keypress(function(e){
  if(e.which == 13) {
        $('#login_form').submit();
    }
});

$('#register_password_input').keypress(function(e){
  if(e.which == 13) {
        $('#register_btn').click();
    }
});


$('#product_detail_delete_btn').click(function(){
  $productid = $('#product_detail').data('id');
  $('#delete_product_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/product/"+$productid,
        data: {},
        success: function(){
          location.replace('/admin/products');
        }
      })
    }
  }).modal('show');
})

$('.admin_delete_category_btn').click(function(){
  $categoryid = $(this).closest('.category').data('id');
  $('#delete_category_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/category/"+$categoryid,
        data: {},
        success: function(){
          location.replace('/admin/products');
        }
      })
    }
  }).modal('show');
})

$('.product_row_delete_btn').click(function(){
  $productid = $(this).closest('.product').data('productid');
  $('#delete_product_modal').modal('setting', {
    onApprove : function() {
      $.ajax({
        type: "DELETE",
        url: "/product/"+$productid,
        data: {},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})



$(document).ajaxStart(function() {
  $('#grid').find('.dimmer').addClass('active');
});

function doSearch($query){

  //console.log(getPriceFilter('price'));
  
  $grid = $('#grid');
  $searchGrid = $('#search_grid');
  $filtersDiv = $('#filterbar').find('.params');

  $sortBy = getDesiredSortBy();
  $sortOrder = getDesiredSortOrder();


  $.get('/product/search/'+$query, function(data){
  	$grid.hide();
  	$filtersDiv.hide();

    $searchGrid.show();
    $searchGrid.find('grid').html(data);
  	$searchGrid.find('.dimmer').removeClass('active');

    $filtersDiv.html(data.filters);
    filtersInit();
    $('#grid').find('.dimmer').removeClass('active');
    $('.sorts').show();
    $('#price_slider').show();
    
    initPriceSlider();
    
   
  })
};

var timeout = null;

$(".product_search_input input").keyup(function(e){
    clearTimeout(timeout);
  	$query = $(this).val();

  if ($query!='') 
  {

   	timeout = setTimeout(function() {
   		 $('#search_grid').find('.dimmer').addClass('active');
    	addFilter('search',$query,'hľadaj: '+$query);
	    doSearch($query);
    }, 550);


  }
  else
  {
    removeFilter('search');
    $('#grid').show();
    $('#search_grid').hide();
  	$('#filterbar').find('.params').show();

  };


})


$('#settings_submit_btn').click(function(){
  $validation = 1;

  $userid = $('#settings_user').data('userid');

  $container = $('#settings_user').find('#right');

  $data = {
    first_name: $container.find('input[name="first_name"]').val(),
    last_name: $container.find('input[name="last_name"]').val(),
    phone: $container.find('input[name="phone"]').val(),
    invoiceAddress: {
      street: $container.find('input[name="invoice_address_street"]').val(),
      zip: $container.find('input[name="invoice_address_zip"]').val(),
      city: $container.find('input[name="invoice_address_city"]').val(),
    },
    deliveryAddress: {
      name: $container.find('input[name="delivery_address_name"]').val(),
      street: $container.find('input[name="delivery_address_street"]').val(),
      city: $container.find('input[name="delivery_address_city"]').val(),
      zip: $container.find('input[name="delivery_address_zip"]').val(),
      additional: $container.find('input[name="delivery_address_additional"]').val(),
      phone: $container.find('input[name="delivery_address_phone"]').val(),
    },
  };

  /*
  if ($data.invoiceAddress.street && (!$data.invoiceAddress.zip || !$data.invoiceAddress.city))
  {
    $validation = 0;
    $container.find('input[name="invoice_address_zip"]').closest('.input').addClass('error');
    $container.find('input[name="invoice_address_city"]').closest('.input').addClass('error');
  }

  if ($data.invoiceAddress.zip && (!$data.invoiceAddress.street || !$data.invoiceAddress.city))
  {
    $validation = 0;
    $container.find('input[name="invoice_address_street"]').closest('.input').addClass('error');
    $container.find('input[name="invoice_address_city"]').closest('.input').addClass('error');
  }

  if ($data.invoiceAddress.city && (!$data.invoiceAddress.zip || !$data.invoiceAddress.street))
  {
    $validation = 0;
    $container.find('input[name="invoice_address_zip"]').closest('.input').addClass('error');
    $container.find('input[name="invoice_address_street"]').closest('.input').addClass('error');
  }

  */
  
  $deliveryInputsLength = $('.delivery_address.inputs .input').length;
  $deliveryAddressEmpty = [];

  $('.delivery_address.inputs .input input').each(function(index, element){
    if ($(element).val()=='')
    {
      $deliveryAddressEmpty.push($(element).attr('name'));
    }
  })

  if ($deliveryInputsLength != $deliveryAddressEmpty.length){
    $.each($deliveryAddressEmpty, function(i, item) {
      $('input[name="'+item+'"]').closest('.input').addClass('error');
      $validation = 0;
    });
  }

  $data.invoiceAddress = JSON.stringify($data.invoiceAddress);
  $data.deliveryAddress = JSON.stringify($data.deliveryAddress);

  if ($validation)
  {
    $.ajax({
      method: "PUT",
      url: '/user/'+$userid,
      data: $data,
      success: function(data){
        location.reload();
        //console.log(data)
      }
    })
  } 
})

$(".cart_delivery").click(function(){
  $delivery = $(this).data('delivery_method');

  $.ajax({
    method: "POST",
    url: '/cart',
    data: {delivery_method: $delivery}
  })
})

$(".cart_payment").click(function(){
  $payment = $(this).data('payment_method');

  $.ajax({
    method: "POST",
    url: '/cart',
    data: {payment_method: $payment}
  })
})

$('#use_delivery_address_input').checkbox({
  onChecked: function(){
    $('.cart_address .delivery').fadeIn();

    $.ajax({
      method: "POST",
      url: '/cart',
      data: {delivery_address_flag: 1}
    })

  },
  onUnchecked: function(){
    $('.cart_address .delivery').fadeOut();

    $.ajax({
      method: "POST",
      url: '/cart',
      data: {delivery_address_flag: 0}
    })
  },
})


$('#cart_shipping_next_btn').click(function(e){
    $validation = 1;

    $invoiceAddress = {};
    $deliveryAddress = {};
    $button = $(this);
    $button.addClass('loading');
    
    $invoiceAddressInputs = $('.cart_address').find('.invoice').find('.input');
    $invoiceAddressInputs.each(function(index, item){
      $type = $(item).data('column');
      $invoiceAddress[$type] = $(item).find('input').val();
      if ($(item).find('input').val() == '')
      {
        $validation = 0;
        $(item).addClass('error');
      }
    })

    $deliveryAdressFlag = $('#use_delivery_address_input').checkbox('is checked');
    
    if ($deliveryAdressFlag)
    {
      $deliveryAddressInputs = $('.cart_address').find('.delivery').find('.input');
      $deliveryAddressInputs.each(function(index, item){
        $type = $(item).data('column');
        $deliveryAddress[$type] = $(item).find('input').val();
        if ($(item).find('input').val() == '')
        {
          $validation = 0;
          $(item).addClass('error');
        }
      })
    }


    console.log($validation);

    

    if ($validation)
    { 
      $.ajax({
        method: "POST",
        url: '/cart',
        data: {invoice_address: JSON.stringify($invoiceAddress), delivery_address: JSON.stringify($deliveryAddress)}
      });

      e.preventDefault();
      setTimeout(function(){
          $.get($(this).attr('href'),{}, function(){
          location.replace($button.attr('href'));
        })
      },1000);
    }
    else{
      e.preventDefault();
      $button.removeClass('loading');
    }

})


$('#submit_order_btn').click(function(){
  $button = $(this);
  $button.addClass('loading');
  $.ajax({
    method: 'POST',
    url: '/order',
    success: function(){
      location.replace("/order/success");
    }
  })

})


$('#admin #grid .product.item').draggable({ 
  opacity: 0.6, 
  helper: "clone"
});

$('.categories .item').droppable({
  tolerance: "pointer",
  accept: ".product",
  over: function( event, ui ) {
    $(this).addClass('active');
  },
  out: function( event, ui ) {
    $(this).removeClass('active');
  },
  deactivate: function( event, ui ) {
    $(this).removeClass('active');
  },
  drop: function( event, ui ) {
    $categoryId = $(this).data('categoryid');
    $product = $(ui.draggable);

    $.post('/product/'+$product.data('productid')+'/change/category/'+$categoryId,{},function(){
          $product.remove();
    });

    $(this).removeClass('active');
  }

});


$(document).on('click', '.admin_delete_user_btn', function(){
  $userid = $(this).closest('.user').data('userid');
  $.ajax({
    method: "DELETE",
    url: '/user/'+$userid,
    success: function(){
      location.reload();
    }
  })
});



$('.admin_admin_checkbox').checkbox({
  onChecked: function(){

    $userid = $(this).closest('.user').data('userid');

    $.ajax({
      method: "PUT",
      url: '/user/'+$userid,
      data: {admin: 1}
    })

  },
  onUnchecked: function(){

    $userid = $(this).closest('.user').data('userid');

    $.ajax({
      method: "PUT",
      url: '/user/'+$userid,
      data: {admin: 0}
    })
  },
})


$('.delete_img').click(function(){
  $image = $(this).closest('.image_div');
  $imageid = $image.data('fileid');

   $.ajax({
    method: "DELETE",
    url: '/file/'+$imageid,
    data: {},
    success: function(){
      $image.remove();
    }
  })
})


$('.make_primary_img').click(function(){
  $image = $(this).closest('.image_div');
  $imageid = $image.data('fileid');

   $.ajax({
    method: "PUT",
    url: '/file/'+$imageid,
    data: {primary:1},
    success: function(){
      $('.image_div').removeClass('primary');
     $image.addClass('primary');
    }
  })
})

// callback for clicking the active filter delete icon
$("#active_filters").on('click','span .delete', function () {
    $filter = $(this).parent().data('filter');
    $value = $(this).parent().data('value');
    $(this).parent().remove();
    $('.filter[data-filter="'+$filter+'"][data-value="'+$value+'"]').removeClass('active');
    doSort();
});


$("#sidebar_handle").click(function(){
  $('#sidebar').sidebar('toggle');
})

$("#catbar_handle").click(function(){
  $('#catbar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
})

$("#parambarbar_handle").click(function(){
  $('#parambar').sidebar('toggle');
})

$('.close_btn').click(function(){
  $('.ui.sidebar').sidebar('hide');
})

$('#home_sales_div').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false,
    prevNextButtons: false,
    imagesLoaded: true
});

$('#home_news_div').flickity({
    cellAlign: 'left',
    contain: true,
    pageDots: false,
    prevNextButtons: false,
    imagesLoaded: true
});

$('#admin_add_category_param_btn').click(function(){
  $html = $('#admin_filters_div .row:first-child').clone();
  $('#admin_filters_div').append($html);
})

$('#product_detail_dropzone').dropzone({
    params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#import_dropzone').dropzone({
    success: function(param, data){
      $table = $('#admin_import_results').find('table');
      $row = $table.find('tbody tr');
      $.each(data, function(index,item){
        $lastRow = $table.find('tbody tr:last-child');
        $lastRow.find('td[col="name"]').html(item['name']);
        $lastRow.find('td[col="code"]').html(item['code']);
        $lastRow.find('td[col="maker"]').html(item['maker']);

        console.log(item);

        $row.clone().appendTo($table);

      })

      //delete the duplicate last row
      $table.find('tbody tr:last-child').remove();
    },
    params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    }
})


$('#filterbar .tabs .category.tab').click(function(){
  $('#cat_div').show();
  $('#filterbar .tabs .tab').removeClass('active');
  $(this).addClass('active');
})


$('#filterbar .tabs .param.tab:not(".disabled")').click(function(){
    $('#cat_div').hide();
      $('#filterbar .tabs .tab').removeClass('active');
  $(this).addClass('active');
})

$('.ui.dropdown').dropdown({
  allowCategorySelection: true
});

$('#category_image_dropzone').dropzone({
  success: function(file, response){
    
    this.removeAllFiles(true);
    $categoryid = $('#category_image_div').data('categoryid');

    $.ajax({
      method: "POST",
      url: '/category/'+$categoryid+'/image/confirmCrop',
      data: {filename: file.name},
      success: function(){
        location.reload();
      }
    })

  } 
});

$('.covers').flickity({
  autoPlay: 4000,
  adaptiveHeight: true
});


$('.admin_wrapper .categories').nestedSortable({
  handle: 'div',
  items: 'li',
  toleranceElement: '> div',
  listType: 'ul',
  disableParentChange: false,
  stop: function(event, ui){
    $data = [];
    $orders = {};
    $parents = {};

    $('.admin_wrapper .categories .category.item').each(function(index, item){
      $orders[$(item).data('categoryid')] = index;
      $parents[$(item).data('categoryid')] = $(item).closest('li').parent().closest('li').data('categoryid');
    });
    //console.log($(ui.item).closest('li').parent().closest('li').data('categoryid'));

    $.ajax({
      method: "PUT",
      url: '/categories/setorder',
      data: {'orders':$orders, 'parents': $parents}
    })
  }
});

$('.tabs .tab').click(function(){
  $('.tabs .tab').removeClass('brown').addClass('basic');
  $(this).addClass('brown').removeClass('basic')
  $('.tabs .content').removeClass('active');
  $('.tabs .content[data-tab="'+$(this).data("tab")+'"]').addClass('active');
})

$('.my.rating').rateYo({
  rating: $('#myrating').data('rating')
})

$('.rating:not(.disabled)').rateYo().on("rateyo.set", function(e, data){

      $('#new_rating_modal').modal('setting', {
        autofocus: true,
        onApprove : function() {
          $text = $('#new_rating_modal textarea').val();
          $id = $('#product_detail').data('id');
          $.ajax({
            type: "POST",
            url: "/product/"+$id+"/rating",
            data: {value: data.rating, text: $text},
            success: function(){
              location.reload();
            }
          })
        }
        }).modal('show');
    });


$('.disabled.rating').rateYo({
  readOnly: true,
})




$('.disabled.rating').each(function(index, item){
  //console.log($(item).data('rating'));
  $(item).rateYo('rating', $(item).data('rating'));
})


$('.dashboard_tabs .new.tab').click(function(){
  $('.dashboard_tabs .overall.tab').removeClass('blue').addClass('basic');
  $(this).addClass('blue').removeClass('basic');
  $('.admin_dashboard .new.boxes').removeClass('hidden');
  $('.admin_dashboard .overall.boxes').addClass('hidden');
});


$('.dashboard_tabs .overall.tab').click(function(){
  $('.dashboard_tabs .new.tab').removeClass('blue').addClass('basic');
  $(this).addClass('blue').removeClass('basic');
  $('.admin_dashboard .new.boxes').addClass('hidden');
  $('.admin_dashboard .overall.boxes').removeClass('hidden');
});


$('.add_delivery_method_btn').click(function(){
    $('#add_delivery_method_modal').modal('setting', {
    onApprove : function() {
      $name = $('#add_delivery_method_name_input').val();
      $desc = $('#add_delivery_method_desc_input').val();
      $icon = $('#add_delivery_method_modal').find('.ui.dropdown').dropdown('get value');

      $.ajax({
        type: "POST",
        url: "/admin/delivery/",
        data: {name: $name, desc:$desc, icon: $icon},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})



$('.add_payment_method_btn').click(function(){
    $('#add_payment_method_modal').modal('setting', {
    onApprove : function() {
      $name = $('#add_payment_method_name_input').val();
      $desc = $('#add_payment_method_desc_input').val();
      $icon = $('#add_payment_method_modal').find('.ui.dropdown').dropdown('get value');
      
      $.ajax({
        type: "POST",
        url: "/admin/payment/",
        data: {name: $name, desc:$desc, icon: $icon},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})




$(document).on('click','.admin_method_list i.action', function(){
  $row = $(this).closest('tr');
  $type = $(this).closest('tbody').data('type');
  $id = $row.data('id');
  $this = $(this);
  $key = $row.find('td:first-child').text();
  $name = $row.find('td:nth-child(2)').text();
  $desc = $row.find('td:nth-child(3)').text();
  $icon = $row.find('.ui.dropdown').dropdown('get value');


  if ($(this).hasClass('edit'))
  {
      $row.find('i.red').css('display','inline-block');
      $(this).toggleClass('edit check square green');

      $row.find('td:not(:last-child):not(:nth-child(4))').prop('contenteditable',true).addClass('editable');
      $row.find('.ui.dropdown').show();
      $row.find('td:nth-child(4)>i.icon').hide();
  }
  else
  {
      $.ajax({
        type: "PUT",
        url: "/admin/"+$type+"/"+$id,
        data: {name:$name, key: $key, desc:$desc, icon: $icon},
        success: function(){
            $this.toggleClass('edit check square green');
            isEditable=$row.is('.editable');
            $row.find('td:not(:last-child)').prop('contenteditable',false).removeClass('editable');
            $row.find('i.red').hide();
            $row.find('.ui.dropdown').hide();
            $row.find('td:nth-child(4)>i.icon').attr('class','').addClass('big icon '+$icon).show();
        }
      })
  };
})

$('.admin_method_list i.red').click(function(){
  $(this).hide();
  $row = $(this).closest('tr');
  $row.find('td:not(:last-child)').prop('contenteditable',false).removeClass('editable');
  $('.admin_method_list i.green.square.check').toggleClass('green square check edit');
              $row.find('.ui.dropdown').hide();
            $row.find('td:nth-child(4)>i.icon').show();
})



$('.tabbs .tabb').click(function(){
  $('.tabbs .tabb').removeClass('blue selected').addClass('basic');
  $(this).addClass('blue selected').removeClass('basic')
  $('.tabbs .contents .content').removeClass('active');
  $('.tabbs .contents .content[data-tab="'+$(this).data("tab")+'"]').addClass('active');
})



$('.delivery_payment_checkbox').checkbox({
  onChecked: function(){
    $delivery_method_id = $(this).closest('tr').data('delivery_method_id');
    $payment_method_id = $(this).closest('tr').data('payment_method_id');

    $.ajax({
      method: 'POST',
      url: '/admin/deliverypayment',
      data: {delivery_method_id: $delivery_method_id, payment_method_id: $payment_method_id}
    })
  },
  onUnchecked: function(){
    $delivery_method_id = $(this).closest('tr').data('delivery_method_id');
    $payment_method_id = $(this).closest('tr').data('payment_method_id');

    $.ajax({
      method: 'DELETE',
      url: '/admin/deliverypayment',
      data: {delivery_method_id: $delivery_method_id, payment_method_id: $payment_method_id}
    })
  }
})

$('input.delivery_price').keyup(function(){
    $delivery_method_id = $(this).closest('tr').data('delivery_method_id');
    $payment_method_id = $(this).closest('tr').data('payment_method_id');
    $price = $(this).val();

    $.ajax({
      method: 'PUT',
      url: '/admin/deliverypayment',
      data: {delivery_method_id: $delivery_method_id, payment_method_id: $payment_method_id, price: $price}
    })
});




function initCoverEdit()
{
    $('.cover.editable .cover_div').resizable({
        stop: function stop() {
          $('#admin_add_cover_form input[name="width"]').val($(this).width() / $(this).parent().width() * 100);
        }
      }).draggable({
      containment: ".cover_image",
      start: function start(event, ui) {
        var left = parseInt($(this).css('left'), 10);
        left = isNaN(left) ? 0 : left;
        var top = parseInt($(this).css('top'), 10);
        top = isNaN(top) ? 0 : top;
        __recoupLeft = left - ui.position.left;
        __recoupTop = top - ui.position.top;
      },
      drag: function drag(event, ui) {
        //resize bug fix ui drag `enter code here`
        __dx = ui.position.left - ui.originalPosition.left;
        __dy = ui.position.top - ui.originalPosition.top;
        //ui.position.left = ui.originalPosition.left + ( __dx/__scale);
        //ui.position.top = ui.originalPosition.top + ( __dy/__scale );
        ui.position.left = ui.originalPosition.left + __dx;
        ui.position.top = ui.originalPosition.top + __dy;
        //
        ui.position.left += __recoupLeft;
        ui.position.top += __recoupTop;
      },
      stop: function stop() {
        var pos = {};

        $('#admin_add_cover_form input[name="left"]').val($(this).position().left / $(this).parent().width() * 100);
        $('#admin_add_cover_form input[name="top"]').val($(this).position().top / $(this).parent().height() * 100);
      }
    });

    $('.cover_div h1').css('color',$('#admin_add_cover_form input[name="h1_color"]').val());
    $('.cover_div h1').css('font-size',$('#admin_add_cover_form input[name="h1_size"]').val()+'vw');
    $('.cover_div h2').css('color',$('#admin_add_cover_form input[name="h2_color"]').val());
    $('.cover_div h2').css('font-size',$('#admin_add_cover_form input[name="h2_size"]').val()+'vw');
    $('.cover_div h1').text($('#admin_add_cover_form input[name="h1_text"]').val());
    $('.cover_div h2').text($('#admin_add_cover_form input[name="h2_text"]').val());

    $('.cover_div').css('left',$('#admin_add_cover_form input[name="left"]').val()+'%');
    $('.cover_div').css('top',$('#admin_add_cover_form input[name="top"]').val()+'%');
    $('.cover_div').css('width',$('#admin_add_cover_form input[name="width"]').val()+'%');

}

initCoverEdit();

$('#cover_dropzone').dropzone({
  clickable: ['#admin_add_cover_change_image_btn', '#cover_dropzone'],
  success: function(file, response){
    var $x, $y, $w, $h;
    this.removeAllFiles(true); 
    $('.crop_preview').html("<img src=/"+response+" />").unbind('focus');
    $('.admin_add_cover_under').css('display','flex');
    $('.cover_image').show();
    $('#cover_dropzone').hide();
    $('#admin_add_cover_form input[name="filename"]').val(file.name);
    $('#admin_add_cover_change_image_btn').hide();

    $('.crop_preview img').cropper({
      guides: false,
      viewMode: 1,
      aspectRatio: 3.3,
      autoCropArea: 1,

      crop: function(e){
        $('#admin_add_cover_form input[name="x"]').val(e.x);
        $('#admin_add_cover_form input[name="y"]').val(e.y);
        $('#admin_add_cover_form input[name="w"]').val(e.width);
        $('#admin_add_cover_form input[name="h"]').val(e.height);

        if ($('.cover_image').find('.cover_div').length == 0)
        {
         $('.cover_image .cover').append('<div class="cover_div"><h1>Nadpis</h1><h2>Text ktory sa zobrazi pod nadpisom</h2></div>');
        }

        initCoverEdit();

      },
      preview: $('.cover_image .cover')
    });


    // confirm crop
    $('.crop_ok').show().click(function(){
      $categoryid = $(this).data('categoryid');

      $.ajax({
        method: "POST",
        url: '/category/'+$categoryid+'/image/confirmCrop',
        data: {filename: file.name, x: $x, y:$y, w:$w, h:$h},
        success: function(){
          location.reload();
        }
      })
    });

  }
});


$('.admin_add_cover_h1_color_btn').spectrum({
      color:  $('#admin_add_cover_form input[name="h1_color"]').val(),
      showAlpha: true
});

$('.admin_add_cover_h2_color_btn').spectrum({
      color:  $('#admin_add_cover_form input[name="h2_color"]').val(),
      showAlpha: true

});

$(".admin_add_cover_h1_color_btn").on('move.spectrum', function(e, color) {
    $('.cover_div h1').css('color',color.toRgbString());
    $('#admin_add_cover_form input[name="h1_color"]').val(color.toRgbString());
});

$(".admin_add_cover_h2_color_btn").on('move.spectrum', function(e, color) {
    $('.cover_div h2').css('color',color.toRgbString()); 
    $('#admin_add_cover_form input[name="h2_color"]').val(color.toRgbString());
});

var h1Slider = document.getElementById('admin_add_cover_h1_size_slider');
var h2Slider = document.getElementById('admin_add_cover_h2_size_slider');

if ($('#admin_add_cover_h1_size_slider').length)
{
  noUiSlider.create(h1Slider ,{
   start: $('#admin_add_cover_form input[name="h1_size"]').val(),
      connect: true,
      range: {
        'min': 0,
        'max': 6
      },
    });

  noUiSlider.create(h2Slider ,{
   start: $('#admin_add_cover_form input[name="h2_size"]').val(),
      connect: true,
      range: {
        'min': 0,
        'max': 6
      },
    });


  h1Slider.noUiSlider.on('update', function(aa){
      $('.cover_div h1').css('font-size',aa[0]+'vw'); 
      $('#admin_add_cover_form input[name="h1_size"]').val(aa[0]);
  });


  h2Slider.noUiSlider.on('update', function(aa){
      $('.cover_div h2').css('font-size',aa[0]+'vw'); 
      $('#admin_add_cover_form input[name="h2_size"]').val(aa[0]);

  });

}


$('#admin_add_cover_h1').on('keyup', function(e, color) {
    $('.cover_div h1').html($(this).val());
    $('#admin_add_cover_form input[name="h1_text"]').val($(this).val());
});

$('#admin_add_cover_h2').on('keyup', function(e, color) {
    $('.cover_div h2').html($(this).val());
    $('#admin_add_cover_form input[name="h2_text"]').val($(this).val());
});


$('.admin_cover_list h1').each(function(index,element){
  $(element).css('font-size', parseFloat(($(element).css('font-size')))*0.18);
});

$('.admin_cover_list h2').each(function(index,element){
  $(element).css('font-size', parseFloat(($(element).css('font-size')))*0.2);
});



$('.delete_cover_btn').click(function(){
  $btn = $(this);
  $('#delete_cover_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
      $id = $btn.closest('.cover').data('id');
      $.ajax({
        type: "DELETE",
        url: "/admin/cover/"+$id,
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})


$('.admin_cover_list').sortable({
  stop: function(){
    $data = {};

    $('.admin_cover_list .cover').each(function(index, item){
      $data[$(item).data('id')] = index;
    });

    $.ajax({
      method: "PUT",
      url: '/admin/cover/setorder',
      data: $data
    })
  }
});

$('table.sortable').tablesorter({
  cssAsc:'sorted ascending',
  cssDesc:'sorted descending'
});


setTimeout(function () {
  $('.covers').fadeTo("slow", 1);
}, 100);

if ($('body').attr('id')=='dashboard')
{
  initCharts();
  drawCharts();
}

function drawCharts(){

  $('canvas').each(function(index, item)
  {
    var days = $(item).closest('.box').data('days');
    var resource = $(item).closest('.box').data('resource');
    var type = $(item).closest('.box').data('type');
    var chart = $(item).closest('.box').data('resource')+$(item).closest('.box').data('type');

    $.get('/api/'+resource+'/'+type+'/'+days, {}, function(data){

      var labels = getLastDays(days).reverse();
      var chartdata = getDataByDays(data, days).reverse();

      drawChart(chart, labels, chartdata);

    })


  })

}

function drawChart(chart, labels, data){

    $charts[chart].data.labels = [];
    $charts[chart].data.datasets.forEach((dataset) => {
        dataset.data = [];
    }); 

    $(data).each(function(index, element){
      addChartData($charts[chart], labels[index], data[index]);
    })

}


function addChartData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}



function getLastDays(goBackDays)
{
    var today = new Date();
    var days = [];

    for(var i = 0; i < goBackDays; i++)
    {
        var newDate = new Date(today.setDate(today.getDate() - 1));
        days.push(newDate.getFullYear()+'-'+parseInt(newDate.getMonth()+1)+'-'+newDate.getDate());
    }

    return days;
}

function getDataByDays(data, goBackDays)
{ 
    var result = [];

    var days = getLastDays(goBackDays);
    assocData = {};

    $(data).each(function(index, element){
      assocData[element.date] = element.count;
    })

    $(days).each(function(index, element){
      if (assocData[element]){
        result.push(assocData[element]);
      }
      else
      {
        result.push(0);
      }
    })
    return result;
}

function randomColor(){
  var colorR = Math.floor((Math.random() * 256));
  var colorG = Math.floor((Math.random() * 256));
  var colorB = Math.floor((Math.random() * 256));
  rand="rgb(" + colorR + "," + colorG + "," + colorB + ")";
  return rand;
}

function initCharts()
{
  $charts = {};
  $('canvas').each(function(index, item){
    var canvas = item;
    var ctx = canvas.getContext('2d');
    var color = randomColor();
    canvas.height = $(canvas).parent().height();

    $charts[$(item).closest('.box').data('resource')+$(item).closest('.box').data('type')] = new Chart(ctx, {
        type: 'line',

        data: {
            labels: [],
            datasets: [{
                label: "Počet",
                backgroundColor: color,
                borderColor: color,
                data:[],
                fill: false,
                lineTension: 0
            }]
        },

        options: {
          responsive: true,
          responsiveAnimationDuration: 0,
          maintainAspectRatio: false,

          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              ticks: {
                stepSize: 1
              }
            }]
          },
        },

    });
  })

}





$('.chart_days_btn').click(function(){
  var box = $(this).closest('.box');
  var days = $(this).data('days');
  var resource = $(this).closest('.box').data('resource');
  var type = $(this).closest('.box').data('type');
  var chart =  resource+type;

  $.get('/api/'+resource+'/'+type+'/'+days, {}, function(data){
    var labels = getLastDays(days).reverse();
    var chartdata = getDataByDays(data, days).reverse();
    drawChart(chart, labels, chartdata);
  })

  $(this).closest('.fr').find('.chart_days_btn').removeClass('selected');
  $(this).addClass('selected');

});


$('.layout_div').click(function(){
  $layout = $(this).data('layout');
  $.post('/admin/layout/set',{layout:$layout}, function(){
    location.reload();
  })
})


$('.ui.new.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {new: 1}, 
        success: function(data){
          $row = $('#new_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#new_product_table tbody tr:last-child').before($row);
        }   
      })
    }
  }).unbind('ajaxStart');;

$('#new_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {new: 0}, 
    success: function(data){
      $row.remove();
    }   
  })
})


$('.ui.sale.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {sale: 1}, 
        success: function(data){
          $row = $('#sale_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#sale_product_table tbody tr:last-child').before($row);
        }   
      })
    }
  });

$('#sale_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {sale: 0}, 
    success: function(data){
      $row.remove();
    }   
  })
})



$('.ui.inactive.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
    },
    onSelect: function(result, response){
       $.ajax({
        method: 'PUT',
        url: '/api/product/'+result.id,
        data: {active: 0}, 
        success: function(data){
          $row = $('#inactive_product_table tbody tr:first-child').clone();
          $row.find('td:first-child').text(result.id);
          $row.find('td:nth-child(2)').text(result.name);
          $row.data('id',result.id);
          $('#inactive_product_table tbody tr:last-child').before($row);
        }   
      })
    }
  });

$('#inactive_product_table').on('click', '.red.button', function(){
  $row = $(this).closest('tr');
  $id = $row.data('id');
  $.ajax({
    method: 'PUT',
    url: '/api/product/'+$id,
    data: {active: 1}, 
    success: function(data){
      $row.remove();
    }   
  })
})



$('.ui.cart.product.search')
  .search({
    apiSettings: {
      url: '/api/products/search?query={query}',
    },
    fields: {
      results : 'results',
      title   : 'name',
    },
    onSelect: function(result, response){
       $cartid = $('.cart.content').data('cartid');
       $.ajax({
        method: 'POST',
        url: "/cart/"+$cartid+"/"+result.id,
        data: {qty: 1}, 
        success: function(data){
          location.reload();
        }   
      })
    }
  });


$('.change_cat_img_btn').click(function(){
  $('#category_image_dropzone').click();
});

$('#import_json_btn').click(function(){
  $json = $.parseJSON($('#import_json').find('textarea').val());
  $table = $('#import_json_table');
  $tbody = $table.find('tbody');
  $table.show();

  $($json).each(function(i,e){
    $tbody.find('tr:last-child td:nth-child(2)').html('<img src="'+e.img+'" width="100" />');
    $tbody.find('tr:last-child td:nth-child(3)').text(e.id);
    $tbody.find('tr:last-child td:nth-child(4)').text(e.nome);
    $tbody.find('tr:last-child td:nth-child(5)').text(e.descr);
    $tbody.find('tr:last-child').clone().appendTo($tbody);
  })

  $('.ui.checkbox').checkbox();

})

$('#import_json_accept').click(function(){
  var json = $('#import_json_table').tableToJSON();
  console.log(json);
  $.post('/admin/import/json', {json: $('#import_json').find('textarea').val()}, function(e){
    console.log(e);
  })
})

$('.add_color_btn').click(function(){
    $('#add_color_modal').modal('setting', {
    onApprove : function() {
      $key = $('#add_color_key_input').val();
      $value = $('#add_color_value_input').val();
      
      $.ajax({
        type: "POST",
        url: "/admin/color/",
        data: {key: $key, value:$value},
        success: function(){
          location.reload();
        }
      })
    }
  }).modal('show');
})



$('.product_color.editable').spectrum({
    showPaletteOnly: true,
    hideAfterPaletteSelect:true,
    color: 'blanchedalmond',
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ]
});

$(".product_color.editable").on('change.spectrum', function(e, color) {
    $(this).css('background-color',color.toRgbString());
    $('#add_color_value_input').val(color.toHexString());
});

$('.product_color.choosable')
  .popup({
    popup : $('.flowing.popup'),
    on    : 'hover',
    hoverable: true
  })
;


function initCartProductSlider(){

  var sliders = document.getElementsByClassName('cart_length_slider');
  
  for ( var i = 0; i < sliders.length; i++ ) {

     $qty = $(sliders[i]).data('qty');
     $thresholds = $(sliders[i]).data('thresholds');

     $prices = JSON.parse($(sliders[i]).data('prices'));

     noUiSlider.create(sliders[i], {
          start: $qty,
          connect: "lower",
          orientation: "horizontal",
          tooltips: true,
          range: {
              'min': 1,
              'max': 200
          },
        
          format: wNumb({
            decimals: 0,
          })
      });
  
     sliders[i].noUiSlider.on('slide', function ( values, handle ) {
      $level = getClosestValue($thresholds,values[handle]); 
      $index = $thresholds.indexOf($level);
      $newprice =$prices[$index];
      $($(this)[0].target).closest('.item.product').find('.final_price').html($newprice+ ' &euro;');
     });
      $cartid = $('.cart.content').data('cartid');

      sliders[i].noUiSlider.on('change', function ( values, handle ) {

      $('#grid .dimmer').addClass('active');

      $.ajax({
        type: "PUT",
        url: "/cart/"+$cartid+"/"+$($(this)[0].target).data('productid'),
        data: {qty: values[handle]},
        success: function(){
          location.reload();
        }
      })
     });

  }
  

}

initCartProductSlider();


function getClosestValue(myArray, myValue){
    //optional
    var i = 0;

    while(myArray[++i] <= myValue);

    return myArray[--i];
}

function initProductQtySlider(){

  var slider = document.getElementById('product_buy_qty_m_slider');
    if ($(slider).length)
    {
    $min = $(slider).data('min');
    $max = $(slider).data('max');
    $thresholds = [];

    $('#product_price_thresholds').find('.threshold').each(function(index, obj)
    {
      $thresholds.push(parseInt($(this).text()));
    });


     noUiSlider.create(slider, {
          start: $min,
          step: 1,
          orientation: "horizontal",
          connect: [true, false],
          range: {
              'min': 0,
              'max': $max
          },
          pips: {
            mode: 'values',
            values: $thresholds,
            density: 1
          },
          format: wNumb({
            decimals: 0,
          })
      });
  
    slider.noUiSlider.on('change', function ( values, handle ) {
    if ( values[handle] < $min ) {
      slider.noUiSlider.set($min);
      $('#product_buy_qty_value').find('qty').text($min);
      $price = $min * parseFloat($('#product_price_thresholds').find('.threshold').next().find('#final_price').text()); 
      $('#product_buy_qty_value').find('price').text($price);

    };
  });


  slider.noUiSlider.on('slide', function ( values, handle ) {
    $('#product_buy_qty_value').find('qty').text(values[handle]);
    $('#product_detail_tocart_btn').data('qty',values[handle]);
    $price = values[handle] * Math.round(parseFloat($('#product_price_thresholds').find('.threshold[data-value="'+getClosestValue($thresholds,values[handle])+'"]').next().find('#final_price').text())*100)/100; 
    $('#product_price_thresholds').find('.threshold').closest('tr').removeClass('positive');
    $('#product_price_thresholds').find('.threshold[data-value="'+getClosestValue($thresholds,values[handle])+'"]').closest('tr').addClass('positive');
    $('#product_buy_qty_value').find('price').text($price);
   });
}
}


initProductQtySlider();



$('#add_price_level_btn').click(function(){
  $.get('/api/view/pricelevel',{}, function(data){
    $('#product_price_levels_list').append(data);
  })
})

/*
$('#product_detail .img img').loupe({
    width: 250, // width of magnifier
  height: 200, // height of magnifier
  loupe: 'loupe' // css class for magnifier
});
*/

$('.admin_checkbox_onthefly').checkbox({
    onChecked: function(){
      $resource = $(this).parent().data('resource');
      $name = $(this).attr('name');
      $id = $(this).parent().data('id');
      $data = {};
      $data[$name] = 1;
      $.ajax({
        method: 'PUT',
        url: '/'+$resource+'/'+$id,
        data: $data          
      })
    },
    onUnchecked: function(){
      $resource = $(this).parent().data('resource');
      $name = $(this).attr('name');
      $id = $(this).parent().data('id');
      $data = {};
      $data[$name] = 0;
      $.ajax({
        method: 'PUT',
        url: '/'+$resource+'/'+$id,
        data: $data          
      })
    }
  });


 $('#bulk_products_table').DataTable({
  paging: false,
  info: false,
  lengthChange: false,
 });


function getBulkEditedRows()
{
    var myRows = {};
    var tbl = $('#bulk_products_table tbody tr.edited').each(function(index, item) {
      $cells = $(this).find("td.edit");

      $productid = $(item).data('id');
      myRows[$productid] = {};
      $cells.each(function(cindex,citem) {
        myRows[$productid][$(citem).data('name')] = $(citem).find('input').val();
      });    
    });
    

    return myRows;
}

  $editedRows=[];
$('#bulk_products_table').on('change keyup','.product_param', function(){
  $tr = $(this).closest('tr');
  $tr.addClass('positive edited');
  $productid=$tr.data('id');
  $editedRows.push($productid);
 });

$('#bulk_save_btn').click(function(){
  console.log(getBulkEditedRows());

    $.ajax({
      method: 'POST',
      url: '/bulk',
      data: getBulkEditedRows() ,
      success: function(data){
        location.reload();
      } 
    })
})

$('#cookies_msg i').click(function(){
  $('#cookies_msg').hide();
  $.ajax({
    method: "PUT",
    url: '/user/'+$(this).data('user_id'),
    data: {cookies: 1}
  })
});


$cart_price = 0;

$('#cart_detail .product').each(function(index,item){
  $cart_price = $cart_price + parseFloat($(item).find('.final_price').text());
})

$('#cart_total_price').find('price').text(parseFloat($cart_price).toFixed(2));

if(parseFloat($('#cart_total_price').find('price').text()) < parseFloat($('#cart_min_price').find('price').text()))
{
	$('#cart_continue_btn').addClass('disabled');
}

$freeShippingPrice = parseFloat($('#cart_free_shipping_price').data('price')) - parseFloat($('#cart_total_price').find('price').text());
if ($freeShippingPrice > 0)
{
	$('#cart_free_shipping_price').find('price').text($freeShippingPrice);
}
else
{
	$('#cart_free_shipping_price').hide();
}

$('.filterbar_handle').mouseover(function(){
  $('#filterbar').show();
})

$('#product_content #filterbar').mouseleave(function(){
  setTimeout(function(){
    $('#filterbar').hide();
  },600)
})

$('.admin_delete_category_param_btn').click(function(){
  $.ajax({
    method: "DELETE",
    url: '/category/parameter/'+$(this).data('paramid'),
    success: function(){
      location.reload();
    }
  })
})

$('.category i.setting').click(function(e){
  e.preventDefault();

  location.replace($(this).data('href'));
})


$('#change_grid_view_btn').click(function(){
  $('#grid').find('.item').addClass('grid').removeClass('list');
  $(this).addClass('active');
  $('#change_list_view_btn').removeClass('active');
})


$('#change_list_view_btn').click(function(){
  $('#grid').find('.item').addClass('list').removeClass('grid');
    $(this).addClass('active');
  $('#change_grid_view_btn').removeClass('active');
})

$('#cart_continue_btn').click(function(){
  $price = $('#cart_total_price price').text();

   $.ajax({
    type: "POST",
    url: "/cart/",
    data: {price: $price},
    success: function(){
      //
    }
  });
}).unbind('ajaxStart');


$().prettyEmbed({ 
  useFitVids: true,
});


$(document).on('click', '.pretty-embed', function(){
  var lightbox = lity('//www.youtube.com/watch?v='+$(this).data('pe-videoid'));
});

$('#add_param_btn').click(function(){
	$('#add_param_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {
    	$key = $('#add_param_modal input[name="key"]').val();
        $display_key = $('#add_param_modal input[name="display_key"]').val();

    	$.ajax({
    		type: "POST",
    		url: "/param/",
    		data: {key: $key, display_key:$display_key},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})

$('.edit_param_btn').click(function(){
	 $id = $(this).closest('.param.item').data('paramid');
	 $val = $(this).closest('.param.item').data('val');

	$('#edit_param_modal').modal('setting', {
    autofocus: false,
    onShow: function(){
    	$('#edit_param_modal input[name="display_key"]').val($val);
    },
    onApprove : function() {

        $display_key = $('#edit_param_modal input[name="display_key"]').val();

    	$.ajax({
    		type: "PUT",
    		url: "/param/"+$id,
    		data: {display_key:$display_key},
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
})


$('.delete_param_btn').click(function(){
	 $id = $(this).closest('.param.item').data('paramid');

	$('#delete_param_modal').modal('setting', {
    autofocus: false,
    onApprove : function() {

    	$.ajax({
    		type: "DELETE",
    		url: "/param/"+$id,
    		success: function(){
    			location.reload();
    		}
    	})
    }
  }).modal('show');
});


$(document).on('click', '#params_list .param.item:not(.manage)', function(e){
   if( e.target == this ||  $(e.target).hasClass('name')  ||  $(e.target).hasClass('eye') ) 
   {
		$paramid = $(this).data('paramid');
		$catid = $(this).data('categoryid');
		$this = $(this);
		$this.find('.dimmer').addClass('active');
		if ($this.hasClass('active'))
		{
			$.ajax({
				type: "DELETE",
				url: "/category/parameter/"+$paramid,
				data: {category_id: $catid},
				success: function(){
					$this.removeClass('active');
						$this.find('.dimmer').removeClass('active');

				}
			})	
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "/category/parameter/add",
				data: {parameter_id: $paramid, category_id: $catid},
				success: function(){
					$this.addClass('active');
					$this.find('.dimmer').removeClass('active');

				}
			})	
		}
	}
});

if ($('#admin_category_params_selection').length > 0)
{
$('.dropdown').dropdown({
	onAdd: function(addedValue, addedText, $addedChoice){
		$catid = $('#category_image_div').data('categoryid');
		$.ajax({
			type: "POST",
			url: "/category/parameter/add",
			data: {parameter_id: addedValue, category_id: $catid},
			success: function(){

			}
		})
	},
	onRemove: function(removedValue, removedText, $removedChoice){
		$catid = $('#category_image_div').data('categoryid');
		$.ajax({
			type: "DELETE",
			url: "/category/parameter/"+removedValue,
			data: {category_id: $catid},
			success: function(){

			}
		})	
	}
})
}

$('#admin_order_params_save').click(function(){
	$data = {};
	$data['min_order_price'] = $('input[name="min_order_price"]').val();
	$data['min_free_shipping_price'] = $('input[name="min_free_shipping_price"]').val();

	$.post('/set/config', $data, function(){

	})
})

$(document).on('click', '.delete_product_param', function(){
	$(this).closest('.row').remove();
})

$('#send_remider_btn').click(function(){
	$(this).addClass('loading');
})

$(document).on('click','.delete_price_level_btn', function(){
	$(this).closest('.product_price_level').remove();
});

});
