<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>兑换记录</title>
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/Public/Weixin/css/purchase_record.css">
    <link rel="stylesheet" href="/Public/Weixin/css/personal_center.css">
    <script src="/Public/Weixin/js/jquery-1.9.1.min.js"></script>
</head>
<style>
    .purchase_left img{
        width:223px;
        height:138px;
        margin-left:30px;
        margin-top:20px;
    }
    .duihuan{
        font-size: 24px;
        color: #686868;
        letter-spacing: -0.44px;
        text-align: center;
        height:33px;
        width:100%;
    }
    .yeslist{
        display: none;
    }
</style>
<body>
<div class="exchange_menu">
    <div class="exchange_left active">未兑换</div>
    <div class="exchange_right">已兑换</div>
</div>
<!--未兑奖记录-->
<?php if(is_array($noExchangeList)): $i = 0; $__LIST__ = $noExchangeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="purchase_content nolist">
        <div class="purchase_left">
            <img src="<?php echo (get_cover($vo["order"]["goods_detail"]["cover_id"],'path')); ?>" alt="">
            <p class="duihuan">未兑换</p>
        </div>
        <div class="purchase_right">
            <div class="purchase_right_title"><?php echo ($vo["order"]["goods_detail"]["title"]); ?></div>
            <div class="purchase_right_choose">我的选择：<span><?php echo ($vo["order"]["num"]); ?>单  <?php echo ($vo["type"]); ?></span></div>
            <div class="purchase_right_choose">参与时间：<?php echo (date('Y/m/d H:i:s', $vo["order"]["create_time"])); ?></div>
            <div class="purchase_right_choose">开奖时间：<?php echo ($vo["order"]["lottery_time"]); ?></div>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>

<!--已兑奖记录-->
<?php if(is_array($yesExchangeList)): $i = 0; $__LIST__ = $yesExchangeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="purchase_content yeslist">
        <div class="purchase_left">
            <img src="<?php echo (get_cover($vo["order"]["goods_detail"]["cover_id"],'path')); ?>" alt="">
            <p class="duihuan">半价购买：￥<?php echo ($vo["goods_type"]); ?>元</p>
        </div>
        <div class="purchase_right">
            <div class="purchase_right_title"><?php echo ($vo["order"]["goods_detail"]["title"]); ?></div>
            <div class="purchase_right_choose">我的选择：<span><?php echo ($vo["order"]["num"]); ?>单 <?php echo ($vo["type"]); ?></span></div>
            <div class="purchase_right_choose">参与时间：<?php echo (date('Y/m/d H:i:s', $vo["order"]["create_time"])); ?></div>
            <div class="purchase_right_choose">开奖时间：<?php echo ($vo["order"]["lottery_time"]); ?></div>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
<?php if(is_array($yesExchangeList)): $i = 0; $__LIST__ = $yesExchangeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="purchase_content yeslist">
        <div class="purchase_left">
            <img src="<?php echo (get_cover($vo["order"]["goods_detail"]["cover_id"],'path')); ?>" alt="">
            <p class="duihuan">半价购买：￥<?php echo ($vo["goods_type"]); ?>元</p>
        </div>
        <div class="purchase_right">
            <div class="purchase_right_title"><?php echo ($vo["order"]["goods_detail"]["title"]); ?></div>
            <div class="purchase_right_choose">我的选择：<span><?php echo ($vo["order"]["num"]); ?>单 <?php echo ($vo["type"]); ?></span></div>
            <div class="purchase_right_choose">参与时间：<?php echo (date('Y/m/d H:i:s', $vo["order"]["create_time"])); ?></div>
            <div class="purchase_right_choose">开奖时间：<?php echo ($vo["order"]["lottery_time"]); ?></div>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
<div style="height:8rem;width:100%;"></div>

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
    $(".nolist").click(function(){
        window.location.href="http://duobao.akng.net/pay.php";
    });
    $(".exchange_left").click(function(){
        $(this).addClass('active');
        $(".exchange_right").removeClass("active");
        $(".nolist").css("display","block");
        $(".yeslist").css("display","none");
    });
    $(".exchange_right").click(function(){
        $(this).addClass('active');
        $(".exchange_left").removeClass("active");
        $(".nolist").css("display","none");
        $(".yeslist").css("display","block");
    });

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