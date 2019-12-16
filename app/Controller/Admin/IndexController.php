<?php

namespace W7\App\Controller\Admin;

use W7\Core\Controller\ControllerAbstract;
use W7\App;

class IndexController extends ControllerAbstract
{

    public function clearCacheAll(){
        App::getApp()->getCacher()->clear();
        sleep(3);
        return $this->responseJson(['status'=> 200,'message' => 'success', 'data' => true]);
    }
}