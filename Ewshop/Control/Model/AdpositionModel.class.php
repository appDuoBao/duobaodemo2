<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Control\Model;
use Think\Model;

/**
 * 广告位模型
 * @author ew_xiaoxiao
 */
class AdpositionModel extends Model{

    protected $_validate = array(
        array('name', 'require', '广告位名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

  	protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /**
     * 获取广告位信息
     * @param  milit   $id 广告位ID或标识
     * @param  boolean $field 查询字段
     * @return array     广告位信息
     * @author ew_xiaoxiao
     */
    public function info($id, $field = true){
        /* 获取优惠券信息 */
        $map = array();
        $map['id'] = $id;
        return $this->field($field)->where($map)->find();
    }

    /**
     * 保存广告位信息
     * @return boolean 更新状态
     * @author ew_xiaoxiao
     */
    public function update(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }

        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add();
        }else{
            $res = $this->save();
        }

        //记录行为
        action_log('update_Adposition', 'Adposition', $data['id'] ? $data['id'] : $res, UID);

        return $res;
    }

    
}
