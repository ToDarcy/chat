<?php
namespace app\home\controller;
use \my\WebSocket;

class IndexController extends CommonController
{

    /**
     * 前台首页
     */
    public function index()
    {
    	if(isMobile()){
    		$url = "http://todarcy.com/";
			header("Location: {$url}");exit;
		}else{
	        return $this->fetch();
	    }
    }
    
}