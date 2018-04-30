<?php
/**
 * ZTfx HelloWorld 插件  demo 示例
 * ============================================================================
  
 * 网站地址: http://www.ZTfx.cn
 * ----------------------------------------------------------------------------
  
  
 * ============================================================================
        
  
 */
namespace Admin\Controller;

// 这是一个demo 插件
class HelloWorldController extends BaseController {

    public function index(){        
        $hello = M('HelloWorld')->find();        
        $this->assign('hello',$hello);
        $this->display();
    }
}