<?php

/**
 *  后台继承类
 */

namespace app\admin\controller;
use think\Loader;

class WarehouseController extends CommonController {

    public function index() {
        $lists = db('goods')->alias('G')->field('G.id,G.name,G.stock,G.type,G.add_time,G.up_time,G.operator,A.username')
                ->join(config('database.prefix').'admin A', 'G.operator=A.id', 'left')
                ->order('G.id desc')
                ->select();
     
        foreach ($lists as &$v) {
            $v["add_time"] = dateSwitch($v["add_time"]);
            $v["up_time"] = dateSwitch($v["up_time"]);
        }

        $this->assign('lists', $lists);
        return $this->fetch();
    }

}
