<?php

/**
 * ZTfx
 * ============================================================================
  
 * 网站地址: http://www.ZTfx.cn
 * ----------------------------------------------------------------------------
  
  
 * ============================================================================
   
  
 */
 
namespace app\admin\logic;

use think\Model;
use think\Db;

class UsersLogic extends Model
{    
    
    /**
     * 获取指定用户信息
     * @param $uid int 用户UID
     * @param bool $relation 是否关联查询
     *
     * @return mixed 找到返回数组
     */
    public function detail($uid, $relation = true)
    {
        $user = M('admin')->where(array('user_id' => $uid))->relation($relation)->find();
        return $user;
    }
    
    /**
     * 改变用户信息
     * @param int $uid
     * @param array $data
     * @return array
     */
    public function updateUser($uid = 0, $data = array())
    {
        $db_res = M('admin')->where(array("user_id" => $uid))->data($data)->save();
        if ($db_res) {
            return array(1, "用户信息修改成功");
        } else {
            return array(0, "用户信息修改失败");
        }
    }
    
    
    /**
     * 添加用户
     * @param $user
     * @return array
     */
    public function addUser($user)
    {
		$user_count = Db::name('admin')
				->where(function($query) use ($user){
					if ($user['email']) {
						$query->where('email',$user['email']);
					}
					if ($user['mobile']) {
						$query->whereOr('mobile',$user['mobile']);
					}
                    if ($user['user_name']) {
                        $query->whereOr('user_name',$user['user_name']);
                    }
				})
				->count();
		if ($user_count > 0) {
			return array('status' => -1, 'msg' => '账号已存在');
		}
    	$user['password'] = encrypt($user['password']);
    	$user['reg_time'] = time();

        //用户默认角色
        $user['role_id'] = 2;

        //用户等级
        
        //股权
        $user['right'] = 0;
        $user['lev_integral'] = $user['reg_money'];
        $user['reg_integral'] = 0;
        $user['acc_integral'] = 0;
        $user['shop_integral'] = $user['reg_money'];

        $level = Db::name('user_level')->where('amount','<=',$user['reg_money'])->order('amount','desc')->find();
        $user['level'] = $level['level_name'];
        $user['right'] = $level['discount']/100*$user['reg_money'];
        $user['right'] = $user['right'] > $level['describe'] ? $level['describe'] : $user['right'];

        //accountLog($order['user_id'],$order['order_amount'],$order['integral'],'用户申请商品退款',0,$order['order_id'],$order['order_sn']);

    	$user_id = M('admin')->add($user);
    	if(!$user_id){
    		return array('status'=>-1,'msg'=>'添加失败');
    	}else{
    		// $pay_points = tpCache('basic.reg_integral'); // 会员注册赠送积分
    		// if($pay_points > 0)
    		// 	accountLog($user_id, 0 , $pay_points , '会员注册赠送积分'); // 记录日志流水
    		return array('status'=>1,'msg'=>'添加成功');
    	}
    }   

}