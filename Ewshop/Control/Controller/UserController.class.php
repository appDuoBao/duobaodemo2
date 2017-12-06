<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Control\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author ew_xiaoxiao
 */
class UserController extends ControlController {

    /**
     * 用户管理首页
     * @author ew_xiaoxiao
     */
    public function index(){
        //当前管理员id
        $gid = $_SESSION['onethink_admin']['user_auth']['uid'];
        $groupid = M('admin')->where(array('uid'=>$gid))->getField('groupid');
        if($groupid == 7){    //是企业分销管理员
            $uid = M('Join')->where(array('gid'=>$gid,'is_delete'=>0,'status'=>1))->getField('uid');
            $map['parent_id'] = $uid;
        }
		
        $mobile = I('mobile');
        $mobile = trim($mobile);
        if ($mobile) {
            $uid = M('UcenterMember')->field("id")->where("mobile='".$mobile."'")->select();
            $uid = $uid ? $uid :  M('Member')->field('uid as id')->where('nickname like "%'.$mobile.'%"')->select();
            $newuid = "";
            if ($uid) {
                foreach ($uid as $b) {
                    $newuid[] = $b['id'];
                }
                $map['uid'] = array("in", $newuid);
            }
        }		
		
		
		$nickname      = I('nickname');
		$nickname      = trim($nickname);
        $map['status'] = array ('egt' , 0);
        $map['nickname'] = array ('like' , '%' . (string) $nickname . '%');
        $list = $this->lists('Member' , $map);
		$join_user_id = M('Join')->where(array('is_delete'=>0,'status'=>1))->getField('uid',true);
		
        foreach ($list as $key => $val) {
            $list[$key]['mobile'] = M('UcenterMember')->where("id='$val[uid]'")->getField("mobile");
            $list[$key]['email']  = M('UcenterMember')->where("id='$val[uid]'")->getField("email");
	    $list[$key]['usertype'] = '普通会员';		
		$this->assign('usertype' , $usertype);			
        }
        int_to_string($list);

        $this->assign('_list' , $list);
        $this->meta_title = '用户信息';
        $this->display();
    }


    /**
     * 代理商管理
     * @author ew_xiaoxiao
     */
    public function daili(){
        
        $jointype = I('status');
		if($jointype){
		    $mapj['parent_id'] = array('neq',0);    
		}else{
		    $mapj['parent_id'] = array('eq',0);    
		}
        $mapj['status'] = array('eq',1);
        $mapj['is_delete'] = array('eq',0);
		$join_user_id = M('Join')->where($mapj)->getField('uid',true);
		if($join_user_id){
			$map['uid'] = array("in", $join_user_id);
		}	
        $mobile = I('mobile');
        $mobile = trim($mobile);
        if ($mobile) {
            $uid = M('UcenterMember')->field("id")->where("mobile=".$mobile)->select();
            $newuid = "";
            if ($uid) {
                foreach ($uid as $b) {
                    $newuid[] = $b['id'];
                }
                $map['uid'] = array("in", $newuid);
            }
        }		
			
		$nickname      = I('nickname');
		$nickname      = trim($nickname);
        $map['status'] = array ('egt' , 0);
        $map['nickname'] = array ('like' , '%' . (string) $nickname . '%');
		
        $list = $this->lists('Member' , $map);
		
		$join_user_id = M('Join')->where(array('is_delete'=>0,'status'=>1))->getField('uid',true);
        foreach ($list as $key => $val) {
            $list[$key]['mobile'] = M('UcenterMember')->where("id='$val[uid]'")->getField("mobile");
            $list[$key]['email']  = M('UcenterMember')->where("id='$val[uid]'")->getField("email");
		        
			if($jointype){
				$list[$key]['usertype'] = '普通代理';
			}else{
				$list[$key]['usertype'] = '总代理商';
			}			
        }
        int_to_string($list);

        $this->assign('_list' , $list);
        $this->meta_title = '代理商信息';
        $this->display();
    }
	
    /**
     * 分享会员
     * @author ew_xiaoxiao
     */
    public function fenxianguser($puid = NULL){
		$Member = D('Member');
		$info             = $Member->info($puid);
		$this->assign('username' , $info['nickname']);
        $map['parent_id'] = $puid;
        $list = $this->lists('Member' , $map);
        foreach ($list as $key => $val) {
            $list[$key]['mobile'] = M('UcenterMember')->where("id='$val[uid]'")->getField("mobile");
            $list[$key]['email']  = M('UcenterMember')->where("id='$val[uid]'")->getField("email");
        }
        int_to_string($list);
        $this->assign('_list' , $list);
        $this->meta_title = '分享会员';
        $this->display();
    }	
    public function agentinfo(){
            
            $pid = I("puid");
            $root = I("root_id");
            $uid = I("uid");
            if($pid || $root){
                $uids =array($pid,$root);
                $map['uid'] = array('in',$uids);
                $agent = M('Join')->where($map)->getField('uid,company,name,mobile,ratio,parent_id,ratio_type,address');
                $parents = ($pid) ? $agent[$pid] : '';
                $roots = ($root) ? $agent[$root] : '';
                $this->assign('parent',$parents);
                $this->assign('roots',$roots);
                $this->assign('uid',$uid);
            }
           // var_dump($parents);exit;
            $this->display('');
    }
    /**
     * 分佣明细
     * @author ew_xiaoxiao
     */
    public function fenyonglog($puid = NULL){
		$Member = D('Member');
		$info             = $Member->info($puid);
		$this->assign('userinfo' , $info);	
		
		$fxusers = getfxuser($puid);//当前会员下级会员 无限级别
		$fxuids = $puid;
        foreach ($fxusers as $key => $val) {
			if($fxuids==''){
				$fxuids = $val['uid'];
			}else{
				$fxuids = $fxuids.",".$val['uid'];	
			}
        }	
		$map['pid']  = array('in',$fxuids);
		$map['status']  = 1;//1佣金 2购买
		
			$start_date      = I('start_date') ? I('start_date') : date('Y-m-d');
		$end_date      = I('end_date') ? I('end_date') : date('Y-m-d') ;
		if($start_date && $end_date){
			$map['create_time'] = array(array('egt',strtotime($start_date)),array('lt',strtotime($end_date)+(24*60*60)));
		}elseif($start_date  && empty($end_date)){
			$map['create_time']  = array('egt',strtotime($start_date));
		}elseif($end_date && empty($start_date)){
			$map['create_time']  = array('lt',strtotime($end_date)+(24*60*60));
		}		
		//佣金总金额
		//$zong =M('AccountLog')->where($map)->Sum('money_p');
		$cur_ratio = M('Join')->where("uid='".$puid."'")->getField("ratio");
		//$map['pid'] = array('neq',0);
		//$alogs = M('AccountLog')->where($map)->select();
		$umap['uid'] = array('in',$fxuids);
		$name = $Member->where($umap)->getField('uid,nickname',true);
		
		$alogs = M('WinOrder')->where($map)->select();
		$zong = 0 ;
        foreach ($alogs as $key => $aval) {
			$tdcount = bcadd($aval['money'],$tdcount);
			
			$alogs[$key]['nickname'] = $name[$aval['uid']];
        }	
        $zong = bcmul($tdcount ,bcdiv($cur_ratio,100,4),4);
        $this->assign('ratio' , $cur_ratio);
		$this->assign('zong' , $zong);
		$this->assign('tdzongcount',$tdcount);
		
		//总销售金额（包含自己的销售额+所有下级的销售额）
		$zongcount = getxse($fxuids);
		$this->assign('zongcount' , $zongcount);			
				
		
        $this->assign('_list' , $alogs);
        $this->meta_title = '佣金记录';
        $this->display();
    }
    
     /**---begain new agnet fenyong logs----------------------**/
     /**
     * 分佣明细
     * @author bankie
     */
    public function orderlist($puid = NULL){
        
       
        $pid = I('puid');//var_dump($pid);exit;
        $agent_login = $pid;// 查看下级业绩 
        if(!$agent_login){
            $this->meta_title = '佣金记录';
            $this->display();   
        }
        $login = M('Join');
        $Member = D('Member');
        $loginfo = $login->where(sprintf('uid = %d',$agent_login))->find();
	    if($loginfo['join_type'] === '0'){//总代理,可以一次把所有用户数据取出,收益比例可能有特别
		     $alluser = $Member->where(sprintf('root_id = %d or uid = %d',$agent_login,$agent_login))->getField('uid,nickname',true); 
		     $uids = (is_array($alluser)) ? $alluser : array();
             $uids = array_merge(array_keys($alluser),array((int)$loginfo['uid']));//包括用户本身
		}else{ //非一级代理用户
		    
		     $uids = self::getAllUidsByParent($agent_login);
		     $uids = array_merge($uids,array((int)$agent_login));//代理本身需要计算进来
		     $alluser = $Member->where(sprintf('uid in (%s)',implode(',', $uids)))->getField('uid,nickname',true);
		}
		//var_dump($uids);exit;
	    //$this->assign('userinfo' , $info);	
		if(empty($uids)){
		    $this->meta_title = '佣金记录';
            $this->display();
		}
		$map['uid']  = array('in',$uids);
		$map['status']  = 1;//1佣金 2购买
		
		$start_date      = I('start_date') ? I('start_date') : date('Y-m-d');
		$end_date      = I('end_date') ? I('end_date') : date('Y-m-d') ;
		if($start_date && $end_date){
			$map['create_time'] = array(array('egt',strtotime($start_date)),array('lt',strtotime($end_date)+(24*60*60)));
		}elseif($start_date  && empty($end_date)){
			$map['create_time']  = array('egt',strtotime($start_date));
		}elseif($end_date && empty($start_date)){
			$map['create_time']  = array('lt',strtotime($end_date)+(24*60*60));
		}		
		//佣金总金额
		//$zong =M('AccountLog')->where($map)->Sum('money_p');var_dump($zong);exit;
		$cur_ratio =$loginfo["ratio"];
		
		//整理数据
		
		//var_dump($alogs);exit;				
		//计算总订单金额
		$allorder = M('WinOrder')->where($map)->Sum('money');
		$all_order = M('WinOrder')->where($map)->getField('id,num,uid,money,order_number,create_time,period,num,number_section');
		$alogs = $all_order;
		if($all_order){
		    $zmap['order_id'] =array('in',array_keys($all_order));
		    $is_winstate = M('WinExchange')->where($zmap)->getField('order_id,goods_id,buy_num',true);
    		foreach($alogs as $k=>$v){
    		    $alogs[$k]['nickname'] = $alluser[$v['uid']];
    		    if($is_winstate){
    		        foreach($is_winstate as $kk=>$vv){
    		            $is_win[$vv['goods_id']] = $vv['goods_id'];
    		            if($k == $vv['order_id']){
    		                  $alogs[$k]['is_win'] = '中奖';  break;
    		            }else{
    		                   $alogs[$k]['is_win'] = '未中奖';  
    		            }    
    		        }
    		    }else{  
    		        $alogs[$k]['is_win'] = '未中奖';
    		    }
    		}
      
    		//计算中奖金额
    		
    		if($is_winstate){
        		    $zjmap['id'] = array('in',array_keys($is_win));
        		    $zjorder = M('Document')->where($zjmap)->getField('id,real_price');
        		    foreach ($is_winstate as $k=>$v) {//总支出
                         $zhichu =bcadd($zhichu,bcmul($zjorder[$v['goods_id']],(int)$v['buy_num'],4),4);
                    } 
    		}
    		    $zhichu = $zhichu ? $zhichu : 0;
    		if($loginfo['ratio_type'] ==2){
    		    
    		    $lirun = bcsub($allorder,$zhichu,4);
    		    $sy = bcmul($lirun,bcdiv($cur_ratio,100,4),4);
    	    }else{
    	        $sy =   bcmul($allorder,bcdiv($cur_ratio,100,4),4);  
    	    }
    		//按比例收益,这地方计算不对，应该是减去商品本身的价格
	    }
		$this->assign('start_date',$start_date);
	    $this->assign('end_date',$end_date);
		$this->assign('uname',$loginfo['name']);
		$this->assign('cur_ratio',$cur_ratio);
		$this->assign('sy',$sy);
		$this->assign('zj',$zhichu);
		$this->assign('puid',$pid);
		$this->assign('zongcount',$allorder);
        $this->assign('_list' , $alogs);
        $this->meta_title = '佣金记录';
        $this->display();
    }
   private static function getAllUidsByParent($pid){
        if($pid){
            $joinuids = self::getUidsByjoin($pid);
		     if($joinuids){
		        foreach($joinuids as $k=>$v){
		            $uids[] = $v['uid'];    
		        }
		            
		            return $uids;
		     }
		}
            return array();
    }
  private static function getUidsByjoin($pid){
        global $memberlist; 
    	$map['parent_id']=$pid; 
    	$members = M('Join')->field('uid')->where($map)->select();
    	//根据id获取下级用户
    	if($members){
    		if($memberlist){
    			$memberlist = array_merge($memberlist, $members);
    		}else{
    			$memberlist = $members;	
    		}
    		foreach ($members as $k => $v ) {
    			self::getUidsByjoin($v['uid']);
    		}	
    	}
	    return $memberlist;
            
    }
    /**---------end ---------------------**/
    
	
    /**
     * 添加会员信息
     * @author ew_xiaoxiao
     */
    public function add($username = '' , $password = '' , $repassword = '' , $email = ''){
        if (IS_POST) {
            /* 检测密码 */
            if ($password != $repassword) {
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User = new UserApi;
            $uid  = $User->register($username , $password , $email);
            if (0 < $uid) { //注册成功
                $user = array ('uid' => $uid , 'nickname' => $username , 'status' => 1);
                if (!M('Member')->add($user)) {
                    $this->error('用户添加失败！');
                } else {
                    $this->success('用户添加成功！' , U('index'));
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = '新增用户';
            $this->display();
        }
    }

    /**
     * 修改会员信息
     * @author ew_xiaoxiao
     */
    public function edit($id = NULL , $pid = 0){
        $Member = D('Member');

        if (IS_POST) {
            $data['uid']      = $_POST['id'];
            $yzdata['password']   = $_POST['password'];
            $yzdata['repassword'] = $_POST['repassword'];
            $udata['email']       = $_POST['email'];
            $udata['mobile']      = $_POST['mobile'];
            $udata['id']          = $_POST['id'];

            //提交表单
            if ($yzdata['password'] || $yzdata['repassword']) {

                $udata['password']   = $yzdata['password'];
                $udata['repassword'] = $yzdata['repassword'];
                /* 检测密码 */
                if ($udata['password'] != $udata['repassword']) {
                    $this->error('密码和重复密码不一致！');
                }

                /* 调用注册接口注册用户 */
                $User = new UserApi;
                $uid  = $User->updateInfo($udata['id'] , $udata['password'] , $udata);

                if ($uid['status']) {
                    if (FALSE !== $Member->updatem($data)) {
                        $this->success('编辑成功！' , U('index'));
                    } else {
                        $error = $Member->getError();
                        $this->error(empty($error) ? '未知错误！' : $error);
                    }
                } else {
                    $this->error($this->showRegError($uid['info']));
                }
            } else {
                $User = new UserApi;
                $uid  = $User->updateInfo($udata['id'] , $udata['password'] , $udata);
                if ($uid['status']) {
                    if (FALSE !== $Member->updatem($data)) {
                        $this->success('编辑成功！' , U('index'));
                    } else {
                        $error = $Member->getError();
                        $this->error(empty($error) ? '未知错误！' : $error);
                    }
                }
            }
        } else {
            $info             = $id ? $Member->info($id) : '';
            $info['email']    = M('UcenterMember')->getFieldById($id , 'email');
            $info['mobile']   = M('UcenterMember')->getFieldById($id , 'mobile');
            $info['username'] = M('UcenterMember')->getFieldById($id , 'username');
            $this->assign('info' , $info);
            $this->meta_title = '编辑用户';
            $this->display();
        }
    }

    /**
     * 修改会员信息
     * @author ew_xiaoxiao
     */
    public function userview($puid = 0){
        $Member = D('Member');
		$info             = $puid ? $Member->info($puid) : '';
		$info['email']    = M('UcenterMember')->getFieldById($puid , 'email');
		$info['mobile']   = M('UcenterMember')->getFieldById($puid , 'mobile');
		
		$data = M('Join')->where(array('uid'=>$puid))->find();
		if($data){
			$info['company'] = $data['company'];//公司名称
			$info['lxname'] = $data['name'];//联系人姓名
			$info['lxmobile'] = $data['mobile'];//联系人电话
			$info['address'] = $data['address'];//联系地址
			$info['ratio'] = $data['ratio'];//返佣比例
			$info['lx'] = ($data['ratio_type']==1) ? '正常分成' : '利润分成';
			if($data['parent_id']){
			    $parent = M('Join')->where('uid = '.$data['parent_id'])->getField('name'); 
			    $info['pname'] = $parent;
			}
			$info['parent'] = $data['parent_id'];
			$info['erm'] = $data['erm'];
			$info['kaihuhang'] = $data['kaihuhang'];//开户行
			$info['kahao'] = $data['kahao'];//卡号
			$info['xingming'] = $data['xingming'];//户名
			$info['jid'] = $data['id'];			
		}
		$this->assign('info' , $info);
		$this->meta_title = '编辑用户';
		$this->display();
    }
    
    public function getparents(){
         header("Content-type: text/html; charset=utf-8");
         $pid = I('pid');
         $where = $pid ? ('parent_id = '.$pid) : '1 = 1';  
         $list = M('Join')->where($where)->getField('id,parent_id,name,mobile,uid',true); 
         
         exit(json_encode(array('ret'=>0,'data'=>$list)));    
    }
	
	public function updatepid(){
	      header("Content-type: text/html; charset=utf-8");
         $id = I('id');
         $puid = I('puid');
         if($id && $puid){ 
            $data['parent_id'] = $puid;
            $data['join_type'] = 1;
            $ret = M('Join')->where('id = '.$id)->save($data); 
            if($ret){
                exit(json_encode(array('ret'=>0,'data'=>'ok'))); 
             }
         }
         
            exit(json_encode(array('ret'=>1,'data'=>'error')));   
	}
    /**
     * 会员状态修改
     * @author ew_xiaoxiao
     */
    public function changeStatus($method = NULL){
        $id = array_unique((array) I('id' , 0));
        if (in_array(C('USER_ADMINISTRATOR') , $id)) {
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',' , $id) : $id;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] = array ('in' , $id);
        switch (strtolower($method)) {
            case 'forbiduser':
                $this->forbid('Member' , $map);
                break;
            case 'resumeuser':
                $this->resume('Member' , $map);
                break;
            case 'deleteuser':
                $this->delete('Member' , $map);
                break;
            default:
                $this->error('参数非法');
        }
    }

    /**
     * 会员收货地址
     * @author ew_xiaoxiao
     */
    public function address($uid = NULL){
        $realname = I('realname');
        if ($realname) {
            $map['realname'] = array ('like' , '%' . $realname . '%');
        }
        $map['uid'] = $uid;
        $this->assign('uid' , $uid);
        $addresslist = $this->lists('transport' , $map);
        foreach ($addresslist as $key => $val) {
            $address3 = M("area")->where("id='" . $val[area] . "'")->find();
            $address2 = M("area")->where("id='" . $address3[pid] . "'")->find();
            $address1 = M("area")->where("id='" . $address2[pid] . "'")->find();
            $areas    = $address1['name'];
            $areas .= $address2['name'];
            $areas .= $address3['name'];
            $addresslist[$key]['areas'] = $areas;//三级地区
        }
        $this->assign('addnum' , count($list));
        $this->assign('list' , $addresslist);
        $this->meta_title = get_username() . '的地址管理';
        $this->display();
    }

    /**
     * 添加会员收货地址
     * @author ew_xiaoxiao
     */
    public function addressadd(){
        if (IS_POST) {
            $Transport = M("transport"); // 实例化transport对象

            $data['uid']       = $_POST['uid'];
            $data['realname']  = $_POST['realname'];
            $data['cellphone'] = $_POST['cellphone'];
            $data['status']    = $_POST['status'];
            $data['address']   = $_POST['address'];
            $data['youbian']   = $_POST['youbian'];
            $data['mobile']    = $_POST['mobile'];
            $data['area']      = $_POST['areaid'];
            if ($data['status'] == "1") {//设为默认
                //默认地址更新会员
                if ($Transport->where("uid='" . $data['uid'] . "' and status='1'")->getField("id")) {
                    $odata['status'] = 0;
                    $Transport->where("uid='" . $data['uid'] . "'")->save($odata);
                }
            }
            if (FALSE !== $Transport->add($data)) {
                $this->success('添加成功！');
            } else {
                $this->error('添加失败！');
            }

        } else {
            $comparea   = M('area');
            $map['pid'] = 0;
            $arealist   = $comparea->where($map)->select();
            $this->assign('arealist' , $arealist);//地区列表

            $this->assign('info' , $info);
            $this->display();
        }
    }

    /**
     * 编辑会员收货地址
     * @author ew_xiaoxiao
     */
    public function addressedit($id = NULL){
        if (IS_POST) {
            $Transport = M("transport"); // 实例化transport对象
            $id        = $_POST['id'];
            //$data['id'] = $_POST['id'];
            $data['uid']       = $_POST['uid'];
            $data['realname']  = $_POST['realname'];
            $data['cellphone'] = $_POST['cellphone'];
            $data['status']    = $_POST['status'];
            $data['address']   = $_POST['address'];
            $data['youbian']   = $_POST['youbian'];
            $data['mobile']    = $_POST['mobile'];
            $data['area']      = $_POST['areaid'];
            if ($data['status'] == "1") {//设为默认
                //默认地址更新会员
                if ($Transport->where("uid='" . $data['uid'] . "' and status='1'")->getField("id")) {
                    $odata['status'] = 0;
                    $Transport->where("uid='" . $data['uid'] . "'")->save($odata);
                }
            }
            if (FALSE !== $Transport->where("id='" . $id . "'")->save($data)) {
                $this->success('编辑成功！');
            } else {
                $this->error('编辑失败！');
            }

        } else {
            $area       = M('area');
            $map['pid'] = 0;
            $arealist   = $area->where($map)->select();
            $this->assign('arealist' , $arealist);//地区列表
            $info = M("transport")->where("id='" . $id . "'")->find();

            $address3 = $area->where("id='" . $info['area'] . "'")->find();
            $address2 = $area->where("id='" . $address3['pid'] . "'")->find();
            $address1 = $area->where("id='" . $address2['pid'] . "'")->find();
            $areaname = $address1['name'] . $address2['name'] . $address3['name'];
            $this->assign('areaname' , $areaname);

            $this->assign('info' , $info);
            $this->display();
        }
    }


    /**
     * 用户行为列表
     * @author ew_xiaoxiao
     */
    public function action(){
        //获取列表数据
        $Action = M('Action')->where(array ('status' => array ('gt' , -1)));
        $list   = $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__' , $_SERVER['REQUEST_URI']);

        $this->assign('_list' , $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     * @author ew_xiaoxiao
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->assign('data' , NULL);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author ew_xiaoxiao
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(TRUE)->find($id);

        $this->assign('data' , $data);
        $this->meta_title = '编辑行为';
        $this->display('editaction');
    }

    /**
     * 更新行为
     * @author ew_xiaoxiao
     */
    public function saveAction(){
        $res = D('Action')->update();
        if (!$res) {
            $this->error(D('Action')->getError());
        } else {
            $this->success($res['id'] ? '更新成功！' : '新增成功！' , Cookie('__forward__'));
        }
    }


    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:
                $error = '用户名长度必须在16个字符以内！';
                break;
            case -2:
                $error = '用户名被禁止注册！';
                break;
            case -3:
                $error = '用户名被占用！';
                break;
            case -4:
                $error = '密码长度必须在6-30个字符之间！';
                break;
            case -5:
                $error = '邮箱格式不正确！';
                break;
            case -6:
                $error = '邮箱长度必须在1-32个字符之间！';
                break;
            case -7:
                $error = '邮箱被禁止注册！';
                break;
            case -8:
                $error = '邮箱被占用！';
                break;
            case -9:
                $error = '手机格式不正确！';
                break;
            case -10:
                $error = '手机被禁止注册！';
                break;
            case -11:
                $error = '手机号被占用！';
                break;
            default:
                $error = '未知错误';
        }
        return $error;
    }


    /**
     * 导出全部会员信息
     * @author
     */
    public function export(){
		$list          = M()->query("SELECT * FROM `ewshop_member` WHERE `status` = 1");
	
        foreach ($list as $key => $val) {
            $list[$key]['mobile'] = M('UcenterMember')->where("id='$val[uid]'")->getField("mobile");
            $list[$key]['email']  = M('UcenterMember')->where("id='$val[uid]'")->getField("email");
        }
        int_to_string($list);

        vendor('PHPExcel');
        $objPHPExcel = new \PHPExcel();

        // 设置文件的一些属性，在xls文件——>属性——>详细信息里可以看到这些值，xml表格里是没有这些值的
        $objPHPExcel->getProperties()//获得文件属性对象，给下文提供设置资源
                    ->setCreator("admin")//设置文件的创建者
                    ->setLastModifiedBy("admin")//设置最后修改者
                    ->setTitle("Office 2007 XLSX Document")//设置标题
                    ->setSubject("Office 2007 XLSX Document")//设置主题
                    ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")//设置备注
                    ->setKeywords("office 2007 openxml php")//设置标记
                    ->setCategory("Result file"); //设置类别

        // 给表格添加数据（表头）
        $objPHPExcel->setActiveSheetIndex(0)//设置第一个内置表（一个xls文件里可以有多个表）为活动的
                    ->setCellValue('A1' , '电话')//给表的单元格设置数据
                    ->setCellValue('B1' , '姓名')//数据格式可以为字符串
                    ->setCellValue('C1' , '邮箱');//数据格式可以为字符串


        // 给表格添加数据（内容）
        $name = 2;
        foreach ($list as $k => $v) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $name , $v['mobile']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $name , $v['realname']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $name , $v['email']);
            $name++;
        }

        //得到当前活动的表,注意下文教程中会经常用到$objActSheet
        $objActSheet = $objPHPExcel->getActiveSheet();
        // 给当前活动的表设置名称
        $objActSheet->setTitle('会员数据');
        //设置列的宽度
        $objActSheet->getColumnDimension('A')->setWidth(22); //30宽
        $objActSheet->getColumnDimension('B')->setWidth(35); //30宽
        $objActSheet->getColumnDimension('C')->setWidth(25); //30宽

        /*********  浏览器输出  ********/

        // 生成2007excel格式的xlsx文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="会员数据.xlsx"'); //文件名称
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory:: createWriter($objPHPExcel , 'Excel2007');
        $objWriter->save('php://output');
        exit;


    }
    
    public function updateRootId(){
        $puid = I('uid');
        if($puid){
            $fxusers = getfxuser($puid);
            foreach ($fxusers as $k=>$v) {
                 $uids[] = $v['uid']; 
            }
            $map['uid'] = array('in',$uids);
           // $map['root_id'] = array('eq',0);
            $data['root_id'] = $puid;
            $ret = M('Member')->where($map)->save($data); 
            error_log(implode(',',$uids).'-->update-->root_id'.'-->'.$puid,'3','/home/tmp/uprootid.log');
            if($ret) echo 'susccess';
         }
         echo 'data is null';
            
    }
    
    public function updatepidm(){
         header("Content-type: text/html; charset=utf-8");
         $id = I('id');
         $puid = I('puid');
         if($id && $puid){ 
            $data['parent_id'] = $puid;
            $data['join_type'] = 1;
            $ret = M('Member')->where('uid = '.$id)->save($data); 
            if($ret){
                exit(json_encode(array('ret'=>0,'data'=>'ok'))); 
             }
         }
           
         exit(json_encode(array('ret'=>1,'data'=>'error'))); 
    }


}
