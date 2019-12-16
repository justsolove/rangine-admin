<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
use W7\App\Model\Common\Article;
class ArticleCat extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'article_cat';
    // 主键设置
    protected $primaryKey  = 'article_cat_id';

    public $timestamps    = false;

    public $error = '';
    /**
     * 获取分类所有列表
     * @access public static
     * @param  int  $catId   分类Id
     * @param  bool $isLayer 是否返回本级分类
     * @param  int  $level   分类深度
     * @param  int  $isNavi  过滤是否导航
     * @return array|false
     * @throws
     */
    public  function getArticleCatList($catId = 0, $isLayer = false, $level = null, $isNavi = null)
    {
        $map = [];
        is_null($isNavi) ?: $map[] = ['c.is_navi','=', $isNavi];

        $result = idb()->table('article_cat as c')
            ->selectRaw('ims_c.*,count(ims_s.article_cat_id) children_total,ifnull(ims_a.num, 0) aricle_total')
            ->leftJoin('article_cat as s',function ($join) {
                $join->on( 's.parent_id', '=', 'c.article_cat_id');
            })
            ->leftJoin(idb()->raw("(SELECT article_cat_id,count(*) num FROM `ims_article` GROUP BY `article_cat_id`) as ims_a"),function ($join) {
                $join->on( 'a.article_cat_id', '=', 'c.article_cat_id');
            })
            ->where($map)
            ->groupBy('c.article_cat_id')
            ->orderBy('c.parent_id')
            ->orderBy('c.sort')
            ->orderBy('c.article_cat_id')
            ->get()
            ->toArray();
        $result=$this->getList($result);
        if (false === $result) {
            return false;
        }
        // 处理原始数据至菜单数
        $tree = $this->setArticleCatTree($catId, $result, $level, $isLayer);
        return $tree;
    }
    /**
     * 过滤和排序所有分类
     * @access private
     * @param  int    $parentId   上级分类Id
     * @param  object $list       原始模型对象
     * @param  int    $limitLevel 显示多少级深度 null:全部
     * @param  bool   $isLayer    是否返回本级分类
     * @param  int    $level      分类深度
     * @return array
     */
    public  function setArticleCatTree($parentId, $list, $limitLevel = null, $isLayer = false, $level = 0,&$tree=[])
    {
//        static $tree = [];
        $parentId != 0 ?: $isLayer = false; // 返回全部分类不需要本级

        foreach ($list as $key => $value) {
            // 获取分类主Id

            $articleCatId = $value['article_cat_id'];
            if ($value['parent_id'] !== $parentId && $articleCatId !== $parentId) {
                continue;
            }
            // 是否返回本级分类
            if ($articleCatId === $parentId && !$isLayer) {
                continue;
            }

            // 限制分类显示深度
            if (!is_null($limitLevel) && $level > $limitLevel) {
                break;
            }

            $value['level']= $level;
            $tree[] = $value;

            // 需要返回本级分类时保留列表数据,否则引起树的重复,并且需要自增层级
            if (true == $isLayer) {
                $isLayer = false;
                $level++;
                continue;
            }

            // 删除已使用数据,减少查询次数
            unset($list[$key]);
            if ($value['children_total'] > 0) {
                $this->setArticleCatTree($articleCatId, $list, $limitLevel, $isLayer, $level + 1,$tree);
            }
        }

        return $tree;
    }
    /**
     * 编辑一个文章分类
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setArticleCatItem($data)
    {
        // 父分类不能设置成本身或本身的子分类
        if (isset($data['parent_id'])) {
            if ($data['parent_id'] == $data['article_cat_id']) {
                return $this->setError('上级分类不能设为自身');
            }

            if (($result = $this->getArticleCatList($data['article_cat_id'])) === false) {
                return false;
            }

            foreach ($result as $value) {
                if ($data['parent_id'] == $value['article_cat_id']) {
                    return $this->setError('上级分类不能设为自身的子分类');
                }
            }
        }
        $result = self::find($data['article_cat_id']);
        $result->parent_id=isset($data['parent_id']) ? $data['parent_id'] : $result->parent_id;
        $result->cat_name=isset($data['cat_name']) ? $data['cat_name'] : $result->cat_name;
        $result->cat_type=isset($data['cat_type']) ? $data['cat_type'] : $result->cat_type;
        $result->keywords=isset($data['keywords']) ? $data['keywords'] : $result->keywords;
        $result->description=isset($data['description']) ? $data['description'] : $result->description;
        $result->sort=isset($data['sort']) ? $data['sort'] : $result->sort;
        $result->is_navi=isset($data['is_navi']) ? $data['is_navi'] : $result->is_navi;
        if ($result->save()) {
            return $result->toArray();
        }else{
            return $this->setError('操作失败');
        }
    }

    /**
     * 添加一个文章分类
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addArticleCatItem($data)
    {
        // 避免无关字段
        unset($data['article_cat_id']);
        $result = new ArticleCat();
        $result->parent_id=isset($data['parent_id']) ? $data['parent_id'] : '';
        $result->cat_name=isset($data['cat_name']) ? $data['cat_name'] : '';
        $result->cat_type=isset($data['cat_type']) ? $data['cat_type'] : '';
        $result->keywords=isset($data['keywords']) ? $data['keywords'] : '';
        $result->description=isset($data['description']) ? $data['description'] :'';
        $result->sort=isset($data['sort']) ? $data['sort'] : '';
        $result->is_navi=isset($data['is_navi']) ? $data['is_navi'] : '';
        if ($result->save()) {
            return $result->toArray();
        }else{
            return $this->setError('操作失败');
        }
    }

    /**
     * 批量删除文章分类(支持检测是否存在子节点与关联文章)
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delArticleCatList($data)
    {
        $idList = $result = [];
        isset($data['not_empty']) ?: $data['not_empty'] = 0;
        if (!empty($data['not_empty'])) {
            $idList = $data['article_cat_id'];
            if (($result = self::getArticleCatList()) === false) {
                return false;
            }
        }
        // 过滤不需要的分类
        $catFilter = [];
        foreach ($result as $value) {
            if ($value['children_total'] > 0 || $value['aricle_total'] > 0) {
                $catFilter[$value['article_cat_id']] = $value;
            }
        }
        foreach ($idList as $catId) {
            if (array_key_exists($catId, $catFilter)) {
                if ($catFilter[$catId]['children_total'] > 0) {
                    return $this->setError('Id:' . $catId . ' 分类名称"' . $catFilter[$catId]['cat_name'] . '"存在子分类');
                }

                if ($catFilter[$catId]['aricle_total'] > 0) {
                    return $this->setError('Id:' . $catId . ' 分类名称"' . $catFilter[$catId]['cat_name'] . '"存在关联内容');
                }
            }
        }

        self::destroy($data['article_cat_id']);
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
    function objectToArray($obj) {
        //首先判断是否是对象
        $arr = is_object($obj) ? get_object_vars($obj) : $obj;
        if(is_object($arr)) {
            //这里相当于递归了一下，如果子元素还是对象的话继续向下转换
            return array_map(__FUNCTION__, $arr);
        }else {
            return $arr;
        }
    }
    public function getList($data){
        return array_map('get_object_vars', $data);
    }
}