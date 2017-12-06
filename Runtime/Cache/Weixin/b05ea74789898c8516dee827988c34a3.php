<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>合作申请</title>
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Weixin/css/bank_card.css">
    <script src="/duobao/app/duobaodemo2/Public/Weixin/js/jquery-2.1.0.min.js"></script>
</head>
<style>
    .card_name{
        width:200px;
    }
    .save_btn{
        bottom:314px;
    }
</style>
<body>
<form role="form" action="/duobao/app/duobaodemo2/index.php?s=/My/join" method="post" name="formUser" id="formUser">
<div class="card_content">
    <span class="card_name">企业名称：</span>
    <input type="text" id="company" value="<?php echo ($list["company"]); ?>"   name="company" >
</div>
<div class="card_content">
    <span class="card_name">联系人：</span>
    <input type="text" id="name"  value="<?php echo ($list["name"]); ?>"  name="name" >
</div>
<div class="card_content">
    <span class="card_name">联系电话：</span>
    <input type="text" id="mobile"  value="<?php echo ($list["mobile"]); ?>"  name="mobile" >
</div>
<div class="card_content">
    <span class="card_name">联系地址：</span>
    <input type="text" id="address"  value="<?php echo ($list["address"]); ?>"  name="address" >
</div>
<div class="card_content">
    <span class="card_name">开户行：</span>
    <input type="text" id="kaihuhang"  value="<?php echo ($list["kaihuhang"]); ?>"  name="kaihuhang" >
</div>
<div class="card_content">
    <span class="card_name">卡号：</span>
    <input type="text" id="kahao"  value="<?php echo ($list["kahao"]); ?>"  name="kahao" >
</div>
<div class="card_content">
    <span class="card_name">开户人姓名：</span>
    <input type="text" id="xingming"  value="<?php echo ($list["xingming"]); ?>"  name="xingming" >
</div>

<div class="save_btn" id="confirm" onclick="submitFormUser();">保存</div>
</form>
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

    function submitFormUser(){

        var uid = $('#uid').val();

        var company = $('#company').val();

        var name = $('#name').val();

        var mobile = $('#mobile').val();

        var address = $('#address').val();

        var re = /^1\d{10}$/;

        if(uid == '' || company == ''  || name =='' || mobile =='' || address ==''){

            alert('数据不能为空');

            return false;

        }

        if(!re.test(mobile)){

            alert('请输入正确的手机号');

            return false;

        }

        $('#formUser').submit();//提交

    }
</script>