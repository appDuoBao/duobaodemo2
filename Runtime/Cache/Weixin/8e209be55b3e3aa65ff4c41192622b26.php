<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>个人中心</title>
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/Public/Weixin/css/personal_center.css">
    <script src="/Public/Weixin/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div class="heand">
        <div class="head_img"><img src="/Public/Weixin/images/head.png" alt=""></div>
        <div class="head_name">用户名</div>
    </div>
    <div id="mywallet" class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/my_money.png" alt=""></span>
        <span class="menu_font">我的钱包</span>
        <span class="menu_right">〉</span>
    </div>
    <div id="exchangelog" class="menu_personal" style="margin-top:20px;">
        <span class="menu_img"><img src="/Public/Weixin/images/dui.png" alt=""></span>
        <span class="menu_font">兑换记录</span>
        <span class="menu_right">〉</span>
    </div>
    <div id="trancepaylog" class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/zhuan.png" alt=""></span>
        <span class="menu_font">我的转售</span>
        <span class="menu_right">〉</span>
    </div>
    <div id="buylog" class="menu_personal" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/buy.png" alt=""></span>
        <span class="menu_font">购买记录</span>
        <span class="menu_right">〉</span>
    </div>
    <?php if($isjoin != true): ?><div id="cooperation" class="menu_personal" style="margin-top:20px;">
        <span class="menu_img"><img src="/Public/Weixin/images/he.png" alt=""></span>
        <span class="menu_font">合作申请</span>
        <span class="menu_right">〉</span>
    </div><?php endif; ?>
    <div id="plays" class="menu_personal" style="margin-top:20px;">
        <span class="menu_img"><img src="/Public/Weixin/images/wan.png" alt=""></span>
        <span class="menu_font">玩法介绍</span>
        <span class="menu_right">〉</span>
    </div>
    <div id="outlog" class="menu_personal sign_out" style="margin-top:5px;">
        <span class="menu_img"><img src="/Public/Weixin/images/tui.png" alt=""></span>
        <span class="menu_font">退出登录</span>
        <span class="menu_right">〉</span>
    </div>
    <div class="signout" style="display: none;">
        <div class="sign_center">
            <div class="sign_title">是否退出登录？</div>
            <div class="canal">取消</div>
            <div id="signout" class="determine">确定</div>
        </div>
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
   <!--  <div class="footer">
    <div class="f1">
        <a href="<?php echo U('Inedex/index');?>" class="active">
            <img src="/Public/Weixin/images/icon-index.png" alt="" />
            <p style="color:#333;font-size: 0.2rem;">首页</p>
        </a>
    </div>
    <div class="f2">
        <a href="<?php echo U('Openprize/index');?>">
            <img src="/Public/Weixin/images/icon-flow.png" alt="" />
            <p style="color:#333; font-size: 0.2rem;">走势图</p>
        </a>
    </div>
    <div class="f3">
        <a href="<?php echo U('Index/topsort?t=to');?>">
            <img src="/Public/Weixin/images/icon-order-red.png" alt="" />
            <p style="color:#C22631;font-size: 0.2rem;">排行榜</p>
        </a>
    </div>
    <div class="f3">
        <a href="<?php echo U('My/index');?>">
            <img src="/Public/Weixin/images/icon-person.png" alt="" />
            <p style="font-size: 0.2rem;">个人中心</p>
        </a>
    </div>
    
    
</div> -->
    <script>
        $(".sign_out").on("click",function(){
            $(".signout").css("display","block");
        });
        $(".canal").on("click",function(){
            $(".signout").css("display","none");
        });
        $("#buylog").click(function(){
            window.location.href='<?php echo U('My/buyLog');?>';
        });
        $("#exchangelog").click(function(){
            window.location.href='<?php echo U('My/exchangeList');?>';
        });
        $("#mywallet").click(function(){
            window.location.href='<?php echo U('My/account');?>';
        });
        $("#trancepaylog").click(function(){
            window.location.href='http://duobao.akng.net/pay.php';
        });
        $("#cooperation").click(function(){
            window.location.href='<?php echo U('My/join');?>';
        });
        $("#plays").click(function(){
            window.location.href='<?php echo U('Index/introduce');?>';
        });

        $("#signout").click(function(){
            window.location.href='<?php echo U('User/logout');?>';
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
</body>
</html>