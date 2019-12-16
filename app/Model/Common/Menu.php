<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Menu extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'menu';
   // 主键设置
    protected $primaryKey  = 'menu_id';

    public $timestamps    = false;

    protected $fillable = ['parent_id','name','alias','icon','remark','module','type','url','params','target','is_navi','sort','status'];


    public $error = '';
    /**
     * 根据权限获取菜单列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     */
    public function getMenuAuthList($data)
    {
//        if (!$this->validateData($data, 'Menu.auth')) {
//            return false;
//        }

        // 获取当前登录账号对应的权限数据
       // $ruleResult = AuthRule::getMenuAuthRule($data['module'], get_client_group());

        $ruleResult = AuthRule::getMenuAuthRule($data['module'], get_client_group());
        if (empty($ruleResult['menu_auth'])) {
            return [];
        }

        // 当规则表中存在菜单权限时进行赋值,让获取的函数进行过滤
       // self::$menuAuth = [];
        $menuAuth = $ruleResult['menu_auth'];

        //idd($ruleResult['menu_auth'] );
        $menuId = isset($data['menu_id']) ? $data['menu_id'] : 0;
        $result = self::getMenuListData($data['module'], $menuId, true,null,null,$menuAuth);
      //  idd(self::$menuAuth);

        return $result;
    }

    /**
     * 根据条件获取菜单列表数据
     * @access public static
     * @param  string $module  所属模块
     * @param  int    $menuId  菜单Id
     * @param  bool   $isLayer 是否返回本级菜单
     * @param  int    $level   菜单深度
     * @param  array  $filter  过滤'is_navi'与'status'
     * @return array|false
     * @throws
     */
    public static function getMenuListData($module, $menuId = 0, $isLayer = false, $level = null, $filter = null,$menuAuth = array())
    {

        // 搜索条件
        $joinMap = "";
        //$map = "ims_m.module = ".$module;
        $map = sprintf("ims_m.module = '%s'", $module);;

        // 过滤'is_navi'与'status'
        foreach ((array)$filter as $key => $value) {
            if ($key != 'is_navi' && $key != 'status') {
                continue;
            }
            $map .= sprintf(' AND ims_m.%s = %d', $key, $value);
            $joinMap .= sprintf(' AND ims_s.%s = %d', $key, $value);
        }
        if($joinMap){
            $joinMap = substr($joinMap,4);
        }

        $result = idb()->table('menu as m')
            ->selectRaw('ims_m.*,count(ims_s.menu_id) children_total')
            ->leftJoin('menu as s',function ($join) use ($joinMap){
                $join = $join->on( 's.parent_id', '=', 'm.menu_id');
                if($joinMap){
                    $join->whereRaw($joinMap);
                }
            })
            ->whereRaw($map)
            ->groupBy('m.menu_id')
            ->orderBy('m.parent_id')
            ->orderBy('m.sort')
            ->orderBy('m.menu_id')
            ->get();

        if (false === $result) {

            return false;
        }

        $tree = self::setMenuTree((int)$menuId, $result, $level, $isLayer,0,$menuAuth);
        if (!empty($menuAuth)) {
            foreach ($result as $value) {
                $value->level= 0;
                $tree[] = $value;
            }
        }

        return $tree;
    }

    /**
     * 过滤和排序所有菜单
     * @access private
     * @param  int    $parentId   上级菜单Id
     * @param  object $list       原始模型对象
     * @param  int    $limitLevel 显示多少级深度 null:全部
     * @param  bool   $isLayer    是否返回本级菜单
     * @param  int    $level      层级深度
     * @return array
     */
    private static function setMenuTree($parentId, &$list, $limitLevel = null, $isLayer = false, $level = 0,$menuAuth= array(),&$tree =[])
    {
        $parentId != 0 ?: $isLayer = false; // 返回全部菜单不需要本级
        foreach ($list as $key => $value) {
            // 获取菜单主Id
            $menuId = $value->menu_id;

            // 优先处理:存在权限列表则需要检测,否则删除节点
            if (!empty($menuAuth) && !in_array($menuId, $menuAuth)) {
                unset($list[$key]);
                continue;
            }

            // 判断菜单是否存在继承关系
            if ($value->parent_id !== $parentId && $menuId !== $parentId) {
                continue;
            }

            // 是否返回本级菜单
            if ($menuId === $parentId && !$isLayer) {
                continue;
            }

            // 限制菜单显示深度
            if (!is_null($limitLevel) && $level > $limitLevel) {
                break;
            }

            $value->level= $level;
            $tree[] = (array)$value;

            // 需要返回本级菜单时保留列表数据,否则引起树的重复,并且需要自增层级
            if (true == $isLayer) {
                $isLayer = false;
                $level++;
                continue;
            }

            // 删除已使用数据,减少查询次数
            unset($list[$key]);

            if ($value->children_total > 0) {
                self::setMenuTree($menuId, $list, $limitLevel, $isLayer, $level + 1,$menuAuth,$tree);
            }
        }

        return   $tree;
    }
    /**
     * 获取菜单列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     */
    public function getMenuList($data)
    {
        $menuId = isset($data['menu_id']) ? $data['menu_id'] : 0;
        $isLayer = !is_empty_parm($data['is_layer']) ? (bool)$data['is_layer'] : true;
        $level = isset($data['level']) ? $data['level'] : null;

        $filter = null;
        is_empty_parm($data['is_navi']) ?: $filter['is_navi'] = $data['is_navi'];
        is_empty_parm($data['status']) ?: $filter['status'] = $data['status'];

        return self::getMenuListData($data['module'], $menuId, $isLayer, $level, $filter);
    }

    /**
     * 编辑一个菜单
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setMenuItem($data)
    {
        $result = self::find($data['menu_id']);
        if (!$result) {
            return is_null($result) ? $this->setError('数据不存在') : false;
        }

        // 检测编辑后是否存在重复URL
        empty($data['url']) ?: $data['url'] = $data['url'];
        isset($data['type']) ?: $data['type'] = $result->type;
        isset($data['url']) ?: $data['url'] = $result->url;

        if (!empty($data['url']) && 0 == $data['type']) {
            $map[] = ['menu_id','!=',$data['menu_id']];
            $map[] = ['module','=',$result->module];
            $map[] = ['type','=',0];
            $map[] = ['url','=',$data['url']];
            if (self::checkUnique($map)) {
                return $this->setError('Url已存在');
            }
        }

        // 父菜单不能设置成自身或所属的子菜单
        if (isset($data['parent_id'])) {
            if ($data['parent_id'] == $data['menu_id']) {
                return $this->setError('上级菜单不能设为自身');
            }

            $menuList = self::getMenuListData($result->module, $data['menu_id']);
            if (false === $menuList) {
                return false;
            }

            foreach ($menuList as $value) {
                if ($data['parent_id'] == $value['menu_id']) {
                    return $this->setError('上级菜单不能设为自身的子菜单');
                }
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
     * 添加一个菜单
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addMenuItem($data)
    {
        // 避免无关字段,并且转换格式
        unset($data['menu_id']);

        if (!empty($data['url']) && 0 == $data['type']) {
            $map[] = ['module','=',$data['module']];
            $map[] = ['type','=',0];
            $map[] = ['url','=',$data['url']];
            if (self::checkUnique($map)) {
                return $this->setError('Url已存在');
            }
        }
        $result = new Menu();
        $result->create($data);
        if ($result->save()) {
            return $result->toArray();
        }else{
            return $this->setError('操作失败');
        }
    }

    /**
     * 设置菜单状态(影响上下级菜单)
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setMenuStatus($data)
    {
        $result = self::find($data['menu_id']);
        if (!$result) {
            return is_null($result) ? $this->setError('数据不存在') : false;
        }

        if ($result->status == $data['status']) {
            return $this->setError('状态未改变');
        }

        // 获取当前菜单模块名
        $module = $result->module;

        // 如果是启用,则父菜单也需要启用
        $parent = [];
        if ($data['status'] == 1) {
            $parent = self::getParentList($module, $data['menu_id'], false);
            if (false === $parent) {
                return false;
            }
        }

        // 子菜单则无条件继承
        $children = self::getMenuListData($module, $data['menu_id'], true);
        if (false === $children) {
            return false;
        }

        $parent = array_column($parent, 'menu_id');
        $children = array_column($children, 'menu_id');

        $rs = idb()->table('menu')
            ->whereIn('menu_id', array_merge($parent, $children))
            ->where('status','=',$result->status)
            ->update(['status' => $data['status']]);
        if($rs){
            return ['parent' => $parent, 'children' => $children, 'status' => (int)$data['status']];
        }else{
            return false;
        }
    }

    /**
     * 根据编号获取上级菜单列表
     * @access public
     * @param  string $module  所属模块
     * @param  int    $menuId  菜单编号
     * @param  bool   $isLayer 是否返回本级
     * @param  array  $filter  过滤'is_navi'与'status'
     * @return array|false
     */
    public static function getParentList($module, $menuId, $isLayer = false, $filter = null)
    {
        // 搜索条件
        $map[] = ['module','=',$module];
        // 过滤'is_navi'与'status'
        foreach ((array)$filter as $key => $value) {
            if ($key != 'is_navi' && $key != 'status') {
                continue;
            }
            $map[] = [$key,'=',$value];
        }

        $list = self::where($map)->get();
        if ($list === false) {
            return false;
        }else{
            foreach ($list as $key=>$value){
                $list[$value['menu_id']] = $value;
            }
        }

        // 判断是否根据url获取
        if (isset($filter['url'])) {
            $url = array_column($list, 'menu_id', 'url');
            if (isset($url[$filter['url']])) {
                $menuId = $url[$filter['url']];
                unset($url);
            }
        }

        // 是否返回本级
        if (!$isLayer && isset($list[$menuId])) {
            $menuId = $list[$menuId]['parent_id'];
        }


        $result = [];
        while (true) {
            if (!isset($list[$menuId])) {
                break;
            }
            $result[] = $list[$menuId];

            if ($list[$menuId]['parent_id'] <= 0) {
                break;
            }

            $menuId = $list[$menuId]['parent_id'];
        }

        return array_reverse($result);
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
     * URL驼峰转下划线修改器
     * @access protected
     * @param  string $value 值
     * @return string
     */
    private function strToSnake($value)
    {
        if (empty($value) || !is_string($value)) {
            return $value;
        }

        $word = explode('/', $value);
        $word = array_map(['think\\helper\\Str', 'snake'], $word);

        return implode('/', $word);
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
            return $count;
        }

        return $count;
    }

    /**
     * 删除一个菜单(影响下级子菜单)
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function delMenuItem($data)
    {
        $result = self::find($data['menu_id']);
        if (!$result) {
            return is_null($result) ? $this->setError('数据不存在') : false;
        }

        $menuList = self::getMenuListData($result->module, $data['menu_id'], true);
        if (false === $menuList) {
            return false;
        }

        $delList = array_column($menuList, 'menu_id');
        self::destroy($delList);
        return ['children' => $delList];
    }

    /**
     * 根据编号自动排序
     * @access public
     * @param  $data
     * @return bool
     * @throws \Exception
     */
    public function setMenuIndex($data)
    {
        $list = [];
        foreach ($data['menu_id'] as $key => $value) {
            $list[] = ['menu_id' => $value, 'sort' => $key + 1];
        }
        foreach ($list as $key=>$value){
            idb()->table('menu')
                ->where('menu_id','=',$value['menu_id'])
                ->update(['sort' => $value['sort']]);
        }
        return true;
    }
}