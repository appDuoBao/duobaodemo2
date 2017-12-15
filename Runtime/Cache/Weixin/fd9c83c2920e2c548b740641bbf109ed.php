<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>我的银行卡</title>
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/Public/Weixin/css/bank_card.css">
    <script src="/Public/Weixin/js/jquery-2.1.0.min.js"></script>
</head>
</head>
<body>
<div class="card_content account">到账方式</div>
<div class="account_card">
    <div class="account_left">
        <?php if($isadd == 'no'): ?><span class="card_nmber">银行卡：<?php echo (substr($account[0]['card_no'] ,0,3)); ?>********<?php echo (substr($account[0]['card_no'] ,-4)); ?></span>
        <?php else: ?>
        <span class="card_nmber">您还没有添加银行卡</span><?php endif; ?>
        <span class="card_bottm">（提现到支付宝，手续费1%，2小时内到账）</span>
    </div>
    <div class="account_right">
        <?php if($isadd == 'no'): ?>已添加
        <?php else: ?>
        <a href="/pay.php?s=/index/bindcard" style="color:#4A90E2;font-size: 32px;">添加</a><?php endif; ?>
    </div>
</div>
<div class="card_content account" style="margin-top:20px;">提款金额</div>
<div class="can_use">可用余额<span style="color:#C22631 "><?php echo ($balance); ?></span>元</div>
<div class="money_edit"><span>￥</span><input type="text" id="paymoney" placeholder="" onkeyup="check_balance(this.value)"></div>
<div class="can_use">
    手续费：￥<span id="service_charge">0.00</span>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
    实际到账：￥<span id="realitypay">0.00</span>
 </div>
<div class="warning">
    <p>提现注意事项：</p>
    <p>国家命令禁止一切洗钱行为，本平台积极响应配合国家政策，保证正常用户的资金安全，针对提款作出以下规定：</p>
    <p>1、针对充值后消费金额小于存入金额20%的账户的提款申请，将加收15%的异常提款处理费用，同时，提款到账自提款申请之日起，不少于15个工作日。
    </p>
    <p>2、针对异常提款进行严格审核，审核时间大于1-3天，处理时间在30个工作日内，工作人员发现账户有异常提款记录后，账户信息将被加入黑名单。
    </p>
</div>
<div class="save_btn">提款</div>

</body>
</html>
<script>
   function check_balance(val){
        console.log(val);
        if(val><?php echo ($balance); ?>){
            alert("余额不足");
            $("#paymoney").val('');
            return false;
        }else{
            if(val){
                var s_c=(parseFloat(val)*0.01).toFixed(2);
                var rp=(parseFloat(val)*0.99).toFixed(2);
                $("#service_charge").html(s_c);
                $("#realitypay").html(rp);
                return true;
            }
        }
   }

   $(".save_btn").on('click',function(){
        if(check_balance($("#paymoney").val())){
            //提款操作：
        }
   });
</script>