<?php

/**
 *  
 * @file   Index.php  
 */  

namespace app\admin\controller;

class IndexController extends CommonController{
    /**
     * 后台首页
     */
    public function index(){
       
        return $this->fetch();
    }
    
    
}