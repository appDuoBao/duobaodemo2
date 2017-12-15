<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>排行榜</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
	<link rel="stylesheet" href="/Public/Weixin/css/newsort.css">
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
</head>

<body>
	<div class="content">
		<div class="list">
		    <?php if($type == to): ?><a id="day-list" class="list-type list-active" href="#item1">
				日榜
			</a>
			<a id="week-list" class="list-type"   href="<?php echo U('Index/topsort?t=mo');?>">
				周榜
			</a>
		    <?php else: ?>
		        <a id="day-list" class="list-type" href="<?php echo U('Index/topsort?t=to');?>">
				日榜
			</a>
			<a id="week-list" class="list-type list-active" href="#item2">
				周榜
			</a><?php endif; ?>
			<!-- <a class="mui-control-item" href="#item3">
				月榜
			</a> -->
		</div>
		<!-- 日榜 -->
		<div id="item1" class="listmsg daylist-active">
			<div class="top">
				<div class="top-left">
					<img src="Public/Weixin/images/Group 4.png">
				</div>
				<div class="top-right">
					<div class="tr1">
						<img class="tr-img" src="<?php echo ($one["userinfo"]["headimgurl"]); ?>" />
						<img src="/Public/Weixin/images/no1.png" class="tr-img2">
						<span class="tr-name"><?php echo (mb_substr($one["userinfo"]["nickname"],0,7)); ?></span>
					</div>
					<p class="top-buy">已获胜：<i style="color: #C22631;"><?php echo ($one["num"]); ?></i>单</p>
				</div>
			</div>

			<ul class="">
				<li class="top2">
					<div class="top2-left" >
						<img src="Public/Weixin/images/Group 6.png">
					</div>
					<div class="top2-right">
						<div class="tr2-img">
							<img class="" src="<?php echo ($two["userinfo"]["headimgurl"]); ?>" />
						</div>
						<div class="tr2-word">
							<h4 class="nickname"><?php echo ($two["userinfo"]["nickname"]); ?></h4>
							<span class="nicknum">已获胜：<i><?php echo ($two["num"]); ?></i>单</span>
						</div>
					</div>
				</li>
				<li class="top2">
					<div class="top2-left">
						<img src="Public/Weixin/images/Group 7.png">
					</div>
					<div class="top2-right">
						<div class="tr2-img">
							<img class="ph_img3" src="<?php echo ($three["userinfo"]["headimgurl"]); ?>" />
						</div>
						<div class="tr2-word">
							<h4 class="nickname"><?php echo ($three["userinfo"]["nickname"]); ?></h4>
							<span class="nicknum">已获胜：<i><?php echo ($three["num"]); ?></i>单</span>
						</div>
					</div>
				</li>
				 <?php if(!empty($users)): if(is_array($users)): $k = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="top2">
					<div class="top2-num">NO.<?php echo ($k+3); ?></div>
					<div class="top2-right">
						<div class="tr2-img">
							<img class="ph_img4" src="<?php echo ($vo["userinfo"]["headimgurl"]); ?>" />
						</div>
						<div class="tr2-word">
							<h4 class="nickname"><?php echo ($vo["userinfo"]["nickname"]); ?></h4>
							<span class="nicknum">已获胜：<i><?php echo ($vo["num"]); ?></i>单</span>
						</div>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; endif; ?> 
				
			</ul>
		</div>
		<!-- 日榜 end-->
		<!-- 周榜 -->
		<div id="item2" class="" style="display: none;">
			<div class="top">
				<div class="top-left">
					<img src="Public/Weixin/images/Group 4.png">
				</div>
				<div class="top-right">
					<div class="tr1">
						<!-- <img class="ph_zimg" src="<?php echo ($one["headimgurl"]); ?>" /> -->
						<img class="tr-img" src="/Public/Weixin/images/1_03.png" />
						<img src="/Public/Weixin/images/no1.png" class="tr-img2">
						<span class="tr-name"><?php echo (mb_substr($one["userinfo"]["nickname"],0,7)); ?></span>
					</div>
					<p class="top-buy">已获胜：<i style="color: #C22631;"><?php echo ($one["num"]); ?></i>单</p>
				</div>
			</div>

			<ul class="">
				<li class="top2">
					<div class="top2-left" >
						<img src="Public/Weixin/images/Group 6.png">
					</div>
					<div class="top2-right">
						<div class="tr2-img">
							<img class="" src="<?php echo ($two["userinfo"]["headimgurl"]); ?>" />
						</div>
						<div class="tr2-word">
							<h4 class="nickname"><?php echo ($two["userinfo"]["nickname"]); ?>是否大师傅的说法大宋</h4>
							<span class="nicknum">已获胜：<i><?php echo ($two["num"]); ?>20</i>单</span>
						</div>
					</div>
				</li>
				<li class="top2">
					<div class="top2-left">
						<img src="Public/Weixin/images/Group 7.png">
					</div>
					<div class="top2-right">
						<div class="tr2-img">
							<img class="ph_img3" src="<?php echo ($three["userinfo"]["headimgurl"]); ?>" />
						</div>
						<div class="tr2-word">
							<h4 class="nickname"><?php echo ($three["userinfo"]["nickname"]); ?>sfdsfsd</h4>
							<span class="nicknum">已获胜：<i><?php echo ($three["num"]); ?>20</i>单</span>
						</div>
					</div>
				</li>
				 <?php if(!empty($users)): if(is_array($users)): $k = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="top2">
					<div class="top2-num">NO.<?php echo ($k+3); ?></div>
					<div class="top2-right">
						<div class="tr2-img">
							<img class="ph_img4" src="<?php echo ($vo["userinfo"]["headimgurl"]); ?>" />
						</div>
						<div class="tr2-word">
							<h4 class="nickname"><?php echo ($vo["userinfo"]["nickname"]); ?></h4>
							<span class="nicknum">已获胜：<i><?php echo ($vo["num"]); ?></i>单</span>
						</div>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; endif; ?> 
				
			</ul>
		</div>

	</div>
	<div class="menu_fixed">
	    <div class="bottom_menu" id="main">
	        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-main.png" alt=""></span>
	        <span class="menu_bottom_font ">首页</span>
	    </div>
	    <div class="bottom_menu" id="flow">
	        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-flow.png" alt=""></span>
	        <span class="menu_bottom_font ">走势图</span>
	    </div>
	    <div class="bottom_menu" id="order">
	        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-order-red.png" alt=""></span>
	        <span class="menu_bottom_font font-red">排行榜</span>
	    </div>
	    <div class="bottom_menu" id="personal">
	        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-person.png" alt=""></span>
	        <span class="menu_bottom_font ">个人中心</span>
	    </div>
	</div>

	<script src="Public/Weixin/js/jquery-1.9.1.min.js"></script>
<!--<script src="Public/Weixin/js/mui.min.js"></script>-->
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
	
</body>
</html>