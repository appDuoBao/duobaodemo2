<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>购买记录</title>
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/purchase_record.css">
    <script src="/duobao/app/duobaodemo2/Public/Weixin/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="purchase_content">
            <div class="purchase_left"><img src="<?php echo (get_cover($vo["goods_detail"]["cover_id"],'path')); ?>" alt=""></div>
            <div class="purchase_right">
                <div class="purchase_right_title"><?php echo ($vo["goods_detail"]["title"]); ?></div>
                <div class="purchase_right_choose">我的选择：<span><?php echo ($vo["num"]); ?>单 <?php echo ($vo["type"]); ?></span></div>
                <div class="purchase_right_choose">参与时间：<?php echo (date('Y/m/d H:i:s', $vo["create_time"])); ?></div>
                <div class="purchase_right_choose">开奖时间：<?php echo ($vo["lottery_time"]); ?></div>
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
   
    <div style="height:8rem;width:100%;"></div>

    <div class="menu_fixed">
        <div class="bottom_menu" id="main">
            <span class="menu_bottom_img"><img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-main.png" alt=""></span>
            <span class="menu_bottom_font">首页</span>
        </div>
        <div class="bottom_menu" id="flow">
            <span class="menu_bottom_img"><img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-flow.png" alt=""></span>
            <span class="menu_bottom_font">走势图</span>
        </div>
        <div class="bottom_menu" id="order">
            <span class="menu_bottom_img"><img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-order.png" alt=""></span>
            <span class="menu_bottom_font">排行榜</span>
        </div>
        <div class="bottom_menu" id="personal">
            <span class="menu_bottom_img"><img src="/duobao/app/duobaodemo2/Public/Weixin/images/icon-person-red.png" alt=""></span>
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