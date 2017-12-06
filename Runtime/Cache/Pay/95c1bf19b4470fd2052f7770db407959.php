<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>我的转售</title>
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Pay/css/base.css">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Pay/css/my_resale.css">
    <script src="/duobao/app/duobaodemo2/Public/Pay/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="Public/Pay/js/libs/zepto.min.js"></script>
</head>
<body>
    <div class="resale_top">
        <span class="resale_top_img"><img src="/duobao/app/duobaodemo2/Public/Pay/images/zhuan.png" alt=""></span><span style="padding-left:20px;">兑换码转售</span>
    </div>
    <div class="card_all">
        <span style="padding-left:40px; float:left;">卡数合计</span>
        <span style="padding-right:40px; float:right;"><?php echo ($cardno); ?>张</span>
    </div>
    <div class="card_content">
        <div class="content_left">
            <span class="left_font">实际收入</span>
            <span class="left_font">总价值</span>
            <span class="left_font">手续费</span>
        </div>
        <div class="content_right">
            <span class="right_font"><?php echo ($shiji); ?>元</span>
            <span class="right_font"><?php echo ($total); ?>元</span>
            <span class="right_font"><?php echo ($sxf); ?>元</span>
        </div>
    </div>
    <div class="yes_btn">确定</div>
    <div class="card_number">
        <span class="card_name">银行卡号：</span>
        <input id="bank_no" type="text" value="<?php echo ($cardinfo["card_no"]); ?>">
    </div>
    <div class="card_number" style="margin-top:2px;">
        <span class="card_name">开户银行：</span>
        <input id="bank_name" type="text" value="<?php echo ($cardinfo["bankname"]); ?>">
    </div>
    <div class="card_number" style="margin-top:2px;">
        <span class="card_name">开户姓名：</span>
        <input id="bank_user" type="text" value="<?php echo ($cardinfo["username"]); ?>">
    </div>
    <div class="resale_top" style="margin-top:20px;">
        <span class="resale_top_img"><img src="/duobao/app/duobaodemo2/Public/Pay/images/zhuan.png" alt=""></span><span style="padding-left:20px;">兑换码</span>
    </div>
    <div class="kuang"><?php if(!empty($code)): if(is_array($code)): $i = 0; $__LIST__ = $code;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["exchange_number"]); ?>,<?php endforeach; endif; else: echo "" ;endif; endif; ?></div>
    <div class="pingtai"><span style="color:#C22631;">[极速转售平台]</span>是一个第三方卡类商品交易平台。注册平台后，通过该平台您可以将闲置的各类卡转让给其他有需求的用户，转售完成后交易金额将自动结算至您绑定的银行卡账户，方便快捷。</div>
    <div class="menu_fixed">
        <div class="bottom_menu" style="width:33.3%" id="main">
            <span class="menu_bottom_img" style="margin-left:105px;"><img src="/duobao/app/duobaodemo2/Public/Pay/images/icon-main-red.png" alt=""></span>
            <span class="menu_bottom_font font-red">首页</span>
        </div>
        <div class="bottom_menu" style="width:33.3%" id="bankcard">
            <span class="menu_bottom_img" style="margin-left:105px;"><img src="/duobao/app/duobaodemo2/Public/Pay/images/icon-card.png" alt=""></span>
            <span class="menu_bottom_font">银行卡</span>
        </div>
        <div class="bottom_menu" style="width:33.3%" id="tranceReport">
            <span class="menu_bottom_img" style="margin-left:105px;"><img src="/duobao/app/duobaodemo2/Public/Pay/images/icon-order.png" alt=""></span>
            <span class="menu_bottom_font">转售记录</span>
        </div>
    </div>
</body>
</html>
<script>
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