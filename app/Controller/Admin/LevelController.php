<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App\Model\Common\UserLevel;

class LevelController extends ControllerAbstract
{

    /**
     * 用户获取未读消息数
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function levelList(){
        $level = new UserLevel();
        $params = [

        ];
        $result = $level->getLevelList($params);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);
    }

    /**
     * 批量删除账号等级
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function levelDelete($data)
    {

        $level = new UserLevel();
        $params = $this->request()->post;
        $result = $level->delLevelList($params);
        if($result !== true){
            return $this->responseJson(['status'=> 500,'message' => $result, 'data' => '']);
        }
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => $result]);

    }


}