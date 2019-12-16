<?php
/**
 * @author donknap
 * @date 18-11-12 下午4:21
 */

namespace W7\App\Controller\Home;


use W7\Core\Controller\ControllerAbstract;
use W7\Core\Database\ModelAbstract;
use Illuminate\Support\Facades\DB;
use W7\App\Model\Home\User;
class WelcomeController extends ControllerAbstract {
	/**
	 * 访问URL http://127.0.0.1:88/
	 */
	public function index() {

        $users = idb()->select('select * from `ims_user` where user_id = ?', [1]);
        //$phone = Users::find(1)->phone;
		return $this->responseJson($users);
	}


}