<?php
// +----------------------------------------------------------------------
// | 微信管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2017  All rights reserved.
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

namespace Weixin\Logic;

/**
 * 文档模型子模型 - 文章模型
 */
class ArticleLogic extends BaseLogic{
	/* 自动验证规则 */
	protected $_validate = array(
		array('content', 'require', '内容不能为空！', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);

	/* 自动完成规则 */
	protected $_auto = array();

}
