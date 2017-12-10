<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>我的转售</title>
    <link rel="stylesheet" href="/Public/Pay/css/base.css">
    <link rel="stylesheet" href="/Public/Pay/css/my_resale.css">
    <script type="text/javascript" src="Public/Pay/js/libs/zepto.min.js"></script>
    <style>
        .card_bank{
            position: absolute;
            color:#fff;
            font-family: PingFangSC-Regular;
            top:8.5rem;
            left:15rem;
            font-size: 36px;
            letter-spacing: -0.62px;
            line-height: 50px;
        }
        .card_num{
            position: absolute;
            color:#fff;
            font-family: PingFangSC-Regular;
            font-size: 32px;
            color:black;
            letter-spacing: -0.55px;
            left:18rem;
            top:18rem;
        }
        .card_num span{
            color:#fff;
            margin-left: 5px;
            font-size: 32px;
        }
    </style>
</head>
<body>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="card_img" >
        <img src="/Public/Pay/images/card_yin.png" alt="">
        <span class="card_bank">招商银行</span>
        <div class="card_num">
            <span><?php echo (substr($vo["card_no"],0,4)); ?></span>
            <span>****</span>
            <span>****</span>
            <span>****</span>
            <span class="num"><?php echo (substr($vo["card_no"],-4)); ?></span>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
<div class="add_card">
    <span class="menu_img">+</span>
    <span class="menu_font">添加储蓄卡</span>
    <span class="menu_right">〉</span>
</div>
<div class="menu_fixed">
    <div class="bottom_menu" style="width:33.3%" id="main">
        <span class="menu_bottom_img" style="margin-left:105px;"><img src="/Public/Pay/images/icon-main.png" alt=""></span>
        <span class="menu_bottom_font ">首页</span>
    </div>
    <div class="bottom_menu" style="width:33.3%" id="bankcard">
        <span class="menu_bottom_img" style="margin-left:105px;"><img src="/Public/Pay/images/card_red.png" alt=""></span>
        <span class="menu_bottom_font font-red">银行卡</span>
    </div>
    <div class="bottom_menu" style="width:33.3%" id="tranceReport">
        <span class="menu_bottom_img" style="margin-left:105px;"><img src="/Public/Pay/images/icon-order.png" alt=""></span>
        <span class="menu_bottom_font">转售记录</span>
    </div>
</div>
</body>
</html>
<script>
    $(".add_card").click(function(){
        window.location.href="<?php echo U('bindcard');?>";
    });

    $("#main").click(function(){
        window.location.href="<?php echo U('Index/index');?>";
    });
    $("#bankcard").click(function(){
        window.location.href="<?php echo U('Index/cardlist');?>";
    });
    $("#tranceReport").click(function(){
        window.location.href="<?php echo U('Index/recordlist');?>";
    });
</script>