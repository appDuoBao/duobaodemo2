<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=750, target-densitydpi=284, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta charset="utf-8">
    <title>我的银行卡</title>
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Pay/css/base.css">
    <link rel="stylesheet" href="/duobao/app/duobaodemo2/Public/Pay/css/bank_card.css">
    <script src="/duobao/app/duobaodemo2/Public/Pay/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div class="card_content">
        <span class="card_name">持卡人：</span>
        <input type="text" placeholder="请输入持卡人姓名" name="username" value="<?php echo ($username); ?>">
    </div>
    <div class="card_content">
        <span class="card_name">银行：</span>
        <select id="bank_name">
            <option value="请选择">请选择</option>
            <option value="工商银行">工商银行</option>
            <option value="中国银行">中国银行</option>
            <option value="建设银行">建设银行</option>
            <option value="民生银行">民生银行</option>
            <option value="招商银行">招商银行</option>
            <option value="农业银行">农业银行</option>
            <option value="浦发银行">光大银行</option>
            <option value="兴业银行">兴业银行</option>
            <option value="北京银行">北京银行</option>
        </select>
    </div>
    <div class="card_content">
        <span class="card_name">开户行：</span>
        <input type="text" placeholder="如四川省成都市春熙路支行">
    </div>
    <div class="card_content">
        <span class="card_name">卡号：</span>
        <input id="bank_no" name="card_no" value="<?php echo ($cardno); ?>" type="text" placeHolder="请输入16或19位银行卡号">
    </div>
    <div class="card_content">
        <span class="card_name">手机号：</span>
        <input id="mobile" name="mobile" type="text" placeHolder="请输入银行卡绑定手机号">
    </div>
    <div class="card_content">
        <span class="card_name">验证码：</span>
        <input id="check_code" name="check_code" style="width:377px;" type="text" placeHolder="请输入短信验证码">
        <span id="sendma" class="get_code" onclick="sendphone()">获取验证码</span>
    </div>
    <div class="showerror">
        <span id="showinfo"></span>
    </div>
    <div class="zhu">注：1 如果您不知道开户行，请拨打卡所属客服电话进行查询<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2 仅支持借记卡， 不支持信用卡
    </div>
    <div class="save_btn">保存</div>
</body>
</html>
<script>
    function sendphone(){
        var phone=$("#mobile").val();
        if(!(/^1[34578]\d{9}$/.test(phone))){
            err_msg('不正确的手机号码', 'mobile');
            return false;
        }
        if($('#dmobile').html()=="手机号已经被使用" || $('#dmobile').html()=="短信已发送") {
            return false;
        }
        $.ajax({
            type:'post', //传送的方式,get/post
            url:'<?php echo U("index/sendcode");?>', //发送数据的地址
            data:{phone:phone},
            dataType: "json",
            success:function(data){
                err_msg(data.info, 'mobile');
            }
        })
         document.getElementById('sendma').style.color = '#cdced0';
         backcount();
   }  
   var secs = 60;
    function backcount(){
        $(".get_code").attr("onClick",'');
        for(i=1;i<=secs;i++) {
            window.setTimeout("update1(" + i + ")", i * 1000);
        }
    }  
    function err_msg(str, id) {
        document.getElementById('showinfo').style.display = "inline-block";
        document.getElementById('showinfo').style.color = "#F00";
        //document.getElementById('showinfo').style.font-size = "12px";
        document.getElementById('showinfo').innerHTML=str;
    }
     function update1(num) {
        if(num == secs) {
            $("#sendma").html('获取验证码');
            $("#sendma").addClass('background-color','#f70e8f');
            $("#sendma").attr("onClick",'sendphone();');
        }else {
            printnr = secs-num;
            $("#sendma").html("(" + printnr +")秒后重发");
        }
    }
</script>