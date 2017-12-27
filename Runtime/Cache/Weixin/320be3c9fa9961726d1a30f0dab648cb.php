<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" href="/Public/Weixin/css/common.css"> -->
    <link rel="stylesheet" type="text/css" href="/Public/Weixin/css/swiper.min.css"/>
    <link rel="stylesheet" href="/Public/Weixin/css/newhome.css">
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
</head>
<body>
<div class="mainall">

    <div class="bg">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if(is_array($data["indexImgs"])): $i = 0; $__LIST__ = $data["indexImgs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                    <?php if($vo['url'] != ''): ?><a href="<?php echo ($vo["url"]); ?>"><?php endif; ?>
                    <img src="<?php echo ($vo["path"]); ?>" />
                    <?php if($vo['url'] != ''): ?></a><?php endif; ?>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="bgbottom fnTimeCountDown" data-end="<?php echo ($data["time_end"]); ?>">
        <img src="/Public/Weixin/images/laba_03.png" alt="">
        开战倒计时： <span class="hour">00</span>:<span class="mini">00</span>:<span class="sec">00</span>
        <!--:<span class="hm">000</span>-->
    </div>
    <p class="fnTimeCountDown1" data-end="<?php echo ($data["time_end"]); ?>" style="display: none">
        开战倒计时： <span class="mini">00</span>:<span class="sec">00</span>
        :<span class="hm">000</span>
    </p>
    
    <div class="tab-img">
        <div class="active">50元卡</div>
        <div>100元卡</div>
        <!--<div>某某卡</div>-->
    </div>
    <div class="tab-ul">
        <ul class="list-li active">
            <?php if(is_array($data["list_50"])): $i = 0; $__LIST__ = $data["list_50"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                    <a href="<?php echo U('Goods/detail?id='.$vo['id']);?>">
                        <img src="<?php echo (get_cover($vo["cover_id"],'path')); ?>" alt="">
                    </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <ul class="list-li">
            <?php if(is_array($data["list_100"])): $i = 0; $__LIST__ = $data["list_100"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                    <a href="<?php echo U('Goods/detail?id='.$vo['id']);?>">
                        <img src="<?php echo (get_cover($vo["cover_id"],'path')); ?>" alt="">
                    </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>

    </div>
    <!--<div class="tejia">-->
        <!--<a href="http://www.nike.com/cn/zh_cn/c/nike-plus"><img src="<?php echo ($data["indexGoods"]["path"]); ?>" alt=""></a>-->
    <!--</div>-->
    <div class="tab-index">
        <div class="active">
            最近抢购记录
        </div>
        <!--<div onclick="location.href='/Weixin/Index/introduce'">玩法规则</div>-->
        <div>
            最新战绩
        </div>       
    </div>
    <div class="tab-con">
        <ul class="lis"  >
            <?php if(is_array($data["buy_list"])): $i = 0; $__LIST__ = $data["buy_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><a href="<?php echo U('My/buyLog?uid='.$vo1['userinfo']['uid']);?>">
                    <li>
                    <div class="lf">
                        <img src="<?php echo ($vo1["userinfo"]["headimgurl"]); ?>" alt="">
                    </div>
                    <div class="lm">
                        <div class="lm-head">
                            <p class="lmh" style="text-overflow: ellipsis;width: 8.8rem;"><?php echo ($vo1["userinfo"]["nickname"]); ?></p>
                             <p class="lmt"><?php echo (date('Y-m-d H:i',$vo1["buy_time"])); ?></p>
                        </div>
                        
                        <p class="lm-gwk"><?php echo ($vo1["goods_title"]); ?>    抢购第<?php echo ($vo1["period"]); ?>期    单×<?php echo ($vo1["buy_num"]); ?>  <?php echo ($vo1["type"]); ?></p>
                       
                    </div>
                        <!--<div class="lt">
                            <p class="lt1"><span><?php echo ($vo["num"]); ?></span>单</p><p class="lt2">参与</p>
                        </div>-->
                    </li>
                </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <ul class="lis" style="display:none">
            <?php if(is_array($data["pk_list"])): $i = 0; $__LIST__ = $data["pk_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('My/exchangeList?uid='.$vo['userinfo']['uid']);?>"><li>
                    <div class="lf">
                        <img src="<?php echo ($vo["userinfo"]["headimgurl"]); ?>" alt="">
                    </div>
                    <div class="lm">
                        <div class="lm-head">
                            <p class="lmh" style="text-overflow: ellipsis;width: 8.8rem;"><?php echo ($vo["userinfo"]["nickname"]); ?></p>
                             <p class="lmt"><?php echo (date('Y-m-d H:i',$vo["buy_time"])); ?></p>
                        </div>
                        
                        <p class="lm-gwk"><?php echo ($vo["goods_title"]); ?>    中奖第<?php echo ($vo["period"]); ?>期    单×<?php echo ($vo["buy_num"]); ?>  <?php echo ($vo["type"]); ?></p>
                       
                    </div>
                    <!--<div class="lt">
                        <p class="lt1"><span><?php echo ($vo["num"]); ?></span>单</p><p class="lt2">参与</p>
                    </div>-->
                </li>
            </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
          
        <!--<ul class="list">-->
            <!--<li class="list-head">-->
                <!--<p><a>开奖时间</a></p>-->
                <!--<p><a>开奖号码</a></p>-->
                <!--<p><a>50元区</a></p>-->
                <!--<p><a>100元区</a></p>-->
            <!--</li>-->
            <!--<?php if(is_array($data["code_list"])): $i = 0; $__LIST__ = $data["code_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                <!--<li>-->
                    <!--<div class="li1">-->
                        <!--<p class="p-1"><?php echo ($vo['create_time'][0]); ?></p>-->
                        <!--<p class="p-2"><?php echo ($vo['create_time'][1]); ?></p>-->
                    <!--</div>-->
                    <!--<div class="li2"><?php echo ($vo["code"]); ?></div>-->
                    <!--<div class="li3"><p><?php echo ($vo["code_56"]); ?>&nbsp;&nbsp;<?php echo ($vo["code_56_type"]); ?></p></div>-->
                    <!--<div class="li3 li4"><p><?php echo ($vo["code_110"]); ?>&nbsp;&nbsp;<?php echo ($vo["code_110_type"]); ?></p></div>-->
                <!--</li>-->
            <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
        <!--</ul>-->

    </div>
    <div  id="reload_more" onclick="reload_more();">点击加载更多</div>  
</div>
<div class="menu_fixed">
    <div class="bottom_menu" id="main">
        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon_red.png" alt=""></span>
        <span class="menu_bottom_font font-red">首页</span>
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
        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-person.png" alt=""></span>
        <span class="menu_bottom_font ">个人中心</span>
    </div>
</div>
<!--<script type="text/javascript" src="/Public/Weixin/js/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="/Public/Weixin/js/zepto.min.js"></script>
<script src="/Public/Weixin/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Weixin/js/countdown.js"></script>
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
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 3000
    });
    $(".tab-img div").tap(function(){
        var i=$(this).index();
        console.log(i);
        $(".tab-img div").eq(i).addClass('active').siblings().removeClass('active');
        $(".tab-ul ul").eq(i).addClass('active').siblings().removeClass('active');
    })
    $(".tab-index div").tap(function(){
        var i=$(this).index();
        $(".tab-index div").eq(i).addClass('active').siblings().removeClass('active');
        $(".tab-con ul").eq(i).show().siblings().hide();
    })
    function tCDThml(element) {
        var second = 9;
        var time = setInterval(function(){
            second--;
            element.html("正在揭晓&nbsp;&nbsp;"+second);
            if (second == 0) {
                clearInterval(time);
            };
        },1000);
    };
    function mat(date) {
        var datetime = date.getFullYear()
                + "-"// "年"
                + ((date.getMonth() + 1) > 10 ? (date.getMonth() + 1) : "0"
                + (date.getMonth() + 1))
                + "-"// "月"
                + (date.getDate() < 10 ? "0" + date.getDate() : date
                        .getDate());
        return datetime;
    }

    Date.prototype.Format = function(fmt) { //author: meizz
        var o = {
            "M+" : this.getMonth() + 1, //月份
            "d+" : this.getDate(), //日
            "h+" : this.getHours(), //小时
            "m+" : this.getMinutes(), //分
            "s+" : this.getSeconds(), //秒
            "q+" : Math.floor((this.getMonth() + 3) / 3), //季度
            "S" : this.getMilliseconds()
            //毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "")
                    .substr(4 - RegExp.$1.length));
        for ( var k in o)
            if (new RegExp("(" + k + ")").test(fmt))
                fmt = fmt.replace(RegExp.$1,
                        (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k])
                                .substr(("" + o[k]).length)));
        return fmt;
    }

    $(function() {
        // 倒计时
        var date = new Date();
        var as=10;
        if((date.getHours()>=22||date.getHours()<1||(date.getHours()==1&&date.getMinutes()<=55))){
            as=5;
        }
        //开奖时间为10：00 --02：00
        if((date.getHours()>=2&&date.getHours()<10)||(date.getHours()==1&&date.getMinutes()>55)){
            $(".fnTimeCountDown").fnTimeCountDown(tCDThml);

            $(".fnTimeCountDown1").fnTimeCountDown(function() {
                location.href = location;
            });
        }else{
            if (date.getMinutes()%as==0&&date.getSeconds() < 8) {
                var second = 8 - date.getSeconds();
                console.log(second);
                var time = setInterval(function(){
                    second--;
                    $(".fnTimeCountDown").html("正在揭晓&nbsp;&nbsp;"+second);
                    if (second == 0) {
                        clearInterval(time);
                    };
                },1000);
                setTimeout(function() {
                    location.href = location;
                }, (8 - date.getSeconds()) * 1000);
            }else{
                $(".fnTimeCountDown").fnTimeCountDown(tCDThml);

                $(".fnTimeCountDown1").fnTimeCountDown(function() {
                    location.href = location;
                });
            }
        }


    })
    //点击加载更多
    var num1=1,num2=1;
    function reload_more(){
        var num=0;
        $(".lis").each(function(i){
            if($(this).css("display")=="block"){
                num=i;
            }
        });
        $.ajax({
            type:"POST",
            url:'<?php echo U("Index/reloadMore");?>',
            datetype:"json",
            data:"num="+num+"&num1="+num1+"&num2="+num2,
            success:function(data){
                //console.log(data);
                if(data.more=='yes'){
                    var obj = num==0?data.buy_list:data.pk_list;
                    var child='';
                    for(var i=0;i<obj.length;i++){
                        //console.log(obj[i].uid);
                        var id='<?php echo U("My/buyLog");?>?uid='+obj[i].uid;
                        var times=new Date(parseInt(obj[i].buy_time)*1000);
                        var buy_time=times.getFullYear()+"-"+(times.getMonth()+1)+"-"+times.getDate()+"  "+times.getHours()+":"
                                    +times.getMinutes()+":" +times.getSeconds();
                            child += '<a href="'+id+'"><li>'
                                +'<div class="lf">';
                            //console.log(Object.keys(obj[i].userinfo).length);
                            if(Object.keys(obj[i].userinfo).length)
                                child+='<img src="'+obj[i].userinfo.headimgurl+'" alt="">';
                            else
                                child+='<img src="" alt="">';
                            child+='</div><div class="lm"><div class="lm-head">'
                                +'<p class="lmh" >';
                            if(Object.keys(obj[i].userinfo).length)
                                child+=obj[i].userinfo.nickname.substr(0,9);
                            child+='</p>'
                                 +'<p class="lmt">'+buy_time+'</p></div>'
                                +'<p class="lm-gwk" >'+obj[i].goods_title;
                            if(num==0){
                                child+='    购买第'+obj[i].period+'期    单×'+obj[i].buy_num+'  '+obj[i].type+'</p>';
                            }else{
                                child+='    中奖第'+obj[i].period+'期    单×'+obj[i].buy_num+'  '+obj[i].codeid+'</p>'
                            }
                           child +='</div></li></a>';
                    }
                    $(".lis").eq(num).append(child);
                    if(num==0)
                        num1++;
                    else
                        num2++;
                }else{
                    $(".lm-gwk").html('别点了，已经到底了！')
                }
            }
        });
    }
</script>

</body>
</html>