<?php

/**
 *  后台继承类
 */

namespace app\admin\controller;
use think\Loader;

class CustomerServiceController extends CommonController {

    public function index() 
    {
        return $this->fetch();
    }

    public function upClientId()
    {
    	$client_id = trim($_GET["client_id"]);
    	if($client_id == ""){
    		return show_json(0,"id不能为0");
    	}
    	$data = ["client_id" => $client_id];
        //修改客服管理员登录在线状态
        $res = Loader::model('CustomerService')->editInfo($this->CustomerServiceId, $data);
        if($res > 0 && $res != false){
        	return show_json(1,"成功");
        }else{
        	return show_json(0,"失败");
        }
    }
}
