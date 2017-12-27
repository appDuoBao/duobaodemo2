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
    <link rel="stylesheet" href="Public/Pay/css/commonalert.css?a=bcaa">
    <script type="text/javascript" src="Public/Pay/js/libs/zepto.min.js"></script>
    <script type="text/javascript" src="Public/Pay/js/alertPopShow.js"></script>
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
	.payment_time_mask{

		text-align: center;
	}
	.payment_time_mask li {
		height: 38px;
		line-height: 38px;
		background-color: #fff;
		border-bottom: 1px solid #ccc;
		list-style-type:none;
}
    </style>
</head>
<body>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="card_img" data-id="<?php echo ($vo["id"]); ?>">
        <img src="/Public/Pay/images/card_yin.png" alt="">
        <span class="card_bank"><?php echo ($vo["bankname"]); ?></span>
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
	
               var flag = 'c';
	       $('.card_img').on('click', function(){

			       var obj = $(this);
			       var bid = obj.attr('data-id');  
			       if(!bid) return; 
			       popTipShow.confirm('银行卡菜单','<div z-index="9999" class="payment_time_mask"><li onclick="selec(this,1)" class="muca">默认银行卡</li><li onclick="selec(this,2)" class="muca">删除银行卡</li></div>',['确 定','取 消'],
				       function(e){
				       //callback 处理按钮事件
				       var button = $(e.target).attr('class');

				       if(button == 'ok'){
				       //按下确定按钮执行的操作
				       //todo ....				
				       this.hide();
				       setTimeout(function() {

					       $.post("<?php echo U('updatebank');?>",{bid:bid,flag:flag},function(result){
						       if(result.ret ==0){
						       webToast("操作成功","top", 2000);
						       window.href.reload();
						       }

						       },'json'); 


					       }, 300);
				       }

				       if(button == 'cancel') {
					       //按下取消按钮执行的操作
					       //todo ....
					       this.hide();
					       //        				setTimeout(function() {
					       //        					webToast("您选择“取消”了","bottom", 2000);
					       //        				}, 300);
				       }
				       }
	       );
	       });

            function selec(obj,act){
                  $(".muca").css("background-color","");
                   flag = act; 
                   var objs  = $(obj);
                   objs.css("background-color","yellow");
                      
            }



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