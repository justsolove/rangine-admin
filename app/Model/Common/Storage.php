<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Storage extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'storage';
   // 主键设置
    protected $primaryKey  = 'storage_id';

    public $error = '';

    protected $fillable = [
        'name',
        'parent_id',
        'mime',
        'ext',
        'size',
        'pixel',
        'hash',
        'path',
        'url',
        'protocol',
        'type',
    ];
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps    = false;



    /**
     * 获取资源目录选择列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getStorageDirectorySelect($data)
    {

        // 排序方式与排序字段
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'storage_id';

        $result = $this->where('type','=',2)
            ->orderBy($orderField,$orderType)
            ->orderBy('sort','asc')->get()
            ->toArray()?: [];

        return [
            'list'    => $result,
            'default' => self::getDefaultStorageId(),
        ];
    }

    /**
     * 获取默认目录的资源编号
     * @access public
     * @return integer
     */
    public static function getDefaultStorageId()
    {
        $map[] = ['type','=', 2];
        $map[] = ['is_default','=', 1];
        return self::where($map)
                ->value('storage_id') ?: 0;
    }

    public function getImgList($data)
    {
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
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'storage_id';
        $result = self::where('type','=',0)
            ->orderBy($orderField,$orderType)
            ->offset($startNum)
            ->limit($pageSize)
            ->get()
            ->toArray()?: [];

        return $result;
    }
    /**
     * 删除图片
     */
    public function delImg($data){
        if(!isset($data['storage_id'])){
            return $this->setError('缺少参数storage_id！');
        }
        $result=self::find($data['storage_id']);
        if (!$result) {
            return is_null($result) ? $this->setError('数据不存在') : false;
        }
        if($result->delete()){
            return true;
        }else{
            return $this->setError('删除失败！');
        }

    }
    /**
     * 删除图片
     */
    public static function createImg($data){
        $storageDb = Storage::create($data);
        $storageDb->create_time = time();
        $storageDb->update_time = time();
        $rs = $storageDb->save();
        if($rs){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 设置错误信息
     * @access public
     * @param  string $error 错误信息
     * @return false
     */
    public function setError($error)
    {
        $this->error = $error;
        return false;
    }
}