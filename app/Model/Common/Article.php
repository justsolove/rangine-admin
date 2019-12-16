<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
use W7\App\Model\Common\ArticleCat;

class Article extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'article';
    // 主键设置
    protected $primaryKey  = 'article_id';

    protected $fillable = ['article_cat_id','title','image','content','source','source_url','keywords','description','url','target','is_top','status'];

    public $timestamps    = false;

    public $error = '';

    /**
     * 获取文章列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getArticleList($data)
    {
        // 获取分类Id,包括子分类
        $catIdList = [];
        if (isset($data['article_cat_id'])) {
            $catIdList[] = (int)$data['article_cat_id'];
            $articleCat = ArticleCat::getArticleCatList($data['article_cat_id']);

            foreach ($articleCat as $value) {
                $catIdList[] = $value['article_cat_id'];
            }
        }

        // 搜索条件
        isset($data['status']) ?$map[] = ['status','=', $data['status']]: $map[] = ['status','=', 1];
        empty($catIdList) ?: $map[] = ['article_cat_id','in', $catIdList];
        empty($data['title']) ?: $map[] = ['title','like', '%' . $data['title'] . '%'];

        // 后台管理搜索

        unset($map['article.status']);
        is_empty_parm($data['status']) ?: $map[] = ['status','=', $data['status']];
        is_empty_parm($data['is_top']) ?: $map[] = ['is_top','=', $data['is_top']];
        empty($data['keywords']) ?: $map[] = ['keywords','like', '%' . $data['keywords'] . '%'];


        $totalResult = $this->with('getArticleCat')->where($map)->count();
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
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'article_id';

        $result = Article::with('getArticleCat')
            ->where($map)
            ->orderBy($orderField,$orderType)
            ->offset($startNum)
            ->limit($pageSize)
            ->get()
            ->map(function($item) {
                if($item->create_time){
                    $item->create_time = date("Y-m-d H:i:s",$item->create_time);
                }else{
                    $item->create_time ='-';
                }
                return $item;
            });
        $result = $result->toArray();
        if (false !== $result) {
            foreach ($result as $key=>$value){
                if(!$value['get_article_cat']){
                    $result[$key]['get_article_cat']['cat_name'] = '';
                    $result[$key]['get_article_cat']['cat_type'] = 0;
                }

            }
            return ['items' => $result, 'total_result' => $totalResult];
        }
        return false;
    }

    /**
     * 获取一篇文章
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getArticleItem($data)
    {
        $map[] = ['article_id','=', $data['article_id']];
        $map[] = ['status','=', 1];

        $result = idb()->table('article')
            ->where($map)
            ->get()
           ->first();

        return is_null($result) ? null : $result;

    }
    /**
     * 批量设置文章置顶
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setArticleTop($data)
    {
        $rs = idb()->table('article')
            ->whereIn('article_id', $data['article_id'])
            ->update(['is_top' => $data['is_top']]);
        if($rs){
            return true;
        }else{
            return false;
        }

        return false;
    }

    /**
     * 批量删除文章
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delArticleList($data)
    {

        self::destroy($data['article_id']);

        return true;
    }
    /**
     * 批量设置文章是否显示
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setArticleStatus($data)
    {
        $rs = idb()->table('article')
            ->whereIn('article_id', $data['article_id'])
            ->update(['status' => $data['status']]);
        if($rs){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 编辑一篇文章
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setArticleItem($data)
    {
        $article = self::find($data['article_id']);
        $article->fill($data);
        $article->update_time= time();
        if($article->save()){
            return $article->toArray();
        }
        return false;
    }

    /**
     * 添加一篇文章
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addArticleItem($data)
    {

        // 避免无关字段
        unset($data['article_id']);
        $article = Article::create($data);
        $article ->create_time = time();
        $article ->update_time = time();
        if ($article->save()) {
            return $article->toArray();
        }

        return false;
    }
    /**
     * hasOne cs_article_cat
     * @access public
     * @return mixed
     */
    public function getArticleCat()
    {
        return $this
            ->belongsTo('W7\App\Model\Common\ArticleCat', 'article_cat_id', 'article_cat_id')->select(['article_cat_id','cat_name','cat_type']);
    }
}