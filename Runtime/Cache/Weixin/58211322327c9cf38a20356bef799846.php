<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>支付订单</title>
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/pay_order.css">
    <script src="/duobao/app/duobaodemo2/Public/Weixin/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div class="pay_title"><?php echo ($goodsmsg[0]["title"]); ?></div>
    <div class="pay_number">
        <button class="pay_choose lower">-</button>
        <input class="pay_center" type="number" placeholder="" value="1" onkeyup="check_num(this.value);">
        <button class="pay_choose uper">+</button>
    </div>
    <div class="pay_number" style="height:220px;">
        <span class="number_content">1</span>
        <span class="number_content">10</span>
        <span class="number_content">20</span>
        <span class="number_content">30</span>
        <span class="number_content">50</span>
        <span class="number_content">60</span>
        <span class="number_content">80</span>
        <span class="number_content">100</span>
    </div>
    <div class="more_buy">单笔最多可购买100单</div>
    <div class="line"></div>
    <div class="all_need">总需：<span id="pay_num"><?php echo ($pay_half); ?></span>微币</div>
    <div class="menu_personal" style="margin-top:18px;">
        <span class="menu_img"><img src="/duobao/app/duobaodemo2/Public/Weixin/images/pay_wei.png" alt=""></span>
        <span class="menu_font">微信支付</span>
        <span class="menu_right"><input type="radio" class="cbtest" name="pay" value="1" /></span>
    </div>
    <div class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/duobao/app/duobaodemo2/Public/Weixin/images/pay_zhi.png" alt=""></span>
        <span class="menu_font">支付宝支付</span>
        <span class="menu_right">
            <input type="radio" class="cbtest" name="pay" value="2" />
        </span>
    </div>
    <div class="pay_confirm">确认支付</div>
</body>
</html>
<script>
    //点-减少数量和钱数
    $(".lower").click(function(){
        var num=$(".pay_center").val();
        if(num>1)
            num--;
        $(".pay_center").val(num);
        $("#pay_num").html(num*<?php echo ($pay_half); ?>);
    });
    //点+ 增加数量和钱数
    $(".uper").click(function(){
        var num=$(".pay_center").val();
        if(num<100)
            num++;
        $(".pay_center").val(num);
        $("#pay_num").html(num*<?php echo ($pay_half); ?>);
    });
    $(".pay_center").blur(function(){
        if($(this).val()>100){
            alert("最多只可购买100单");
            $(this).val(100);
        }
    });
    function check_num(v){
        if(v=="")
            v=0;
        if(v>100){
            alert("最多只可购买100单");
            $(".pay_center").val(100);
            v=100;
            $("#pay_num").html(parseInt(v)*parseInt(<?php echo ($pay_half); ?>));
            return false;
        }else{

            $("#pay_num").html(parseInt(v)*parseInt(<?php echo ($pay_half); ?>));
            return true;
        }
    }
    //点击数量
    $(".number_content").each(function(i){
        $(this).click(function(){
            $(".pay_center").val($(this).html());
            $("#pay_num").html($(this).html()*<?php echo ($pay_half); ?>);
        });
    });
    //确认支付
    $(".pay_confirm").click(function(){
        if(check_num($(".pay_center").val())){
            callpay($("input[name='pay']:checked").val());
        }
    });
     function callpay(ptype){
          var myunix = "<?php echo ($data["myunix"]); ?>";
          var myjsunix = nowunix = Date.parse( new Date())/1000;

         if((myunix - myjsunix) < 30){
            alert('即将开奖，敬请期待下一期');
            return false;
         }
        var total_fee = $('.pay_num').html();
        var type =  "<?php echo ($type); ?>";

        var num = $(".pay_center").val();
        var goods_type = '<?php echo ($goodsmsg[0]["price"]); ?>';
        var fromtype = ptype;
        var lottery_time = $(".fnTimeCountDown").data('end');
        var goods_id = '<?php echo ($goodsmsg[0]["id"]); ?>';
        if(total_fee == '' || type==''  || num =='' || lottery_time =='' || goods_id ==''){
            alert('操作异常,请选择购买数量！');
            return false;
        }
        console.log("hehe");
        $.ajax({
            type: 'post', //传送的方式,get/post
            //url: './index.php?s=Weixin/Request/submitOrderInfo',
            url:"<?php echo U('Request/submitOrderInfo');?>",
            data: {total_fee:total_fee,type:type,num:num,goods_type:goods_type,lottery_time:lottery_time,goods_id:goods_id,ptype:'',buyer_id:'',buyer_logon_id:''},
            //dataType: "json",
            success: function (res) {
                console.log(res);
                if(res.ret== 0){
                    if(ptype ==1){      
                        _AP.pay(res.url);
                            window.location.href = res.url;
                    }
                    if(ptype == 2){
                        wxcallpay(res.data);    
                    }
                            //var options = {text: res.url};
                            //var canvas = BCUtil.createQrCode(options);
                            //var wording=document.createElement('p');
                    //var imgs = convertCanvasToImage(canvas);
                            //var element=document.getElementById("qrcode");
                            //element.appendChild(wording);
                            //element.appendChild(imgs);  
                    //$(".content").html(imgs);
                }else{
                   alert(res.msg);
                }
            
            }
        });
         
      }
function wxcallpay(result) {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall(result);
        }
    }

function jsApiCall(ret) {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',{
                            "appId" : ret.app_id, //公众号名称，由商户传入
                            "timeStamp": ret.timestamp, //戳，自1970 年以来的秒数
                            "nonceStr" : ret.nonce_str, //随机串
                            "package" : ret.package,
                            "signType" : ret.sign_type, //微信签名方式:
                            "paySign" : ret.pay_sign//微信签名,
             },
            function(res){
                if(res.err_msg == "get_brand_wcpay_request：ok" ) {
            alert('支付成功');
                }else{
                        alert('支付失败');
                }
            }
        );
    }
function convertCanvasToImage(canvas){

     //新Image对象,可以理解为DOM;
     var image = new Image();

     //canvas.toDataURL返回的是一串Base64编码的URL,当然,浏览器自己肯定支持
     //指定格式PNG
     image.src = canvas.toDataURL("image/png");
     return image;
}

    var flag = 0;

    function judge(){
        var myunix = "<?php echo ($data["myunix"]); ?>";
        var myjsunix = nowunix = Date.parse( new Date())/1000;

        if((myunix - myjsunix) < 30){
            alert('即将开奖，敬请期待下一期');
            return false;
        }

        var total_fee = $('.sumn').html();
        var account = "<?php echo ($price); ?>";
        console.log('account'+account);
        console.log('total_fee'+total_fee);

        var cha = parseInt(account - total_fee);
        console.log(cha);
        if(cha >= 0){
            if(flag == 1){
                alert('处理中...');
            }else{
                flag = 1;
                console.log(flag);

                var total_fee = $('.sumn').html();
                var type = $('#pay_type').val();
                var num = $(".btn2").val();
                var goods_type = $('#goods_type').val();
                var lottery_time = $(".fnTimeCountDown").data('end');
                var goods_id = '<?php echo I("get.id");?>';
                if(total_fee == ''  || type =='' || num =='' || lottery_time =='' || goods_id ==''){
                    alert('操作异常');
                    return false;
                }
                $.ajax({

                    type: 'post', //传送的方式,get/post
                    url: '/Weixin/Goods/makeOrder',
                    data: {total_fee:total_fee,type:type,num:num,goods_type:goods_type,lottery_time:lottery_time,goods_id:goods_id},
                    dataType: "json",
                    success: function (data) {
                        flag = 0;
                        if(data.status == 1){
                            alert('购买成功');
                            window.location.href = '/Weixin/Goods/doByPay/id/' + data.out_trade_no;

                        }else{
                            alert('操纵异常');
                        }
                    }
                });
            }
        }else{
            getpay();
        }

    }

    function getpay(){
        var myunix = "<?php echo ($data["myunix"]); ?>";
        var myjsunix = nowunix = Date.parse( new Date())/1000;

        if((myunix - myjsunix) < 30){
            alert("即将开奖，敬请期待下一期");
            return false;
        }       
        
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', topay, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', topay);
                document.attachEvent('onWeixinJSBridgeReady', topay);
            }
            topay();
        }else{
            topay();
        }
    }



    function topay(){
        var total_fee = $('.sumn').html();
        var type = $('#pay_type').val();
        var num = $(".btn2").val();
        var lottery_time = $(".fnTimeCountDown").data('end');
        var goods_id = '<?php echo I("get.id");?>';
        if(total_fee == ''  || type =='' || num =='' || lottery_time =='' || goods_id ==''){
            alert('操作异常,请选择购买数量！');
            return false;
        }
        $.ajax({
            type: 'post', //传送的方式,get/post
            url: '../index.php?s=/Weixin/Request/submitOrderInfo',
            data: {total_fee:total_fee,type:type,num:num,goods_type:goods_type,lottery_time:lottery_time,goods_id:goods_id,ptype:1},
//            dataType: "json",
            success: function (res) {
                if(typeof(res) === 'string'){
                    res = JSON.parse(res);
                    var payInfo = JSON.parse(res.pay_info);
                    var orderid = JSON.parse(res.orderid);
                }

                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',{
                            "appId" : payInfo.appId, //公众号名称，由商户传入
                            "timeStamp": payInfo.timeStamp, //戳，自1970 年以来的秒数
                            "nonceStr" : payInfo.nonceStr, //随机串
                            "package" : payInfo.package,
                            "signType" : payInfo.signType, //微信签名方式:
                            "paySign" : payInfo.paySign  //微信签名,
                        },function(data){
                            //alert(data.err_desc+data.err_msg);
                            if(data.err_msg.indexOf('ok')>0){
                                // 此处可以使用此方式判断前端返回,微信团队郑重提示：res.err_msg 将在用户支付成功后返回ok，但并不保证它绝对可靠。
                                alert('购买成功');
                                var jump_url = '/Weixin/Goods/doByPay/id/' + orderid;
                                window.location.href = jump_url;
                            }
                        }
                );
            }
        });

    }
</script>