<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
use W7\App\Model\Common\AuthGroup;
use W7\App\Model\Common\UserLevel;
class User extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'user';

    public $timestamps    = false;

    public $primaryKey  = 'user_id';
    public $incrementing   = true;

    /**
     * hasOne ims_token
     * @access public
     * @return mixed
     */
    public function hasToken()
    {
        return $this->hasOne('Token', 'user_id', 'client_id');
    }

    /**
     * hasOne ims_user_money
     * @access public
     * @return mixed
     */
    public function hasUserMoney()
    {
        return $this->hasOne('userMoney');
    }


    /**
     * hasOne ims_auth_group
     * @access public
     * @return mixed
     */
    public function getAuthGroup()
    {
        return $this
            ->hasOne('W7\App\Model\Common\AuthGroup', 'group_id', 'group_id');
    }

    /**
     * hasOne ims_user_level
     * @access public
     * @return mixed
     */
    public function getUserLevel()
    {
        return $this
            ->hasOne('W7\App\Model\Common\UserLevel', 'user_level_id', 'user_level_id');
    }



    /**
     * 获取账号列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getUserList($data)
    {

        $query = $this->with(['getUserLevel:user_level_id,name,icon,discount','getAuthGroup:group_id,name,status'])
            ->where('user.is_delete',0);



        // 搜索条件
        if( !empty($data['account'])){
            $query = $query->orWhere('user.username',$data['account']);
            $query = $query->orWhere('user.mobile',$data['account']);
            $query = $query->orWhere('user.nickname',$data['account']);
        }
        if( !is_empty_parm($data['user_level_id'])){
            $query = $query->where('user.user_level_id',$data['user_level_id']);
        }
        if( !is_empty_parm($data['group_id'])){
            $query = $query->where('user.group_id',$data['group_id']);
        }
        if( !is_empty_parm($data['status'])){
            $query = $query->where('user.status',$data['status']);
        }

        $totalResult = $query->count();
        if ($totalResult <= 0) {
            return ['total_result' => 0];
        }

        // 每页条数
        $pageSize = isset($data['page_size']) ? $data['page_size'] : 20;
        // 页码
        $pageNo = isset($data['page_no']) ? $data['page_no'] : 1;
        $pageCur = ($pageNo-1) * $pageSize;

        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';
        // 排序的字段
        $orderField = 'user.user_id';
        if (!is_empty_parm($data['order_field'])) {
            switch ($data['order_field']) {
                case 'user_id':
                case 'username':
                case 'mobile':
                case 'nickname':
                case 'group_id':
                case 'sex':
                case 'birthday':
                case 'user_level_id':
                case 'status':
                case 'create_time':
                    $orderField = 'user.'.$data['order_field'];
                    break;
                case 'name':
                case 'discount':
                    $orderField = 'getUserLevel.'.$data['order_field'];
                    break;
            }
        }
        $listResult = $query  ->orderBy($orderField , $orderType)
        ->offset($pageCur)->limit($pageSize)
        ->get()->toArray();
        return ['items' => $listResult, 'total_result' => $totalResult];

    }
    /**
     * 批量设置账号状态
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setUserStatus($data)
    {
        $idList = is_client_admin() ? $data['client_id'] : [0];
        $query = self::whereIn('user_id',$idList);

        if(false !==$query->update(['status' => $data['status']])){
            idb()->table('token')->whereIn('client_id',$idList)->where('client_type',0)->delete();
            return true;
        }
        return false;
    }

    /**
     * 批量删除账号
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function delUserList($data)
    {
        $idList = is_client_admin() ? $data['client_id'] : [0];
        $map['user_id'] = ['in', $idList];
        $query = self::whereIn('user_id',$idList);
        if(false !==$query->update(['is_delete' => 1])){
            idb()->table('token')->whereIn('client_id',$idList)->where('client_type',0)->delete();
            return true;
        }
        return false;

    }

    /**
     * 修改一个账号密码
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setUserPassword($data)
    {
        ['status'=> 200,'message' => 'success', 'data' => ''];
        // 获取实际账号Id
        $userId = is_client_admin() ? $data['client_id'] : get_client_id();

        if (!is_client_admin()) {
            // 获取账号数据
            $result = self::get($userId);
            if (!$result) {
                return is_null($result) ? $this->setError('账号不存在') : false;
            }

            if (empty($data['password_old'])) {
                return $this->setError('原始密码不能为空');
            }

            if (!hash_equals($result->getAttr('password'), user_md5($data['password_old']))) {
                return $this->setError('原始密码错误');
            }
        }

        if (false !== $this->save(['password' => $data['password']], ['user_id' => ['eq', $userId]])) {
            Cache::clear('token:user_' . $userId);
            $this->hasToken()->where(['client_id' => $userId, 'client_type' => 0])->delete();
            return true;
        }

        return false;
    }

    /**
     * 检测是否存在相同值
     * @access public
     * @param  array $map 查询条件
     * @return bool false:不存在
     * @throws
     */
    public static function checkUnique($map)
    {
        if (empty($map)) {
            return true;
        }

        $count = self::where($map)->count();
        if (is_numeric($count) && $count <= 0) {
            return false;
        }

        return true;
    }
}