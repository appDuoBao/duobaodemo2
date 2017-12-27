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
    <script src="/Public/Pay/js/jquery-1.9.1.min.js"></script>
</head>
<style>
    .content_left{
        width:30%;
    }
    .content_right{
        width:70%;
    }
    .left_font{
        width:133px;
        height:45px;
        padding-left:40px;
        font-family: PingFangSC-Regular;
    }
    .left_font:last-child,.left_font:last-child{
        margin-bottom:20px;
    }
    .right_font{
        text-align: left;
        color:#686868;
    }
</style>
<body>
<div class="resale_top">
    <span class="resale_top_img"><img src="/Public/Pay/images/zhuan.png" alt=""></span><span style="padding-left:20px;">兑换码转售</span>
</div>
<div style="width:710px;height:63px;padding-left:40px;font-size:24px;color:#9b9b9b;line-height:63px;">银行晚间21:30-22:00系统维护</div>
<div class="resale_top">
    <span style="padding-left:40px;">转售记录</span>
</div>
<?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="card_content change2" style="margin-top:2px;">
            <div class="content_left">
                <span class="left_font">转售单号</span>
            </div>
            <div class="content_right">
                <span class="right_font"><?php echo ($vo["pay_id"]); ?></span>
            </div>
            <div style="clear:both;"></div>
        </div><?php endforeach; endif; else: echo "" ;endif; endif; ?> 
<div class="menu_fixed" >
    <div class="bottom_menu" style="width:33.3%" id="main">
        <span class="menu_bottom_img" style="margin-left:105px;"><img src="/Public/Pay/images/icon-main.png" alt=""></span>
        <span class="menu_bottom_font ">首页</span>
    </div>
    <div class="bottom_menu" style="width:33.3%" id="bankcard">
        <span class="menu_bottom_img" style="margin-left:105px;"><img src="/Public/Pay/images/icon-card.png" alt=""></span>
        <span class="menu_bottom_font">银行卡</span>
    </div>
    <div class="bottom_menu" style="width:33.3%" id="tranceReport">
        <span class="menu_bottom_img" style="margin-left:105px;"><img src="/Public/Pay/images/icon-order-red.png" alt=""></span>
        <span class="menu_bottom_font font-red">转售记录</span>
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