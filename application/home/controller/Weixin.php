<?php
/**
 * ZTfx
 * ============================================================================
  
 * 网站地址: http://www.ZTfx.cn
 * ----------------------------------------------------------------------------
  
  
 *    
 * ============================================================================
 */

namespace app\home\controller;

use app\common\logic\WechatLogic;

class Weixin
{
    /**
     * 处理接收推送消息
     */
    public function index()
    {
        $logic = new WechatLogic;
        $logic->handleMessage();
    }
    
}