<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>支付订单</title>
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/Public/Weixin/css/pay_order.css">
    <script src="/Public/Weixin/js/jquery-2.1.0.min.js"></script>
    <style>
        .chosenum{
            width:100%;
            font-family: PingFangSC-Regular;
            font-size: 35px;
            color: #C22631;
            letter-spacing: -0.48px;
            line-height: 100px;
            text-align: center;
            background-color: #FFFFFF;
            margin:0px auto;
            height: 100px;
           box-shadow: 0 2px 4px 0 rgba(0,0,0,0.20);
            border-radius: 5px;
        }
        .number_content{
            width:150px;
            height:78px;
            font-size: 30px;
            color: #686868;
            letter-spacing: 0;
            margin-right: 25px;
            margin-left: 15px;
        }
        .chosepay{
            height:100px;
            font-family: PingFangSC-Regular;
            font-size: 35px;
            line-height: 100px;
            color: #C22631;
            letter-spacing: -0.48px;
            background-color: #FFFFFF;
        }
        .choseThis{
            background-color: #C22631;
            color:#FFFFFF;
        }
    </style>
</head>
<body>
    <div class="pay_number chosenum">
        选择充值金额
    </div>
    <div class="pay_number" style="height:220px;width:82%">
        <span class="number_content">20</span>
        <span class="number_content">50</span>
        <span class="number_content">100</span>
        <span class="number_content">200</span>
        <span class="number_content">500</span>
        <span class="number_content">1000</span>
    </div>
    <div class="all_need chosepay" >选择支付方式</div>
    <div class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/pay_wei.png" alt=""></span>
        <span class="menu_font">微信支付</span>
        <span class="menu_right"><input type="radio" class="cbtest" name="pay"/></span>
    </div>
    <div class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/QQ.png" alt=""></span>
        <span class="menu_font">网银支付</span>
        <span class="menu_right">
            <input type="radio" class="cbtest" name="pay"/>
        </span>
    </div>
    <div class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/pay_zhi.png" alt=""></span>
        <span class="menu_font">支付宝支付</span>
        <span class="menu_right">
            <input type="radio" class="cbtest" name="pay"/>
        </span>
    </div>
    <div class="pay_confirm" id="confirm" onclick="topay();">确认支付</div>
    <input id="total_fee" name="total_fee" type="hidden" value="">
</body>
</html>
<script>
    $(".number_content").each(function(i){
        $(this).click(function(){
            $(this).addClass("choseThis");
            $(this).siblings().removeClass("choseThis");
            $("#total_fee").val($(this).html());
        });
    });


    // 调用微信JS api 支付
    function jsApiCall(){
        var total_fee = $('input[name=total_fee]').val();
        if(total_fee == ''){
            alert('操作异常');
            return false;
        }
        var r = /^\+?[1-9][0-9]*$/;　　//正整数
        if(!r.test(total_fee)){
            alert('请输入大于1的整数');
            return false;
        }
        $.ajax({
            type: 'post', //传送的方式,get/post
            url: '/Weixin/My/getJsApiParametersNo', //获取jsApiParameters
            data: {total_fee:total_fee},
            dataType: "json",
            success: function (data) {

                if(data.jsApiParameters){
                    WeixinJSBridge.invoke('getBrandWCPayRequest',data.jsApiParameters,function(res){
//                        WeixinJSBridge.log(res.err_msg);
//                        alert(JSON.stringify(<?php echo ($jsApiParameters); ?>));
                        //alert(res.err_code+'---'+res.err_desc+'---'+res.err_msg);
                        var out_trade_no = data.out_trade_no;
                        if(res.err_msg.indexOf('ok')>0){
                            //支付成功后的操作
                            $.ajax({
                                type: 'post', //传送的方式,get/post
                                url: '/Weixin/My/doSthByPayment', //获取jsApiParameters
                                data:  {out_trade_no:out_trade_no},
                                dataType: "json",
                                success: function (result) {
                                    if(result.status == 1){
                                        //自动跳转
                                        var jump_url = '/Weixin/My/account';
                                        window.location.href = jump_url;
                                    }else{
                                        alert('操纵异常');
                                    }
                                }
                            })
                        }
                    });
                }
            }
        })
    }

    function callpay(){
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }


    function topay(){
        var total_fee = $('input[name=total_fee]').val();
        var lottery_time = $('input[name=lottery_time]').val();
        if(total_fee == ''){
            alert('操作异常');
            return false;
        }
        var r = /^\+?[1-9][0-9]*$/;　　//正整数
        if(!r.test(total_fee)){
            alert('请输入大于1的整数');
            return false;
        }

        $.ajax({
            type: 'post', //传送的方式,get/post
            url: '<?php echo U("Request/rechargeOrderInfo");?>',
            data: {total_fee:total_fee,lottery_time:lottery_time},
 //           dataType: "json",
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
                                alert('充值成功');
                                var jump_url = '/Weixin/My/account';
                                window.location.href = jump_url;
                            }
                        }
                );
            }
        });

    }
</script>