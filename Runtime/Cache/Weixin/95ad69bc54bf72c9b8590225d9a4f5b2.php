<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>走势图</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" href="/Public/Weixin/css/common.css"> -->
    <link rel="stylesheet" type="text/css" href="/Public/Weixin/css/swiper.min.css"/>
    <link rel="stylesheet" href="/Public/Weixin/css/base.css">
    <link rel="stylesheet" href="/Public/Weixin/css/newflow.css">
</head>

<body>

<div class="mainall">
    <ul class="con">

        <li><a href="#">时间</a></li>

        <li><a href="#">号码</a></li>

        <li><a href="#">50元区</a></li>

        <li><a href="#">100元区</a></li>

    </ul>
    <div class="data">

        <p class="fnTimeCountDown" data-end="<?php echo ($data["time_end"]); ?>">

            开战倒计时： <span class="hour">00</span>:<span class="mini">00</span>:<span class="sec">00</span>

            <!--:<span class="hm">000</span>-->

        </p>

        <p class="fnTimeCountDown1" data-end="<?php echo ($data["time_end"]); ?>" style="display: none">

            开战倒计时： <span class="mini">00</span>:<span class="sec">00</span>

            :<span class="hm">000</span>

        </p>

    </div>

    <div class="list">

        <ul>

            <?php if(is_array($data["code_list"])): $i = 0; $__LIST__ = $data["code_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--
                <span style="font-size:12px;" >
                &nbsp;&nbsp;<?php echo ($vo["czh"]); ?>/<?php echo ($vo["province"]); ?>/<?php echo ($vo["company"]); ?>/<?php echo ($vo["info"]); ?>
                </span>   -->
                <li>

                    <div class="li1">
                        <p class="p-1"><?php echo ($vo['create_time'][0]); ?></p>
                        <p class="p-2"><?php echo ($vo['create_time'][1]); ?></p>
                    </div>

                    <div class="li2">
                    <?php echo ($vo["code"]); ?>
                    </div>

                    <div class="li3"><p <?php if($vo['code_56_type'] == '双'): ?>style="background:#C22631"<?php else: ?>style="background:#F5A623 "<?php endif; ?> ><?php echo ($vo["code_56"]); ?>&nbsp;&nbsp;<?php echo ($vo["code_56_type"]); ?></p></div>

                    <div class="li3 li4"><p <?php if($vo['code_110_type'] == '双'): ?>style="background:#C22631"<?php else: ?>style="background:#F5A623 "<?php endif; ?>><?php echo ($vo["code_110"]); ?>&nbsp;&nbsp;<?php echo ($vo["code_110_type"]); ?></p></div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>

        </ul>

    </div>

    <!--<div class="qiang">-->

        <!--<img src="/Public/Weixin/images/qiangbao_03.png" alt="">-->

    <!--</div>-->

    <!--<div class="hot">-->

        <!--<div class="wrap">-->

            <!--<div>-->

                <!--<p class="title">热门商品推荐</p>-->

            <!--</div>-->

            <!--<div class="ulimg">-->

                <!--<ul class="img">-->

                    <!--<?php if(is_array($data["list"])): $i = 0; $__LIST__ = $data["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->

                        <!--<li><a href="<?php echo U('Goods/detail?id='.$vo['id']);?>"><img src="<?php echo (get_cover($vo["cover_id"],'path')); ?>" alt=""></a></li>-->

                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->

                <!--</ul>-->

            <!--</div>-->

            <!--<div class="icon flex_row">-->

                <!--<img src="/Public/Weixin/images/1.png" alt="">-->

            <!--</div>-->

        <!--</div>-->



    <!--</div>-->

</div>

<div class="menu_fixed">
    <div class="bottom_menu" id="main">
        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-main.png" alt=""></span>
        <span class="menu_bottom_font ">首页</span>
    </div>
    <div class="bottom_menu" id="flow">
        <span class="menu_bottom_img"><img src="/Public/Weixin/images/icon-flows.png" alt=""></span>
        <span class="menu_bottom_font font-red">走势图</span>
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

<script type="text/javascript" src="/Public/Weixin/js/countdown.js"></script>

<script type="text/javascript">
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

    $(function(){

        var mo=function(e){e.preventDefault();};

        function stop(){

            document.body.style.overflow='hidden';

            document.addEventListener("touchmove",mo,false);//禁止页面滑动

        }

        function move(){

            document.body.style.overflow='';//出现滚动条

            document.removeEventListener("touchmove",mo,false);

        }

        move();

        $('.icon').tap(function(){

            $('.hot').animate({

                left:"-10rem"

            },1000,function(){

                $(".wrap").hide();

            })

        })



        $(".qiang").click(function(){

            $('.hot').animate({

                left:"0rem"

            },1000,function(){

                $(".wrap").show();

            })

        });



    })

</script>



<script>



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

</script>





</body>

</html>