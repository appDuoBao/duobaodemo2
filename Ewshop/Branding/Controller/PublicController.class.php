<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Branding\Controller;
use User\Api\UserApi;

/**
 * 后台首页控制器
 * @author ew_xiaoxiao
 */
class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     * @author ew_xiaoxiao
     */
    public function login($username = null, $password = null, $verify = null){
        
        if(IS_POST){         
           
			    $user = M('BrandingMember');
			    $arruser = $user->where(sprintf("username = '%s'", $username))->find();
			   // print_r($arruser);exit;
			    $user = new UserApi;
                $pass = think_ucenter_md5($password, UC_AUTH_KEY);
                // var_dump($pass);exit;
                if($arruser['password'] == $pass){ //UC登录成功
                    $_SESSION['user_brand'] = $arruser;
                    /* 登录用户 */
                      $this->success('登录成功！', U('BrandingManage/index'));
                    
                }else{
                     $this->error('密码错误');
                }		
        } else {
            if(empty($_SESSION['user_brand'])){
                $_SESSION['user_brand'] =array('0');
                $this->redirect('Index/index');
            }else{
                /* 读取数据库中的配置 */
                $config	=	S('DB_CONFIG_DATA');
                if(!$config){
                    $config	=	D('Config')->lists();
                    S('DB_CONFIG_DATA',$config);
                }
                C($config); //添加配置
               
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Admin')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }

}
