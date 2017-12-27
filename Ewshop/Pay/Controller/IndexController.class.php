<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Pay\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台首页控制器
 * @author ew_xiaoxiao
 */
class IndexController extends ControlController {
    /**
     * 后台首页
     * @author ew_xiaoxiao
     */
    private static  $certFilePath='/home/cert/800000600020008.p12';
   
    private static  $merchanid='800000600020008';
   
    private static  $merchantCertPass='VkSuds'; 
    
    private static  $deskey = 'cputest';  
    
    private $uid;
    
    private $shouxufei = 1; //手续费1元
    
    public function _initialize(){
        
        $this->uid = ($_SESSION['onethink_home']['uid']) ? ($_SESSION['onethink_home']['uid']) : ($_SESSION['onethink_admin']['user_auth']['uid']) ;
        if(empty($this->uid)){
             $this->redirect('User/register');  return; 
        }
    }
      
    public function index(){
		 
		 //计算金额
		 $uid = $this->uid;
		 $order = $this->getExCode();
		 $shiji = $order['shiji'] ? $order['shiji'] : 0;
		 $zhcode = $order['code'];
		 $total = $order['total'] ? $order['total'] : 0;
		 $sxf = $order['sxf'] ? $order['sxf'] : 0;
	     //拉取银行卡信息
	     $allcard = M('Account')->where(sprintf('uid = %d',$uid))->getField('id,card_no,bankname,username',true);
	     $cardmap['defaultcard'] = array('eq',1);
	     $cardmap['uid'] = array('eq',$uid);
	     $cardinfo = M('Account')->where($cardmap)->find();
	     //var_dump($cardinfo);exit;
	     $this->assign('cardno',count($zhcode));
	     $this->assign('cardinfo',($cardinfo));
	     
	     $this->assign('shiji',$shiji);
	     $this->assign('code',$zhcode);
	     $this->assign('total',$total);
	     $this->assign('sxf',$sxf);
             $this->assign('sytlei',1);
	     $this->display();
    }
    
    private function getExCode($arr = ''){
         $uid = $this->uid;
		 $map['uid'] =array('eq',$uid);
		 $map['is_exchange'] =array('eq',0);
		 $map['exchange_number'] =array('neq','');
		 if(!empty($arr) && is_array($arr) && count($arr)>0){
		   $map['exchange_number'] = array('in',$arr);   
		 }
		 $goodid = M('WinExchange')->where($map)->getField('goods_id',true);
	     $zhcode = M('WinExchange')->where($map)->getField('id,uid,order_id,goods_id,exchange_number,buy_num',true);
	     if($goodid){
	        $goodprice = M('Document')->where(array('id'=>array('in',$goodid)))->getField('id,real_price');   
	     }
	     $total = 0;
	     $sxf = 0;
	     if($zhcode){
	       
	        foreach($zhcode as $k=>$v){
	            $arrcode[] = $v['exchange_number'];
	            $total = bcadd($total,bcmul($goodprice[$v['goods_id']],$v['buy_num'],4),4);
	            $ex_tot[$v['exchange_number']] = bcmul($goodprice[$v['goods_id']],$v['buy_num'],4);
	        }   
	        $sxf = $this->shouxufei ;//bcmul($total,bcdiv($this->shouxufei,100,4),4);
	        $shiji = bcsub ($total,$sxf,4);
	     }
	     
	     return array('shiji'=>$shiji,'total'=>$total,'code'=>$zhcode,'sxf'=>$sxf,'arrcode'=>$arrcode,'exrecord'=>$ex_tot);
        
    }
    public function getShouRu(){
        $datacode = I('datacode');
        if($datacode){
            $code = explode(',', $datacode);
            $ret = $this->getExCode($code); 
            if($ret){
                $retdata = array('shiji'=>$ret['shiji'],'total'=>$ret['total'],'sxf'=>$ret['sxf']); 
                exit(json_encode(array('ret'=>0,'data'=>$retdata,'msg'=>'ok')));   
            }   
        }
        exit(json_encode(array('ret'=>1,'msg'=>'error','data'=>'')));    
    }
    public function docharge(){
	$uid = $this->uid;
        $datacode= ''; //I('codedata');
        if(empty($uid)){

            $this->error("请登陆");return;
        }
        $order = $this->getExCode();
	$total_fee = $order['shiji'];
        $ptype    = 3;
        //获取预支付信息
        $out_trade_no = 'RE'.date('YmjHis').sprintf("%07d", $uid).'3'.rand(1000,9999);//商户订单号
        //创建订单
        $data['uid'] = $uid;
        $data['create_time'] = time();
        $data['total_fee'] = $total_fee;
        $data['ptype'] = $ptype;
        $data['out_trade_no'] = $out_trade_no;
	$arrcode = $order['arrcode'];
        $paycode=implode(':', $arrcode);
	$data['content'] = $paycode;
	$data['status'] = 1;
        if($orderid = M('RechargeOrder')->add($data)){
		$acc = D('Recharge');
		$nowtoto = $acc->where()->getField('totalnum');
		$arr['totalnum'] = bcadd($data['total_fee'],$nowtoto,4);var_dump($arr);
		$ret = $acc->where('uid = '. $uid)->save($arr);
		if($ret){
			$win_ex = M('WinExchange');
			$order_ids = array_keys($order['code']); 
			$exmap['id'] = array('in',$order_ids);
			$exret = $win_ex->where($exmap)->save(array('is_exchange'=>1));	
			if($ret && $exret){
		   		header('Location: http://www.bjlaote.com/index.php?s=/Weixin/My/account');exit;
		        }
		}
        }else{
		 $this->redirect('Index/index');  return;
        }

    }
    public function doorder(){
        $uid = $this->uid;
        $datacode= ''; //I('codedata');
        if(empty($uid)){
            
            $this->error("请登陆");return;
        }
        $code = '';explode(',', $datacode);
        $order = $this->getExCode($code);
        if($order){
          //查询有无银行卡
             $allcard = M('Account')->where(sprintf('uid = %d',$uid))->getField('id,card_no,bankname,username',true);
    	     if(empty($allcard)){
    	          $this->redirect('Index/bindcard');  return; 
    	     }
    	     $cardmap['defaultcard'] = array('eq',1);
    	     $cardmap['uid'] = array('eq',$uid);
    	     $cardinfo = M('Account')->where($cardmap)->find();
           if($order['shiji']){
               $payobj = M('PayRecord');
            //插入订单表数据 
                $shiji =$order['shiji'];
                $arrcode = $order['arrcode'];
                //根据pay_code查询是否有过支付
                $paycode=implode(':', $arrcode);
               
                    $orderSn = 'PAY' . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', mt_rand(10, 1000));
                    $data['pay_id'] = $orderSn;
                    $data['account_id'] = $cardinfo['id'];
                    $data['card_no'] = $cardinfo['card_no'];
                    $data['username'] = $cardinfo['username'];
                    $data['cardname'] = $cardinfo['bankname'];
                    $data['uid'] = $uid;
                    $data['pay_code'] = $paycode;
                    
                    $data['total_nu'] = $shiji;
                    $data['ctime'] = time();
                    $data['status'] = 0;
                    $ret = M('PayRecord')->add($data);
                    
                    if($ret){
                         $logdata['order_no'] =  $orderSn;
                         foreach($order['code'] as $k=>$v){
                             $logdata['win_order_id'] =  $v['order_id'];
                             $logdata['uid'] =  $uid;
                             $logdata['exchange_number'] =  $v['exchange_number'];
                             $logdata['total'] = $order['exrecord'][$v['exchange_number']];
                             $logdata['ctime'] = time();
                             $paylog = M('PayLog')->add($logdata);
                        }
                          //exit('tat');
                    }else{
                        $this->error('系统错误');return;   
                    }
                
                if($shiji && $uid && $data['card_no'] && $orderSn){ 
                        //调用第三方接口 
                       $retstatu =  $this->paySinTrans($orderSn,$shiji,$cardinfo); 
                       if($retstatu){
                            //更新所有本系统未支付状态记录,//第三方支付成功一定要更新 win-exchange 
                            $win_ex = M('WinExchange');
                            $order_ids = array_keys($order['code']); 
                            $exmap['id'] = array('in',$order_ids);
                            $exret = $win_ex->where($exmap)->save(array('is_exchange'=>1));
                            $ret = M('PayRecord')->where(sprintf("pay_id = '%s' ",$orderSn))->save(array('status'=>1));
                            if($ret && $exret){ 
                                $this->redirect('index/recordlist');return;
                            }else{//支付成功强制　更新表
                                $exmap['id'] = array('in',$order_ids);
                                $exret = $win_ex->where($exmap)->save(array('is_exchange'=>1));
                                 error_log(json_encode(array('orderNo'=>$orderNo,'status'=>'exret:'.$exret.'|payret:'.$ret,'msg'=>'更新数据库失败'.implode(':',$order_ids)))."\n\t",3,'/home/tmp/pay.log');   
                            } 
                       }else{
                           //第三方支付没成功
                            error_log(json_encode(array('orderNo'=>$orderSn,'status'=>$ret,'msg'=>'支付接口：'.$retstatu))."\n\t",3,'/home/tmp/pay.log');   
			                $this->redirect('index/index');return; 
                       }  
                    
                }else{
                    //报错信息    
                }
           }     
            
        }
            
        
    }
    public function bindcard(){
         $uid = $this->uid;
         
         if(IS_POST && $uid){
            $code = I('check_code');
             if($code != $_SESSION['mobile_code']){
                    $this->error("验证码不正确");return;
             }
            $accout = M('Account');
            //查询是否帮定过
            $data['card_no'] = I('card_no');
            if(!$data['card_no'] || !preg_match('/\d{16,19}/', $data['card_no'])){
                $this->error("卡号不正确");return;
            }
            $is_card = $accout->where('card_no = '.$data['card_no'])->find();
            if($is_card){
                $this->error("此卡已经绑定过了，换张卡哟");return;    
            }
            $data['uid'] = $uid;
            $data['username'] = I('username');
            $data['idcard'] = I('bank_add');
            $data['mobile'] = I('mobile');
            $data['ctime'] = time();
            $data['bankname'] = I('bank_name');
            $data['defaultcard'] = 1;
            //参数验证
            //if(strlen($data['idcard']) < 18){
                $//this->error("身份证号不正确");return;
           // }
            $ret = $accout->add($data);
            if($ret){
                $this->redirect('index/recordlist');  return;  
            }
         }
         $username = I('username');
         $idcard = I('idcard');
         $cardno = I('cardno');
         $bankname = I('bank_name');
         $this->assign('username',$username);
         $this->assign('idcard',$idcard);
         $this->assign('cardno',$cardno);
         $this->assign('bankname',$bankname);
         $_SESSION['send_code'] = random(6 , 1);    
         $this->display();
    }
    public function checkCode(){
        if (trim($_POST['miss']) == $_SESSION['mobile_code']) {
            $return = array ("status" => 1 , "info" => "");
        } else {
            $return = array ("status" => 0 , "info" => '验证码不正确');
        }
        $this->ajaxreturn($return);
    }
    public function sendcode(){
        
        $phone = $_POST['phone'];
        $mobile_code = random(4 , 1);//生成手机验证码
        $send_code   = (!empty($_SESSION['send_code'])) ? $_SESSION['send_code'] : '8888';//获取提交随机加密码
        $content     = "您的短信验证码为：" . $mobile_code . "，有效期一小时。【翔傲元】";
        $result      = sendsmscode($phone , $content , $send_code , $mobile_code);
        exit(json_encode($result));
        
    }
    
    public function cardlist(){
         $uid = $this->uid;
         $accout = M('Account');
         $cards = $accout->where('status=1 and uid ='.$uid)->getField('id,card_no,bankname',true);
         $this->assign('list',$cards);
         $this->assign('sytlec',1);
		 $this->display();
    }
    
    public function selectcard(){
      
        $fromurl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->assign('fromurl',$fromurl);
        $this->display();    
    }
    public function recordlist(){
        $uid=337;       
         //$uid = $this->uid;
         $ctime = I('stime') ? I('stime') : date('Y-m-d');
         $start_time = strtotime($ctime);
         $end_time = strtotime($ctime + 24*60*60);
         $map['status'] = array('eq',1);
         $map['uid'] = array('eq',$uid);
         $list = M('PayRecord')->where($map)->select();
         $this->assign('sytler',1);
         $this->assign('list',$list);
		 $this->display();
    }
    public function paySinTrans($orderSn,$shiji,$cardinfo){
	    header("Content-type: text/html; charset=utf-8"); 
        //$reUrl = 'http://43.227.141.32/paygateway/mpsGate/mpsTransaction';//接口类型
	 $reUrl = 'https://jd.kingpass.cn/paygateway/mpsGate/mpsTransaction';
        $order['mcSequenceNo'] = "123456789";
        $order["mcTransDateTime"] = date('YmdHis');
        $order["orderNo"] = $orderSn;
        $order["amount"] = bcmul($shiji,100,4);
        $order["cardNo"] = self::do_des($cardinfo['card_no'],self::$deskey); //'9df04f691e75d4fad0b57592b1dcfc14906ad91d4dbb3063';
        $order["accName"] =  $cardinfo['username'];
        $order["accType"] = '0';
        $order1["lBnkNo"]  = '';
        $order1["lBnkNam"] = '';
        $order["crdType"]= "00";
        $order1["validPeriod"] ='';
        $order1["cvv2"] ="";
        $order1["cellPhone"] = "";
    	$order1['remark']='';
    	$order1['bnkRsv'] = '';
    	$order['capUse'] ='9';
    	//$order['callBackUrl']='http://duobao.akng.net/pay.php?s=index/callbak';
    	$params['service'] = 'capSingleTransfer';
        $publicp = self::publicParams($params);
       	$order = array_merge($order,$publicp);
    	ksort($order);
    	$signdata = self::arrToStr($order);
        $sign = $this->RSAsign($signdata,self::$merchantCertPass);//password私钥证书的密码
       	$header =array();
    	$order= array_merge($order,$order1);
    	$order['merchantSign'] = $sign['sign'];
    	$order['merchantCert'] = $sign['cert'];
        $res =mb_convert_encoding(PostHttp($reUrl,$order,$header),'UTF-8','auto');
       	$ret = self::formartRet($res); 
        if($ret['rspCode']=='IPS00000'){
            return 1;    
        }else{
            error_log(json_encode($ret)."\n\t",3,'/home/tmp/pay.log');     
        }
                
    }
    public static function formartRet($ret){
	    if($ret){
		    $ret = explode('&', $ret);
		    if(is_array($ret)){

			    foreach($ret as $k=>$v){
				    $retv = explode('=', $v);
				    $arrret[$retv[0]] = $retv[1];
			    }

		    }
	    }
	return $arrret;
    }
    public static function publicParams($param = array()){
	$params["charset"] = '02';
	$params["version"] = '1.0';
	$params["merchantId"] = self::$merchanid;
	$params["requestTime"] = date('YmdHis');
	$params["requestId"] = time();
	$params["service"] = $param['service'];
	$params["signType"] = 'RSA256';
	//$params['merchantCert'] = '';
	//$params['merchanSign']='';
	return $params;
    }
    public function getCardInfo(){
       
        $reUrl = 'http://43.227.141.32/paygateway/mpsGate/mpsTransaction';//接口类型
	//$reUrl = 'http://43.227.141.32/paygateway/rpmGate/rpmCardInfo';
	$cardNo["charset"] = '';
	$cardNo["version"] = '1.0';
	$cardNo["service"] = 'rpmCardInfo';
	$cardNo["signType"] = 'RSA256';
	$cardNo["merchantId"] = '800000101000109';
	$cardNo["requestTime"] = date('YmdHis');
	$cardNo["requestId"] = time();
	$cardNo['cardNo'] = "6225880154901171";
        //2、请求流程
        // String buf = reqData + "&merchantSign=" + merchantSign + "&merchantCert=" + merchantCert;
       
        $signdata = http_build_query($cardNo);
        $sign = $this->sign($signdata,$password);//password私钥证书的密码
       
        $header =array($signdata.'&merchantSign='.$sign['sign'] . '&merchantCert='.$sign['cert']);
	$cardNo['merchantSign'] = $sign['sign'];
	$cardNo['merchantCert'] = $sign['cert'];
        $res = PostHttp($reUrl,$cardNo,$header);
        $ret = explode('&', $res);
        if(is_array($ret)){
            
            foreach($ret as $k=>$v){
                $retv = explode('=', $v);
                $arrret[$retv[0]] = $retv[1];
            }
            
        }
	print_r($arrret);exit;
        self::verifySign($ret,$retsign,$password);
    }
    public static function getSign($request,$encoding = 'gbk'){
        $certFilePath =self::$certFilePath;
        $password = self::$merchantCertPass;
        $reqStr=http_build_query($request);
        $asci = self::getBytes($reqStr);
        $sign = self::ascii2hex($asci);
        
        return $sign;
        
    }
    
     public static function getBytes($string) {  
        $bytes = array();  
        for($i = 0; $i < strlen($string); $i++){  
             $bytes[] = ord($string[$i]);  
        }  
        return $bytes;  
    }  
    public static function ascii2hex($ascii) {
          $hex = '';
          for ($i = 0; $i < strlen($ascii); $i++) {
            $byte = strtoupper(dechex(ord($ascii{$i})));
            $byte = str_repeat('0', 2 - strlen($byte)).$byte;
            $hex.=$byte." ";
          }
          return $hex;
    }
    
    public static function getCert(){
        openssl_private_encrypt();    
    }
    
    /**
   * 根据原文生成签名内容
   *
   * @param string $data 原文内容
   *
   * @return string
   * @author confu
   */
public static function RSAsign($source, $password)
    {
        $certs = array ();
        $fd = fopen (self::$certFilePath, 'r' );
        $p12buf = fread ( $fd, filesize (self::$certFilePath) );
        fclose ( $fd );
        if (openssl_pkcs12_read ( $p12buf, $certs, $password )) {
            $pkeyid = openssl_pkey_get_private ( $certs ['pkey'] );//var_dump($pkeyid);exit;
            $signature = "";
	    $pubder = self::pem2der( $certs ['cert'] );
            openssl_sign ($source, $signature, $pkeyid,OPENSSL_ALGO_SHA256);
            openssl_free_key ( $pkeyid );
            return array('sign'=>self::asc2hex ( $signature ),'cert'=>self::asc2hex($pubder));
        }
    }

 public static function asc2hex($str)
    {
        return chunk_split(bin2hex($str), 2, '');
    }
 public static function pem2der($pem_data)
    {
        $begin = "CERTIFICATE-----";
        $end   = "-----END";
        $pem_data = substr($pem_data, strpos($pem_data, $begin)+strlen($begin));
        $pem_data = substr($pem_data, 0, strpos($pem_data, $end));
        $der = base64_decode($pem_data);
        return $der;
    }
public static function encodeArr($input){
	 while (list($k, $v) = each($input)) {
            if (!empty ($v)) {
                $ret[] = "$k=" . mb_convert_encoding($v, 'UTF-8', 'GB18030');
            } else if (gettype($v) != 'boolean' && !is_array($v)) {
                $ret[] = "$k=" . mb_convert_encoding($v, 'UTF-8', 'GB18030');
            }
        }
	return $ret;
 }
 private static function arrToStr($arrdata){
   if($arrdata){
	$ret = [];
   	while(list($k,$v)=each($arrdata)){
	  if(!empty($v)||$v===0 || $v ==='0'){
		$ret[] = "$k=$v";	
	  }	
	}
	return	$str = implode('&',$ret);
     }
	return false;
 }
 private static  function do_des($input, $key)
    {
      
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_ECB);
        $str = self::pkcs5Pad($input, $size);
        $td = @mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_ECB, '');
        $iv = 'cputest0';
        @mcrypt_generic_init($td, $key, $iv);
        $data = @mcrypt_generic($td, $str);
        $ret = strtoupper(bin2hex($data));
        return $ret;
        //return self::asc2hex($encrypted_data);
    }
    public static function pkcs5Pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
   public function updatebank(){
         $uid = $this->uid;
         $bid = I("bid");
         $flag = I("flag");
         if($uid && $bid){
            if($flag == 1){
                $data['defaultcard'] = 0;  
                $ret = M('Account')->where('uid = '.$uid .' and id !='.$bid)->save($data);
                $datau['defaultcard'] = 1;
                $ret = M('Account')->where('id ='.$bid)->save($datau);
                exit(json_encode(array('ret'=>0,'data'=>'ok'))); 
            }elseif ($flag == 2) {
                $data['status'] = 2; 
                $ret = M('Account')->where('id ='.$bid)->save($data);
                exit(json_encode(array('ret'=>0,'data'=>'ok'))); 
            }
         } 
         exit(json_encode(array('ret'=>1,'data'=>'error')));    
    }
    
}
