<?php if (!defined('THINK_PATH')) exit();?><!doctype html>

<html>
<head>
<meta charset="UTF-8">
<title><?php echo ($meta_title); ?>|微信系统管理平台</title>
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
<link rel="stylesheet" type="text/css" href="/Public/Control/css/base.css" media="all">
<link rel="stylesheet" type="text/css" href="/Public/Control/css/common.css" media="all">
<link rel="stylesheet" type="text/css" href="/Public/Control/css/module.css">
<link rel="stylesheet" type="text/css" href="/Public/Control/css/style.css" media="all">
<link rel="stylesheet" type="text/css" href="/Public/Control/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">

<!--[if lt IE 9]>

    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>

    <![endif]--><!--[if gte IE 9]><!-->

<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/Public/Control/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/Public/Control/js/highcharts.js"></script>
<script type="text/javascript" src="/Public/Control/js/exporting.js"></script>
<script type="text/javascript" src="/Public/Control/js/data.js"></script>

<!--<![endif]-->


</head>

<body>

<!-- 头部 -->

<div class="header"> 

<div class="header_cen">
  
  <!-- Logo --> 
  
  <span class="logo"><img src="/Public/Control/images/logo.png"></span>
  
  <!-- /Logo --> 
  
  <!-- 主导航 -->
  
  <ul class="main-nav">
    <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if($menu["title"] != '推广'): ?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (get_nav_url($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
<!--     <li><a href="<?php echo get_index_url();?>" target="_blank">网站首页</a></li> -->
  </ul>
  
  <!-- /主导航 --> 
  
  <!-- 用户栏 -->
  
  <div class="user-bar"> <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
    <ul class="nav-list user-menu hidden">
      <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
      <li><a href="<?php echo U('Cache/delcache');?>">清除缓存</a></li>
      <li><a href="<?php echo U('Admin/updatePassword');?>">修改密码</a></li>
      <li><a href="<?php echo U('Admin/updateNickname');?>">修改昵称</a></li>
      <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
    </ul>
  </div>
  <div class="cls"></div>
</div>  
  
</div>

<!-- /头部 --> 

<!-- 边栏 -->

<div class="sidebar"> 
  
  <!-- 子导航 -->
  
  
    <div id="subnav" class="subnav">
      <?php if(!empty($_extra_menu)): ?>
        
        <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
      <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
        
        <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
          <ul class="side-sub-menu">
            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li> <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul><?php endif; ?>
        
        <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  
  
  <!-- /子导航 --> 
  
</div>

<!-- /边栏 --> 

<!-- 内容区 -->

<div id="main-content">
  <div id="top-alert" class="fixed alert alert-error" style="display: none;">
    <button class="close fixed" style="margin-top: 4px;">&times;</button>
    <div class="alert-content">这是内容</div>
  </div>
  <div id="main" class="main">
     
      
      <!-- nav -->
      
      <?php if(!empty($_show_nav)): ?><div class="breadcrumb"> <span>您的位置:</span>
          <?php $i = '1'; ?>
          <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
              <?php else: ?>
              <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
            <?php $i = $i+1; endforeach; endif; ?>
        </div><?php endif; ?>
      
      <!-- nav --> 
      
    
    
   <script type="text/javascript" src="/Public/Control/js/popup_layer.js"></script>
   <link href="/Public/Control/css/popup_layer.css" type="text/css" rel="stylesheet">
   
    <div class="main-title">
        <h2><a  href="<?php echo U('User/userview?puid='.$parent['parent_id']);?>"><font color="green">上级代理详情</font></a></h2>
    </div>
        <div class="form-item">
            公司名称：<?php echo ($parent["company"]); ?>
        </div>
        <div class="form-item">联系人姓名：<?php echo ($parent["name"]); ?></div>
        <div class="form-item">联系人电话：<?php echo ($parent["mobile"]); ?></div>
        <div class="form-item">联系地址：<?php echo ($parent["address"]); ?></div>
        <div class="form-item">返佣比例：<?php echo ($parent["ratio"]); ?>%</div>
        <div class="form-item">返佣类型：<?php echo ($parent["ratio_type"]); ?></div>
        <div class="form-item">开户行：<?php echo ($parent["kaihuhang"]); ?></div>
        <div class="form-item">卡号：<?php echo ($parent["kahao"]); ?></div>
        <div class="form-item">户名：<?php echo ($parent["xingming"]); ?></div>
        <div class="form-item">昵称：<?php echo ($parent["nickname"]); ?></div>
        <div class="form-item">手机号：<?php echo ($parent["mobile"]); ?></div>
        
         
        <a href="javascript:void(0)"><div class="form-item" id="parentid">上级ID：<?php echo ($parent["parent_id"]); ?></div></a>
          <div class="form-item" id="parent" >上级代理：<?php echo ($parent["pname"]); ?></div>
        <div class="form-item">二维码：<img style="width:200px;high:200px" src="<?php echo ($parent["erm"]); ?>" /></div>
        
        <div class="form-item">注册时间：<?php echo (time_format($parent["create_time"])); ?></div>
       <br/>
    <hr />    
       <hr />    
     <div class="main-title">
        <h2>总代理详情</h2>
    </div>
        <div class="form-item">
            公司名称：<?php echo ($roots["company"]); ?>
        </div>
        <div class="form-item">联系人姓名：<?php echo ($roots["name"]); ?></div>
        <div class="form-item">联系人电话：<?php echo ($roots["mobile"]); ?></div>
        <div class="form-item">联系地址：<?php echo ($roots["address"]); ?></div>
        <div class="form-item">返佣比例：<?php echo ($roots["ratio"]); ?>%</div>
        <div class="form-item">返佣类型：<?php echo ($roots["ratio_type"]); ?></div>
        <div class="form-item">开户行：<?php echo ($roots["kaihuhang"]); ?></div>
        <div class="form-item">卡号：<?php echo ($roots["kahao"]); ?></div>
        <div class="form-item">户名：<?php echo ($roots["xingming"]); ?></div>
        <div class="form-item">昵称：<?php echo ($roots["nickname"]); ?></div>
        <div class="form-item">手机号：<?php echo ($roots["mobile"]); ?></div>
        <div class="form-item">二维码：<img style="width:200px;high:200px" src="<?php echo ($roots["erm"]); ?>" /></div>
        
        <div class="form-item">注册时间：<?php echo (time_format($roots["create_time"])); ?></div>
        
        
        
        
        
    
        <div class="form-item">
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
        
        
   <!-- 弹出层 begain--> 
        <div id="blk1" class="blk" style="display:none;">
            <div class="head"><div class="head-right"></div></div>
            <div class="main">
                <h2>代理列表</h2>
                <a href="javascript:void(0)" id="close1" class="closeBtn">关闭</a>
                <ul id="showdata">
                    <li><a href="#">项目1</a></li>
                    <li><a href="#">项目2</a></li>
                    <li><a href="#">项目3</a></li>
                    <li><a href="#">项目4</a></li>
                    <li><a href="#">项目5</a></li>
                    <li><a href="#">项目6</a></li>
                    <li><a href="#">项目7</a></li>
                  
                </ul>
                  <input id="thisid" type="hidden" value="<?php echo ($uid); ?>" />
                  <input id="puid" namev="" type="hidden" value="" />
                  <a href="javascript:void(0)" id="confirm" class="confirm">确定</a>
              
            </div>
            <div class="foot"><div class="foot-right"></div></div>
        </div>

   
   <!--end 弹出层 -->    


  </div>
  <div class="cont-ft">
    <div class="copyright">
      <div class="fl">感谢使用微信管理系统</div>
      <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
    </div>
  </div>
</div>

<!-- /内容区 --> 

<script type="text/javascript">

    (function(){

        var ThinkPHP = window.Think = {

            "ROOT"   : "", //当前网站地址

            "APP"    : "/control.php?s=", //当前项目地址

            "PUBLIC" : "/Public", //项目公共目录地址

            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符

            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],

            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]

        }

    })();

    </script> 
<script type="text/javascript" src="/Public/static/think.js"></script> 
<script type="text/javascript" src="/Public/Control/js/common.js"></script> 
<script type="text/javascript">

        +function(){

            var $window = $(window), $subnav = $("#subnav"), url;

            $window.resize(function(){

                $("#main").css("min-height", $window.height() - 130);

            }).resize();



            /* 左边菜单高亮 */

            url = window.location.pathname + window.location.search;

            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");

			

            $subnav.find("a[href='" + url + "']").parent().addClass("current") ;



            /* 左边菜单显示收起 */

            $("#subnav").on("click", "h3", function(){

                var $this = $(this);

                $this.find(".icon").toggleClass("icon-fold");

                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").

                      prev("h3").find("i").addClass("icon-fold").end().end().hide();

            });



            $("#subnav h3 a").click(function(e){e.stopPropagation()});



            /* 头部管理员菜单 */

            $(".user-bar").mouseenter(function(){

                var userMenu = $(this).children(".user-menu ");

                userMenu.removeClass("hidden");

                clearTimeout(userMenu.data("timeout"));

            }).mouseleave(function(){

                var userMenu = $(this).children(".user-menu");

                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));

                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));

            });



	        /* 表单获取焦点变色 */

	        $("form").on("focus", "input", function(){

		        $(this).addClass('focus');

	        }).on("blur","input",function(){

				        $(this).removeClass('focus');

			        });

		    $("form").on("focus", "textarea", function(){

			    $(this).closest('label').addClass('focus');

		    }).on("blur","textarea",function(){

			    $(this).closest('label').removeClass('focus');

		    });



            // 导航栏超出窗口高度后的模拟滚动条

            var sHeight = $(".sidebar").height();

            var subHeight  = $(".subnav").height();

            var diff = subHeight - sHeight; //250

            var sub = $(".subnav");

            if(diff > 0){

                $(window).mousewheel(function(event, delta){

                    if(delta>0){

                        if(parseInt(sub.css('marginTop'))>-10){

                            sub.css('marginTop','0px');

                        }else{

                            sub.css('marginTop','+='+10);

                        }

                    }else{

                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){

                            sub.css('marginTop','-'+(diff-10));

                        }else{

                            sub.css('marginTop','-='+10);

                        }

                    }

                });

            }

        }();

    </script>

    <script type="text/javascript">
        
        $("#parentid").click(function(){
              getParents();
              new PopupLayer({trigger:"#parent",popupBlk:"#blk1",closeBtn:"#close1"});
              $('#parent').trigger("click");
            });
       function getpdata(id,uid){
           // alert(id);
        }
      //
        function getParents(pid){
            var htmlstr ='';
             $.post("<?php echo U('getparents');?>",{pid:pid},function(result){
                  if(result.ret ==0){
                     $.each(result.data,function(k,v){
                        htmlstr += '<li class="clidata" data_id="'+v.id+'" data_uid ='+v.uid+'><a href="#"   >'+v.name+'</a></li>';
                     });
                     
                     $("#showdata").empty();
                     $("#showdata").append(htmlstr);  
                     $(".clidata").bind('click',function(){
                       $(".clidata").css('background-color','');
                        var obj = $(this);
                        var pid = obj.attr('data_id');  
                        var uid = obj.attr('data_uid');
                        var namev = obj.children('a').text();
                        obj.css('background-color','red');
                        $("#puid").val(uid);
                        $("#puid").attr('namev',namev);
                      });
                  }
                  
              },'json');   
        }
        $("#confirm").click(function(){
            var thisid = $("#thisid").val();
            var puid = $("#puid").val();   
            if(thisid && puid){
                $.post("<?php echo U('updatepidm');?>",{id:thisid,puid:puid},function(result){
                  if(result.ret ==0){
                    $('#close1').trigger("click");
                    window.location.href="<?php echo U('index');?>";
                  }
                  
              },'json');     
            }
        });
        
        
        //导航高亮
        highlight_subnav("<?php echo U('User/daili');?>");
    </script>

</body>
</html>