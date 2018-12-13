<?php

/**
 *  
 * @file   admin.php  
 */

namespace app\admin\model;

use think\Db;

class CustomerService extends \think\Model 
{

    /**
     * 登陆更新客服在线状态
     * @param 0:不在线,1:在线
     * @param int $id id
     * @param array $data 更新的数据
     */
    public function editInfo($id, $data = array()) {
        $res = $this->allowField(true)->save($data, ['id' => $id]);
        return $res;
    }

}
