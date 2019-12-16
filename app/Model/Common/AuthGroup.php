<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class AuthGroup extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'auth_group';
   // 主键设置
    protected $primaryKey  = 'group_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps    = false;

    public $error='';
    /**
     * 获取用户组列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getAuthGroupList($data)
    {
        $query = self::orderBy($data['order_field'],$data['order_type']);

        // 搜索条件
        if(isset($data['exclude_id']) ){
            $query = $query->whereNotIn('group_id',$data['exclude_id']);
        }
        if(!is_empty_parm($data['status']) ){
            $query = $query->where('status', $data['status']);
        }

        return  $query->get()->toArray();

    }
    /**
     * 编辑一个用户组
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setAuthGroupItem($data)
    {
       // $map['group_id'] = ['eq', $data['group_id']];
        $auth_group = self::get()->where('group_id',$data['group_id'])
            ->first();

        if(!$auth_group){
            return false;
        }
        $auth_group->name=isset($data['name'])?$data['name']:'';
        $auth_group->description=isset($data['description'])?$data['description']:'';
        $auth_group->sort=isset($data['sort'])?$data['sort']:'';
        $auth_group->status=isset($data['status'])?$data['status']:'';
        if($auth_group->save()){
            return $auth_group->toArray();
        }else{
            return false;
        }
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
    /**
     * 设置用户组排序
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setAuthGroupSort($data)
    {
        $auth_group = self::get()->where('group_id',$data['group_id'])
            ->first();

        if(!$auth_group){
            return false;
        }
        $auth_group->sort=isset($data['sort'])?$data['sort']:'';
        if($auth_group->save()){
            return $auth_group->toArray();
        }else{
            return false;
        }
    }

    /**
     * 添加一个用户组
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addAuthGroupItem($data)
    {
        $auth_group=new AuthGroup();
        $auth_group->name=isset($data['name'])?$data['name']:'';
        $auth_group->description=isset($data['description'])?$data['description']:'';
        $auth_group->sort=isset($data['sort'])?$data['sort']:'';
        $auth_group->status=isset($data['status'])?$data['status']:'';
        if($auth_group->save()){
            return $auth_group->toArray();
        }else{
            return false;
        }
    }
    /**
     * 删除一个用户组
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function delAuthGroupItem($data)
    {
        $auth_group = self::get()->where('group_id',$data['group_id'])
            ->first();
        if (!$auth_group) {
            return is_null($auth_group) ? $this->setError('数据不存在') : false;
        }

        if ($auth_group->system === 1) {
            return $this->setError('系统级用户组不可以删除');
        }
        // 查询是否已被使用
        if (User::checkUnique([['group_id','=',$data['group_id']]])) {//['group_id' => $data['group_id']]
            return $this->setError('当前用户组已被使用');
        }

        if (Admin::checkUnique([['group_id','=',$data['group_id']]])) {
            return $this->setError('当前用户组已被使用');
        }

        // 删除本身与规则表中的数据
        idb()->beginTransaction();
        $rs1=$auth_group->delete();
        $authRule = AuthRule::get()->where('group_id',$data['group_id'])->first();
        if($authRule&&count($authRule)>0){
            $rs2=AuthRule::where('group_id',$data['group_id'])->delete();
            if($rs1&&$rs2){
                idb()->commit();
            }else{
                idb()->rollBack();
                return $this->setError('删除失败1');
            }
        }else{
            if($rs1){
                idb()->commit();
            }else{
                idb()->rollBack();
                return $this->setError('删除失败2');
            }
        }

        return true;
    }
    /**
     * hasMany cs_auth_rule
     * @access public
     * @return mixed
     */
    public function hasAuthRule()
    {
        return $this->hasMany('AuthRule', 'group_id');
    }

    /**
     * 批量设置用户组状态
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setAuthGroupStatus($data)
    {
        $rs = idb()->table('auth_group')
            ->whereIn('group_id', $data['group_id'])
            ->update(['status' => $data['status']]);
        if($rs){
            return true;
        }else{
            return false;
        }
    }
}