<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */
return array (
    'URL_MODEL' => 3 , //URL模式
    'URL_HTML_SUFFIX' => '' ,

    'URL_ROUTER_ON' => TRUE ,               //开启路由
    'URL_ROUTE_RULES' => array ( //定义路由规则
//                                 'detail/:id' => 'Goods/detail' ,
//                                 'explain' => 'News/explain' ,
//                                 'goods' => 'Goods/goodsList' ,
//                                 'bidding/:id' => 'Goods/bidding' ,
//                                 'dobidding' => 'Goods/doBidding' ,
//                                 'dofinish' => 'Goods/doFinish' ,
//                                 'news/:id' => 'News/detail' ,
//                                 'my' => 'My/index' ,
//                                 'mydata' => 'My/userData' ,
//                                 'doedit' => 'My/doEdit' ,
//                                 'records' => 'Records/recordList' ,
//                                 'pricelog/:id' => 'Records/priceLog' ,
//                                 'orders' => 'Records/orders' ,
//                                 'getdetail/:id' => 'Records/getDetail' ,
//                                 'like' => 'Records/like' ,
//                                 'dolike' => 'Records/doLike' ,
//                                 'news' => 'News/newsList' ,
//                                 'register' => 'User/register' ,
//                                 'login' => 'User/login' ,
//                                 'logout' => 'User/logout' ,
//                                 'index' => 'Index/index' ,
    ) ,

    // 预先加载的标签库
    'TAGLIB_PRE_LOAD' => 'OT\\TagLib\\Article,OT\\TagLib\\Think' ,

    /* 主题设置 */
    'DEFAULT_THEME' => 'default' ,  // 默认模板主题名称

    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX' => 'onethink_' , // 缓存前缀
    'DATA_CACHE_TYPE' => 'File' , // 数据缓存类型 

    /* 文件上传相关配置 */
    'DOWNLOAD_UPLOAD' => array (
        'mimes' => '' , //允许上传的文件MiMe类型
        'maxSize' => 5 * 1024 * 1024 , //上传的文件大小限制 (0-不做限制)
        'exts' => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml' , //允许上传的文件后缀
        'autoSub' => TRUE , //自动子目录保存文件
        'subName' => array ('date' , 'Y-m-d') , //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Download/' , //保存根路径
        'savePath' => '' , //保存路径
        'saveName' => array ('uniqid' , '') , //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '' , //文件保存后缀，空则使用原后缀
        'replace' => FALSE , //存在同名是否覆盖
        'hash' => TRUE , //是否生成hash编码
        'callback' => FALSE , //检测文件是否存在回调函数，如果存在返回文件信息数组
    ) , //下载模型上传配置（文件上传类配置）

    /* 编辑器图片上传相关配置 */
    'EDITOR_UPLOAD' => array (
        'mimes' => '' , //允许上传的文件MiMe类型
        'maxSize' => 2 * 1024 * 1024 , //上传的文件大小限制 (0-不做限制)
        'exts' => 'jpg,gif,png,jpeg' , //允许上传的文件后缀
        'autoSub' => TRUE , //自动子目录保存文件
        'subName' => array ('date' , 'Y-m-d') , //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Editor/' , //保存根路径
        'savePath' => '' , //保存路径
        'saveName' => array ('uniqid' , '') , //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '' , //文件保存后缀，空则使用原后缀
        'replace' => FALSE , //存在同名是否覆盖
        'hash' => TRUE , //是否生成hash编码
        'callback' => FALSE , //检测文件是否存在回调函数，如果存在返回文件信息数组
    ) ,

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array (
        '__STATIC__' => __ROOT__ . '/Public/static' ,
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons' ,
        '__IMG__' => __ROOT__ . '/Public/' . MODULE_NAME . '/images' ,
        '__CSS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/css' ,
        '__JS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/js' ,
    ) ,

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'onethink_home' , //session前缀
    'COOKIE_PREFIX' => 'onethink_home_' , // Cookie前缀 避免冲突

    /**
     * 附件相关配置
     * 附件是规划在插件中的，所以附件的配置暂时写到这里
     * 后期会移动到数据库进行管理
     */
    'ATTACHMENT_DEFAULT' => array (
        'is_upload' => TRUE ,
        'allow_type' => '0,1,2' , //允许的附件类型 (0-目录，1-外链，2-文件)
        'driver' => 'Local' , //上传驱动
        'driver_config' => NULL , //驱动配置
    ) , //附件默认配置


    'ATTACHMENT_UPLOAD' => array (
        'mimes' => '' , //允许上传的文件MiMe类型
        'maxSize' => 5 * 1024 * 1024 , //上传的文件大小限制 (0-不做限制)
        'exts' => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml' , //允许上传的文件后缀
        'autoSub' => TRUE , //自动子目录保存文件
        'subName' => array ('date' , 'Y-m-d') , //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Attachment/' , //保存根路径
        'savePath' => '' , //保存路径
        'saveName' => array ('uniqid' , '') , //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '' , //文件保存后缀，空则使用原后缀
        'replace' => FALSE , //存在同名是否覆盖
        'hash' => TRUE , //是否生成hash编码
        'callback' => FALSE , //检测文件是否存在回调函数，如果存在返回文件信息数组
    ) , //附件上传配置（文件上传类配置）

    // 配置邮件发送服务器,演示用
    // 'MAIL_HOST' =>'smtp.exmail.qq.com',//smtp服务器的名称
    // 'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    //'MAIL_USERNAME' =>'jufengjituan@gsjfjt.com',//你的邮箱名
    //'MAIL_FROM' =>'jufengjituan@gsjfjt.com',//发件人地址
    //'MAIL_FROMNAME'=>'聚丰集团',//发件人姓名
    // 'MAIL_PASSWORD' =>'******',//邮箱密码
    // 'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    //'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件

    /* 支付设置 */
    'payment' => array (
        'tenpay' => array (
            // 加密key，开通财付通账户后给予
            'key' => C('TENPAYKEY') ,
            // 合作者ID，财付通有该配置，开通财付通账户后给予
            'partner' => C('TENPAYPARTNER')
        ) ,
        'alipay' => array (
            // 收款账号邮箱
            'email' => C('ALIPAYEMAIL') ,
            // 加密key，开通支付宝账户后给予
            'key' => C('ALIPAYKEY') ,
            // 合作者ID，支付宝有该配置，开通易宝账户后给予
            'partner' => C('ALIPAYPARTNER')
        ) ,
        'palpay' => array (
            'business' => C('PALPAYPARTNER')
        ) ,
        'yeepay' => array (
            'key' => C('YEEPAYPARTNER') ,
            'partner' => C('YEEPAYKEY')
        ) ,
        'kuaiqian' => array (
            'key' => C('KUAIQIANPARTNER') ,
            'partner' => C('KUAIQIANKEY')
        ) ,
        'unionpay' => array (
            'key' => C('UNIONPARTNER') ,
            'partner' => C('UNIONKEY')
        )
    ) ,
    //支付宝配置参数
    'alipay_config' => array (
        'partner' => C('ALIPAYPARTNER') ,   //这里是你在成功申请支付宝接口后获取到的PID,通过后台配置读取；
        'key' => C('ALIPAYKEY') ,//这里是你在成功申请支付宝接口后获取到的Key.通过后台配置读取
        'sign_type' => strtoupper('MD5') ,
        'input_charset' => strtolower('utf-8') ,
        'cacert' => getcwd() . '\\cacert.pem' ,
        'transport' => 'http' ,
    ) ,
    //以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；

    'alipay' => array (
        //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
        'seller_email' => 'pay@xxx.com' ,
        //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
        'notify_url' => 'http://www.ijquery.net/Pay/notifyurl' ,
        //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
        'return_url' => 'http://www.ijquery.net/Pay/returnurl' ,
        //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
        'successpage' => 'User/myorder?ordtype=payed' ,
        //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
        'errorpage' => 'User/myorder?ordtype=unpay' ,
    ),

    //workman连接服务端url
    'workman_url' => 'http://auction.akng.net:2121/',
    'weixin' =>array(
        'appid' =>'wxc624a047e450f940',
        'secret'=>'01efa246da38ce6e918e2afa5c9e98dc',
    ),
    'SHOW_PAGE_TRACE' =>false, 
);


