<?php
/**
 * ZTfx
 */

namespace app\admin\controller;
use think\Page;
use think\Db;

class Zts extends Base{

    public function index(){

    }   

    public function user(){
    	$user_id = session('user_id');
    	$user = M('admin')->where('user_id',$user_id)->find();
    	$this->assign('user',$user);
        return $this->fetch();
    }

    public function pwd(){
        if(IS_POST){
        	$password = I('post.password');
            $paypwd = I('post.paypwd');
          	if($password == ''){
                unset($_POST['password']);
            }else{
                $_POST['password'] = encrypt($_POST['password']);
            }

			if($paypwd == ''){
                unset($_POST['paypwd']);
            }else{
                $_POST['paypwd'] = encrypt($_POST['paypwd']);
            }
            $uid = session('user_id');
            $row = M('admin')->where(array('user_id'=>$uid))->save($_POST);
            if($row)
                exit($this->success('修改成功'));
            exit($this->error('未作内容修改或修改失败'));
        }

    	return $this->fetch();	
    }

    public function bank(){
   		$user_id = session('user_id');
    	$user = M('admin')->where('user_id',$user_id)->find();
    	$this->assign('user',$user);

        if(IS_POST){
          	if(encrypt($_POST['pass']) != $user['paypwd']){
          		$this->error('交易密码错误');
          		exit;
          	}

            $row = M('admin')->where(array('user_id'=>$uid))->save($_POST);
            if($row)
                exit($this->success('修改成功'));
            exit($this->error('未作内容修改或修改失败'));
        }

        return $this->fetch();
    }
}