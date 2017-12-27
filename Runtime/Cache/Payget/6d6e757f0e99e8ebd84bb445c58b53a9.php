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
        <title> 绑定 </title>
        
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
         <link rel="stylesheet" href="Public/Pay/css/style.css?t=ab">
        <script type="text/javascript" src="Public/Pay/js/libs/zepto.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="top">
                <h1>绑定储蓄卡</h1>
                <p>欢迎使用极速转售，绑定银行卡号后会方便转售</p>
            </div>
            <section class="main">
             <form action="<?php echo U(bindcard);?>" method="post" class="form-horizontal">    
                <div class="form-wrap">
                    <ul>
                        <li>
                            <label for="bank_no">姓名</label>
                            <input id="bank_no" name="username" type="text" value="<?php echo ($username); ?>" placeHolder="请输入姓名">
                        </li>

                        <li>
                            <label for="bank_no">身份证号</label>
                            <input id="bank_no" name="idcard" value="<?php echo ($idcard); ?>" type="text" placeHolder="请输入身份证号">
                        </li>
                    </ul>
                </div>

                 <div class="form-wrap">
                    <ul>
                        <li>
                            <label for="bank_no">储蓄卡号</label>
                            <input id="bank_no" name="card_no" value="<?php echo ($cardno); ?>" type="text" placeHolder="请输入卡号">
                        </li>
                    </ul>
                </div>

                <div class="form-info">
                    <a href="javascript:;" id="cardse"><i class="ico ico-support"></i>支持银行</a><br/>
                   <li>
                            <label for="bank_no"><?php echo ($bankname); ?></label>
                            <input id="bank_no" name="bankname" value="<?php echo ($bankname); ?>" type="hidden" />
                        </li>
                </div>

                 <div class="form-wrap flex-3">
                    <ul>
                        <li>
                            <label for="bank_no">手机号</label>
                            <input id="mobile" name="mobile" type="text" placeHolder="请输入手机号">
                        </li>

                        <li class="flex-3-li">
                            <label for="bank_no">验证码</label>
                            <input id="check_code" name="check_code" type="text" placeHolder="请输入验证码">
                            <a href="javascript:;" id="sendma" onclick="sendphone()" class="btn-yanzheng">获取验证码</a>
                        </li>
                    </ul>
                </div>
                <span id="showinfo" style="font-size:14px"></span>
                 <div class="tool">
                    <a href="javascript:;" id="submit">下一步</a>
                </div>
            </form>
            </section>

        </div>
        <script type="text/javascript">
            
            var secs = 60;
            $("#submit").click(function(){
               var mobile_code = $('#check_code').val();
               var username = $("input[name='username']").val();
               var idcard = $("input[name='idcard']").val();
               var card_no = $("input[name='card_no']").val();
               var bankname = $("input[name='bankname']").val();
               if(!mobile_code){alert('验证码不能为空');return;}
               if(!username){alert('开户名不能为空');return;}
               if(!idcard){alert('身份证号不能为空');return;}
               if(!card_no){alert('银行卡号不能为空');return;}
               if(!bankname){alert('请选择支持银行');return;}
                     $('form').submit();
            });
            
        function err_msg(str, id) {
    		document.getElementById('showinfo').style.display = "inline-block";
    		document.getElementById('showinfo').style.color = "#F00";
    		//document.getElementById('showinfo').style.font-size = "12px";
    		document.getElementById('showinfo').innerHTML=str;
	    }
        function sendphone(){
    		var phone=$("#mobile").val();
    		if(!(/^1[34578]\d{9}$/.test(phone))){
    			err_msg('不正确的手机号码', 'mobile');
    			return false;
    		}
    		if($('#dmobile').html()=="手机号已经被使用" || $('#dmobile').html()=="短信已发送") {
    			return false;
    		}
    		$.ajax({
    			type:'post', //传送的方式,get/post
    			url:'<?php echo U("index/sendcode");?>', //发送数据的地址
    			data:{phone:phone},
    			dataType: "json",
    			success:function(data){
    				err_msg(data.info, 'mobile');
    			}
    		})
    		 document.getElementById('sendma').style.color = '#cdced0';
    		 backcount();
	   }    
	   function backcount(){
    		$(".btn-yanzheng").attr("onClick",'');
    		for(i=1;i<=secs;i++) {
    			window.setTimeout("update1(" + i + ")", i * 1000);
    		}
	    }
	    function update1(num) {
    		if(num == secs) {
    			$("#sendma").html('获取验证码');
    			$("#sendma").addClass('background-color','#f70e8f');
    			$("#sendma").attr("onClick",'sendphone();');
    		}else {
    			printnr = secs-num;
    			$("#sendma").html("(" + printnr +")秒后重发");
    		}
	    }
	    $("#cardse").click(function(){
	        //var url = window.location.href;   
	        var username = $("input[name=username]").val();
	        var idcard = $("input[name=idcard]").val();
	        var card_no = $("input[name=card_no]").val();
	        var jumprul = "<?php echo U(selectcard);?>"+'&username='+username+'&idcard='+idcard+'&cardno='+card_no;
	        
	        window.location.href = jumprul;
	     });
        </script>

    </body>
</html>