<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class AuthRule extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'auth_rule';
   // 主键设置
    protected $primaryKey  = 'rule_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps    = false;

    protected $fillable = ['module','group_id','name','menu_auth','log_auth','sort','status'];

    public $error = '';


    /**
     * 根据用户组编号与对应模块获取权限明细
     * @access public
     * @param  string $module  对应模块
     * @param  int    $groupId 用户组编号
     * @return array|false
     * @throws
     */
    public static function getMenuAuthRule($module, $groupId)
    {
        // 需要加入游客组的权限(已登录账号也可以使用游客权限)
        if (AUTH_GUEST !== $groupId) {
            $groupId = [$groupId, AUTH_GUEST];
        }

        //$result = self::where($map)->cache(true, null, 'CommonAuth')->select();
        $result = self::get()->where('module',$module)
                            ->where('status',1)
                            ->whereIn('group_id',$groupId);
        $result = $result->toArray();
        $menuAuth = [];
        $logAuth = [];
        $whiteList = [];

        foreach ($result as $value) {
            // 默认将所有获取到的编号都归入数组
            if (!empty($value['menu_auth'])) {
                $value['menu_auth'] =json_decode($value['menu_auth'],1);
                //idd( $value['menu_auth']);
                $menuAuth = array_merge($menuAuth, $value['menu_auth']);

                // 游客组需要将权限加入白名单列表
                if (AUTH_GUEST == $value['group_id']) {
                    $whiteList = array_merge($whiteList, $value['menu_auth']);
                }
            }
            $value['log_auth'] = json_decode( $value['log_auth']);
            if (!empty($value['log_auth'])) {
                $logAuth = array_merge($logAuth, $value['log_auth']);
            }
        }

        return [
            'menu_auth'  => array_unique($menuAuth),
            'log_auth'   => array_unique($logAuth),
            'white_list' => $whiteList,
        ];
    }
    /**
     * 获取规则列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getAuthRuleList($data)
    {
        // 搜索条件
        $map = [];
        empty($data['group_id']) ?: $map[] = ['group_id','=', $data['group_id']];
        is_empty_parm($data['module']) ?$map[] = ['module','=', 'admin']: $map[] = ['module','=', $data['module']];
        is_empty_parm($data['status']) ?: $map[] = ['status','=', $data['status']];

        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'asc';

        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'sort';

        $result = idb()->table('auth_rule')
            ->where($map)
            ->orderBy($orderField,$orderType)->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
        if (false === $result) {
            return false;
        }elseif (count($result)>0){
            foreach ($result as $key=>$value){
                if($value['menu_auth']){
                    $result[$key]['menu_auth'] = json_decode($value['menu_auth'],1);
                }
                if($value['log_auth']){
                    $result[$key]['log_auth'] = json_decode($value['log_auth'],1);
                }
            }
        }

        return $result;
    }
    /**
     * 编辑一条规则
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setAuthRuleItem($data)
    {
        // 数组字段特殊处理
        if (isset($data['menu_auth']) && '' == $data['menu_auth']) {
            $data['menu_auth'] = [];
        }else{
            $data['menu_auth'] = json_encode($data['menu_auth'] );
        }

        if (isset($data['log_auth']) && '' == $data['log_auth']) {
            $data['log_auth'] = [];
        }else{
            $data['log_auth'] = json_encode($data['log_auth'] );
        }

        // 获取原始数据
        $result = self::find($data['rule_id']);
        if (!$result) {
            return is_null($result) ? $this->setError('数据不存在') : false;
        }

        if (!empty($data['module'])) {
            $map[] = ['rule_id','!=', $data['rule_id']];
            $map[] = ['module','=', $data['module']];
            $map[] = ['group_id','=', $data['group_id']];

            if (self::checkUnique($map)) {
                return $this->setError('当前模块下已存在相同用户组');
            }
        }
        $result->fill($data);
        if ($result->save()) {
            return $result->toArray();
        }else{
            return $this->setError('操作失败');
        }
    }
    /**
     * 添加一条规则
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addAuthRuleItem($data)
    {
        // 避免无关字段
        unset($data['rule_id']);
        // 数组字段特殊处理
        if (isset($data['menu_auth']) && '' == $data['menu_auth']) {
            $data['menu_auth'] = [];
        }else{
            $data['menu_auth'] = json_encode($data['menu_auth'] );
        }

        if (isset($data['log_auth']) && '' == $data['log_auth']) {
            $data['log_auth'] = [];
        }else{
            $data['log_auth'] = json_encode($data['log_auth'] );
        }

        $map[] = ['module','=', $data['module']];
        $map[] = ['group_id','=', $data['group_id']];

        if (self::checkUnique($map)) {
            return $this->setError('当前模块下已存在相同用户组');
        }
        $result= new AuthRule();
        $result->create($data);
        if ($result->save()) {
            return $result->toArray();
        }else{
            return $this->setError('操作失败');
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
     * 批量设置规则状态
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setAuthRuleStatus($data)
    {

        $rs = idb()->table('auth_rule')
            ->whereIn('rule_id', $data['rule_id'])
            ->update(['status' => $data['status']]);
        if($rs){
            return true;
        }else{
            return $this->setError('设置失败');
        }
    }

    /**
     * 批量删除规则
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delAuthRuleList($data)
    {
        self::destroy($data['rule_id']);
        return true;
    }

    /**
     * 根据编号自动排序
     * @access public
     * @param  $data
     * @return bool
     * @throws \Exception
     */
    public function setAuthRuleIndex($data)
    {
        $list = [];
        foreach ($data['rule_id'] as $key => $value) {
            $list[] = ['rule_id' => $value, 'sort' => $key + 1];
        }

        foreach ($list as $key=>$value){
            idb()->table('auth_rule')
                ->where('rule_id','=',$value['rule_id'])
                ->update(['sort' => $value['sort']]);
        }
        return true;
    }

}