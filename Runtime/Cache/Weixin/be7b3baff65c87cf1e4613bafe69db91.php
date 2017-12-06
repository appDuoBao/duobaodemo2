<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>玩法规则</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/common.css">
    <style>
        .z-sc{
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
	<div class="mainall">
		<img src="/duobao/app/duobaodemo2/Public/Weixin/images/z-sc.jpg" alt="">
	</div>
	<div class="footer">
    <div class="f1">
        <a href="<?php echo U('Inedex/index');?>" class="active">
            <img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon_red.png" alt="" />
            <p style="color:#C22631;">首页</p>
        </a>
    </div>
    <div class="f2">
    	<a href="<?php echo U('Openprize/index');?>">
    		<img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-flow.png" alt="" />
            <p>走势图</p>
    	</a>
    </div>
    <div class="f3">
        <a href="<?php echo U('Index/topsort');?>">
            <img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-order.png" alt="" />
            <p>排行榜</p>
        </a>
    </div>
    <div class="f3">
        <a href="<?php echo U('My/index');?>">
            <img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-person.png" alt="" />
            <p>个人中心</p>
        </a>
    </div>
    
    
</div>
</body>
</html>