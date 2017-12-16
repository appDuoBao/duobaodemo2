<?php
/**
 * 支付接口调测例子
 * ================================================================
 * index 进入口，方法中转
 * submitOrderInfo 提交订单信息
 * queryOrder 查询订单
 *
 * ================================================================
 */
namespace Weixin\Controller;
use Think\Controller;

Class PayController extends HomeController{

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
	public function isCanPay($tsnum){
		 $uid = $this->uid;
		 $totnum = D('Recharge')->where('uid = '.$uid)->getField('totalnum');
		 if($tsnum > $totnum){
			return false;
		 }
		 return array('tot'=>$totnum);
	}
	public function doorder(){
			$uid = $this->uid;
			$shiji = $_REQUEST['numb'];
			if(empty($uid) || !preg_match('/\d{1,10000}/',$shiji)){
				$this->error("请登陆");return;
			}
			$ispay = $this->isCanPay($shiji);
			if(!$ispay){
				$this->error('提现金额有误');exit;	
			}
			//查询有无银行卡
			$allcard = M('Account')->where(sprintf('uid = %d and defaultcard=1',$uid))->find();
			if(empty($allcard)){
				$this->redirect('Index/bindcard');  return; 
			}
			$payobj = M('PayRecord');
			//插入订单表数据 
			$orderSn = 'PAY' . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', mt_rand(10, 1000));
			$data['pay_id'] = $orderSn;
			$data['account_id'] = $allcard['id'];
			$data['card_no'] = $allcard['card_no'];
			$data['username'] = $allcard['username'];
			$data['cardname'] = $allcard['bankname'];
			$data['uid'] = $uid;
			$data['pay_code'] = 'TIXIAN';

			$data['total_nu'] = $shiji;
			$data['ctime'] = time();
			$data['status'] = 0;
			$ret = M('PayRecord')->add($data);
			if($shiji && $uid && $data['card_no'] && $orderSn && $ret){ 
				//调用第三方接口 

				$retstatu =  $this->paySinTrans($orderSn,$shiji,$allcard); 
				if($retstatu){
					//更新所有本系统未支付状态记录,//第三方支付成功一定要更新 win-exchange 
					$left = bcsub($ispay['tot'],$shiji);
					$ret = M('Recharge')->where(sprintf("uid = '%d' ",$uid))->save(array('totalnum'=>$left));
					if(!$ret)
						$flag = 1;
						while($flag<=3){
						$ret = M('Recharge')->where(sprintf("uid = '%d' ",$uid))->save(array('totalnum'=>$left));
							if(!$ret){
								$flag++;
								error_log(json_encode(array('orderNo'=>$orderNo,'status'=>'exret:'.$exret.'|payret:'.$ret,'msg'=>'更新数据库失败'.implode(':',$order_ids)))."\n\t",3,'/home/tmp/pay.log');   
							}
							if($ret) break;
						}
				}else{
					//第三方支付没成功
				}  
				$this->redirect('index/recordlist');return;

			}
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
			$content     = "您的短信验证码为：" . $mobile_code . "，有效期一小时。【千亩阳光】";
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
			$params["merchantId"] = self::$merchanid;;
			$params["requestTime"] = date('YmdHis');
			$params["requestId"] = time();
			$params["service"] = $param['service'];
			$params["signType"] = 'RSA256';
			//$params['merchantCert'] = '';
			//$params['merchanSign']='';
			return $params;
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

	}
	?>
