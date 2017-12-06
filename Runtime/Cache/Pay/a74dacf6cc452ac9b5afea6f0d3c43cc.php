<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="apple-mobile-web-app-title" content="MGJH5" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="grey" />
        <title> 支持储蓄卡 </title>
        
        <script type="text/javascript">
        (function(win,lib){var doc=win.document;var docEl=doc.documentElement;var metaEl=doc.querySelector('meta[name="viewport"]');var flexibleEl=doc.querySelector('meta[name="flexible"]');var dpr=0;var scale=0;var tid;var flexible=lib.flexible||(lib.flexible={});if(metaEl){var match=metaEl.getAttribute("content").match(/initial-scale=([d.]+)/);if(match){scale=parseFloat(match[1]);dpr=parseInt(1/scale)}}else{if(flexibleEl){var content=flexibleEl.getAttribute("content");if(content){var initialDpr=content.match(/initial-dpr=([d.]+)/);var maximumDpr=content.match(/maximum-dpr=([d.]+)/);if(initialDpr){dpr=parseFloat(initialDpr[1]);scale=parseFloat((1/dpr).toFixed(2))}if(maximumDpr){dpr=parseFloat(maximumDpr[1]);scale=parseFloat((1/dpr).toFixed(2))}}}}if(!dpr&&!scale){var isAndroid=win.navigator.appVersion.match(/android/gi);var isIPhone=win.navigator.appVersion.match(/iphone/gi);var devicePixelRatio=win.devicePixelRatio;if(isIPhone){if(devicePixelRatio>=3&&(!dpr||dpr>=3)){dpr=3}else{if(devicePixelRatio>=2&&(!dpr||dpr>=2)){dpr=2}else{dpr=1}}}else{dpr=1}scale=1/dpr}docEl.setAttribute("data-dpr",dpr);if(!metaEl){metaEl=doc.createElement("mdeta");metaEl.setAttribute("name","viewport");metaEl.setAttribute("content","initial-scale="+scale+", maximum-scale="+scale+", minimum-scale="+scale+", user-scalable=no");if(docEl.firstElementChild){docEl.firstElementChild.appendChild(metaEl)}else{var wrap=doc.createElement("div");wrap.appendChild(metaEl);doc.write(wrap.innerHTML)}}function refreshRem(){var width=docEl.getBoundingClientRect().width;if(width/dpr>640){width=640*dpr}var rem=width/6.4;docEl.style.fontSize=rem+"px";flexible.rem=win.rem=rem}win.addEventListener("pageshow",function(e){if(e.persisted){clearTimeout(tid);tid=setTimeout(refreshRem,300)}},false);if(doc.readyState==="complete"){doc.body.style.fontSize=12*dpr+"px"}else{doc.addEventListener("DOMContentLoaded",function(e){doc.body.style.fontSize=12*dpr+"px"},false)}refreshRem();flexible.dpr=win.dpr=dpr;flexible.refreshRem=refreshRem;flexible.rem2px=function(d){var val=parseFloat(d)*this.rem;if(typeof d==="string"&&d.match(/rem$/)){val+="px"}return val};flexible.px2rem=function(d){var val=parseFloat(d)/this.rem;if(typeof d==="string"&&d.match(/px$/)){val+="rem"}return val}})(window,window["lib"]||(window["lib"]={}));
          
          (function() {
            var win = window,
                doc = win.document,
                isAndroid = win.navigator.appVersion.match(/android/gi),
                isIPhone = win.navigator.appVersion.match(/iphone/gi),
                platform = isIPhone ? 'iphone' : (isAndroid ? 'android' : 'other');
            if (doc.readyState === 'complete') {
              doc.body.setAttribute('data-platform', platform);
            } else {
              doc.addEventListener('DOMContentLoaded', function(e) {
                doc.body.setAttribute('data-platform', platform);
              }, false);
            }
          })();
        </script>
        <link rel="stylesheet" href="Public/Pay/css/style.css">
        <script type="text/javascript" src="Public/Pay/js/libs/zepto.min.js"></script>
    </head>
    <body>
        <div class="container bank">
            <header> 
                <h1 class="title tc">支持储蓄卡</h1>
            </header>
            <section class="main ">
                
                <div class="bankList">
                    <ul>
                        <li  class="selectbank " bname="工商银行">
                            <a href="javascript:;"><i class="ico ico-bank-icbc"></i>工商银行</a>
                            <div class="bg"></div>
                        </li>
                        <li class="selectbank" bname="招商银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>招商银行</a>
                            <div class="bg"></div>
                        </li>
                         <li class="selectbank" bname="中国银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>中国银行</a>
                            <div class="bg"></div>
                        </li>
                         <li class="selectbank" bname="建设银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>建设银行</a>
                            <div class="bg"></div>
                        </li>
                           <li class="selectbank" bname="民生银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>民生银行</a>
                            <div class="bg"></div>
                        </li>
                        <li class="selectbank" bname="北京银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>北京银行</a>
                            <div class="bg"></div>
                        </li>
                        <li class="selectbank" bname="兴业银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>兴业银行</a>
                            <div class="bg"></div>
                        </li>
                        <li class="selectbank" bname="农业银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>农业银行</a>
                            <div class="bg"></div>
                        </li>
                         <li class="selectbank" bname="光大银行">
                             <a href="javascript:;"><i class="ico ico-bank-icbc"></i>光大银行</a>
                            <div class="bg"></div>
                        </li>
                    </ul>
                </div>
                
                 <div class="tool">
                    <input type="hidden" id="urlfrom" value="<?php echo ($fromurl); ?>"/>
                    <a href="javascript:;" id="nextop">下一步</a>
                </div>
            </section>
            <script type="text/javascript">
                    var bankname='';
                   $(".selectbank").click(function(){
                        var thisobj = $(this);
                        $(".selectbank").removeClass('active');
                        thisobj.addClass('active');
                        bankname = thisobj.attr('bname');
                    });
                    $("#nextop").click(function(){
                        var url = $("#urlfrom").val();
                        var jumpurl = "http://"+url.replace(/selectcard/,"bindcard") + "&bankname="+bankname;
                        if(url){
                            window.location.href = jumpurl;
                        }
                            
                    });
             </script>
        </div>
        

    </body>
</html>