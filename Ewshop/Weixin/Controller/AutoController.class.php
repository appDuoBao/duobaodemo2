<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Weixin\Controller;
use Think\Controller;

/**
 * Class AutoController
 * @package Weixin\Controller
 * @author
 */
class AutoController extends HomeController {

    /**
     * 自动获取5位随机数
     * @author
     */
    public function doAuto(){
        //开奖时间是 10:00 - 2:00
        $time_H = date('H');
        $time_m = date('i');
        if($time_H >= 10 || $time_H < 2 || ($time_H == 2 && $time_m < 1)){
//            echo  date('Y-m-d H:i:s')."\n";

            $lottery_time = $this->get_time_on_clock(time());//下期开奖时间

            $lottery_time_stamp = strtotime($lottery_time);

            $data['create_time'] = $lottery_time;//开奖时间
            $data['period'] = $this->getPeriod($lottery_time);//开奖期数
            $data['time'] = $lottery_time_stamp;//开奖时间
            
            if(date('H:i:s',$lottery_time_stamp) != '02:05:00'){
                $map['create_time'] = $lottery_time;//开奖时间
                $map['period'] = $this->getPeriod($lottery_time);//开奖期数
                $is_exist = M('WinCode')->where($map)->find();
                (!$is_exist) ?  M('WinCode')->add($data) : ''; //插入数据
            }
            //判断是否有code为0的数据
            $is_exist_code = M('WinCode')->where("code = '0' and time < {$lottery_time_stamp}")->order('id desc')->select();
           
//            echo M()->getLastSql();
//            dump($is_exist_code);
            if($is_exist_code){
                foreach($is_exist_code as $key => $val){
					$this->setOrderStatus($val);
				}
				//if($is_exist_code[0]){
					//$this->setOrderStatus($is_exist_code[0]);
				//}  
            }
        }
		
		if($time_H == 22 && $time_m < 10){
			//清空数据表
			$sql = 'truncate table ewshop_lottery';
			M('Lottery')->execute($sql);
            //清空数据表

			$lotterys = getlotterys();//获取所有开奖结果（10个结果）
			//将22点的接口数据存入数据库
			foreach($lotterys as $key=>$val){
				if($val){
					 M('Lottery')->add($val);
				}
			}
			//将22点的接口数据存入数据库
		}
    }
    //  */1 * * * * /usr/bin/curl http://duobao.akng.net/Weixin/Auto/doAuto  >> /opt/web/mydata.log



    /**
     * 设置订单状态
     * @author
     */
    public function setOrderStatus($code_arr){
        $data = $this->getCodeRand($code_arr['create_time']);
		if($data){
			 
			$lottery_nums = $data['lottery_nums'];
			
			$code = $data['code'];
			$code_56 =  $code%56 + 1;
			$code_110   =  $code%110 + 1;
	
			//更新数据
			//$data2['id'] = $code_arr['id'];
			$data2['code'] = $lottery_nums;//开奖号码
			$data2['code_56'] = $code_56;
			$data2['code_56_type'] = $code_56 <= 28 ? 1 : 2;
			$data2['code_110']   = $code_110;
			$data2['code_110_type'] = $code_110 <= 55 ? 1 : 2;
			$data2['czh']   = $data['lottery'];//彩种名称
			$data2['cno']   = $data['lottery_no'];//开奖号码
			$data2['ctime']   = $data['lottery_time'];//开奖时间
			$data2['province']   = $data['province'];//彩种所在城市
			$data2['company']   = $data['company'];//彩票类型
			$data2['info']   = $data['info'];//彩票信息	
			
			$iswc = M('WinCode')->where("id='".$code_arr['id']."'")->find();//判断当前开奖是否已设置开奖码
			if($iswc['code']=='0'){
				$res2 = M('WinCode')->where("id='".$code_arr['id']."'")->save($data2);
				//设置获胜者
				if($res2){
					$order_list = M('WinOrder')->where(array('lottery_time'=>$code_arr['create_time'],'status'=>1))->select();
					if($order_list){
						foreach($order_list as $key=>$val){
							if(($val['goods_type'] == 1 && $val['type'] == $data2['code_56_type']) || ($val['goods_type'] == 2 && $val['type'] == $data2['code_110_type'])){
								$exchangeData['uid'] = $val['uid'];
								$exchangeData['goods_id'] = $val['goods_id'];//购买商品
								$exchangeData['order_id'] = $val['id'];
								$exchangeData['exchange_number'] = $this->randStr();
								$exchangeData['buy_num'] = $val['num'];//购买数量
								$exchangeData['buy_time'] = $val['create_time'];//购买时间
								$exchangeData['create_time']     = time();
								//$exchangeData['city']     = $this->getIpInfo();//用户的城市信息  速度太慢会有延迟
								$exchangeData['city']     = getip();//用户的ip信息
								$exchangeData['period']     = $code_arr['period'];
								$exchangeData['codeid']     = $code_arr['id'];
								$exchangeData['utype'] = $val['utype'];//用户类型
								$iswe = M('WinExchange')->where("uid='".$val['uid']."' and order_id='".$val['id']."'")->find();//判断当前订单是否已经设置当前会员中奖
								if(empty($iswe)){								
									M('WinExchange')->add($exchangeData);
									
								}
								//插入虚拟单子数据
								//$this->setOrderLogRand($code_arr['period'],$code_arr['id']);
									
							}
						}
					}
				}
			}
		}

        echo  date('Y-m-d H:i:s').':This code is '.$code.'.'."\n";
    }



    /**
     *  获取5位随机数
     * @param $lottery_time
     * @author
     */
    public function getCodeRand($lottery_time = ''){

//        $lottery_time = '2017/04/16 23:25:00';
        $num_56_small = M('WinOrder')->where(array('lottery_time'=>$lottery_time,'goods_type'=>1,'utype'=>1,'type'=>1,'status'=>1))->sum('money');//买小（28元）的订单数的总金额
        $num_56_big   = M('WinOrder')->where(array('lottery_time'=>$lottery_time,'goods_type'=>1,'utype'=>1, 'type'=>2,'status'=>1))->sum('money');//买大（28元）的订单数的总金额
        $num_110_small = M('WinOrder')->where(array('lottery_time'=>$lottery_time,'goods_type'=>2,'utype'=>1, 'type'=>1,'status'=>1))->sum('money');//买小（55元）的订单数的总金额
        $num_110_big   = M('WinOrder')->where(array('lottery_time'=>$lottery_time,'goods_type'=>2,'utype'=>1, 'type'=>2,'status'=>1))->sum('money');//买大（55元）的订单数的总金额
        if($num_56_small > $num_56_big){
            $code_56_val = 2;//选择大的赢
        }elseif($num_56_small < $num_56_big){
            $code_56_val = 1;//选择小的赢
        }else{
            $code_56_val = 0;//大小均可
        }

        if($num_110_small > $num_110_big){
            $code_110_val = 2;//选择大的赢
        }elseif($num_110_small < $num_110_big){
            $code_110_val = 1;//选择小的赢
        }else{
            $code_110_val = 0;//大小均可
        }
		
		$isLS = M('Config')->getFieldByName('LOTTERY_SETTING','value');//判断时候开启开奖控制
		if($isLS==1){
			$data = $this->getCodeRand2(0,0);//正常开奖
		}else{
        	$data = $this->getCodeRand2($code_56_val,$code_110_val,$isLS);//开启优势规则
		}
        return $data;
    }


    /**
     *
     * @param $code_56_val
     * @param $code_110_val
	 * @param $control_type(0:控制，1:正常开奖，2:反向控制)
     * @author
     */
    public function getCodeRand2($code_56_val = 0,$code_110_val = 0,$control_type = 1){
		$data = array();
		$time_H = date('H');
/***   
     if($code_56_val == 0 && $code_110_val== 0){
			if($time_H > 23 || $time_H < 2){
				//从数据库中直接获取数据
				$lotterys = getlotterybydata();
				foreach($lotterys as $key=>$val){
					$lottery = $val;
					break;
				}
			}else{
				$lottery = getnewlottery();//获取最近的一次开奖，大小无所谓
			}
			if(!empty($lottery)){
				$lottery_nums = $lottery['lottery_nums'];
				$lottery_nums = str_replace(',', '', $lottery_nums);
				//$lottery_nums = str_replace('0', '', $lottery_nums);
				//if(strlen($lottery_nums)>5){
				//	$lottery_nums = substr($lottery_nums, -5);
				//}
				$code = intval($lottery_nums);
				$lottery['code']=$code;
				
				$data = $lottery;		
			}
        }else{
			if($time_H > 23 || $time_H < 2){
				//从数据库中直接获取数据
				$lotterys = getlotterybydata();//获取所有开奖结果（10个结果）
			}else{
				$lotterys = getlotterys();//获取所有开奖结果（10个结果）
			}
			if(!empty($lotterys)){
				foreach($lotterys as $key=>$val){
					$lottery_nums = $val['lottery_nums'];
					$lottery_nums = str_replace(',', '', $lottery_nums);
					//$lottery_nums = str_replace('0', '', $lottery_nums);
					//if(strlen($lottery_nums)>5){
					//	$lottery_nums = substr($lottery_nums, -5);
					//}
					$code = intval($lottery_nums);
					$val['code']=$code;
					$data = $val;	
					$code_56 =  $code%56 + 1;
					$code_110   =  $code%110 + 1;
					if($code_56_val == 0 && $code_110_val == 1){
						if($code_110 <= 56) break;
					}elseif($code_56_val == 0 && $code_110_val == 2){
						if($code_110>56 && $code_110<=110) break;
					}elseif($code_56_val == 1 && $code_110_val ==0){
						if($code_56<=28) break;
					}elseif($code_56_val == 1 && $code_110_val ==1){
						if($code_56<=28 && $code_110<=56) break;
					}elseif($code_56_val == 1 && $code_110_val ==2){
						if($code_56<=28 && $code_110>56 && $code_110<=110) break;
					}elseif($code_56_val == 2 && $code_110_val ==0){
						if($code_56>28 && $code_56<=56) break;
					}elseif($code_56_val == 2 && $code_110_val ==1){
						if($code_56>28 && $code_56<=56 && $code_110<=56) break;
					}elseif($code_56_val == 2 && $code_110_val ==2){
						if($code_56>28 && $code_56<=56 && $code_110>56 && $code_110<=110) break;
					}	
				}	
			}
        }
**/
	//	if(empty($data) || count($data)==0){//接口获取数据失败时调用内部算法
			$val['lottery']   = '时时彩';//彩种名称
			//$val['cno']   = $data['lottery_no'];//开奖号码
			$val['ctime']   = date('Y-m-d H:m:s',$time);;//开奖时间
			$val['province']   = '上海';//彩种所在城市
			$val['company']   = '福彩';//彩票类型
			$val['info']   = '每日：100 期，开奖频率：10分钟';//彩票信息	
			
			if($code_56_val == 0 && $code_110_val== 0){
				$lottery_nums = rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9);
				$val['lottery_nums']=$lottery_nums;
				$code = str_replace(',','',$lottery_nums);
				$val['code']=$code;
				$data = $val;
			}else{		
				while(true){
					$lottery_nums = rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9);//原有规则
					$val['lottery_nums']=$lottery_nums;
					$code = str_replace(',','',$lottery_nums);
					$val['code'] = $code;
					$data = $val;				
					$code_56 =  $code%56 + 1;
					$code_110   =  $code%110 + 1;
					if($code_56_val == 0 && $code_110_val == 1){
						if($control_type==0){
							if($code_110 <= 56) break;
						}else{
							if($code_110>56 && $code_110<=110) break;
						}
					}elseif($code_56_val == 0 && $code_110_val == 2){
						if($control_type==0){
							if($code_110>56 && $code_110<=110) break;
						}else {
							if($code_110<=56) break;
						}
					}elseif($code_56_val == 1 && $code_110_val ==0){
						if($control_type==0){
							if($code_56<=28) break;
						}else{
							if($code_56>28 && $code_56<=56) break;
						}
					}elseif($code_56_val == 1 && $code_110_val ==1){
						if($control_type==0){
							if($code_56<=28 && $code_110<=56) break;
						}else{
							if($code_56>28 && $code_56<=56 && $code_110>56 && $code_110<=110) break;
						}
					}elseif($code_56_val == 1 && $code_110_val ==2){
						if($control_type==0){
							if($code_56<=28 && $code_110>56 && $code_110<=110) break;
						}else{
							if($code_56>28 && $code_56<=56 && $code_110<=56) break;
						}
					}elseif($code_56_val == 2 && $code_110_val ==0){
						if($control_type==0){
							if($code_56>28 && $code_56<=56) break;
						}else{
							if($code_56<=28) break;
						}
					}elseif($code_56_val == 2 && $code_110_val ==1){
						if($control_type==0){
							if($code_56>28 && $code_56<=56 && $code_110<=56) break;
						}else{
							if( $code_56<=28 && $code_110>56 && $code_110<=110) break;
						}
					}elseif($code_56_val == 2 && $code_110_val ==2){
						if($control_type==0){
							if($code_56>28 && $code_56<=56 && $code_110>56 && $code_110<=110) break;
						}else{
							if($code_56<=28 && $code_110<=56) break;
						}
					}
				}	
			}
	//	}
		
		return $data;
    }


    /**
     * 随机产生六位数兑换码
     * @param int $len
     * @param string $format
     * @return string
     * @author
     */
    public function randStr($len=6,$format='ALL') {
        switch($format) {
            case 'ALL':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; break;
            case 'CHAR':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; break;
            case 'NUMBER':
                $chars='0123456789'; break;
            default :
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        mt_srand((double)microtime()*1000000*getmypid());
        $password="";
        while(strlen($password)<$len)
            $password.=substr($chars,(mt_rand()%strlen($chars)),1);
        return $password;
    }

    /**
     * 设置虚拟的中奖记录
     * @author
     */
    public function setOrderLogRand($period = '',$codeid= ''){
        //开奖时间是 10:00 - 2:00
        
        $time_H = date('H');
        $time_i = date('i');
        if(($time_H == 10 && $time_i >= 5)  || $time_H >= 11 || $time_H < 2) {
			$dasuijishu = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,5,10,15,20,25,30,35,40,45,50);
			$xiaosuijishu = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100);
            $data['is_virtual'] = 1;
            $goods_arr = M('Document')->where("category_id = 217 and status = 1")->order(' rand()')->limit(3)->select();//获取所有的商品
            
            foreach ($goods_arr as $key => $val) {
                $data['uid'] = 10000 . rand(9, 205);
                $data['goods_id'] = $val['id'];
				if($val['price']==2){//110价格的产品  最多能买50
					$iii = rand(0, 40);
					$data['buy_num'] = $dasuijishu[$iii];
				}else{//55价格的产品  最多能买100
					$iii = rand(0, 50);
					$data['buy_num'] = $xiaosuijishu[$iii];
				}
                $data['buy_time'] = time() - rand(10,300);
                $data['city'] = $this->getRandCity();
                $data['period'] = $period;
                $data['codeid'] = $codeid;
                M('WinExchange')->add($data);
            }
            echo  date('Y-m-d H:i:s').':To write  is successful.'."\n";

        }
    }

    //  */5 * * * * /usr/bin/curl http://duobao.akng.net/Weixin/Auto/setOrderLogRand  >> /opt/web/order_data.log

    /**
     * 随机获取用户的城市
     * @author gechuan <gechuan@ewangtx.com> 天行云
     */
    public function getRandCity(){
        $id = rand(1,65);
        $cityName = M('Hotcity')->where(array('id'=>$id))->getField('name');
        return $cityName;
    }


//    public function tempdo(){
//        $list = M('WinExchange')->select();
//        dump($list);
//        foreach ($list as $item) {
//            $name = $this->getRandCity();
//            $res = M('WinExchange')->where("id = {$item['id']}")->setField('city',$name);
//            dump($res);
//        }
//    }
    //虚拟用户购买
    public function doorder(){
	    $numb = mt_rand(1,2);
	    $members = M('MemberTemp')->where('pid = 0')->order(' rand()')->limit($numb)->getField('id',true);//虚拟用户
	    $goods =    M('Document')->where("category_id = 217 and status = 1")->order(' rand()')->limit(5)->getField('id,price');//获取所有的商品
	    $lottery_time = $this->get_time_on_clock(time());//下期开奖时间

	    foreach($members as $k=>$v){
		    $data['uid'] = $v;
		    $data['utype'] = 2;
		    $gid = array_rand($goods,1); 
		    $data['goods_id'] = $gid;
		    $data['goods_type'] = $goods[$gid]['price'];
		    $data['num'] = rand(1,20);
		    $data['type'] = rand(1,2);
		    $data['create_time'] = time();
		    $data['order_number'] =  'FD-'.date('YmjHis').sprintf("%07d", $uid).$type.rand(1000,9999);//商户订单号;
		    $data['lottery_time'] = $lottery_time;
		    $data['period'] = $this->getPeriod($lottery_time);//开奖期数
		    $data['status'] = 1;//开奖期数
		    $data['ip_info'] = get_client_ip();
		    $data['paytype'] = '微信';
		    $data['pay_time']= time();
		    if($goods[$gid] == 1){
			    $price  =  28;
			    $data['money_w'] = $data['num']*28;
			    $data['money'] = $data['num']*28;
			    if($data['type'] == 1){
				    $data['number_section'] = '1-28';
			    }elseif($data['type'] == 2){
				    $data['number_section'] = '29-56';
			    }
		    }elseif($goods[$gid] == 2){
			    $price  =  55;
			    $data['money_w'] = $data['num']*55;
			    $data['money'] = $data['num']*55;
			    if($data['type'] == 1){
				    $data['number_section'] = '1-55';
			    }elseif($data['type'] == 2){
				    $data['number_section'] = '56-110';
			    }
		    }
		    //  var_dump($data);exit;
		    M('WinOrder')->add($data);
		    //$snum =mt_rand(1,50);
		    //sleep($snum);
	    }


    }
}
