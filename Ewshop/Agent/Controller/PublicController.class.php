<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Agent\Controller;
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
           
			    $user = M('UcenterMember');
			    $arruser = $user->where(sprintf("username = '%s'", $username))->find();
			   //print_r($arruser);exit;
			   //判断是否是代理商
			   if($arruser){
			        $isagent = M('Join')->where(sprintf("uid = %d",$arruser['id']))->find();
			        if(empty($isagent)){
			              $this->error('非代理商，无权限');
			        }
			   }
			   
			    $user = new UserApi;
                $pass = think_ucenter_md5($password, UC_AUTH_KEY);
                // var_dump($pass);exit;
                if($arruser['password'] == $pass){ //UC登录成功
                    $_SESSION['user_agent'] = $arruser;
                    /* 登录用户 */
                      $this->success('登录成功！', U('AgentManage/index'));
                    
                }else{
                     $this->error('密码错误');
                }		
        } else {
            if(empty($_SESSION['user_agent'])){
                $_SESSION['user_agent'] =array('0');
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
    
     public function resetps(){ 
        $mobile = I('username');
        $password = I('password');
        $repassword = I('repassword');
        if($mobile){
            $Member = D('UcenterMember');
            if($password != $repassword){
                $this->error('修改失败,用户密码不一致！');  
                    
            }
                 $User = new UserApi;
    			$data['password'] = think_ucenter_md5($password,UC_AUTH_KEY);//公司名称
    			$ret = $Member->where(sprintf("username = '%s'",$mobile))->save($data);	
    			if($ret){
    			     $this->success('修改成功！' , U('Public/login'));    
    			}
	    }
	    $_SESSION['send_code'] = random(6 , 1);  
		$this->display();
    }
    public function sendphone(){
        $phone = $_POST['phone'];
        if (empty($phone)) {
            $return = array ("status" => 0 , "info" => '手机号不正确');
            header('Content-type: text/html; charset=UTF-8');
            $this->ajaxreturn($return);
            exit();
        }

        $oldphone = $_GET['oldphone'];//修改手机号操作：原手机号码
        if ($oldphone) {
            if ($phone == $oldphone) {
                $return = array ("status" => 0 , "info" => '请填写新的手机号码');
                $this->ajaxreturn($return);
                exit();
            }
        }

        $mobile_code = random(4 , 1);//生成手机验证码
        $send_code   = (!empty($_SESSION['send_code'])) ? $_SESSION['send_code'] : '8888';//获取提交随机加密码
        $content     = "您的短信验证码为：" . $mobile_code . "，有效期一小时。【翔傲元】";
        $result      = sendsmscode($phone , $content , $send_code , $mobile_code);

        $this->ajaxreturn($result);

    }
     public function checkphone(){
       if (trim($_POST['miss']) == $_SESSION['mobile_code']) {
            $return = array ("status" => 1 , "info" => "");
        } else {
            $return = array ("status" => 0 , "info" => '验证码不正确');
        }
        $this->ajaxreturn($return);
    }

	

}
