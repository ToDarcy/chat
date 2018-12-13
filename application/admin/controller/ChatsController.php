<?php
namespace app\admin\controller;
use think\Controller;

class ChatsController extends Controller
{
    public function index()
    {
        $info = db('Customer_service')->field('id,uid,name,is_online,client_id')->order("is_online desc")->select();
        $this->assign('info', empty($info) ? [] : $info);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    public function chat()
    {
    	$this->view->engine->layout(false);
    	return $this->fetch();
    }


}
