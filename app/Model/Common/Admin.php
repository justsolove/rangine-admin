<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
use W7\App\Model\Common\Token;
class Admin extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'admin';
   // 主键设置
    protected $primaryKey  = 'admin_id';

    protected $hidden = ['password', 'is_delete'];

    public $error = '';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps    = false;

    /**
     * 登录账号
     */
    public function loginAdmin($data, $isGetToken = true){
        // 根据账号获取
        $map[]=['username','=',$data['username']];
        $map[]=['is_delete','=',0];
        $result = self::where($map)->get()->first();
        if (!$result) {
            return is_null($result) ? '账号不存在' : false;
        }
        if ($result['status'] !== 1) {
            return '账号已禁用';
        }
       // idd(user_md5('123456'));
        if (!hash_equals($result['password'], user_md5($data['password']))) {
            return '密码错误';
        }
        $data['last_login'] = time();
        $data['last_ip'] = getClientIp();
        // 登录日志处理
        if (!$isGetToken) {
            return ['admin' => $result];
        }
        $adminId = $result['admin_id'];
        $groupId = $result['group_id'];
        $tokenDb = new Token();
        $tokenResult = $tokenDb->setToken($adminId, $groupId, 1, $data['username'], $data['platform']);
        if (false === $tokenResult) {
            return "token false";
        }
        return ['admin' => $result, 'token' => $tokenResult];
    }

    /**
     * 注销账号
     * @access public
     * @return bool
     * @throws
     */
    public function logoutAdmin($data)
    {
        idb()->table('token')
            ->where('client_id','=',get_client_id())
            ->where('client_type','=',1)
            ->where('token' ,'=',$data['token'])->delete();
        return true;
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
    /**
     * 获取账号列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getAdminList($data)
    {
        // 搜索条件
        $map = [];
        is_empty_parm($data['group_id']) ?: $map[] = ['admin.group_id','=', $data['group_id']];
        is_empty_parm($data['status']) ?: $map[] = ['admin.status','=', $data['status']];
        $map[] = ['admin.is_delete','=', '0'];
        $totalResult =  idb()->table('admin')
            ->where($map)
            ->where(function ($query) use($data) {
                if(isset($data['account'])&&!empty($data['account'])){
                    $query->where('username', '=', $data['account'])
                        ->orWhere('nickname', '=', $data['account']);
                }
            })
            ->count();
        if ($totalResult <= 0) {
            return ['total_result' => 0];
        }
        // 翻页页数
        $pageNo = isset($data['page_no']) ? $data['page_no'] : 1;

        // 每页条数
        $pageSize = isset($data['page_size']) ? $data['page_size'] : 20;
        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';
        $page=$pageNo-1;
        if ($page != 0) {
            $startNum = $pageSize * $page;
        }else{
            $startNum =0;
        }
        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'admin_id';
        $result = Admin::with('getAuthGroup')
            ->where($map)
            ->where(function ($query) use($data) {
                if(isset($data['account'])&&!empty($data['account'])){
                    $query->where('admin.username', '=', $data['account'])
                        ->orWhere('admin.nickname', '=', $data['account']);
                }

            })
            ->orderBy('admin.' . $orderField,$orderType)
            ->offset($startNum)
            ->limit($pageSize)
            ->get()
            ->map(function($item) {
                if($item->last_login){
                    $item->last_login = date("Y-m-d H:i:s",$item->last_login);
                }else{
                    $item->last_login ='-';
                }
                return $item;
            });

        if (false !== $result) {
            return ['items' => $result->toArray(), 'total_result' => $totalResult];
        }

        return false;
    }

    public function getAuthGroup()
    {
        return $this->belongsTo('W7\App\Model\Common\AuthGroup','group_id','group_id');
    }
    /**
     * 批量设置账号状态
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setAdminStatus($data)
    {
        idb()->transaction(function () use($data) {
            idb()->table('admin')
                ->whereIn('admin_id', $data['client_id'])
                ->update(['status' => $data['status']]);

            Token::where([['client_type', '=', 1]])
                ->whereIn('client_id', $data['client_id'])
                ->delete();
        });
        return true;
    }
    /**
     * 添加一个账号
     * @access public
     * @param  array $data 外部数据
     * @return array|bool
     * @throws
     */
    public function addAdminItem($data)
    {
        $admin = new Admin();
        if(!isset($data['username'])||!$data['username']){
            return $this->setError('请输入账号');
        }
        if(!isset($data['password'])||!$data['password']){
            return $this->setError('请输入密码');
        }
        if(!isset($data['nickname'])||!$data['nickname']){
            return $this->setError('请输入昵称');
        }
        if(!isset($data['group_id'])||!$data['group_id']){
            return $this->setError('请选择用户组');
        }
        $admin->username=isset($data['username']) ? $data['username'] : '';
        if(trim($data['password'])!=trim($data['password_confirm'])){
            return $this->setError('两次输入密码不一致');
        }
        $admin->password=isset($data['password']) ? user_md5($data['password']) : '';
        $admin->group_id=isset($data['group_id']) ? $data['group_id'] : '';
        $admin->nickname=isset($data['nickname']) ? $data['nickname'] : '';
        $admin->head_pic=isset($data['head_pic']) ? $data['head_pic'] : '';
        $admin->create_time = time();
        $admin->update_time = time();
        if($admin->save()){
            return $admin->toArray();
        }else{
            return false;
        }

    }

    /**
     * 编辑一个账号
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setAdminItem($data)
    {
        // 数据类型修改
        $data['client_id'] = (int)$data['client_id'];

        if (!empty($data['nickname'])) {
            $nickMap[] = ['admin_id','!=', $data['client_id']];
            $nickMap[] = ['nickname','=', $data['nickname']];
            $nickMap[] = ['is_delete','=', 0];
            if (self::checkUnique($nickMap)) {
                return $this->setError('昵称已存在');
            }
        }
        $admin  = Admin::find($data['client_id']);
        if (isset($data['group_id'])) {
            Token::where([['client_id','=',$data['client_id']],['client_type','=',1]])->delete();
        }
        $admin->group_id=isset($data['group_id']) ? $data['group_id'] : '';
        $admin->nickname=isset($data['nickname']) ? $data['nickname'] : '';
        $admin->head_pic=isset($data['head_pic']) ? $data['head_pic'] : '';
        $admin->update_time = time();
        if($admin->save()){
            return $admin->toArray();
        }else{
            return false;
        }
        return false;
    }

    /**
     * 重置一个账号密码
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     */
    public function resetAdminItem($data)
    {
        // 初始化部分数据
        $data['password'] = mb_strtolower(get_randstr(8), 'utf-8');
        $map[] = ['admin_id','=', $data['client_id']];

        $rs = idb()->table('admin')
            ->where($map)
            ->update(['password' => user_md5($data['password'])]);
        if($rs){
            return ['password' => $data['password']];
        }else{
            return false;
        }
    }

    /**
     * 修改一个账号密码
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function setAdminPassword($data)
    {
        $result = self::find($data['client_id']);
        if (!$result) {
            return is_null($result) ? $this->setError('账号不存在') : false;
        }

        if (!hash_equals($result->password, user_md5($data['password_old']))) {
            return $this->setError('原始密码错误');
        }
        $map[] = ['admin_id','=', $data['client_id']];
        idb()->beginTransaction();
        $rs = idb()->table('admin')
            ->where($map)
            ->update(['password' => user_md5($data['password'])]);
        if($rs){
            $rs2 = Token::where([['client_id','=',$data['client_id']],['client_type','=',1]])->delete();
            if($rs2){
                idb()->commit();
                return true;
            }else{
                idb()->rollBack();
                return $this->setError('设置失败');
            }

        }else{
            idb()->rollBack();
            return $this->setError('设置失败');
        }
    }
    /**
     * 批量删除账号
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function delAdminList($data)
    {
       // $map[]=['admin_id','in', $data['client_id']];
        idb()->table('admin')
            ->whereIn('admin_id', $data['client_id'])
            ->update(['is_delete' => 1]);

        Token::where([['client_type','=',1]])
                ->whereIn('client_id', $data['client_id'])
                ->delete();
        return true;
    }
    /**
     * 设置模型错误信息
     * @access public
     * @param  string $value 错误信息
     * @return false
     */
    public function setError($value)
    {
        $this->error = $value;
        return false;
    }



}