<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>玩法规则</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
    <script src="/Public/Weixin/js/qrcode.js"></script>
    <style>
        .mainall{
            width: 100%;
            height: auto;
            margin-bottom: 100px;
        }
        .mainall img{
            width: 100%;
        }
    </style>
</head>
<body>
	<div class="mainall">
		<img src="/Public/Weixin/images/z-sc.jpg" alt="">
	</div>
	<div class="menu_fixed">
        <div class="bottom_menu" id="main">
            <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-main.png" alt=""></span>
            <span class="menu_bottom_font">首页</span>
        </div>
        <div class="bottom_menu" id="flow">
            <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-flow.png" alt=""></span>
            <span class="menu_bottom_font">走势图</span>
        </div>
        <div class="bottom_menu" id="order">
            <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-order.png" alt=""></span>
            <span class="menu_bottom_font">排行榜</span>
        </div>
        <div class="bottom_menu" id="personal">
            <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-person-red.png" alt=""></span>
            <span class="menu_bottom_font font-red">个人中心</span>
        </div>
    </div>
</body>
</html>
<script>
     $("#main").click(function(){
        window.location.href='<?php echo U('Index/index');?>';
    });
    $("#flow").click(function(){
        window.location.href='<?php echo U('Openprize/index');?>';
    });
    $("#order").click(function(){
        window.location.href='<?php echo U('Index/topsort?t=to');?>';
    });
    $("#personal").click(function(){
        window.location.href='<?php echo U('My/index');?>';
    });
</script>