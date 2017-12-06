<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>我的钱包</title>
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/wallet.css">
    <script src="/duobao/app/duobaodemo2/Public/Weixin/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div class="money">0.00</div>
    <div class="money_yu">账户余额  <?php echo ($price); ?> （元）</div>
    <div class="save_btn" id="recharge">充值</div>
    <div class="save_btn" id="withdraw" style="background: #D8D8D8;color: #686868;">提现</div>
    <div class="money_yu" style="margin-top:60px;color: #4A90E2;">
        <a href="" style="color:#4A90E2;text-decoration: none;">银行卡管理</a>
    </div>
</body>
</html>
<script>
    $("#recharge").click(function(){
        window.location.href="<?php echo U('Goods/detail');?>/id/<?php echo ($uid); ?>/t/cuihua";
    });
    $("#withdraw").click(function(){
        window.location.href="<?php echo U('My/accountPresentation');?>";
    });
</script>