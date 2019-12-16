<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Region extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'region';
   // 主键设置
    protected $primaryKey  = 'region_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps    = false;

    protected $fillable = ['parent_id','region_name', 'sort'];

//    protected $hidden = [
//        'router',
//        'help_id',
//        'ver',
//        'module',
//    ];
    public static $keyList = null;
    /**
     * 获取指定Id下的子节点
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getRegionList($data)
    {

        // 是否提取已删除区域
        $map[] = ['is_delete','=',0];
        $map[] = isset($data['region_id']) ? ['parent_id','=', $data['region_id']] : ['parent_id','=', 0];
        $result = self::where($map)->orderBy('sort')->orderBy('region_id')->get();

        if (false !== $result) {
            return $result->toArray();
        }

        return false;
    }

    /**
     * 获取指定Id下的所有子节点
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     */
    public function getRegionSonList($data)
    {
        // 是否提取已删除区域
        $isDelete = !is_empty_parm($data['region_all']) ? (bool)$data['region_all'] : false;
        isset($data['region_id']) ?: $data['region_id'] = 0;
        $regionList = self::getRegionCacheList();

         $result = [];
        self::getRegionChildrenList($data['region_id'], $result, $regionList, $isDelete);

        return $result;
    }

    /**
     * 获取区域缓存列表
     * @access public
     * @return array|false
     */
    public static function getRegionCacheList()
    {
        return self::orderBy('sort')->orderBy('region_id')->get()->toArray();
    }

    /**
     * 过滤和排序所有区域
     * @access private
     * @param  int   $id    上级区域Id
     * @param  array &$tree 树结构
     * @param  array &$list 原始数据结构
     * @param  bool  $isDelete 是否提取已删除区域
     * @return void
     */
    private static function getRegionChildrenList($id, &$tree, &$list, $isDelete)
    {

        if (is_null(self::$keyList)) {
            self::$keyList = array_column($list, 'parent_id', 'parent_id');
        }

        foreach ($list as $value) {
            if ($value['parent_id'] != $id) {
                continue;
            }

            if (!$isDelete && $value['is_delete'] == 1) {
                continue;
            }

            if (!$isDelete) {
                unset($value['is_delete']);
            }

            $tree[] = $value;
            if ($value['region_id'] != 0 && isset(self::$keyList[$value['region_id']])) {
                self::getRegionChildrenList($value['region_id'], $tree, $list, $isDelete);
            }
        }
    }

    /**
     * 添加一个区域
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addRegionItem($data)
    {
        return $this->create($data)->save();
    }

    /**
     * 编辑一个区域
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setRegionItem($data)
    {
        return $this->where('region_id','=',$data['region_id'])->update(['region_name' => $data['region_name'],'sort' => $data['sort']]);
    }

    /**
     * 批量删除区域
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delRegionList($data)
    {

        return $this->whereIN('region_id',$data['region_id'])->update(['is_delete' => 1]);

    }

    /**
     * 根据编号自动排序
     * @access public
     * @param  $data
     * @return bool
     * @throws \Exception
     */
    public function setRegionIndex($data)
    {

        $list = [];
        foreach ($data['region_id'] as $key => $value) {
            $list[] = ['region_id' => $value, 'sort' => $key + 1];
        }

        if (false !== $this->isUpdate()->saveAll($list)) {
            Cache::rm('DeliveryArea');
            return true;
        }

        return false;
    }




}